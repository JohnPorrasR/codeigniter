<?php

class Model_home extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Model_util');
    }

    public function eliminarDato($data, $tabla, $x_id)
    {
        $where          = array();
        $where["$x_id"] = $data["$x_id"];
        if ($this->Model_util->Existe($where, "$tabla") != false) {
            $update = $this->Model_util->update("$tabla", $data, $where);
            if ($update == true) {
                $id = $this->Model_util->Existe($where, "$tabla")["$x_id"];
            }
        } else {
            $id = $this->Model_util->save("$tabla", $data);
        }
        return $id;
    }

    public function cambiarCLave($data)
    {
        $where = array();
        $where["n_id_usuario"] = $data["n_id_usuario"];
        if ($this->Model_util->Existe($where, "firma_electronica.tbm_usuarios") != false) {
            $update = $this->Model_util->update("firma_electronica.tbm_usuarios", $data, $where);
            if ($update == true) {
                $id = $this->Model_util->Existe($where, "firma_electronica.tbm_usuarios")["n_id_usuario"];
            }
        } else {
            $id = $this->Model_util->save("firma_electronica.tbm_usuarios", $data);
        }
        return $id;
    }

    public function obtenerCajas($tabla, $multiple = '')
    {
        $sql = "show columns from $tabla";
        $query = $this->db->query($sql);
        $result = $query->result_array();
        if($result){
            $array = array();
            $json = array();        
            foreach ($result as $k => $d) {
                $array['column_name']   = $d['Field'];
                $array['txtTipo']       = strstr($d['Type'], '(', true);
                $array['required']      = str_replace("NO", "required", str_replace('YES', '', $d['Null']));
                $array['data_type']     = '';
                $array['attr']          = '';
                if ($d['Field'] == $multiple) {
                    $array['attr']      .= 'multiple="multiple"';
                }
                $array['type']          = $d['Type'];
                $array['combo']         = str_replace(0,1,strpos(substr($d['Field'], 0, 1), 'm'));
                $json[$k]               = $array;
            }
            return $json;
        }else{
            return [];
        }
    }

    public function generarCajas($data)
    {
        if($data){
            $array = array();
            $json = array();        
            foreach ($data as $k => $d) {
                $array['column_name']   = $data[$k][0];
                $array['txtTipo']       = $data[$k][1];
                $array['required']      = $data[$k][2];
                $array['data_type']     = $data[$k][3];
                $array['attr']          = $data[$k][4];
                $array['type']          = $data[$k][5];
                $array['combo']         = $data[$k][6];
                $json[$k]               = $array;
            }
            return $json;
        }else{
            return [];
        }
    }

    public function obtenerDatos($tabla)
    {

        $sql = "show columns from $tabla";
        $query = $this->db->query($sql);
        $result = $query->result_array();
        $columnas = '';
        foreach ($result as $k => $d) {
            if($d['Field'] == 'm_estado'){
                $columnas .= "IF(m_estado=0,'Bloqueado','habilitado') as dato".$k.',';
            }else{
                $columnas .= $d['Field'].' as dato'.$k.',';
            }
        }
        $columna = substr($columnas, 0, -1);
        $sql = "select $columna from $tabla";
        $query = $this->db->query($sql);
        $result = $query->result_array();
        if($result){
            return $result;
        }else{
            return [];
        }
    }

    public function obtenerDatosReporte($tabla)
    {
        $sql = "select * from tbm_reportes_autogenerados where x_tabla = '".$tabla."' and m_estado = 1";
        $query = $this->db->query($sql);
        $result = $query->result_array();
        if($result){
            return $result;
        }else{
            return [];
        }
    }

}
