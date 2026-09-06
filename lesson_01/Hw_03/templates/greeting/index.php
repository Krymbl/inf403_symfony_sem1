<?php
/** @var \Hw_03\DTO\UserDto|null $user */

$user ??= null;
$success = $this->getFlash('success');
$error = $this->getFlash('error');
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Приветствие</title>
</head>
<body>

<?php if ($success !== null): ?>
    <p><strong><?= $this->e($success) ?></strong></p>
<?php endif; ?>

<?php if ($error !== null): ?>
    <p><strong><?= $this->e($error) ?></strong></p>
<?php endif; ?>

<?php if ($user !== null): ?>
    <h1>
        Добро пожаловать, <?= $this->e($user->name) ?>!
        Ваш возраст: <?= $this->e($user->age) ?>,
        email: <?= $this->e($user->email) ?>
    </h1>

    <form method="post" action="/logout">
        <input type="hidden" name="csrf_token" value="<?= $this->e($this->getCsrfToken()) ?>">
        <button type="submit">Выйти</button>
    </form>
<?php else: ?>
    <h1>Здравствуйте, гость</h1>
    <p><a href="/register">Зарегистрироваться</a></p>
<?php endif; ?>

</body>
</html>