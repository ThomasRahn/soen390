<?php 

class Content extends Eloquent {

	protected $table = "Content";
	protected $guarded = array('ContentID');
	public $timestamps = false;
	protected $primaryKey = 'ContentID';
	
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
