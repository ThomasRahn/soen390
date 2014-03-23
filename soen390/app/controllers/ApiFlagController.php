<?php

/**
 * @author  Thomas Rahn <thomas@rahn.ca>
 * @package Controller
 */
class ApiFlagController extends \BaseController {

    /**
     * @codeCoverageIgnore
     */
    public function __construct()
    {
        $this->beforeFilter('auth', array(
            'except' => array('index', 'show'))
        );
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $narrative = Input::get('NarrativeID');

        $flags = Flag::where('NarrativeID', $narrative)->with('narrative')->get();

        $flagArray = array();

        foreach ($flags as $flag) {
            $flagArray[] = array(
                    'id'          => $flag->FlagID,
                    'name'        => $flag->narrative()->first()->Name,
                    'narrativeID' => $flag->NarrativeID,
                    'comment'     => $flag->Comment,
                );
        }

        return Response::json($flagArray);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function show()
    {
        $comment = Input::get('CommentID');

        $flags = Flag::where('CommentID', $comment)->with('comment')->get();

        $flagArray = array();

        foreach ($flags as $flag) {
            $flagArray[] = array(
                    'id'          => $flag->FlagID,
                    'name'        => $flag->comment()->first()->Name,
                    'commentID'   => $flag->CommentID,
                    'comment'     => $flag->Comment,
                );
        }

        return Response::json($flagArray);
    }

}
