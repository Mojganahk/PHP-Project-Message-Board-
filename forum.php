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
$app->get('/', function() use ($app) {
    echo "jjjjjjjjjjjjjjjjjjaaaaa";
});

//index
$app->get('/index', function() use ($app) {
    $app->render('index.html.twig');
});


$app->get('/session', function() {
    print_r($_SESSION);
});

//-------------------------------login Starts------------------------------------------
$app->get('/login', function() use ($app) {
    $app->render('login.html.twig');
});

$app->post('/login', function() use ($app) {
    $email = $app->request()->post('email');
    $pass = $app->request()->post('pass');
    $row = DB::queryFirstRow("SELECT * FROM users WHERE email= %s", $email);
    $error = false;
    if (!$row) {
        $error = true; // user not found
    } else {
        if ($row['password'] != $pass) {
            $error = true; // password invalid
        }
    }
    if ($error) {
        $app->render('login.html.twig', array('error' => true));
    } else {
        unset($row['password']);
        $_SESSION['user'] = $row;
        $app->render('login_success.html.twig');
    }
});
//-------------------------------login Ends------------------------------------------
//-------------------------------logout starts------------------------------------------
$app->get('/logout', function() use ($app) {
    $_SESSION['user'] = array();
    $app->render('logout.html.twig', array('userSession' => $_SESSION['user']));
});
//-------------------------------logout Ends------------------------------------------
//------------------------------------Register starts-----------------------------------------
$app->get('/register', function() use ($app) {
    $app->render('register.html.twig');
});
$app->post('/register', function() use ($app) {
    $name = $app->request()->post('name');
    $email = $app->request()->post('email');
    $pass1 = $app->request()->post('pass1');
    $pass2 = $app->request()->post('pass2');
    //
    $values = array('name' => $name, 'email' => $email);
    $errorList = array();
    //
    if (strlen($name) < 2 || strlen($name) > 50) {
        $values['name'] = '';
        array_push($errorList, "Name must be between 2 and 50 characters long");
    }
    if (filter_var($email, FILTER_VALIDATE_EMAIL) == FALSE) {
        $values['email'] = '';
        array_push($errorList, "Email must look like a valid email");
    } else {
        $row = DB::queryFirstRow("SELECT * FROM users WHERE email=%s", $email);
        if ($row) {
            $values['email'] = '';
            array_push($errorList, "Email already in use");
        }
    }
    if ($pass1 != $pass2) {
        array_push($errorList, "Passwords don't match");
    } else { // TODO: do a better check for password quality (lower/upper/numbers/special)
        if (strlen($pass1) < 2 || strlen($pass1) > 50) {
            array_push($errorList, "Password must be between 2 and 50 characters long");
        }
    }
    //    image verification
    $avatar = array();
    if ($_FILES['avatar']['error'] != UPLOAD_ERR_NO_FILE) {
        print_r($_FILES);
        $avatar = $_FILES['avatar'];
        if ($avatar['error'] != 0) {
            array_push($errorList, "Error uploading file");
            $log->err("Error uploading file: " . print_r($avatar, true));
        } else {
            if (strstr($avatar['name'], '..')) {
                array_push($errorList, "Invalid file name");
                $log->warn("Uploaded file name with .. in it (possible attack): " . print_r($avatar, true));
            }
            // TODO: check if file already exists, check maximum size of the file, dimensions of the image etc.
            $info = getimagesize($avatar["tmp_name"]);
            if ($info == FALSE) {
                array_push($errorList, "File doesn't look like a valid image");
            } else {
                if ($info['mime'] == 'image/jpeg' || $info['mime'] == 'image/gif' || $info['mime'] == 'image/png') {
                    // image type is valid - all good
                } else {
                    array_push($errorList, "Image must be a JPG, GIF, or PNG only.");
                }
            }
        }
    } else { // no file uploaded        
        array_push($errorList, "Image is required when creating a new member");
    }
    //
    if ($errorList) { // 3. failed submission
        $app->render('register.html.twig', array(
            'errorList' => $errorList,
            'v' => $values));
    } else { // 2. successful submission
        if ($avatar) {
            $avatarPath = 'uploads/' . $avatar['name'];
            if (!move_uploaded_file($avatar['tmp_name'], $avatarPath)) {
                $log->err("Error moving uploaded file: " . print_r($avatar, true));
                $app->render('internal_error.html.twig');
                return;
                // import image
            }
            // TODO: if EDITING and new file is uploaded we should delete the old one in uploads
            $avatarPath = "/" . $avatarPath;
        }
        $passEnc = password_hash($pass1, PASSWORD_BCRYPT);
        DB::insert('users', array('name' => $name, 'email' => $email, 'password' => $passEnc, 'avatarPath' => $avatarPath));
        $app->render('register_success.html.twig');
    }
});


