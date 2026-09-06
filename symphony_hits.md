# Установка Composer

```
php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"

php composer-setup.php

php -r "unlink('composer-setup.php');"
```

---

# Установка окружения для работы с SQLite

В .env:
`DATABASE_URL="sqlite:///%kernel.project_dir%/var/data.db"`

%kernel.project_dir% — это Symfony-переменная, которая резолвится в абсолютный путь к корню проекта, чтобы путь к файлу
БД не зависел от того, откуда именно запущена консоль.

### Создание базы данных через консоль

Он сам создаст файл при миграции

---

# Установка Symfony

1. Скачать scoop

```
Set-ExecutionPolicy -ExecutionPolicy RemoteSigned -Scope CurrentUser
Invoke-RestMethod -Uri https://get.scoop.sh | Invoke-Expression
```

2. scoop install symfony-cli

---

## Создание проекта и требования

https://symfony.com/download

`symfony new my_project --webapp`

`composer create-project symfony/skeleton my_project`

```
my_project/
├── bin/
├── config/
├── public/
├── src/
├── templates/
├── tests/
├── var/
├── vendor/
└── .env
```

## Запуск встроенного сервера

```
symfony serve
или
php -S localhost:8000 -t public
```

---


# Создание миграции

**Миграции — это механизм (инструмент), который превращает изменения в PHP-коде в изменения в базе данных автоматически,
контролируемо и безопасно.**

Команда: создания файла миграции: `php bin/console make:migration`

Команда применения миграции к бд: `php bin/console doctrine:migrations:migrate`

Проверка созданных таблиц: `sqlite3 var/data.db ".tables"` Вместо var/data.db - название файла sqlite

# Автоматическое создание классов

**Все команды запускаются как:** `php bin/console make:XXX`

### Создание сущности

`php bin/console make:entity`


Появляется интеркативный опрос для генерации полей сущностей:

```
New property name: originalUrl
Field type: string
Field length: 2048
Nullable: no
```

### Создание контроллера
`php bin/console make:controller UserController`

сразу полный CRUD-контроллер + шаблоны для существующей Entity:
`php bin/console make:crud Link`

Что генерируется — сразу пачка файлов:

- src/Controller/LinkController.php с методами index, new, show, edit, delete
- src/Form/LinkType.php — форма для создания/редактирования (Symfony Forms)
- templates/link/index.html.twig, new.html.twig, show.html.twig, edit.html.twig, _delete_form.html.twig

### Создание класса формы

**make:form** — генерация класса формы (Symfony Forms)