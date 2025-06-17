<?php
$host = 'localhost';
$user = 'root';
$password = '';
$database = 'webstar_crm';

$conn = new mysqli($host, $user, $password, $database);
if ($conn->connect_error) {
    die("Ошибка подключения: " . $conn->connect_error);
}
?>