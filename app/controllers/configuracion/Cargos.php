<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Cargos extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        ini_set("max_execution_time", 0);
        $this->load->library('session');
        $this->load->model("Model_home", "home");
        $this->load->model("Model_user", "user");
        $this->load->model("configuracion/Model_cargo", "cargo");
        $this->load->model("configuracion/Model_entidad", "entidad");
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
            // $dataview["txt"] = "Entidades";
            $dataview["acciones"] = $this->user->obtener_acciones($perfil, $n_id_modulo);
            $dataview["nivel1"] = strtoupper(substr($this->uri->segment(1), 0, 1)).substr($this->uri->segment(1), 1);
            $dataview["nivel2"] = strtoupper(substr($this->uri->segment(2), 0, 1)).substr($this->uri->segment(2), 1);
            $dataview['label1'] = ['Código','Nombre', 'Estado'];
            $dataview['label2'] = ['Código','Cargo', 'Entidad', 'Sede'];
            $dataview['labelTabla1'] = ['Código','Nombre','Estado'];
            $dataview['labelTabla2'] = ['Código','Nombre', 'Entidad','Sede','Estado'];
            $dataview["cajas1"] = $this->home->obtenerCajas('tbm_cargos');
            $dataview["cajas2"] = $this->home->obtenerCajas('tbm_cargos_entidades');
            $dataview["url"] = $url;
            $dataview["tabla"] = ['tbm_cargos', 'tbm_cargos_entidades'];
            $dataview["labelId"] = ['n_id_cargo', 'n_id_cargo_entidad'];
            $dataview["tabs"] = ['Cargos', 'Cargo y entidad'];
            // $dataview["nivel3"] = "Entidades";
            // writer($dataview["cajas2"]); die;
            $this->load->view($url.'/index', $dataview);
        }else{
            redirect(base_url());
        }
    }

    public function mostrar_cargos()
    {
        $resp = $this->cargo->mostrar_cargos();
        $data = array();
        foreach($resp as $d) {
            $row = array();
            $row['id'] = $d['n_id_cargo'];
            $row['nomb'] = $d['x_cargo_desc'];
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

    public function mostrar_datos()
    {
        $resp = $this->cargo->mostrar_datos();
        $data = array();
        foreach($resp as $d) {
            $row = array();
            $row['id'] = $d['n_id_cargo_entidad'];
            $row['nomb'] = $d['x_cargo_desc'];
            $row['entidad'] = $d['x_entidad_nomb'];
            $row['sede'] = $d['m_nodo'];
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

    public function obtener_cargo()
    {
        $cod = $this->input->post('txtCod');
        $resp = $this->cargo->obtenerCargoPorCod($cod);
        $dataview['data'] = $resp;
        echo json_encode($dataview);
    }

    public function obtener_dato()
    {
        $cod = $this->input->post('txtCod');
        $resp = $this->cargo->obtenerDatoPorCod($cod);
        $dataview['data'] = $resp;
        echo json_encode($dataview);
    }

    public function guardar()
    {
        // writer($_POST); die;
        $data = array();
        $val = $this->input->post('val');
        $dara = array();
        if($val == 1)
        {
            $data['n_id_cargo'] = $this->input->post('n_id_cargo');
            $data['x_cargo_desc'] = $this->input->post('x_cargo_desc');
            $data['m_estado'] = $this->input->post('m_estado');
            $resp = $this->cargo->guardar($data);
        }
        else
        {
            $data['n_id_cargo_entidad'] = $this->input->post('n_id_cargo_entidad');
            $data['m_cargo_id'] = $this->input->post('m_cargo_id');
            $data['m_entidad_id'] = $this->input->post('m_entidad_id');
            $data['m_nodo'] = $this->input->post('m_nodo');
            $data['m_estado'] = $this->input->post('m_estado');
            $resp = $this->cargo->guardarCargoEntidad($data);
        }
        $msg = array();
        if ($resp) {
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

    public function cargar_combos()
    {
        $cargos = $this->cargo->mostrar_cargos();
        $entidades = $this->entidad->mostrar_datos();
        $dataview['cargos'] = $cargos;
        $dataview['entidades'] = $entidades;
        echo json_encode($dataview);
    }
}
