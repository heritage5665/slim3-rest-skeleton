<?php

use App\Factory\NoteFactory;
use App\Repository\NoteRepository;
use App\Action\HomeAction;
use App\Action\NotesAction;

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
$container['pdo'] = function ($c) {
    $settings = $c->get('settings')['pdo'];

    return new PDO($settings['dsn'], $settings['username'], $settings['password']);
};

$container[App\Factory\NoteFactory::class] = function ($c) {
    return new NoteFactory($c->get('logger'), $c->get('pdo'));
};

$container[App\Repository\NoteRepository::class] = function ($c) {
    return new NoteRepository($c->get('logger'), $c->get('pdo'));
};

$container[App\Action\HomeAction::class] = function ($c) {
    return new HomeAction($c->get('logger'));
};

$container[App\Action\NotesAction::class] = function ($c) {
    return new NotesAction($c->get('logger'), $c->get(App\Factory\NoteFactory::class), $c->get(App\Repository\NoteRepository::class));
};
