<?php

namespace Fumagally\PDOMysql;

class PDOIterator
{
    private $position = 0;
    private $pdo;
    private $fetchMode;
    private $nextResult;

    public function __construct(PDOStatement $pdo, $fetchMode = PDO::FETCH_ASSOC)
    {
        $this->position = 0;
        $this->pdo = $pdo;
        $this->fetchMode = $fetchMode;
    }

    public function rewind()
    {
        $this->position = 0;
        $this->pdo->execute();
        $this->nextResult = $this->pdo->fetch($this->fetchMode, PDO::FETCH_ORI_NEXT);
    }

    public function current()
    {
        return $this->nextResult;
    }

    public function key()
    {
        return $this->position;
    }

    public function next()
    {
        ++$this->position;
        $this->nextResult = $this->pdo->fetch($this->fetchMode, PDO::FETCH_ORI_NEXT);
    }

    public function valid()
    {
        $invalid = $this->nextResult === false;
        if ($invalid) {
            $this->pdo->closeCursor();
        }

        return !$invalid;
    }
}
