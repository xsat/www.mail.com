<?php

namespace Common;

class Module
{
    protected $dir;
    protected $prefix;
    protected $di;

    public function __construct()
    {
        $this->dir = __DIR__;
        $this->prefix = 'Common';
    }

    public function registerAutoloaders()
    {
        $loader = new \Phalcon\Loader();
        $loader->registerNamespaces([
            $this->prefix . '\Controllers' => $this->dir . '/../controllers/',
            $this->prefix . '\Models' => $this->dir . '/../models/',
        ]);
        $loader->register();
    }

    public function registerServices(\Phalcon\DiInterface $di)
    {
        $this->di = $di;
        $this->di->set('dispatcher', function() {
            $dispatcher = new \Phalcon\Mvc\Dispatcher();
            $dispatcher->setDefaultNamespace($this->prefix .  '\Controllers');
            return $dispatcher;
        });
        $this->di->set('view', $this->setView(), true);
        $this->di->set('modelsMetadata', $this->setModelsMetadata());
    }

    protected function setView()
    {
        $view = new \Phalcon\Mvc\View();
        $view->setViewsDir($this->dir . '/../views/');
        $view->setLayoutsDir('layouts/');
        $view->setLayout('main');
        $view->registerEngines([
            '.volt' => $this->setVolt($view),
            '.phtml' => 'Phalcon\Mvc\View\Engine\Php',
        ]);

        return $view;
    }

    protected function setVolt(\Phalcon\Mvc\View $view)
    {
        $volt = new \Phalcon\Mvc\View\Engine\Volt($view, $this->di);
        $volt->setOptions([
            'compiledPath' => $this->dir . '/../cache/views/',
            'compiledSeparator' => '_',
        ]);

        return $volt;
    }

    protected function setModelsMetadata()
    {
        return new \Phalcon\Mvc\Model\Metadata\Files(array(
            'metaDataDir' => $this->dir . '/../cache/models/'
        ));
    }
}
