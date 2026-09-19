<?php
$error = $this->getFlash('error');
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Погода</title>
</head>
<body>
<h1>Узнать погоду</h1>

<?php if (!empty($error)): ?>
<p style="color: red;"><?= htmlspecialchars($error, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?></p>
<?php endif; ?>

<form action="/getweather" method="get">
    <label for="city">Город:</label>
    <input type="text" id="city" name="city" placeholder="Например, Москва" required>
    <button type="submit">Запросить погоду</button>
</form>
</body>
</html>