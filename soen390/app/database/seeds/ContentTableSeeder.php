<?php 
class ContentTableSeeder extends Seeder{

        public function run(){

                DB::table('Content')->delete();
		Content::create(array("ContentID"=>1, "NarrativeID"=>1,"AudioPath"=>"1.mp3","PicturePath"=>"1.jpg","Duration"=>7.776));
		Content::create(array("ContentID"=>2, "NarrativeID"=>1,"AudioPath"=>"2.mp3","PicturePath"=>"1.jpg","Duration"=>10.44));
		Content::create(array("ContentID"=>3, "NarrativeID"=>1,"AudioPath"=>"3.mp3","PicturePath"=>"1.jpg","Duration"=>13.39));
		Content::create(array("ContentID"=>4, "NarrativeID"=>1,"AudioPath"=>"4.mp3","PicturePath"=>"4.jpg","Duration"=>5.616));
		Content::create(array("ContentID"=>5, "NarrativeID"=>1,"AudioPath"=>"5.mp3","PicturePath"=>"5.jpg","Duration"=>3.168));
		Content::create(array("ContentID"=>6, "NarrativeID"=>1,"AudioPath"=>"6.mp3","PicturePath"=>"6.jpg","Duration"=>5.688));
		Content::create(array("ContentID"=>7, "NarrativeID"=>1,"AudioPath"=>"7.mp3","PicturePath"=>"7.jpg","Duration"=>5.4));
        }
}

