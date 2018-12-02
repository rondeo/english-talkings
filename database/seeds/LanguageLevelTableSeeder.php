<?php

use App\LanguageLevel;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LanguageLevelTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('language_levels')->delete();

        LanguageLevel::create(['name' => 'general']);
        LanguageLevel::create(['name' => 'pre-intermediate']);
        LanguageLevel::create(['name' => 'intermediate']);
        LanguageLevel::create(['name' => 'upper-intermediate']);
        LanguageLevel::create(['name' => 'advanced']);
        LanguageLevel::create(['name' => 'fluent']);
    }
}
