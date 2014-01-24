<?php 

class Content extends Eloquent {

	protected $table = "Content";
	public $timestamps = false;
	
	public function narrative(){
		return $this->belongsTo('Narrative', 'NarrativeID', 'NarrativeID');
	}
	public function category(){
		return $this->belongsTo('Category', 'CategoryID', 'CategoryID');
	}
	public function comment(){
		return $this->belongsTo('Comment','CommentID', 'CommentID');
	}
}
