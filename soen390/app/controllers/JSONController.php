<?php

class JSONController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//
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
		$narrative = Narrative::where('NarrativeID',$id)->first();
		$content = $narrative->content()->get();	
		$audio_path = Config::get('narrativePath.paths.audio');
                $picture_path = Config::get('narrativePath.paths.picture');
		$narrative_paths = array();
		foreach($content as $path){
			$temp_audio = $audio_path . $path->AudioPath;
			if($path->PicturePath != 0)
				$temp_pic = $picture_path  . $path->PicturePath;
			$narrative_paths[$path->ContentID] = 
					array("title"=>$path->ContentID,"mp3"=>$temp_audio,
						"poster"=>$temp_pic, "duration"=>$path->duration);
		} 
		return json_encode($narrative_paths);
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
