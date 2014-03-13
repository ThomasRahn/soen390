<?php

/**
 * @author Thomas Rahn <thomas@rahn.ca>
 * @package Controller
 */
class AdminCommentController extends BaseController {

    public function getIndex($id)
    {
        return View::make('admin.narratives.comments')->with("NarrativeID",$id);
    }

    public function destroy($id){
    	$comment = Comment::find($id);

        if (! $comment)
            return App::abort(404);

        $comment->flags()->delete();
        $comment->delete();
    }
}


