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
    protected $flag           = null;

    /**
     * @codeCoverageIgnore
     */
    public function __construct(Narrative $narrative, Comment $comment, Flag $flag)
    {
        $this->narrative = $narrative;
        $this->comment   = $comment;
        $this->flag      = $flag;
    }

    /**
     * @return Response
     */
    public function getNarrative($id)
    {
        if (Auth::check() && Input::get('withUnpublished') === '1') {
            $n = $this->narrative->with('comments')->find($id);
        } else {
            $n = $this->narrative->with('comments')->where('Published', true)->find($id);
        }

        if (! $n) {
            return Response::json(array(
                'success' => false,
                'return'  => 'The requested narrative could not be found.',
            ), 404);
        }

        $comments = $n->comments()->whereNull('CommentParentID')->orderBy('DateCreated', 'desc')->get();

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
     * Creates a comment for narrative $id.
     *
     * @param  integer  $id
     * @return Response
     */
    public function postNarrative($id)
    {
        $n = $this->narrative->where('Published', true)->find($id);

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
                'comment' => 'required|min:3|max:255',
                'parent'  => 'exists:Comment,CommentID',
            )
        );

        if ($validator->fails()) {
            return Response::json(array(
                'success' => false,
                'return'  => $validator->errors()->toArray(),
            ), 400);
        }

        $name = Input::get('name');

        $params = array(
            'NarrativeID'     => $n->NarrativeID,
            'CommentParentID' => Input::get('parent', null),
            'DateCreated'     => Carbon::now(),
            'Name'            => ($name == '') ? 'Anonymous' : $name,
            'Comment'         => Input::get('comment'),
        );

        if ($comment = $this->comment->create($params)) {
            return Response::json(array(
                'success' => true,
                'return'  => $this->convertCommentToArray($comment),
            ));
        } else {
            return Response::json(array(
                'success' => false,
                'return'  => 'Save operation failed.',
            ), 500);
        }
    }

    /**
     * Creates a flag for comment $id.
     *
     * @param  integer  $id
     * @return Response
     */
    public function postFlag($id)
    {
        if (! Input::has('reasoning')) {
            return Response::json(array(
                'success' => false,
                'return'  => 'Missing "reasoning" (string) request parameter.',
            ), 400);
        }

        $c = $this->comment->with('narrative')->find($id);

        if (! $c || ! $c->narrative()->first()->Published) {
            return Response::json(array(
                'success' => false,
                'return'  => 'The requested comment could not be found.',
            ), 404);
        }

        $f = $this->flag->create(array(
            'CommentID' => $c->CommentID,
            'Comment'   => Input::get('reasoning'),
        ));

        if (! $f) {
            return Response::json(array(
                'success' => false,
                'return'  => 'Save operation failed.',
            ), 500);
        }

        return Response::json(array(
            'success' => true,
            'return'  => $this->convertCommentToArray($c),
        ));
    }

    /**
     * Updates the votes for a comment $id.
     *
     * @param  integer  $id
     * @return Response
     */
    public function postVote($id)
    {
        if (! Input::has('agree')) {
            return Response::json(array(
                'success' => false,
                'return'  => 'Missing "agree" (boolean) request parameter.',
            ), 400);
        }

        $c = $this->comment->with('narrative')->find($id);

        if (! $c || ! $c->narrative()->first()->Published) {
            return Response::json(array(
                'success' => false,
                'return'  => 'The requested comment could not be found.',
            ), 404);
        }

        $hasChanged = false;
        $agree      = Input::get('agree');
        $swap       = Input::get('swap', false) === 'true';

        if ($agree === 'true') {
            ++$c->Agrees;

            if ($swap) {
                --$c->Disagrees;
            }

            $hasChanged = true;
        } else if ($agree === 'false') {
            ++$c->Disagrees;

            if ($swap) {
                --$c->Agrees;
            }
            
            $hasChanged = true;
        }

        $saved = false;

        if ($hasChanged) {
            $saved = $c->save();
        }

        if ($saved) {
            return Response::json(array(
                'success' => true,
                'return'  => $this->convertCommentToArray($c),
            ));
            // @codeCoverageIgnoreStart
        } else {
            return Response::json(array(
                'success' => false,
                'return'  => 'An error occurred while attempting to save the vote.',
            ), 500);
            // @codeCoverageIgnoreEnd
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
        // Retrieve commment flag count.
        $flagCount = Flag::where('CommentID',$comment->CommentID)->count();

        // Retrieve all subcomments.

        $subcomments = array();

        foreach($comment->comments()->get() as $c) {
            $subcomments[] = $this->convertCommentToArray($c);
        }

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
            'report_count' => $flagCount,
            'children'     => $subcomments,
        );
    }

}
