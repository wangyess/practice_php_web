<?php
require_once('helper/helper.php');
require_once('admin/gateway.php');
$uri = $_SERVER['REQUEST_URI'];
if (strpos($uri, '/a/') !== false) {
    echo get_page_input($uri);
    return;
}
switch ($uri) {
    case '/':
        tpl('home');
        break;
    case '/adm/product':
        tpl('product');
        break;
    case '/adm/cat':
        tpl('cat');
        break;
    case '/login':
        tpl('login');
        break;
    case '/signup':
        tpl('signup');
        break;
    case '/logout':
        tpl('logout');
        break;
    default:
        http_response_code(404);
        die('404 找不到');
}

//switch ($uri) {
//    case'/' :
//        require_once('ui/home.php');
//        break;
//    case '/adm/cat';
//        require_once('ui/cat.php');
//        break;
//    case '/adm/product';
//        require_once('ui/product.php');
//        break;
//    default:
//        http_response_code(404);
//        die('404');
//        break;
//}
