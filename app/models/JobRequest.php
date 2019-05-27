<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class JobRequest extends Model
{
    protected $primaryKey = 'id'; // or null
//    public $incrementing = false;

    var $table = 'service_request';

    var $fillable = ['id', 'desc', 'needed_at', 'job_type_id', 'user_id', 'service_id', 'device_type_id'];

    var $hidden = ['created_at', 'updated_at'];

    var $dates = ['created_at', 'updated_at', 'needed_at'];

    protected $dateFormat = 'Y-m-d H:i:s';

    public function job_type()
    {
        return $this->belongsTo('App\models\JobType', 'job_type_id');
    }

    public function service()
    {
        return $this->belongsTo('App\models\Service', 'service_id');
    }

    public function device_type()
    {
        return $this->belongsTo('App\models\Device', 'device_type_id');
    }

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

}