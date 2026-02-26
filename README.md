# Demo Yii1 Books Catalog

Демонстрационное web‑приложение на Yii1 для каталога книг с авторами, подписками и отчетом.

## Структура
- `web/` — web root (docroot для Apache2), точка входа `web/index.php`.
- `protected/` — Yii1 приложение (controllers, models, views, components, migrations, config).
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
Настройки подключения читаются из `.env` (создайте файл на основе `.env.example`).
Также заданы дефолтные значения в коде, если `.env` отсутствует.
Кодировка подключения: `utf8mb4`.

## Миграции
Миграции находятся в `protected/migrations/`.
Стартовая миграция: `m000000_000000_init.php`.

## Запуск
HTTPD (Apache2) должен быть настроен на docroot `web/`.
Требуется `mod_rewrite` и разрешение `.htaccess` (AllowOverride All).

## Настройка отправки SMS сообщений
Параметры SmsPilot читаются из `.env`:

- `SMS_PILOT_API_KEY` — API-ключ сервиса
- `SMS_PILOT_SENDER` — имя отправителя

Тестовая отправка выполняется консольной командой:

```bash
php protected/yiic.php testsendsms --phone=+79990001122 \
  --message="Тестовое сообщение"
```

## Тестовый пользователь
Для входа можно использовать тестовую учетную запись:

- Логин: `demo`
- Пароль: `user`
