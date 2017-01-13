<?php

namespace Application\View;

/**
 * Интерфейс IDisplayable - для классов представлений
 *
 * @author Константин Харламов <k.kharlamow@gmail.com>
 * @package Application\View
 */
interface IDisplayable
{
    /**
     * Вывод представления
     */
    public function display();

    /**
     * Добавление переменных в шаблон
     *
     * @param string $name Имя переменной
     * @param mixed $value Значение
     */
    public function assign($name, $value);
}