# Laravel Multilingual Site (KZ / RU / EN)

Мультиязычный корпоративный сайт на Laravel 11 + Blade + Tailwind CSS + Alpine.js.

---

## Стек технологий

| Слой        | Технология                    |
|-------------|-------------------------------|
| Backend     | PHP 8.2+, Laravel 11          |
| Frontend    | Blade, Tailwind CSS, Alpine.js |
| Сборка      | Vite                          |
| БД          | MySQL 8+ / MariaDB            |
| Хостинг     | hoster.kz, Plesk + Laravel Toolkit |

---

## Структура проекта

```
laravel-multisite/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Admin/          ← Контроллеры админ-панели
│   │   │   └── Public/         ← Контроллеры публичного сайта
│   │   ├── Middleware/
│   │   │   ├── SetLocale.php   ← Переключение языка
│   │   │   └── AdminMiddleware.php
│   │   └── Requests/           ← Form Request валидации
│   └── Models/                 ← Модели с локализованными геттерами
├── database/
│   ├── migrations/             ← 10 миграций
│   └── seeders/
│       ├── AdminUserSeeder.php ← Создание первого admin
│       └── SettingsSeeder.php  ← Настройки сайта
├── resources/
│   ├── views/
│   │   ├── layouts/
│   │   │   ├── app.blade.php   ← Публичный layout
│   │   │   └── admin.blade.php ← Admin layout
│   │   ├── components/
│   │   │   ├── header.blade.php
│   │   │   ├── footer.blade.php
│   │   │   └── flash.blade.php
│   │   ├── public/             ← Публичные страницы
│   │   └── admin/              ← Страницы панели управления
│   ├── css/app.css
│   ├── js/app.js
│   └── lang/
│       ├── ru/                 ← Русский
│       ├── kz/                 ← Казахский
│       └── en/                 ← Английский
└── routes/web.php              ← Все роуты
```

---

## Установка на hoster.kz (Plesk + Laravel Toolkit)

### Шаг 1: Загрузить файлы

1. В Plesk создайте новый **домен** или **поддомен**
2. В разделе **Laravel Toolkit** нажмите **"Deploy Laravel App"**
3. Загрузите файлы проекта через FTP/SFTP в корень (обычно `/httpdocs`)
4. Убедитесь, что структура выглядит так:
   ```
   /httpdocs/
   ├── app/
   ├── bootstrap/
   ├── config/
   ├── database/
   ├── public/          ← Document Root должен указывать сюда!
   ├── resources/
   ├── routes/
   ├── storage/
   └── ...
   ```

### Шаг 2: Настроить Document Root

В Plesk → Домен → **Apache & nginx Settings**:
```
Document Root: /httpdocs/public
```

### Шаг 3: Настроить .env

Скопируйте `.env.example` в `.env` и заполните:

```bash
APP_NAME="Название сайта"
APP_ENV=production
APP_DEBUG=false
APP_URL=https://ваш-домен.kz

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=имя_базы_данных
DB_USERNAME=пользователь_бд
DB_PASSWORD=пароль_бд
```

> ⚠️ **Важно**: База данных создаётся в Plesk → **Databases** → Add Database

### Шаг 4: Установить зависимости

Через **SSH** (или Laravel Toolkit → Terminal):

```bash
# 1. Перейти в директорию проекта
cd /httpdocs

# 2. Установить PHP-зависимости
composer install --no-dev --optimize-autoloader

# 3. Установить Node-зависимости и собрать assets
npm install
npm run build

# 4. Сгенерировать APP_KEY
php artisan key:generate

# 5. Создать символическую ссылку для storage
php artisan storage:link

# 6. Запустить миграции
php artisan migrate --force

# 7. Заполнить базу начальными данными
php artisan db:seed --class=AdminUserSeeder
php artisan db:seed --class=SettingsSeeder

# 8. Кеш конфигурации (для production)
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### Шаг 5: Права на папки

```bash
chmod -R 755 /httpdocs
chmod -R 777 /httpdocs/storage
chmod -R 777 /httpdocs/bootstrap/cache
```

---

## Регистрация Middleware в bootstrap/app.php

Добавьте в `bootstrap/app.php`:

```php
use App\Http\Middleware\SetLocale;
use App\Http\Middleware\AdminMiddleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'set.locale' => SetLocale::class,
            'admin'      => AdminMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
```

---

## Доступы к админ-панели

После запуска `AdminUserSeeder`:

| Поле     | Значение             |
|----------|----------------------|
| URL      | `/admin/login`       |
| Email    | `admin@company.kz`   |
| Пароль   | `Admin@12345!`       |

> ⚠️ **Обязательно** смените пароль после первого входа!

---

## Структура URL (публичный сайт)

```
/                    → Редирект на /ru
/ru                  → Главная (русский)
/kz                  → Главная (казахский)
/en                  → Главная (английский)

