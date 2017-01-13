<?php

namespace Application\DAO;

/**
 * Класс Payments - обеспечивает доступ к данным таблиц, связанных с платежами
 *
 * @author Константин Харламов <k.kharlamow@gmail.com>
 * @package Application\DAO
 */
class Payments extends \SpaceWeb\Quest\QuestAbstract
{
    const FILTER_ALL = 1; // Получить платежи с документами и без
    const FILTER_WITH_DOCUMENTS = 2; // Получить платежи с документами
    const FILTER_WITHOUT_DOCUMENTS = 3; // Получить платежи без документов
    const TYPE_WITH_DOCUMENTS = 1; // Тип платежей с документами
    const TYPE_WITHOUT_DOCUMENTS = 2; // Тип платежей без документов

    /**
     * Получение статистики по платежам. Такие монструозные запросы, конечно, не highload.
     * Но и структура таблиц тоже не под это, и объём данных не велик.
     * Посчитал такое решение подходящим в рамках предложенной задачи.
     *
     * @param string $startDate Начальная дата в формате 'Y-m-d'
     * @param string $endDate Конечная дата в формате 'Y-m-d'
     * @param int $filter Фильтр статистики, одна из констант типа FILTER_*
     * @return array
     */
    public function getStat($startDate, $endDate, $filter = self::FILTER_ALL)
    {
        $db = $this->getDb();
        $params = array($startDate, $endDate);
        switch ($filter) {
            case self::FILTER_ALL:
                $sql = 'SELECT CASE WHEN d.id THEN ' . self::TYPE_WITH_DOCUMENTS . ' ELSE '
                    . self::TYPE_WITHOUT_DOCUMENTS . ' END AS p_type,'
                    . ' COUNT(p.id) AS p_cnt, SUM(p.amount) AS p_sum FROM payments AS p LEFT OUTER JOIN documents AS d'
                    . ' ON p.id = d.entity_id WHERE p.create_ts >= ? AND p.create_ts <= ? GROUP BY p_type';
                break;
            case self::FILTER_WITH_DOCUMENTS:
                $sql = 'SELECT ' . self::TYPE_WITH_DOCUMENTS . ' AS p_type,'
                    . ' COUNT(p.id) AS p_cnt, SUM(p.amount) AS p_sum FROM payments AS p INNER JOIN documents AS d'
                    . ' ON p.id = d.entity_id WHERE p.create_ts >= ? AND p.create_ts <= ?';
                break;
            case self::FILTER_WITHOUT_DOCUMENTS:
                $sql = 'SELECT ' . self::TYPE_WITHOUT_DOCUMENTS . ' AS p_type,'
                    . ' COUNT(p.id) AS p_cnt, SUM(p.amount) AS p_sum FROM payments AS p LEFT OUTER JOIN documents AS d'
                    . ' ON p.id = d.entity_id WHERE p.create_ts >= ? AND p.create_ts <= ? AND d.id ISNULL';
                break;
        }

        $statement = $db->prepare($sql);
        $statement->execute($params);

        return $statement->fetchAll(\PDO::FETCH_OBJ);
    }
}