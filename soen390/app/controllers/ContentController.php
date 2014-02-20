<?php

class ContentController extends BaseController
{

	public function getContent($id)
	{
		$content = Content::find($id);

		if ($content === null)
			App::abort(404, 'Specified content does not exist.');

		// Get the storage path.
		$storagePath = Config::get('media.paths.processed');
		$fileName = null;

		if (($imagePath = $content->PicturePath) != null)
			$fileName = $imagePath;

		if (($audioPath = $content->AudioPath) != null)
			$fileName = $audioPath;

		if ($fileName === null)
			App::abort(404, 'Specified content not found.');

		return Response::download(
			$storagePath . DIRECTORY_SEPARATOR . $content->narrative()->first()->NarrativeID . DIRECTORY_SEPARATOR . $fileName
		);
	}

}

