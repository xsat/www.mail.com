<?php

namespace Common;

class Application extends \Phalcon\Mvc\Application
{
    public function __construct()
    {
        $this->setServices();
    }

    private function setServices()
    {
        $loader = new \Phalcon\Loader();
        $loader->registerNamespaces(array(
            'Common' => __DIR__ . '/../components/',
            'Common\Controllers' => __DIR__ . '/../controllers/',
            'Common\Models' => __DIR__ . '/../models/',
        ));
        $loader->register();

        $config = new \Common\Config();
        $di = new \Phalcon\DI\FactoryDefault();
        $di->set('router', new \Common\Router());
        $di->set('url', new \Phalcon\Mvc\Url());
        $di->set('db', new \Phalcon\Db\Adapter\Pdo\Mysql(array(
            "host" => $config->database->host,
            "username" => $config->database->username,
            "password" => $config->database->password,
            "dbname" => $config->database->name
        )));
        $di->set('session', function() {
            $session = new \Phalcon\Session\Adapter\Files();
            $session->start();
            return $session;
        });
        $di->set('modelsMetadata', new \Phalcon\Mvc\Model\Metadata\Files(array(
            'metaDataDir' => __DIR__  . '/../cache/models/'
        )));

        $this->setDI($di);

        $this->registerModules([
            'frontend' => [
                'className' => 'Frontend\Module',
                'path' => '../apps/frontend/components/Module.php'
            ],
            'backend' => [
                'className' => 'Backend\Module',
                'path' => '../apps/backend/components/Module.php'
            ],
        ]);
    }

    public function getCompressedContent()
    {
        $search = ['/\>[^\S ]+/s', '/[^\S ]+\</s', '/(\s)+/s', '/>(\s)+</', '/\n/', '/\r/', '/\t/'];
        $replace = ['>', '<', '\\1', '><', '', '', ''];

        return preg_replace($search, $replace, $this->handle()->getContent());
    }
}