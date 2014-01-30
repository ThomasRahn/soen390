<?php

class UploadNarrativeController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		return View::make("admin/upload");
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
		$file = Input::file('narrative');
		
		$destination = "/home/r_thomas/narratives/test/";
                $zip = new ZipArchive();

                $filename = $file->getClientOriginalName();

                $file->move($destination, $filename);

                if($zip->open($destination . $filename) == TRUE){
                        $zip->extractTo($destination);
                        $zip->close();
                }

		//get information from XML file

		//Transcode mp3 files and change names

		
		return View::make("admin/upload")
				->with("msg", "got it");	
			
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
