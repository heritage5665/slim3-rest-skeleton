<?php

// Routes

$app->get('/', App\Action\HomeAction::class.':dispatch')
    ->setName('homepage');

$app->get('/notes', App\Action\NotesAction::class.':getAllNotes')
    ->setName('homepage');

$app->get('/notes/{id:[0-9]+}', App\Action\NotesAction::class.':getNote')
    ->setName('homepage');

$app->post('/notes', App\Action\NotesAction::class.':addNote')
    ->setName('homepage');

$app->delete('/notes/{id:[0-9]+}', App\Action\NotesAction::class.':deleteNote')
    ->setName('homepage');
