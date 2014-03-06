<?php

/**
 * @author  Thomas Rahn <thomas@rahn.ca>
 * @package Controller
 */
class FlagStanceController extends BaseController {

	public function flagReport()
	{

		$narrativeID = Input::get('NarrativeID');
		$comment = Input::get('report-comment');
		$narrative = Narrative::find($narrativeID);
		//save the report here.
		if($narrative != null){
			DB::table('Flag')->insert(array('narrativeID'=>$narrativeID, 'CommentID'=>null, 'comment'=>$comment));
		}

	}
	public function setStance(){
		$narrativeID = Input::get('NarrativeID');
		$stance = Input::get('stance');
		$old = Input::get('old');
		$narrative = Narrative::find($narrativeID);
		if($stance == 1){
			$narrative->increment('Agrees');	
			if($old === true){
				$narrative->decrement('Disagrees');
			}
		}elseif($stance == 2){
			$narrative->increment('Disagrees');
			if($old === true){
				$narrative->decrement('Agrees');
			}
		}
		
	}

}
