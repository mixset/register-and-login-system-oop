<?php

if(isset($_GET['page'])) {
    $page = strip_tags($_GET['page']);
} else {
    $page = null;
}

switch($page)
{
    case 'main':
        require 'main.php';
    break;
 
    case 'register':
        require 'register.php';
    break;

    case 'login';
        require 'login.php';
    break;

    case 'user_panel':
        require 'user_panel.php';
    break;


    case 'register_action':
    {
        $register = new Auth($pdo);
        $result = $register -> register(['login' => $_POST['login'], 'password' => $_POST['password'], 'email' => $_POST['email']]);
        echo (is_array($result) && $result[1] == true) ? $result[0] : $result;
    }
    break;

    case 'login_action':
    {
        $login = new Auth($pdo, $session);
        $result = $login -> login(['login' => $_POST['login'], 'password' => $_POST['password']]);

        if(is_array($result) && $result[1] == true)
        {
            echo $result[0];
            header("Refresh:2;URL=?page=user_panel");
        } else {
            echo $result;
        }
    }
    break;
 
    case 'logout':
    {
        $login = new Auth($pdo);
        $login -> logout();
    }
    break;

    default:
        require 'main.php';
    break;
}

?>