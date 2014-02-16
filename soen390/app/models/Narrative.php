<?php 

class Narrative extends Eloquent{
	
	protected $table = "Narrative";
	public static $unguarded = true;
	public $timestamps = false;
	protected $primaryKey = 'NarrativeID';
	protected $softDelete = true;

	public function category(){
		return $this->belongsTo("Category", "CategoryID", "CategoryID");
	}
	public function langauge(){
		return $this->belongsTo("Language", "LanguageID", "LanguageID");
	}
	public function content(){
		return $this->hasMany("Content", "NarrativeID","NarrativeID");
	}

}
