<?php
session_start();
//var_dump(dirname(__FILE__).'/../helper/helper.php');
//require_once (dirname(__FILE__).'/../helper/helper.php');
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
    <link rel="stylesheet" href="/css/home.css">
</head>
<body>
<div class="navbar nav-default cc clearfix">
    <div class="container clearfix">
        <ul class="nav navbar-nav">
            <li><a href="/">首页</a></li>
            <li><a href="">收藏</a></li>
            <li><a href="">购物车</a></li>
            <?php
            if (he_is('admin')) {
                echo '<li>' . '<a href="/adm/product">' . 'Admin' . '</a>' . '</li>';
            }
            ?>
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
<div class="row clearfix">
    <div class="container">
        <div class="col-sm-3 logo">
            LOGO
        </div>
        <div class="col-sm-6 search">
            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Adipisci beatae dolor eaque eos ipsam iusto
            laborum minima numquam possimus voluptatibus?
        </div>
        <div class="col-sm-3 cart">
            card
        </div>
    </div>
</div>
<div class="row">
    <div class="container">
        <div class="col-sm-3 cat-list">
            Cat
        </div>
        <div class="col-sm-6">
            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aspernatur explicabo illo quam quas qui quo quod
            reiciendis? A dolore libero, molestiae nihil numquam quis repellendus tempore tenetur velit vero,
            voluptatem!
        </div>
        <div class="col-sm-3">
            Persional_information
        </div>
    </div>
</div>
<div class="row">
    <div class="container clearfix">
        <div class="product-list">
            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquam, amet architecto at blanditiis debitis
            dolore dolores expedita laboriosam laudantium natus odit perferendis repellendus reprehenderit sapiente
            tempora temporibus totam. A alias consequatur delectus esse exercitationem incidunt neque nesciunt nostrum
            sed tenetur. Alias aut commodi ipsa nesciunt repellat saepe temporibus veniam voluptatibus. Ipsam labore
            natus omnis. Adipisci dolore laudantium veniam vitae. Ab at, aut, dignissimos dolore dolorem doloremque
            eveniet hic itaque maiores, nam necessitatibus pariatur perspiciatis quod rerum saepe sapiente sit!
            Accusamus asperiores aut commodi cum distinctio dolorum, ex explicabo in nemo nisi nostrum odit, pariatur,
            quae quis temporibus vel velit voluptatibus?
        </div>
    </div>
</div>
<div class="row">
    <div class="container">
        <div class="footer text-center">
            <p>无聊的人决定着无聊的人生和多彩的数字</p>
        </div>
    </div>
</div>

<script src="https://cdn.bootcss.com/jquery/3.2.1/jquery.js"></script>
<script src="/js/model.js"></script>
<script src="/js/home.js"></script>
<script src="/js/logout.js"></script>
</body>
</html>