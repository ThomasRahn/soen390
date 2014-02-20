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
		$narratives = null;

		// Retrieve all published and unpublished narratives if user is
		// authenticated and requests so.
		if (Auth::check() && Input::get('withUnpublished', 0) == 1)
			$narratives = Narrative::with('category', 'language')->get();
		else
			$narratives = Narrative::with('category', 'language')->where('Published', 1)->get();

		// Create an array to hold all the narratives. This array will be converted into a JSON object.
		$narrativesArray = array();

		foreach ($narratives as $n)
			$narrativesArray[] = $this->narrativeToArray($n);

		return Response::json(array(
			'success' => true,
			'return' => $narrativesArray,
		));
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		if (Auth::check() && Input::get('withUnpublished', 0) == 1)
			$narrative = Narrative::with('category', 'language')->find($id);
		else
			$narrative = Narrative::with('category', 'language')->where('Published', 1)->find($id);

		if ($narrative == null)
			return Response::json(array(
				'success' => false,
				'error' => 'Narrative not found.',
			), 404);

		return Response::json(array(
			'success' => true,
			'return' => $this->narrativeToArray($narrative),
		));
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
			Narrative::addArchive($hashedName, $destinationPath, Input::get('category'), (Input::get('publish') == 'publish'));
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

	/**
	 * Given narrative $n, will return it in an array apporpiately
	 * formatted for JSON responses.
	 *
	 * @param  Narrative  $n
	 * @return array
	 */
	private function narrativeToArray($n)
	{
		// Get all the image content for this narrative.
		$imagePaths = array();
		$images = $n->content()->images()->orderBy('PicturePath')->get();

		foreach ($images as $i)
			$imagePaths[] = action('ContentController@getContent', array('id' => $i->ContentID));

		if (count($imagePaths) == 0)
			$imagePaths[] = asset('img/default_narrative.jpg');

		// Get all the audio content for this narrative.
		$audioPaths = array();
		$audio = $n->content()->audio()->orderBy('AudioPath')->get();

		foreach ($audio as $a)
			$audioPaths[] = action('ContentController@getContent', array('id' => $a->ContentID));

		// Put this narrative into the array.
		$narrative = array(
			'id' => $n->NarrativeID,
			'name' => $n->Name,
			'stance' => $n->category()->first()->Description,
			'lang' => $n->language()->first()->Description,
			'views' => $n->Views,
			'yays' => $n->Agrees,
			'nays' => $n->Disagrees,
			'mehs' => $n->Indifferents,
			'createdAt' => $n->DateCreated,
			'published' => $n->Published,
			'images' => $imagePaths,
			'audio' => $audioPaths,
		);

		return $narrative;
	}

}
