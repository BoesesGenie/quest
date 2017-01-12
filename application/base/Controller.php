<?php

namespace Application\Base;

class Controller
{
    /**
     * @var \Application\View\IDisplayable
     */
    protected $view;
    
    protected $request;

    public function __construct(\Application\View\IDisplayable $view)
    {
        $this->view = $view;
        $this->request = \Application\Base\RequestRegistry::instance();
    }
    
    public function execute()
    {
        $actionName = $this->request->getParam(RequestRegistry::ACTION_NAME);
        $this->$actionName();
        $this->view->display();
    }
}