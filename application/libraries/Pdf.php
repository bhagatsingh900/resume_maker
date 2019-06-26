<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once dirname(__FILE__) . '/tcpdf/tcpdf.php';

class pdf extends TCPDF
{
    function __construct()
    {
        parent::__construct();
    }
}

/* End of file tcpdf.php */
/* Location: ./application/libraries/tcpdf.php */