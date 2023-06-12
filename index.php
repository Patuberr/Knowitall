<?php 

//lees request uit
$request = $_SERVER['REQUEST_URI'];
$url = parse_url($request);
switch($url["path"]) {
    case "/":
        require __DIR__ .'/views/index.php';
        break;
    case "":
        require __DIR__ .'/views/index.php';
        break;
    case "/contact":
        require __DIR__ .'/views/contact.php';
        break;
    case "/weetjes":
        require __DIR__ .'/views/weetjes.php';
        break;
    case "/panel":
        require __DIR__ .'/views/panel.html';
        break;
    default:
        http_response_code(404);
        require __DIR__ .'/views/404.php';
        break;
}


?>
