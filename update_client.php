<?php
include 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $company = $_POST['company'];

    $sql = "UPDATE clients SET name = ?, phone = ?, company = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssi", $name, $phone, $company, $id);
    
    if ($stmt->execute()) {
        header("Location: index.php?success=1"); // Возвращаемся на главную с сообщением об успехе
        exit();
    } else {
        die("Ошибка при обновлении клиента: " . $conn->error);
    }
} else {
    die("Некорректный запрос.");
}
?>