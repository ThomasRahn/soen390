<?php 

class Language extends Eloquent{

	protected $table = "Language";

	protected $primaryKey = 'LanguageID';

	public $timestamps = false;

	public function narrative(){
		return $this->hasMany('Narrative', 'LanguageID', 'LanguageID');
	}
}
