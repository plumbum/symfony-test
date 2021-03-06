# Try Symfony

## Init project

```bash
composer create-project symfony/skeleton books-test-php
```

## Development web server

Install dev web server:

```bash
composer require server --dev
```

Run server in foreground:

```bash
php bin/console server:run
```

Run server in background:

```bash
php bin/console server:start
```

Stop daemonized server:

```bash
php bin/console server:stop
```
## Профилирование

```bash
composer require profiler
```

## Index page

Установим поддержку аннотаций:

```bash
composer require annotations
```

Будем использовать их, хотя в прописывании марштрутов в отдельном файле
`config/routes.yaml` есть свои плюсы (не надо рыскать по всему коду в поисках маршрутов).

Так же потребуется генератор кода:

```bash
composer require maker
```

Теперь можно нагеренить контроллер:

```bash
php bin/console make:controller DefaultController
```

Заготовка контроллера будет создана в каталоге `src/Controller`.

## Init database

```bash
composer require doctrine
```

После этого можно прописать в `.env` корректную строку доступа к БД.
В нашем случае это sqlite:

```bash
DATABASE_URL="sqlite:///%kernel.project_dir%/var/books.db"
```

Теперь можно создать БД:

```bash
php bin/console doctrine:database:create
```

Или грохнуть её, если не нужна больше:

```bash
php bin/console doctrine:database:drop --force
```

## Создание сущеностей

Полезно почитать про [аннотации doctrine](https://www.doctrine-project.org/projects/doctrine-orm/en/latest/reference/annotations-reference.html).

Сгенерировать шаблон сущности можно командой:

```bash
php bin/console make:entity Author
```
аналогично создаём сущность для книг.

После можно создать миграцию:

```bash
php bin/console make:migration
```

и применить её:

```bash
php bin/console doctrine:migrations:migrate
```

## Twig

```bash
composer require twig
```

## Формы

https://symfony.com.ua/doc/current/forms.html

```bash
composer require form
```

