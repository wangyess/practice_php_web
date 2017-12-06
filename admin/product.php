<?php
session_start();
require_once('Model.php');

class Product extends Model
{
    public $pdo;
    public $table = 'product';

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    function add($rows)
    {
        $data=$this->_add($rows);
        return $data ? ['success' => true] : ['success' => false, 'msg' => 'interval_error'];
    }

    public function remove($rows)
    {
        $data = $this->_remove($rows);
        return $data ? ['success' => false, 'msg' => 'interval_error'] : ['success' => true];
    }

    public function update($rows)
    {
        $data=$this->_update($rows);
        return $data ?['success' => true] :['success' => false];
    }

    public function read($rows)
    {
        $data = $this->_read($rows);
        return ['success' => true, 'data' => $data];
    }
    public function read_count()
    {
        $sql = "select count(*) from product ";
        $sta = $this->pdo->prepare($sql);
        $sta->execute();
        return $sta->fetch(PDO::FETCH_NUM)[0];
    }

    public function exist_product($id)
    {
        $sql = "select * from product where id=:id";
        $sta = $this->pdo->prepare($sql);
        $sta->execute(['id' => $id]);
        return $sta->fetch(PDO::FETCH_ASSOC);
    }
}