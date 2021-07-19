<?php 
namespace App\Models;

use CodeIgniter\Model;

class CountryModel extends Model
{
    protected $table = 'countries';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = ['prefix', 'country'];
    protected $useTimestamps = false;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $validationRules = [];
    protected $validationMessages = [];
    protected $skipValidation = false;
}