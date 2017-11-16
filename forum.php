<?php

//------------------------ log info------------------------------
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

session_start();

require_once 'vendor/autoload.php';

// lucas
//-----------------------MEEKRO.com-----------------------------
DB::$dbName = 'cp4809_forum';
DB::$user = 'cp4809_forum';
DB::$encoding = 'utf8';
DB::$password = '~F{Vssu~9IBN';

//////////////////////////////////////////~F{Vssu~9IBN


DB::$error_handler = 'sql_error_handler';
DB::$nonsql_error_handler = 'nonsql_error_handler';

function sql_error_handler($params) {
    global $app, $log;
    $log->err("SQL Error: " . $params['error']);
    $log->err(" in query: " . $params['query']);
    http_response_code(500);
    $app->render('error_internal.html.twig');
    die;
}

function nonsql_error_handler($params) {
    global $app, $log;
    $log->err("SQL Error: " . $params['error']);
    http_response_code(500);
    $app->render('error_internal.html.twig');
    die;
}

//------------------------------------------------
// Slim creation and setup
$app = new \Slim\Slim(array(
    'view' => new \Slim\Views\Twig()
        ));

$view = $app->view();
$view->parserOptions = array(
    'debug' => true,
    'cache' => dirname(__FILE__) . '/cache'
);
$view->setTemplatesDirectory(dirname(__FILE__) . '/templates');

// create a log channel
$log = new Logger('main');
$log->pushHandler(new StreamHandler('logs/everything.log', Logger::DEBUG));
$log->pushHandler(new StreamHandler('logs/errors.log', Logger::ERROR));


if (!isset($_SESSION['user'])) {
    $_SESSION['user'] = array();
}

$twig = $app->view()->getEnvironment();
$twig->addGlobal('userSession', $_SESSION['user']);


//eventhandlers:


//index


//$app->get('/session', function() {
//    print_r($_SESSION);
//});


//--------------------------------------Post starts--------------------------------------

//INDEX 
//load to main page when nothing entered
$app->get('/', function($term = null) use ($app) {
    if (!isset($_GET['search'])) {
        $postList = DB::query("SELECT name, title, body, datePosted, posts.id as id, users.id as userId FROM posts, users WHERE posts.authorId=users.id");
        $app->render('index.html.twig', array('list' => $postList));
    } else {
        $term = $app->request()->get('search');
        $postList = DB::query("SELECT name, title, body, datePosted, posts.id as id, users.id as userId FROM posts, users WHERE posts.authorId=users.id AND title LIKE '%$term%' OR body LIKE '%$term%' AND posts.authorId=users.id");
        $app->render('index.html.twig', array('list' => $postList));
    }
});
//
//
//
$app->get('/user/:id', function($id = -1) use($app) {
    if (!$_SESSION['user']) {
        $app->render('access_denied.html.twig');
        return;
    }
    if ($id == -1) {
        $app->render('not_found.html.twig');
        return;
    }
    if ($id != -1) {
//to display list with user's name
        $postList = DB::query("SELECT name, title, body, datePosted, categoryName FROM posts, users, categories WHERE posts.authorId=users.id AND posts.authorId=%i", $id);
//to display the post without the user's name
        $app->render('index.html.twig', array('list' => $postList));
    }
})->conditions(array(
    'id' => '\d+'
));
// add post first show
$app->get('/posts/:op(/:id)', function($op, $id = -1) use ($app) {
    if (!$_SESSION['user']) {
        $app->render('/access_denied.html.twig');
        return;
    }
    if (($op == 'add' && $id != -1) || ($op == 'edit' && $id == -1)) {
        echo "INVALID REQUEST"; // FIXME on Monday - display standard 404 from slim
        return;
    }
    $catList = DB::query("SELECT id, categoryName FROM categories");
    if (!$catList) {
        // internal error display!
        echo "NOT FOUND";  // FIXME on Monday - display standard 404 from slim
        return;
    }
    print_r($catList);
    $app->render('/post_addedit.html.twig', array('catList' => $catList, 'isEditing' => ($id != -1)));
})->conditions(array(
    'op' => '(edit|add)',
    'id' => '\d+'
));