//----------------------------------register ends----------------------------------------------
//
//-------------------------------this Email registered alreardy------------------------------------------
$app->get('/isemailregistered/:email', function($email) use ($app) {
    $row = DB::queryFirstRow("SELECT * FROM users WHERE email=%s", $email);
    echo!$row ? "" : '<span style="background-color: red; font-weight: bold;">Email already taken</span>';
});
//-------------------------------email ends------------------------------------------
//
//-------------------------------login Starts------------------------------------------
$app->get('/login', function() use ($app) {
    $app->render('login.html.twig');
});

$app->post('/login', function() use ($app) {
    $email = $app->request()->post('email');
    $pass = $app->request()->post('pass');
    $row = DB::queryFirstRow("SELECT * FROM users WHERE email=%s", $email);
    $error = false;
    if (!$row) {
        $error = true; // user not found
    } else {
        if ($row['password'] != $pass) {
            $error = true; // password invalid
        }
    }
    if ($error) {
        $app->render('login.html.twig', array('error' => true));
    } else {
        unset($row['password']);
        $_SESSION['user'] = $row;
        $app->render('login_success.html.twig');
    }
});

//-------------------------------login Ends------------------------------------------
//-------------------------------logout starts------------------------------------------
$app->get('/logout', function() use ($app) {
    $_SESSION['user'] = array();
    $app->render('logout.html.twig');
});
//-------------------------------logout Ends------------------------------------------
//--------------------------------Admin - categories-------------------------------
$app->get('/admin/categories/list', function() use ($app) {
    if (!$_SESSION['user'] || $_SESSION['user']['role'] != 'admin') {
        $app->render('access_denied.html.twig');
        return;
    }
    //
    $categoriesList = DB::query("SELECT * FROM categories");
    $app->render('admin/categories_list.html.twig', array('list' => $categoriesList));
});
$app->get('/admin/categories/delete/:id', function($id) use ($app) {
    if (!$_SESSION['user'] || $_SESSION['user']['role'] != 'admin') {
        $app->render('access_denied.html.twig');
        return;
    }
    $categories = DB::queryFirstRow('SELECT * FROM categories WHERE id=%d', $id);
    if (!$categories) {
        $app->render('admin/not_found.html.twig');
        return;
    }
    $app->render('admin/categories_delete.html.twig', array('c' => $categories));
});
$app->post('/admin/categories/delete/:id', function($id) use ($app) {
    if (!$_SESSION['user'] || $_SESSION['user']['role'] != 'admin') {
        $app->render('access_denied.html.twig');
        return;
    }
    $confirmed = $app->request()->post('confirmed');
    if ($confirmed != 'true') {
        $app->render('admin/not_found.html.twig');
        return;
    }
    DB::delete('categories', "id=%i", $id);
    if (DB::affectedRows() == 0) {
        $app->render('admin/not_found.html.twig');
    } else {
        $app->render('admin/categories_delete_success.html.twig');
    }
});
$app->get('/admin/categories/:op(/:id)', function($op, $id = -1) use ($app) {
    if (!$_SESSION['user'] || $_SESSION['user']['role'] != 'admin') {
        $app->render('access_denied.html.twig');
        return;
    }
    if (($op == 'add' && $id != -1) || ($op == 'edit' && $id == -1)) {
        echo "INVALID REQUEST"; // FIXME on Monday - display standard 404 from slim
        return;
    }
    //
    if ($id != -1) {
        $values = DB::queryFirstRow('SELECT * FROM categories WHERE id=%i', $id);
        if (!$values) {
            echo "NOT FOUND";  // FIXME on Monday - display standard 404 from slim
            return;
        }
    } else { // nothing to load from database - adding
        $values = array();
    }
    $app->render('admin/categories_addedit.html.twig', array(
        'v' => $values,
        'isEditing' => ($id != -1)
    ));
})->conditions(array(
    'op' => '(edit|add)',
    'id' => '\d+'
));

