<?php namespace App\Models;

use Myth\Auth\Models\UserModel as MythModel;

class UserModel extends MythModel
{
    protected $allowedFields = [
        'email', 'username', 'password_hash', 'reset_hash', 'reset_at', 'reset_expires', 'activate_hash',
        'status', 'status_message', 'sub_type', 'active', 'force_pass_reset', 'permissions', 'deleted_at',
        'memberid', 'firstname', 'lastname', 'phone', 'photo', 'membercard', 'expired_at',
    ];

    protected $returnType = 'App\Entities\User';
}