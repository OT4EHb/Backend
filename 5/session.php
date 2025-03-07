<?php
function registered(): bool{
    return isset($_SESSION['login']);
}
function signedin(): bool{
    return isset($_SESSION['signin']);
}
function flash(?string $message = null){
    if ($message) {
        $_SESSION['flash'] = $message;
    }
    else {
        if (!empty($_SESSION['flash'])) {
            print('
            <p class="text-center bg-primary mb-4">
                '.$_SESSION['flash'].'
            </p>');
         }
        unset($_SESSION['flash']);
    }
}
session_start();
if (isset($_SESSION['active']) and (time() - $_SESSION['active'] > 3600*24)) {
    unset($_SESSION['signin']);
}
if (!(str_contains($_SERVER['SCRIPT_NAME'],'login.php') or signedin())){
	header('Location: login.php');
	exit();
}
?>