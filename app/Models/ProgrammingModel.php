<?php 
namespace App\Models;

use CodeIgniter\Model;

class ProgrammingModel extends Model
{
    protected $table = 'programming';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = [
        'date', 
        'new_group', 
        'phase', 
        'description', 
        'first_team_id', 
        'firts_team_marker', 
        'second_team_id', 
        'second_team_marker', 
        'status_play', 
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