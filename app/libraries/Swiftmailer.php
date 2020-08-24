<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');


    // Incluimos el archivo Swift
    require_once APPPATH."/third_party/swiftmailer/lib/swift_required.php";
    require_once APPPATH."/third_party/swiftmailer/lib/classes/Swift.php";
 
    class Swiftmailer extends Swift {
    	
        /*public function __construct() {
            parent::__construct();
        }*/
        
    }
?>