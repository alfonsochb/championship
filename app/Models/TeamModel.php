<?php 
namespace App\Models;

use CodeIgniter\Model;

class TeamModel extends Model
{
    protected $table = 'teams';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = [
        'prefix', 
        'country_name', 
        'photo_shield', 
        'photo_flag', 
        'photo_team', 
        'created_at', 
        'updated_at', 
        'delete_at'
    ];
    protected $useTimestamps = false;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $validationRules = [];
    protected $validationMessages = [];
    protected $skipValidation = false;
}