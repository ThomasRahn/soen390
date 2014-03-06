<?php

class LanguageTableSeeder extends Seeder
{

    public function run()
    {
        DB::table('Language')->delete();

        Language::create(array("Description" => "English"));
        Language::create(array("Description" => "French"));
    }

}
