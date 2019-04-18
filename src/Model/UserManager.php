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
class UserManager extends AbstractManager
{
    /**
     *
     */
    const TABLE = 'user';

    /**
     *  Initializes this class.
     */
    public function __construct()
    {
        parent::__construct(self::TABLE);
    }


    /**
     * @param array $user
     * @return int
     */
    public function insert(array $user): int
    {
        // prepared request
        $statement = $this->pdo->prepare("INSERT INTO 
                        $this->table (`nickname`, `email`, `password`) 
                        VALUES (:nickname, :email, :password)");
        $statement->bindValue('nickname', $user['nickname'], \PDO::PARAM_STR);
        $statement->bindValue('email', $user['email'], \PDO::PARAM_STR);
        $statement->bindValue('password', $user['password'], \PDO::PARAM_STR);

        if ($statement->execute()) {
            return (int)$this->pdo->lastInsertId();
        }
    }

    public function isEmailExist(string $email): bool
    {
        $result = false;

        $statement = $this->pdo->prepare('SELECT * FROM ' . $this->table . ' WHERE email = :email');
        $statement->bindValue('email', $email, \PDO::PARAM_STR);
        if ($statement->execute()) {
            if (count($statement->fetchAll()) === 0) {
                $result = true;
            }
        }

        return (bool)$result;
    }

    public function selectUserByEmail(string $email): array
    {
        $statement = $this->pdo->prepare('SELECT * FROM ' . $this->table . 'WHERE email = :email');
        $statement->bindValue('email', $email, \PDO::PARAM_STR);
        $statement->execute();
        return $statement->fetch();
    }
}
