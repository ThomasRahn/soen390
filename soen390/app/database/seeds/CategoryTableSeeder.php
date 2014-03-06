<?php 
class CategoryTableSeeder extends Seeder
{

    public function run()
    {
        DB::table('Category')->delete();

        Category::create(array("Description" => "For"));
        Category::create(array("Description" => "Indifferent"));
        Category::create(array("Description" => "Against"));
    }

}
