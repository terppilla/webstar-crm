<?php
include 'db_connect.php';

// Автоматическое обновление страницы каждые 30 секунд
header("Refresh: 30");

$total_clients = $conn->query("SELECT COUNT(*) FROM clients")->fetch_row()[0];
$active_projects = $conn->query("SELECT COUNT(*) FROM projects WHERE status='В работе'")->fetch_row()[0];
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>WebStar CRM</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <h1 class="text-center mb-4">WebStar CRM</h1>
        
        <!-- Статистика с автоматическим обновлением -->
        <div class="row mb-4">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Клиенты</h5>
                        <p class="display-4" id="client-count"><?= $total_clients ?></p>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Активные проекты</h5>
                        <p class="display-4" id="project-count"><?= $active_projects ?></p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Кнопки навигации -->
        <div class="d-grid gap-2">
            <a href="clients.php" class="btn btn-primary btn-lg">Клиенты</a>
            <a href="projects.php" class="btn btn-success btn-lg">Проекты</a>
        </div>
    </div>

    <script>
    // AJAX-обновление счетчиков без перезагрузки страницы
    function updateCounters() {
        fetch('api/get_counts.php')
            .then(response => response.json())
            .then(data => {
                document.getElementById('client-count').textContent = data.total_clients;
                document.getElementById('project-count').textContent = data.active_projects;
            });
    }

    // Обновляем каждые 10 секунд
    setInterval(updateCounters, 10000);
    </script>
</body>
</html>