/ru/about            → О компании
/ru/services         → Список услуг
/ru/services/{slug}  → Страница услуги
/ru/news             → Список новостей
/ru/news/{slug}      → Новость
/ru/contacts         → Контакты
/ru/{slug}           → Статическая страница
```

---

## Структура URL (admin-панель)

```
/admin/login              → Вход
/admin/dashboard          → Дашборд

/admin/pages              → Статические страницы (CRUD)
/admin/news               → Новости (CRUD)
/admin/services           → Услуги (CRUD)
/admin/team               → Команда (CRUD)
/admin/partners           → Партнёры/клиенты (CRUD)
/admin/faq                → FAQ (CRUD)
/admin/messages           → Входящие сообщения
/admin/media              → Медиафайлы
/admin/settings           → Настройки сайта
```

---

## Модели базы данных

| Таблица           | Модель          | Описание                  |
|-------------------|-----------------|---------------------------|
| `users`           | `User`          | Пользователи + роли       |
| `pages`           | `Page`          | Статические страницы      |
| `news`            | `News`          | Новости                   |
| `services`        | `Service`       | Услуги                    |
| `team`            | `TeamMember`    | Команда / сотрудники      |
| `partners`        | `Partner`       | Партнёры и клиенты        |
| `faq`             | `Faq`           | Вопросы и ответы          |
| `settings`        | `Setting`       | Настройки сайта           |
| `contact_messages`| `ContactMessage`| Заявки с сайта            |
| `media`           | `Media`         | Загруженные файлы         |

Все контентные модели поддерживают:
- **Мультиязычность**: поля `_ru`, `_kz`, `_en` для title, slug, description, content, meta
- **Soft Delete**: данные не удаляются сразу, переходят в "корзину"
- **Статусы**: `draft` (черновик) / `published` (опубликовано)

---

## Фолбэк при незаполненном переводе

Все модели используют метод `getTitle($locale)`, `getContent($locale)` и т.д.:

```php
// Если kz или en пусто — показывает русскую версию
public function getTitle(string $locale = 'ru'): string
{
    return $this->{"title_{$locale}"} ?: ($this->title_ru ?? '');
}
```

Во views используется так:
```blade
{{ $news->getTitle($locale) }}  // Вернёт kz/ru/en или fallback на ru
```

---

## Переключение языка

Переключение происходит через URL-сегмент `/{locale}/...`.

Middleware `SetLocale` автоматически:
1. Проверяет, что locale ∈ `['ru', 'kz', 'en']` (иначе 404)
2. Устанавливает `app()->setLocale($locale)`
3. Сохраняет выбор в session

---

## Composer-зависимости (добавить вручную)

В `composer.json` должны быть:

```json
{
    "require": {
        "php": "^8.2",
        "laravel/framework": "^11.0",
        "laravel/tinker": "^2.9"
    },
    "require-dev": {
        "fakerphp/faker": "^1.23",
        "laravel/pint": "^1.13",
        "laravel/sail": "^1.26",
        "phpunit/phpunit": "^11.0"
    }
}
```

---

## NPM-зависимости (package.json)

```json
{
    "devDependencies": {
        "alpinejs": "^3.13.3",
        "autoprefixer": "^10.4.16",
        "axios": "^1.6.4",
        "laravel-vite-plugin": "^1.0.0",
        "postcss": "^8.4.32",
        "tailwindcss": "^3.4.0",
        "vite": "^5.0.0"
    }
}
```

Установка и сборка:
```bash
npm install
npm run build    # Production (один раз)
npm run dev      # Development (при разработке)
```

---

## Checklist перед запуском

- [ ] `.env` заполнен (DB, APP_URL, APP_KEY)
- [ ] `composer install` выполнен
- [ ] `npm run build` выполнен
- [ ] `php artisan key:generate` выполнен
- [ ] `php artisan storage:link` выполнен
- [ ] `php artisan migrate` выполнен
- [ ] `php artisan db:seed --class=AdminUserSeeder` выполнен
- [ ] `php artisan db:seed --class=SettingsSeeder` выполнен
- [ ] `php artisan config:cache` выполнен
- [ ] `php artisan route:cache` выполнен
- [ ] Document Root → `public/`
- [ ] Права `777` на `storage/` и `bootstrap/cache/`
- [ ] Пароль администратора изменён
- [ ] HTTPS настроен через Plesk

---

## Checklist после запуска

- [ ] Проверить /ru, /kz, /en
- [ ] Переключатель языка работает
- [ ] Форма контактов отправляет (проверить в /admin/messages)
- [ ] Создать новость через /admin/news/create
- [ ] Предпросмотр новости работает
- [ ] Загрузка изображения работает
- [ ] Ошибки валидации отображаются корректно
- [ ] 404 страница на неверном локале/слаге
- [ ] Сайт адаптирован под мобильные
- [ ] /sitemap.xml доступен
- [ ] /robots.txt доступен

---

## Поддержка

При возникновении вопросов по деплою — используйте:
- **Plesk Logs**: `Logs & Statistics → Error Log`
- **Laravel Logs**: `storage/logs/laravel.log`
- **Laravel Toolkit**: в Plesk предоставляет удобный интерфейс управления
