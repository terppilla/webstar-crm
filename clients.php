<?php
include 'db_connect.php';

// Автоматическое обновление страницы каждые 30 секунд
header("Refresh: 30");

// Получаем список клиентов
$sql = "SELECT * FROM clients";
$result = $conn->query($sql);
$clients = $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Клиенты</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <!-- Кнопка возврата на главную -->
    <a href="index.php" class="btn btn-secondary mb-3">← На главную</a>
    
    <h2>Клиенты</h2>
    
    <!-- Поиск и добавление -->
    <div class="d-flex justify-content-between mb-3">
        <form class="w-50">
            <input type="text" class="form-control" placeholder="Поиск по имени или телефону" id="search">
        </form>
        <a href="add_client.php" class="btn btn-primary">+ Добавить клиента</a>
    </div>

    <!-- Таблица клиентов -->
    <div class="table-responsive">
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
</div>

<script>
// Автоматический поиск при вводе текста
document.getElementById('search').addEventListener('input', function() {
    const searchText = this.value.toLowerCase();
    const rows = document.querySelectorAll('tbody tr');
    
    rows.forEach(row => {
        const name = row.cells[0].textContent.toLowerCase();
        const phone = row.cells[1].textContent.toLowerCase();
        if (name.includes(searchText) || phone.includes(searchText)) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
});
</script>
</body>
</html>