<?php 

class Narrative extends Eloquent{
	
	protected $table = "Narrative";

	public $timestamps = false;

	public function category(){
		return $this->belongsTo("Category", "CategoryID", "CategoryID");
	}
	public function langauge(){
		return $this->belongsTo("Language", "LanguageID");
	}
	public function content(){
		return $this->hasMany("Content", "NarrativeID","NarrativeID");
	}

}
