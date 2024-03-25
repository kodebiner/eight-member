<?php namespace App\Models;

use CodeIgniter\Model;

class CheckinModel extends Model
{
    protected $allowedFields = [
        'user_id', 'pt', 'checked_at',
    ];

    protected $table      = 'checkin';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType     = 'array';
    

}