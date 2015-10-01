<?php

use App\Action\HomeAction;
use App\Action\NotesAction;

// Routes

$app->get('/', HomeAction::class.':dispatch')
    ->setName('homepage');

$app->get('/notes', NotesAction::class.':getAllNotes');

$app->get('/notes/{id:[0-9]+}', NotesAction::class.':getNote');

$app->post('/notes', NotesAction::class.':addNote');

$app->delete('/notes/{id:[0-9]+}', NotesAction::class.':deleteNote');
