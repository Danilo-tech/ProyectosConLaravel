<?php

use App\Modelos\Locales\Locale;
use Illuminate\Database\Seeder;

class LocaleTableSeeder extends Seeder
{
    public function run()
    {
        $languages = ['es', 'en'];

        foreach ($languages as $language)
        {
            Locale::create(compact('language',''));
        }
    }
}