<?php

/**
 * @package Model
 */
class Flag extends Eloquent{

    protected $table      = 'Flag';
    protected $primaryKey = 'FlagID';
    protected $softDelete = true;
    protected $guarded    = array('FlagID');
    public    $timestamps = false;

    public function narrative()
    {
        return $this->belongsTo('Narrative', 'NarrativeID', 'NarrativeID');
    }
	public function comment()
    {
        return $this->belongsTo('Comment', 'CommentID', 'CommentID');
    }
}
