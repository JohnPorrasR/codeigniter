<?php


## Funciones Comunes ##
//	// funciones de fechas
/**
 * dateSmart
 */
function dateSmart($dateIn, $template='{hour}:{min} {day}-{month:name}-{year}'){

    $dateIn .= (strlen($dateIn)<=10) ? " 00:00:00":'';
    $dateOut = $template;

    $dater['year']	 = substr ($dateIn,0,4);
    $dater['month']	 = substr ($dateIn,5,2);
    $dater['day']	 = substr ($dateIn,8,2);
    $dater['hour']	 = substr ($dateIn,11,2);

    if( $dater['hour'] >12) {
        $dater['hour'] = $dater['hour'] - 12;
        $dater['meridian'] = 'pm';
    }else{
        $dater['meridian'] = 'am';
    }
    $dater['min']	 = substr ($dateIn,14,2);
    $dater['seg']	 = substr ($dateIn,17,2);

    $dateOut = str_replace('{year}', $dater['year'] ,$dateOut );
    $dateOut = str_replace('{month}', $dater['month'] ,$dateOut );
    $dateOut = str_replace('{day}', $dater['day'] ,$dateOut );
    $dateOut = str_replace('{hour}', $dater['hour'] ,$dateOut );
    $dateOut = str_replace('{min}', $dater['min'] ,$dateOut );
    $dateOut = str_replace('{seg}', $dater['seg'] ,$dateOut );
    $dateOut = str_replace('{meridian}', $dater['meridian'] ,$dateOut );



    if( substr_count($dateOut, '{month:name}') ){
        $dateOut = str_replace('{month:name}', date_month_name($dater['month']) ,$dateOut );
    }


    if( substr_count($dateOut, '{day:name}') ){
        $mkdate = mktime(0,0,0,$dater['month'], $dater['day'], $dater['year']);
        $dateOut = str_replace('{day:name}', date_day_name( date("w", $mkdate) ) , $dateOut );
    }
    return $dateOut;
}

function daySmart($numberDay,$template='{day:name}'){
    $dateOut = $template;

    $dateOut = str_replace('{day:name}', date_day_name($numberDay) ,$dateOut );
    return $dateOut;
}
function date_month_name( $mm ){
    if(trim($mm)=='') return '';
    $months = array('','Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre');
    return $months[ abs( $mm  )];
}
function date_day_name( $mm ){
    if(trim($mm)=='') return '';
    $days = array('Domingo','Lunes','Martes','Mi&eacute;rcoles','Jueves','Viernes','Sabado');
    return $days[ abs( $mm  )];
}
function dateNow($format = "Y-m-d H:i:s",$seg=0){

    if($seg != 0){
        return date( $format, ( time()-($seg)));
    }
    else{
        return date( $format, ( time() ) ); //Localhost
        //return date( $format, ( time()- 3670 ) );
        //return date("Y-m-d H:i:s" );
    }
}
function dateAgo( $str ){

    list( $date, $hour) = split( ' ', $str );

    list( $yy, $mm, $dd) = split( ' ', $date );

    if ( substr_count( ":", $hour ) == 0 ){
        $hh = $ii = $ss = 0;
    }else{
        list( $hh, $ii, $ss) = split( ' ', $hour );
    }

    $tmp = time() - mktime($hh, $ii, $ss, $mm, $dd, $yy);


}

function days_in_month($month = 0, $year = '')
{
    if ($month < 1 OR $month > 12)
    {
        return 0;
    }

    if ( ! is_numeric($year) OR strlen($year) != 4)
    {
        $year = date('Y');
    }

    if ($month == 2)
    {
        if ($year % 400 == 0 OR ($year % 4 == 0 AND $year % 100 != 0))
        {
            return 29;
        }
    }

    $days_in_month	= array(31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31);
    return $days_in_month[$month - 1];
}

/* Funciones iconodelamoda */
function get_porcentaje($param1, $param2, $precision=2) {
    if ( $param2 ) {
        $value = round($param1 * 100 / $param2, $precision) * 100;
        $result = str_pad($value, 5,' ',0);
        $prefijo_cero = ( $value < 100 ) ? '0' : '';
        return $prefijo_cero . trim(substr($result,0,3)) . "." . trim(substr($result,3,2));
    }
    else
        return "0.00";
}


