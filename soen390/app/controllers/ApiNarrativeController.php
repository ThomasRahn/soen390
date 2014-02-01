<?php

class ApiNarrativeController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$narratives = Narrative::all();
		$formattedNarratives = array();

		foreach ($narratives as $narrative) {
			$narrativePhoto = $narrative->content()->whereRaw('PicturePath IS NOT NULL')->first();

			$formattedNarratives[] = array(
					'id' => $narrative->NarrativeID,
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
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//
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
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}
