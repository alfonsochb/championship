<?php
namespace App\Controllers;

use CodeIgniter\Controller;
use App\Libraries\WorldChampionship;


/**
 * @category    Controlador de los equipos del campeonato.
 * @author      Alfonso Chavez Baquero
 * @copyright   2021-2023 Alfonso Chávez Baquero
 * @link        https://github.com/alfonsochb Visita mi página GitHub
 * @since       Version 1.0.0
 * @see         La aplicación CHAMPS fue desarrollada bajo el marco de trabajo 
 * Codeigniter, el cual esta fuertemente ligado al patrón de diseño MVC, patrón más que 
 * adecuado teniendo en cuenta la celeridad con la cual tuvo que desarrollarse la 
 * presente aplicación.
 */
class Teams extends BaseController
{
	
    private $champs;
    private $pathPublic;
    private $pathWritable;
    private $errors = [];
    private $msj = "";


    public function __construct() {
        $this->champs = new WorldChampionship;
        //$this->pathPublic = join( DIRECTORY_SEPARATOR, [ROOTPATH, "public"]);
        //$this->pathWritable = join( DIRECTORY_SEPARATOR, [WRITEPATH, "appdata"]);
        $this->pathPublic = ROOTPATH."public";
        $this->pathWritable = WRITEPATH."appdata";
    }


    public function index()
    {
        $this->checkAuth();
        try {
            $obj = new \App\Libraries\WorldChampionship;
            $champs = $obj->theWorldCup;
            return view('teams/index', [
                'meta_tit'  => 'Equipos',
                'meta_des'  => 'Selección de futbol',
                'meta_key'  => '',
                'teams' => $champs->allTeams
            ]);             
        } catch (\Exception $e) {
            $this->saveLogsJson([
                "code"      => $e->getCode(),
                "message"   => $e->getMessage(),               
                "file"      => $e->getFile(),
                "line"      => $e->getLine()
            ]);
        }
        throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Se ha presentado un fallo.");
        exit(0);
    }


	public function show( $id=null )
	{
        try {
            $session = session();
            //echo "<pre>"; print_r($session->get()); die;
            if( $session->get('logged_in') && $session->get('user_email') ){
                $redirect = site_url('teams');
            } else {
                $redirect = site_url('/');
            }

            $modelFT = new \App\Models\TeamModel;
            $team = $modelFT->asObject()->select([
                'teams.id', 
                'teams.prefix', 
                'teams.country_name', 
                'teams.photo_shield', 
                'teams.photo_flag', 
                'teams.photo_team',
                'groups.group'
            ])
            ->join('groups', 'groups.team_id=teams.id', 'left')
            ->where( 'teams.id', $id)->first();
            $dirTeam = "public/img/teams/".$team->prefix;
            if ( file_exists($dirTeam."/".$team->photo_shield) and is_file($dirTeam."/".$team->photo_shield) ) {
                $team->photo_shield = base_url( $dirTeam."/".$team->photo_shield );
            }else{
                $team->photo_shield = base_url('public/img/any/any-shield.png');
            }

            if ( file_exists($dirTeam."/".$team->photo_flag) and is_file($dirTeam."/".$team->photo_flag) ) {
                $team->photo_flag = base_url( $dirTeam."/".$team->photo_flag );
            }else{
                $team->photo_flag = base_url('public/img/flags/'.$team->prefix.'.png');
            }

            if ( file_exists($dirTeam."/".$team->photo_team) and is_file($dirTeam."/".$team->photo_team) ) {
                $team->photo_team = base_url( $dirTeam."/".$team->photo_team );
            }else{
                $team->photo_team = base_url('public/img/any/any-team.png');
            }

            $players = $modelFT->asObject()
            ->select([
                'players.id', 
                'players.name', 
                'players.surname', 
                'players.nationality', 
                'players.birth', 
                'players.team_position', 
                'players.team_number', 
                'players.photo_player'
            ])
            ->join('players', 'players.team_id=teams.id', 'left')
            ->where( 'teams.id', $id)
            ->findAll();
            if ( is_array($players) and !empty($players) ) {
                foreach ($players as $key => $player) {
                    if ( file_exists($dirTeam."/".$player->photo_player) and is_file($dirTeam."/".$player->photo_player) ) {
                        $players[$key]->photo_player = base_url( $dirTeam."/".$player->photo_player );
                    }else{
                        $players[$key]->photo_player = base_url('public/img/any/any-player.png');
                    }
                }
            }

            $db = \Config\Database::connect();
            $builder = $db->table('groups');
            $countGroups = $builder->countAllResults();
            return view('teams/show', [
                'meta_tit'  => 'Club: '.$team->country_name,
                'meta_des'  => 'Selección de futbol '.$team->country_name,
                'meta_key'  => 'equipos, selección, país, '.$team->country_name,
                'redirect' => $redirect,
                'team' => $team,
                'players' => $players,
                'edit_photo' => $session->get('logged_in') ? true : false,
                'countGroups' => $countGroups
            ]);             
        } catch (\Exception $e) {
            $this->saveLogsJson([
                "code"      => $e->getCode(),
                "message"   => $e->getMessage(),               
                "file"      => $e->getFile(),
                "line"      => $e->getLine()
            ]);
        }
        throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Se ha presentado un fallo.");
        exit(0);
	}


