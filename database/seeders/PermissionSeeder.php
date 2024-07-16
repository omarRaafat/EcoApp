<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        
        $permissions = require(__DIR__ . "/../../permissions_generator.php");

        foreach($permissions as $permission) {
            $existingPermission = Permission::where('name->ar','like',$permission['name']['ar'])->where('module->ar','like',$permission['module']['ar'])->where('group',$permission['group'])->first();
            if ($existingPermission) {
                $existingPermission->update($permission);
            } else {
                Permission::create($permission);
            }
        }

        //php artisan db:seed --class=PermissionSeeder
        Schema::enableForeignKeyConstraints();
    }
}
