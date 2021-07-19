<?php 
namespace App\Models;

use CodeIgniter\Model;

class PlayerModel extends Model
{
    protected $table = 'players';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = [
        'team_id', 
        'name', 
        'surname', 
        'nationality', 
        'birth',
        'team_position', 
        'team_number',
        'photo_player', 
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

    protected $rulesMultiple = [
        'name' => [
            'label'  => 'Players.name',
            'rules'  => 'required|min_length[3]',
            'errors' => [
                'required' => 'El campo Nombres del jugador es requerido.',
                'min_length' => 'Campo Nombres del jugador, mínimo tres caracteres.'
            ]
        ],
        'surname' => [
            'label'  => 'Players.surname',
            'rules'  => 'required|min_length[3]',
            'errors' => [
                'required' => 'El campo Apellidos del jugador es requerido.',
                'min_length' => 'Campo Apellidos del jugador, mínimo tres caracteres.'
            ]
        ],
        'nationality' => [
            'label'  => 'Players.nationality',
            'rules'  => 'required',
            'errors' => [
                'required' => 'El campo Nacionalidad es requerido.'
            ]
        ],
        'birth' => [
            'label'  => 'Players.birth',
            'rules'  => 'required',
            'errors' => [
                'required' => 'El campo Fecha de nacimiento (YYYY-MM-DD) es requerido.'
            ]
        ],
        'team_position' => [
            'label'  => 'Players.team_position',
            'rules'  => 'required',
            'errors' => [
                'required' => 'El campo Posición en el equipo es requerido.'
            ]
        ],
        'team_number' => [
            'label'  => 'Players.team_number',
            'rules'  => 'required',
            'errors' => [
                'required' => 'El campo Número de camiseta es requerido.'
            ]
        ]
    ];
}