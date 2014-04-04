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

    public function toResponseArray()
    {
        $response = array(
            'id'          => $this->TopicID,
            'name'        => $this->Name,
            'description' => $this->translations()
                ->inLocale(App::getLocale())
                ->first()
                ->translation,
            'narrativeCount' => $this->narratives()->count(),
            'published'   => $this->Published,
        );

        return $response;
    }

}
