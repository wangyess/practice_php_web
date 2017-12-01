<?php
session_start();

class Product
{
    public $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    function add($rows)
    {
        if (!he_is('admin')) {
            return ['success' => false, 'msg' => 'quanxianbugou'];
        }

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
        if (!he_is('admin')) {
            return ['success' => false, 'msg' => 'quanxianbugou'];
        }

        $id = $rows['id'];
        if (!$id) {
            return ['success' => false, 'msg' => 'interval:id'];
        }
        $sql = "delete from product where id=:id";
        $sta = $this->pdo->prepare($sql);
        $r = $sta->execute(['id' => $id]);
        return $r ? ['success' => true] : ['success' => false, 'msg' => 'interval_error'];
    }

    public function update($rows)
    {
        if (!he_is('admin')) {
            return ['success' => false, 'msg' => 'quanxianbugou'];
        }

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
        $sql = "update product set title= :title, price= :price,cat_id= :cat_id,des= :des,count_s= :count_s where id=:id";
        $sta = $this->pdo->prepare($sql);
        $r = $sta->execute($a);
        return ['success' => true, 'data' => $r];
    }

    public function read($rows)
    {
        if (!he_is('admin')) {
            return ['success' => false, 'msg' => 'quanxianbugou'];
        }

        $page = (int)@$_GET['page'] ?: 1;
        $limit = 5;
        $offset = $limit * ($page - 1);
        $id = $rows['id'];
        if ($id) {
            $sql = "select * from product where id=:id";
            $sta = $this->pdo->prepare($sql);
            $sta->execute(['id' => $id]);
            $r = $sta->fetch(PDO::FETCH_ASSOC);
            if ($r) {
                return ['success' => true, 'data' => $r];
            } else {
                return ['success' => false, 'msg' => 'error'];
            }
        } else {
            $sql = "select * from product  order by id desc limit :offset, :limit";
            $sta = $this->pdo->prepare($sql);
            $sta->execute(['offset' => $offset, 'limit' => $limit]);
            $r = $sta->fetchALL(PDO::FETCH_ASSOC);
            if ($r) {
                return ['success' => true, 'data' => $r];
            } else {
                return ['success' => false, 'msg' => 'error'];
            }
        }
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