<?php 
class CategoryTableSeeder extends Seeder{

        public function run(){

                DB::table('Category')->delete();
		Category::create(array("CategoryID"=>"1","Description"=>"For"));
		Category::create(array("CategoryID"=>"2","Description"=>"Indifferent"));
		Category::create(array("CategoryID" => "3","Description"=>"Against"));

        }
}

