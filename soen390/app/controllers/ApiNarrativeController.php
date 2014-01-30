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
			$formattedNarratives[] = array(
					'id' => $narrative->NarrativeID,
					'start_year' => $narrative->category()->first()->Name,
					'image_link' => asset('pictures/' . $narrative->content()->whereRaw('PicturePath IS NOT NULL')->first()->PicturePath),
					'language' => $narrative->langauge()->first()->Description,
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
