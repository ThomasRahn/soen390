<?php

/**
 * @author  Thomas Rahn <thomas@rahn.ca>
 * @package Controller
 */
class NarrativeController extends \BaseController {

    /**
     * Display the specified resource.
     *
     * @author Thomas Rahn <thomas@rahn.ca>, Alan Ly <me@alanly.ca>
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $narrative = Narrative::find($id);

        if (! $narrative) App::abort(404, 'The specified narrative could not be found.');

        return View::make("narrative")
            ->with("narrative",$narrative);
    }

}
