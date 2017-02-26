<?php

use Illuminate\Database\Seeder;
use App\Models\Role;
class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $role = [
        	[
        		'name' => 'Add',
        		'display_name' => 'Add Item',
        		'description' => 'Add Item'
        	],
        	[
        		'name' => 'Delete',
        		'display_name' => 'Delete Item',
        		'description' => 'Delete Item'
        	],
        	[
        		'name' => 'Update',
        		'display_name' => 'Update Item',
        		'description' => 'Update Item'
        	]

        ];
         foreach ($role as $key => $value) {
        	Role::create($value);
        }
    }
}
