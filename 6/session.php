<?php
require_once __DIR__.'\boot.php';
session_name('Kaneki');
if (registered()){
    session_start();
    if (isset($_SESSION['active']) and (time() - $_SESSION['active'] > 3600*24)) {
        unset($_SESSION['signin']);
    }
}
if (!(str_contains($_SERVER['SCRIPT_NAME'], 'login.php')||
    isAdmin()||(registered()&&signedin()))){
    redirect('login.php');
}
?>