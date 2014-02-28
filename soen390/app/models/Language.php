<?php 

/**
 * @codeCoverageIgnore
 */
class Language extends Eloquent
{

	protected $primaryKey = 'LanguageID';

	public $timestamps = false;

	public function narrative(){
		return $this->hasMany('Narrative', 'LanguageID', 'LanguageID');
	}
}
