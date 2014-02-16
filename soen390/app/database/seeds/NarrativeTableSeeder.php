<?php 
class NarrativeTableSeeder extends Seeder{

        public function run(){

                DB::table('Narrative')->delete();
		Narrative::create(array("NarrativeID"=>1, "CategoryID"=>1,"TopicID"=>1,"LanguageID"=>1,"DateCreated"=> new DateTime, "Name"=>"First Narrative"));
        }
}

