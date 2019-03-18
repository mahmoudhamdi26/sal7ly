<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    protected $table = 'logs';

    public $timestamps = false;

    protected $dateFormat = 'Y-m-d H:i:s';

    protected $fillable = [
        'who', 'what', 'users_id', 'controller', 'method', 'type_id', 'old_data', 'new_data', 'msg'
    ];

    protected $hidden = ['created_at', 'updated_at'];

    protected $dates = ['created_at', 'updated_at'];

    protected $guarded = [];

    public function user(){
            return $this->belongsTo('App\User', 'users_id');
    }
}
