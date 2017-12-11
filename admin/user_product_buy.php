<?php
session_start();
require_once(__DIR__ . '/./Model.php');

class User_buy extends Model
{
    public $uid;
    public $table = 'user_buy';

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function add($rows)
    {
        //获取商品id
        $pid = @$rows['product_id'];
        //获取当前用户ID
        $uid = @$_SESSION['user']['id'];
        $sql = "insert into user_product_buy(product_id,user_id) VALUES ($pid ,$uid)";
        $sta = $this->pdo->prepare($sql);
        return $sta->execute();
    }

    public function read()
    {
        $uid = @$_SESSION['user']['id'];
        $sql = "select product.id , product.price  from product
                inner join user_product_buy 
                on product.id = user_product_buy.product_id where user_id =$uid";

        $sta = $this->pdo->prepare($sql);
        $sta->execute();
        return $sta->fetchAll(PDO::FETCH_ASSOC);
    }
}