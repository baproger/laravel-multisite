<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Public\HomeController;
use App\Http\Controllers\Public\AboutController;
use App\Http\Controllers\Public\ServiceController;
use App\Http\Controllers\Public\NewsController;
use App\Http\Controllers\Public\ContactController;
use App\Http\Controllers\Public\PageController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PageAdminController;
use App\Http\Controllers\Admin\NewsAdminController;
use App\Http\Controllers\Admin\ServiceAdminController;
use App\Http\Controllers\Admin\TeamController;
use App\Http\Controllers\Admin\PartnerController;
use App\Http\Controllers\Admin\FaqController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Admin\MediaController;
use App\Http\Controllers\Admin\ContactMessageController;

/*
|--------------------------------------------------------------------------
| Редирект с корня на /ru
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return redirect('/ru');
});

/*
|--------------------------------------------------------------------------
| Публичные роуты с локалью: /{locale}/...
|--------------------------------------------------------------------------
*/
Route::prefix('{locale}')
    ->middleware('set.locale')
    ->group(function () {

        // Главная
        Route::get('/', [HomeController::class, 'index'])->name('home');

        // О компании
        Route::get('/about', [AboutController::class, 'index'])->name('about');

        // Услуги
        Route::get('/services', [ServiceController::class, 'index'])->name('services');
        Route::get('/services/{slug}', [ServiceController::class, 'show'])->name('services.show');

        // Новости
        Route::get('/news', [NewsController::class, 'index'])->name('news');
        Route::get('/news/{slug}', [NewsController::class, 'show'])->name('news.show');

        // Контакты
        Route::get('/contacts', [ContactController::class, 'index'])->name('contacts');
        Route::post('/contacts', [ContactController::class, 'store'])->name('contacts.store');

        // Статические страницы (must be last in locale group)
        Route::get('/{slug}', [PageController::class, 'show'])->name('page.show');
    });

/*
|--------------------------------------------------------------------------
| Роуты Sitemap и Robots
|--------------------------------------------------------------------------
*/
Route::get('/sitemap.xml', function () {
    return response()->view('public.sitemap')->header('Content-Type', 'application/xml');
})->name('sitemap');

Route::get('/robots.txt', function () {
    return response()->view('public.robots')->header('Content-Type', 'text/plain');
})->name('robots');

