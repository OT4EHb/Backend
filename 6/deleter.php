<?php
require_once __DIR__ . '/session.php';
header('Content-Type: text/html; charset=UTF-8');
if (empty($_GET['numer']) or empty($_GET['token']) or $_GET['token'] != $_COOKIE['token']) {
    redirect('./');
}
try {
    $stmt = $db->prepare("DELETE FROM app_langs WHERE id_app=?");
    $stmt->execute([$_GET['numer']]);
    $stmt = $db->prepare("DELETE FROM app_users WHERE id_app=?");
    $stmt->execute([$_GET['numer']]);
    $stmt = $db->prepare("DELETE FROM applications WHERE id_app=?");
    $stmt->execute([$_GET['numer']]);
} catch (PDOException $e) {
    flash('Error : ' . $e->getMessage());
    redirect('./');
}
flash('Успешно');
redirect('./');
?>