<?php

use Slim\Factory\AppFactory;
use DI\Container;
use App\ArticleController;
use App\UserController;
use App\CommentController;

require __DIR__ . '/../vendor/autoload.php';

session_start();

$container = new Container();
$container->set('renderer', function () {
    return new \Slim\Views\PhpRenderer(__DIR__ . '/../templates');
});

$app = AppFactory::createFromContainer($container);
$app->addErrorMiddleware(true, true, true);
//articles
$app->get('/', ArticleController::class . ':index');
$app->get('/articles/create', ArticleController::class . ':create');
$app->post('/articles/create', ArticleController::class . ':store');
$app->get('/articles/{id}', ArticleController::class . ':show');
//register
$app->get('/register', UserController::class . ':create');
$app->post('/register', UserController::class . ':store');
//auth
$app->get('/login', UserController::class . ':login');
$app->post('/auth', UserController::class . ':auth');
$app->get('/logout', UserController::class . ':logout');
//comment
$app->post('/comment', CommentController::class . ':create');

$app->run();