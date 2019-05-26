<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    protected $primaryKey = 'id'; // or null
//    public $incrementing = false;

    var $table = 'device_type';

    var $fillable = ['id', 'company', 'service_id'];

    var $hidden = ['created_at', 'updated_at'];

    var $dates = ['created_at', 'updated_at'];

    protected $dateFormat = 'Y-m-d H:i:s';

    public function service()
    {
        return $this->belongsTo('App\models\Service', 'service_id');
    }

}