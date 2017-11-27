<?php
namespace Model;

class User{

    /**
     * The DBAL Connection.
     *
     * @var \Doctrine\DBAL\Connection
     */
    protected $connection;

    public function __construct(\Doctrine\DBAL\Connection $connection)
    {
        $this->connection = $connection;
    }


    public function insert(array $parameters)
    {
        return $this->connection->insert('user', $parameters);
    }

    public function fetchByUserId($user_id){

        $sql = "
            SELECT
                *
            FROM
                user
            WHERE
                user_id = :user_id
        ";

        $stmt = $this->connection->prepare($sql);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function fetchByQueryBuilder($user_id = null, $user_name = null, $age = null)
    {
        $qb = $this->connection->createQueryBuilder()
        ->select([
            'user_id',
            'user_name',
            'age'
        ])
        ->from('user');

        if(isset($user_id)){
            $qb->where('user_id = :user_id')
            ->setParameter(':user_id', $user_id);
        }
        if(isset($user_name)){
            $qb->andWhere('user_name = :user_name')
            ->setParameter(':user_name', $user_name);
        }
        if(isset($age)){
            $qb->andWhere('age = :age')
            ->setParameter(':age', $age);
        }

        return $qb->execute()->fetchAll();
    }

}