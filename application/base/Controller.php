<?php

namespace Application\Base;

/**
 * Класс Controller - базовый класс контроллеров
 *
 * @author Константин Харламов <k.kharlamow@gmail.com>
 * @package Application\Base
 */
class Controller
{
    /**
     * @var \Application\View\IDisplayable Объект представления
     */
    protected $view;

    /**
     * @var \Application\Base\RequestRegistry Объект пользовательского запроса
     */
    protected $request;

    /**
     * Controller constructor.
     * @param \Application\View\IDisplayable $view Объект представления
     */
    public function __construct(\Application\View\IDisplayable $view)
    {
        $this->view = $view;
        $this->request = \Application\Base\RequestRegistry::instance();
    }

    /**
     * Выполнение действий контроллера
     */
    public function execute()
    {
        $actionName = $this->request->getParam(RequestRegistry::ACTION_NAME);
        $this->$actionName();
        $this->view->display();
    }
}