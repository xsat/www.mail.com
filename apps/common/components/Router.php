<?php

namespace Common;

class Router extends \Phalcon\Mvc\Router
{
    public function __construct()
    {
        parent::__construct(false);

        $this->add('/admin', [
            'module' => 'backend',
            'controller' => 'index',
            'action' => 'index'
        ]);
        $this->add('/index', [
            'module' => 'frontend',
            'controller' => 'index',
            'action' => 'index'
        ]);
        $this->add('/', [
            'module' => 'frontend',
            'controller' => 'index',
            'action' => 'index'
        ]);
    }
}