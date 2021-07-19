<?php 
namespace App\Models;

use CodeIgniter\Model;

class GroupModel extends Model
{
    protected $table = 'groups';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = ['group', 'position', 'team_id', 'created_at', 'updated_at', 'delete_at'];
    protected $useTimestamps = false;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $validationRules = [];
    protected $validationMessages = [];
    protected $skipValidation = false;
}