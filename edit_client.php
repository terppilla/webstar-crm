<?php
include 'db_connect.php';

// Проверяем, передан ли ID клиента
if (!isset($_GET['id'])) {
    die("Ошибка: ID клиента не указан.");
}

$id = $_GET['id'];
$sql = "SELECT * FROM clients WHERE id = $id";
$result = $conn->query($sql);

if (!$result || $result->num_rows === 0) {
    die("Клиент не найден.");
}

$client = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Редактировать клиента</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2>Редактировать клиента</h2>
    <form action="update_client.php" method="POST">
        <input type="hidden" name="id" value="<?php echo $client['id']; ?>">
        
        <div class="mb-3">
            <label class="form-label">Имя</label>
            <input type="text" class="form-control" name="name" value="<?php echo htmlspecialchars($client['name']); ?>" required>
        </div>
        
        <div class="mb-3">
            <label class="form-label">Телефон</label>
            <input type="text" class="form-control" name="phone" value="<?php echo htmlspecialchars($client['phone']); ?>" required>
        </div>
        
        <div class="mb-3">
            <label class="form-label">Компания</label>
            <input type="text" class="form-control" name="company" value="<?php echo htmlspecialchars($client['company']); ?>">
        </div>
        
        <button type="submit" class="btn btn-primary">Сохранить</button>
        <a href="index.php" class="btn btn-secondary">Отмена</a>
    </form>
</div>
</body>
</html>