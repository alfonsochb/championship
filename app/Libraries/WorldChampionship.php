<?php 
namespace App\Libraries;


/**
* @category     Aplicación campeonato mundial de futbol.
* @since        Creado: 2021-06-28
* @author       Alfonso Chávez Baquero <alfonso.chb@gmail.com>
* @link         https://alfonsochb.com/ Visita mi página oficial AlfonsoChb.
* @copyright    2021-2023 Alfonso Chávez Baquero
* @see:         Estandares recomendados: PSR-1, PSR-4, PSR-19
* Como usar este recurso:
* Con Use cabecera de los archivos: use App\Libraries\WorldChampionship;
* Con Use cabecera de los archivos: $obj = new WorldChampionship;
* Con Use cabecera de los archivos: $obj->algunMetodo();
* o
* Con instancia desde los métodos: $obj = new \App\Libraries\WorldChampionship;
* Con instancia desde los métodos: $obj->algunMetodo();
*/

class WorldChampionship
{

    public $theWorldCup;
	

    public function __construct()
    {
        $this->theWorldCup = new \stdClass;
        $this->championshipConfiguration();
    }


    public function championshipConfiguration()
    {

        $modelTeam = new \App\Models\TeamModel;
        $modelGroup = new \App\Models\GroupModel;
        $modelProg = new \App\Models\ProgrammingModel;

        
        /** ----------------------------------------------------------------------- */
        $this->theWorldCup->countTeams = $modelTeam->countAllResults();
        $this->theWorldCup->countGroups = $modelGroup->countAllResults();
        $this->theWorldCup->countGames = $modelProg->countAllResults();
        $this->theWorldCup->countGamesPlayed = $modelProg->where('status_play', 'ON')->countAllResults();
        $this->theWorldCup->countCardsY = $this->getTotalCards('Y');
        $this->theWorldCup->countCardsR = $this->getTotalCards('R');
        


        $this->theWorldCup->status = [
            'inscription' => "OFF",
            'lottery' => "OFF",
            'dates' => "OFF",
            'play' => "OFF",
        ];
        if ( $this->theWorldCup->countTeams==32 ) {
            $this->theWorldCup->status['inscription'] = "ON";
        }
        if ( $this->theWorldCup->countTeams==32 ) {
            $this->theWorldCup->status['lottery'] = "ON";
        }


        /** ----------------------------------------------------------------------- */
        $allTeams = $modelTeam->asObject()
        ->select([
            'teams.id', 
            'teams.prefix', 
            'teams.country_name', 
            'teams.photo_shield', 
            'teams.photo_flag', 
            'teams.photo_team',
            'teams.created_at',
        ])
        ->findAll();
        foreach ($allTeams as $key => $team) {
            $dirTeam = "public/img/teams/".$team->prefix;
            if ( file_exists($dirTeam."/".$team->photo_shield) and is_file($dirTeam."/".$team->photo_shield) ) {
                $allTeams[$key]->photo_shield = base_url( $dirTeam."/".$team->photo_shield );
            }else{
                $allTeams[$key]->photo_shield = base_url('public/img/any/any-shield.png');
            }

            if ( file_exists($dirTeam."/".$team->photo_flag) and is_file($dirTeam."/".$team->photo_flag) ) {
                $allTeams[$key]->photo_flag = base_url( $dirTeam."/".$team->photo_flag );
            }else{
                $allTeams[$key]->photo_flag = base_url('public/img/flags/'.$team->prefix.'.png');
            }

            if ( file_exists($dirTeam."/".$team->photo_team) and is_file($dirTeam."/".$team->photo_team) ) {
                $allTeams[$key]->photo_team = base_url( $dirTeam."/".$team->photo_team );
            }else{
                $allTeams[$key]->photo_team = base_url('public/img/any/any-team.png');
            }
        }
        $this->theWorldCup->allTeams = $allTeams;
        

        /** ----------------------------------------------------------------------- */
        $this->theWorldCup->allGroups = [];
        if ( $this->theWorldCup->countGroups==32 ) {
            $teamsGroups = $modelTeam->asObject()
            ->select([
                'groups.group',
                'groups.position',
                'teams.id', 
                'teams.prefix', 
                'teams.country_name',
                'teams.photo_shield', 
                'teams.photo_flag', 
                'teams.photo_team',
                'teams.created_at'
            ])
            ->join('groups', 'groups.team_id=teams.id')
            ->orderBy('groups.group', 'ASC')
            ->orderBy('groups.position', 'ASC')
            ->findAll();
            foreach ($teamsGroups as $key => $team) {
                $dirTeam = "public/img/teams/".$team->prefix;
                if ( file_exists($dirTeam."/".$team->photo_shield) and is_file($dirTeam."/".$team->photo_shield) ) {
                    $photo_shield = base_url( $dirTeam."/".$team->photo_shield );
                }else{
                    $photo_shield = base_url('public/img/any/any-shield.png');
                }
                if ( file_exists($dirTeam."/".$team->photo_flag) and is_file($dirTeam."/".$team->photo_flag) ) {
                    $photo_flag = base_url( $dirTeam."/".$team->photo_flag );
                }else{
                    $photo_flag = base_url('public/img/flags/'.$team->prefix.'.png');
                }
                if ( file_exists($dirTeam."/".$team->photo_team) and is_file($dirTeam."/".$team->photo_team) ) {
                    $photo_team = base_url( $dirTeam."/".$team->photo_team );
                }else{
                    $photo_team = base_url('public/img/any/any-team.png');
                }
                $this->theWorldCup->allGroups[$team->group][$team->position] = (object)[
                    'id' => $team->id,
                    'prefix' => $team->prefix,
                    'country_name' => $team->country_name,
                    'photo_shield' => $photo_shield,
                    'photo_flag' => $photo_flag,
                    'photo_team' => $photo_team
                ];
            }
        }


        /** ----------------------------------------------------------------------- */
        $this->theWorldCup->allProgramming = [];
        if ( $this->theWorldCup->countGames==64 ) {
            $progamation = $modelProg->asObject()
                ->select([
                    'programming.id', 
                    'programming.date', 
                    'programming.new_group', 
                    'programming.phase', 
                    'programming.description', 
                    'programming.first_team_id', 
                    'programming.firts_team_marker', 
                    'programming.second_team_id', 
                    'programming.second_team_marker',
                    'programming.status_play',  
                    'first.country_name as first_team', 
                    'second.country_name as second_team'
                ])
                ->orderBy('programming.id', 'ASC')
                ->join('teams as first', 'first.id=programming.first_team_id', 'left')
                ->join('teams as second', 'second.id=programming.second_team_id', 'left')
                ->findAll();
            $this->theWorldCup->allProgramming = $progamation;
        }
    }


