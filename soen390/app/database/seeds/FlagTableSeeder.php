<?php 
class FlagTableSeeder extends Seeder{

        public function run(){

                DB::table('Flag')->delete();
		Flag::create(array("FlagID"=>1,"NarrativeID"=>1,"CommentID"=>null,"Comment"=>"Bad Narrative!!!!!"));
		Flag::create(array("FlagID"=>2,"NarrativeID"=>1,"CommentID"=>null,"Comment"=>"Bad Narrative!!!!!"));
		Flag::create(array("FlagID"=>3,"NarrativeID"=>1,"CommentID"=>null,"Comment"=>"Bad Narrative!!!!!"));
		Flag::create(array("FlagID"=>4,"NarrativeID"=>1,"CommentID"=>null,"Comment"=>"Bad Narrative!!!!!"));



        }
}

