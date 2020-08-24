<?php
class Model_user extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    function Get_user($data = array())
    {
        $sql = "SELECT u.* FROM tbm_usuarios u WHERE u.x_usuario='".$data['txtuser']."' AND u.x_clave='".md5($data['txtpws'])."' AND u.m_estado = 1";
        $query = $this->db->query($sql);
        $result = $query->row_array();
        return $result;
    }

}
