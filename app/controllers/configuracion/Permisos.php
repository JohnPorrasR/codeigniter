<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Permisos extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        ini_set("max_execution_time", 0);
        $this->load->library('session');
        $this->load->model("Model_home", "home");
        $this->load->model("Model_user", "user");
        $this->load->model("configuracion/Model_permiso", "permiso");
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
            $dataview['label1'] = ['Código','Perfil', 'Módulo', 'Estado'];
            $dataview['labelTabla1'] = ['Código','Perfil', 'Módulo','Estado'];
            $dataview["cajas1"] = $this->home->obtenerCajas('tbm_permisos_base', 'm_modulo_id');
            $dataview["url"] = $url;
            $dataview["tabla"] = ['tbm_permisos_base'];
            $dataview["labelId"] = ['n_id_permiso_base'];
            $dataview["tabs"] = ['Plantilla de permisos'];
            // $dataview["nivel3"] = "Entidades";

            $this->load->view($url.'/index', $dataview);
        }else{
            redirect(base_url());
        }
    }

    public function mostrar_datos()
    {
        $resp = $this->permiso->mostrar_datos();
        $mod  = $this->permiso->mostrar_modulos();

        $data = array();
        foreach($resp as $d) {
            $row = array();
            $row['id'] = $d['m_perfil_entidad_id'];
            $row['perfil'] = $d['x_desc_perfil'];
            $row['modulo'] = '';
            foreach($mod as $m) {
                if ($d['m_perfil_entidad_id'] == $m['m_perfil_entidad_id']) {
                    $row['modulo'] .= $m['x_modulo_desc'].' | ';
                }
            }
            $row['estado'] = 1;
            $data[] = $row;
        }
        $output = array(
            "data" => $data
        );
        echo json_encode($output);
    }

    public function cargar_combos()
    {
        $perfiles = $this->permiso->mostrar_tablas('tbm_perfiles', '');
        $modulos = $this->permiso->mostrar_tablas('tbm_modulos', ' and m_nivel = 3');
        $dataview['perfiles'] = $perfiles;
        $dataview['modulos'] = $modulos;
        echo json_encode($dataview);
    }

    public function obtener_dato()
    {
        $cod = $this->input->post('txtCod');
        $resp = $this->permiso->obtenerDatoPorCod($cod);
        $resp1 = $this->permiso->obtenerVistaModulosPerfil_n1($cod);
        $resp2 = $this->permiso->obtenerVistaModulosPerfil_n2($cod);
        $resp3 = $this->permiso->obtenerVistaModulosPerfil_n3($cod);
        $html  = '';
        foreach ($resp1 as $k1 => $v1) {
            $html .= "<div>"."<h5>".$v1['x_modulo_desc']."</h5>";
            foreach ($resp2 as $k2 => $v2) {
                if ($v2['m_modulo_id'] == $v1['n_id_modulo']) {
                    // $array1['div1'] = "<div'>".$v1['x_modulo_desc']."</div>";"<div id='".$v1['n_id_modulo']."'>".$v2['x_modulo_desc']."</div>";
                    $html .= "<div id='".$v1['n_id_modulo']."' style='margin:2px 5px;'>".'<h6>'.$v2['x_modulo_desc'].'</h6>';
                    foreach ($resp3 as $k3 => $v3) {
                        if ($v3['m_modulo_id'] == $v2['n_id_modulo']) {
                            // $array1['div1'] = "<div'>".$v1['x_modulo_desc']."</div>";"<div id='".$v1['n_id_modulo']."'>".$v2['x_modulo_desc']."</div>";
                            $html .= "<span style='margin: 2px 5px;'>".$v3['x_modulo_desc']."</span>";
                        }
                    }
                    $html .= "</div>";
                }
            }
            $html .="</div>";
        }
        $dataview['html'] = $html;
        $dataview['data'] = $resp;
        echo json_encode($dataview);
    }

    public function guardar()
    {
        $m_perfil_entidad_id = $this->input->post('m_perfil_entidad_id');
        $m_modulo_id         = explode(',',$this->input->post('m_modulo_id'));
        $resp1               = $this->permiso->obtenerVistamodulos_n1($this->input->post('m_modulo_id'));
        $resp2               = $this->permiso->obtenerVistamodulos_n2($this->input->post('m_modulo_id'));

        $this->permiso->actualizarRegistros('tbm_permisos_base', 'm_perfil_entidad_id', $m_perfil_entidad_id);

        foreach ($resp1 as $k => $m) {
            $data = array();
            $data['m_perfil_entidad_id'] = $m_perfil_entidad_id;
            $data['m_modulo_id']         = $m['n_id_modulo'];
            $data['m_estado']            = 1;
            $this->permiso->guardar($data);
        }
        foreach ($resp2 as $k => $m) {
            $data = array();
            $data['m_perfil_entidad_id'] = $m_perfil_entidad_id;
            $data['m_modulo_id']         = $m['n_id_modulo'];
            $data['m_estado']            = 1;
            $this->permiso->guardar($data);
        }
        foreach ($m_modulo_id as $k => $m) {
            $data = array();
            $data['m_perfil_entidad_id'] = $m_perfil_entidad_id;
            $data['m_modulo_id']         = $m;
            $data['m_estado']            = 1;
            $resp = $this->permiso->guardar($data);
        }

        if ($resp){
            $this->permiso->actualizarRegistros('tbm_permisos', 'm_perfil_entidad_id', $m_perfil_entidad_id);
            $bases = $this->permiso->obtenerPermisoBasePorPerfil($m_perfil_entidad_id);
            foreach ($bases as $k => $m) {
                $data = array();
                $data['m_perfil_entidad_id'] = $m['m_perfil_entidad_id'];
                $data['m_modulo_id']         = $m['m_modulo_id'];
                $data['m_estado']            = 1;
                $this->permiso->guardarPermiso($data);
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

    public function obtener_modulo()
    {
        $cod = $this->input->post('mod');
        $resp1 = $this->permiso->obtenerVistamodulos_n1($cod);
        $resp2 = $this->permiso->obtenerVistamodulos_n2($cod);
        $resp3 = $this->permiso->obtenerVistamodulos_n3($cod);
        $html = '';
        foreach ($resp1 as $k1 => $v1) {
            $html .= "<div>"."<h5>".$v1['x_modulo_desc']."</h5>";
            foreach ($resp2 as $k2 => $v2) {
                if ($v2['m_modulo_id'] == $v1['n_id_modulo']) {
                    // $array1['div1'] = "<div'>".$v1['x_modulo_desc']."</div>";"<div id='".$v1['n_id_modulo']."'>".$v2['x_modulo_desc']."</div>";
                    $html .= "<div id='".$v1['n_id_modulo']."' style='margin:2px 5px;'>".'<h6>'.$v2['x_modulo_desc'].'</h6>';
                    foreach ($resp3 as $k3 => $v3) {
                        if ($v3['m_modulo_id'] == $v2['n_id_modulo']) {
                            // $array1['div1'] = "<div'>".$v1['x_modulo_desc']."</div>";"<div id='".$v1['n_id_modulo']."'>".$v2['x_modulo_desc']."</div>";
                            $html .= "<span style='margin: 2px 5px;'>".$v3['x_modulo_desc']."</span>";
                        }
                    }
                    $html .= "</div>";
                }
            }
            $html .="</div>";
        }
        $dataview['html'] = $html;
        echo json_encode($dataview);
    }

    public function obtener_modulo_perfil()
    {
        $cod   = $this->input->post('perf');
        $resp1 = $this->permiso->obtenerVistaModulosPerfil_n1($cod);
        $resp2 = $this->permiso->obtenerVistaModulosPerfil_n2($cod);
        $resp3 = $this->permiso->obtenerVistaModulosPerfil_n3($cod);
        $html  = '';
        foreach ($resp1 as $k1 => $v1) {
            $html .= "<div>"."<h5>".$v1['x_modulo_desc']."</h5>";
            foreach ($resp2 as $k2 => $v2) {
                if ($v2['m_modulo_id'] == $v1['n_id_modulo']) {
                    // $array1['div1'] = "<div'>".$v1['x_modulo_desc']."</div>";"<div id='".$v1['n_id_modulo']."'>".$v2['x_modulo_desc']."</div>";
                    $html .= "<div id='".$v1['n_id_modulo']."' style='margin:2px 5px;'>".'<h6>'.$v2['x_modulo_desc'].'</h6>';
                    foreach ($resp3 as $k3 => $v3) {
                        if ($v3['m_modulo_id'] == $v2['n_id_modulo']) {
                            // $array1['div1'] = "<div'>".$v1['x_modulo_desc']."</div>";"<div id='".$v1['n_id_modulo']."'>".$v2['x_modulo_desc']."</div>";
                            $html .= "<span style='margin: 2px 5px;'>".$v3['x_modulo_desc']."</span>";
                        }
                    }
                    $html .= "</div>";
                }
            }
            $html .="</div>";
        }
        $dataview['html'] = $html;
        echo json_encode($dataview);
    }

}
