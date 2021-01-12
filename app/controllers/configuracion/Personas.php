<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Personas extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        ini_set("max_execution_time", 0);
        $this->load->library('session');
        $this->load->model("Model_home", "home");
        $this->load->model("Model_user", "user");
        $this->load->model("configuracion/Model_persona", "persona");
    }

    public function index()
    {
        $usuario = $this->session->userdata('id');
        if (!empty($usuario)) {
            $dataview = array();
            $url = $this->uri->segment(1).'/'.$this->uri->segment(2);
            $perfil = $this->session->userdata('id_perfil');
            $array = $this->session->userdata("menu_n3");
            $nodo = array_search($this->uri->segment(2), array_column($array, 'x_url'));
            $n_id_modulo = $array[$nodo]['n_id_modulo'];
            $dataview["acciones"] = $this->user->obtener_acciones($perfil, $n_id_modulo);
            $dataview["nivel1"] = strtoupper(substr($this->uri->segment(1), 0, 1)).substr($this->uri->segment(1), 1);
            $dataview["nivel2"] = strtoupper(substr($this->uri->segment(2), 0, 1)).substr($this->uri->segment(2), 1);
            $dataview['label1'] = ['Código','Ape. Paterno', 'Ape. materno', 'Nombres', 'Tipo Doc.', 'Nro. Doc', 'Coreo personal', 'Correo institucional', 'Celular', 'Nacimiento', 'Usuario', 'Entidad', 'Cargo', 'Perfil', 'Estado'];
            $dataview['labelTabla1'] = ['Código','Ape. Paterno', 'Ape. materno', 'Nombres', 'Tipo Doc.', 'Nro. Doc', 'Coreo personal', 'Correo institucional', 'Celular', 'Nacimiento', 'Usuario', 'Cargo', 'Perfil', 'Estado'];
            $array = array(
                          array("n_id_persona", "int", "required", "", "", "int(11)", ""),
                          array("x_ape_pat", "varchar", "required", "", "", "varchar(255)", ""),
                          array("x_ape_mat", "varchar", "required", "", "", "varchar(255)", ""),
                          array("x_nombres", "varchar", "required", "", "", "varchar(255)", ""),
                          array("x_tipo_doc", "varchar", "required", "", "", "varchar(255)", "1"),
                          array("x_num_doc", "varchar", "required", "", "", "varchar(255)", ""),
                          array("x_correo_personal", "varchar", "", "", "", "varchar(255)", ""),
                          array("x_correo_institucional", "varchar", "", "", "", "varchar(255)", ""),
                          array("m_celular", "int", "", "", "", "int(11)", ""),
                          array("f_cumple", "varchar", "", "", "", "varchar(255)", ""),
                          array("x_usuario", "int", "required", "", "", "int(11)", ""),
                          array("m_entidad_id", "int", "required", "", "", "int(11)", "1"),
                          array("m_cargo_entidad_id", "int", "required", "", "", "int(11)", "1"),
                          array("m_perfil_entidad_id", "int", "required", "", "", "int(11)", "1"),
                          array("m_estado", "int", "required", "", "", "int(11)", "1")
                        );
            $dataview["cajas1"] = $this->home->generarCajas($array);
            $dataview["url"] = $url;
            $dataview["tabla"] = ['tbm_personas'];
            $dataview["labelId"] = ['n_id_persona'];
            $dataview["tabs"] = ['Personas'];

            $this->load->view($url.'/index', $dataview);
        }else{
            redirect(base_url());
        }
    }

    public function mostrar_datos()
    {
        $resp = $this->persona->mostrar_datos();

        $data = array();
        foreach($resp as $d) {
            $row = array();
            $row['id'] = $d['n_id_persona'];
            $row['pat'] = $d['x_ape_pat'];
            $row['mat'] = $d['x_ape_mat'];
            $row['nomb'] = $d['x_nombres'];
            $row['tipo_doc'] = $d['x_tipo_doc'];
            $row['nro_doc'] = $d['x_num_doc'];
            $row['corr_p'] = $d['x_correo_personal'];
            $row['corr_i'] = $d['x_correo_institucional'];
            $row['cel'] = $d['m_celular'];
            $row['cum'] = $d['f_cumple'];
            $row['usu'] = $d['x_usuario'];
            $row['cargo'] = $d['x_cargo_desc'];
            $row['perfil'] = $d['x_desc_perfil'];
            if($d['m_estado'] > 0){
                $row['estado'] = 'Habilitado';
            }else{
                $row['estado'] = 'Desabilitado';
            }
            $data[] = $row;
        }
        $output = array(
            "data" => $data
        );
        echo json_encode($output);
    }

    public function combos()
    {
        $entidades = $this->persona->obtenerEntidades();
        $perfiles = $this->persona->obtenerPerfiles(0);
        $cargos = $this->persona->obtenerCargos(0);
        $dataview['entidades'] = $entidades;
        $dataview['perfiles'] = $perfiles;
        $dataview['cargos'] = $cargos;
        $dataview['tiposDocs'] = array('Doc. Extranjero','DNI');
        echo json_encode($dataview);
    }

    public function cargar_combos()
    {
        $cod = $this->input->post('txtCod');
        $perfiles = $this->persona->obtenerPerfiles($cod);
        $cargos = $this->persona->obtenerCargos($cod);
        $dataview['perfiles'] = $perfiles;
        $dataview['cargos'] = $cargos;
        echo json_encode($dataview);
    }

    public function obtener_dato()
    {
        $cod = $this->input->post('txtCod');
        $resp = $this->persona->obtenerDatoPorCod($cod);
        $dataview['data'] = $resp;
        echo json_encode($dataview);
    }

    public function guardar()
    {
        $persona = $this->persona->obtenerDatoPorCod($this->input->post('n_id_persona'));
        $dataU = array();
        if($this->input->post('n_id_persona') == 0){
            $dataU['n_id_usuario'] = '0';
            $dataU['x_usuario'] = $this->input->post('x_usuario');
            $dataU['x_clave'] = md5($this->input->post('x_usuario'));
        }else{
            $dataU['n_id_usuario'] = $persona[0]['m_usuario_id'];
            $dataU['x_usuario'] = $this->input->post('x_usuario');
            $dataU['x_clave'] = md5($this->input->post('x_usuario'));
        }
        $respU = $this->persona->guardarUsuario($dataU);

        $data = array();
        $data['n_id_persona'] = $this->input->post('n_id_persona');
        $data['x_ape_pat'] = $this->input->post('x_ape_pat');
        $data['x_ape_mat'] = $this->input->post('x_ape_mat');
        $data['x_nombres'] = $this->input->post('x_nombres');
        $data['x_tipo_doc'] = $this->input->post('x_tipo_doc');
        $data['x_num_doc'] = $this->input->post('x_num_doc');
        $data['x_correo_personal'] = $this->input->post('x_correo_personal');
        $data['x_correo_institucional'] = $this->input->post('x_correo_institucional');
        $data['m_celular'] = $this->input->post('m_celular');
        $data['f_cumple'] = $this->input->post('f_cumple');
        if($this->input->post('n_id_persona') == 0){
            $data['m_usuario_id'] = $respU;
        }else{
            $data['m_usuario_id'] = $persona[0]['m_usuario_id'];
        }
        $data['m_estado'] = $this->input->post('m_estado');
        $resp = $this->persona->guardar($data);

        $dataD = array();
        if($this->input->post('n_id_persona') == 0){
            $dataD['m_persona_id'] = $resp;
        }else{
            $dataD['m_persona_id'] = $this->input->post('n_id_persona');
        }
        $dataD['m_cargo_entidad_id'] = $this->input->post('m_cargo_entidad_id');
        $dataD['m_perfil_entidad_id'] = $this->input->post('m_perfil_entidad_id');
        $respD = $this->persona->guardarDetalle($dataD);

        $data = array();

        $msg = array();
        if ($respD) {
            $msg["resp"] = 100;
            $msg["tipo"] = 'success';
            $msg["titulo"] = 'Mensaje: ';
            $msg["text"] = 'Datos guardados.';
        }else{
            $msg["resp"] = 10;
            $msg["tipo"] = 'error';
            $msg["titulo"] = 'Mensaje: ';
            $msg["text"] = 'Error al guardar.';
        }

        echo json_encode($msg);
    }

}
