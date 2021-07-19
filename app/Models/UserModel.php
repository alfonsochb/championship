<?php 
namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = [
        'name', 
        'surname', 
        'avatar', 
        'email', 
        'password',
        'status', 
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