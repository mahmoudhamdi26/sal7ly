<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class Problem extends Model {
    protected $primaryKey = 'id'; // or null
//    public $incrementing = false;

    var $table = 'problems';

    var $fillable = [ 'id', 'desc', 'user_id' ];

    var $hidden = [ 'created_at', 'updated_at' ];

    var $dates = [ 'created_at', 'updated_at' ];

    protected $dateFormat = 'Y-m-d H:i:s';

}