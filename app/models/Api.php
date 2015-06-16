<?php

/*
|--------------------------------------------------------------------------
| Author 			: DuRenK
| Created_at		: 14/06/2015
|--------------------------------------------------------------------------
*/

class Api extends Eloquent {
		
	protected $guarded = array();
    protected $appends = array('api_url');
	public $timestamps = true;

	public function getApiUrlAttribute(){
		if (isset($this->attributes['id']) && $this->attributes['id']){
			return url($this->attributes['id']);
		}

		return null;
	}

}