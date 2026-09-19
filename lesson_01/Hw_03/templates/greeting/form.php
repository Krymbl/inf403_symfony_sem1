<?php
/** @var \Hw_03\DTO\UserDto|null $dto */
/** @var array<string, string[]> $errors */

$dto ??= null;
$errors ??= [];
$error = $this->getFlash('error');
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Регистрация</title>
</head>
<body>
<h1>Регистрация</h1>

<?php if ($error !== null): ?>
    <p><strong><?= $this->e($error) ?></strong></p>
<?php endif; ?>

<form method="post" action="/register">
    <input type="hidden" name="csrf_token" value="<?= $this->e($this->getCsrfToken()) ?>">
    <p>
        <label>Имя:<br>
            <input type="text" name="name" value="<?= $this->e($dto->name ?? '') ?>" required>
        </label>
        <?php foreach ($errors['name'] ?? [] as $message): ?>
            <br><span style="color: red"><?= $this->e($message) ?></span>
        <?php endforeach; ?>
    </p>

    <p>
        <label>Возраст:<br>
            <input type="number" name="age" value="<?= $this->e($dto->age ?? '') ?>" required min="1" max="120">
        </label>
        <?php foreach ($errors['age'] ?? [] as $message): ?>
            <br><span style="color: red"><?= $this->e($message) ?></span>
        <?php endforeach; ?>
    </p>

    <p>
        <label>Email:<br>
            <input type="text" name="email" value="<?= $this->e($dto->email ?? '') ?>" required>
        </label>
        <?php foreach ($errors['email'] ?? [] as $message): ?>
            <br><span style="color: red"><?= $this->e($message) ?></span>
        <?php endforeach; ?>
    </p>

    <button type="submit">Зарегистрироваться</button>
</form>

<p><a href="/greeting">На главную</a></p>
</body>
</html>