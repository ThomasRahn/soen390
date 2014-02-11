<?php


class Comment extends Eloquent{

	protected $table = "Comment";
	protected $primaryKey = 'CommentID';

	public $timestamps = false;

	public function narrative(){
		return $this->belongsTo("Narrative", "NarrativeID","NarrativeID");
	}
	public function comment(){
		return $this->belongsTo("Comment", "CommentParentID", "CommentID");
	}
}
