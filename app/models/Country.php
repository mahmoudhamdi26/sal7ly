<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class Country extends Model {
	protected $primaryKey = 'id'; // or null
//    public $incrementing = false;

	var $table = 'countries';

	var $fillable = [ 'id', 'name', 'code', 'name_ar' ];

	var $hidden = [ 'created_at', 'updated_at' ];

	var $dates = [ 'created_at', 'updated_at' ];

	protected $dateFormat = 'Y-m-d H:i:s';

}
