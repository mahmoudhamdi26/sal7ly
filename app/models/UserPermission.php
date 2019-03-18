<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class UserPermission
 */
class UserPermission extends Model
{
    protected $table = 'user_permissions';

    public $timestamps = true;
    protected $dateFormat = 'Y-m-d H:i:s';


    protected $fillable = [
        'users_id',
        'permissions_id',
        'functions_id'
    ];

    protected $guarded = [];

        
}