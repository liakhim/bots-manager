# 🤖 Bots Manager

Laravel 10 приложение для управления Telegram ботами с дополнительным функционалом изучения английского языка (B2 Vocabulary).

## Возможности

**Telegram Bots**
- Два бота с webhook обработкой
- Автоматическое создание пользователей
- Логирование входящих сообщений
- Напоминания и ежедневные уведомления

**B2 Vocabulary**
- База английских слов с переводами (EN → RU)
- Определения, синонимы, антонимы, примеры
- Интеграция с Google Translate и dictionaryapi.dev

## Tech Stack

- Laravel 10
- MySQL, Redis, Meilisearch
- Docker (Laravel Sail)
- Guzzle HTTP

## Быстрый старт

```bash
composer install && npm install
cp .env.example .env
php artisan key:generate
php artisan migrate
docker-compose up -d
```

## Команды

```bash
php artisan queue:work      # Очередь задач
php artisan schedule:run     # Планировщик
php artisan test             # Тесты
```
