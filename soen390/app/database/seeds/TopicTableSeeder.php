<?php 
class TopicTableSeeder extends Seeder{

        public function run(){

                DB::table('Topic')->delete();
		Topic::create(array("TopicID"=>1, "DateCreated"=>new DateTime,"Name"=>"Pipes and stuff","Description"=>"Key stone pipeline stuff"));
        }
}

