<?php
session_start();
require_once('Model.php');

class Package extends Model
{
    public $pdo;
    public $table = 'package';

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function add($rows)
    {
        $product_id = $rows['product_id'];
        if (!$this->find_a($product_id)) {
            return ['success' => false, 'msg' => 'invalid:product_id'];
        }
        $data = $this->_add($rows);
        return $data ?
            ['success' => true] :
            ['success' => false, 'msg' => 'internal_error'];
    }

    public function remove($rows)
    {
        $data = $this->_remove($rows);
        return ['success' => true];
    }

    public function update($rows)
    {
        $id = @$rows['id'];
        if(!$id){
            return ['success' => false, 'msg' => 'no_id'];
        }
        $name = @$rows['name'];
        //判断name 是否重复
        $r = $this->name_exists($name, $id);
        if ($r) {
            return ['success' => false, 'msg' => 'exist_name'];
        }
        $data = $this->_update($rows);
        return $data ? ['success' => true] : ['success' => false, 'msg' => 'internal_error'];
    }

    public function read($rows)
    {
        $data = $this->_read($rows);
        return ['success' => true, 'data' => $data];
    }

    public function find_item($id)
    {
        $sql = "select * from package where id =$id";
        $sta = $this->pdo->prepare($sql);
        $sta->execute();
        return $sta->fetch(PDO::FETCH_ASSOC);
    }

    public function name_exists($name, $id)
    {
        $sql = "select * from package where `name` = '{$name}' and id<>$id";
        $sta = $this->pdo->prepare($sql);
        $sta->execute();
        $t = $sta->fetch(PDO::FETCH_ASSOC);
        return (bool)$t;
    }

    //看看数据库 product 中是否存在
    public function find_a($product_id)
    {
        $sql = "select * from product where id = $product_id";
        $sta = $this->pdo->prepare($sql);
        $sta->execute();
        return $sta->fetch(PDO::FETCH_ASSOC);
    }
}