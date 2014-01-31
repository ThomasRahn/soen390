<?php

class UploadNarrativeController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$category = Category::all();		
		return View::make("admin/upload")
			->with('category',$category);
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
		$category = Input::get('category');
		$datetime = new DateTime();		

	
		$destination = "/home/r_thomas/narratives/test/";
                $zip = new ZipArchive();

                $filename = $file->getClientOriginalName();

                $file->move($destination, $filename);

                if($zip->open($destination . $filename) == TRUE){
                        $zip->extractTo($destination);
                        $zip->close();
                }
		unlink($destination . $filename);	
		$directories = scandir($destination);
		for($i = 2; $i< count($directories); $i++){
			foreach(scandir($destination . $directories[$i]) as $name) {
			    if(substr($name,-4) == ".xml"){
				    $xml_file = file_get_contents($destination . $directories[$i] ."/". $name, FILE_TEXT);
		        	    $xmlcont = new SimpleXMLElement($xml_file);
				    $language = DB::table('Language')->where("Description","like",$xmlcont->language)->first();
				    $narrative = Narrative::create(array('Name'=>$xmlcont->narrativeName, 'CategoryID'=>$category, 'LanguageID'=>$language->LanguageID, 'DateCreated'=>$datetime));
			    }
			 } 
		}
		//Transcode mp3 files and change names
		$category = Category::all();
                return View::make("admin/upload")
                        ->with('category',$category);
	
	
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
