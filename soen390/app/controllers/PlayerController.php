<?php

/**
 * @author  Alan Ly <me@alanly.ca>
 * @package Controller
 */
class PlayerController extends \BaseController
{
    protected static $restful = true;
    protected $narrative = null;

    /**
     * @codeCoverageIgnore
     */
    public function __construct(Narrative $narrative)
    {
        $this->narrative = $narrative;
    }

    /**
     * @return Response
     */
    public function getPlay($id)
    {
        $n = $this->narrative->find($id);

        if (! $n)
            App::abort(404, 'Unable to find the requested narrative.');

        return View::make('player.popup')
            ->with('narrativeApiPath', action('ApiNarrativeController@show', array('id' => $n->NarrativeID)))
            ->with('commentsApiPath', action('ApiCommentController@getNarrative', array('id' => $n->NarrativeID)));
    }
}
