<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Perfiles extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        ini_set("max_execution_time", 0);
        $this->load->library('session');
        $this->load->model("Model_home", "home");
        $this->load->model("Model_user", "user");
        $this->load->model("configuracion/Model_perfil", "perfil");
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
            $dataview['label2'] = ['Código','Perfil', 'Entidad', 'Sede'];
            $dataview['label3'] = ['Código','Perfil', 'Modulo', 'Acción'];
            $dataview['labelTabla1'] = ['Código','Nombre','Estado'];
            $dataview['labelTabla2'] = ['Código','Perfil', 'Entidad','Estado'];
            $dataview['labelTabla3'] = ['Código','Perfil','Modulo', 'Acción','Estado'];
            $dataview["cajas1"] = $this->home->obtenerCajas('tbm_perfiles');
            $dataview["cajas2"] = $this->home->obtenerCajas('tbm_perfiles_entidades');
            $dataview["cajas3"] = $this->home->obtenerCajas('tbm_perfiles_acciones', 'm_accion_id');
            $dataview["url"] = $url;
            $dataview["tabla"] = ['tbm_perfiles', 'tbm_perfiles_entidades', 'tbm_perfiles_acciones'];
            $dataview["labelId"] = ['n_id_perfil', 'n_id_perfil_entidad', 'n_id_perfil_accion'];
            $dataview["tabs"] = ['Perfiles', 'Perfil y entidad', 'Perfil y acciones'];
            // $dataview["nivel3"] = "Entidades";
            // writer($dataview["cajas2"]); die;
            $this->load->view($url.'/index', $dataview);
        }else{
            redirect(base_url());
        }
    }

    public function mostrar_perfiles()
    {
        $resp = $this->perfil->mostrar_datos();
        $data = array();
        foreach($resp as $d) {
            $row = array();
            $row['id'] = $d['n_id_perfil'];
            $row['nomb'] = $d['x_desc_perfil'];
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

    public function mostrar_perfiles_entidades()
    {
        $resp = $this->perfil->mostrar_perfiles_entidades();
        $data = array();
        foreach($resp as $d) {
            $row = array();
            $row['id'] = $d['n_id_perfil_entidad'];
            $row['nomb'] = $d['x_desc_perfil'];
            $row['entidad'] = $d['x_entidad_nomb'];
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

    public function mostrar_perfiles_acciones()
    {
        $resp = $this->perfil->mostrar_perfiles_acciones();
        $data = array();
        foreach($resp as $d) {
            $row = array();
            $row['id'] = $d['n_id_perfil_accion'];
            $row['per'] = $d['x_desc_perfil'];
            $row['mod'] = $d['x_modulo_desc'];
            $row['acc'] = $d['x_descripcion'];
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

    public function cargar_combos()
    {
        $entidades = $this->perfil->mostrar_tablas('tbm_entidades', '');
        $perfiles = $this->perfil->mostrar_tablas('tbm_perfiles', '');
        $acciones = $this->perfil->mostrar_tablas('tbm_acciones', '');
        $modulos = $this->perfil->mostrar_tablas('tbm_modulos', ' and m_nivel = 3');
        $dataview['entidades'] = $entidades;
        $dataview['perfiles'] = $perfiles;
        $dataview['acciones'] = $acciones;
        $dataview['modulos'] = $modulos;
        echo json_encode($dataview);
    }

    public function guardar()
    {
        $data = array();
        $val = $this->input->post('val');
        $dara = array();
        if($val == 1)
        {
            $data['n_id_perfil'] = $this->input->post('n_id_perfil');
            $data['x_desc_perfil'] = $this->input->post('x_desc_perfil');
            $data['m_estado'] = $this->input->post('m_estado');
            $resp = $this->perfil->guardar($data);
        }
        else if($val == 2)
        {
            $data['n_id_perfil_entidad'] = $this->input->post('n_id_perfil_entidad');
            $data['m_perfil_id'] = $this->input->post('m_perfil_id');
            $data['m_entidad_id'] = $this->input->post('m_entidad_id');
            $resp = $this->perfil->guardarPerfilEntidad($data);
        }
        else
        {
            $acciones = explode(",", $this->input->post('m_accion_id'));
            if(sizeof($acciones) > 0){
                $this->perfil->actualizar($this->input->post('m_perfil_id'), $this->input->post('m_modulo_id'));
                for ($i=0; $i < sizeof($acciones); $i++) { 
                    $data['m_perfil_id'] = $this->input->post('m_perfil_id');
                    $data['m_modulo_id'] = $this->input->post('m_modulo_id');
                    $data['m_accion_id'] = $acciones[$i];
                    $data['m_estado']   = 1;
                    $resp = $this->perfil->guardarPerfilAccion($data);
                }
            }else{
                $resp = 0;
            }
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

    public function obtener_dato()
    {
        $cod = $this->input->post('txtCod');
        $resp = $this->perfil->obtenerDatoPorCod($cod);
        $dataview['data'] = $resp;
        echo json_encode($dataview);
    }

    public function obtener_perfil_entidad()
    {
        $cod = $this->input->post('txtCod');
        $resp = $this->perfil->obtenerPerfilEntidad($cod);
        $dataview['data'] = $resp;
        echo json_encode($dataview);
    }

    public function obtener_perfil_accion()
    {
        $cod = $this->input->post('txtCod');
        $resp = $this->perfil->obtenerPerfilAccion($cod);
        $dataview['data'] = $resp;
        $dataview["tipo"] = 'success';
        $dataview["titulo"] = 'Mensaje: ';
        $dataview["text"] = 'En esta vista se edita el módulo comnpleto que este unido al perfil.';
        echo json_encode($dataview);
    }

    public function obtener_perfil_modulo()
    {
        $mod = $this->input->post('mod');
        $perf = $this->input->post('perf');
        $resp = $this->perfil->obtenerPerfilAccionPorCodModulo($mod, $perf);
        $dataview['data'] = $resp;
        echo json_encode($dataview);
    }

}