    public function getTotalCards( $color='Y' )
    {
        $color = strtoupper(substr($color, 0, 1));
        $db = \Config\Database::connect();
        $builder = $db->table('cards');
        return $builder->where('color', $color)->countAllResults();
    }


    public function generateCSV($input, $path, $delimiter, $enclosure)
    {
        try {
            $fileOpen = fopen($path, 'w');
            foreach ($input as $line) {
                $csv = array_map('utf8_decode', $line);
                fputcsv($fileOpen, $csv, $delimiter, $enclosure);
            }
            rewind($fileOpen);
            fclose($fileOpen);
            return true;
        } catch (\Throwable $e) {
            return false;
        }
    }


   /**
     * Método para obtener la información de un archivo en formato csv.
     * @throws Retorna FALSE si los parámetros no son correctos
     * @param (string) $routeFile - Indica la ruta donde esta el archivo.
     * @return (array structure) - Una estructura de datos leidos.
     */
    public function getCsv( $routeFile='' )
    {
        if ( empty($routeFile) or !file_exists($routeFile) ) return [];

        $info = explode( ".", $routeFile );
        $ext = strtolower( trim( array_pop( $info ) ) ) ;
        if ($ext!='csv') return [];

        $arrayResult = [];
        $docRead = fopen($routeFile, "r");
        while(!feof($docRead)) {
            $row = @trim(fgets($docRead));
            if (!empty($row)) {
                $array = explode(";", $row);
                $array = array_map("trim", $array);
                foreach ($array as $key => $value) {
                    if (mb_detect_encoding($value, 'UTF-8', true)===false) {
                        $array[$key] = utf8_encode($value);
                    }
                }
                array_push($arrayResult, $array);
            }
            unset($row);
        }
        fclose($docRead);
        return $arrayResult;
    }


   /**
     * Método para descargar archivos.
     * @param (string) $routeDownload - Indica el path donde esta el recurso.
     * @return (bolean) - Verdadero o falso según la ejecusión.
     * @see Ejemplo: $Obj->downloadFiles("ruta/miarchivo.ext");
     */
    public function downloadFiles( $routeDownload )
    {
        if ( file_exists($routeDownload) ) {
            $download_name = basename($routeDownload);
            header("Cache-Control: no-cache private");
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename='.$download_name);
            header('Content-Transfer-Encoding: binary');
            header('Content-Length: '.filesize($routeDownload));
            header('Expires: 0');
            header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
            header('Pragma: public');
            ob_clean();
            flush();
            readfile($routeDownload);
            return true;   
        }
        return false;      
    }



