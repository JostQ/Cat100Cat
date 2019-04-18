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
class DeckManager extends AbstractManager
{
    /**
     *
     */
    const TABLE = 'deck';

    /**
     *  Initializes this class.
     */
    public function __construct()
    {
        parent::__construct(self::TABLE);
    }


    /**
     * @param array $deck
     * @return int
     */
    public function insert(array $deck): int
    {
        // prepared request
        $statement = $this->pdo->prepare("INSERT INTO $this->table (`name`, `lord_id`, `user_id`) 
                                                    VALUES (:name, :lord, :user)");
        $statement->bindValue('name', $deck['name'], \PDO::PARAM_STR);
        $statement->bindValue('lord', $deck['lord'], \PDO::PARAM_STR);
        $statement->bindValue('user', $_SESSION['id'], \PDO::PARAM_INT);

        if ($statement->execute()) {
            return (int)$this->pdo->lastInsertId();
        }
    }

    /**
     * @param int $id
     */
    public function delete(int $id): void
    {
        // prepared request
        $statement = $this->pdo->prepare("DELETE FROM $this->table WHERE id=:id");
        $statement->bindValue('id', $id, \PDO::PARAM_INT);
        $statement->execute();
    }

    public function selectOneByIdAndByUser(int $id): array
    {
        $statement = $this->pdo->prepare('SELECT * FROM ' . $this->table . ' WHERE id = :id AND user_id = :user');
        $statement->bindValue('id', $id, \PDO::PARAM_INT);
        $statement->bindValue('user', $_SESSION['id'], \PDO::PARAM_INT);
        $statement->execute();
        return $statement->fetch();
    }

    public function selectAllByUserId(): array
    {
        $statement = $this->pdo->prepare('SELECT * FROM ' . $this->table . ' WHERE user_id = :user');
        $statement->bindValue('user', $_SESSION['id'], \PDO::PARAM_INT);
        $statement->execute();
        return $statement->fetchAll();
    }
}