/*
|--------------------------------------------------------------------------
| Админ-панель
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->name('admin.')->group(function () {

    // Авторизация (без middleware)
    Route::get('/login',  [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Защищённые роуты (только для editors/admins)
    Route::middleware('admin')->group(function () {

        // Дашборд
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // Страницы
        Route::get('/pages',              [PageAdminController::class, 'index'])->name('pages.index');
        Route::get('/pages/create',       [PageAdminController::class, 'create'])->name('pages.create');
        Route::post('/pages',             [PageAdminController::class, 'store'])->name('pages.store');
        Route::get('/pages/{id}',         [PageAdminController::class, 'show'])->name('pages.show');
        Route::get('/pages/{id}/edit',    [PageAdminController::class, 'edit'])->name('pages.edit');
        Route::put('/pages/{id}',         [PageAdminController::class, 'update'])->name('pages.update');
        Route::delete('/pages/{id}',      [PageAdminController::class, 'destroy'])->name('pages.destroy');
        Route::get('/pages/{id}/preview', [PageAdminController::class, 'preview'])->name('pages.preview');
        Route::post('/pages/{id}/restore',[PageAdminController::class, 'restore'])->name('pages.restore');

        // Новости
        Route::get('/news',               [NewsAdminController::class, 'index'])->name('news.index');
        Route::get('/news/create',        [NewsAdminController::class, 'create'])->name('news.create');
        Route::post('/news',              [NewsAdminController::class, 'store'])->name('news.store');
        Route::get('/news/{id}',          [NewsAdminController::class, 'show'])->name('news.show');
        Route::get('/news/{id}/edit',     [NewsAdminController::class, 'edit'])->name('news.edit');
        Route::put('/news/{id}',          [NewsAdminController::class, 'update'])->name('news.update');
        Route::delete('/news/{id}',       [NewsAdminController::class, 'destroy'])->name('news.destroy');
        Route::get('/news/{id}/preview',  [NewsAdminController::class, 'preview'])->name('news.preview');
        Route::post('/news/{id}/restore', [NewsAdminController::class, 'restore'])->name('news.restore');

        // Услуги
        Route::get('/services',              [ServiceAdminController::class, 'index'])->name('services.index');
        Route::get('/services/create',       [ServiceAdminController::class, 'create'])->name('services.create');
        Route::post('/services',             [ServiceAdminController::class, 'store'])->name('services.store');
        Route::get('/services/{id}',         [ServiceAdminController::class, 'show'])->name('services.show');
        Route::get('/services/{id}/edit',    [ServiceAdminController::class, 'edit'])->name('services.edit');
        Route::put('/services/{id}',         [ServiceAdminController::class, 'update'])->name('services.update');
        Route::delete('/services/{id}',      [ServiceAdminController::class, 'destroy'])->name('services.destroy');
        Route::get('/services/{id}/preview', [ServiceAdminController::class, 'preview'])->name('services.preview');

        // Команда
        Route::get('/team',              [TeamController::class, 'index'])->name('team.index');
        Route::get('/team/create',       [TeamController::class, 'create'])->name('team.create');
        Route::post('/team',             [TeamController::class, 'store'])->name('team.store');
        Route::get('/team/{id}/edit',    [TeamController::class, 'edit'])->name('team.edit');
        Route::put('/team/{id}',         [TeamController::class, 'update'])->name('team.update');
        Route::delete('/team/{id}',      [TeamController::class, 'destroy'])->name('team.destroy');

        // Партнёры
        Route::get('/partners',              [PartnerController::class, 'index'])->name('partners.index');
        Route::get('/partners/create',       [PartnerController::class, 'create'])->name('partners.create');
        Route::post('/partners',             [PartnerController::class, 'store'])->name('partners.store');
        Route::get('/partners/{id}/edit',    [PartnerController::class, 'edit'])->name('partners.edit');
        Route::put('/partners/{id}',         [PartnerController::class, 'update'])->name('partners.update');
        Route::delete('/partners/{id}',      [PartnerController::class, 'destroy'])->name('partners.destroy');

        // FAQ
        Route::get('/faq',              [FaqController::class, 'index'])->name('faq.index');
        Route::get('/faq/create',       [FaqController::class, 'create'])->name('faq.create');
        Route::post('/faq',             [FaqController::class, 'store'])->name('faq.store');
        Route::get('/faq/{id}/edit',    [FaqController::class, 'edit'])->name('faq.edit');
        Route::put('/faq/{id}',         [FaqController::class, 'update'])->name('faq.update');
        Route::delete('/faq/{id}',      [FaqController::class, 'destroy'])->name('faq.destroy');

        // Обращения
        Route::get('/messages',           [ContactMessageController::class, 'index'])->name('messages.index');
        Route::get('/messages/{id}',      [ContactMessageController::class, 'show'])->name('messages.show');
        Route::delete('/messages/{id}',   [ContactMessageController::class, 'destroy'])->name('messages.destroy');

        // Медиа-менеджер
        Route::get('/media',             [MediaController::class, 'index'])->name('media.index');
        Route::post('/media/upload',     [MediaController::class, 'upload'])->name('media.upload');
        Route::delete('/media/{id}',     [MediaController::class, 'destroy'])->name('media.destroy');

        // Настройки (только admin)
        Route::middleware('can:admin-only')->group(function () {
            Route::get('/settings',      [SettingsController::class, 'index'])->name('settings.index');
            Route::post('/settings',     [SettingsController::class, 'update'])->name('settings.update');
        });
    });
});
