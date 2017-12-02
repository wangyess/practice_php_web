<?php
session_start();
?>
<!doctype html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>这个天才又来啦❤️</title>
    <link rel="stylesheet" href="https://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.css">
    <link rel="stylesheet" href="https://cdn.bootcss.com/font-awesome/4.7.0/css/font-awesome.css">
    <style>
        .ass{
            width: 500px;
            margin: 40px auto;
        }
        .ddl{
            text-align: center;
            width: 500px;
            margin: 40px auto;
        }
    </style>
</head>
<body>
<div class="navbar nav-default cc clearfix">
    <div class="container clearfix">
        <ul class="nav navbar-nav">
            <li><a href="/">首页</a></li>
            <li><a href="">收藏</a></li>
            <li><a href="">购物车</a></li>
        </ul>
        <ul class="nav navbar-nav navbar-right">
            <li><a href="/signup">注册</a></li>
            <?php
            if ($_SESSION['user']) {
                echo '<li>' . '<a >' . $_SESSION['user']['username'] . '</a>' . '</li>';
                echo '<li id="cli_on_1">' . '<a>' . '注销' . '</a>' . '</li>';
            } else {
                echo '<li>' . '<a href="/login">' . '登录' . '</a>' . '</li>';
            }
            ?>
        </ul>
    </div>
</div>
<hr>
<div class="row">
    <div class="container clearfix">
        <div class="ddl">
            <h2>Signup</h2>
        </div>
        <div class="ass">
            <form id="signup-form" >
                <div class="form-group">
                    <input type="text" class="form-control" name="username"  placeholder="UserName">
                </div>
                <div class="form-group">
                    <input type="password" class="form-control" name="password"  placeholder="Password">
                </div>
                <div class="form-group">
                    <input type="hidden" class="form-control" name="permission" value="user" placeholder="Password">
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-default form-control">Signup</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script src="https://cdn.bootcss.com/jquery/3.2.1/jquery.js"></script>
<script src="/js/signup.js"></script>
<script src="/js/logout.js"></script>
</body>
</html>