    public function createMultiple()
    {
        $this->checkAuth();
        $this->response->setHeader('Content-Type', 'application/json; charset=UTF-8');
        try {
            $modelCountry = new \App\Models\CountryModel;
            $modelFT = new \App\Models\TeamModel;
            $modelPlayer = new \App\Models\PlayerModel;


            $method = !empty($this->request->getMethod(TRUE)) 
                ? $this->request->getMethod(TRUE) 
                : strtoupper($_SERVER['REQUEST_METHOD']);


            if ( 'POST'!=$method or !$this->request->getPost('csrf_test_name') ) {
                throw new \RuntimeException('Esta acción no esta permitida.', 001);
            }
            

            $country_id = $this->request->getPost('country_id');
            if ( !is_numeric($country_id) or $country_id<=0 ) {
                throw new \RuntimeException('Parámetros incorrectos.', 001);
            }

            
            $file = $this->request->getFile('team_file');
            $ext = strtolower( $file->guessExtension() );
            if ($ext !=="csv" ) {
                throw new \RuntimeException('El archivo no es válido, debe estar en formato csv.', 001);
            }


            $allTeams = $modelFT->findAll();
            if ( count($allTeams)>=32 ) {
                throw new \RuntimeException('No se pueden registrar más de 32 Clubes deportivos.', 001);
            }


            // Verificar si ya existe el equipo registrado.
            $country = $modelCountry->asObject()->select(['prefix', 'country'])->where( 'id', $country_id)->first();
            $team = $modelFT->asObject()->where( 'prefix', $country->prefix)->first();
            if ( is_object($team) and isset($team->id) ) {
                throw new \RuntimeException("Ya se encuentra registrado el Club: ".$team->country_name, 001);
            }


            // Crear una copia temporal de archivo para lectura. 
            $newName = $file->getRandomName();
            $file->move(WRITEPATH.'uploads', $newName);
            $fileOpen = WRITEPATH.'uploads'.DIRECTORY_SEPARATOR.$newName;
            $arrayPlayers = $this->champs->getCsv( $fileOpen );
            unlink($fileOpen);
            if ( !is_array($arrayPlayers) or count($arrayPlayers)<=1 ) {
                throw new \RuntimeException('No se encontraron datos en el formato csv.', 001);
            }


            // Saneamiento de datos.
            $positions = ['portero', 'delantero', 'defensa', 'centrocampista'];
            $insertPlayers = [];
            $rulesPlayer = $modelPlayer->rulesMultiple;
            $validation = \Config\Services::validation();
            foreach ($arrayPlayers as $key => $player) {
                if ($key>0) {
                    array_map("trim", $player);
                    $name = preg_replace("/[^a-zA-Z0-9]+/", "", html_entity_decode($player[0]));
                    $surname = preg_replace("/[^a-zA-Z0-9]+/", "", html_entity_decode($player[1]));
                    $nationality = preg_replace("/[^a-zA-Z0-9]+/", "", html_entity_decode($player[2]));
                    $team_position = preg_replace("/[^a-zA-Z0-9]+/", "", html_entity_decode($player[4]));
                    $aux = [
                        'name' => ucwords(strtolower($name)),
                        'surname' => ucwords(strtolower($surname)),
                        'nationality' => ucwords(strtolower($nationality)),
                        'birth' => $player[3],
                        'team_position' => in_array(strtolower($team_position), $positions) ? strtolower($player[4]) : '',
                        'team_number' => is_numeric($player[5]) ? (int)$player[5] : 0,
                        'photo_player' => @trim($player[6])
                    ];
                    $validation->reset();
                    $validation->setRules($rulesPlayer);
                    if ( !$validation->run($aux) ) {
                        $this->errors[$key][] = "Archivo en la fila: ".($key+1);
                        foreach ($validation->getErrors() as $index => $error) {
                            $this->errors[$key][] = $error;
                        }
                    } else {
                        array_push($insertPlayers, (object)$aux);
                    }
                }
            }


            if ( !empty($this->errors) ) {
                throw new \RuntimeException('No se cumple con las validaciones.', 001);
            }


            if ( count($insertPlayers)<22 ) {
                throw new \RuntimeException('Registre mínimo 22 jugadores.', 001);
            }

            $teamId = $modelFT->insert([
                'prefix' => trim($country->prefix),
                'country_name' => ucwords(strtolower($country->country)),
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
                'delete_at' => NULL
            ]);
            if ( $teamId>0 ) {
                foreach ($insertPlayers as $key => $player) {
                    $modelPlayer->insert([
                        'team_id' => $teamId, 
                        'name' => $player->name, 
                        'surname' => $player->surname, 
                        'nationality' => $player->nationality, 
                        'birth' => $player->birth,
                        'team_position' => $player->team_position, 
                        'team_number' => $player->team_number,
                        'photo_player' =>  $player->photo_player,
                        'created_at' => date("Y-m-d H:i:s"),
                        'updated_at' => date("Y-m-d H:i:s"),
                        'delete_at' => NULL
                    ]);
                }
                $this->msj = "OK";
            }            
        } catch (\Exception $e) {
            $this->msj = ($e->getCode()=='001') 
                ? $e->getMessage() 
                : "Se ha presentado un error inesperado.";

            $this->champs->saveLogsJson([
                "code"      => $e->getCode(),
                "message"   => $e->getMessage(),               
                "file"      => $e->getFile(),
                "line"      => $e->getLine()
            ]);
        }
        return $this->response->setJSON([
            'message' => $this->msj,
            'errors' => $this->errors
        ]);
    }


