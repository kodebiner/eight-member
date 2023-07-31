<?php namespace App\Models;

use CodeIgniter\Model;

class ActivityModel extends Model
{
    protected $allowedFields = [
        'user_id', 'activity', 'done_at',
    ];

    protected $table      = 'activity';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType     = 'array';
    

}