// ADD SUBMISSION
$app->post('/posts/:op(/:id)', function($op, $id = -1) use ($app) {
    //if user isnt logged in, deny access
    if (!$_SESSION['user']) {
        $app->render('/access_denied.html.twig');
        return;
    }
    if (($op == 'add' && $id != -1) || ($op == 'edit' && $id == -1)) {
        echo "INVALID REQUEST"; // FIXME on Monday - display standard 404 from slim
        return;
    }
//extract submission
    $authorId = $_SESSION['user']['id'];
    $catId = $app->request()->post('catId');
    $title = $app->request()->post('title');
    $body = $app->request()->post('body');
//
    $values = array('catId' => $catId, 'title' => $title, 'body' => $body);
    $errorList = array();
    
// title check
    if (strlen($title) < 1 || strlen($title) > 100) {
        array_push($errorList, "Title must be between 1 and 100 characters.");
        $values['title'] = '';
    }
//body check
    if (strlen($body) < 1 || strlen($body) > 2000) {
        array_push($errorList, "Body must be between 1 and 2000 characters.");
        $values['body'] = '';
    }
//
    if ($errorList) { // 3. failed submission
        $app->render('/post_addedit.html.twig', array(
            'errorList' => $errorList,
            'isEditing' => ($id != -1),
            'v' => $values));
    } else { //2. successful submission
//INSERT STATEMENT
        DB::insert('posts', array('authorId' => $authorId, 'catId' => $catId, 'title' => $title, 'body' => $body));
        $app->render('/post_addedit_success.html.twig');
    }
})->conditions(array(
    'op' => '(edit|add)',
    'id' => '\d+'
));
//delete
$app->get('/posts/delete/:id', function($id) use ($app) {
    if (!$_SESSION['user']) {
        $app->render('/access_denied.html.twig');
        return;
    }
    $post = DB::queryFirstRow('SELECT * FROM posts WHERE id=%d', $id);
    if (!$post) {
        $app->render('/not_found.html.twig');
        return;
    }
    $app->render('/post_delete.html.twig', array('p' => $post));
});
$app->post('/posts/delete/:id', function($id) use ($app) {
    if (!$_SESSION['user']) {
        $app->render('/access_denied.html.twig');
        return;
    }
    $confirmed = $app->request()->post('confirmed');
    if ($confirmed != 'true') {
        $app->render('/not_found.html.twig');
        return;
    }
    DB::delete('posts', "id=%i", $id);
    if (DB::affectedRows() == 0) {
        $app->render('/not_found.html.twig');
    } else {
        $app->render('/post_delete_success.html.twig');
    }
});
$app->get('/posts/delete/:id', function($id) use ($app) {
    if (!$_SESSION['user']) {
        $app->render('/access_denied.html.twig');
        return;
    }
    $post = DB::queryFirstRow('SELECT * FROM posts WHERE id=%d', $id);
    if (!$post) {
        $app->render('/not_found.html.twig');
        return;
    }
    $app->render('/post_delete.html.twig', array('p' => $post));
});
$app->post('/posts/delete/:id', function($id) use ($app) {
    if (!$_SESSION['user']) {
        $app->render('/access_denied.html.twig');
        return;
    }
    $confirmed = $app->request()->post('confirmed');
    if ($confirmed != 'true') {
        $app->render('/not_found.html.twig');
        return;
    }
    DB::delete('posts', "id=%i", $id);
    if (DB::affectedRows() == 0) {
        $app->render('/not_found.html.twig');
    } else {
        $app->render('/post_delete_success.html.twig');
    }
});



//-------------------------------------------------POST PAGINATION-----------------------------------------------------------------

// URL/event handlers go here
$app->get('/posts(/:page)', function($page = 1) use ($app) {
    $perPage = 4;
    $totalCount = DB::queryFirstField("SELECT COUNT(*) AS count FROM posts");
    $maxPages = ($totalCount + $perPage - 1) / $perPage;
    if ($page > $maxPages) {
        http_response_code(404);
        $app->render('not_found.html.twig');
        return;
    }
    $skip = ($page - 1) * $perPage;
    $postList = DB::query("SELECT * FROM posts ORDER BY id LIMIT %d,%d", $skip, $perPage);
    $app->render('newposts.html.twig', array(
        "postsList" => $postList,
        "maxPages" => $maxPages
    ));
})->conditions(array(
    'page' => '\d+'
));
// posts pagination usinx AJAX - main page
$app->get('/newposts(/:page)', function($page = 1) use ($app) {
    $perPage = 4;
    $totalCount = DB::queryFirstField("SELECT COUNT(*) AS count FROM posts");
    $maxPages = ($totalCount + $perPage - 1) / $perPage;
    if ($page > $maxPages) {
        http_response_code(404);
        $app->render('not_found.html.twig');
        return;
    }
    $skip = ($page - 1) * $perPage;
    $postList = DB::query("SELECT * FROM posts ORDER BY id LIMIT %d,%d", $skip, $perPage);
    $app->render('newposts.html.twig', array(
        "postList" => $postList,
        "maxPages" => $maxPages,
        "currentPage" => $page
    ));
});
// posts pagination usinx AJAX - just the table of post
$app->get('/ajax/newposts(/:page)', function($page = 1) use ($app) {
    $perPage = 4;
    $totalCount = DB::queryFirstField("SELECT COUNT(*) AS count FROM posts");
    $maxPages = ($totalCount + $perPage - 1) / $perPage;
    if ($page > $maxPages) {
        http_response_code(404);
        $app->render('not_found.html.twig');
        return;
    }
    $skip = ($page - 1) * $perPage;
    $postList = DB::query("SELECT * FROM posts ORDER BY id LIMIT %d,%d", $skip, $perPage);
    $app->render('ajaxnewposts.html.twig', array(
        "postList" => $postList,
    ));
});
//-------------------------------------------------POST PAGINATION-----------------------------------------------------------------

//-------------------------------------------------- CATEGORY LIST STARTS ---------------------------------------------------------
$app->get('/categories', function() use ($app) {
    if (!$_SESSION['user']) {
        $app->render('access_denied.html.twig');
        return;
    }
    //
    $categoriesList = DB::query("SELECT categoryName, description, imagePath FROM categories");
    $app->render('/categories.html.twig', array('list' => $categoriesList));
});
//-------------------------------------------------- CATEGORY LIST ENDS ---------------------------------------------------------

//-------------------------------------------------- POST LIST STARTS ---------------------------------------------------------
$app->get('/posts', function() use ($app) {
    if (!$_SESSION['user']) {
        $app->render('access_denied.html.twig');
        return;
    }
    //
    $postList = DB::query("SELECT title, body FROM posts");
    $app->render('/newposts.html.twig', array('list' => $postList));
});
//-------------------------------------------------- POST LIST ENDS ---------------------------------------------------------




require_once 'account.php';



require_once 'admin.php';


$app->run();
