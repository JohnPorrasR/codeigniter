<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Home extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        ini_set("max_execution_time", 0);
        $this->load->library('session');
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
            if ($data['m_estado'] == 0)
            {
                $msg["resp"] = 10;
                $msg["text"] = "Su usuario se encuentra bloqueado.";
                echo json_encode($msg);die;
            }
            $server = $this->user->obtener_server();

            if(count($server) > 0)
            {
                $url = $server['x_url'];
            }else{
                $url = base_url();
            }
            $this->session->set_userdata(
                array(
                    "usu" => $data['x_usuario'], "id" => $data['n_id_usuario'], "nomb" => $data['x_mostrar_nomb'], "base_url" => $url
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

}
