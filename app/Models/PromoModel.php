<?php namespace App\Models;

use CodeIgniter\Model;

class PromoModel extends Model
{
    protected $allowedFields = [
        'name'
    ];

    protected $table      = 'promo';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $useSoftDeletes = true;
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';
    protected $returnType     = 'array';

    public function getUserPromo(int $userid) {
        $userPromos = $this->db->table('promo_user')->where('user_id',  $userid)->get()->getResultArray();
        return (!empty($userPromos)) ? $userPromos[0] : array();
    }

    public function deleteUserPromo(int $userid) {
        $userPromos = $this->db->table('promo_user')->where('user_id',  $userid)->get()->getResultArray();

        if (!empty($userPromos)) {
            $this->db->table('promo_user')->where('user_id',  $userid)->delete();
            return true;
        } else {
            return false;
        }
    }
    
    public function addUserPromo(int $userid, int $promoid) {
        $userPromos = $this->db->table('promo_user')->where('user_id',  $userid)->get()->getResultArray();

        // Clear The Promos
        if (!empty($userPromos)) {
        $this->db->table('promo_user')->where('user_id',  $userid)->delete();
        }

        // Add User To Promo
        $data = [
            'promo_id'  => $promoid,
            'user_id'   => $userid
        ];
        return (bool) $this->db->table('promo_user')->insert($data);
    }
}