<?php

use Illuminate\Database\Eloquent\Builder;

/**
 * Provides for the translation of Topic descriptions for locales supported by the system.
 *
 * @author  Alan Ly <me@alanly.ca>
 * @package Model
 */
class TopicTranslation extends \Eloquent
{

    protected $guarded = array('id');
    protected $table   = 'topic_translations';

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

    /**
     * Returns an apppropriate query scope for the translation of a Topic
     * with the given locale.
     *
     * @param  Builder  $query
     * @param  string   $localeCode
     * @return Builder
     */
    public function scopeInLocale(Builder $query, $localeCode)
    {
        return $query->where(
            'language_id',
            Language::where('code', $localeCode)->first()->LanguageID
        );
    }

}
