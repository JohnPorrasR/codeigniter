<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Home extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        ini_set("max_execution_time", 0);
        $this->load->library('session');
        $this->load->library("excelphp");
        $this->load->model('Model_home', 'home');
        $this->load->model("Model_user", "user");
    }

    public function index()
    {
        $this->load->view('login/login');
    }

    public function login()
    {
        $msg = array();
        $data = $this->user->obtener_usuario($_POST);
        if ($data)
        {
            if ($data[0]['m_estado'] == 0)
            {
                $msg["resp"] = 10;
                $msg["text"] = "Su usuario se encuentra bloqueado.";
                echo json_encode($msg);die;
            }
            $server = $this->user->obtener_sistema();
            $usuario = $this->user->obtener_datos_usuario_persona($data[0]['n_id_usuario']);
            $menu_n1 = $this->user->obtener_menu_n1($data[0]['n_id_usuario'], $usuario[0]["m_perfil_entidad_id"]);
            $menu_n2 = $this->user->obtener_menu_n2($data[0]['n_id_usuario'], $usuario[0]["m_perfil_entidad_id"]);
            $menu_n3 = $this->user->obtener_menu_n3($data[0]['n_id_usuario'], $usuario[0]["m_perfil_entidad_id"]);

            if(count($server) > 0)
            {
                $sistema = $server[0]['x_nomb'];
            }else{
                $sistema = 'Demo';
            }
            $this->session->set_userdata(
                array(
                    "usu" => $data[0]['x_usuario'], "id" => $data[0]['n_id_usuario'],
                    "nomb" => $usuario[0]['x_ape_pat'].' '.$usuario[0]['x_ape_mat'].', '.$usuario[0]['x_nombres'], "id_perfil" => $usuario[0]["m_perfil_entidad_id"],
                    "sistema" => $sistema,
                    "menu_n1" => $menu_n1, "menu_n2" => $menu_n2, "menu_n3" => $menu_n3
                )
            );
            $msg["resp"] = 100;
            $msg["text"] = "Accediendo!!!.";
        }
        else
        {
            $msg["resp"] = 10;
            $msg["text"] = "Usuario y/o contraseña incorrecta, o el usuario no existe.";
        }
        echo json_encode($msg);
    }

    public function cpanel()
    {
        $usuario = $this->session->userdata('id');
        if (!empty($usuario)) {
            $this->load->view('index');
        }else{
            redirect(base_url());
        }
    }

    public function logout()
    {
        $this->session->sess_destroy();
        redirect(base_url());
    }

    public function cambiar_clave()
    {
        $usuario = $this->session->userdata('id');
        if (!empty($usuario)) {
            $txtClave           = $this->input->post("txtClave");
            $txtConfirmar       = $this->input->post("txtConfirmar");
            $data               = array();
            $data["n_id_usuario"] = $usuario;
            $data["x_clave"]   = MD5($txtClave);
            if(strlen($txtClave) > 0 && strlen($txtConfirmar) > 0){
                if($txtClave == $txtConfirmar){
                    $id         = $this->home->cambiarCLave($data);
                }else{
                    $id         = 0;
                }
            }else{
                $id             = 0;
            }
            $msg                = array();
            if ($id > 0) {
                $msg["resp"]    = 100;
                $msg["text"]    = 'Se ha cambiado la clave con exito.';
            }else{
                $msg["resp"]    = 10;
                $msg["text"]    = 'Error, no se ha podido cambiar la clave.';
            }
            echo json_encode($msg);
        }else{
            redirect(base_url());
        }
    }

    public function redireccionar()
    {
        $grupo = $this->uri->segment(3);
        $_SESSION["grupoModulo"] = $grupo;
        redirect(base_url()."home/cpanel");
    }

    public function cambioEstado()
    {
        $data             = array();
        $tabla            = $this->input->post("tabla");
        $x_id             = $this->input->post("x_id");
        $data["$x_id"]    = $this->input->post("id");
        $data["m_estado"] = $this->input->post("estado");

        $text = '';
        if ($this->input->post("estado") > 0) {
            $text .= 'El registro esta desbloqueado';
        }else{
            $text .= 'El registro esta bloqueado';
        }

        $id = $this->home->eliminarDato($data, $tabla, $x_id);

        $msg = array();
        if ($id > 0) {
            $msg["resp"] = 100;
            $msg["text"] = $text;
        } else {
            $msg["resp"] = 10;
            $msg["text"] = 'Error al ejecutar la acción, si el problema persiste comuniquese con el adminitrador.';
        }
        echo json_encode($msg);
    }

    public function excel()
    {
        $tabla = $this->uri->segment(3);
        $datos = $this->home->obtenerDatosReporte($tabla);
        if($datos){
            $tituloReporte = $datos[0]['x_titulo'];
            $nombreCabecera = $datos[0]['x_cabecera'];
            $n_col = $datos[0]['m_columna'];
            $nombreHoja = $datos[0]['x_nombre_hoja'];
            $nombreArchivo = $datos[0]['x_nombre_archivo'];
            $data = $this->home->obtenerDatos($tabla);
            $this->exportar_excel($tituloReporte,$nombreCabecera,$n_col,$data,$nombreHoja,$nombreArchivo);
        }else{
            die("No se ha podido generar el reporte si el problema persiste informe al administrador");
        }
    }

    public function exportar_excel($tituloReporte,$nombreCabecera,$n_col,$data,$nombreHoja,$nombreArchivo)
    {
        // Crea un nuevo objeto PHPExcel
        $objPHPExcel = new PHPExcel();

        //PREPARANDO EL EXCEL
        $objPHPExcel->getProperties()->setCreator("John Porras R"); // Nombre del autor
        $objPHPExcel->getProperties()->setTitle("John Porras R"); // Titulo
        $objPHPExcel->getProperties()->setSubject("reporte"); //Asunto
        $objPHPExcel->getProperties()->setDescription("reporte"); //Descripción
        $objPHPExcel->getProperties()->setCategory("reporte"); //Categorias
        $objPHPExcel->getProperties()->setKeywords("reporte"); //Etiquetas

        $titulosColumnas = explode(",", $nombreCabecera);
        $columna = ['A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z'];

        $lenghCol = $columna[$n_col];

        // Se combinan las celdas A1 hasta X1, para colocar ahí el titulo del reporte
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:'.$lenghCol.'1');
          
        // Se agregan los titulos del reporte
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1','Lista de '.$tituloReporte); // Titulo del reporte
        for ($i=0; $i < sizeof($titulosColumnas); $i++) { 
            if ($i == sizeof($titulosColumnas)) {
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($columna[$i].'2',  $titulosColumnas[$i]);
            }else{
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($columna[$i].'2',  $titulosColumnas[$i]);
            }
        }

        $n = 3;
        //Numero de fila donde se va a comenzar a rellenar
        for ($i=0; $i < sizeof($data); $i++) {            
            for ($j=0; $j < sizeof($data[$i]); $j++) {
                if (sizeof($data) == $i) {
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($columna[$j].$n, $data[$i]['dato'.$j]);
                }else{
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($columna[$j].$n, $data[$i]['dato'.$j]);
                }
            }
            $n = $n + 1;
        }


        $estiloTituloReporte = array(
            // 'font' => array('name'=> 'Calibri','bold'=> true,'italic'=> false,'strike'=> false,'size'=> 16,'color'=> array('rgb'=> 'FFFFFF')),
            // 'fill' => array('type'  => PHPExcel_Style_Fill::FILL_SOLID,'color' => array('argb' => '14142D')),
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                )
            ),
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                'rotation' => 0,
                'wrap' => TRUE
            )
        );
  
        $estiloTituloColumnas = array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                )
            )
        );
  
        $estiloInformacion = new PHPExcel_Style();
        $estiloInformacion->applyFromArray( array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                )
            )
        ));

        $objPHPExcel->getActiveSheet()->getStyle('A1:'.$lenghCol.'1')->applyFromArray($estiloTituloReporte);
        $objPHPExcel->getActiveSheet()->getStyle('A2:'.$lenghCol.'2')->applyFromArray($estiloTituloColumnas);
        $objPHPExcel->getActiveSheet()->setSharedStyle($estiloInformacion, "A4:$lenghCol".($n-1));

        for($i = 'A'; $i <= $lenghCol; $i++){
            $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension($i)->setAutoSize(TRUE);
        }

        // Se asigna el nombre a la hoja
        $objPHPExcel->getActiveSheet()->setTitle($nombreHoja);
          
        // Se activa la hoja para que sea la que se muestre cuando el archivo se abre
        $objPHPExcel->setActiveSheetIndex(0);
          
        // Inmovilizar paneles
        //$objPHPExcel->getActiveSheet(0)->freezePane('A4');
        $objPHPExcel->getActiveSheet(0)->freezePaneByColumnAndRow(0,$n_col);

        // Se manda el archivo al navegador web, con el nombre que se indica, en formato 2007
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="'.$nombreArchivo.'.xlsx"');
        header('Cache-Control: max-age=0');
          
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('php://output');
        exit;

    }

}
