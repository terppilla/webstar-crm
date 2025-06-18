<?php
include 'db_connect.php';

// Получаем список клиентов для выпадающего списка
$clients = $conn->query("SELECT id, name FROM clients")->fetch_all(MYSQLI_ASSOC);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $client_id = $_POST['client_id'];
    $service = $_POST['service'];
    $status = $_POST['status'];
    
    $sql = "INSERT INTO projects (title, client_id, service, status) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("siss", $title, $client_id, $service, $status);
    $stmt->execute();
    
    header("Location: projects.php");
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Добавить проект</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2>Добавить проект</h2>
    <form method="POST">
        <div class="mb-3">
            <label class="form-label">Название проекта*</label>
            <input type="text" name="title" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Клиент*</label>
            <select name="client_id" class="form-select" required>
                <option value="">Выберите клиента</option>
                <?php foreach ($clients as $client): ?>
                    <option value="<?= $client['id'] ?>"><?= htmlspecialchars($client['name']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">Услуга*</label>
            <select name="service" class="form-select" required>
                <option value="Сайт">Сайт</option>
                <option value="SEO">SEO</option>
                <option value="Реклама">Реклама</option>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">Статус*</label>
            <select name="status" class="form-select" required>
                <option value="В работе">В работе</option>
                <option value="Завершен">Завершен</option>
                <option value="Отменен">Отменен</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Сохранить</button>
    </form>
</div>
</body>
</html>