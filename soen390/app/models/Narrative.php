<?php 

class Narrative extends Eloquent
{
	protected $table = 'Narrative';
	protected $primaryKey = 'NarrativeID';
	protected $softDelete = true;
	protected $guarded = array('id');
	public $timestamps = false;

	public function category()
	{
		return $this->belongsTo('Category', 'CategoryID', 'CategoryID');
	}

	public function langauge()
	{
		return $this->belongsTo('Language', 'LanguageID', 'LanguageID');
	}

	public function content()
	{
		return $this->hasMany('Content', 'NarrativeID', 'NarrativeID');
	}
}
