<?php
namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Http\Repositories\Eloquent\SettingRepository;
use App\Http\Repositories\Interfaces\SettingInterFace;
use App\Models\Setting;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(SettingInterFace::class, function () {
            return new SettingRepository(new Setting());
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
