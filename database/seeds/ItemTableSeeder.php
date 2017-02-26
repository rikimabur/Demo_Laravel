<?php

use Illuminate\Database\Seeder;
use App\Models\Item;
class ItemTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $items = [
        	[
        		'title' => 'title 1',
        		'description' => 'title 1'
        	],
        	[
        		'title' => 'title 1',
        		'description' => 'title 1'
        	]
        ];
        foreach ($items as $key => $value) {
        	Item::create($value);
        }
    }
}
