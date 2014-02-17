<?php

class FlagController extends BaseController {

	public function getIndex()
	{

		$narrativeID = Input::get('NarrativeID');
		$comment = Input::get('report-comment');

		//save the report here.
		DB::table('Flag')->insert(array('narrativeID'=>$narrativeID, 'CommentID'=>null, 'comment'=>$comment));

	}

}
