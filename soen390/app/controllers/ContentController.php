<?php

use Carbon\Carbon;

/**
 * @author  Alan Ly <me@alanly.ca>
 * @package Controller
 */
class ContentController extends BaseController
{

	public function getContent($id)
	{
		$media = Media::find($id);

		if ($media === null)
			App::abort(404, 'Specified content does not exist.');

		// Get the storage path.
		$storagePath = Config::get('media.paths.processed');

		return Response::download(
			$storagePath . DIRECTORY_SEPARATOR . $media->narrative_id . DIRECTORY_SEPARATOR . $media->basename,
			null,
			array(
				'Expires' => Carbon::now()->addDay()->toRFC2822String(),
			)
		);
	}

}

