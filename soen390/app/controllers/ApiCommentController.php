<?php

use Carbon\Carbon;

/**
 * @package Controller
 */
class ApiCommentController extends \BaseController
{

    protected static $restful = true;
    protected $narrative      = null;
    protected $comment        = null;

    /**
     * @codeCoverageIgnore
     */
    public function __construct(Narrative $narrative, Comment $comment)
    {
        $this->narrative = $narrative;
        $this->comment   = $comment;
    }

    /**
     * @return Response
     */
    public function getNarrative($id)
    {
        $n = $this->narrative->with('comments')->find($id);

        if (! $n) {
            return Response::json(array(
                'success' => false,
                'return'  => 'The requested narrative could not be found.',
            ), 404);
        }

        $comments = $n->comments()->orderBy('DateCreated', 'desc')->get();

        $arrayedComments = array();

        foreach ($comments as $c) {
            $arrayedComments[] = $this->convertCommentToArray($c);
        }

        return Response::json(array(
            'success' => true,
            'return'  => $arrayedComments,
        ));
    }

    public function postNarrative($id)
    {
        $n = $this->narrative->find($id);

        if (! $n) {
            return Response::json(array(
                'success' => false,
                'return'  => 'The requested narrative could not be found.',
            ), 404);
        }

        $validator = Validator::make(
            Input::all(),
            array(
                'name'    => 'min:2|max:255',
                'comment' => 'required|min:10|max:255',
            )
        );

        if ($validator->fails()) {
            return Response::json(array(
                'success' => false,
                'return'  => $validator->errors()->toArray(),
            ), 400);
        }

        $name = Input::get('name');

        $comment = new Comment(array(
            'DateCreated' => Carbon::now(),
            'Name'        => ($name == '') ? 'Anonymous' : $name,
            'Comment'     => Input::get('comment'),
        ));

        if ($n->comments()->save($comment)) {
            return Response::json(array(
                'success' => true,
                'return'  => $this->convertCommentToArray($comment),
            ));
        } else {
            return Response::json(array(
                'success' => false,
                'return'  => 'Save operation failed.',
            ));
        }
    }

    /**
     * Given a $comment instance, it will convert that comment's relevant
     * properties into a keyed array. The resulting array can then be used
     * in the API response, with keys expected by the UI.
     *
     * @param  Comment  $comment
     * @return array
     */
    protected function convertCommentToArray(Comment $comment)
    {
        return array(
            'comment_id'   => $comment->CommentID,
            'narrative_id' => $comment->NarrativeID,
            'parent_id'    => $comment->CommentParentID,
            'created_at'   => with(new Carbon($comment->DateCreated))->diffForHumans(),
            'deleted_at'   => $comment->deleted_at,
            'name'         => e($comment->Name),
            'agrees'       => $comment->Agrees,
            'disagrees'    => $comment->Disagrees,
            'indifferents' => $comment->Indifferents,
            'body'         => e($comment->Comment),
        );
    }

}
