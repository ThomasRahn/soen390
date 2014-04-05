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

    /**
     * Returns all associated translations of Topic description in an array.
     * Array `key` is the language code identifier.
     *
     * @return array
     */
    public function getTranslationsAsArray()
    {
        $translations = array();

        foreach ($this->translations()->get() as $t) {
            $language = $t->language()->first();

            $translations[$language->Code] = $t->toArray();
        }

        return $translations;
    }

    /**
     * Return this Topic instance as an array that has been appropriately
     * organized for JSON responses.
     *
     * @return array
     */
    public function toResponseArray()
    {
        $response = array(
            'id'             => $this->TopicID,
            'name'           => $this->Name,
            'narrativeCount' => $this->narratives()->count(),
            'published'      => $this->Published,
            'descriptions'   => $this->getTranslationsAsArray(),
            'description'    => $this->translations()
                ->inLocale(App::getLocale())
                ->first()
                ->translation,
        );

        return $response;
    }

}
