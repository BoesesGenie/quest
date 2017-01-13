<?php

namespace Application\Base;

/**
 * Класс RequestRegistry - класс-хранилище параметров пользовательского запроса
 *
 * @author Константин Харламов <k.kharlamow@gmail.com>
 * @package Application\Base
 */
class RequestRegistry
{
    const ACTION_NAME = 'actionName'; // Ключ имени действия контроллера
    const OPTIONS = 'options'; // Ключ опций пользовательского запроса

    /**
     * Различные параметры пользовательского запроса
     *
     * @var array
     */
    private $values = array();

    /**
     * Возвращает объект класса
     *
     * @return static
     */
    public static function instance()
    {
        static $instance = null;
        if(is_null($instance)) {
            $instance = new static();
        }

        return $instance;
    }

    /**
     * Получить значение параметра пользовательского запроса
     *
     * @param string $key Ключ, по которому получить значение параметра
     * @return mixed
     */
    public function getParam($key)
    {
        if (isset($this->values[$key])) {
            return $this->values[$key];
        }

        return null;
    }

    /**
     * Установить значение параметра пользовательского запроса
     * Может понадобиться, к примеру, при обработке исключений
     *
     * @param string $key Ключ для параметра
     * @param mixed $val Значение параметра
     */
    public function setParam($key, $val)
    {
        $this->values[$key] = $val;
    }

    /**
     * Установить несколько значений параметров пользовательского запроса
     *
     * @param array $params Массив параметров
     */
    public function setArrayOfParameters($params)
    {
        foreach ($params as $key => $val) {
            $this->setProperty($key, $val);
        }
    }

    /**
     * Запрет переопределения и внешнего вызова
     */
    private final function __construct() {}

    /**
     * Запрет переопределения и внешнего вызова
     */
    private final function __clone() {}

    /**
     * Запрет переопределения и внешнего вызова
     */
    private final function __wakeup() {}
}