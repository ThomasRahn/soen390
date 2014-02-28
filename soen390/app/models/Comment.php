<?php

/**
 * @codeCoverageIgnore
 */
class Comment extends Eloquent
{

class Comment extends Eloquent{

	protected $table = "Comment";
	protected $primaryKey = 'CommentID';
	protected $softDelete = true;
	public $timestamps = false;
	public static $unguarded = true;

	public function narrative(){
		return $this->belongsTo("Narrative", "NarrativeID","NarrativeID");
	}
//	public function comment(){
//		return $this->belongsTo("Comment", "CommentParentID", "CommentID");
//	}
}
