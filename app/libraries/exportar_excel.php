<?php
defined('BASEPATH') or exit('No direct script access allowed');

class exportar_excel
{
	
    function to_excel($data, $cabecera, $nombArchivo)
    {
            header('Content-Disposition: attachment;filename="'.$nombArchivo.'.xlsx"');
            header('Content-Type: application/force-download');
            header('Content-Transfer-Encoding: binary');
            header('Pragma: public');
            print "\XEF\XBB\XBF";
            $h = array();
            foreach ($data->result_array() as $row) {
            	foreach ($row as $k => $r) {
            		if (!in_array($k, $h)) {
            			$h[] = $k;
            		}
            	}
            }
            echo '<table><tr>';
            foreach ($h as $key) {
            	$key = ucwords($key);
            	echo '<th style="border:1px #888 solid; background-color: #006699; color: white;">'.$key.'</th>';
            }
            echo '</tr>';

            foreach ($data->result_array() as $row) {
            	echo '<tr>';
            	foreach ($row as $val) {
            		$this->writerRow($val);
            	}
            }
            echo '</tr>';
            echo '</table>';
    }

    function writerRow($val){
    	echo '<td style="border:1px #888 solid; color: #555;">'.$val.'</td>';
    }
}