<?php

use Illuminate\Database\Seeder;
use App\Models\Painel\Permissions;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Permissions::create([
            'name'=> null,
            'readable_name'=> 'Configurações',
            'icon'=> 'icon-home',
            'order' => 1,
            'id_permission' => null,
            'menu_fix' => 0
        ]);

        Permissions::create([
            'name'=> 'settings',
            'readable_name'=> 'Sistema',
            'icon'=> null,
            'order' => 1,
            'id_permission' => 1,
            'menu_fix' => 0
        ]);

        Permissions::create([
            'name'=> 'roles',
            'readable_name'=> 'Grupos',
            'icon'=> null,
            'order' => 2,
            'id_permission' => 1,
            'menu_fix' => 0
        ]);

        Permissions::create([
            'name'=> 'permissions',
            'readable_name'=> 'Menus',
            'icon'=> null,
            'order' => 3,
            'id_permission' => 1,
            'menu_fix' => 0
        ]);

        Permissions::create([
            'name'=> 'site',
            'readable_name'=> 'Menus Sites',
            'icon'=> 'icon-globe',
            'order' => 2,
            'id_permission' => null,
            'menu_fix' => 1
        ]);
    }
}
