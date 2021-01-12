<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Entidades extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        ini_set("max_execution_time", 0);
        $this->load->library('session');
        $this->load->model("Model_home", "home");
        $this->load->model("Model_user", "user");
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
            $dataview['label1'] = ['Código','Nombre', 'Abreviatura', 'Dirección', 'Central', 'Estado'];
            $dataview['labelTabla1'] = ['Código','Nombre', 'Abreviatura', 'Dirección', 'Central', 'Estado'];
            $dataview["cajas1"] = $this->home->obtenerCajas('tbm_entidades');
            $dataview["url"] = $url;
            $dataview["tabla"] = ['tbm_entidades',''];
            $dataview["labelId"] = ['n_id_entidad',''];
            $dataview["tabs"] = ['Nuevas entidades'];
            // $dataview["nivel3"] = "Entidades";

            $this->load->view($url.'/index', $dataview);
        }else{
            redirect(base_url());
        }
    }

    public function mostrar_datos()
    {
        $resp = $this->entidad->mostrar_datos();

        $data = array();
        foreach($resp as $d) {
            $row = array();
            $row['id'] = $d['n_id_entidad'];
            $row['nomb'] = $d['x_entidad_nomb'];
            $row['abr'] = $d['x_entidad_abr'];
            $row['direc'] = $d['x_direccion'];
            $row['nodo'] = $d['m_entidad_id'];
            if($d['m_estado'] > 0){
                $row['estado'] = 'Habilitado';
            }else{
                $row['estado'] = 'Desabilitado';
            }
            $data[] = $row;
        }
        $output = array(
            //"draw" => $_POST['draw'],
            //"recordsTotal" => $count_all [0]->total,
            //"recordsFiltered" => $count_all [0]->total,
            // "recordsTotal" => $count_all_asistencia [0]->count_all_asistencia,
            //"recordsFiltered" => $count_filtered_requerimiento [0]->count_filtered_requerimiento,
            "data" => $data
        );
        echo json_encode($output);
    }

    public function combo()
    {
        $entidades = $this->entidad->mostrar_datos();
        $dataview['data'] = $entidades;
        echo json_encode($dataview);
    }

    public function obtener_dato()
    {
        $cod = $this->input->post('txtCod');
        $resp = $this->entidad->obtenerDatoPorCod($cod);
        $dataview['data'] = $resp;
        echo json_encode($dataview);
    }

    public function guardar()
    {
        $data = array();
        $resp = $this->entidad->guardar($_POST);

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

}
