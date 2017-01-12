<?php

namespace Application\Controller;

use Application\DAO\Payments;

class StatisticController extends \Application\Base\Controller
{
    public function indexAction()
    {
        $data = (new Payments())->getStat();
        $this->view->assign('stat', $data);
    }
}