<?php

class ApiCategoryController extends BaseController
{

	/**
	 * Retrieves a listing of all categories available.
	 *
	 * @return Response
	 */
	public function index()
	{
		return Response::json(array(
			'success' => true,
			'return'  => Category::all()->toArray(),
		));
	}

}

