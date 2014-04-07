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
        $this->beforeFilter('maintenance');
        $this->narrative = $narrative;
    }

    /**
     * @return Response
     */
    public function getPlay($id)
    {
        $wildcards = array('id' => $id);

        if (Auth::check() && Input::get('withUnpublished', 0) == 1) {
            $wildcards['withUnpublished'] = 1;
            $n = $this->narrative->find($id);
        } else {
            $n = $this->narrative->where('Published', 1)->find($id);
        }

        if (! $n)
            App::abort(404, 'Unable to find the requested narrative.');

        return View::make('player.popup')
            ->with('narrativeApiPath', action('ApiNarrativeController@show', $wildcards))
            ->with('commentsApiPath', action('ApiCommentController@getNarrative', $wildcards));
    }
}
