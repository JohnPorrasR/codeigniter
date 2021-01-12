<?php

class Model_accion extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Model_util');
    }

    public function mostrar_datos()
    {
        $sql = "select * from tbm_acciones as a";
        $query = $this->db->query($sql);
        $result = $query->result_array();
        if($result){
            return $result;
        }else{
            return [];
        }
    }

    public function obtenerDatoPorCod($cod)
    {
        $sql = "select * from tbm_acciones where n_id_accion = $cod";
        $query = $this->db->query($sql);
        $result = $query->result_array();
        if($result){
            return $result;
        }else{
            return [];
        }
    }

    public function guardar($data)
    {
        $where                = array();
        $where["n_id_accion"] = $data["n_id_accion"];
        if ($this->Model_util->Existe($where, "tbm_acciones") != false) {
            $update = $this->Model_util->update("tbm_acciones", $data, $where);
            if ($update == true) {
                $resp = $this->Model_util->Existe($where, "tbm_acciones");
            }
        } else {
            $resp = $this->Model_util->save("tbm_acciones", $data);
        }
        return $resp;
    }

}