function get_facebook_cookie($app_id, $application_secret) {
    $args = array();

    if (isset($_COOKIE['fbs_' . $app_id])){
        parse_str(trim($_COOKIE['fbs_' . $app_id], '\\"'), $args);
        ksort($args);
        $payload = '';
        foreach ($args as $key => $value) {
            if ($key != 'sig') {
                $payload .= $key . '=' . $value;
            }
        }
        if (md5($payload . $application_secret) != $args['sig']) {
            return null;
        }
    }
    return $args;
}

function make_seed()
{
    list($usec, $sec) = explode(' ', microtime());
    return (float) $sec + ((float) $usec * 100000);
}


function show_embed_video($url) {
    $media = $url;
    $media = str_replace("http://","",$media);
    $media = str_replace("www.youtube.com/","",$media);
    $media = str_replace("watch?v=","",$media);
    return '<a href="'.$url.'" target="_blank"><img width="145" src="http://i2.ytimg.com/vi/'.$media.'/default.jpg"/></a>';
}


function format_date($fecha, $type=''){
    $hour='';
    $meridiano='';
    if(strlen(trim($fecha))==19):
        list($fecha,$hour,$meridiano) = explode(" ",$fecha);
    endif;

    //formato fecha americana
    switch($type)
    {
        default:
            $result=date("d/m/Y",strtotime($fecha));
            break;
        case 'en':
            $result=date("Y-m-d",strtotime(str_replace("/","-",$fecha)));

            break;

    }
    return trim($result." ".$hour);

}

function makehrs_real($hour){
    if(strstr($hour,'pm'))
    {
        switch(substr($hour,0,2))
        {
            case '12':
                $hreal=str_replace(substr($hour,0,2),'12',$hour);
                break;

            case '11':
                $hreal=str_replace(substr($hour,0,2),'23',$hour);
                break;

            case '10':
                $hreal=str_replace(substr($hour,0,2),'22',$hour);
                break;

            case '09':
                $hreal=str_replace(substr($hour,0,2),'21',$hour);
                break;

            case '08':
                $hreal=str_replace(substr($hour,0,2),'20',$hour);
                break;

            case '07':
                $hreal=str_replace(substr($hour,0,2),'19',$hour);
                break;

            case '06':
                $hreal=str_replace(substr($hour,0,2),'18',$hour);
                break;

            case '05':
                $hreal=str_replace(substr($hour,0,2),'17',$hour);
                break;

            case '04':
                $hreal=str_replace(substr($hour,0,2),'16',$hour);
                break;

            case '03':
                $hreal=str_replace(substr($hour,0,2),'15',$hour);
                break;

            case '02':
                $hreal=str_replace(substr($hour,0,2),'14',$hour);
                break;

            case '01':
                $hreal=str_replace(substr($hour,0,2),'13',$hour);
                break;
        }
    }
    else
    {
        switch(substr($hour,0,2))
        {
            case '12':
                $hreal=str_replace(substr($hour,0,2),'00',$hour);
                break;

            default:
                $hreal=$hour;
                break;
        }


    }
    return $hreal;
}

function Delete_Directory($dirname) {
    if (is_dir($dirname))
        $dir_handle = opendir($dirname);
    if (!$dir_handle)
        return false;
    while($file = readdir($dir_handle)) {
        if ($file != "." && $file != "..") {
            if (!is_dir($dirname."/".$file))
                unlink($dirname."/".$file);
            else
                delete_directory($dirname.'/'.$file);
        }
    }
    closedir($dir_handle);
    rmdir($dirname);
    return true;
}

function Delete_Files($dirname){
    if (is_dir($dirname))
        $dir_handle = opendir($dirname);
    if (!$dir_handle)
        return false;
    while($file = readdir($dir_handle)) {
        if ($file != "." && $file != "..") {
            if (!is_dir($dirname."/".$file))
                unlink($dirname."/".$file);
        }
    }
    closedir($dir_handle);

    return true;

}

function site_resource($ext=""){
    // return dirname(base_url()).str_replace("//","/","/resource/".$ext);
    return base_url().'resource/'.$ext;
}

function writer($var){
    echo("<pre>".print_r($var,true)."</pre>");
}

function CutText($texto,$size){
    $texto = strip_tags(trim($texto));
    if(strlen($texto)>$size){
        for($i=$size;$i>0;$i--){
            if(substr($texto,$i,1)==" "){
                return substr($texto,0,$i)."...";
                break;
            }
        }
    } else {
        return $texto;
    }
}


