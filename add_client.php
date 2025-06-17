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
    <h2>Добавить клиента</h2>
    <form method="POST" action="save_client.php">
        <div class="mb-3">
            <label class="form-label">Имя*</label>
            <input type="text" name="name" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Телефон*</label>
            <input type="tel" name="phone" class="form-control" placeholder="89121234567" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control">
        </div>
        <div class="mb-3">
            <label class="form-label">Компания</label>
            <input type="text" name="company" class="form-control">
        </div>
        <button type="submit" class="btn btn-primary">Сохранить</button>
    </form>
</div>
</body>
</html>