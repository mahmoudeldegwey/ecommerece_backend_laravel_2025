<?php
namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\Eloquent\SettingRepository;
use App\Repositories\Interfaces\SettingInterFace;
use App\Models\Setting;
use App\Models\Sanctum\PersonalAccessToken;
use Laravel\Sanctum\Sanctum;

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
        Sanctum::usePersonalAccessTokenModel(PersonalAccessToken::class);
    }
}
