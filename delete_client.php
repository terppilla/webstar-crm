<?php
include 'db_connect.php';

if (!isset($_GET['id'])) {
    die("Ошибка: ID клиента не указан.");
}

$id = $_GET['id'];
$sql = "DELETE FROM clients WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    header("Location: index.php?deleted=1"); // Возвращаемся на главную с сообщением об успехе
    exit();
} else {
    die("Ошибка при удалении клиента: " . $conn->error);
}
?>