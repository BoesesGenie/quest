<?php

namespace Application\View;

/**
 * Класс Console - представление для консольного вывода
 *
 * @author Константин Харламов <k.kharlamow@gmail.com>
 * @package Application\View
 */
class Console implements IDisplayable
{
    /**
     * @var array Массив данных для подстановки в шаблон
     */
    private $data = array();

    /**
     * @var string Путь к файлу шаблона
     */
    private $template = '';

    /**
     * @inheritdoc
     */
    public function display() {
        echo $this->render();
    }

    /**
     * @inheritdoc
     */
    public function assign($name, $value) {
        $this->data[$name] = $value;
    }

    /**
     * Установить путь к шаблону
     *
     * @param string $template Имя файла шаблона
     */
    public function setTemplate($template)
    {
        $this->template = $this->baseTplDir() . $template . '.php';
    }

    /**
     * Очистить массив данных для подстановки в шаблон
     */
    public function cleanData()
    {
        $this->data = array();
    }

    /**
     * Рендер шаблона
     *
     * @return string
     * @throws \Exception
     */
    public function render()
    {
        foreach ($this->data as $name => $val) {
            $$name = $val;
        }

        if (!$this->template || !file_exists($this->template)) {
            throw new \Exception('Wrong template path: "' . $this->template . '".');
        }

        ob_start();
        include $this->template;
        $output = ob_get_contents();
        ob_end_clean();

        return $output;
    }

    /**
     * Директория файлов шаблонов для консольного вывода
     *
     * @return string
     */
    private function baseTplDir()
    {
        return __DIR__ . '/templates/console/';
    }
}