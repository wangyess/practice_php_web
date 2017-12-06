<?php

class Model
{
    function _read($opt = [])
    {
        $id = @$opt['id'];
        $page = @$opt['page'] ?: 1;
        $limit = @$opt['limit'] ?: 10;
        $where = @$opt['where'];
        $order = @$opt['order'];
        if ($id) {
            $sql = "select * from $this->table where id = $id";
        } else {
            if ($where) {
                $i = 0;
                $sql_where = ' where ';
                foreach ($where as $key => $val) {
                    $a = $key . " = '" . $val . "'";
                    if ($i > 0) {
                        $a = ' and ' . $a;
                    }
                    $sql_where .= $a . ' ';
                    $i++;
                }
            }

            if ($page) {
                $offset = $limit * ($page - 1);
                $sql_limit = " limit $offset , $limit ";
            }
            if ($order) {
                $by = $order['by'] ?: 'id';
                $direction = @$order['de'] ?: 'desc';
                $sql_order = " order by $by $direction ";
            }
            $sql = "select * from $this->table $sql_where $sql_order  $sql_limit";
        }
        $sta = $this->pdo->prepare($sql);
        $sta->execute();
        return $sta->fetchAll(PDO::FETCH_ASSOC);
    }

    function _remove($opt = [])
    {
        $id = @$opt['id'];
        if (!$id) {
            return ['success' => false, 'msg' => 'invalid:id'];
        }
        $sql = "delete from $this->table where id = $id";
        $sta = $this->pdo->prepare($sql);
        $sta->execute();
        return $sta->fetch(PDO::FETCH_ASSOC);
    }

    function _add($opt = [])
    {
        return $this->_add_or_update('add', $opt);
    }

    public function _update($opt = [])
    {
        return $this->_add_or_update('update', $opt);
    }

    public function _add_or_update($type, $opt)
    {
        //判断是添加还是更新
        $is_add = $type == 'add';
        if ($is_add) {
            //天加
            unset($opt['id']);
        } else {
            //更新
            $id = $opt['id'];
            //判断数据库中是否有这一条
            if (!$old = $this->find($id)) throw new \Exception('invalid:id');
            $opt = array_merge($old, $opt);
        }
        if ($is_add) {
            $sql = $this->create_add_sql($opt);
        } else {
            $sql = $this->create_update_sql($opt);
        }
        $sta = $this->pdo->prepare($sql);
        return $sta->execute();
    }

    public function create_add_sql($opt)
    {
        $sql_key = '';
        $sql_val = '';
        $all_name = $this->column_name_list();
        foreach ($opt as $key => $val) {
            if (in_array($key, $all_name)) {
                $sql_key .= $key . ',';
                $sql_val .= "'" . $val . "'" . ',';
            } else {
                continue;
            }
        }
        $sql_key = trim($sql_key, ',');
        $sql_val = trim($sql_val, ',');
        return $sql = "insert into $this->table ($sql_key) VALUES ($sql_val)";
    }

    public function create_update_sql($opt)
    {
        $id = $opt['id'];
        $col = '';
        $all_name = $this->column_name_list();
        foreach ($opt as $key => $val) {
            if (in_array($key, $all_name)) {
                if ($key == 'id') continue;
                if ($opt[$key] == '') continue;
                $col .= " $key = '$val', ";
            } else {
                continue;
            }
        }
        $col = trim($col, ', ');
        return $sql = "update $this->table set $col  where id = $id ";
    }

    public function column_list()
    {
        $sql = "desc $this->table";
        $sta = $this->pdo->prepare($sql);
        $sta->execute();
        return $sta->fetchAll(PDO::FETCH_ASSOC);
    }

    public function column_name_list()
    {
        $name_list = [];
        $list = $this->column_list();
        foreach ($list as $key) {
            $name_list[] = $key['Field'];
        }
        return $name_list;
    }

    /*通过id找一行*/
    public function find($id)
    {
        if (!$id) return false;

        $s = $this->pdo
            ->prepare("select * from $this->table where id = :id");
        $s->execute([
            'id' => $id,
        ]);
        return $s->fetch(PDO::FETCH_ASSOC);
    }
}