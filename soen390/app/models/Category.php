<?php

/**
 * @codeCoverageIgnore
 */
class Category extends Eloquent
{

	protected $table = "Category";
	protected $primaryKey = 'CategoryID';
	public $timestamps = false;
	


	public function narrative(){
		return $this->hasMany('Narrative', 'CategoryID', 'CategoryID');
	}
}
