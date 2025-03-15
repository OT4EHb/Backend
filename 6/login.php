<?php
require_once __DIR__.'/../../../pass.php';
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
?>