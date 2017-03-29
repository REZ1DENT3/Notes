<?php

use Illuminate\Database\Seeder;

class ColorsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::table('colors')->insert([
            'title' => 'Primary',
            'value' => '#337ab7'
        ]);

        DB::table('colors')->insert([
            'title' => 'Success',
            'value' => '#5cb85c'
        ]);

        DB::table('colors')->insert([
            'title' => 'Info',
            'value' => '#5bc0de'
        ]);

        DB::table('colors')->insert([
            'title' => 'Warning',
            'value' => '#f0ad4e'
        ]);

        DB::table('colors')->insert([
            'title' => 'Danger',
            'value' => '#d9534f'
        ]);

        DB::table('colors')->insert([
            'title' => 'Darker',
            'value' => '#222'
        ]);

        DB::table('colors')->insert([
            'title' => 'Dark',
            'value' => '#333'
        ]);

        DB::table('colors')->insert([
            'title' => 'Gray',
            'value' => '#555'
        ]);

        DB::table('colors')->insert([
            'title' => 'Gray Light',
            'value' => '#777'
        ]);

        DB::table('colors')->insert([
            'title' => 'Gray Lighter',
            'value' => '#eee'
        ]);

    }
}
