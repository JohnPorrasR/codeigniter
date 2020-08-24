<?php

class Model_util extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function Importar($tabla, $campos, $valores)
    {
        $campos  = " (" . implode(",", $campos) . ") ";
        $valores = implode(",", $valores);
        $sql     = "INSERT INTO " . $tabla . $campos . " VALUES " . $valores . ";";

        $query = $this->db->query($sql);

        if ($query) {
            return $query;
        } else {
            return false;
        }
    }

    public function Existe($data, $table, $task = true)
    {
        $where      = "";
        $_arr_where = array();
        if (is_array($data)) {
            if (count($data)) {
                foreach ($data as $key => $item) {
                    array_push($_arr_where, $key . " = '" . $item . "'");
                }
                $where = " WHERE " . implode(" AND ", $_arr_where);
            }
        } else {
            die("Parametro 1 no soportado, se esperaba un array en el parmetro 1");
        }
        $sql = "SELECT * FROM " . $table . " " . $where;
        $query  = $this->db->query($sql);
        
        $result = $query->result();
        if (!empty($result)) {
            if ($task) {
                return $query->row_array();
            } else {
                return $query->result_array();
            }

        } else {
            return false;
        }
    }

    public function MaxRow($table, $field)
    {
        $sql   = "SELECT MAX(" . $field . ") as ultimo FROM " . $table;
        $query = $this->db->query($sql);
        if ($query->result()) {
            return $query->row()->ultimo;
        } else {
            return false;
        }
    }

    public function save($table, $data)
    {
        $this->db->insert($table, $data);
        $id = $this->db->insert_id();
        if ($id) {
            return $id;
        } else {
            return false;
        }
    }

    public function update($table, $data, $where)
    {

        $id = $this->db->update($table, $data, $where);
        if ($id) {
            return true;
        } else {
            return false;
        }
    }

}
