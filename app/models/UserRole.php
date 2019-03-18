<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class UserRole
 */
class UserRole extends Model
{
    protected $table = 'user_roles';

    public $timestamps = true;
    protected $dateFormat = 'Y-m-d H:i:s';


    protected $fillable = [
        'users_id',
        'roles_id'
    ];

    protected $guarded = [];

        
}