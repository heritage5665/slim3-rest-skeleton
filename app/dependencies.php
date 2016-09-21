<?php

use Illuminate\Database\Capsule\Manager as Capsule;
use App\Factory\NoteFactory;
use App\Repository\NoteRepository;
use App\Controller\HomeController;
use App\Controller\NoteController;

$container = $app->getContainer();

// monolog
$container['logger'] = function ($c) {
    $settings = $c->get('settings');
    $logger = new Monolog\Logger($settings['logger']['name']);
    $logger->pushProcessor(new Monolog\Processor\UidProcessor());
    $logger->pushHandler(new Monolog\Handler\StreamHandler($settings['logger']['path'], Monolog\Logger::DEBUG));

    return $logger;
};

// Database
$container['db'] = function ($c) {
    $capsule = new Capsule();
    $capsule->addConnection($c->get('settings')['db']);

    //$capsule->setAsGlobal();
    $capsule->bootEloquent();

    return $capsule;
};

$container[App\Factory\NoteFactory::class] = function ($c) {
    return new NoteFactory($c->get('logger'), $c->get('db'));
};

$container[App\Repository\NoteRepository::class] = function ($c) {
    return new NoteRepository($c->get('logger'), $c->get('db'));
};

$container[App\Controller\HomeController::class] = function ($c) {
    return new HomeController($c->get('logger'));
};

$container[App\Controller\NoteController::class] = function ($c) {
    return new NoteController($c->get('logger'), $c->get(App\Factory\NoteFactory::class), $c->get(App\Repository\NoteRepository::class));
};
