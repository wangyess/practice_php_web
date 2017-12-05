<?php
session_start();
require_once ('Model.php');

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
        $name = @$rows['name'];
        $price = @$rows['price'];
        $product_id = @$rows['product_id'];
        $count_s = @$rows['count_s'];
        $des = @$rows['des'];
        if (!$name || !$product_id || !$price)
            return ['success' => false, 'msg' => 'invalid:title||product_id||price'];

        $s = $this->pdo
            ->prepare("insert into $this->table (name, product_id, price, des, count_s) values (?,?,?,?,?)");

        $r = $s->execute([
            $name, $product_id, $price, $des, $count_s,
        ]);

        return $r ?
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
        $name = @$rows['name'];
        //判断是否有这条
        $data = $this->find_item($id);
        if (!$data) {
            return ['success' => false, 'msg' => 'invalid:id'];
        }
        //判断name 是否重复
        $r = $this->name_exists($name,$id);
        if($r){
            return ['success' => false, 'msg' => 'exist_name'];
        }
        $sql="update package set `name` =:name,price=:price where id =:id";
        $sta=$this->pdo->prepare($sql);
        return $sta->execute($rows) ? ['success' => true] :['success' => false, 'msg' => 'internal_error'];
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

    public function name_exists($name,$id)
    {
      $sql="select * from package where `name` = '{$name}' and id<>$id";
      $sta=$this->pdo->prepare($sql);
      $sta->execute();
      $t=$sta->fetch(PDO::FETCH_ASSOC);
      return (bool)$t;
    }
}