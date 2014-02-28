<?php

/**
 * @codeCoverageIgnore
 */
class Flag extends Eloquent{

	protected $table = "Flag";
	public $timestamps = false;
	protected $primaryKey = 'FlagID';
	protected $softDelete = true;
	public function narrative(){
		return $this->belongsTo('Narrative','NarrativeID','NarrativeID');
	}
}
