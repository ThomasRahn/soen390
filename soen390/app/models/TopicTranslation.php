<?php

/**
 * Provides for the translation of Topic descriptions for locales supported by the system.
 *
 * @author  Alan Ly <me@alanly.ca>
 * @package Model
 */
class TopicTranslation extends \Eloquent
{

    protected $guarded = array('id');
    protected $table   = 'topic_translation';

    /**
     * @codeCoverageIgnore
     */
    public function language()
    {
        $this->belongsTo('Language', 'language_id', 'LanguageID');
    }

    /**
     * @codeCoverageIgnore
     */
    public function topic()
    {
        $this->belongsTo('Topic', 'topic_id', 'TopicID');
    }

}
