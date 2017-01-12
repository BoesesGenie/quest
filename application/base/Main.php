<?php

namespace Application\Base;

use Application\View\Console;
use Application\Base\RequestRegistry;

class Main
{
    private function __construct()
    {
    }
    
    public static function run()
    {
        $instance = new Main();
        $instance->handleRequest();
    }
    
    public function handleRequest()
    {
        try {
            if ($_SERVER['argc'] < 2) {
                throw new \Exception('Wrong request.');
            }
            
            $options = getopt('c:a:');
            if (!isset($options['c'])) {
                throw new \Exception('Controller name reqired.');
            }
            
            if (isset($options['a'])) {
                $actionName = $options['a'] . 'Action';
            } else {
                $actionName = 'indexAction';
            }
            
            $controllerClass = '\\Application\\Controller\\'
                . ucfirst($options['c']) . 'Controller';
            
            $registry = RequestRegistry::instance();
            $registry->setParam(RequestRegistry::ACTION_NAME, $actionName);
            $view = new Console();
            $controller = new $controllerClass($view);
            $controller->execute();
        } catch (\Exception $e) {
            echo 'Error occurred: '
                . $e->getMessage() . "\n" . $e->getTraceAsString() . "\n";
        }
    }
}