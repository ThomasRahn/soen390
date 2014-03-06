<?php
/**
 * @author  Thomas Rahn <thomas@rahn.ca>
 * @package Controller
 */
class ApiCommentController extends \BaseController{


	/**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $narrative = Input::get('NarrativeID');

        $comments = Comment::where('NarrativeID', $narrative)->with('narrative')->get();

        $commentArray = array();

        foreach ($comments as $comment) {
            $commentArray[] = array(
                    'id'          => $comment->CommentID,
                    'name'          => $comment->Name,
                    'narrativeID' => $comment->NarrativeID,
                    'comment'     => $comment->Comment,
                    'agrees'     => $comment->Agrees,
                    'disagress'     => $comment->Disagrees,
                );
        }

        return Response::json($commentArray);
    }

}