function Get_DatesOfBetween($dateStart,$dateEnd){//Retorna todas las fechas que hay entre dos fechas
    $date_Start=strtotime($dateStart);

    $date_End=strtotime($dateEnd);
    $dateArray = array();
    for($i=$date_Start; $i<=$date_End; $i+=86400){
        array_push($dateArray, date("d-m-Y", $i));
    }

    return $dateArray;

}

function makedays(){
    $digit='00';
    for($i=1;$i<32;$i++){
        echo '<option value="'.substr($digit,0,strlen($digit)-strlen($i)).$i.'">'.substr($digit,0,strlen($digit)-strlen($i)).$i.'</option>';
    }
}

function makemonths($name=''){
    $digit='00';
    $mes=array('1'=>'ENERO', '2'=>'FEBRERO', '3'=>'MARZO', '4'=>'ABRIL', '5'=>'MAYO', '6'=>'JUNIO', '7'=>'JULIO', '8'=>'AGOSTO', '9'=>'SETIEMBRE', '10'=>'OCTUBRE', '11'=>'NOVIEMBRE', '12'=>'DICIEMBRE');
    switch($name){
        default:
        case '':
            for($i=1;$i<=12;$i++){
                echo '<option value="'.substr($digit,0,strlen($digit)-strlen($i)).$i.'">'.substr($digit,0,strlen($digit)-strlen($i)).$i.'</option>';
            }
            break;

        case 'SHORTNAME':
            for($i=1;$i<=12;$i++){
                echo '<option value="'.substr($digit,0,strlen($digit)-strlen($i)).$i.'">'.substr($mes[$i],0,3).'</option>';
            }
            break;
        case 'shortname':
            for($i=1;$i<=12;$i++){
                echo '<option value="'.substr($digit,0,strlen($digit)-strlen($i)).$i.'">'.ucfirst(strtolower(substr($mes[$i],0,3))).'</option>';
            }
            break;

        case 'NAME':
            for($i=1;$i<=12;$i++){
                echo '<option value="'.substr($digit,0,strlen($digit)-strlen($i)).$i.'">'.$mes[$i].'</option>';
            }
            break;
        case 'name':
            for($i=1;$i<=12;$i++){
                echo '<option value="'.substr($digit,0,strlen($digit)-strlen($i)).$i.'">'.ucfirst(strtolower($mes[$i])).'</option>';
            }
            break;
    }


}

function makeyears($inicio='',$fin=''){
    if(!empty($inicio) and !empty($fin)){
        $start=$inicio;
        $end = $fin;
    }
    else{
        $start = date('Y')-95;
        $end = date('Y');
    }
    for($i=$end;$i>=$start;$i--){
        echo '<option value="'.$i.'">'.$i.'</option>';
    }
}

function Get_Days_Month($date=''){
    $days = array();
    if(empty($date)):
        $maxDays = date("t",mktime(0,0,0,date("n"),date("j"),date("Y")));
    else:
        $date = substr($date,0,10);
        list($anio,$mes,$dia)= explode("-",$date);
        $maxDays = date("t",mktime(0,0,0,(int)$mes,(int)$dia,(int)$anio));
    endif;

    for($d=1;$d<=$maxDays;$d++){
        array_push($days,$d);
    }

    return $days;
}

function Get_Calendary($date = ''){
    $_cal = array();
    if(empty($date)):
        $day_start = date("N",mktime(0,0,0,date("n"),date("j"),date("Y")));
        $ndays = Get_Days_Month(date('Y-m-d'));
        $day_end = date('N',mktime(0,0,0,date("n"),(int)$ndays[count($ndays)-1],date("Y")));
    else:
        list($anio,$mes,$dia)= explode("-",$date);
        $day_start = date('N',mktime(0,0,0,(int)$mes,(int)$dia,(int)$anio));
        $ndays = Get_Days_Month($date);
        $day_end = date('N',mktime(0,0,0,(int)$mes,(int)$ndays[count($ndays)-1],(int)$anio));
    endif;

    $NroOfWeek = ceil((count($ndays)+($day_start-1))/7);

    for($j=1;$j<=($day_start-1);$j++){
        array_unshift($ndays,"");
    }
    for($h=1;$h<=(7-$day_end);$h++){
        array_push($ndays,"");
    }

    $_cal['day_star'] = $day_start;
    $_cal['day_end'] = $day_end;
    $_cal['ndays'] = $ndays;

    $_cal['nweek'] = $NroOfWeek;
    return $_cal;

}

