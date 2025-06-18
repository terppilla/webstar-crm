<?php
include 'db_connect.php';

// Автоматическое обновление страницы каждые 30 секунд
header("Refresh: 30");

// Получаем список проектов
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
    <!-- Кнопка возврата на главную -->
    <a href="index.php" class="btn btn-secondary mb-3">← На главную</a>
    
    <h2>Проекты</h2>
    
    <!-- Поиск и добавление -->
    <div class="d-flex justify-content-between mb-3">
        <form class="w-50">
            <input type="text" class="form-control" placeholder="Поиск по названию проекта" id="search">
        </form>
        <a href="add_project.php" class="btn btn-primary">+ Добавить проект</a>
    </div>

    <!-- Таблица проектов -->
    <div class="table-responsive">
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
</div>

<script>
// Автоматический поиск при вводе текста
document.getElementById('search').addEventListener('input', function() {
    const searchText = this.value.toLowerCase();
    const rows = document.querySelectorAll('tbody tr');
    
    rows.forEach(row => {
        const title = row.cells[0].textContent.toLowerCase();
        const client = row.cells[1].textContent.toLowerCase();
        if (title.includes(searchText) || client.includes(searchText)) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
});
</script>
</body>
</html>