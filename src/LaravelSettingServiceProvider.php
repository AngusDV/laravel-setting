<?php
namespace AngusDV\LaravelSetting;


use AngusDV\LaravelSetting\Settings\Settings;
use Illuminate\Support\Facades\File;
use Illuminate\Support\ServiceProvider;

class LaravelSettingServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(Settings::class, function () {
            return Settings::make();
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        if (File::exists(__DIR__ . '/helpers/settings.php')) {
            require __DIR__ . '/helpers/settings.php';
        }
        $this->loadMigrationsFrom(__DIR__.'/database/migrations');
    }
}
