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

