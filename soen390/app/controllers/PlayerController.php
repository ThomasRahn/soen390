<?php

/**
 * @author  Alan Ly <me@alanly.ca>
 * @package Controller
 */
class PlayerController extends \BaseController
{
    protected $narrative = null;

    public function __construct(Narrative $narrative)
    {
        $this->narrative = $narrative;
    }

    /**
     * @return Response
     */
    public function getIndex($id)
    {
        $n = $this->narrative->find($id);

        if (! $n)
            App::abort(404, 'Unable to find the requested narrative.');

        return View::make('player.popup')
            ->with('apiPath', action('ApiNarrativeController@show', array('id' => $n->NarrativeID)));
    }
}
