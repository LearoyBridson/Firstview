<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    public function user() {
    	return $this->belongsTo(User::class);
    }
	
	public function asset() {
		return $this->hasMany(Asset::class);
	}
}
