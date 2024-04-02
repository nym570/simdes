<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;
use App\Models\User;
use App\Models\Admin;
use App\Models\Desa;
use App\Models\Pemerintahan;
use App\Models\Dusun;
use App\Models\RW;
use App\Models\RT;
use Spatie\Activitylog\Models\Activity;
use App\Models\Warga;
use App\Models\Ruta;
use App\Models\AnggotaRuta;
use App\Models\Dinamika;
use App\Models\Kelahiran;
use App\Models\Kematian;
use App\Models\Kedatangan;
use App\Models\Kepindahan;
use App\Models\Aspirasi;
use App\Models\BalasAspirasi;
use App\Models\InfoPublik;
use App\Models\PengajuanInfoPublik;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to the "home" route for your application.
     *
     * This is used by Laravel authentication to redirect users after login.
     *
     * @var string
     */
    public const HOME = '/';
    public const ADMIN_HOME = '/admin';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        $this->configureRateLimiting();

        $this->routes(function () {
            Route::prefix('api')
                ->middleware('api')
                ->group(base_path('routes/api.php'));

            Route::middleware('web')
                ->group(base_path('routes/web.php'));
        });
        Route::bind('user', function ($value, $route) {
            return $this->getModel(User::class, $value);
        });
        Route::bind('admin', function ($value, $route) {
            return $this->getModel(Admin::class, $value);
        });
        Route::bind('desa', function ($value, $route) {
            return $this->getModel(Desa::class, $value);
        });
        Route::bind('pemerintahan', function ($value, $route) {
            return $this->getModel(Pemerintahan::class, $value);
        });
        Route::bind('dusun', function ($value, $route) {
            return $this->getModel(Dusun::class, $value);
        });
        Route::bind('rw', function ($value, $route) {
            return $this->getModel(RW::class, $value);
        });
        Route::bind('rt', function ($value, $route) {
            return $this->getModel(RT::class, $value);
        });
        Route::bind('log', function ($value, $route) {
            return $this->getModel(Activity::class, $value);
        });
        Route::bind('warga', function ($value, $route) {
            return $this->getModel(Warga::class, $value);
        });
        Route::bind('ruta', function ($value, $route) {
            return $this->getModel(Ruta::class, $value);
        });
        Route::bind('anggota_ruta', function ($value, $route) {
            return $this->getModel(AnggotaRuta::class, $value);
        });
        Route::bind('dinamika', function ($value, $route) {
            return $this->getModel(Dinamika::class, $value);
        });
        Route::bind('lahir', function ($value, $route) {
            return $this->getModel(Kelahiran::class, $value);
        });
        Route::bind('pindah', function ($value, $route) {
            return $this->getModel(Kepindahan::class, $value);
        });
        Route::bind('datang', function ($value, $route) {
            return $this->getModel(Kedatangan::class, $value);
        });
        Route::bind('mati', function ($value, $route) {
            return $this->getModel(Kematian::class, $value);
        });
        Route::bind('aspirasi', function ($value, $route) {
            return $this->getModel(Aspirasi::class, $value);
        });
        Route::bind('balas_aspirasi', function ($value, $route) {
            return $this->getModel(BalasAspirasi::class, $value);
        });
        Route::bind('info', function ($value, $route) {
            return $this->getModel(InfoPublik::class, $value);
        });
        Route::bind('mohon_info', function ($value, $route) {
            return $this->getModel(PengajuanInfoPublik::class, $value);
        });
    }

    /**
     * Configure the rate limiters for the application.
     *
     * @return void
     */
    protected function configureRateLimiting()
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });
    }

    private function getModel($model, $routeKey)
{
    $id = \Hashids::connection($model)->decode($routeKey)[0] ?? null;
    $modelInstance = resolve($model);

    return  $modelInstance->findOrFail($id);
}
}