function To_Upper($str){
    $_search = array("á","é","í","ó","ú","ñ");
    $_replace = array("Á","É","Í","Ó","Ú","Ñ");
    $res = strtoupper($str);
    return str_replace($_search,$_replace,$res);

}

function cleanString($string)
{

    $string = trim($string);

    $string = str_replace(
        array('á', 'à', 'ä', 'â', 'ª', 'Á', 'À', 'Â', 'Ä'),
        array('a', 'a', 'a', 'a', 'a', 'A', 'A', 'A', 'A'),
        $string
    );

    $string = str_replace(
        array('é', 'è', 'ë', 'ê', 'É', 'È', 'Ê', 'Ë'),
        array('e', 'e', 'e', 'e', 'E', 'E', 'E', 'E'),
        $string
    );

    $string = str_replace(
        array('í', 'ì', 'ï', 'î', 'Í', 'Ì', 'Ï', 'Î'),
        array('i', 'i', 'i', 'i', 'I', 'I', 'I', 'I'),
        $string
    );

    $string = str_replace(
        array('ó', 'ò', 'ö', 'ô', 'Ó', 'Ò', 'Ö', 'Ô'),
        array('o', 'o', 'o', 'o', 'O', 'O', 'O', 'O'),
        $string
    );

    $string = str_replace(
        array('ú', 'ù', 'ü', 'û', 'Ú', 'Ù', 'Û', 'Ü'),
        array('u', 'u', 'u', 'u', 'U', 'U', 'U', 'U'),
        $string
    );

    $string = str_replace(
        array('ñ', 'Ñ', 'ç', 'Ç'),
        array('n', 'N', 'c', 'C',),
        $string
    );

    //Esta parte se encarga de eliminar cualquier caracter extraño
    $string = str_replace(
        array("\\", "¨", "º", "-", "~",
            "#", "@", "|", "!", "\"",
            "·", "$", "%", "&", "/",
            "(", ")", "?", "'", "¡",
            "¿", "[", "^", "`", "]",
            "+", "}", "{", "¨", "´",
            ">", "<", ";", ",", ":",
            " "),
        '',
        $string
    );


    return $string;
}

