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



//eventhandlers:
$app->get('/', function() use ($app) {
    echo "jjjjjjjjjjjjjjjjjj";
});

//index
$app->get('/index', function() use ($app) {
    $app->render('index.html.twig');
});

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

$app->get('/session', function() {
    print_r($_SESSION);
});



require_once 'admin.php';


$app->run();
