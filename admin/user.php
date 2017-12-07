<?php
session_start();
require_once('Model.php');

class User extends Model
{
    public $pdo;

//    public $column_rule = [
//        'username' => 'max_length:12 | min_length:4',
//        'password' => 'max_length:64 | min_length:12',
//    ];

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function signup($rows)
    {
        $username = $rows['username'];
        $password = $rows['password'];
        $permission = $rows['permission'];
        if (!$username || !$password) {
            return ['success' => false, 'msg' => 'invalid:username || password'];
        }
        //判断这个用户名有没有人用
        $kk = $this->exist_username($username);
        if ($kk) {
            return ['success' => false, 'msg' => 'exist_username'];
        }
        //密码加密
        $password = $this->password_encrypt($password);
        $sql = "insert into user(username, password, permission) values('{$username}', '{$password}', '{$permission}')";
        $sta = $this->pdo->prepare($sql);
        $r = $sta->execute();
        return $r ? ['success' => true] : ['success' => false, 'msg' => 'interval_error'];
    }

    public function login($rows)
    {
        $username = $rows['username'];
        $password = $rows['password'];
        if (!$username || !$password) {
            return ['success' => false, 'msg' => 'invalid_username || password'];
        }
        //将密码转换\
        $password = $this->password_encrypt($password);
        //判断用户名和密码是否被注册过
        $sql = "select * from user where username=:username and password =:password";
        $sta = $this->pdo->prepare($sql);
        $sta->execute(['username' => $username, 'password' => $password]);
        $r = $sta->fetch(PDO::FETCH_ASSOC);
        if ($r) {
            $_SESSION['user'] = $r;
            return ['success' => true, 'data' => $r];
        } else {
            return ['success' => false, 'msg' => 'interval_error'];
        }
    }

    public function logout()
    {
        unset($_SESSION['user']);
        return ['success' => true];
    }

    //判断用户名是否存在
    public function exist_username($username)
    {
        $sql = "select * from user where username=:username";
        $sta = $this->pdo->prepare($sql);
        $sta->execute(['username' => $username]);
        $r = $sta->fetch(PDO::FETCH_ASSOC);
        return $r;
    }

    //用户密码加密
    public function password_encrypt($password)
    {
        return md5(md5($password) . 'aaa');
    }
}