function Get_Ip_User() {
    return getenv('HTTP_X_FORWARDED_FOR') ?  getenv('HTTP_X_FORWARDED_FOR') :  getenv('REMOTE_ADDR');
}
function Add_Ceros($suma,$field){

    $cantceros = strlen($field)-strlen($suma);

    return str_repeat("0",$cantceros).$suma;
}
function Agrupa_Piezas($data = array()){
    $result = array();
    $tempArr = array();
    $obj = new stdClass;
    $peso = $precio = 0;
    if(count($data)>0){
        $count = ceil(count($data)/2);
        for($i=0;$i<$count;$i++){
            array_push($tempArr,array_slice($data,$i*2,2));
        }

        foreach($tempArr as $key=>$items){
            foreach($items as $item){
                $peso = $peso + $item->peso;
                $precio = $item->precio;

            }
            $obj->peso = $peso;
            $result[$key] = array('peso'=>$peso,'precio'=>$precio);
            $peso = $precio = 0;

        }

        return $result;
    }
    else{
        return false;
    }
}
function Crea_Path($path){
    if($path == ""){
        return false;
    }

    $directorios = explode("/",$path);
    $directorios = array_filter($directorios);

    if(count($directorios)<0){
        return false;
    }

    $response = true;
    $apppath = dirname(APPPATH);
    $subpath = "";
    foreach($directorios as $directorio){
        $directorio = '/'.$directorio;
        $subpath = $subpath.$directorio;
        $path = $apppath.$subpath;
        if(!is_dir($path)):
            if(!mkdir($path)){
                $response = false;
            }

        endif;
    }

    return $response;

}
/*Convertir numero a letras*/
function moneda_numtoletras($xcifra)
{
    $xarray = array(0 => "Cero",
        1 => "UN", "DOS", "TRES", "CUATRO", "CINCO", "SEIS", "SIETE", "OCHO", "NUEVE",
        "DIEZ", "ONCE", "DOCE", "TRECE", "CATORCE", "QUINCE", "DIECISEIS", "DIECISIETE", "DIECIOCHO", "DIECINUEVE",
        "VEINTI", 30 => "TREINTA", 40 => "CUARENTA", 50 => "CINCUENTA", 60 => "SESENTA", 70 => "SETENTA", 80 => "OCHENTA", 90 => "NOVENTA",
        100 => "CIENTO", 200 => "DOSCIENTOS", 300 => "TRESCIENTOS", 400 => "CUATROCIENTOS", 500 => "QUINIENTOS", 600 => "SEISCIENTOS", 700 => "SETECIENTOS", 800 => "OCHOCIENTOS", 900 => "NOVECIENTOS"
    );
    //
    $xcifra = trim($xcifra);
    $xlength = strlen($xcifra);
    $xpos_punto = strpos($xcifra, ".");
    $xaux_int = $xcifra;
    $xdecimales = "00";
    if (!($xpos_punto === false)) {
        if ($xpos_punto == 0) {
            $xcifra = "0" . $xcifra;
            $xpos_punto = strpos($xcifra, ".");
        }
        $xaux_int = substr($xcifra, 0, $xpos_punto); // obtengo el entero de la cifra a covertir
        $xdecimales = substr($xcifra . "00", $xpos_punto + 1, 2); // obtengo los valores decimales
    }

    $XAUX = str_pad($xaux_int, 18, " ", STR_PAD_LEFT); // ajusto la longitud de la cifra, para que sea divisible por centenas de miles (grupos de 6)
    $xcadena = "";
    for ($xz = 0; $xz < 3; $xz++) {
        $xaux = substr($XAUX, $xz * 6, 6);
        $xi = 0;
        $xlimite = 6; // inicializo el contador de centenas xi y establezco el límite a 6 dígitos en la parte entera
        $xexit = true; // bandera para controlar el ciclo del While
        while ($xexit) {
            if ($xi == $xlimite) { // si ya llegó al límite máximo de enteros
                break; // termina el ciclo
            }

            $x3digitos = ($xlimite - $xi) * -1; // comienzo con los tres primeros digitos de la cifra, comenzando por la izquierda
            $xaux = substr($xaux, $x3digitos, abs($x3digitos)); // obtengo la centena (los tres dígitos)
            for ($xy = 1; $xy < 4; $xy++) { // ciclo para revisar centenas, decenas y unidades, en ese orden
                switch ($xy) {
                    case 1: // checa las centenas
                        if (substr($xaux, 0, 3) < 100) { // si el grupo de tres dígitos es menor a una centena ( < 99) no hace nada y pasa a revisar las decenas

                        } else {
                            $key = (int) substr($xaux, 0, 3);
                            if (TRUE === array_key_exists($key, $xarray)){  // busco si la centena es número redondo (100, 200, 300, 400, etc..)
                                $xseek = $xarray[$key];
                                $xsub = subfijo($xaux); // devuelve el subfijo correspondiente (Millón, Millones, Mil o nada)
                                if (substr($xaux, 0, 3) == 100)
                                    $xcadena = " " . $xcadena . " CIEN " . $xsub;
                                else
                                    $xcadena = " " . $xcadena . " " . $xseek . " " . $xsub;
                                $xy = 3; // la centena fue redonda, entonces termino el ciclo del for y ya no reviso decenas ni unidades
                            }
                            else { // entra aquí si la centena no fue numero redondo (101, 253, 120, 980, etc.)
                                $key = (int) substr($xaux, 0, 1) * 100;
                                $xseek = $xarray[$key]; // toma el primer caracter de la centena y lo multiplica por cien y lo busca en el arreglo (para que busque 100,200,300, etc)
                                $xcadena = " " . $xcadena . " " . $xseek;
                            } // ENDIF ($xseek)
                        } // ENDIF (substr($xaux, 0, 3) < 100)
                        break;
                    case 2: // checa las decenas (con la misma lógica que las centenas)
                        if (substr($xaux, 1, 2) < 10) {

                        } else {
                            $key = (int) substr($xaux, 1, 2);
                            if (TRUE === array_key_exists($key, $xarray)) {
                                $xseek = $xarray[$key];
                                $xsub = subfijo($xaux);
                                if (substr($xaux, 1, 2) == 20)
                                    $xcadena = " " . $xcadena . " VEINTE " . $xsub;
                                else
                                    $xcadena = " " . $xcadena . " " . $xseek . " " . $xsub;
                                $xy = 3;
                            }
                            else {
                                $key = (int) substr($xaux, 1, 1) * 10;
                                $xseek = $xarray[$key];
                                if (20 == substr($xaux, 1, 1) * 10)
                                    $xcadena = " " . $xcadena . " " . $xseek;
                                else
                                    $xcadena = " " . $xcadena . " " . $xseek . " Y ";
                            } // ENDIF ($xseek)
                        } // ENDIF (substr($xaux, 1, 2) < 10)
                        break;
                    case 3: // checa las unidades
                        if (substr($xaux, 2, 1) < 1) { // si la unidad es cero, ya no hace nada

                        } else {
                            $key = (int) substr($xaux, 2, 1);
                            $xseek = $xarray[$key]; // obtengo directamente el valor de la unidad (del uno al nueve)
                            $xsub = subfijo($xaux);
                            $xcadena = " " . $xcadena . " " . $xseek . " " . $xsub;
                        } // ENDIF (substr($xaux, 2, 1) < 1)
                        break;
                } // END SWITCH
            } // END FOR
            $xi = $xi + 3;
        } // ENDDO

        if (substr(trim($xcadena), -5, 5) == "ILLON") // si la cadena obtenida termina en MILLON o BILLON, entonces le agrega al final la conjuncion DE
            $xcadena.= " DE";

        if (substr(trim($xcadena), -7, 7) == "ILLONES") // si la cadena obtenida en MILLONES o BILLONES, entoncea le agrega al final la conjuncion DE
            $xcadena.= " DE";

        // ----------- esta línea la puedes cambiar de acuerdo a tus necesidades o a tu país -------
        if (trim($xaux) != "") {
            switch ($xz) {
                case 0:
                    if (trim(substr($XAUX, $xz * 6, 6)) == "1")
                        $xcadena.= "UN BILLON ";
                    else
                        $xcadena.= " BILLONES ";
                    break;
                case 1:
                    if (trim(substr($XAUX, $xz * 6, 6)) == "1")
                        $xcadena.= "UN MILLON ";
                    else
                        $xcadena.= " MILLONES ";
                    break;
                case 2:
                    if ($xcifra < 1) {
                        $xcadena = "CERO PESOS $xdecimales/100 M.N.";
                    }
                    if ($xcifra >= 1 && $xcifra < 2) {
                        $xcadena = "UN PESO $xdecimales/100 M.N. ";
                    }
                    if ($xcifra >= 2) {
                        $xcadena.= " PESOS $xdecimales/100 M.N. "; //
                    }
                    break;
            } // endswitch ($xz)
        } // ENDIF (trim($xaux) != "")
        // ------------------      en este caso, para México se usa esta leyenda     ----------------
        $xcadena = str_replace("VEINTI ", "VEINTI", $xcadena); // quito el espacio para el VEINTI, para que quede: VEINTICUATRO, VEINTIUN, VEINTIDOS, etc
        $xcadena = str_replace("  ", " ", $xcadena); // quito espacios dobles
        $xcadena = str_replace("UN UN", "UN", $xcadena); // quito la duplicidad
        $xcadena = str_replace("  ", " ", $xcadena); // quito espacios dobles
        $xcadena = str_replace("BILLON DE MILLONES", "BILLON DE", $xcadena); // corrigo la leyenda
        $xcadena = str_replace("BILLONES DE MILLONES", "BILLONES DE", $xcadena); // corrigo la leyenda
        $xcadena = str_replace("DE UN", "UN", $xcadena); // corrigo la leyenda
    } // ENDFOR ($xz)
    return trim($xcadena);
}

