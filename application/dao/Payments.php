<?php

namespace Application\DAO;

class Payments extends \SpaceWeb\Quest\QuestAbstract
{
    const FILTER_ALL = 1;
    const FILTER_WITH_DOCUMENTS = 2;
    const FILTER_WITHOUT_DOCUMENTS = 3;

    public function getStat($filter = self::FILTER_ALL)
    {
        $db = $this->getDb();
        $sql = 'SELECT * FROM payments';
        $statement = $db->prepare('SELECT * FROM payments');
        $statement->execute();

        return $statement->fetchAll(\PDO::FETCH_OBJ);
    }
}