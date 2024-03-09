<?php namespace App\Models;

use CodeIgniter\Model;

class MemberCategoryModel extends Model
{
    protected $allowedFields = [
        'name'
    ];

    protected $table      = 'member_category';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType     = 'array';
    

}