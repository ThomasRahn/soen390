<?php

/**
 * @package Model
 */
class Topic extends Eloquent
{

    protected $guarded    = array('TopicID');
    protected $primaryKey = 'TopicID';
    protected $table      = 'Topic';

    /**
     * @codeCoverageIgnore
     */
    public function narratives()
    {
        return $this->hasMany('Narrative', 'TopicID', 'TopicID');
    }

    /**
     * @codeCoverageIgnore
     */
    public function translations()
    {
        return $this->hasMany('TopicTranslation', 'topic_id', 'TopicID');
    }

}
