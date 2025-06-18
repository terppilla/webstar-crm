<?php
include 'db_connect.php';

// Получаем список проектов с именами клиентов
$sql = "SELECT p.id, p.title, c.name AS client_name, p.service, p.status 
        FROM projects p 
        LEFT JOIN clients c ON p.client_id = c.id";
$result = $conn->query($sql);
$projects = $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Проекты</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2>Проекты</h2>
    
    <!-- Кнопка добавления -->
    <a href="add_project.php" class="btn btn-primary mb-3">+ Добавить проект</a>

    <!-- Таблица проектов -->
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Название</th>
                <th>Клиент</th>
                <th>Услуга</th>
                <th>Статус</th>
                <th>Действия</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($projects as $project): ?>
            <tr>
                <td><?= htmlspecialchars($project['title']) ?></td>
                <td><?= htmlspecialchars($project['client_name']) ?></td>
                <td>
                    <span class="badge bg-<?= 
                        $project['service'] == 'Сайт' ? 'info' : 
                        ($project['service'] == 'SEO' ? 'success' : 'primary') 
                    ?>">
                        <?= $project['service'] ?>
                    </span>
                </td>
                <td>
                    <span class="badge bg-<?= 
                        $project['status'] == 'В работе' ? 'warning' : 
                        ($project['status'] == 'Завершен' ? 'success' : 'secondary') 
                    ?>">
                        <?= $project['status'] ?>
                    </span>
                </td>
                <td>
                    <a href="edit_project.php?id=<?= $project['id'] ?>" class="btn btn-sm btn-warning">✏️</a>
                    <a href="delete_project.php?id=<?= $project['id'] ?>" class="btn btn-sm btn-danger">🗑️</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
</body>
</html>