// END FUNCTION

function subfijo($xx)
{ // esta función regresa un subfijo para la cifra
    $xx = trim($xx);
    $xstrlen = strlen($xx);
    if ($xstrlen == 1 || $xstrlen == 2 || $xstrlen == 3)
        $xsub = "";
    //
    if ($xstrlen == 4 || $xstrlen == 5 || $xstrlen == 6)
        $xsub = "MIL";
    //
    return $xsub;
}
function num2letras($num, $fem = true, $dec = true) {
    //if (strlen($num) > 14) die("El número introducido es demasiado grande");
    $matuni[2]  = "dos";
    $matuni[3]  = "tres";
    $matuni[4]  = "cuatro";
    $matuni[5]  = "cinco";
    $matuni[6]  = "seis";
    $matuni[7]  = "siete";
    $matuni[8]  = "ocho";
    $matuni[9]  = "nueve";
    $matuni[10] = "diez";
    $matuni[11] = "once";
    $matuni[12] = "doce";
    $matuni[13] = "trece";
    $matuni[14] = "catorce";
    $matuni[15] = "quince";
    $matuni[16] = "dieciseis";
    $matuni[17] = "diecisiete";
    $matuni[18] = "dieciocho";
    $matuni[19] = "diecinueve";
    $matuni[20] = "veinte";
    $matunisub[2] = "dos";
    $matunisub[3] = "tres";
    $matunisub[4] = "cuatro";
    $matunisub[5] = "quin";
    $matunisub[6] = "seis";
    $matunisub[7] = "sete";
    $matunisub[8] = "ocho";
    $matunisub[9] = "nove";
    $matdec[2] = "veint";
    $matdec[3] = "treinta";
    $matdec[4] = "cuarenta";
    $matdec[5] = "cincuenta";
    $matdec[6] = "sesenta";
    $matdec[7] = "setenta";
    $matdec[8] = "ochenta";
    $matdec[9] = "noventa";
    $matsub[3]  = 'mill';
    $matsub[5]  = 'bill';
    $matsub[7]  = 'mill';
    $matsub[9]  = 'trill';
    $matsub[11] = 'mill';
    $matsub[13] = 'bill';
    $matsub[15] = 'mill';
    $matmil[4]  = 'millones';
    $matmil[6]  = 'billones';
    $matmil[7]  = 'de billones';
    $matmil[8]  = 'millones de billones';
    $matmil[10] = 'trillones';
    $matmil[11] = 'de trillones';
    $matmil[12] = 'millones de trillones';
    $matmil[13] = 'de trillones';
    $matmil[14] = 'billones de trillones';
    $matmil[15] = 'de billones de trillones';
    $matmil[16] = 'millones de billones de trillones';
    $num = trim((string)@$num);
    if ($num[0] == '-') {
        $neg = 'menos ';
        $num = substr($num, 1);
    }else
        $neg = '';
    while ($num[0] == '0') $num = substr($num, 1);
    if ($num[0] < '1' or $num[0] > 9) $num = '0' . $num;
    $zeros = true;
    $punt = false;
    $ent = '';
    $fra = '';
    for ($c = 0; $c < strlen($num); $c++) {
        $n = $num[$c];
        if (! (strpos(".,''`", $n) === false)) {
            if ($punt) break;
            else{
                $punt = true;
                continue;
            }
        }elseif (! (strpos('0123456789', $n) === false)) {
            if ($punt) {
                if ($n != '0') $zeros = false;
                $fra .= $n;
            }else
                $ent .= $n;
        }else
            break;
    }

    $ent = '     ' . $ent;

    if ($dec and $fra and ! $zeros) {
        $fin = ' punto';
        for ($n = 0; $n < strlen($fra); $n++) {
            if (($s = $fra[$n]) == '0')
                $fin .= ' cero';
            elseif ($s == '1')
                $fin .= $fem ? ' uno' : ' un';
            else
                $fin .= ' ' . $matuni[$s];
        }
    }else
        $fin = '';
    if ((int)$ent === 0) return 'Cero ' . $fin;
    $tex = '';
    $sub = 0;
    $mils = 0;
    $neutro = false;

    while ( ($num = substr($ent, -3)) != '   ') {

        $ent = substr($ent, 0, -3);
        if (++$sub < 3 and $fem) {
            $matuni[1] = 'uno';
            $subcent = 'as';
        }else{
            $matuni[1] = $neutro ? 'un' : 'uno';
            $subcent = 'os';
        }
        $t = '';
        $n2 = substr($num, 1);
        if ($n2 == '00') {
        }elseif ($n2 < 21)
            $t = ' ' . $matuni[(int)$n2];
        elseif ($n2 < 30) {
            $n3 = $num[2];
            if ($n3 != 0) $t = 'i' . $matuni[$n3];
            $n2 = $num[1];
            $t = ' ' . $matdec[$n2] . $t;
        }else{
            $n3 = $num[2];
            if ($n3 != 0) $t = ' y ' . $matuni[$n3];
            $n2 = $num[1];
            $t = ' ' . $matdec[$n2] . $t;
        }

        $n = $num[0];
        if ($n == 1) {
            $t = ' ciento' . $t;
        }elseif ($n == 5){
            $t = ' ' . $matunisub[$n] . 'ient' . $subcent . $t;
        }elseif ($n != 0){
            $t = ' ' . $matunisub[$n] . 'cient' . $subcent . $t;
        }

        if ($sub == 1) {
        }elseif (! isset($matsub[$sub])) {
            if ($num == 1) {
                $t = ' mil';
            }elseif ($num > 1){
                $t .= ' mil';
            }
        }elseif ($num == 1) {
            $t .= ' ' . $matsub[$sub] . 'ón';
        }elseif ($num > 1){
            $t .= ' ' . $matsub[$sub] . 'ones';
        }
        if ($num == '000') $mils ++;
        elseif ($mils != 0) {
            if (isset($matmil[$sub])) $t .= ' ' . $matmil[$sub];
            $mils = 0;
        }
        $neutro = true;
        $tex = $t . $tex;
    }
    $tex = $neg . substr($tex, 1) . $fin;
    return ucfirst($tex);
}
/*Buscar item dentro de array*/
function buscar_en_array($word, $array) {
    if(is_array($array)){
        foreach ($array as $key=>$item) {
            $res = array_search($word,$item);
            if ($res) {
                return $item;
            }

        }
        return false;
    }
    else{
        die("El sugundo parametro debe se un Array");
    }
}

