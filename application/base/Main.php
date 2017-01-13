<?php

namespace Application\Base;

use Application\View\Console;
use Application\Controller\StatisticController;

/**
 * Класс Main - единая точка входа
 *
 * @author Константин Харламов <k.kharlamow@gmail.com>
 * @package Application\Base
 */
class Main
{
    /**
     * @var array Допустимые опции пользовательского запроса
     */
    private $availableOptions = [
        StatisticController::OPT_WITH_DOCS,
        StatisticController::OPT_WITHOUT_DOCS,
    ];

    /**
     * Main constructor.
     */
    private function __construct()
    {
    }

    /**
     * Запуск приложения
     */
    public static function run()
    {
        $instance = new Main();
        $instance->handleRequest();
    }

    /**
     * Обработка запроса
     */
    public function handleRequest()
    {
        try {
            if ($_SERVER['argc'] < 2) {
                throw new \Exception('Wrong request.');
            }

            $route = Router::getRoute($_SERVER['argv'][1]);
            $controllerClass = $route['controller'];
            $registry = RequestRegistry::instance();
            $registry->setParam(RequestRegistry::ACTION_NAME, $route['action']);
            if ($_SERVER['argc'] > 2) {
                $requestOptions = array_slice($_SERVER['argv'], 2);
                $options = array();
                foreach ($requestOptions as $option) {
                    if (!in_array($option, $this->availableOptions)) {
                        throw new \Exception('Option "' . $option . '" not allowed.');
                    }

                    $options[$option] = true;
                }

                $registry->setParam(RequestRegistry::OPTIONS, $options);
            }

            $view = new Console();
            $controller = new $controllerClass($view);
            $controller->execute();
        } catch (\Exception $e) {
            echo 'Error occurred: '
                . $e->getMessage() . "\n" . $e->getTraceAsString() . "\n";
        }
    }
}