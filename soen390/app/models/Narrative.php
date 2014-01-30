<?php 

class Narrative extends Eloquent{
	
	protected $table = "Narrative";

	public $timestamps = false;

	public function category(){
		return $this->belongsTo("Category", "CategoryID", "CategoryID");
	}
	public function langauge(){
		return $this->belongsTo("Language", "LanguageID", "LanguageID");
	}
	public function content(){
		return $this->hasMany("Content", "NarrativeID","NarrativeID");
	}
	public static function transcode(){

		return Queue::push(function($job) use(){

			// add transcoding stuff here


		}

	}

}
