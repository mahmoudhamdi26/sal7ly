<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Permission
 */
class Permission extends Model
{
    protected $table = 'permissions';

    public $timestamps = true;
    protected $dateFormat = 'Y-m-d H:i:s';


    protected $fillable = [
        'label',
        'type'
    ];

    protected $guarded = [];

    public function functions(){
        return $this->hasMany('App\models\Functions', 'permissions_id');
    }



        
}