<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LocaleSeeder extends Seeder
{
    public function run() {
        \DB::table('locales')->insert([[
            'slug' => 'fr',
            'name' => 'Français',
        ], [
            'slug' => 'en',
            'name' => 'English',
        ]]);
    }
}
