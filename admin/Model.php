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

}