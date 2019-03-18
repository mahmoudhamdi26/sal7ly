<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Role
 */
class Role extends Model
{
    protected $table = 'roles';

    public $timestamps = true;
    protected $dateFormat = 'Y-m-d H:i:s';


    protected $fillable = [
        'label'
    ];

    protected $guarded = [];

    public function permissions(){
        return $this->belongsToMany('App\models\Permission', 'role_permissions', 'roles_id', 'permissions_id');
    }

    public function functions(){
        return $this->belongsToMany('App\models\Functions', 'role_permissions', 'roles_id', 'functions_id');
    }

        
}