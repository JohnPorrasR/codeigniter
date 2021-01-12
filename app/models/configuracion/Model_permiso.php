<?php

class Model_permiso extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Model_util');
    }

    public function mostrar_datos()
    {
        $sql = "select distinct pb.m_perfil_entidad_id, pf.x_desc_perfil
                from tbm_permisos_base as pb
                inner join tbm_perfiles_entidades as pe on pb.m_perfil_entidad_id = pe.n_id_perfil_entidad
                inner join tbm_perfiles as pf on pe.m_perfil_id = pf.n_id_perfil";
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

    public function mostrar_modulos()
    {
        $sql = "select p.m_perfil_entidad_id, m.n_id_modulo, m.x_modulo_desc
                from tbm_permisos_base as p
                inner join tbm_modulos as m on p.m_modulo_id = m.n_id_modulo
                where p.m_estado = 1 and m.m_nivel = 3";
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
        $sql = "select distinct pb.m_perfil_entidad_id, pf.x_desc_perfil
                from tbm_permisos_base as pb
                inner join tbm_perfiles_entidades as pe on pb.m_perfil_entidad_id = pe.n_id_perfil_entidad
                inner join tbm_perfiles as pf on pe.m_perfil_id = pf.n_id_perfil
                where pb.m_perfil_entidad_id = $cod";
        $query = $this->db->query($sql);
        $result = $query->result_array();
        if($result){
            return $result;
        }else{
            return [];
        }
    }

    public function obtenerPermisoBasePorPerfil($cod)
    {
        $sql = "SELECT * FROM tbm_permisos_base WHERE m_estado = 1 and m_perfil_entidad_id = $cod";
        $query = $this->db->query($sql);
        $result = $query->result_array();
        if($result){
            return $result;
        }else{
            return [];
        }
    }

    public function actualizarRegistros($tabla, $columna, $cod)
    {
        $sql = "update $tabla set m_estado = 0 where $columna = $cod";
        $query = $this->db->query($sql);
        return 1;
    }
    
    public function guardar($data)
    {
        $where                = array();
        $where["m_perfil_entidad_id"] = $data["m_perfil_entidad_id"];
        $where["m_modulo_id"] = $data["m_modulo_id"];
        if ($this->Model_util->Existe($where, "tbm_permisos_base") != false) {
            $update = $this->Model_util->update("tbm_permisos_base", $data, $where);
            if ($update == true) {
                $resp = $this->Model_util->Existe($where, "tbm_permisos_base");
            }
        } else {
            $resp = $this->Model_util->save("tbm_permisos_base", $data);
        }
        return $resp;
    }
    
    public function guardarPermiso($data)
    {
        $where                = array();
        $where["m_perfil_entidad_id"] = $data["m_perfil_entidad_id"];
        $where["m_modulo_id"] = $data["m_modulo_id"];
        if ($this->Model_util->Existe($where, "tbm_permisos") != false) {
            $update = $this->Model_util->update("tbm_permisos", $data, $where);
            if ($update == true) {
                $resp = $this->Model_util->Existe($where, "tbm_permisos");
            }
        } else {
            $resp = $this->Model_util->save("tbm_permisos", $data);
        }
        return $resp;
    }

    public function obtenerVistamodulos_n1($cods)
    {
        $sql = "select distinct m1.n_id_modulo, m1.x_modulo_desc, m1.m_modulo_id
                from tbm_modulos as m1
                inner join tbm_modulos as m2 on m1.n_id_modulo = m2.m_modulo_id
                inner join tbm_modulos as m3 on m2.n_id_modulo = m3.m_modulo_id
                where m3.n_id_modulo in ($cods)";
        $query = $this->db->query($sql);
        $result = $query->result_array();
        if($result){
            return $result;
        }else{
            return [];
        }
    }

    public function obtenerVistamodulos_n2($cods)
    {
        $sql = "select distinct m2.n_id_modulo, m2.x_modulo_desc, m2.m_modulo_id
                from tbm_modulos as m1
                inner join tbm_modulos as m2 on m1.n_id_modulo = m2.m_modulo_id
                inner join tbm_modulos as m3 on m2.n_id_modulo = m3.m_modulo_id
                where m3.n_id_modulo in ($cods)";
        $query = $this->db->query($sql);
        $result = $query->result_array();
        if($result){
            return $result;
        }else{
            return [];
        }
    }

    public function obtenerVistamodulos_n3($cods)
    {
        $sql = "select distinct m3.n_id_modulo, m3.x_modulo_desc, m3.m_modulo_id
                from tbm_modulos as m1
                inner join tbm_modulos as m2 on m1.n_id_modulo = m2.m_modulo_id
                inner join tbm_modulos as m3 on m2.n_id_modulo = m3.m_modulo_id
                where m3.n_id_modulo in ($cods)";
        $query = $this->db->query($sql);
        $result = $query->result_array();
        if($result){
            return $result;
        }else{
            return [];
        }
    }

    public function obtenerVistaModulosPerfil_n1($cod)
    {
        $sql = "select distinct m1.n_id_modulo, m1.x_modulo_desc, m1.m_modulo_id
                from tbm_modulos as m1
                inner join tbm_modulos as m2 on m1.n_id_modulo = m2.m_modulo_id
                inner join tbm_modulos as m3 on m2.n_id_modulo = m3.m_modulo_id
                inner join tbm_permisos_base as pb on m3.n_id_modulo = pb.m_modulo_id
                where pb.m_estado = 1 and pb.m_perfil_entidad_id = $cod";
        $query = $this->db->query($sql);
        $result = $query->result_array();
        if($result){
            return $result;
        }else{
            return [];
        }
    }

    public function obtenerVistaModulosPerfil_n2($cod)
    {
        $sql = "select distinct m2.n_id_modulo, m2.x_modulo_desc, m2.m_modulo_id
                from tbm_modulos as m1
                inner join tbm_modulos as m2 on m1.n_id_modulo = m2.m_modulo_id
                inner join tbm_modulos as m3 on m2.n_id_modulo = m3.m_modulo_id
                inner join tbm_permisos_base as pb on m3.n_id_modulo = pb.m_modulo_id
                where pb.m_estado = 1 and pb.m_perfil_entidad_id = $cod";
        $query = $this->db->query($sql);
        $result = $query->result_array();
        if($result){
            return $result;
        }else{
            return [];
        }
    }

    public function obtenerVistaModulosPerfil_n3($cod)
    {
        $sql = "select distinct m3.n_id_modulo, m3.x_modulo_desc, m3.m_modulo_id
                from tbm_modulos as m1
                inner join tbm_modulos as m2 on m1.n_id_modulo = m2.m_modulo_id
                inner join tbm_modulos as m3 on m2.n_id_modulo = m3.m_modulo_id
                inner join tbm_permisos_base as pb on m3.n_id_modulo = pb.m_modulo_id
                where pb.m_estado = 1 and pb.m_perfil_entidad_id = $cod";
        $query = $this->db->query($sql);
        $result = $query->result_array();
        if($result){
            return $result;
        }else{
            return [];
        }
    }

}