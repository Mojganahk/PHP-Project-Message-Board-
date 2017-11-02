<?php

//------------------------ log info------------------------------
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

session_start();

require_once 'vendor/autoload.php';



//-----------------------MEEKRO.com-----------------------------
DB::$dbName = 'slimshop';
DB::$user = 'slimshop';
DB::$encoding = 'utf8';
DB::$password = 'Is9TcSiAmZbOnKOR';


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

$app->get('/', function() use ($app) {
    $app->render('index.html.twig');
});

$app->get('/session', function() {
    print_r($_SESSION);
});


//eventhandlers:




$app->run();
