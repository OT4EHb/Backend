<?php
function registered(): bool{
    return isset($_COOKIE[session_name()]);
}
function signedin(): bool{
    return isset($_SESSION['signin']);
}
function isAdmin(): bool{
    return !empty($_SERVER['PHP_AUTH_USER']);
}
function flash(?string $message = null){
    if ($message) {
        setcookie('flash',$message);
        $_COOKIE['flash']=$message;
    }
    else {
        if (!empty($_COOKIE['flash'])) {
            print('
            <p class="text-center bg-primary mb-4">
                '.$_COOKIE['flash'].'
            </p>');
         }
        setcookie('flash', '', strtotime("-1 day"));
        unset($_COOKIE['flash']);
    }
}
function redirect(string $path){
    header('Location: '.$path);
    exit();
}
function randomPassword($length=12): string {
    $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
    $pass = '';
    $alphaLength = strlen($alphabet) - 1;
    for ($i = 0; $i < $length; $i++) {
        $n = rand(0, $alphaLength);
        $pass.= $alphabet[$n];
    }
    return $pass;
}
function getToken(): string{
    return randomPassword(rand(50,80));
}
require_once __DIR__.'/../../../pass.php';
function checkAdmin(){
    global $db;
    $stmt=$db->prepare("SELECT * FROM admin");
    $stmt->execute();
    $admin=$stmt->fetch(PDO::FETCH_NUM);
    if (empty($_SERVER['PHP_AUTH_USER']) ||
        empty($_SERVER['PHP_AUTH_PW']) ||
        $_SERVER['PHP_AUTH_USER'] != $admin[0] ||
        !password_verify($_SERVER['PHP_AUTH_PW'], $admin[1]))
    {
        header('WWW-Authenticate: Basic realm="Это реалмно"');
        header('HTTP/1.1 401 Unanthorized');
        print('<h1>Если нажмешь "Отмена" суммарно 1000 раз я всё таки впущу тебя</h1>');
        exit();
    }
    return TRUE;
}
if (isAdmin()){
    checkAdmin();
}
$token=getToken();
setcookie('token', $token);
?>