    /**
     * @method Método para guardar log cuando ocurren errores.
     * @param (string or array) $messages - Mensajes a ser guardados.
     * @return (void) - Devuelve continuación del proceso.
    */
    public function saveLogsJson( $messages=null )
    {
        $path_logs = WRITEPATH."logs";
        if ( file_exists($path_logs) and is_dir($path_logs) and '(null)'!==$messages ){
            $moment = date( "Y-m-d H:i:s" );
            $file_name = $path_logs.DIRECTORY_SEPARATOR."jsonlogs_".date("Ymd").".json";
            $database = [];
            if ( file_exists($file_name) and is_file($file_name) ) {
                $database = json_decode( file_get_contents( $file_name ), true );
            }

            if ( is_array($messages) ) {
                $messages = (object)$messages;
            }
            if ( is_object($messages) ) {
                 $aux = [
                    'code'      => (isset($messages->code) and is_numeric($messages->code)) ? $messages->code : 0,
                    'message'   => (isset($messages->message) and !empty($messages->message)) ? $messages->message : null,               
                    'file'      => (isset($messages->file) and !empty($messages->file)) ? $messages->file : null,
                    'line'      => (isset($messages->line) and is_numeric($messages->code)) ? $messages->line : 0,
                ];               
            }
            if ( !is_array($messages) and !is_object($messages) ) {
                 $aux = [
                    'code'      => 0,
                    'message'   => $messages,               
                    'file'      => null,
                    'line'      => 0,
                ];  
            }
            if ( $aux and !empty($aux) ) {
                $database[] = $aux;
                $write = fopen( $file_name, "w" );
                if ( flock( $write, LOCK_EX) ) { // adquirir un bloqueo exclusivo
                    ftruncate( $write, 0 );      // truncar el fichero
                    fwrite( $write, json_encode($database, JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES|JSON_PRETTY_PRINT) );
                    fflush( $write );            // volcar la salida antes de liberar el bloqueo
                    flock( $write, LOCK_UN );    // liberar el bloqueo
                }
                fclose( $write );
            }
            return;
        }
    }

    
    public function getJsonSportsClubs()
    {
        # Referencia al API del recurso: https://www.banderas-mundo.es/descargar/api
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: GET,POST,PUT,DELETE");
        header("Content-Type: application/json; charset=UTF-8");

        $modelCountry = new \App\Models\CountryModel;

        return json_encode($modelCountry->findAll(), JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES|JSON_PRETTY_PRINT);
    }


