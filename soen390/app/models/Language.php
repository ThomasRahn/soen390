<?php 

/**
 * @codeCoverageIgnore
 */
class Language extends Eloquent
{

	protected $table      = 'Language';
	protected $primaryKey = 'LanguageID';
	public    $timestamps = false;
    public    $guarded    = array('LanguageID');

	public function narrative()
    {
		return $this->hasMany('Narrative', 'LanguageID', 'LanguageID');
	}

}
