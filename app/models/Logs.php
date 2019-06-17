<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class Logs extends Model
{
    protected $primaryKey = 'id'; // or null
//    public $incrementing = false;

    var $table = 'logs';

    var $fillable = ['id', 'user_id', 'item_id','item_type','item_data','action'];

//    var $hidden = ['created_at', 'updated_at'];

    var $dates = ['created_at', 'updated_at'];

    protected $dateFormat = 'Y-m-d H:i:s';

    public function getItemDataAttribute($value) {
        return json_decode($value,true);
    }

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

}