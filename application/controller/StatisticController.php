<?php

namespace Application\Controller;

use Application\DAO\Payments;
use Application\Helper\Date as DH;

/**
 * Класс StatisticController - контроллер статистики платежей
 *
 * @author Константин Харламов <k.kharlamow@gmail.com>
 * @package Application\Controller
 */
class StatisticController extends \Application\Base\Controller
{
    const OPT_WITH_DOCS = '--with-documents'; // Опция запроса клиента, платежи с документами
    const OPT_WITHOUT_DOCS = '--without-documents'; // Опция запроса клиента, платежи без документов

    /**
     * Главное действие, вывод суммарной статистики
     */
    public function indexAction()
    {
        $this->displayMessage("Follow instructions below. To exit program type 'q' and press 'Enter'.\n");
        $check = false;
        while (!$check) {
            $this->displayMessage('Please enter start date (YYYY-MM-DD): ');
            $startDate = trim(fgets(STDIN));
            if ($startDate == 'q') {
                $this->displayMessage("Bye!\n");
                exit;
            }

            if (!DH::validateFormat($startDate)) {
                $this->displayMessage("Wrong date format.\n");
                continue;
            }

            $this->displayMessage('Please enter end date (YYYY-MM-DD): ');
            $endDate = trim(fgets(STDIN));
            if ($endDate == 'q') {
                $this->displayMessage("Bye!\n");
                exit;
            }

            if (!DH::validateFormat($endDate)) {
                $this->displayMessage("Wrong date format.\n");
                continue;
            }

            if ($startDate > $endDate) {
                $this->displayMessage("Wrong period.\n");
                continue;
            }

            $check = true;
        }

        $filter = Payments::FILTER_ALL;
        $options = \Application\Base\RequestRegistry::instance()->getParam('options');
        if (is_array($options)) {
            if (isset($options[self::OPT_WITH_DOCS]) && !isset($options[self::OPT_WITHOUT_DOCS])) {
                $filter = Payments::FILTER_WITH_DOCUMENTS;
            } elseif (isset($options[self::OPT_WITHOUT_DOCS]) && !isset($options[self::OPT_WITH_DOCS])) {
                $filter = Payments::FILTER_WITHOUT_DOCUMENTS;
            } else {
                $filter = Payments::FILTER_ALL;
            }
        }

        $data = (new Payments())->getStat($startDate, $endDate, $filter);
        $this->view->cleanData();
        $this->view->setTemplate('statistic/index');
        $this->view->assign('stat', $data);
    }

    /**
     * Вывод произвольного сообщения в консоль
     *
     * @param string $message Текст сообщения
     */
    private function displayMessage($message)
    {
        $this->view->setTemplate('statistic/_message');
        $this->view->assign('message', $message);
        $this->view->display();
    }
}