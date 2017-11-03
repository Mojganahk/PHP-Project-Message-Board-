<?php

// fake $app, $log so that Netbeans can provide suggestions while typing code
if (false) {
    $app = new \Slim\Slim();
    $log = new Logger('main');
}

// URL/event handlers go here
$app->get('/admin/articles/list', function() use ($app) {
    echo "This is Moj";
});
