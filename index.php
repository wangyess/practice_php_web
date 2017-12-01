<?php
require_once ('helper/helper.php');
$uri = $_SERVER['REQUEST_URI'];

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
