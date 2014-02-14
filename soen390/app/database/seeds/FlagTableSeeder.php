<?php 
class FlagTableSeeder extends Seeder{

        public function run(){

                DB::table('Flag')->delete();
				Flag::create(array("FlagID"=>1,"NarrativeID"=>1,"CommentID"=>null,"Comment"=>"Bad Narrative!!!!!"));
        }
}

