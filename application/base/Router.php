<?php

namespace Application\Base;

/**
 * Класс Router - выбор нужного класса Controller и действия контроллера по имени маршрута.
 * Можно было бы использовать getopt(), но формат запроса, предложенный в ТЗ не позволяет.
 *
 * @author Константин Харламов <k.kharlamow@gmail.com>
 * @package Application\Base
 */
class Router
{
    /**
     * Возвращает массив с именем класса контроллера и действием контроллера, например:
     * [
     *     'controller' => \Application\Controller\StatisticController::class,
     *     'action'     => 'indexAction',
     * ]
     *
     * @param string $routeName Имя маршрута
     * @return array
     * @throws \Exception
     */
    public static function getRoute($routeName)
    {
        $routes = self::routes();
        if (!isset($routes[$routeName])) {
            throw new \Exception('Route "' . $routeName . '" not defined.');
        }

        return $routes[$routeName];
    }

    /**
     * Список допустимых маршрутов
     *
     * @return array
     */
    private static function routes()
    {
        return array(
            'statistic' => array(
                'controller' => \Application\Controller\StatisticController::class,
                'action'     => 'indexAction',
            ),
        );
    }
}