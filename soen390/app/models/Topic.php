<?php

/**
 * @package Model
 */
class Topic extends Eloquent
{

    protected $table      = 'Topic';
    protected $primaryKey = 'TopicID';
    protected $guarded    = array('TopicID');
    public    $timestamps = false;

    /**
     * @codeCoverageIgnore
     */
    public function narratives()
    {
        return $this->hasMany('Narrative', 'TopicID', 'TopicID');
    }

}
