<?php

class Model_perfil extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Model_util');
    }

    public function guardarDatos($data)
    {
        $where                = array();
        $where["n_id_log"]    = $data["n_id_log"];
        if ($this->Model_util->Existe($where, "firma_electronica.tfe_log") != false) {
            $update = $this->Model_util->update("firma_electronica.tfe_log", $data, $where);
            if ($update == true) {
                $id = $this->Model_util->Existe($where, "firma_electronica.tfe_log")['n_id_log'];
            }
        } else {
            $id = $this->Model_util->save("firma_electronica.tfe_log", $data);
        }
        return $id;
    }

}
