<?php
session_start();
require_once('Model.php');

class Cat extends Model
{
    public $pdo;
    public $table = 'cat';
    public $column_rule = [
        'title'     => 'u_max_length:12|u_min_length:2',
        'parent_id' => 'numeric|positive',
    ];

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function add($rows)
    {
        $title = $rows['title'];
        //判断是否传title
        if (!$title) {
            return ['success' => false, 'msg' => 'invalid:title'];
        }
        //判断是否存在
        if ($this->title_exist($title)) {
            return ['success' => false, 'msg' => 'exist:title'];
        }
        //如果有parent_id 那么返回一个int型的 如果没有自动为空
        $rows['parent_id'] = $rows['parent_id'] ? $rows['parent_id'] : 1;
        $data = $this->_add($rows);
        $rs = $data['msg'];
        if ($rs) {
            return $data;
        }
        return $data ? ['success' => true] : ['success' => false, 'msg' => 'internal_error'];
    }

    public function remove($rows)
    {
        $data = $this->_remove($rows);
        return $data ? ['success' => false, 'msg' => 'internal_error'] : ['success' => true];
    }

    public function update($rows)
    {
        $id = $rows['id'];
        $title = $rows['title'];
        if ($this->title_exist($title, $id)) {
            return ['success' => false, 'msg' => 'exist:title'];
        }
        $data = $this->_update($rows);
        $rs = $data['msg'];
        if ($rs) {
            return $data;
        }
        return $data ? ['success' => true] : ['success' => false, 'msg' => 'internal_error'];
    }

    public function read($rows)
    {
        $data = $this->_read($rows);
        return ['success' => true, 'data' => $data];
    }

    public function read_count()
    {
        $sql = "select count(*) from cat ";
        $sta = $this->pdo->prepare($sql);
        $sta->execute();
        return $sta->fetch(PDO::FETCH_NUM)[0];
    }

    //判断是不是已经存在一个样的名字的分类
    public function title_exist($title, $id = null)
    {
        $sql = "select * from cat where title =:title";
        $hole = ['title' => $title];
        if ($id) {
            //如果传入ID代表是要更新 所以要把本身排除在外
            $sql = $sql . ' and id <> :id';
            $hole['id'] = $id;
        }
        $sta = $this->pdo->prepare($sql);
        $sta->execute($hole);
        $r = $sta->fetch(PDO::FETCH_ASSOC);
        return (bool)$r;
    }

    //判断表中是否有想要更新的数据
    public function find_id($id)
    {
        $sql = "select * from cat where id = :id";
        $sta = $this->pdo->prepare($sql);
        $sta->execute(['id' => $id]);
        $r = $sta->fetch(PDO::FETCH_ASSOC);
        return $r;
    }
}