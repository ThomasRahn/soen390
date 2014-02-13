<?php

class ApiNarrativeController extends \BaseController {

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
		$narratives = Narrative::all();
		$formattedNarratives = array();
		$picture_path = Config::get('narrativePath.paths.picture');
		foreach ($narratives as $narrative) {
			$narrativePhoto = $narrative->content()->whereRaw('PicturePath IS NOT NULL')->first();

			$formattedNarratives[] = array(
					'id' => $narrative->NarrativeID,
					'name' => $narrative->Name,
					'stance' => $narrative->category()->first()->Name,
					'lang' => $narrative->langauge()->first()->Description,
					'views' => $narrative->Views,
					'yays' => $narrative->Agrees,
					'nays' => $narrative->Disagrees,
					'mehs' => $narrative->Indifferents,
					'createdAt' => $narrative->DateCreated,
					'imageLink' => isset($narrativePhoto) ? asset('pictures/' . $narrativePhoto->PicturePath) : asset('img/default_narrative.jpg'),
				);
		}

		return Response::json($formattedNarratives);
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
