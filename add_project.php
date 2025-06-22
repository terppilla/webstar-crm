<?php
session_start();
if (isset($_SESSION['errors'])) {
    foreach ($_SESSION['errors'] as $field => $message) {
        echo '<div class="alert alert-danger">' . htmlspecialchars($message) . '</div>';
    }
    unset($_SESSION['errors']);
}
if (isset($_SESSION['old'])) {
    $old = $_SESSION['old'];
    unset($_SESSION['old']);
}
?>
<?php
include 'db_connect.php';

// Получаем список клиентов для выпадающего списка
$clients = $conn->query("SELECT id, name FROM clients")->fetch_all(MYSQLI_ASSOC);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Валидация данных
    $errors = [];
    
    $title = trim($_POST['title'] ?? '');
    if (empty($title)) {
        $errors['title'] = 'Название проекта обязательно';
    } elseif (strlen($title) < 3 || strlen($title) > 100) {
        $errors['title'] = 'Название должно быть от 3 до 100 символов';
    }
    
    $client_id = $_POST['client_id'] ?? '';
    if (empty($client_id)) {
        $errors['client_id'] = 'Выберите клиента';
    }
    
    $service = $_POST['service'] ?? '';
    if (empty($service)) {
        $errors['service'] = 'Выберите услугу';
    }
    
    $status = $_POST['status'] ?? '';
    if (empty($status)) {
        $errors['status'] = 'Выберите статус';
    }
    
    if (!empty($errors)) {
        $_SESSION['errors'] = $errors;
        $_SESSION['old'] = $_POST;
        header("Location: add_project.php");
        exit();
    }
    
    $sql = "INSERT INTO projects (title, client_id, service, status) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("siss", $title, $client_id, $service, $status);
    
    if ($stmt->execute()) {
        header("Location: projects.php?success=1");
        exit();
    } else {
        die("Ошибка при добавлении проекта: " . $conn->error);
    }
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Добавить проект</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .was-validated .form-control:invalid,
        .form-control.is-invalid {
            border-color: #dc3545;
        }
        .was-validated .form-control:valid,
        .form-control.is-valid {
            border-color: #28a745;
        }
        .invalid-feedback {
            display: none;
            width: 100%;
            margin-top: 0.25rem;
            font-size: 0.875em;
            color: #dc3545;
        }
        .was-validated .form-control:invalid ~ .invalid-feedback,
        .form-control.is-invalid ~ .invalid-feedback {
            display: block;
        }
        .was-validated .form-select:invalid ~ .invalid-feedback,
        .form-select.is-invalid ~ .invalid-feedback {
            display: block;
        }
    </style>
</head>
<body>
<div class="container mt-5">
    <a href="projects.php" class="btn btn-secondary mb-3">← Назад к проектам</a>
    <h2>Добавить проект</h2>
    
    <?php if (isset($_GET['success'])): ?>
        <div class="alert alert-success">Проект успешно добавлен!</div>
    <?php endif; ?>
    
    <form method="POST" id="projectForm" novalidate>
        <div class="mb-3">
            <label class="form-label">Название проекта*</label>
            <input type="text" name="title" class="form-control" 
                   value="<?= isset($old['title']) ? htmlspecialchars($old['title']) : '' ?>" 
                   required minlength="3" maxlength="100">
            <div class="invalid-feedback">Название проекта должно содержать от 3 до 100 символов.</div>
        </div>
        
        <div class="mb-3">
            <label class="form-label">Клиент*</label>
            <select name="client_id" class="form-select" required>
                <option value="">Выберите клиента</option>
                <?php foreach ($clients as $client): ?>
                    <option value="<?= $client['id'] ?>" 
                        <?= isset($old['client_id']) && $old['client_id'] == $client['id'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($client['name']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <div class="invalid-feedback">Пожалуйста, выберите клиента.</div>
        </div>
        
        <div class="mb-3">
            <label class="form-label">Услуга*</label>
            <select name="service" class="form-select" required>
                <option value="">Выберите услугу</option>
                <option value="Сайт" <?= isset($old['service']) && $old['service'] == 'Сайт' ? 'selected' : '' ?>>Сайт</option>
                <option value="SEO" <?= isset($old['service']) && $old['service'] == 'SEO' ? 'selected' : '' ?>>SEO</option>
                <option value="Реклама" <?= isset($old['service']) && $old['service'] == 'Реклама' ? 'selected' : '' ?>>Реклама</option>
            </select>
            <div class="invalid-feedback">Пожалуйста, выберите услугу.</div>
        </div>
        
        <div class="mb-3">
            <label class="form-label">Статус*</label>
            <select name="status" class="form-select" required>
                <option value="">Выберите статус</option>
                <option value="В работе" <?= isset($old['status']) && $old['status'] == 'В работе' ? 'selected' : '' ?>>В работе</option>
                <option value="Завершен" <?= isset($old['status']) && $old['status'] == 'Завершен' ? 'selected' : '' ?>>Завершен</option>
                <option value="Отменен" <?= isset($old['status']) && $old['status'] == 'Отменен' ? 'selected' : '' ?>>Отменен</option>
            </select>
            <div class="invalid-feedback">Пожалуйста, выберите статус.</div>
        </div>
        
        <button type="submit" class="btn btn-primary">Сохранить</button>
    </form>
</div>

<script>
// Валидация формы на стороне клиента
document.getElementById('projectForm').addEventListener('submit', function(event) {
    if (!this.checkValidity()) {
        event.preventDefault();
        event.stopPropagation();
    }
    this.classList.add('was-validated');
}, false);
</script>
</body>
</html>