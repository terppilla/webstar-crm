<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
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
            <?php foreach ($clients as $client): ?>
            <tr>
                <td><?php echo htmlspecialchars($client['name']); ?></td>
                <td><?php echo $client['phone']; ?></td>
                <td><?php echo htmlspecialchars($client['company']); ?></td>
                <td>
                    <a href="edit_client.php?id=<?php echo $client['id']; ?>" class="btn btn-sm btn-warning">✏️</a>
                    <a href="delete_client.php?id=<?php echo $client['id']; ?>" class="btn btn-sm btn-danger">🗑️</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
</body>
</html>
