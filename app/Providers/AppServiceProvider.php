<?php
namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\Eloquent\{SettingRepository,RoleRepository,UserRepository, PermissionRepository, ProductRepository};
use App\Repositories\Interfaces\{SettingInterFace,RoleInterFace,UserInterFace,PermissionInterFace,ProductInterFace};
use App\Models\{Setting,Role,User,Permission,Product}; 
use App\Models\Sanctum\PersonalAccessToken;
use Laravel\Sanctum\Sanctum;
use App\Http\Facades\Permission as PermissionFacade;
use Laravel\Passport\Passport;
use Illuminate\Foundation\AliasLoader;

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

        $this->app->singleton(RoleInterFace::class, function () {
            return new RoleRepository(new Role());
        });

        $this->app->singleton(UserInterFace::class, function () {
            return new UserRepository(new User());
        });

        $this->app->singleton(PermissionInterFace::class, function () {
            return new PermissionRepository(new Permission());
        });

        $this->app->singleton(ProductInterFace::class, function () {
            return new ProductRepository(new Product());
        });

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Sanctum::usePersonalAccessTokenModel(PersonalAccessToken::class);

        Passport::loadKeysFrom(storage_path());

        $this->app->booted(function () {
            $loader = AliasLoader::getInstance();
            $loader->alias('Permission', PermissionFacade::class);
        });

    }
}
