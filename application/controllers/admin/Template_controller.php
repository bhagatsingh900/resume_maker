<?php

Class Template_controller extends CI_Controller
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
		$data['content']=$this->customModel->selectAll('template_section',array(),'sort','ASC');
		$this->load->view('admin/common/header');
		$this->load->view('admin/common/sidebar');
		$this->load->view('admin/template/list',$data); 
	 }
	 
	 public function show_template($id)
	 {
		$data['content']=$this->customModel->selectAll('template_section',array("template_id"=>$id),'sort','ASC');
			$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT,  array(250, 300), true, 'UTF-8', false);
									$pdf->setPrintHeader(false);
									$pdf->setPrintFooter(false);
									$pdf->setTitle("Template");
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
									$content='';
									//$string = $this->load->view('admin/template/genrt_template', $data, TRUE);
									//$html1=$string;
									
									foreach($data['content'] as $key=> $cnt):
										$cnt->content=str_replace('/assets',base_url('assets/'),$cnt->content);
										$content .=  $cnt->content;
									endforeach; 
									// define some HTML content with style
									/*$html = <<<EOF
									$content
EOF;*/
									
									// output the HTML content
									$pdf->writeHTML($content);
									
									// $pdf->Output('example_001.pdf', 'F');					
									$pdf->Output('example_001.pdf', 'I');		 
	}
	
	
	
	 public function template_1($id)
	 {
		 $data['content']='
				 [
					  {
						"profile": {
						  "title": "profile",
						  "declaration": "Highly communicative individual with strong interpersonal skills and an ability to adapt to working in team environments. Motivated by challenge, an astute and dedicated student working to the highest of ability and effectively managing the challenges of part-time employment while successfully completing VCE",    
						  "properties": [
							{
							  "font_famalily": "vardana",
							  "font_size": 25
							},
							{
							  "font_famalily": "vardana",
							  "font_size": 25
							}
						  ]
						},
						"basic_info": {
						  "name": "Bhagat Singh Chandrawat",
						  "email": "bhagat@gmail.com",
						  "designation": "Developer",
						  "phone": "+919009407828",
						  "gender": "male",
						  "address" : "36, MIG, LIG Indore(mp)",
						  "properties": [
							{
							  "font_famalily": "vardana",
							  "font_size": 25
							}
						  ]
						},
						"additional_info":[
							{
								"description" :"NCC Certificate"
							},
							{
								"description" :"Robotics Awards"
							}
						],
						"education": [ {
							"institute_name": "Neemuch Institute",
							"location": "Neemuch",
							"degree" : "MCA",
							"passing_year" : 2015,
							"description":"passing with grade A (75%)"
						  },
						  {
							"institute_name": "Mandsaur Institute",
							"location": "Mandsaur",
							"degree" : "BCA",
							"passing_year" : 2013,
							"description":"passing with grade A (75%)"
						  },
						  {
							"institute_name": "Neemuch Institute",
							"location": "Neemuch",
							"degree" : "12",
							"passing_year" : 2010,
							"description":"passing with grade A (75%)"
						  }
						],
						"award": [
						  {
							"title": "Honor Roll",
							"description":"Honor Roll inclusion for high grades"
						  },
						  {
							"title": "Awards won",
							"description":"Awards won for specific activities or subjects (i.e., Most Valuable Player (MVP), Fine Art Award)"
						  },
						  {
							"title": "Student-related achievement",
							"description" : "Inclusion in student-related achievement publications (i.e., Who’s Who in American High Schools)"
						  }
						],
						"experience" : [
							{
								"from_date" : 2015,
								"to_date" : 2017,
								"designation":"DEVLOPER, WEB DESIGNER",
								"company_name" : "CIT",
								"description" : "Assisted customers with all orders. Ensured the accurate collection of information relating to specific orders and ad hoc requests"
							},
							{
								"from_date" : 2017,
								"to_date" : 2018,
								"designation":"Sr. DEVLOPER",
								"company_name" : "TCS",
								"description" : "Managed cash and EFTPOS payments. Accurately recorded all cash movements while following policies on large note transactions and cash out.Attended to shift cleaning duties including general cleaning, rubbish removal and floor mopping to meet both HACCP and Food Safety regulations. "
							},
							{
								"from_date" : 2018,
								"to_date" : 2019,
								"designation":"Sr. DEVLOPER",
								"company_name" : "WIPRO",
								"description" : "Managed cash and EFTPOS payments. Accurately recorded all cash movements while following policies on large note transactions and cash out.Attended to shift cleaning duties including general cleaning, rubbish removal and floor mopping to meet both HACCP and Food Safety regulations. "
							}
						]
					  }
				]
			';
		
		
			$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT,  array(250,500), true, 'UTF-8', false);
									$pdf->setPrintHeader(false);
									$pdf->setPrintFooter(false);
									$pdf->setTitle("Template");
									$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
									$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
									if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
									require_once(dirname(__FILE__).'/lang/eng.php');
									$pdf->setLanguageArray($l);
									}
									$pdf->setFontSubsetting(true);
									//$pdf->SetFont('Courier', '', 14, '', true);
									$pdf->AddPage('A4');
									$pdf->setTextShadow(array('enabled'=>true, 'depth_w'=>0.2, 'depth_h'=>0.2, 'color'=>array(196,196,196), 'opacity'=>1, 'blend_mode'=>'Normal'));
									$html1 = '';
									$content='';
									$data['pdf']=$pdf;
									$string = $this->load->view('admin/template/temp_1', $data, TRUE);
									//$html1=$string;
									
									//foreach($data['content'] as $key=> $cnt):
									//	$cnt->content=str_replace('/assets',base_url('assets/'),$cnt->content);
									//	$content .=  $cnt->content;
									//endforeach;
									
									
									// define some HTML content with style
									/*$html = <<<EOF
									$content
EOF;*/
									
									// output the HTML content
									$pdf->writeHTML($string);
									
									// $pdf->Output('example_001.pdf', 'F');					
									$pdf->Output('example_001.pdf', 'I');		 
	}
	 
	
}
?>