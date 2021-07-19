<?php
namespace App\Controllers;

use CodeIgniter\Controller;

/**
 * @category    Controlador para la administración del campeonato.
 * @author      Alfonso Chavez Baquero
 * @copyright   2021-2023 Alfonso Chávez Baquero
 * @link        https://github.com/alfonsochb Visita mi página GitHub
 * @since       Version 1.0.0
 */
class Config extends BaseController
{
	

    public function __construct() 
    {
		$this->checkAuth();
    }


	public function config()
	{
        try {
            $obj = new \App\Libraries\WorldChampionship;
            $champs = $obj->theWorldCup;
            //echo "<pre>"; print_r($champs); die;
            return view('config/config', [
                'meta_tit'  => 'Configuraciones',
                'meta_des'  => 'Herramientas de la app.',
                'meta_key'  => 'config',
                'config' => $champs,
                'initial' => date("Y-m-d", strtotime(date("Ymd")."+ 30 days") )
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


    public function lottery()
    {
        try {
            $db = \Config\Database::connect();
            $builder = $db->table('groups');
            $countGroups = $builder->countAllResults();
            if ( $countGroups!=32 ) {
                $alpha = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H');
                $modelFT = new \App\Models\TeamModel;
                $allTeams = $modelFT->findAll();
                if ( count($allTeams)==32 ) {
                    $list = array_column($allTeams, 'id');
                    shuffle( $list );
                    $newList = array_chunk($list, 4);
                    $groups = [];
                    foreach ($newList as $key => $team) $groups[$alpha[$key]] = $team;
                    foreach ($groups as $key => $group) {
                        foreach ($group as $index => $id) {
                            $builder->insert([
                                'group' => $key,
                                'team_id' => $id,
                                'position' => ($index+1),
                                'created_at' => date("Y-m-d H:i:s"),
                                'updated_at' => date("Y-m-d H:i:s"),
                                'delete_at' => NULL
                            ]);
                        }
                    }
                    return redirect('groups')->with("success", "Sorteo realizado satisfactoriamente.");
                } else {
                    return redirect('config')->with("warning", "No estan completos los 32 equipos.");
                }
            }else{
                return redirect('config')->with("info", "El sorteo ya fue realizado.");
            }
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


    public function dates()
    {
        try {
            $objChamps = new \App\Libraries\WorldChampionship;
            $all = $objChamps->theWorldCup;
            if ( $all->countGroups==32 and $all->countGames==0 ) {
                # 64 partidos.
                $aux1 = $this->interGroupGames( 1, 2 );
                $aux2 = $this->interGroupGames( 3, 4 );
                $aux3 = $this->interGroupGames( 1, 3 );
                $aux4 = $this->interGroupGames( 2, 4 );
                $aux5 = $this->interGroupGames( 1, 4 );
                $aux6 = $this->interGroupGames( 2, 3 );
                $troubleshooting = $this->troubleshooting();
                $programming = array_merge( $aux1, $aux2, $aux3, $aux4, $aux5, $aux6, $troubleshooting );
                
                $day = 1;
                $dateInitial = date("Ymd", strtotime(date("Ymd")."+ 30 days") );
                foreach ($programming as $key => $info) {
                    if ( $key%3==0 ) $day++;
                    $programming[$key]['date'] = date("Y-m-d", strtotime($dateInitial."+ $day days") );
                    if ($key>=62)  break;
                }

                // Semi final
                $day=$day+5;
                $programming[62]['date'] = date("Y-m-d", strtotime($dateInitial."+ $day days") );

                // Final
                $day=$day+3;
                $programming[63]['date'] = date("Y-m-d", strtotime($dateInitial."+ $day days") );

                if ( count($programming)==64 ) {
                    $modelProg = new \App\Models\ProgrammingModel;
                    foreach ($programming as $key => $info) {
                        $info['created_at'] = date("Y-m-d H:i:s");
                        $info['updated_at'] = date("Y-m-d H:i:s");
                        $info['delete_at'] = NULL;
                        $modelProg->insert( $info );
                    }
                    return redirect('config')->with("info", "Se ha creado correctamente la programación.");
                }else{
                    return redirect('config')->with("warning", "Algo no esta funcionando en la programación.");
                }
            } else {
                return redirect('config')->with("info", "No se puede modificar la programación.");
            }
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


    public function interGroupGames( $first=0, $second=0 )
    {
        $encounters = [];
        $alpha = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H');
        $objChamps = new \App\Libraries\WorldChampionship;
        $groups = $objChamps->theWorldCup->allGroups;
        //echo "<pre>"; print_r($groups); die; 
        if ( !empty($groups) ) {
            foreach ($alpha as $key => $group) {
                $encounters[] = [
                    'date' => "",
                    'new_group' => "Grupos",
                    'phase' => "GRUPOS",
                    'description' => "Grupo: ".$groups[$group][$first]->country_name." - ".$groups[$group][$second]->country_name,
                    'first_team_id' => $groups[$group][$first]->id,
                    'firts_team_marker' => 0,
                    'second_team_id' => $groups[$group][$second]->id,
                    'second_team_marker' => 0               
                ];
            }
        }
        return $encounters;
    }


    public function troubleshooting()
    {
        $encounters = [];
        $phaseOct = [
            'A' => "Primero grupo A vs Segundo grupon B",
            'B' => "Primero grupo C vs Segundo grupon D",
            'C' => "Primero grupo B vs Segundo grupon A",
            'D' => "Primero grupo D vs Segundo grupon C",
            'E' => "Primero grupo E vs Segundo grupon F",
            'F' => "Primero grupo G vs Segundo grupon H",
            'G' => "Primero grupo F vs Segundo grupon E",
            'H' => "Primero grupo H vs Segundo grupon G",
        ];
        foreach ($phaseOct as $key => $info) {
            $encounters[] = [
                'date' => "",
                'new_group' => "OCT-$key",
                'phase' => "OCTAVOS",
                'description' => $info,
                'first_team_id' => 0,
                'firts_team_marker' => 0,
                'second_team_id' => 0,
                'second_team_marker' => 0               
            ];
        }
        $phaseQuarter = [
            'W' => "OCT-A vs OCT-B",
            'X' => "OCT-E vs OCT-F",
            'Y' => "OCT-G vs OCT-H",
            'Z' => "OCT-C vs OCT-D",
        ];
        foreach ($phaseQuarter as $key => $info) {
            $encounters[] = [
                'date' => "",
                'new_group' => "QUARTER-$key",
                'phase' => "CUARTOS",
                'description' => $info,
                'first_team_id' => 0,
                'firts_team_marker' => 0,
                'second_team_id' => 0,
                'second_team_marker' => 0               
            ];
        }
        $semifinale = [
            'SEMI-A' => "QUARTER-W vs QUARTER-X",
            'SEMI-B' => "QUARTER-Y vs QUARTER-Z",
        ];
        foreach ($semifinale as $key => $info) {
            $encounters[] = [
                'date' => "",
                'new_group' => "SEMI",
                'phase' => "SEMIFINALES",
                'description' => $info,
                'first_team_id' => 0,
                'firts_team_marker' => 0,
                'second_team_id' => 0,
                'second_team_marker' => 0               
            ];
        }
        $encounters[] = [
            'date' => "",
            'new_group' => "TERCER-QUARTO",
            'phase' => "TERCERP",
            'description' => "Semi Final",
            'first_team_id' => 0,
            'firts_team_marker' => 0,
            'second_team_id' => 0,
            'second_team_marker' => 0               
        ];
        $encounters[] = [
            'date' => "",
            'new_group' => "PRIMERO-SEGUNDO",
            'phase' => "FINAL",
            'description' => "Gran Final del campeonato",
            'first_team_id' => 0,
            'firts_team_marker' => 0,
            'second_team_id' => 0,
            'second_team_marker' => 0               
        ];
        return $encounters;
    }


    public function play()
    {
        try {
            $modelProg = new \App\Models\ProgrammingModel;
            $modelTeam = new \App\Models\TeamModel;
            $modelPlayer = new \App\Models\PlayerModel;
            $pg = $modelProg->asObject()
                ->select([
                    'id',
                    'date',
                    'description', 
                    'first_team_id',
                    'firts_team_marker',
                    'second_team_id',
                    'second_team_marker'
                ])
                ->orderBy('id', 'ASC')
                ->where('status_play', 'OFF')
                ->first();
            $pg->firts_team = $modelTeam->asObject()
                ->select(['id', 'country_name', 'photo_shield', 'photo_flag', 'photo_team'])
                ->where('id', $pg->first_team_id)
                ->first();
            $pg->second_team = $modelTeam->asObject()
                ->select(['id', 'country_name', 'photo_shield', 'photo_flag', 'photo_team'])
                ->where('id', $pg->second_team_id)
                ->first();
            $pg->firts_team->players[] = $modelPlayer->asObject()
                ->select(['id', 'name', 'surname', 'team_position', 'team_number'])
                ->where('team_id', $pg->firts_team->id)
                ->where('team_position', 'portero')
                ->first();
             $players = $modelPlayer->asObject()
                ->select(['id', 'name', 'surname', 'team_position', 'team_number'])
                ->where('team_id', $pg->firts_team->id)
                ->where('team_position !=', 'portero')
                ->findAll(10);
            $pg->firts_team->players = array_merge($pg->firts_team->players, $players);
            $pg->second_team->players[] = $modelPlayer->asObject()
                ->select(['id', 'name', 'surname', 'team_position', 'team_number'])
                ->where('team_id', $pg->second_team->id)
                ->where('team_position', 'portero')
                ->first();
            $players = $modelPlayer->asObject()
                ->select(['id', 'name', 'surname', 'team_position', 'team_number'])
                ->where('team_id', $pg->second_team->id)
                ->where('team_position !=', 'portero')
                ->findAll(10);
            $pg->second_team->players = array_merge($pg->second_team->players, $players);

            return view('config/play', [
                'meta_tit'  => $pg->description,
                'meta_des'  => "Encuentro deportivo ".$pg->date." ".$pg->description,
                'meta_key'  => 'partidos, fechas, juegos',
                'config'    => $pg
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


    public function playAdd()
    {
        $this->checkAuth();
        try {
            if ( 'POST'!=$this->request->getMethod(TRUE) or !$this->request->getPost('csrf_test_name') ) {
                throw new \RuntimeException('Esta acción no esta permitida.', 001);
            }

            extract($this->request->getPost());
            $modelProg = new \App\Models\ProgrammingModel;
            $game = $modelProg->where('id', $game_id)->first();

            $game['firts_team_marker'] = $this->request->getPost('firts_team_marker');
            $game['second_team_marker'] = $this->request->getPost('second_team_marker');
            $game['status_play'] = "ON";
            $game['updated_at'] = date("Y-m-d H:i:s");
            $modelProg->where('id', $game_id)->set($game)->update();
            //$modelProg->save($game);
            
            $db = \Config\Database::connect();
            $builder = $db->table('cards');
            if ( isset($yellow) and is_array($yellow) and !empty($yellow) ) {
                foreach ($yellow as $team => $players) {
                    foreach ($players as $player => $check) {
                        $builder->insert([
                            'game_id' => $game_id,
                            'team_id' => $team,
                            'player_id' => $player,
                            'color' => "Y"
                        ]);
                    }
                }
            }
            if ( isset($red) and is_array($red) and !empty($red) ) {
                foreach ($red as $team => $players) {
                    foreach ($players as $player => $check) {
                        $builder->insert([
                            'game_id' => $game_id,
                            'team_id' => $team,
                            'player_id' => $player,
                            'color' => "R"
                        ]);
                    }
                }
            }
            return redirect('config/play')->with("success", "Se ha realizado correctamente el registro de partido jugado. ¡Siguiente partido!");
        } catch (\Exception $e) {
            $this->saveLogsJson([
                "code"      => $e->getCode(),
                "message"   => $e->getMessage(),               
                "file"      => $e->getFile(),
                "line"      => $e->getLine()
            ]);
            redirect()->back()->with("error", "Se han presentado fallos en el registro.");
        }
        throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Se ha presentado un fallo.");
        exit(0);
    }


    public function eighthsFinals()
    {
        // code...
    }


    public function quarterFinals($value='')
    {
        // code...
    }


    public function semiFinal($value='')
    {
        // code...
    }


    public function grandFinale($value='')
    {
        // code...
    }


}
