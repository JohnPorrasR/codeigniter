<?php
class Dompdf_lib {

	var $_dompdf = NULL;

	function __construct()
	{
		require_once("dompdf/dompdf_config.inc.php");
		if(is_null($this->_dompdf)){
			$this->_dompdf = new DOMPDF();
		}
	}

	function convert_html_to_pdf($html, $filename ='', $stream = TRUE, $ori = "portrait")
	{
		$this->_dompdf->set_paper ('a4',$ori);
		//ini_set("memory_limit","80M");
		$this->_dompdf->load_html($html);
		$this->_dompdf->render();
		//return $this->_dompdf->output($filename, 'f');

		if ($stream) {
			$this->_dompdf->stream($filename, array("Attachment" => false));
		} else {
			return $this->_dompdf->output($filename, 'f');
		}

		header('Content-type: application/pdf');
        header('Content-Disposition: inline; filename="' . $filename . '"');
        header('Content-Transfer-Encoding: binary');
        header('Content-Length: ' . filesize($filename));
        header('Accept-Ranges: bytes');

        @readfile($filename);


	}

}
?>