    public function new()
    {
        $this->checkAuth();
        try {
            $modelCountrie = new \App\Models\CountryModel;
            $countries = $modelCountrie->findAll();
            return view('teams/new', [
                'meta_tit'  => 'Registrar Club deportivo',
                'meta_des'  => 'Formulario de registro de equipos de futbol',
                'meta_key'  => 'registro, equipos, selecciones, futbol',
                'countries' => $countries
            ]);             
        } catch (\Exception $e) {
            die($e->getMessage());
            $this->saveLogsJson([
                "code"      => $e->getCode(),
                "message"   => $e->getMessage(),               
                "file"      => $e->getFile(),
                "line"      => $e->getLine()
            ]);
        }
        throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Se ha presentado un fallo.");
        exit(0);
    }


    public function download()
    {
        $this->checkAuth();
        // Datos encabezados del archivo palntilla.
        $arrayData= [
            [
                "Nombres del jugador",
                "Apellidos del jugador",
                "Nacionalidad",
                "Fecha de nacimiento (YYYY-MM-DD)",
                "Posición en el equipo",
                "Número de camiseta",
                "Foto Jugador"
            ]
        ];

        // Generar el archivo de descarga.
        $pathFile = $this->pathWritable.DIRECTORY_SEPARATOR."register_teams.csv";
        $this->champs->generateCSV($arrayData, $pathFile, $delimiter=';', $encap='"');

        // Solicitar la descarga del archivo.
        return $this->champs->downloadFiles( $pathFile );
    }


    public function photo( $photo='', $id=null )
    {
        $photos = ['team', 'shield', 'flag', 'player'];
        if ( in_array($photo, $photos) and $id and is_numeric($id) ) {
            if ( $photo=='player' ) {
                $modelPlayer = new \App\Models\PlayerModel;
                $info = $modelPlayer->asObject()->where('id', $id)->first();
                $resumen = "En esta sección Usted esta modificando la foto del jugador {$info->name} {$info->surname}.";
                $orientation="V";
            }else{
                $modelTeam = new \App\Models\TeamModel;
                $info = $modelTeam->asObject()->where('id', $id)->first();
                $nota = [
                    'team' => 'del equipo',
                    'shield' => 'del escudo',
                    'flag' => 'de la bandera'
                ];
                $resumen = "En esta sección Usted esta modificando la foto {$nota[$photo]} del Club deportivo {$info->country_name}.";
                $orientation = ($photo=='shield') ? "V" : "H";
            }          
            return view('teams/photo', [
                'meta_tit'      => 'Registrar foto',
                'meta_des'      => 'Recurso fotografico',
                'meta_key'      => '',
                'orientation'   => $orientation,
                'resumen'       => $resumen,
                'photo'         => $photo,
                'id'            => $id
            ]);  
        }else{
            redirect()->back()->with("error", "No se puede acceder al recurso.");
        }
    }


