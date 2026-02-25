# Demo Yii1 Books Catalog

Демонстрационное web‑приложение на Yii1 для каталога книг с авторами, подписками и отчетом.

## Структура
- `web/` — web root (docroot для Apache2), точка входа `web/index.php`.
- `protected/` — Yii1 приложение (controllers, models, views, components, migrations, config).
- `.work-docs/` — документация проекта (`.work-docs/WISHLIST.md`, `.work-docs/TECH_SPEC.md`, задание).
- `uploads/` — загруженные обложки.
- `framework/` — Yii1 framework (устанавливается скриптом).

## Установка Yii1
Для загрузки Yii1 используйте скрипт:

```bash
bash install.sh
```

По умолчанию будет скачана версия `1.1.32`. Можно указать другую:

```bash
YII_VERSION=1.1.29 bash install.sh
```

## Настройка БД
Настройки подключения в `protected/config/main.php` и `protected/config/console.php`.
Кодировка подключения: `utf8mb4`.

## Миграции
Миграции находятся в `protected/migrations/`.
Стартовая миграция: `m000000_000000_init.php`.

## Запуск
HTTPD (Apache2) должен быть настроен на docroot `web/`.
Требуется `mod_rewrite` и разрешение `.htaccess` (AllowOverride All).
