<?php
class Db
{
    private
        $config = [
            'driver' => 'mysql',
            'host' => 'localhost',
            'login' => 'root',
            'password' => '',
            'database' => 'kotophoto',
            'charset' => 'utf8'
        ];

    private $connection = null;

    private function getConnection()
    {
        if (is_null($this->connection)) {
            $this->connection = new \PDO($this->prepareDsnString(), $this->config['login'], $this->config['password']);
            $this->connection->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_ASSOC);
        }
        return $this->connection;
    }

    private function prepareDsnString()
    {
        return sprintf(
            "%s:host=%s;dbname=%s;charset=%s",
            $this->config['driver'],
            $this->config['host'],
            $this->config['database'],
            $this->config['charset']
        );
    }

    private function query($sql, $params)
    {
        $STH = $this->getConnection()->prepare($sql);
        $STH->execute($params);
        return $STH;
    }

    public function queryWhereAssoc($sql, $params)
    {
        $STH = $this->query($sql, $params);
        $STH->setFetchMode(\PDO::FETCH_ASSOC);
        return $STH->fetchAll();
    }

    public function createFeedBackTable()
    {
        $sql = "CREATE TABLE IF NOT EXISTS `feedback` (
        `id` int(11) not null auto_increment,
        `name` varchar(64),
        `email` varchar(64),
        `message` text,
        primary key(`id`) 
        );";
        $this->query($sql, []);
    }

    public function insert($tableName, $props)
    {
        foreach ($props as $key => $value) {
            $params[':' . $key] = $value;
            $columns[] = $key;
        }
        $columns = implode(',', $columns);
        $values = implode(',', array_keys($params));
        $sql = "INSERT INTO {$tableName} ({$columns}) VALUES ({$values})";
        if ($this->query($sql, $params))
            return true;
        return false;
    }
}
