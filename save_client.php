<?php
include 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Валидация данных
    $errors = [];
    
    $name = trim($_POST['name'] ?? '');
    if (empty($name)) {
        $errors['name'] = 'Имя обязательно для заполнения';
    } elseif (strlen($name) < 2 || strlen($name) > 50) {
        $errors['name'] = 'Имя должно быть от 2 до 50 символов';
    }
    
    $phone = preg_replace('/[^0-9]/', '', $_POST['phone'] ?? '');
    if (empty($phone)) {
        $errors['phone'] = 'Телефон обязателен для заполнения';
    } elseif (!preg_match('/^(\+7|8)\d{10}$/', $phone)) {
        $errors['phone'] = 'Неверный формат телефона';
    }
    
    $email = trim($_POST['email'] ?? '');
    if (!empty($email)) {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Неверный формат email';
        }
    }
    
    $company = trim($_POST['company'] ?? '');
    if (strlen($company) > 100) {
        $errors['company'] = 'Название компании слишком длинное';
    }
    
    if (!empty($errors)) {
        // Возвращаем пользователя обратно с сообщениями об ошибках
        session_start();
        $_SESSION['errors'] = $errors;
        $_SESSION['old'] = $_POST;
        header("Location: " . ($_SERVER['HTTP_REFERER'] ?? 'add_client.php'));
        exit();
    }
    
    $sql = "INSERT INTO clients (name, phone, email, company) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $name, $phone, $email, $company);
    $stmt->execute();
    header("Location: clients.php");
    exit();
}
?>