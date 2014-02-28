<?php

class ApiFlagController extends \BaseController {

	/**
	 * @codeCoverageIgnore
	 */
	public function __construct()
	{
		$this->beforeFilter('auth', array(
			'except' => array('index', 'show'))
		);
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$flags = Flag::all();
		$formattedFlags = array();
		foreach ($flags as $flag) {
			$formattedFlags[] = array(
					'id' => $flag->FlagID,
					'name' => $flag->narrative()->first()->Name,
					'narrativeID' => $flag->NarrativeID,
					'comment' =>$flag->Comment,
				);
		}

		return Response::json($formattedFlags);
	}
	
	/*
	*  Returns the number of flags per narrative
	*
	*
	*/
	public function getCount($NarrativeID){
		
	}
	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Store the specified narrative.
	 *
	 * @return Response
	 */
	public function store()
	{

	}

}