/*Buscar en Object*/
function in_object($word, $array) {
    if(is_array($array)){
        foreach ($array as $key=>$item) {

            if ($item->id_area==$word) {
                return true;
            }

        }
        return false;
    }
    else{
        die("El sugundo parametro debe se un array");
    }
}

/*Verificar si existe un archivo en un servidor remoto*/
function remote_file_exists($url)
{
    $file = $url;
    $file_headers = @get_headers($file);

    switch($file_headers[0])
    {
        case 'HTTP/1.1 404 Not Found':
            return false;
            break;

        case 'HTTP/1.1 302 Moved Temporarily':
            return false;
            break;

        default:
            return true;

    }
}

/*Devuelve el nro de dias entre dos fecha*/
function NroDias_RangoFechas($fecha_i,$fecha_f,$inclusive=false)
{

    $dias	= (strtotime($fecha_i)-strtotime($fecha_f))/86400;
    $dias 	= abs($dias);
    $dias = floor($dias);
    if($inclusive){
        $dias = $dias + 1;
    }

    return $dias;
}


function validateEspecialidad($arreglo, $dni, $especilidad)
{
    if($especilidad == "")
    {
        for ($i=0; $i <count($arreglo) ; $i++)
        {
            if($arreglo[$i]["cod_plaza"] === $dni)
            {
                echo $arreglo[$i]["carrera"];
            }
        }
    }
    else
    {
        echo $especilidad;
    }
}

