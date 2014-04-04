<?php

/**
 * @author  Alan Ly <me@alanly.ca>
 * @package Controller
 */
class ApiNarrativeController extends \BaseController
{

	protected $narrative;

	/**
	 * @codeCoverageIgnore
	 */
	public function __construct(Narrative $narrative)
	{
		// Ensure that user is authenticated for all write/update routes.
		$this->beforeFilter('auth.api', array(
			'except' => array('index', 'show'))
		);

		$this->narrative = $narrative;
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
		if (Auth::check() && Input::get('withUnpublished', 0) == '1') {
			$narratives = Narrative::with('category', 'language', 'media')->get();
		} else {
			$topic = Session::get('selectedTopic', Topic::get()->last());

			$narratives = $topic->narratives()->with('category', 'language', 'media')->where('Published', 1)->get();
		}

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
		if (Auth::check() && Input::get('withUnpublished', 0) == '1')
			$narrative = Narrative::with('category', 'language', 'media')->find($id);
		else
			$narrative = Narrative::with('category', 'language', 'media')->where('Published', 1)->find($id);

		if ($narrative == null)
			return Response::json(array(
				'success' => false,
				'error' => 'Narrative not found.',
			), 404);

		// Increment the view count.
		$narrative->Views = $narrative->Views + 1;
		$narrative->save();

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
			'archive'  => 'required|mimes:zip',
			'category' => 'required|exists:Category,CategoryID',
			'topic'    => 'required|exists:Topic,TopicID',
		));

		if ($validator->fails())
			return Response::json(array(
				'success' => false,
				'error'   => $validator->errors()->toArray(),
			), 400);

		$file = Input::file('archive');

		// Figure out a uniquely identifying name for this archive.
		$originalName   = $file->getClientOriginalName();
		$hashedName     = hash('sha256', Session::getId() . $originalName . time());
		$hashedFullName = $hashedName . '.' . $file->getClientOriginalExtension();

		if (App::environment('testing')) {
			File::copy(
				$file->getRealPath(),
				Config::get('media.paths.uploads') . DIRECTORY_SEPARATOR . $hashedFullName
			);
		} else {
			// @codeCoverageIgnoreStart
			$file->move(Config::get('media.paths.uploads'), $hashedFullName);
			// @codeCoverageIgnoreEnd
		}

		// Determine the destination of where the archive has been moved to.
		$destinationPath = Config::get('media.paths.uploads') . DIRECTORY_SEPARATOR . $hashedFullName;

		// Process the archive
		try {
			$this->narrative->addArchive(
				$hashedName,
				$destinationPath,
				Input::get('category'),
				Input::get('publish') == 'publish',
				Input::get('topic')
			);
		} catch (Exception $e) {
			$errorArray = array($e->getMessage());

			if (Config::get('app.debug') === true)
				$errorArray[] = $e->getTrace();

			return Response::json(array(
				'success' => false,
				'error'   => $errorArray,
			), 500);
		}

		return Response::json(array(
			'success' => true,
			'return'  => 'Upload is queued for processing.',
		));
	}

	/**
	 * Update the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$narrative = $this->narrative->find($id);

		if ($narrative == null)
			return Response::json(array(
				'success' => false,
				'error' => 'Unable to find the requested narrative.',
			), 404);

		$validator = Validator::make(Input::all(), array(
			'category'     => 'exists:Category,CategoryID',
			'topic'        => 'exists:Topic,TopicID',
			'language'     => 'exists:Language,LanguageID',
			'name'         => 'alpha_num|min:1',
			'views'        => 'integer',
			'agrees'       => 'integer',
			'disagrees'    => 'integer',
			'indifferents' => 'integer',
			'published'    => 'in:0,1,true,false',
		));

		if ($validator->fails())
			return Response::json(array(
				'success' => false,
				'error' => $validator->errors()->toArray(),
			), 400);

		$narrative->CategoryID   = Input::get('category',     $narrative->CategoryID);
		$narrative->TopicID      = Input::get('topic',        $narrative->TopicID);
		$narrative->LanguageID   = Input::get('language',     $narrative->LanguageID);
		$narrative->Name         = Input::get('name',         $narrative->Name);
		$narrative->Views        = Input::get('views',        $narrative->Views);
		$narrative->Agrees       = Input::get('agrees',       $narrative->Agrees);
		$narrative->Disagrees    = Input::get('disagrees',    $narrative->Disagrees);
		$narrative->Indifferents = Input::get('indifferents', $narrative->Indifferents);

		if (Input::has('published'))
			$narrative->Published = Input::get('published') === 1 || Input::get('published') === 'true';

		if ($narrative->save() === false)
			return Response::json(array(
				'success' => false,
				'error'   => 'Unable to save changes to narrative.',
			), 500);

		return Response::json(array(
			'success' => true,
			'return'  => $this->narrativeToArray($narrative),
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
		return $n->toResponseArray();
	}

}

