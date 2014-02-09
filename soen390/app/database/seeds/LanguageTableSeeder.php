<?php 
class LanguageTableSeeder extends Seeder{

        public function run(){

                DB::table('Language')->delete();
		Language::create(array("LanguageID"=>1,"Description"=>"English"));
        }
}

