<?php
 class User_controller extends CI_Controller
 {
				public function __construct()
				{
						parent::__construct();
						if(!is_logged_in())  
												{
														redirect(base_url('login'));
												}
						$this->load->library('Pdf'); 
				}
				
				public function index()
				{
						$data['users']=$this->customModel->selectAll('users',array("type"=>'user'));
						$this->load->view('admin/common/header');
						$this->load->view('admin/common/sidebar');
						$this->load->view('admin/users/user_list',$data);		
				}
				
				public function userList()
				{
						$users=$this->customModel->selectAll('users',array("type"=>'user'));
					 
						 $results = array(
            "sEcho" => 1,
            "iTotalRecords" => count($users),
            "iTotalDisplayRecords" => count($users),
            "aaData"=>$users);
            echo json_encode($results);
				}
				
				
 	/*	public function pdfd()
				{
							$pdf = new Pdf(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
							$pdf->SetTitle('Resume');
							$pdf->SetHeaderMargin(30);
							$pdf->SetTopMargin(20);
							$pdf->setFooterMargin(20);
							$pdf->SetAutoPageBreak(true);
							$pdf->SetAuthor('Author');
						//	$pdf->SetDisplayMode('real', 'default'); 
							$pdf->AddPage();
							$string = $this->load->view('admin/word_ex', '', TRUE);
				 	//	$pdf->writeHTML(5, $string);
							 $pdf->writeHTML($string, true, false, false, false, '');
							$pdf->Output('My-File-Name.pdf', 'I');
				}
				*/
		
	 public function pdfd()
				{
									$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT,  array(250, 300), true, 'UTF-8', false);
									$pdf->setPrintHeader(false);
									$pdf->setPrintFooter(false);
									$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
									$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
									if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
									require_once(dirname(__FILE__).'/lang/eng.php');
									$pdf->setLanguageArray($l);
									}
									$pdf->setFontSubsetting(true);
									$pdf->SetFont('Helvetica', '', 14, '', true);
									$pdf->AddPage();
									$pdf->setTextShadow(array('enabled'=>true, 'depth_w'=>0.2, 'depth_h'=>0.2, 'color'=>array(196,196,196), 'opacity'=>1, 'blend_mode'=>'Normal'));
									$html1 = '';
									$string = $this->load->view('admin/word_ex', '', TRUE);
									$html1=$string;
									
									
									
									
									// define some HTML content with style
									$html = <<<EOF
									$html1
EOF;
									
									// output the HTML content
									$pdf->writeHTML($html, true, false, true, false, '');
									
									// $pdf->Output('example_001.pdf', 'F');					
									$pdf->Output('example_001.pdf', 'I');
	
	} 
 
 }

?>