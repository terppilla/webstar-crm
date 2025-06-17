<?php
// Подключаемся к базе данных
include 'db_connect.php';

// Получаем список клиентов из базы данных
$sql = "SELECT * FROM clients";
$result = $conn->query($sql);

// Проверяем, есть ли результаты
if ($result && $result->num_rows > 0) {
    $clients = $result->fetch_all(MYSQLI_ASSOC);
} else {
    $clients = []; // Если клиентов нет, создаем пустой массив
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Список клиентов</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2>Клиенты</h2>
    
    <!-- Поиск -->
    <form class="mb-3">
        <input type="text" class="form-control" placeholder="Поиск по имени или телефону" id="search">
    </form>

    <!-- Кнопка добавления -->
    <a href="add_client.php" class="btn btn-primary mb-3">+ Добавить клиента</a>

    <!-- Таблица клиентов -->
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Имя</th>
                <th>Телефон</th>
                <th>Компания</th>
                <th>Действия</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($clients)): ?>
                <?php foreach ($clients as $client): ?>
                <tr>
                    <td><?php echo htmlspecialchars($client['name']); ?></td>
                    <td><?php echo htmlspecialchars($client['phone']); ?></td>
                    <td><?php echo htmlspecialchars($client['company']); ?></td>
                    <td>
                        <a href="edit_client.php?id=<?php echo $client['id']; ?>" class="btn btn-sm btn-warning">✏️</a>
                        <a href="delete_client.php?id=<?php echo $client['id']; ?>" class="btn btn-sm btn-danger">🗑️</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="4" class="text-center">Нет данных о клиентах</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
</body>
</html>