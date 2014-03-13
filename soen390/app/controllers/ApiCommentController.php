<?php

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

        $comments = $n->comments()->orderBy('DateCreated')->get();

        $arrayedComments = array();

        foreach ($comments as $c) {
            $arrayedComments[] = $this->convertCommentToArray($c);
        }

        return Response::json(array(
            'success' => true,
            'return'  => $arrayedComments,
        ));
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
        $flagCount = Flag::where('CommentID',$comment->CommentID)->count();
        return array(
            'comment_id'   => $comment->CommentID,
            'narrative_id' => $comment->NarrativeID,
            'parent_id'    => $comment->CommentParentID,
            'created_at'   => with(new Carbon\Carbon($comment->DateCreated))->diffForHumans(),
            'deleted_at'   => $comment->deleted_at,
            'name'         => e($comment->Name),
            'agrees'       => $comment->Agrees,
            'disagrees'    => $comment->Disagrees,
            'indifferents' => $comment->Indifferents,
            'body'         => e($comment->Comment),
            'report_count'   => $flagCount,
        );
    }

}
