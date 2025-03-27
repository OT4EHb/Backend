<?php
require_once __DIR__ . '/boot.php';
if (checkAdmin()) {
    redirect('./');
}
?>