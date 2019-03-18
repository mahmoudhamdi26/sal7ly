<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class LogicException extends Model
{
    protected $primaryKey = 'id'; // or null
//    public $incrementing = false;

    var $table = 'logic_exceptions';

    var $fillable = ['id', 'msg', 'for_type', 'for_id', 'action_name'];

    var $hidden = ['created_at','updated_at'];
    
    protected $dateFormat = 'Y-m-d H:i:s';
}
