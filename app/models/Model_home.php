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

}