function getHoras($grado, $codplaza, $area, $data)
{
    for ($i=0; $i < count($data) ; $i++) {
        if($data[$i]["grado"] == $grado && $data[$i]["codplaza"] == $codplaza && $data[$i]["areas_codigo"] == $area )
        {
            return $data[$i]["horas"];
        }
    }
}

function getSum($grado, $modalidad, $data)
{
    $cont = 0;
    for ($i=0; $i < count($data) ; $i++) {
        if($data[$i]["grado"] == $grado && $data[$i]["modalidad"] == $modalidad )
        {
            $cont += $data[$i]["horas"];
        }
    }

    return $cont;
}

function getSumSemi($grado, $modalidad, $data)
{
    $cont = 0;
    for ($i=0; $i < count($data) ; $i++) {
        if($data[$i]["grado"] == $grado && substr($data[$i]["modalidad"],0,13) == $modalidad )
        {
            $cont += $data[$i]["horas"];
        }
    }

    return $cont;
}

function sumaGeneralHoras($grado, $data)
{
    for ($i=0; $i <count($data) ; $i++) {
        if($data[$i]["grado"] == $grado)
        {
            return $data[$i]["horas"];
        }
    }
}

function getHorasTotal($codplaza, $area, $data)
{
    for ($i=0; $i <count($data) ; $i++) {
        if ($data[$i]["codplaza"] == $codplaza && $data[$i]["area_codigo"] == $area) {
            return $data[$i]["horas"];
        }
    }
}

function getHorasArea($codplaza, $area, $data)
{
    $espec = "";
    for ($i=0; $i <count($data) ; $i++) {
        if ($data[$i]["codplaza"] == $codplaza && $data[$i]["area_codigo"] == $area) {
            if($data[$i]["area_codigo"] == "E189" || $data[$i]["area_codigo"] == "JE189" || $data[$i]["area_codigo"] == "E188" || $data[$i]["area_codigo"] == "JE188" || $data[$i]["area_codigo"] == "CEB189" || $data[$i]["area_codigo"] == "SEMIEP")
            {
                $espec = "<br>".$data[$i]["especialidad"];
            }
            return $data[$i]["areas_nombre"].$espec;
        }
    }
}



?>