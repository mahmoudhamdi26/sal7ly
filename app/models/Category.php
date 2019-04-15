<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model {
    protected $primaryKey = 'id'; // or null
//    public $incrementing = false;

    var $table = 'category';

    var $fillable = [ 'id', 'name' ];

    var $hidden = [ 'created_at', 'updated_at' ];

    var $dates = [ 'created_at', 'updated_at' ];

    protected $dateFormat = 'Y-m-d H:i:s';

}