<?php
header('Content-Type: text/html; charset=UTF-8');
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
	$messages=array();
	exit();
}
$errors = array();
  $errors['fio'] = !empty($_COOKIE['fio_error']);
include("form.php");
////
$values = array();
$values['fio'] = empty($_COOKIE['fio_value']) ? '' : $_COOKIE['fio_value'];

$errors = FALSE;

if (strlen($_POST['FIO'])>150) {
	print('ФИО слишком длинное.<br/>');
	$errors = TRUE;
}

if (preg_match('~[0-9]+~', $_POST['FIO'])) {
    print('ФИО не должно содержать цифры.<br/>');
	$errors = TRUE;
}

if (!preg_match('/^[0-9]{10}+$/', $_POST['tel'])) {
	print('Номер должен содержать ровно 10 цифр.<br/>');
	$errors = TRUE;
}

if (!preg_match('~@~', $_POST['email'])) {
	print('Email должен содержать \'@\'.<br/>');
	$errors = TRUE;
}

$year =(int)substr($_POST['DR'],0,4);
if($year<1800){
	print('Вы долгожитель?<br/>');
	$errors = TRUE;
} elseif ($year>2025) {
	print('Вы из будущего?<br/>');
	$errors = TRUE;
}

if (empty($_POST['lang'])){
	print('Выберите хотя бы JavaScript<br/>');
	$errors = TRUE;
}

if (strlen($_POST['bio'])>200){
	print('Ваша биография трогает душу...<br/>Но уменьшите её (душу)<br/>');
	$errors = TRUE;
}

if ($errors) {
  exit();
}

include("../../../pass.php");
$db = new PDO("mysql:host=localhost;dbname=$dbname", $user, $pass,
  [PDO::ATTR_PERSISTENT => true, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);

try {
	$stmt = $db->prepare("INSERT INTO applications VALUES (0, ?, ?, ?, ?, ?, ?)");
	$stmt -> execute([$_POST['FIO'], $_POST['tel'], $_POST['email'],
					$_POST['DR'], $_POST['sex'], $_POST['bio']]);
	$id_app = $db -> lastInsertId();
	foreach($data->lang as $value) {
		$stmt = $db->prepare("INSERT INTO app_langs VALUES (?, ?)");
		$stmt -> execute([$id_app,$value]);
	}
}
catch(PDOException $e){
  print('Error : ' . $e->getMessage());
  exit();
}

print("Успешно<br/>");
?>
