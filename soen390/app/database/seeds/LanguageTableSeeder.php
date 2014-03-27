<?php

class LanguageTableSeeder extends Seeder
{

    public function run()
    {
        DB::table('Language')->delete();

        Language::create(array(
            'Code'        => 'en',
            'Description' => 'English',
        ));

        Language::create(array(
            'Code'        => 'fr',
            'Description' => 'Français',
        ));
    }

}
