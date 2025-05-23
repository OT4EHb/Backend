<?php
header('Content-Type: text/html; charset=UTF-8');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $error = FALSE;

    if (strlen($_POST['FIO']) > 150) {
        setcookie('fio_error', 'ФИО слишком длинное.');
        $error = TRUE;
    } elseif (preg_match('~[0-9]+~', $_POST['FIO'])) {
        setcookie('fio_error', 'ФИО не должно содержать цифры.');
        $error = TRUE;
    } else {
        setcookie('fio_error', '', strtotime("-1 day"));
    }
    setcookie('fio_value', $_POST['FIO'], strtotime('+1 year'));

    if (!preg_match('/^[0-9]{10}$/', $_POST['tel'])) {
        setcookie('tel_error', 'Номер должен содержать ровно 10 цифр.');
        $error = TRUE;
    } else {
        setcookie('tel_error', '', strtotime("-1 day"));
    }
    setcookie('tel_value', $_POST['tel'], strtotime('+1 year'));

    if (!preg_match('~@~', $_POST['email'])) {
        setcookie('email_error', 'Email должен содержать \'@\'.');
        $error = TRUE;
    } else {
        setcookie('email_error', '', strtotime("-1 day"));
    }
    setcookie('email_value', $_POST['email'], strtotime('+1 year'));

    $year = intval(substr($_POST['DR'], 0, 4));
    if ($year < 1800) {
        setcookie('dr_error', 'Вы долгожитель?');
        $error = TRUE;
    } elseif ($year > 2025) {
        setcookie('dr_error', 'Вы из будущего?');
        $error = TRUE;
    } else {
        setcookie('dr_error', '', strtotime("-1 day"));
    }
    setcookie('dr_value', $_POST['DR'], strtotime('+1 year'));

    if (!is_array($_POST['lang'])) {
        $_POST['lang'] = array();
    }
    foreach ($_POST['lang'] as $k => $v) {
        if (intval($v) < 1 || intval($v) > 11)
            unset($_POST['lang'][$k]);
    }
    if (empty($_POST['lang'])) {
        setcookie('lang_error', 'Выберите хотя бы JavaScript');
        setcookie('lang_value', '', strtotime('-1 day'));
        $error = TRUE;
    } else {
        setcookie('lang_error', '', strtotime("-1 day"));
        setcookie('lang_value', implode('|', ($_POST['lang'])), strtotime('+1 year'));
    }

    if (!preg_match('/^[0, 1]$/', $_POST['sex'])) {
        setcookie('sex_error', "Ты как это сделал?");
        $error = TRUE;
    } else {
        setcookie('sex_error', '', strtotime("-1 day"));
    }
    setcookie('sex_value', $_POST['sex'], strtotime('+1 year'));

    if (strlen($_POST['bio']) > 200) {
        setcookie('bio_error', 'Ваша биография трогает душу...<br/>Но уменьшите её (душу)');
        $error = TRUE;
    } else {
        setcookie('bio_error', '', strtotime("-1 day"));
    }
    setcookie('bio_value', $_POST['bio'], strtotime('+1 year'));

    if ($error) {
        header('Location: index.php');
        exit();
    }

    include("../../../pass.php");
    $db = new PDO(
        "mysql:host=localhost;dbname=$dbname",
        $user,
        $pass,
        [PDO::ATTR_PERSISTENT => true, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );

    try {
        $stmt = $db->prepare("INSERT INTO applications VALUES (0, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([
            $_POST['FIO'],
            $_POST['tel'],
            $_POST['email'],
            $_POST['DR'],
            $_POST['sex'],
            $_POST['bio']
        ]);
        $id_app = $db->lastInsertId();
        foreach ($_POST['lang'] as $value) {
            $stmt = $db->prepare("INSERT INTO app_langs VALUES (?, ?)");
            $stmt->execute([$id_app, $value]);
        }
    } catch (PDOException $e) {
        setcookie('DBerror', 'Error : ' . $e->getMessage());
        header('Location: index.php');
        exit();
    }

    setcookie('save', 'Успешно');
    header('Location: index.php');
    exit();
}

include("form.php");
?>