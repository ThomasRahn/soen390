<?php 

/**
 * @package Model
 */
class Language extends Eloquent
{

    protected $table      = 'Language';
    protected $primaryKey = 'LanguageID';
    public    $timestamps = false;
    public    $guarded    = array('LanguageID');

    /**
     * @codeCoverageIgnore 
     */
    public function narrative()
    {
        return $this->hasMany('Narrative', 'LanguageID', 'LanguageID');
    }

}
