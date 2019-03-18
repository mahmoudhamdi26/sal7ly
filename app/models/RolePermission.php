<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class RolePermission
 */
class RolePermission extends Model
{
    protected $table = 'role_permissions';

    public $timestamps = true;
    protected $dateFormat = 'Y-m-d H:i:s';


    protected $fillable = [
        'roles_id',
        'functions_id',
        'permissions_id'
    ];

    protected $guarded = [];

        
}