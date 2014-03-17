<?php

/**
 * @author Thomas Rahn <thomas@rahn.ca>
 * @package Controller
 */
class AdminCommentController extends BaseController {

    public function destroy($id){
    	$comment = Comment::find($id);

        if (! $comment)
            return App::abort(404);

        $comment->flags()->delete();
        $comment->delete();
    }
}


