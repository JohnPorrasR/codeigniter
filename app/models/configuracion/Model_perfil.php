<?php

class Model_perfil extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Model_util');
    }

    public function mostrar_datos()
    {
        $sql = "select * from tbm_perfiles";
        $query = $this->db->query($sql);
        $result = $query->result_array();
        if($result){
            return $result;
        }else{
            return [];
        }
    }

    public function mostrar_tablas($tabla, $and)
    {
        $sql = "select * from $tabla where m_estado = 1 $and";
        $query = $this->db->query($sql);
        $result = $query->result_array();
        if($result){
            return $result;
        }else{
            return [];
        }
    }

    public function mostrar_perfiles_entidades()
    {
        $sql = "select pe.n_id_perfil_entidad, p.x_desc_perfil, e.x_entidad_nomb, pe.m_estado
                from tbm_perfiles as p
                inner join tbm_perfiles_entidades as pe on p.n_id_perfil = pe.m_perfil_id
                inner join tbm_entidades as e on pe.m_entidad_id = e.n_id_entidad";
        $query = $this->db->query($sql);
        $result = $query->result_array();
        if($result){
            return $result;
        }else{
            return [];
        }
    }

    public function mostrar_perfiles_acciones()
    {
        $sql = "select pa.n_id_perfil_accion, p.x_desc_perfil, m.x_modulo_desc, a.x_descripcion, pa.m_estado
                from tbm_perfiles as p
                inner join tbm_perfiles_acciones as pa on p.n_id_perfil = pa.m_perfil_id
                inner join tbm_acciones as a on pa.m_accion_id = a.n_id_accion
                inner join tbm_modulos as m on pa.m_modulo_id = m.n_id_modulo
                order by p.x_desc_perfil, m.x_modulo_desc";
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
        $sql = "select * from tbm_perfiles where n_id_perfil = $cod";
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
        $where["n_id_perfil"] = $data["n_id_perfil"];
        if ($this->Model_util->Existe($where, "tbm_perfiles") != false) {
            $update = $this->Model_util->update("tbm_perfiles", $data, $where);
            if ($update == true) {
                $resp = $this->Model_util->Existe($where, "tbm_perfiles");
            }
        } else {
            $resp = $this->Model_util->save("tbm_perfiles", $data);
        }
        return $resp;
    }

    public function guardarPerfilEntidad($data)
    {
        $where                = array();
        $where["m_perfil_id"] = $data["m_perfil_id"];
        $where["m_entidad_id"] = $data["m_entidad_id"];
        if ($this->Model_util->Existe($where, "tbm_perfiles_entidades") != false) {
            $update = $this->Model_util->update("tbm_perfiles_entidades", $data, $where);
            if ($update == true) {
                $resp = $this->Model_util->Existe($where, "tbm_perfiles_entidades");
            }
        } else {
            $resp = $this->Model_util->save("tbm_perfiles_entidades", $data);
        }
        return $resp;
    }

    public function guardarPerfilAccion($data)
    {
        $where                = array();
        $where["m_perfil_id"] = $data["m_perfil_id"];
        $where["m_accion_id"] = $data["m_accion_id"];
        $where["m_modulo_id"] = $data["m_modulo_id"];
        if ($this->Model_util->Existe($where, "tbm_perfiles_acciones") != false) {
            $update = $this->Model_util->update("tbm_perfiles_acciones", $data, $where);
            if ($update == true) {
                $resp = $this->Model_util->Existe($where, "tbm_perfiles_acciones");
            }
        } else {
            $resp = $this->Model_util->save("tbm_perfiles_acciones", $data);
        }
        return $resp;
    }    

    public function actualizar($perfil, $modulo)
    {
        $sql = "update tbm_perfiles_acciones set m_estado = 0 where m_perfil_id = $perfil and m_modulo_id = $modulo";
        $query = $this->db->query($sql);
        return 1;
    }

    public function obtenerPerfilEntidad($cod)
    {
        $sql = "select * from tbm_perfiles_entidades where n_id_perfil_entidad = $cod";
        $query = $this->db->query($sql);
        $result = $query->result_array();
        if($result){
            return $result;
        }else{
            return [];
        }
    }

    public function obtenerPerfilAccion($cod)
    {
        $sql = "select * from tbm_perfiles_acciones where n_id_perfil_accion = $cod";
        $query = $this->db->query($sql);
        $result = $query->result_array();
        if($result){
            return $result;
        }else{
            return [];
        }
    }

    public function obtenerPerfilAccionPorCodModulo($mod, $perf)
    {
        $sql = "select a.*
                from tbm_perfiles_acciones as pa 
                inner join tbm_acciones as a on pa.m_accion_id = a.n_id_accion
                where pa.m_estado = 1 and pa.m_modulo_id = $mod and pa.m_perfil_id = $perf";
        $query = $this->db->query($sql);
        $result = $query->result_array();
        if($result){
            return $result;
        }else{
            return [];
        }
    }

}