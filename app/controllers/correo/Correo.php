<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Correo extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->model('Model_notificar', 'notificar');
        $this->load->model('Model_helpers', 'help');
    }

    public function index()
    {

    }

    public function enviar()
    {
        $usuario    = $this->session->userdata('iduser');
        $msg        = array();
        if($usuario > 0)
        {
            $proceso    = $this->uri->segment(4);
            $data       = $this->notificar->obtenerDataParaCorreo($proceso);
            if(count($data) > 0)
            {
                foreach ($data as $k => $p)
                {
                    if(strlen($p["x_correo_institucional"]) > 1)
                    {
                        $email  = $p["x_correo_institucional"];
                    }
                    else
                    {
                        $email  = $p["x_correo_personal"];
                    }
                    $usuario    = $p["x_nombres"].' '.$p["x_ape_pat"].' '.$p["x_ape_mat"];
                    $plantilla  = str_replace('|NOMBRE|', $usuario, $p["x_descripcion"]);
                    $this->load->library('swiftmailer');
                    $message_ = $p["x_asunto"];
                    $transport = \Swift_SmtpTransport::newInstance()
                        ->setUsername('jporras@drelm.gob.pe')->setPassword('S1st3m452020.....')
                        ->setHost('smtp.office365.com')
                        ->setPort(587)->setEncryption('tls');
                    // Create the Mailer using your created Transport
                    $mailer = Swift_Mailer::newInstance($transport);
                    // Create a message
                    $message = Swift_Message::newInstance('DRELM')
                        ->setFrom(array('jporras@drelm.gob.pe' => '[DRELM]'))
                        ->setTo(array($email => ''));
                    $message->setBody($plantilla, 'text/html');
                    $mailer->send($message);
                }
                $msg["text"] = "Notificación enviada correctamente.";
                $msg["resp"] = 100;
            }
            else
            {
                $msg["text"] = "No hay correos para enviar.";
                $msg["resp"] = 10;
            }
        }
        else
        {
            $msg["text"] = "Error al enviar el correo.";
            $msg["resp"] = 10;
        }
        echo json_encode($msg);
    }

    public function reenviar()
    {
        $usuario    = $this->session->userdata('iduser');
        $msg        = array();
        if($usuario > 0)
        {
            $proceso    = $this->uri->segment(4);
            $dni        = $this->uri->segment(5);
            $data       = $this->notificar->obtenerDataParaCorreoPorPersona($proceso, $dni);
            if(count($data) > 0)
            {
                foreach ($data as $k => $p)
                {
                    if(strlen($p["x_correo_institucional"]) > 1)
                    {
                        $email  = $p["x_correo_institucional"];
                    }
                    else
                    {
                        $email  = $p["x_correo_personal"];
                    }
                    $usuario    = $p["x_nombres"].' '.$p["x_ape_pat"].' '.$p["x_ape_mat"];
                    $plantilla  = str_replace('|NOMBRE|', $usuario, $p["x_descripcion"]);
                    $this->load->library('swiftmailer');
                    $message_ = $p["x_asunto"];
                    $transport = \Swift_SmtpTransport::newInstance()
                        ->setUsername('jporras@drelm.gob.pe')->setPassword('S1st3m452020.....')
                        ->setHost('smtp.office365.com')
                        ->setPort(587)->setEncryption('tls');
                    // Create the Mailer using your created Transport
                    $mailer = Swift_Mailer::newInstance($transport);
                    // Create a message
                    $message = Swift_Message::newInstance('DRELM')
                        ->setFrom(array('jporras@drelm.gob.pe' => '[DRELM]'))
                        ->setTo(array($email => ''));
                    $message->setBody($plantilla, 'text/html');
                    $mailer->send($message);
                }
                $msg["text"] = "Notificación enviada correctamente.";
                $msg["resp"] = 100;
            }
            else
            {
                $msg["text"] = "No hay correos para enviar.";
                $msg["resp"] = 10;
            }
        }
        else
        {
            $msg["text"] = "Error al enviar el correo.";
            $msg["resp"] = 10;
        }
        echo json_encode($msg);
    }

    public function demo()
    {
        $proceso    = $this->uri->segment(4);
        $data       = $this->notificar->obtenerDataParaCorreo($proceso);
        if(count($data) > 0)
        {
            foreach ($data as $k => $p)
            {
                if(strlen($p["x_correo_institucional"]) > 1)
                {
                    $email  = $p["x_correo_institucional"];
                }
                else
                {
                    $email  = $p["x_correo_personal"];
                }
                $usuario    = $p["x_nombres"].' '.$p["x_ape_pat"].' '.$p["x_ape_mat"]; 
                $plantilla  = str_replace('|NOMBRE|', $usuario, $p["x_descripcion"]);
                $this->load->library('swiftmailer');
                $message_ = $p["x_asunto"];
                $transport = \Swift_SmtpTransport::newInstance()
                    ->setUsername('jporras@drelm.gob.pe')->setPassword('S1st3m452020.....')
                    ->setHost('smtp.office365.com')
                    ->setPort(587)->setEncryption('tls');
                // Create the Mailer using your created Transport
                $mailer = Swift_Mailer::newInstance($transport);
                // Create a message
                $message = Swift_Message::newInstance('DRELM')
                    ->setFrom(array('jporras@drelm.gob.pe' => '[DRELM]'))
                    ->setTo(array($email => ''));
                $message->setBody($plantilla, 'text/html');
                $mailer->send($message);
            }
            $msg["text"] = "Notificación enviada correctamente.";
            $msg["resp"] = 100;
        }
        else
        {
            $msg["text"] = "No hay correos para enviar.";
            $msg["resp"] = 10;
        }
        echo json_encode($msg);
    }

}