$app->post('/admin/categories/:op(/:id)', function($op, $id = -1) use ($app, $log) {
    if (!$_SESSION['user'] || $_SESSION['user']['role'] != 'admin') {
        $app->render('access_denied.html.twig');
        return;
    }
    if (($op == 'add' && $id != -1) || ($op == 'edit' && $id == -1)) {
        echo "INVALID REQUEST"; // FIXME on Monday - display standard 404 from slim
        return;
    }
    //
    $categoryName = $app->request()->post('categoryName');
    $description = $app->request()->post('description');
    //
    $values = array('categoryName' => $categoryName, 'description' => $description);
    $errorList = array();
    //
    if (strlen($categoryName) < 2 || strlen($categoryName) > 20) {
        $values['categoryName'] = '';
        array_push($errorList, "categoryName must be between 2 and 20 characters long");
    }
    if (strlen($description) < 2 || strlen($description) > 100) {
        $values['description'] = '';
        array_push($errorList, "Description must be between 2 and 100 characters long");
    }

    $categoryImage = array();
    ///////////////////
    if ($_FILES['categoryImage']['error'] != UPLOAD_ERR_NO_FILE) {
        $categoryImage = $_FILES['categoryImage'];
        if ($categoryImage['error'] != 0) {
            array_push($errorList, "Error uploading file");
            $log->err("Error uploading file: " . print_r($categoryImage, true));
        } else {
            if (strstr($categoryImage['name'], '..')) {
                array_push($errorList, "Invalid file name");
                $log->warn("Uploaded file name with .. in it (possible attack): " . print_r($categoryImage, true));
            }
            // TODO: check if file already exists, check maximum size of the file, dimensions of the image etc.
            $info = getimagesize($categoryImage["tmp_name"]);
            if ($info == FALSE) {
                array_push($errorList, "File doesn't look like a valid image");
            } else {
                if ($info['mime'] == 'image/jpeg' || $info['mime'] == 'image/gif' || $info['mime'] == 'image/png') {
                    // image type is valid - all good
                } else {
                    array_push($errorList, "Image must be a JPG, GIF, or PNG only.");
                }
            }
        }
    } else { // no file uploaded
        if ($op == 'add') {
            array_push($errorList, "Image is required when creating new category");
        }
    }
    //
    if ($errorList) { // 3. failed submission
        $app->render('admin/categories_addedit.html.twig', array(
            'errorList' => $errorList,
            'isEditing' => ($id != -1),
            'v' => $values));
    } else { // 2. successful submission
        if ($categoryImage) {
            $imagePath = 'uploads/' . $categoryImage['name'];
            if (!move_uploaded_file($categoryImage['tmp_name'], $imagePath)) {
                $log->err("Error moving uploaded file: " . print_r($categoryImage, true));
                $app->render('internal_error.html.twig');
                return;
            }
            // TODO: if EDITING and new file is uploaded we should delete the old one in uploads
            $values['imagePath'] = "/" . $imagePath;
        }
        if ($id != -1) {
            DB::update('categories', $values, "id=%i", $id);
        } else {
            DB::insert('categories', $values);
        }
        $app->render('admin/categories_addedit_success.html.twig', array('isEditing' => ($id != -1)));
    }
})->conditions(array(
    'op' => '(edit|add)',
    'id' => '\d+'
));

