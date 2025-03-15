<?php
require_once __DIR__.'/login.php';
header('Content-Type: text/html; charset=UTF-8');
if (empty($_GET['numer'])){
	header('Location: index.php');
	exit();
}
try {
	$stmt=$db->prepare("DELETE FROM app_langs WHERE id_app=?");
	$stmt->execute([$_GET['numer']]);
	$stmt=$db->prepare("DELETE FROM app_users WHERE id_app=?");
	$stmt->execute([$_GET['numer']]);
	$stmt=$db->prepare("DELETE FROM applications WHERE id_app=?");
	$stmt->execute([$_GET['numer']]);
}
catch(PDOException $e){
	flash('Error : ' . $e->getMessage());
	header('Location: index.php');
	exit();
}
flash('Успешно');
header('Location: index.php');
exit();
?>