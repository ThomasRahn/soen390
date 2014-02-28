<?php

/**
 * @codeCoverageIgnore
 */
class Media extends Eloquent
{

	protected $table   = 'media';
	protected $guarded = array('id');

	public function narrative()
	{
		return $this->belongsTo('Narrative');
	}

	public function scopeAudio($query)
	{
		return $query->where('type', 'audio');
	}

	public function scopeImages($query)
	{
		return $query->where('type', 'image');
	}

}

