<?php

/**
 * @codeCoverageIgnore
 */
class Flag extends Eloquent{

    protected $table      = 'Flag';
    protected $primaryKey = 'FlagID';
    protected $softDelete = true;
    public    $timestamps = false;

    public function narrative()
    {
        return $this->belongsTo('Narrative','NarrativeID','NarrativeID');
    }

}
