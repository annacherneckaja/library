<?php

use vendor\core\Router;

/**
 * add routes from specific ones, the coincidence of which will be processed first to the default ones
 */
if ($query != null) {
    Router::add('^admin.*$', [
        'controller' => 'Admin',
        'action' => array_key_first($query) == 'page' ? 'index' : array_key_first($query),
        'alias' => $query[array_key_first($query)]]);
}

Router::add('^admin/?$', [
    'controller' => 'Admin',
    'action' => 'index']);

Router::add('^admin/(?P<action>[a-z-]+)$', [
    'controller' => 'Admin']);

Router::add('^book/(?P<alias>[0-9]+)$', [
    'controller' => 'Main',
    'action' => 'view']);

//defaults routs
Router::add('^$', [
    'controller' => 'Main',
    'action' => 'index']);

Router::add('^(?P<controller>[a-z-]+)/?(?P<action>[a-z-]+)?$', []);
