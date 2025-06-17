<?php
include 'db_connect.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $phone = preg_replace('/[^0-9]/', '', $_POST['phone']);
    $email = $_POST['email'] ?? null;
    $company = $_POST['company'] ?? null;

    $sql = "INSERT INTO clients (name, phone, email, company) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $name, $phone, $email, $company);
    $stmt->execute();
    header("Location: clients.php");
}
?>