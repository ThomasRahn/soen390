<?php

class FlagStanceController extends BaseController {

	public function getIndex()
	{

		$narrativeID = Input::get('NarrativeID');
		$comment = Input::get('report-comment');

		//save the report here.
		DB::table('Flag')->insert(array('narrativeID'=>$narrativeID, 'CommentID'=>null, 'comment'=>$comment));

	}
	public function setStance(){
		$narrativeID = Input::get('NarrativeID');
		$stance = Input::get('stance');
		$narrative = Narrative::find($narrativeID);

		if($stance == 1){
			$narrative->increment('Agrees');	
		}elseif($stance == 2){
			$narrative->increment('Disagrees');	
		}elseif($stance == 3){
			$narrative->increment('Indifferents');	
		}
		
	}

}