//--------------------------------------admin ends--------------------------------------


//--------------------------------------Post starts--------------------------------------

//INDEX 
//load to main page when nothing entered
$app->get('/(:term)', function($term = null) use ($app) {
    if (!$_SESSION['user']) {
        $app->render('access_denied.html.twig');
        return;
    } 
    if(!isset($_GET['search'])){
    $postList = DB::query("SELECT name, title, body, datePosted, posts.id as id, users.id as userId FROM posts, users WHERE posts.authorId=users.id");
    $app->render('index.html.twig', array('list' => $postList));
    } else {
        $term = $app->request()->get('search');
         $postList = DB::query("SELECT name, title, body, datePosted, posts.id as id, users.id as userId FROM posts, users WHERE posts.authorId=users.id AND title LIKE '%$term%' OR body LIKE '%$term%' AND posts.authorId=users.id");
         $app->render('index.html.twig', array('list' => $postList));
    }
})->conditions(array(
    'term' => '\w'
));
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
$app->get('/addpost', function() use ($app, $log) {
    if (!$_SESSION['user']) {
        $app->render('access_denied.html.twig');
        return;
    }
    $RowCategory = DB::query("SELECT DISTINCT id,categoryName FROM categories");
    
    $app->render('post_addedit.html.twig', array('RowCategory' => $RowCategory));
});

// ADD SUBMISSION
$app->post('/addpost', function() use ($app, $log) {
    //if user isnt logged in, deny access
    if (!$_SESSION['user']) {
        $app->render('access_denied.html.twig');
        return;
    }
//extract submission
    $authorId = $_SESSION['user']['id'];


  


    $catId = $app->request()->post('catName');

    $title = $app->request()->post('title');
    $body = $app->request()->post('body');
//
    $values = array('categoryName' => $categoryName, 'title' => $title, 'body' => $body);
    $errorList = array();
    $query = DB::query("SELECT catId, categoryName FROM posts, categories");
    
    
    $id=$row["catId"];  
    $category = $row["categoryName"];
    
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
        $app->render('post_addedit.html.twig', array(
            'errorList' => $errorList,
            'v' => $values));
    } else { //2. successful submission
//INSERT STATEMENT

        
        DB::insert('posts', array('authorId' => $authorId, 'catId' => $catId, 'title' => $title, 'body' => $body));
        

        $app->render('post_addedit_success.html.twig');
    }
});



//-------------------------------------------------POST PAGINATION-----------------------------------------------------------------

// URL/event handlers go here
$app->get('/posts(/:page)', function($page = 1) use ($app) {
    $perPage = 4;
    $totalCount = DB::queryFirstField ("SELECT COUNT(*) AS count FROM posts");
    $maxPages = ($totalCount + $perPage - 1) / $perPage;
    if ($page > $maxPages) {
        http_response_code(404);
        $app->render('not_found.html.twig');
        return;
    }
    $skip = ($page - 1) * $perPage;
    $postList = DB::query("SELECT * FROM posts ORDER BY id LIMIT %d,%d", $skip, $perPage);
    $app->render('posts.html.twig', array(
        "postsList" => $postList,
        "maxPages" => $maxPages
        ));
});

// posts pagination usinx AJAX - main page
$app->get('/newposts(/:page)', function($page = 1) use ($app) {
    $perPage = 4;
    $totalCount = DB::queryFirstField ("SELECT COUNT(*) AS count FROM posts");
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
    $totalCount = DB::queryFirstField ("SELECT COUNT(*) AS count FROM posts");
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
