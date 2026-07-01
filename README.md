# URL Shortener

Laravel 10 приложение для сокращения ссылок с отслеживанием переходов и личным кабинетом на [Filament v3](https://filamentphp.com/).

## Возможности

- Регистрация и вход через Filament
- Создание коротких ссылок из длинных URL
- Редирект по короткому коду с записью статистики (IP, дата/время)
- Личный кабинет: список ссылок, удаление, просмотр статистики переходов
- Docker для быстрого запуска

## Требования (локально без Docker)

- PHP 8.1+ (Docker-образ использует PHP 8.4)
- Composer
- MySQL 8+ или SQLite

## Быстрый старт через Docker

```bash
git clone https://github.com/CottonAO/laravel-url-shortener.git
cd laravel-url-shortener

# Автоматическая установка (Linux/macOS)
chmod +x setup.sh && ./setup.sh
```

Или вручную:

```bash
docker compose up -d --build

# Установка зависимостей и настройка приложения
docker compose exec app composer install --no-interaction
docker compose exec app cp .env.example .env
docker compose exec app php artisan key:generate
docker compose exec app php artisan migrate --force
docker compose exec app php artisan filament:assets
docker compose exec app php artisan optimize
```

Приложение: http://localhost:8080  
Личный кабинет (Filament): http://localhost:8080/admin

> **Производительность на Windows:** `vendor/` монтируется в Docker-том (не через bind mount),
> иначе каждый PHP-запрос читает тысячи файлов с диска Windows и может занимать 5–10 секунд.
> После `composer install` внутри контейнера выполните `php artisan optimize`.

### Регистрация

1. Откройте http://localhost:8080/admin/register
2. Создайте аккаунт
3. В разделе «Мои ссылки» создайте короткую ссылку
4. Перейдите по короткой ссылке — переход будет зафиксирован в статистике

## Локальная установка (без Docker)

```bash
composer install
cp .env.example .env
php artisan key:generate

# Настройте DB_* в .env для вашей БД
php artisan migrate
php artisan filament:assets

php artisan serve
```

Откройте http://127.0.0.1:8000 и http://127.0.0.1:8000/admin

## Тесты

```bash
php artisan test
```

или через Docker:

```bash
docker compose exec app php artisan test
```

## Структура проекта

```
app/
├── Filament/Resources/     # Filament-ресурсы (личный кабинет)
├── Http/Controllers/       # RedirectController
├── Models/                 # User, Link, LinkClick
└── Services/               # ShortLinkService
database/migrations/        # Таблицы links, link_clicks
docker/                     # Nginx-конфиг
tests/Feature/              # Feature-тесты
```

## API маршрутов

| Метод | URL | Описание |
|-------|-----|----------|
| GET | `/` | Главная страница |
| GET | `/{shortCode}` | Редирект на оригинальный URL |
| GET | `/admin` | Личный кабинет Filament |

## Лицензия

MIT
