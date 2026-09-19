<?php
/** @var ?string $message*/
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>500 — Ошибка сервера</title>
</head>
<body>
<h1>500 — Ошибка сервера</h1>
<p>Что-то пошло не так. Попробуйте позже</p>
<p><strong>DEV</strong> Сообщение об ошибке: <?= $message?></p>

<a href="/">На главную</a>
</body>
</html>