<?php

namespace App\Providers;

use App\Services\ClassesService;
use App\Services\Contracts\ClassesService as ClassesServiceContract;
use Illuminate\Config\Repository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(ClassesServiceContract::class, function() {
            /** @var Repository $config */
            $config = $this->app->get('config');
            $serviceConfig = $config->get('admin.classes.source_of_truth', []);

            return new ClassesService($serviceConfig);
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
