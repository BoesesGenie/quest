<?php

namespace Application\Controller;

use Application\DAO\Payments;
use Application\Helper\Date as DH;

class StatisticController extends \Application\Base\Controller
{
    public function indexAction()
    {
        echo "Follow instructions below. To exit program type 'q' and press 'Enter'.\n";
        $startDate = '';
        $endDate = '';
        while (!DH::validateFormat($startDate) || !DH::validateFormat($endDate)) {
            echo 'Please enter start date (YYYY-MM-DD): ';
            $startDate = trim(fgets(STDIN));
            if ($startDate == 'q') {
                echo "Bye!\n";
                exit;
            }

            echo 'Please enter end date (YYYY-MM-DD): ';
            $endDate = trim(fgets(STDIN));
            if ($endDate == 'q') {
                echo "Bye!\n";
                exit;
            }
        }

        $data = (new Payments())->getStat();
        $this->view->assign('stat', $data);
    }
}