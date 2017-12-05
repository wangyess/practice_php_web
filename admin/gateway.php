<?php
session_start();
require_once(dirname(__FILE__) . '/../helper/helper.php');
require_once(dirname(__FILE__) . '/./cat.php');
require_once(dirname(__FILE__) . '/./product.php');
require_once(dirname(__FILE__) . '/./user.php');
require_once(dirname(__FILE__) . '/./order.php');
require_once(dirname(__FILE__) . '/./package.php');

//获取页面的输入
function get_page_input($uri)
{
    $uri = trim(trim($uri, '/'), 'a/');
    $befor_after = explode('?', $uri);
    $model_ac = @$befor_after[0];

    $model_action = explode('/', $model_ac);
    $model = @$model_action[0];
    $action = @$model_action[1];
    $pdo = connect_database();

    //获取输入
    $params = array_merge($_GET, $_POST);
    //获取页面调用的类名
    $klass = ucfirst($model);
    //获取页面调用的方法
    $methods = $action;
    //判断权限
    if (!has_permission_to($model, $action)) {
        echo json_encode(['success' => false, 'msg' => 'permission_denied']);
        return;
    }
    $kk = new $klass($pdo);
    //调用这个方法
    $res = $kk->$methods($params);
    echo json($res);
}

function has_permission_to($model, $action)
{
    $public = [
        'user' => ['login', 'signup', 'logout']
    ];
    $config = [
        'product' => [
            'read' => ['user', 'admin'],
            'add' => ['admin'],
            'remove' => ['admin'],
            'update' => ['admin'],
            'read_count' => ['user', 'admin'],
        ],
        'cat' => [
            'read' => ['user', 'admin'],
            'add' => ['admin'],
            'remove' => ['admin'],
            'update' => ['admin'],
            'read_count' => ['user', 'admin'],
        ],
        'package' => [
            'read' => ['user', 'admin'],
            'add' => ['admin'],
            'remove' => ['admin'],
            'update' => ['admin'],
        ]
    ];
    //判断是否有传进来的model
    if (!key_exists($model, $config) && !key_exists($model, $public)) {
        return false;
    }
    $public_action_arr = @$public[$model];
    if ($public_action_arr && in_array($action, $public_action_arr)) {
        return true;
    }
    //判断是否有传进来的方法
    $action_arr = $config[$model];
    if (!key_exists($action, $action_arr)) {
        return false;
    }
    //判断你是否有权限去访问这个方法
    $permission_arr = $action_arr[$action];
    $user_permission = $_SESSION['user']['permission'];
    if (!in_array($user_permission, $permission_arr)) {
        return false;
    } else {
        return true;
    }
}

