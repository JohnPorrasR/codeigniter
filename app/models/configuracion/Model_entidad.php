<?php

class Model_entidad extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Model_util');
    }

    public function mostrar_datos()
    {
        $sql = "select n_id_entidad, x_entidad_nomb, x_entidad_abr, x_direccion, 
                IFNULL((select x_entidad_nomb from tbm_entidades as e2 where e2.n_id_entidad = e.m_entidad_id), '') as m_entidad_id
                , m_estado from tbm_entidades as e";
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
        $sql = "select * from tbm_entidades where n_id_entidad = $cod";
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
        $where["n_id_entidad"] = $data["n_id_entidad"];
        if ($this->Model_util->Existe($where, "tbm_entidades") != false) {
            $update = $this->Model_util->update("tbm_entidades", $data, $where);
            if ($update == true) {
                $resp = $this->Model_util->Existe($where, "tbm_entidades");
            }
        } else {
            $resp = $this->Model_util->save("tbm_entidades", $data);
        }
        return $resp;
    }

}