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
        $title = @$rows['title'];
        $price = @$rows['price'];
        $cat_id = @$rows['cat_id'];
        $des = @$rows['des'];
        $count_s = @$rows['count_s'];
        if (!$title || !$price || !$cat_id) {
            return ['success' => false, 'msg' => 'invalid:title||price||cat_id'];
        }
        if (!is_numeric($price)) {
            return ['success' => false, 'msg' => 'invalid_price'];
        }
        if (!is_numeric($count_s)) {
            return ['success' => false, 'msg' => 'invalid_price'];
        }
        $sql = "insert into product(title,price,cat_id,des,count_s) values('{$title}', '{$price}', '{$cat_id}', '{$des}', '{$count_s}') ";
        $sta = $this->pdo->prepare($sql);
        $r = $sta->execute();
        return $r ? ['success' => true] : ['success' => false, 'msg' => 'interval_error'];
    }

    public function remove($rows)
    {
        $data = $this->_remove($rows);
        return $data ? ['success' => false, 'msg' => 'interval_error'] : ['success' => true];
    }

    public function update($rows)
    {
        $id = $rows['id'];
        if (!$id) {
            return ['success' => false, 'msg' => 'interval:id'];
        }
        //判断数据库中有没有这个ID
        $old = $this->exist_product($id);
        if (!$old) {
            return ['success' => false, 'msg' => 'no_find'];
        }
        $a = array_merge($old, $rows);
        $sql = "update product set title= :title, price= :price,cat_id= :cat_id,des= :des,count_s= :count_s,hot= :hot,new= :new where id=:id";
        $sta = $this->pdo->prepare($sql);
        $r = $sta->execute($a);
        return ['success' => true, 'data' => $r];
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