<?php

class Flag extends Eloquent{

	protected $table = "Flag";
	public $timestamps = false;
	protected $primaryKey = 'FlagID';

	public function narrative(){
		return $this->belongsTo('Narrative','NarrativeID','NarrativeID');
	}
}