    public function cropper()
    {
        $status = "warning";
        $message = "";
        $data = [];
        $this->checkAuth();
        $this->response->setHeader('Content-Type', 'application/json; charset=UTF-8');
        try {
            $session = session();
            if ( $this->request->getMethod(TRUE)!=='POST' or !$this->request->getPost('csrf_test_name') ) {
                throw new \RuntimeException('Esta acción no esta permitida.', 001);
            }

            extract($this->request->getPost());
            if ( !isset($id) or !is_numeric($id) or $id<=0 ) {
                throw new \RuntimeException('La foto no se puede asociar al recurso.', 001);
            }

            $photos = ['team', 'shield', 'flag', 'player'];
            if ( !in_array($photo, $photos) ) {
                throw new \RuntimeException('La foto no pertenece a los recursos permitidos.', 001);
            }

            if ( $photo=='player' ) {
                $modelPlayer = new \App\Models\PlayerModel;
                $info = $modelPlayer->asObject()
                ->select(['players.*', 'teams.prefix'])
                ->join('teams', 'teams.id=players.team_id')
                ->where('players.id', $id)
                ->first();
            }else{
                $modelTeam = new \App\Models\TeamModel;
                $info = $modelTeam->asObject()->where('id', $id)->first();
            }

            //$array_files = $this->request->getFiles();
            $file = $this->request->getFile('photo_upload');
            $message.=$file->getErrorString();
            $data_file = [
                'name'      => $file->getClientName(),
                'type'      => $file->getClientMimeType(),
                'tmp_name'  => $file->getTempName(),
                'error'     => $file->getError(),
                'size'      => $file->getSize('mb'),
                'message'   => $file->getErrorString(),
                'ext'       => $file->getClientExtension(),
            ];
            array_map("trim", $data_file);  
            if ( $data_file['error']!=0 ) {
                throw new \RuntimeException("Error de archivo: ".$this->filesError[$data['error']], 001);
            }

            $basename = htmlspecialchars(basename($data_file["name"]));
            $aux = explode(".", $basename);
            $newName = trim( strtolower( $photo."-".date("YmdHis").".".end($aux) ) );
            $endDirectory = join( DIRECTORY_SEPARATOR, [
                $this->pathPublic, 
                "img",
                "teams",
                trim(strtolower($info->prefix))
            ]);

            if ( !file_exists($endDirectory) ) mkdir($endDirectory, 0777, true);
            $endDirectory = $endDirectory.DIRECTORY_SEPARATOR.$newName;

            if( move_uploaded_file($data_file["tmp_name"], $endDirectory) ) {
                $message.= " Se ha guardado la imagen.";
                if ( $photo=='player' ) {
                    $result = $modelPlayer->where('id', $id)->set(['photo_player' => $newName])->update();
                }else{
                    switch ($photo) {
                        case 'team': $aux=['photo_team' => $newName]; break;
                        case 'shield': $aux=['photo_shield' => $newName]; break;
                        case 'flag': $aux=['photo_flag' => $newName]; break;
                    }
                    $result = $modelTeam->where('id', $id)->set($aux)->update();
                }
                if ($result) {
                    $status = "success";
                    $message.= " Se ha actualizado el registro correctamente.";
                } else {
                    unlink( $endDirectory );
                    throw new \RuntimeException("Imposible crear el registro.", 01);
                }
            }else{
                throw new \RuntimeException("No se puede guardar la imágen.", 001);
            }
        }catch (\Exception $e){
            $status = "error";
            $message = $e->getMessage();
            $this->saveLogsJson([
                'code'      => $e->getCode(),
                'message'   => $e->getMessage(),
                'file'      => $e->getFile(),
                'line'      => $e->getLine()
            ]);
        }
        echo json_encode([
            'status'=>$status, 
            'mesagge'=>$message, 
            'data'=>$data
        ], JSON_UNESCAPED_UNICODE);
        exit;
    }


}
