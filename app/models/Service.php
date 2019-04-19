<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $primaryKey = 'id'; // or null
//    public $incrementing = false;

    var $table = 'service';

    var $fillable = ['id', 'name', 'desc', 'category_id'];

    var $hidden = ['created_at', 'updated_at'];

    var $dates = ['created_at', 'updated_at'];

    protected $dateFormat = 'Y-m-d H:i:s';

    public function category()
    {
        return $this->belongsTo('App\models\Category', 'category_id');
    }

    public function job_types()
    {
        return $this->hasMany("App\models\JobType");
    }
}