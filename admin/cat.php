<?php
session_start();

class Cat
{
    public $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function add($rows)
    {
        if (!he_is('admin')) {
            return ['success' => false, 'msg' => 'quanxianbugou'];
        }

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
        $parent_id = $rows['parent_id'] ? (int)$rows['parent_id'] : 1;
        $sql = "insert into cat (title,parent_id) values( '{$title}', '{$parent_id}')";
        $row = $this->pdo->prepare($sql);
        $r = $row->execute();
        return $r ? ['success' => true] : ['success' => false, 'msg' => 'internal_error'];
    }

    public function remove($rows)
    {
        if (!he_is('admin')) {
            return ['success' => false, 'msg' => 'quanxianbugou'];
        }

        $id = $rows['id'];
        if (!$id) {
            return ['success' => false, 'msg' => 'invalid:id'];
        }
        $sql = "delete from cat where id = ?";
        $row = $this->pdo->prepare($sql);
        $row->bindValue(1, $id);
        $r = $row->execute();
        return $r ? ['success' => true] : ['success' => false, 'msg' => 'internal_error'];
    }

    public function update($rows)
    {
        if (!he_is('admin')) {
            return ['success' => false, 'msg' => 'quanxianbugou'];
        }

        $id = $rows['id'];
        $title = $rows['title'];
        //判断是否传入了ID
        if (!$id) {
            return ['success' => false, 'msg' => 'invalid:id'];
        }
        //判断要更新这条数据是否存在 存在的话就拿出来
        $data = $this->find_id($id);
        if (!$data) {
            return ['success' => false, 'msg' => 'invalid:id'];
        }
        //判断是否重复
        if ($this->title_exist($title, $id)) {
            return ['success' => false, 'msg' => 'exist:title'];
        }
        $cc = array_merge($data, $rows);
        $spl = "update cat set title = :title,parent_id = :parent_id where id = :id";
        $ee = $this->pdo->prepare($spl);
        $r = $ee->execute($cc);
        return $r ? ['success' => true] : ['success' => false, 'msg' => 'internal_error'];
    }

    public function read($rows)
    {
        $id = $rows['id'];
        $page = $_GET['page'] ?: 1;
        $limit = 5;
        $offset = $limit * ($page - 1);

        if ($id) {
            $s = $this->pdo->prepare('select * from cat where id = :id');
            $s->execute(['id' => $id]);
            $d = $s->fetch(PDO::FETCH_ASSOC);
        } else {
            $spl = "select * from cat order by id desc limit :offset, :limit";
            $row = $this->pdo->prepare($spl);
            $row->execute([
                'offset' => $offset,
                'limit' => $limit,
            ]);
            $d = $row->fetchAll(PDO::FETCH_ASSOC);
        }
        return ['success' => true, 'data' => $d];
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