   /**
     * Método para obtener un una fecha en formato texto.
     * @param (string) $dateString - Indica la fecha input en formato AAAA-MM-DD.
     * @throws Retorna un array vacio si no corresponde el parámetro $dateString.
     * @return (STRING) - Fecha formateada a texto.
     */
    public function getTextFromDate( $dateString='' )
    {
        $string = "";
        if ( strlen($dateString)==10 and strpos($dateString, "-")!==false ) {
            $months = [ '01' => 'enero', '02' => 'febrero', '03' => 'marzo', '04' => 'abril', '05' => 'mayo', '06' => 'junio', '07' => 'julio', '08' => 'agosto', '09' => 'septiembre', '10' => 'octubre', '11' => 'noviembre', '12' => 'diciembre'];
            $textDays = [ 'Domingo', 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado' ];
            $aux = explode( "-", $dateString );
            $numDays = cal_days_in_month(CAL_GREGORIAN, intval($aux[1]), intval($aux[0]) );
            if ( intval($aux[2])<=$numDays ) {
                $date = $aux[2]."-".$aux[1]."-".$aux[0];
                $num = date( 'w', strtotime($date) );
                $string = $textDays[$num]." ".$aux[2]." de ".$months[$aux[1]]." de ".$aux[0];
            }
        }
        return $string;       
    }


    
    public function getCsvSelectionColombia()
    {
        $seleccionCol= [
            [
                "Nombres del jugador",
                "Apellidos del jugador",
                "Nacionalidad",
                "Fecha de nacimiento (YYYY-MM-DD)",
                "Posición en el equipo",
                "Número de camiseta",
                "Foto Jugador"
            ], [
                "Aldair",
                "Quintana",
                "Colombiana",
                "1994-07-11",
                "portero",
                22,
                "number_1.png"
            ], [
                "Alfredo",
                "Morelos",
                "Colombiana",
                "1996-06-21",
                "delantero",
                27,
                "number_2.png"
            ], [
                "Baldomero",
                "Perlaza",
                "Colombiana",
                "1992-06-05",
                "delantero",
                25,
                "number_3.png"
            ], [
                "Camilo",
                "vargas",
                "Colombiana",
                "1989-03-09",
                "portero",
                12,
                "number_4.png"
            ], [
                "carlos",
                "cuesta",
                "Colombiana",
                "1999-03-09",
                "defensa",
                4,
                "number_5.png"
            ], [
                "daniel",
                "Muños",
                "Colombiana",
                "1996-05-26",
                "defensa",
                16,
                "number_6.png"
            ], [
                "David",
                "OSPINA",
                "Colombiana",
                "1988-08-31",
                "portero",
                1,
                "number_7.png"
            ], [
                "Dávinson",
                "Sánchez",
                "Colombiana",
                "1996-06-12",
                "defensa",
                23,
                "number_8.png"
            ], [
                "Cristian Duvan",
                "Zapata",
                "Colombiana",
                "1991-04-01",
                "delantero",
                7,
                "number_9.png"
            ], [
                "Edwin",
                "Cardona",
                "Colombiana",
                "1992-12-08",
                "centrocampista",
                8,
                "number_10.png"
            ], [
                "Frank",
                "Fabra",
                "Colombiana",
                "1991-02-22",
                "defensa",
                26,
                "number_11.png"
            ], [
                "Gustavo",
                "Cuéllar",
                "Colombiana",
                "1992-08-14",
                "centrocampista",
                18,
                "number_12.png"
            ], [
                "Jamilton",
                "Campaz",
                "Colombiana",
                "2000-05-24",
                "centrocampista",
                20,
                "number_13.png"
            ], [
                "Jhon Janer",
                "LUCUMÍ",
                "Colombiana",
                "1998-06-26",
                "defensa",
                21,
                "number_14.png"
            ], [
                "JUAN GUILLERMO",
                "Cuadrado",
                "Colombiana",
                "1998-05-26",
                "centrocampista",
                11,
                "number_15.png"
            ], [
                "Luis",
                "Diaz",
                "Colombiana",
                "1979-04-09",
                "delantero",
                14,
                "number_16.png"
            ], [
                "Luis",
                "Muriel",
                "Colombiana",
                "1997-01-31",
                "delantero",
                19,
                "number_17.png"
            ], [
                "Mateus",
                "Uribe",
                "Colombiana",
                "1991-03-21",
                "centrocampista",
                15,
                "number_18.png"
            ], [
                "Miguel",
                "Borja",
                "Colombiana",
                "1993-01-26",
                "delantero",
                17,
                "number_19.png"
            ], [
                "Oscar",
                "Murillo",
                "Colombiana",
                "1988-04-08",
                "defensa",
                3,
                "number_20.png"
            ], [
                "Rafael Santos",
                "Borré",
                "Colombiana",
                "1995-09-15",
                "delantero",
                18,
                "number_21.png"
            ], [
                "Sebastián",
                "Pérez",
                "Colombiana",
                "1993-03-29",
                "centrocampista",
                21,
                "number_22.png"
            ], [
                "Stefan",
                "Medina",
                "Colombiana",
                "1992-06-14",
                "defensa",
                3,
                "number_23.png"
            ], [
                "Wilfran",
                "Tesillo",
                "Colombiana",
                "1990-02-02",
                "defensa",
                6,
                "number_24.png"
            ], [
                "Wílmar",
                "Barrios",
                "Colombiana",
                "1993-08-16",
                "centrocampista",
                5,
                "number_25.png"
            ], [
                "Yairo",
                "Moreno",
                "Colombiana",
                "1995-04-04",
                "centrocampista",
                17,
                "number_26.png"
            ], [
                "Yerry",
                "Mina",
                "Colombiana",
                "1994-09-23",
                "defensa",
                13,
                "number_27.png"
            ], [
                "Yimmy",
                "Chará",
                "Colombiana",
                "1991-04-02",
                "delantero",
                28,
                "number_28.png"
            ]
        ];
        $pathFile = WRITEPATH."appdata".DIRECTORY_SEPARATOR."Seleccion-Colombia.csv";
        return $this->generateCSV($seleccionCol, $pathFile, $delimiter=';', $encap='"');
    }



}