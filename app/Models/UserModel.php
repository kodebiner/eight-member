<?php namespace App\Models;

use Myth\Auth\Models\UserModel as MythModel;

class UserModel extends MythModel
{
    protected $allowedFields = [
        'email', 'username', 'password_hash', 'reset_hash', 'reset_at', 'reset_expires', 'activate_hash',
        'status', 'status_message', 'sub_type', 'category_id', 'active', 'force_pass_reset', 'permissions', 'deleted_at',
        'memberid', 'firstname', 'lastname', 'phone', 'photo', 'membercard', 'expired_at',
    ];

    protected $returnType = 'App\Entities\User';

    // Get Personal Trainer
    public function getPT()
    {
        $groupsUsers = $this->db->table('auth_groups_users')->where('group_id', 5)->get()->getResult();
        $usersid = [];
        foreach ($groupsUsers as $groupUser) {
            $usersid[] = $groupUser->user_id;
        }
        $pt = $this->db->table('users')->whereIn('id', $usersid)->get()->getResult();
        return $pt;
    }
}