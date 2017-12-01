<?php
//权限判断
function he_is($permission)
{
    if ($_SESSION['user']['permission'] === $permission) {
        return true;
    } else {
        return false;
    }
}
//把返回的数据变成json形式
function json($data)
{
    header('Content-Type:application/json');
    return json_encode($data);
}
function tpl($path)
{
//    var_dump(tpl_path($path));
    require_once(tpl_path($path));
}

function tpl_path($path)
{
    return dirname(__FILE__) . '/../ui/' . $path . '.php';
}

