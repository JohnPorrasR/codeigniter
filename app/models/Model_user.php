<?php
class Model_user extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    function obtener_usuario($data = array())
    {
        $sql = "SELECT u.* FROM tbm_usuarios u WHERE u.x_usuario='".$data['txtuser']."' AND u.x_clave='".md5($data['txtpws'])."' AND u.m_estado = 1";
        $query = $this->db->query($sql);
        $result = $query->result_array();
        if($result){
            return $result;
        }else{
            return [];
        }
    }

    function obtener_sistema()
    {
        $sql = "select * from tbm_sistemas where m_estado = 1";
        $query = $this->db->query($sql);
        $result = $query->result_array();
        if($result){
            return $result;
        }else{
            return [];
        }
    }

    function obtener_datos_usuario_persona($usu)
    {
        $sql = "select p.n_id_persona, p.x_ape_pat, p.x_ape_mat, p.x_nombres, pd.m_cargo_entidad_id, pd.m_perfil_entidad_id
                from tbm_usuarios as u
                inner join tbm_personas as p on u.n_id_usuario = p.m_usuario_id
                inner join tbm_personas_detalles as pd on p.n_id_persona = pd.m_persona_id
                where u.m_estado = 1 and u.n_id_usuario = $usu";
        $query = $this->db->query($sql);
        $result = $query->result_array();
        if($result){
            return $result;
        }else{
            return [];
        }
    }

    function obtener_menu_n1($id, $perfil)
    {
        $sql = "select m.* 
                from tbm_permisos as p
                inner join tbm_perfiles_entidades as pe on p.m_perfil_entidad_id = pe.n_id_perfil_entidad
                inner join tbm_modulos as m on p.m_modulo_id = m.n_id_modulo
                where p.m_estado = 1 and m.m_estado = 1 and p.m_usuario_id = 0 and m.m_nivel = 1 and p.m_perfil_entidad_id = $perfil
                union all 
                select m.* 
                from tbm_permisos as p
                inner join tbm_perfiles_entidades as pe on p.m_perfil_entidad_id = pe.n_id_perfil_entidad
                inner join tbm_modulos as m on p.m_modulo_id = m.n_id_modulo
                where p.m_estado = 1 and m.m_estado = 1 and m.m_nivel = 1 and p.m_usuario_id = $id";
        $query = $this->db->query($sql);
        $result = $query->result_array();
        if($result){
            return $result;
        }else{
            return [];
        }
    }

    function obtener_menu_n2($id, $perfil)
    {
        $sql = "select m.* 
                from tbm_permisos as p
                inner join tbm_perfiles_entidades as pe on p.m_perfil_entidad_id = pe.n_id_perfil_entidad
                inner join tbm_modulos as m on p.m_modulo_id = m.n_id_modulo
                where p.m_estado = 1 and p.m_usuario_id = 0 and m.m_nivel = 2 and p.m_perfil_entidad_id = $perfil
                union all 
                select m.* 
                from tbm_permisos as p
                inner join tbm_perfiles_entidades as pe on p.m_perfil_entidad_id = pe.n_id_perfil_entidad
                inner join tbm_modulos as m on p.m_modulo_id = m.n_id_modulo
                where p.m_estado = 1 and m.m_nivel = 2 and p.m_usuario_id = $id";
        $query = $this->db->query($sql);
        $result = $query->result_array();
        if($result){
            return $result;
        }else{
            return [];
        }
    }

    function obtener_menu_n3($id, $perfil)
    {
        $sql = "select m.* 
                from tbm_permisos as p
                inner join tbm_perfiles_entidades as pe on p.m_perfil_entidad_id = pe.n_id_perfil_entidad
                inner join tbm_modulos as m on p.m_modulo_id = m.n_id_modulo
                where p.m_estado = 1 and p.m_usuario_id = 0 and m.m_nivel = 3 and p.m_perfil_entidad_id = $perfil
                union all 
                select m.* 
                from tbm_permisos as p
                inner join tbm_perfiles_entidades as pe on p.m_perfil_entidad_id = pe.n_id_perfil_entidad
                inner join tbm_modulos as m on p.m_modulo_id = m.n_id_modulo
                where p.m_estado = 1 and m.m_nivel = 3 and p.m_usuario_id = $id";
        $query = $this->db->query($sql);
        $result = $query->result_array();
        if($result){
            return $result;
        }else{
            return [];
        }
    }

    function obtener_acciones($perfil, $modulo)
    {
        $sql = "select a.* 
                from tbm_perfiles as p
                inner join tbm_perfiles_acciones as pa on p.n_id_perfil = pa.m_perfil_id
                inner join tbm_acciones as a on pa.m_accion_id = a.n_id_accion
                inner join tbm_perfiles_entidades as pe on p.n_id_perfil = pe.m_perfil_id
                where pa.m_estado = 1 and pe.n_id_perfil_entidad = $perfil and pa.m_modulo_id = $modulo";
        $query = $this->db->query($sql);
        $result = $query->result_array();
        if($result){
            return $result;
        }else{
            return [];
        }
    }

}
