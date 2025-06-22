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
    <form method="POST" action="save_client.php" id="clientForm" novalidate>
    <div class="mb-3">
        <label class="form-label">Имя*</label>
        <input type="text" name="name" class="form-control" required minlength="2" maxlength="50">
        <div class="invalid-feedback">Пожалуйста, введите имя (от 2 до 50 символов).</div>
    </div>
    <div class="mb-3">
        <label class="form-label">Телефон*</label>
        <input type="tel" name="phone" class="form-control" placeholder="89121234567" required 
               pattern="^(\+7|8)\d{10}$">
        <div class="invalid-feedback">Пожалуйста, введите корректный номер телефона (начинается с 8 или +7, 11 цифр).</div>
    </div>
    <div class="mb-3">
        <label class="form-label">Email</label>
        <input type="email" name="email" class="form-control" 
               pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$">
        <div class="invalid-feedback">Пожалуйста, введите корректный email.</div>
    </div>
    <div class="mb-3">
        <label class="form-label">Компания</label>
        <input type="text" name="company" class="form-control" maxlength="100">
        <div class="invalid-feedback">Максимальная длина названия компании - 100 символов.</div>
    </div>
    <button type="submit" class="btn btn-primary">Сохранить</button>
</form>
</div>

<script>
// Валидация формы на стороне клиента
document.getElementById('clientForm').addEventListener('submit', function(event) {
    if (!this.checkValidity()) {
        event.preventDefault();
        event.stopPropagation();
    }
    this.classList.add('was-validated');
}, false);
</script>
</body>
</html>