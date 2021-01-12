<?php

class Model_persona extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Model_util');
    }

    public function mostrar_datos()
    {
        $sql = "select p.n_id_persona, p.x_ape_pat, p.x_ape_mat, p.x_nombres, p.x_tipo_doc, p.x_num_doc, p.x_correo_personal, p.x_correo_institucional, p.m_celular, 
                p.f_cumple, u.x_usuario, c.x_cargo_desc, pf.x_desc_perfil, p.m_estado
                from tbm_personas as p 
                inner join tbm_personas_detalles as pd on p.n_id_persona = pd.m_persona_id
                inner join tbm_cargos_entidades as ce on pd.m_cargo_entidad_id = ce.n_id_cargo_entidad
                inner join tbm_cargos as c on ce.m_cargo_id = c.n_id_cargo
                inner join tbm_perfiles_entidades as pe on pd.m_perfil_entidad_id = pe.n_id_perfil_entidad
                inner join tbm_perfiles as pf on pe.m_perfil_id = pf.n_id_perfil
                inner join tbm_usuarios as u on p.m_usuario_id = u.n_id_usuario";
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
        $sql = "select p.n_id_persona, p.x_ape_pat, p.x_ape_mat, p.x_nombres, p.x_tipo_doc, p.x_num_doc, p.x_correo_personal, p.x_correo_institucional, p.m_celular, 
                p.f_cumple, u.x_usuario, pd.m_cargo_entidad_id, pd.m_perfil_entidad_id, p.m_usuario_id, p.m_estado
                from tbm_personas as p 
                inner join tbm_personas_detalles as pd on p.n_id_persona = pd.m_persona_id
                inner join tbm_cargos_entidades as ce on pd.m_cargo_entidad_id = ce.n_id_cargo_entidad
                inner join tbm_cargos as c on ce.m_cargo_id = c.n_id_cargo
                inner join tbm_perfiles_entidades as pe on pd.m_perfil_entidad_id = pe.n_id_perfil_entidad
                inner join tbm_perfiles as pf on pe.m_perfil_id = pf.n_id_perfil
                inner join tbm_usuarios as u on p.m_usuario_id = u.n_id_usuario
                where p.n_id_persona = $cod";
        $query = $this->db->query($sql);
        $result = $query->result_array();
        if($result){
            return $result;
        }else{
            return [];
        }
    }

    public function obtenerEntidades()
    {
        $sql = "select * from tbm_entidades where m_estado = 1";
        $query = $this->db->query($sql);
        $result = $query->result_array();
        if($result){
            return $result;
        }else{
            return [];
        }  
    }

    public function obtenerPerfiles($cod)
    {
        $and = '';
        if($cod > 0){
            $and .=  "  and e.n_id_entidad = $cod";
        }
        $sql = "select pe.n_id_perfil_entidad, p.x_desc_perfil, pe.m_estado
                from tbm_perfiles as p
                inner join tbm_perfiles_entidades as pe on p.n_id_perfil = pe.m_perfil_id
                inner join tbm_entidades as e on pe.m_entidad_id = e.n_id_entidad
                where pe.m_estado = 1 $and";
        $query = $this->db->query($sql);
        $result = $query->result_array();
        if($result){
            return $result;
        }else{
            return [];
        }  
    }

    public function obtenerCargos($cod)
    {
        $and = '';
        if($cod > 0){
            $and .= " and e.n_id_entidad = $cod";
        }
        $sql = "select ce.n_id_cargo_entidad, c.x_cargo_desc, ce.m_estado
                from tbm_cargos as c
                inner join tbm_cargos_entidades as ce on c.n_id_cargo = ce.m_cargo_id
                inner join tbm_entidades as e on ce.m_entidad_id = e.n_id_entidad
                where ce.m_estado = 1 $and";
        $query = $this->db->query($sql);
        $result = $query->result_array();
        if($result){
            return $result;
        }else{
            return [];
        }
    }

    public function guardarUsuario($data)
    {
        $where                = array();
        $where["n_id_usuario"] = $data["n_id_usuario"];
        if ($this->Model_util->Existe($where, "tbm_usuarios") != false) {
            $update = $this->Model_util->update("tbm_usuarios", $data, $where);
            if ($update == true) {
                $resp = $this->Model_util->Existe($where, "tbm_usuarios");
            }
        } else {
            $resp = $this->Model_util->save("tbm_usuarios", $data);
        }
        return $resp;
    }

    public function guardar($data)
    {
        $where                = array();
        $where["n_id_persona"] = $data["n_id_persona"];
        if ($this->Model_util->Existe($where, "tbm_personas") != false) {
            $update = $this->Model_util->update("tbm_personas", $data, $where);
            if ($update == true) {
                $resp = $this->Model_util->Existe($where, "tbm_personas");
            }
        } else {
            $resp = $this->Model_util->save("tbm_personas", $data);
        }
        return $resp;
    }

    public function guardarDetalle($data)
    {
        $where                = array();
        $where["m_persona_id"] = $data["m_persona_id"];
        if ($this->Model_util->Existe($where, "tbm_personas_detalles") != false) {
            $update = $this->Model_util->update("tbm_personas_detalles", $data, $where);
            if ($update == true) {
                $resp = $this->Model_util->Existe($where, "tbm_personas_detalles");
            }
        } else {
            $resp = $this->Model_util->save("tbm_personas_detalles", $data);
        }
        return $resp;
    }

}