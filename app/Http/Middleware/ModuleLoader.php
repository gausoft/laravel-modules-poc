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
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $request->headers->set('Accept', 'application/json');

        $routeName = Route::currentRouteName();
        $moduleName = $this->getModuleNameFromRoute($routeName);

        if ($moduleName && $this->isModuleActive($moduleName)) {
            $this->loadModule($moduleName);
        }

        return $next($request);
    }

    protected function getModuleNameFromRoute($routeName)
    {
        $segments = explode('.', $routeName);
        return $segments[0] ?? null;
    }

    protected function isModuleActive($moduleName)
    {
        return ModuleModel::where('name', $moduleName)->where('is_active', true)->exists();
    }

    protected function loadModule($moduleName)
    {
        $module = Module::find($moduleName);

        if ($module) {
            $module->boot();
            $module->register();
        }
    }
}
