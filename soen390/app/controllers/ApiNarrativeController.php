<?php

class ApiNarrativeController extends \BaseController {

	public function __construct()
	{
		// Ensure that user is authenticated for all write/update routes.
		$this->beforeFilter('auth.api', array(
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
					'stance' => $narrative->category()->first()->Description,
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
		$validator = Validator::make(Input::all(), array(
				'archive' => 'required|mimes:zip',
				'category' => 'required|exists:Category,CategoryID'
			));

		if ($validator->fails())
			return Response::json(array(
					'success' => false,
					'error' => $validator->errors()->toJson()
				), 400);

		$file = Input::file('archive');

		// Figure out a uniquely identifying name for this archive.
		$originalName = $file->getClientOriginalName();
		$hashedName = hash('sha256', Session::getId() . $originalName . time());
		$hashedFullName = $hashedName . '.' . $file->getClientOriginalExtension();

		$file->move(Config::get('media.paths.uploads'), $hashedFullName);

		// Determine the destination of where the archive has been moved to.
		$destinationPath = Config::get('media.paths.uploads') . '/' . $hashedFullName;

		// Process the archive
		try {
			Narrative::addArchive($hashedName, $destinationPath);
		} catch (Exception $e) {
			return Response::json(array(
				'success' => false,
				'error' => $e->getMessage()
			), 500);
		}

		return Response::json(array(
			'success' => true,
			'return' => 'Upload is queued for processing.',
		));
	}
}
