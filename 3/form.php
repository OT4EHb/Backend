<?php
header('Content-Type: text/html; charset=UTF-8');
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
	print("<h1>Вы ошиблись адресом</h1>");
	print("<h2>Форма не на form.php</h2>");
	exit();
}

$json = file_get_contents('php://input');
$data = json_decode($json);
$errors = FALSE;

if (strlen($data->FIO)>150) {
	print('ФИО слишком длинное.<br/>');
	$errors = TRUE;
}

if (preg_match('~[0-9]+~', $data->FIO)) {
    print('ФИО не должно содержать цифры.<br/>');
	$errors = TRUE;
}

if (!preg_match('/^[0-9]{10}+$/', $data->tel)) {
	print('Номер должен содержать ровно 10 цифр.<br/>');
	$errors = TRUE;
}

if (!preg_match('~@~',$data->email)) {
	print('Email должен содержать \'@\'.<br/>');
	$errors = TRUE;
}

$year =(int)substr($data->DR,0,4);
if($year<1800){
	print('Вы долгожитель?<br/>');
	$errors = TRUE;
} elseif ($year>2025) {
	print('Вы из будущего?<br/>');
	$errors = TRUE;
}

if (empty($data->lang)){
	print('Выберите хотя бы JavaScript<br/>');
	$errors = TRUE;
}

if (strlen($data->bio)>200){
	print('Ваша биография трогает душу...<br/>Но уменьшите её<br/>');
	$errors = TRUE;
}

if (empty($data->bio)){
	print('Если вы ничего о себе не расскажите ваши данные будут дешевле проданы😞<br/>');
}

if ($errors) {
  exit();
}

include("../../../pass.php");
$db = new PDO("mysql:host=localhost;dbname=$dbname", $user, $pass,
  [PDO::ATTR_PERSISTENT => true, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);

try {
	$stmt = $db->prepare("INSERT INTO applications VALUES (0,:FIO,:tel,:email,:DR,:sex,:bio)");
	$stmt -> execute(['FIO'=>$data->FIO, 'tel'=>$data->tel, 'email'=>$data->email,
					'DR'=>$data->DR, 'sex'=>$data->sex, 'bio'=>$data->bio]);
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
