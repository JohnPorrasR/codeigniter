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
        $result = $query->row_array();
        if(count($result) > 0){
            return $result;
        }else{
            return [];
        }
    }

    function obtener_server()
    {
        $sql = "select * from tbm_server where m_estado = 1";
        $query = $this->db->query($sql);
        $result = $query->row_array();
        if(count($result) > 0){
            return $result;
        }else{
            return [];
        }
    }

}
