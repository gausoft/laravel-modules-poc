<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Nwidart\Modules\Facades\Module;
use App\Models\Module as ModuleModel;
use Illuminate\Support\Facades\Log;
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
        $this->handleModules();
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

    /**
     * Handle module activation and deactivation.
     */
    protected function handleModules(): void
    {
        $activeModules = ModuleModel::where('is_active', true)->pluck('name')->toArray();
        $allModules = Module::all();

        foreach ($allModules as $module) {
            if (!in_array($module->getName(), $activeModules)) {
                Module::disable($module->getName());
            }
        }

        // Activate only active modules
        foreach ($activeModules as $moduleName) {
            Module::enable($moduleName);

            $this->registerModules();
        }
    }
}