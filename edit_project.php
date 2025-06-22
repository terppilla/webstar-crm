<?php
include 'db_connect.php';

// Получаем данные проекта для редактирования
$project_id = $_GET['id'];
$project = $conn->query("SELECT * FROM projects WHERE id = $project_id")->fetch_assoc();

// Получаем список клиентов
$clients = $conn->query("SELECT id, name FROM clients")->fetch_all(MYSQLI_ASSOC);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $client_id = $_POST['client_id'];
    $service = $_POST['service'];
    $status = $_POST['status'];
    
    $sql = "UPDATE projects SET title=?, client_id=?, service=?, status=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sissi", $title, $client_id, $service, $status, $project_id);
    $stmt->execute();
    
    header("Location: projects.php");
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Редактировать проект</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2>Редактировать проект</h2>
    <form method="POST" id="editProjectForm" novalidate>
    <div class="mb-3">
        <label class="form-label">Название проекта*</label>
        <input type="text" name="title" class="form-control" 
               value="<?= htmlspecialchars($project['title']) ?>" 
               required minlength="3" maxlength="100">
        <div class="invalid-feedback">Название проекта должно содержать от 3 до 100 символов.</div>
    </div>
        <div class="mb-3">
            <label class="form-label">Клиент*</label>
            <select name="client_id" class="form-select" required>
                <?php foreach ($clients as $client): ?>
                    <option value="<?= $client['id'] ?>" <?= $client['id'] == $project['client_id'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($client['name']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">Услуга*</label>
            <select name="service" class="form-select" required>
                <option value="Сайт" <?= $project['service'] == 'Сайт' ? 'selected' : '' ?>>Сайт</option>
                <option value="SEO" <?= $project['service'] == 'SEO' ? 'selected' : '' ?>>SEO</option>
                <option value="Реклама" <?= $project['service'] == 'Реклама' ? 'selected' : '' ?>>Реклама</option>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">Статус*</label>
            <select name="status" class="form-select" required>
                <option value="В работе" <?= $project['status'] == 'В работе' ? 'selected' : '' ?>>В работе</option>
                <option value="Завершен" <?= $project['status'] == 'Завершен' ? 'selected' : '' ?>>Завершен</option>
                <option value="Отменен" <?= $project['status'] == 'Отменен' ? 'selected' : '' ?>>Отменен</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Сохранить</button>
    </form>
</div>
<script>
// Валидация формы на стороне клиента
document.getElementById('editProjectForm').addEventListener('submit', function(event) {
    if (!this.checkValidity()) {
        event.preventDefault();
        event.stopPropagation();
    }
    this.classList.add('was-validated');
}, false);
</script>
</body>
</html>