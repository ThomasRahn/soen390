<?php

/**
 * @codeCoverageIgnore
 */
class Comment extends Eloquent
{

    protected $table      = 'Comment';
    protected $primaryKey = 'CommentID';
    protected $softDelete = true;
    public    $timestamps = false;
    public    $guarded    = array('CommentID');

    public function narrative()
    {
        return $this->belongsTo("Narrative", "NarrativeID","NarrativeID");
    }

}
