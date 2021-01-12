<?php

class Model_cargo extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Model_util');
    }

    public function mostrar_datos()
    {
        $sql = "select ce.n_id_cargo_entidad, c.x_cargo_desc, IFNULL(e.x_entidad_nomb, '') as x_entidad_nomb, 
                IFNULL((select c1.x_cargo_desc from tbm_cargos as c1 where c1.n_id_cargo = ce.m_nodo), '') as m_nodo, ce.m_estado
                from tbm_cargos as c 
                inner join tbm_cargos_entidades as ce on c.n_id_cargo = ce.m_cargo_id
                inner join tbm_entidades as e on ce.m_entidad_id = e.n_id_entidad";
        $query = $this->db->query($sql);
        $result = $query->result_array();
        if($result){
            return $result;
        }else{
            return [];
        }
    }

    public function mostrar_cargos()
    {
        $sql = "select * from tbm_cargos";
        $query = $this->db->query($sql);
        $result = $query->result_array();
        if($result){
            return $result;
        }else{
            return [];
        }
    }

    public function obtenerCargoPorCod($cod)
    {
        $sql = "select * from tbm_cargos where n_id_cargo = $cod";
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
        $sql = "select * from tbm_cargos_entidades where n_id_cargo_entidad = $cod";
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
        $where["n_id_cargo"] = $data["n_id_cargo"];
        if ($this->Model_util->Existe($where, "tbm_cargos") != false) {
            $update = $this->Model_util->update("tbm_cargos", $data, $where);
            if ($update == true) {
                $resp = $this->Model_util->Existe($where, "tbm_cargos");
            }
        } else {
            $resp = $this->Model_util->save("tbm_cargos", $data);
        }
        return $resp;
    }

    public function guardarCargoEntidad($data)
    {
        $where                = array();
        $where["m_cargo_id"] = $data["m_cargo_id"];
        $where["m_entidad_id"] = $data["m_entidad_id"];
        if ($this->Model_util->Existe($where, "tbm_cargos_entidades") != false) {
            $update = $this->Model_util->update("tbm_cargos_entidades", $data, $where);
            if ($update == true) {
                $resp = $this->Model_util->Existe($where, "tbm_cargos_entidades");
            }
        } else {
            $resp = $this->Model_util->save("tbm_cargos_entidades", $data);
        }
        return $resp;
    }

}