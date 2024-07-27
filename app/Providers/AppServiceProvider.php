<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Nwidart\Modules\Facades\Module;
use App\Models\Module as ModuleModel;
use Illuminate\Support\Facades\Route;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->registerModules();
        $this->registerRoutes();
    }

    protected function registerModules()
    {
        $modules = ModuleModel::where('is_active', true)->pluck('name')->toArray();

        foreach ($modules as $moduleName) {
            $module = Module::find($moduleName);
            if ($module) {
                $module->register();
            }
        }
    }

    protected function registerRoutes()
    {
        $modules = ModuleModel::where('is_active', true)->pluck('name')->toArray();

        foreach ($modules as $moduleName) {
            $module = Module::find($moduleName);

            if ($module) {
                Route::group([
                    'namespace' => $module->getNamespace(),
                    'prefix' => 'api',
                    'middleware' => 'api',
                ], function () use ($module) {
                    $routesPath = $module->getPath() . '/Routes/api.php';

                    if (file_exists($routesPath)) {
                        require $routesPath;
                    }
                });
            }
        }
    }
}