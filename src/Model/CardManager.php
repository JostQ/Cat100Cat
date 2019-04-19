<?php
/**
 * Created by PhpStorm.
 * User: sylvain
 * Date: 07/03/18
 * Time: 18:20
 * PHP version 7
 */

namespace App\Model;

/**
 *
 */
class CardManager extends AbstractManager
{
    /**
     *
     */
    const TABLE = 'card';

    /**
     *  Initializes this class.
     */
    public function __construct()
    {
        parent::__construct(self::TABLE);
    }


    /**
     * @param array $card
     * @return int
     */
    public function insert(array $card): int
    {
        // prepared request
        $statement = $this->pdo->prepare("INSERT INTO $this->table (`egg_id`, `deck_id`) VALUES (:egg, :deck)");
        $statement->bindValue('egg', $card['egg'], \PDO::PARAM_STR);
        $statement->bindValue('deck', $card['deck'], \PDO::PARAM_INT);

        if ($statement->execute()) {
            return (int)$this->pdo->lastInsertId();
        }
    }

    /**
     * @param string $egg_id
     * @param int $id
     * @return bool
     */
    public function updateSelected(string $egg_id, int $id):bool
    {
        // prepared request
        $statement = $this->pdo->prepare("UPDATE $this->table SET `is_selected` = true 
                                                WHERE egg_id = :egg AND deck_id = :id");
        $statement->bindValue('id', $id, \PDO::PARAM_INT);
        $statement->bindValue('egg', $egg_id, \PDO::PARAM_BOOL);

        return $statement->execute();
    }

    public function selectAllByDeckId(int $id): array
    {
        $statement = $this->pdo->prepare('SELECT * FROM ' . $this->table . ' WHERE deck_id = :id');
        $statement->bindValue('id', $id, \PDO::PARAM_STR);
        $statement->execute();

        return $statement->fetchAll();
    }

    public function selectOneByEggId(int $id): array
    {
        $statement = $this->pdo->prepare('SELECT * FROM ' . $this->table . ' WHERE egg_id = :id');
        $statement->bindValue('id', $id, \PDO::PARAM_STR);
        $statement->execute();

        return $statement->fetch();
    }
}
