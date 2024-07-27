<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpFoundation\Response;
use Nwidart\Modules\Facades\Module;
use App\Models\Module as ModuleModel;

class ModuleLoader
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next): Response
    {
        $routeName = Route::currentRouteName();
        $moduleName = $this->getModuleNameFromRoute($routeName);

        if ($moduleName) {
            if ($this->isModuleActive($moduleName)) {
                $this->loadModule($moduleName);
            } else {
                return response()->json([
                    'message' => "The module '{$moduleName}' is disabled.",
                ], 403); // Forbidden
            }
        }

        return $next($request);
    }

    /**
     * Extract module name from route name.
     *
     * @param  string  $routeName
     * @return string|null
     */
    protected function getModuleNameFromRoute($routeName)
    {
        $segments = explode('.', $routeName);
        return $segments[0] ?? null;
    }

    /**
     * Check if the module is active.
     *
     * @param  string  $moduleName
     * @return bool
     */
    protected function isModuleActive($moduleName)
    {
        return ModuleModel::where('name', $moduleName)->where('is_active', true)->exists();
    }

    /**
     * Load the module if it's active.
     *
     * @param  string  $moduleName
     * @return void
     */
    protected function loadModule($moduleName)
    {
        $module = Module::find($moduleName);

        if ($module) {
            $module->boot();
            $module->register();
        }
    }
}