<?php

require_once __DIR__ .'/../Autoloader.php';

use ElvenSpellmaker\Глаза\View;
use ElvenSpellmaker\Глаза\ViewManager;

ViewManager::addViewPath( __DIR__ );

$view = new View( 'ViewTestHtml' );

$view->set( 'testVar', 'I am a test' );
$view->set( 'testView', new View( 'ViewInViewTest' ) );
$view->set( 'testEscape', '<b>Not Bold</b>' );
$view->set( 'testNoEscape', '<b>Bold</b>', false );

echo ( file_get_contents(__DIR__ .'/expectedOutput.test') === (string)$view ) ? "\e[0;32mPASS\e[0m\n" : "\e[0;31mFAIL\e[0m\n";