<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Nwidart\Modules\Facades\Module;
use App\Models\Module as ModuleModel;

class CreateModuleListSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $modules = Module::all();

        foreach ($modules as $moduleName => $moduleInfo) {
            ModuleModel::firstOrCreate([
                'name' => $moduleName,
                'is_active' => true,
            ]);
        }
    }
}
