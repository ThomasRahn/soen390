<?php

class NarrativeController extends \BaseController {

    /**
     * Display the specified resource.
     *
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
