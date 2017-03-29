<?php

use Illuminate\Database\Seeder;

class FontAwesomeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (file(__DIR__ . '/font-awesomes.txt') as $line)
        {
            $line = trim($line);

            DB::table('font_awesomes')->insert([
                'value' => $line
            ]);
        }
    }
}
