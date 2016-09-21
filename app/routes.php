<?php

use App\Controller\HomeController;
use App\Controller\NoteController;

// Routes

$app->get('/', HomeController::class)
    ->setName('homepage');

$app->get('/notes', NoteController::class.':getAllNotes');
$app->get('/notes/{id:[0-9]+}', NoteController::class.':getNote');
$app->post('/notes', NoteController::class.':addNote');
$app->delete('/notes/{id:[0-9]+}', NoteController::class.':deleteNote');
