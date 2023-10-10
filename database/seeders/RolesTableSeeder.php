<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $edit = Permission::findByName('edit posts');
        $delete = Permission::findByName('delete posts');
        $create = Permission::findByName('create posts');

        $SuperRole = Role::create(['name' => 'Super Admin']);
        $SuperRole->givePermissionTo(Permission::all());
        
        $EditorsRole = Role::create(['name' => 'Editors']);
        $EditorsRole->givePermissionTo($delete,$edit, $create);

    }
}
