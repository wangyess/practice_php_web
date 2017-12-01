<?php
session_start();
require_once ('../helper/helper.php');
require_once('./cat.php');
require_once('./product.php');
require_once('./user.php');
require_once('./order.php');
//封装一个连接数据库的方法
function connect_database()
{
    //配置默认项
    $options = [
        /* 常用设置 */
        PDO::ATTR_CASE => PDO::CASE_NATURAL, /*PDO::CASE_NATURAL | PDO::CASE_LOWER 小写，PDO::CASE_UPPER 大写， */
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, /*是否报错，PDO::ERRMODE_SILENT 只设置错误码，PDO::ERRMODE_WARNING 警告级，如果出错提示警告并继续执行| PDO::ERRMODE_EXCEPTION 异常级，如果出错提示异常并停止执行*/
        PDO::ATTR_ORACLE_NULLS => PDO::NULL_NATURAL, /* 空值的转换策略 */
        PDO::ATTR_STRINGIFY_FETCHES => false, /* 将数字转换为字符串 */
        PDO::ATTR_EMULATE_PREPARES => false, /* 模拟语句准备 */
    ];
    return $pdo = new PDO('mysql:host=wangye.mvp;dbname=shopping_mall', 'root', 'wangye', $options);
}

//获取页面的输入
function get_page_input($pdo)
{
    //获取输入
    $params = array_merge($_GET, $_POST);
    //获取页面调用的类名
    $klass = ucfirst(@$params['model']);
    //获取页面调用的方法
    $methods = @$params['action'];
    $kk = new $klass($pdo);
    unset($params['model']);
    unset($params['action']);
    //调用这个方法
    return $kk->$methods($params);
}

//初始函数
function init()
{
    $pdo = connect_database();
    echo json(get_page_input($pdo));
}

init();
