<?php 
use resume_builder\Libraries\REST_Controller; 
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';
class Reactapi extends REST_Controller {
    
    public function __construct()
    {
       parent::__construct();
      
       header('Access-Control-Allow-Origin: *');
       header("Access-Control-Allow-Headers: Authorization , Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
       header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
    }
    
    /* Slider List */
    public function sliderList_get()
    {
        $list=$this->Webapi_model->get_data_where('tbl_home_slider',array("Status"=>1));     
        if(!empty($list)) 
        {
            foreach($list as $val){
                if($val['image_name'] != ''){
                    $val['image_name']="uploads/slider/".$val['image_name'];
                }
                $list1[]=$val;
            }                                              
                $this->response($list1, 200);
        }else{
            $this->response(array("status" => "Failed", "response_code" => 204,"message"=>"Failed", "result" =>''), 204);          
        }
        
    }

    /* Category List */
    public function categoryList_get()
    {
		$lang=$this->get('lang');
        $product_type=$this->get('product_type');
		if($product_type=='rent'){
			 $category_list=$this->Admin_model->get_data_where('tbl_category',array("show_in_header"=>1,"Status"=>1,"product_type"=>'rent')); 
		}else{
			$category_list=$this->Admin_model->get_data_where('tbl_category',array("show_in_header"=>1,"Status"=>1));
        }        
        if(!empty($category_list)) 
        {
            foreach($category_list as $cat){
				if($lang=='en'){
					$cat['name']=$cat['Category'];
				}else{
					$cat['name']=$cat['ar_Category'];
				}
				 $cat['ID']=$this->encrypt_ID($cat['ID']);
                if($cat['Image'] != ''){
                    $cat['Image']="uploads/category/default/".$cat['Image'];
                }else{
                    $cat['Image']= "uploads/No_Image_Available.png";
                }
                 $category[]=$cat;
            }
           $this->response(array("status" => "Success", "response_code" => 200,"message"=>"Category Fetched Successfully", "result" =>$category), 200);
        }else{
       $this->response(array("status" => "Failed", "response_code" => 200,"message"=>"Data Not Available", "result" =>""), 200);              
     }
    }
    
    /*encode decode id*/    
    public function encrypt_ID($id){
        $ID=encryptIt($id);
         return base64_encode($ID);
    }  
    
     /*encode decode id*/    
    public function decrypt_ID($id){
        $ID=base64_decode($id);
         return decryptIt($ID);
    }
    
    /* brandList List */
    public function brandList_get()
    {
	    $lang=$this->get('lang');
        $category_list=$this->db->query('select * from tbl_category  where ID in (select CategoryId from tbl_mas_brand)')->result_array();
        if(!empty($category_list)) 
        {
            foreach($category_list as $cat){
				if($lang=='en'){
					$cat['name']=$cat['Category'];
				}else{
					$cat['name']=$cat['ar_Category'];
				}
                if($cat['Image'] != ''){
                    $cat['Image']="uploads/category/default/".$cat['Image'];
                }else{
                    $cat['Image']= "uploads/No_Image_Available.png";
                }
                $cat['ID']=$this->encrypt_ID($cat['ID']);
                 $category[]=$cat;
            }			
              $this->response(array("status" => "Success", "response_code" => 200,"message"=>"Brands Fetched Successfully", "result" =>$category), 200);              
          }else{
         $this->response(array("status" => "Success", "response_code" => 200,"message"=>"Data Not Available", "result" =>"" ), 200);  
        }       
    }
    

    /* Static Page Content */
    public function staticPage_post() 
    {
        if($this->post('page_id') != '')
        {
            $page_id = $this->post('page_id');
            $wh = array("ID"=>$page_id,"status"=>1);
            $list=$this->Admin_model->get_data_where('tbl_APT',$wh);
         
            if(!empty($list)) 
            {
                $this->response(array("status" => "Success", "response_code" => 200,"message"=>"Record Fetched Successfully", "result" =>$list), 200);              
         }else{
                 $this->response(array("status" => "Failed", "response_code" => 200,"message"=>"No Data Available", "result" =>""), 200);              
            }
        }        
    }

    /* Story List*/
    public function storyList_get() 
    {
        $limit = '10';
        /*if($this->post('no') != '')
        {
            $limit = $this->post('no');
        }*/
        $list=$this->Webapi_model->get_Story_data('',$limit);     
        if(!empty($list)) 
        {
            foreach($list as $val){
                if($val['Images'] != ''){
                   $val['Images']= "uploads/stories/default/".$val['Images']; 
                }else{
                    $val['Images']= "uploads/No_Image_Available.png";
                }
                 
                 $list1[]=$val;
            }                                              
            $this->response($list1, 200);
        }else{
            $this->response(array("status" => "Failed", "response_code" => 204,"message"=>"Failed", "result" =>''), 204);          
        }
        
    }

    /* Rent papular product list*/
    public function rent_popular_products_get() 
    {
        $popular_type= 'Rent';
        $limit ='10'; 
        $categories = array(car_category_ID, realstate_category_ID,yachts_category_ID);
        $cat=$this->Webapi_model->all_most_popular_product($categories ,$popular_type,$limit);
       if(count($cat)>0){
           foreach($cat as $key=>$list1){                
                if($list1['DImage'] != ''){
                     $cat[$key]['DImage']='uploads/products/default/'.$list1['DImage'];
                     
                }else{
                     $cat[$key]['DImage']= "uploads/No_Image_Available.png";
                }                
            }           
            $this->response(array("status" => "Success", "response_code" => 200,"message"=>"Category Fetched Successfully", "result" =>$cat), 200);    
        }else{ 
            $this->response(array("status" => "Failed", "response_code" => 200,"message"=>"No Data Available", "result" =>[]), 400);
        }    
      
       
    } 

    /*Sale papular product list*/
    public function sale_popular_products_get() 
    {        
        $popular_type= 'Sale';
        $limit ='8';
        $categories = array(car_category_ID, realstate_category_ID,yachts_category_ID);
        $cat=$this->Webapi_model->all_most_popular_product($categories ,$popular_type,$limit);        
        if(count($cat)>0){
           foreach($cat as $key=>$list1){
                
                if($list1['DImage'] != ''){
                     $cat[$key]['DImage']='uploads/products/default/'.$list1['DImage'];
                     
                }else{
                     $cat[$key]['DImage']= "uploads/No_Image_Available.png";
                }
            }
            $this->response(array("status" => "Success", "response_code" => 200,"message"=>"Category Fetched Successfully", "result" =>$cat), 200);    
        }else{ 
            $this->response(array("status" => "Failed", "response_code" => 200,"message"=>"No Data Available", "result" =>[]), 400);
        }       
    }
    
    
    
 /*Buyer Signup*/
    public function buyers_signup_post()
    {
        $message='';
        $name=$this->post('FName');
        $contactnum=$this->post('Mobile');
        $email=$this->post('Email');
        $pass=$this->post('Password');
        $Device_token=$this->post('Device_token');
        unset($_POST['rePassword']);        
        if(($email !='' || $contactnum !='') && $pass != ''){
           $check_email=$this->db->query("select * from tbl_users where (Email='$email' or Mobile='$contactnum')")->result_array();      
            if(empty($check_email)){
                    $_POST['Password']=encryptIt($_POST['Password']);
                    $_POST['otp']=mt_rand(100000,999999);
                    $buy_id=$this->Admin_model->insert_data('tbl_users',$_POST);
                    $message.="Dear $name <br>  Please varify your Luxury Car Account by click on below link  <br>";
                    $message.="varifyemail/".encryptIt($buy_id);
                    send_mail($email,"Regarding Varification",$message);                       
                    $records=$this->Admin_model->get_data_where_row('tbl_users',array("ID"=>$buy_id));                
                    $this->response(array("status" => "Success", "response_code" => 200,"message"=>"Registered Successfully", "result" =>$records), 200);        
            }else{
                   $this->response(array("status" => "Failed", "response_code" => "","message"=>"Emailid or MobileNo. Already Exist", "result" => ""), 200);           
            }
        }else{         
                $error = array('status' => "Failed", "response_code" => "", "message"=>"Invalid data","result" => "" );
                $this->response($error, 200);
        }        
    }
    
    public function private_seller_signup_post(){
       if(!empty($_POST)){
				/*$y=$_POST['year'];
				$m=$_POST['month'];
				$d=$_POST['day'];
				$time=strtotime(date("$y".'-'."$m".'-'."$d"));
				$DOB= date('Y-m-d',$time);*/
				$insert['FName']=$_POST['FName'];
				$insert['LName']=$_POST['LName'];
				$insert['gender']=$_POST['gender'];
				/*$insert['DOB']=$DOB;*/
				$insert['Address']=$_POST['Address'];
				$insert['City']=$_POST['city_id'];
				$insert['zip']=$_POST['zip'];
				$insert['Countries']=$_POST['country_id'];
				/*$insert['States']=$_POST['StatesID'];*/
				$insert['Email']=$_POST['Email'];
				$insert['Mobile']=$_POST['Phone'];
                $insert['user_type']="seller";
				$insert['Password']=encryptIt($_POST['Password']);
                unset($_POST['Cpassword']);
				$userid=$this->Admin_model->insert_data('tbl_users',$insert);
                $records=$this->Admin_model->get_data_where_row('tbl_users',array("ID"=>$userid));
                 if(!empty($records)){
                    $_SESSION['userID']=$records->ID;
                    $this->response(array("status" => "Success", "response_code" => 200,"message"=>"Registered Successfully", "result" =>$records), 200);
                 }
           }
        }

    /*Buyer Login*/
    public function buyers_login_post()
    {
        $email=$this->post('Email');
        $Mobile=$this->post('Mobile');
        $pass=$this->post('Password');
        $Device_token=$this->post('Device_token');
        if(($email !='' || $Mobile !='') && $pass != ''){
            if(!empty($email)){
                $where=array("Email"=>$email,"Password"=>encryptIt($pass));
                $msg="EmailID or Mobile No.";
            }
 
            $check_email=$this->db->query("select * from tbl_users where (Email='$email' or Mobile='$email' ) and Password='".encryptIt($pass)."'")->row();                   
            if(!empty($check_email)){                
                if($check_email->email_varification==0){
                    $error_msg="Please check your EmailID and verify";
                }else if($check_email->mobile_varification==0){
                    $error_msg="Please verify your mobile number";
                }
                if($Device_token == ''){
                    $Device_token="";
                }
                if($check_email->Status == '0'){
                    $error_msg="Your id is deactvated, Please contact to admin.";
                }
                if($check_email->email_varification==1 && $check_email->mobile_varification==1 && $check_email->Status==1)
                {
                    $wh = array('ID' => $check_email->ID);
                    $data = array('Device_token'=>$Device_token);
                    $res=$this->Webapi_model->update_data($wh,'tbl_users',$data);
                   /*   $_SESSION['userID']=$check_email->ID; */
                     $check_email->ID=$this->encrypt_ID($check_email->ID); 
                     $this->response(array("status" => "Success", "response_code" => 200,"message"=>"Login Successfully", "result" =>$check_email), 200);
                }else{ 
                        $this->response(array("status" => "Failed", "response_code" => "","message"=>"Please varify Email or Mobile Varification", "result" =>""), 200);
                }            
            }else{  
              $error_msg="Invalid $msg and password";         
               $this->response(array("status" => "Failed", "response_code" =>"","message"=>$error_msg, "result" =>""), 200);
            }
        }else{
           $error = array('status' => "Failed", "response_code" => "","message"=>"Invalid data", "result" => "" );
            $this->response($error, 200);
        }
    }
       
    /*otp  varification*/
    public function otp_varify_post()
    {
        if(!empty($_POST)){
            $UserID=$this->input->post('id');
            $otp=$this->input->post('otp');
            $check=$this->Admin_model->get_data_where('tbl_users',array("ID"=>$UserID,"otp"=>$otp));
            if(!empty($check)){
                $update=$this->Admin_model->update_data(array("ID"=>$UserID),"tbl_users",array("mobile_varification"=>1));
                if($update){
                    $get_data=$this->Admin_model->get_data_where('tbl_users',array("ID"=>$UserID));
                    $this->response($get_data, 200);
                }
           }else{
                $this->response(array("status" => "Failed", "response_code" => 204,"message"=>"Failed", "result" =>''), 204);
            }
        }        
           $this->response(array("status" => "Failed", "response_code" => 204,"message"=>"Failed", "result" =>''), 204);
        
    }
    
     /*get category name by alias*/    
    public function get_categeryname($alias){
       return $this->db->where('CatAlias',$alias)->get('tbl_category')->row('ID');
    }   
    
    
    /*View all brand list*/
    public function brandList_post()
    {
        $wh = '';
            if($this->post('no') != ''){
                $limit = $this->post('no'); 
            }else{
                $limit = '';
            }
            $category_id = $this->post('category_id');
            if($category_id != ''){
                //$category_id=$this->get_categeryname($category_id);
                $category_id=$this->decrypt_ID($category_id);
                $wh = array("b.CategoryID"=>$category_id);
            }            
            $list=$this->Webapi_model->get_brand_data($wh,$limit);
            if(!empty($list)) 
            {
                foreach($list as $brand){
                    if(isset($brand['brand_image']) && $brand['brand_image'] != ''){
                        $brand['brand_image']= "uploads/brand/default/".$brand['brand_image'];
                    }else{
                        $brand['brand_image']= "uploads/No_Image_Available.png";
                    }                     
                     $brand_list[]=$brand;
                }                                 
                $this->response(array("status" => "Success", "response_code" => 200,"message"=>"Category Fetched Successfully", "result" =>$brand_list), 200);    
            }else{ 
                $this->response(array("status" => "Failed", "response_code" => 200,"message"=>"No Data Available", "result" =>[]), 400);
            }
    }
    
    
   /*View all papular product list*/
    public function all_products_post() 
    {
        /* for rent product_type ="Rent" , for sale product_type = "Sale"*/
       
        $limit = '';
        $popular_type = $this->post('popular_type');
        $product_type = $this->post('product_type');
        $category_id = $this->post('category_id');   
        $limit = $this->post('limit');
        $page = $this->post('page');
        $currency_id = $this->post('currency_id');		
        if($product_type != ''){
            if($category_id != '' && $category_id!='all'){
                $categories = array($this->decrypt_ID($category_id));
            }else{
                $categories = array(antiques_category_ID,designerwear_category_ID,fragrance_category_ID,watch_category_ID,lifestyle_category_ID,extraordinary_category_ID,motorcycle_category_ID,car_category_ID,realstate_category_ID,yachts_category_ID,jewelry_category_ID);
			}
            $orderby = "p.ID";
            if($popular_type != ''){
                $orderby = "p.no_of_views";
            }
            
            if($limit != ''){
                $start_limit = 0;
                if($page >1){
                    $start_limit=($page-1)*$limit; 
                }
                $limit=$limit;
            }
     
			$cat=$this->Webapi_model->all_most_popular_product($categories ,$product_type,$limit,$orderby,$start_limit);
 
           if(count($cat)>0){
                $today = date("Y-m-d");
               foreach($cat as $key=>$list1){
                    if($list1['offer_validity']<$today){
                        $cat[$key]['offer_validity']= '';
                    }else{
                        $cat[$key]['offer_validity']= date("d/m/Y",strtotime($list1['offer_validity']));
                    }
                    if($list1['DImage'] != ''){
                        $cat[$key]['DImage']='uploads/products/default/'.$list1['DImage'];
                        $cat[$key]['home_image']='uploads/products/default/home/'.$list1['DImage'];
                        $cat[$key]['thumbnail_image']='uploads/products/default/thumbnail/'.$list1['DImage'];
                        $cat[$key]['big_image']='uploads/products/default/big/'.$list1['DImage']; 
                    }else{
                         $cat[$key]['DImage']= "uploads/No_Image_Available.png";
                    }
                     $cat[$key]['ConCode']= strtolower($cat[$key]['ConCode']);
                     $cat[$key]['ID']=$this->encrypt_ID($cat[$key]['ID']);
                }
                 $this->response(array("status" => "Success", "response_code" => 200,"message"=>"Products Fetched Successfully", "result" =>$cat), 200);
             }else{
                 $this->response(array("status" => "Success", "response_code" => 200, "message"=>"Data Not available" , "result" =>''), 200);
            }      
        }else{
             $error = array('status' => "Failed", "response_code" => 400, "message"=>"Please select product type (Rent or Sale).","result" => "" );
            $this->response($error, 400);
        }
    }
 
    /* Story detail by story id */
    public function storyDetails_post()
    {
        if($this->post('story_id') != '')
        {
            $story_id = $this->post('story_id');   
            $wh = array("s.ID"=>$story_id);
            $list=$this->Webapi_model->get_Story_data($wh);            
            if(!empty($list)) 
            {
                $list=$list[0];
                if($list['Images'] != ''){
                   $list['Images']= "uploads/stories/default/".$list['Images']; 
                }else{
                    $list['Images']= "uploads/No_Image_Available.png";
                }                
                $wh = array("StoryID"=>$story_id);
                $imageList = $this->Webapi_model->get_data_where('tbl_story_images',$wh);
                $list1 = array();
                if(!empty($imageList)) 
                {   
                    foreach($imageList as $key=>$val){
                        if($val['SimilerImg'] != ''){
                           $list1[$key]= "uploads/stories/similer/".$val['SimilerImg']; 
                        }                        
                    }   
                    $list['GalleryImages'] = $list1;
                }else{
                    $list['GalleryImages'] = '';
                }
                   
                $this->response(array("status" => "Success", "response_code" => 200,"message"=>"Category Fetched Successfully", "result" =>$list), 200);    
            }else{ 
                $this->response(array("status" => "Failed", "response_code" => 200,"message"=>"No Data Available", "result" =>[]), 400);
            }                                              
              
        }else{            
            $this->response(array("status" => "Failed", "response_code" => 200,"message"=>"No Data Available", "result" =>[]), 400);
        }       
    }      
    
    /* sub menu list*/
    public function sub_menu_list_get()
    {
        $submenu = array("for_sale"=>array(),
                    "travel"=>array(),
                    "brands"=>array(),
                    "dealers"=>array()
                );
        
        $Salelist=$this->Webapi_model->category_list_from_product('Sale');
        $Rentlist=$this->Webapi_model->category_list_from_product('Rent');
        $Brandlist=$this->Webapi_model->brand_list_from_product();
        
        if(!empty($Salelist)) 
        {
            foreach($Salelist as $key=>$val){
                if($val['Image'] != ''){
                   $val['Image']= "uploads/category/default/".$val['Image']; 
                }else{
                    $val['Image']= "uploads/No_Image_Available.png";
                }

                $submenu['for_sale'][$key]=$val;
            }
        }
        if(!empty($Rentlist)) 
        {
            foreach($Rentlist as $key=>$val){
                if($val['Image'] != ''){
                   $val['Image']= "uploads/category/default/".$val['Image']; 
                }else{
                    $val['Image']= "uploads/No_Image_Available.png";
                }
                 
                $submenu['travel'][$key]=$val;
            }
        }
        if(!empty($Brandlist)) 
        {
            $submenu['brands'] = $Brandlist;
        }
        $this->response(array("status" => "Success", "response_code" => 200,"message"=>"Category Fetched Successfully", "result" =>$submenu), 200);
    }

     /*product details by product id*/
    function productDetails_post()
    {
        if($this->post('product_id') != '')
        {
            $product_id =$this->post('product_id');
            if($product_id!=''){
                $product_id = $this->decrypt_ID($this->post('product_id'));
            }
             $user_id = $this->post('user_id');
            if($user_id!=''){
                 //$user_id = $this->decrypt_ID($this->post('user_id'));
                  $user_id = $this->post('user_id');
            }
              /*  $getchatlist=$this->Webapi_model->get_UsersChat_list($product_id,$user_id);
                $gerAssignedUser=$this->Webapi_model->get_Assgined_User($product_id);*/
             
             
            $list = $this->Webapi_model->get_product_details_by_id($product_id, $user_id);
            $a = array("ID", "User_id", "User_type","FName", "LName","PImage", "Alias", "Name", "Price","CurrencyId", "DImage", "no_of_views","Description","Address","CreateDate", "UpdateDate", "is_fav");
            $na = array("CategoryID", "BrandID", "ModelID", "DriveId", "Tags", "Status","YearID","CountriesID","StatesID","CityID","InteriorColorID","ColorID","TypeID");
            if(!empty($list)) 
            {
                $z=1;
                   $list=$list[0];
                $i = '0';
              
              /*  $senderID=array("id"=>$this->decrypt_ID($this->post('user_id')));
               foreach($gerAssignedUser as $recuser){
                $receiver['id']=$recuser['ID'];
                $receiver['username']=trim($recuser['FName']." ".$recuser['LName']);
                if(!empty($recuser['PImage'])){
                $receiver['imageUrl']=$recuser['PImage'];
                }else{
                     $receiver['imageUrl']= "uploads/No_Image_Available.png";
                }
               }*/
               /* $msg=array();
                foreach($getchatlist as $chat){
                   $message['id']=$chat['Id'];
                    $message['msg']=array("type"=>"text","text"=>$chat['Message']);
                     $message['userID']=$chat['SenderId'];
                     $msg[]=$message;
                }*/
               
             
                foreach($list as $key => $value) {
                    if(in_array($key, $a)){
                        $mlist[$key] = $value;
                    }else if(($value != '' || $value != null) && !in_array($key, $na)){
                        $alist[$i]["key"] = $key;
                        $alist[$i]["value"] = $value;  
                        $i++;                  
                    }
                }
                $list = $mlist;
                $list["attributes"] =$alist;
                if($list['PImage'] != ''){
                   $list['PImage']= $list['PImage']; 
                }else{
                    $list['PImage']= "uploads/No_Image_Available.png";
                }
                if($list['DImage'] != ''){
                    $defaultimage='uploads/products/default/big/'.$list['DImage'];
                   $list['DImage']= 'uploads/products/default/'.$list['DImage'];
                 //   $list['home_image']='uploads/products/default/home/'.$list['DImage'];
                  //  $list['thubnail_image']='uploads/products/default/thumbnail/'.$list['DImage'];
                   //  $list['big_image']='uploads/products/default/big/'.$list['DImage']; 
                }else{
                    $list['DImage']= "uploads/No_Image_Available.png";
                }
                 $list['ID']=$this->encrypt_ID($list['ID']);               
                $wh = array("ProductID"=>$product_id);
                $imageList = $this->Webapi_model->get_data_where('tbl_product_images',$wh);
                //print($imageList);
                if(!empty($imageList))  
                {
                    $similercount=1;
                    foreach($imageList as &$val){
                        if($val['SimilerImg'] != ''){
                            if($similercount==1){
                                $similrimg['DImage']= $defaultimage;
                            }
                           $similrimg['SimilerImg'] = 'uploads/products/similer/'.$val['SimilerImg'];
                            $similrimg['thumbnail_image'] = 'uploads/products/similer/thumbnail/'.$val['SimilerImg'];
                             $similrimg['big_image'] = 'uploads/products/similer/big/'.$val['SimilerImg'];
                             $imgimg[]=$similrimg;
                             $similercount++;
                        }
                    }
                    $list['GalleryImages'] = $imgimg;
                }else{
                    $list['GalleryImages'] = '';
                }
               /* $list["sender"] =$senderID;
                 $list["receiver"] =$receiver;
                  $list['message']=$msg;*/
                $this->response(array("status" => "Success", "response_code" => 200,"message"=>"Category Fetched Successfully", "result" =>$list), 200);    
            }else{ 
                $this->response(array("status" => "Failed", "response_code" => 200,"message"=>"No Data Available", "result" =>[]), 400);
            }
        }else{
            $this->response(array("status" => "Failed", "response_code" => 200,"message"=>"No Data Available", "result" =>[]), 400);
        }
    }

   

     /*Buyer Profile by id*/
    public function myProfile_post()
    {
        $user_id=$this->post('user_id');

        if($user_id !=''){
            $wh = array("ID"=>$user_id);
            $list =  $this->Webapi_model->get_data_where('tbl_users',$wh);
            if(!empty($list)){
                $list = $list[0]; 
                if($list['Status'] == 1){
                    $this->response(array("status" => "Success", "response_code" => 200,"message"=>"Category Fetched Successfully", "result" =>$list), 200);    
                }else{ 
                    $this->response(array("status" => "Failed", "response_code" => 200,"message"=>"No Data Available", "result" =>[]), 400);
                } 
            }
        
        }else{                  
           $this->response(array("status" => "Failed", "response_code" => 200,"message"=>"No Data Available", "result" =>[]), 400);
        }
    }


     /*Update Buyer Profile*/
    public function updateProfile_post()
    {
        $user_id=$this->post('user_id');
        $email=$this->post('email');
        $mobile=$this->post('mobile');
        $f_name=$this->post('f_name');
        $l_name=$this->post('l_name');

        if($user_id !=''){
            $wh = array("ID"=>$user_id);
            $list =  $this->Webapi_model->get_data_where('tbl_users',$wh);

            $check_email=$this->db->query("select * from tbl_users where (Email='$email' or Mobile='$mobile') and ID!='$user_id'")->row();

            if(count($list)>0 && count($check_email) < 1){
                $data = array();
                if($f_name != ''){
                    $data['FName'] = $f_name;
                }
                if($l_name != ''){
                    $data['LName'] = $l_name;
                }
                if($email != ''){
                    $data['Email'] = $email;
                }
                if($mobile != ''){
                    $data['Mobile'] = $mobile;
                }

                if(!empty($data)){
                   $res=$this->Webapi_model->update_data($wh,'tbl_users',$data); 
                }
                
                $list =  $this->Webapi_model->get_data_where('tbl_users',$wh);
                $this->response(array("status" => "Success", "response_code" => 200,"message"=>"Profile update successfully.", "result" =>$list[0]), 200);
                
            
            }else{ 
                if(count($check_email) >0){
                    $error_msg = "Your Email ID or Mobile already exist.";
                }else{
                    $error_msg="Your user id does not exist.";   
                }   
            }
            $this->response(array("status" => "Failed", "response_code" => 200,"message"=>"Failed", "result" =>''), 200);
                       
        
        }else{                  
           $this->response(array("status" => "Failed", "response_code" => 200,"message"=>"Failed", "result" =>''), 200);
        }
    }

     /*change password*/
    public function changePassword_post()
    {
        $user_id = $this->post('user_id');
        $old_password = $this->post('old_password');
        $new_password = $this->post('new_password');
        $confirm_password = $this->post('confirm_password');

        if($user_id !=''){
            $wh = array("ID"=>$user_id,"Password"=>encryptIt($old_password));
            $check_pass =  $this->Webapi_model->get_data_where('tbl_users',$wh);

            if(count($check_pass)>0){                
                if($new_password == ''){ 
                    $this->response(array("status" => "Failed", "response_code" => 204,"message"=>"Failed", "result" =>''), 204);
                }else if($new_password != $confirm_password){
                    $this->response(array("status" => "Failed", "response_code" => 204,"message"=>"Failed", "result" =>''), 204);
                }else{
                    $data['Password'] = encryptIt($new_password);
                
                   $wh1 = array("ID"=>$user_id);
                   $res=$this->Webapi_model->update_data($wh1,'tbl_users',$data); 
                
                    $this->response(array("status" => "Success", "response_code" => 200,"message"=>"Category Fetched Successfully", "result" =>$list), 200);        
                }                
            }else{       
                $this->response(array("status" => "Failed", "response_code" => 200,"message"=>"Failed", "result" =>''), 200);
            }                     
        
        }else{                  
           $this->response(array("status" => "Failed", "response_code" => 200,"message"=>"Failed", "result" =>''), 200);
        }
    }

     /*forget password*/
    public function forgetPassword_post()
    {
        $email = $this->post('email');    

        if($email !=''){
            $wh = array("Email"=>$email);
            $check_email =  $this->Webapi_model->get_data_where('tbl_users',$wh); 

            if(count($check_email)>0){ 
                $url = base_url()."Forget_password/".$check_email[0]['ID'];
                $message = 'Please click on below link <br><a href="'.$url.'">'.$url.'</a>'; 
                $this->email->from('admin@mail.com', 'Admin');
                $this->email->to($email); 
                $this->email->subject('Forget password from LuxuryCars.');
                $this->email->message($message);
                $this->email->send();  

                $this->response(array(), 200);  
            }else{       
                $this->response(array("status" => "Failed", "response_code" => 200,"message"=>"Failed", "result" =>''), 200);
            }                     
        
        }else{                  
           $this->response(array("status" => "Failed", "response_code" => 200,"message"=>"Failed", "result" =>''), 200);
        }
    }

     /* favourites Product list*/
    public function favouritesProduct_post()
    {
        if($this->post('user_id') != '')
        {
             $user_id = $this->decrypt_ID($this->post('user_id'));
            
            $limit = '';

            if($this->post('no') != '')
            {
                $limit = $this->post('no');
            }
            $wh = array("UserId"=>$user_id);
            $list=$this->Webapi_model->get_favourite_products($wh,$limit);        
            if(!empty($list)) 
            {
                foreach($list as $val){
                    if($val['DImage'] != ''){                       
                        $val['DImage']= 'uploads/products/default/'.$val['DImage'];                        
                    }else{
                        $val['DImage']= "uploads/No_Image_Available.png";
                    }
                     $val['ID']=$this->encrypt_ID($val['ID']);
                     $list1[]=$val;
                }                                              
                $this->response(array("status" => "Success", "response_code" => 200,"message"=>"Successfully", "result" =>$list1), 200);
            }else{
                 $this->response(array("status" => "Failed", "response_code" => 200,"message"=>"Failed", "result" =>''), 200);
            }
        }else{           
            $this->response(array("status" => "Failed", "response_code" => 204,"message"=>"Failed", "result" =>''), 204);
        }
    }

     /* make or remove the favourites Product */
    public function makeFavouriteProduct_post()
    {
        $user_id = $this->decrypt_ID($this->post('user_id'));
        $product_id = $this->decrypt_ID($this->post('product_id'));
        $fav_status = $this->post('fav_status');
         $remove_all = $this->post('remove_all');
         
         if(!empty($remove_all) && $remove_all==1){
            $fav_id=$this->Webapi_model->delete_data('tbl_favourites_product',array("UserId"=>$user_id)); 
             $this->response(array("status" => "Success", "response_code" => 200,"message"=>"Successfully Remove Favourite Product." ,"result" =>""), 200);  
         }else{
                if($user_id != '' && $product_id != '' && $fav_status != '')
                {
                    $wh = array("UserId"=>$user_id,"ProductId"=>$product_id);
                    $data = array("UserId"=>$user_id,"ProductId"=>$product_id);
                    $list=$this->Webapi_model->get_data_where("tbl_favourites_product",$wh);
                    
                    if(count($list)>0 && $fav_status == 'false') 
                    {
                        $fav_id=$this->Webapi_model->delete_data('tbl_favourites_product',$wh);                               
                        $this->response(array("status" => "Success", "response_code" => 200,"message"=>"Remove Favourite Product." ,"result" =>""), 200);                
                    }else if(count($list)>0 && $fav_status == 'true'){
                        $this->response(array("status" => "Failed", "response_code" => 204,"message"=>"Already favourite Product.", "result" =>''), 204);
                    }else if(count($list)<1 && $fav_status == 'false'){
                        $this->response(array("status" => "Failed", "response_code" => 204,"message"=>"Does not exist as a favourite Product.", "result" =>''), 204);
                    }else{
                        $fav_id=$this->Webapi_model->insert_data('tbl_favourites_product',$data);
                       $this->response(array("status" => "Success", "response_code" => 200, "message"=>"Make favourite Product.", "result" => ""), 200);
                        
                    }
                }else{
                    $this->response(array("status" => "Failed", "response_code" => 204,"message"=>"Please enter user id , product id , favourite status", "result" =>''), 204);
                }
         }
    }
    
    

    /* Currency List*/
    public function currencyList_get()
    {        
        $list=$this->Admin_model->get_data_where('tbl_mas_currency',array("Status"=>"1"));     
        if(!empty($list)) 
        {
            foreach($list as $val){
                if($val['image'] != ''){
                   $val['image']= "uploads/currency/".$val['image']; 
                }else{
                    $val['image']= "uploads/No_Image_Available.png";
                }

                $val1['value']=$val['ID'];
                 $val1['label']=$val['Currency']; 
                $list1[]=$val1;
            } 
            $this->response(array("status" => "Success", "response_code" => 200,"message"=>"Category Fetched Successfully", "result" =>$list1), 200);
        }else{
              $this->response(array("status" => "Failed", "response_code" => 200,"message"=>"Failed", "result" =>''), 200);
        }
        
    }

    /* buyer Chat List*/
    public function buyerChatList_post()
    {
        
        if($this->post('user_id') != '')
        {
            $user_id = $this->post('user_id');
            $limit = '';

            if($this->post('no') != '')
            {
                $limit = $this->post('no');
            }
            $wh = array("SenderId"=>$user_id,"SenderType"=>'buyer');
            $list=$this->Webapi_model->get_chat_list_by_sender_id($wh,$limit);
           
            if(!empty($list)) 
            {   
                $table = '';
                $list1 = array();
                $i = 0;
                foreach($list as $key=>$val){

                    if($val['RecieverType'] == 'admin'){
                       $table = 'admin_login';
                    }
                    if($val['RecieverType'] == 'seller'){
                       $table = 'tbl_private_seller';
                    }
                    if($val['RecieverType'] == 'dealer'){
                       $table = '';
                    }
                    $rec_id = $val['RecieverId'];
                    $pro_id = $val['ProductId'];
                    $Rdetail=$this->Webapi_model->get_data_where($table,array('ID'=>$rec_id));
                    $Pdetail=$this->Webapi_model->get_data_where("tbl_products",array('ID'=>$pro_id));
                    
                    if(!empty($Rdetail))
                    {
                        $a1['RecieverId']=$Rdetail[0]['ID'];
                        $a1['FName']=$Rdetail[0]['FName'];
                        $a1['LName']=$Rdetail[0]['LName'];
                        $list1[$key] = $a1;
                    }
                    if(!empty($Pdetail))
                    {
                        $a['ProductId']=$Pdetail[0]['ID'];
                        $a['Name']=$Pdetail[0]['Name'];
                        $a['Price']=$Pdetail[0]['Price'];
                        $a['Address']=$Pdetail[0]['Address'];
                        $a['DImage']="uploads/products/default/".$Pdetail[0]['DImage'];
                        
                        $list2 = $a;
                        
                    }else{
                        $list2 = "";
                    }
                    $list1[$key]['ProductDetails'] = $list2;
                }    
                                                
                $this->response(array("status" => "Success", "response_code" => 200,"message"=>"Category Fetched Successfully", "result" =>$list1), 200);
            }else{
                 $this->response(array("status" => "Failed", "response_code" => 200, "message"=>"Data Not available" , "result" =>''), 200);
            }
        }else{           
            $this->response(array("status" => "Failed", "response_code" => 204,"message"=>"Failed", "result" =>''), 204);
        }
        
    }

    

    /* Product views update*/
    public function productViewsUpdate_post()
    {
        $product_id = $this->post('product_id'); 
        $product_id = $this->post('product_id');
        if($product_id != ''){
            $no_of_views = 1;
            $wh = array('ID' => $product_id);
            $res=$this->Webapi_model->get_data_where('tbl_products',$wh);
            
            if(!empty($res)){
               $no_of_views = $res[0]['no_of_views']+1;
            }
             $data = array('no_of_views'=>$no_of_views);
            
            //print_r($data);die;
            $res1=$this->Webapi_model->update_data($wh,'tbl_products',$data);
            $this->response(array("status" => "Success", "response_code" => 200,"message"=>"Category Fetched Successfully", "result" =>$no_of_views), 200);
        } else{
            $this->response(array("status" => "Failed", "response_code" => 204,"message"=>"Failed", "result" =>''), 204);
        } 
    }
    /* search Product On Home Page*/
    public function searchProductByKeyword_post()
    {
        $keyword = $this->post("keyword");
        if($keyword != ''){
            $list = $this->Webapi_model->search_product_by_keyword($keyword);
            if(!empty($list)) 
            {   
               foreach($list as $key=>$list1){
                    
                    if($list1['DImage'] != ''){
                         $list[$key]['DImage']='uploads/products/default/'.$list1['DImage'];                         
                    }else{
                         $list[$key]['DImage']= "uploads/No_Image_Available.png";
                    }
                    
                }                                          
                $this->response(array("status" => "Success", "response_code" => 200,"message"=>"Category Fetched Successfully", "result" =>$list), 200);
            }else{
                $this->response(array(), 200);
            }
        }else{
            $this->response(array("status" => "Failed", "response_code" => 204,"message"=>"Failed", "result" =>''), 204);
        }
    }
   
     /* Brand product Filters List */
     public function brandFilterAttributes_post()
     {
        $cat_id = $this->decrypt_ID($this->post("category_id"));
        $product_type = $this->post("product_type");       
        
        $wh = array('CategoryID'=>$cat_id,"Rental"=>$product_type);
        $attrlistdetail = $this->Webapi_model->get_brandattrdata($wh);
       
        if(!empty($attrlistdetail)){
            $attr_list = array();
            $i = 0;
            foreach($attrlistdetail as $key => $value) { 
                $wh['BrandID'] = $value['ID'];
                $pro_total = $this->Webapi_model->get_total_product($wh)[0]['Total'];
                if($pro_total >0){
                    $attr_list[$i] = $value;
                    $attr_list[$i]['show_text'] = $value['Brand']."(".$pro_total.")";
                    $i++;
                }
            }
            $this->response(array("status" => "Success", "response_code" => 200,"message"=>"Models Fetched Successfully", "result" =>$attr_list), 200);
        }else{
            $this->response(array("status" => "Failed", "response_code" => 200, "message"=>"Data Not available" , "result" =>''), 200);
        }
        
     }

      /* Model product Filters List */
      public function modelFilterAttributes_post()
      {
         $data['CategoryID'] = $this->post("category_id");
         $data['Rental'] = $this->post("product_type"); 
         $data['BrandID'] = $this->post("brand_id");
         //$wh = array('CategoryID'=>$cat_id,"Rental"=>$product_type,"ModelID"=>$brand_id);
         $wh =  $data;
         $attrlistdetail = $this->Webapi_model->get_modelattrdata($wh); 
         if(!empty($attrlistdetail)){
             $attr_list = array();
             $i = 0;
             foreach($attrlistdetail as $key => $value) {
                 $wh['ModelID'] = $value['ID'];                
                 $pro_total = $this->Webapi_model->get_total_product($wh)[0]['Total'];
                 if($pro_total >0){
                     $attr_list[$i] = $value;
                     $attr_list[$i]['show_text'] = $value['Model']." (".$pro_total.")";
                     $i++;
                 }
             }
           $this->response(array("status" => "Success", "response_code" => 200,"message"=>"Models Fetched Successfully", "result" =>$attr_list), 200);              
          
         }else{
            
          $this->response(array("status" => "Failed", "response_code" => "","message"=>"Data not available", "result" => ""), 200);           
             
         }         
      }

      /* roduct Filters List By CategoryType productFiltersListByCategoryType*/
      public function yearFilterAttributes_post()
      {
         $cat_id = $this->post("category_id");
         $product_type = $this->post("product_type");     
         
         $wh = array('CategoryID'=>$cat_id,"Rental"=>$product_type);
         if($this->post("brand_id") != ''){
            $wh['BrandID'] = $this->post("brand_id");
         }
         $attrlistdetail = $this->Webapi_model->get_yearattrdata($wh);
        
         if(!empty($attrlistdetail)){
             $attr_list = array();
             $i = 0;
             foreach($attrlistdetail as $key => $value) { 
                 $wh['YearID'] = $value['ID'];
                 $pro_total = $this->Webapi_model->get_total_product($wh)[0]['Total'];
                 if($pro_total >0){
                     $attr_list[$i] = $value;
                     $attr_list[$i]['show_text'] = $value['Year']."(".$pro_total.")";
                     $i++;
                 }
             }
             $this->response(array("status" => "Success", "response_code" => 200,"message"=>"Models Fetched Successfully", "result" =>$attr_list), 200);
         }else{
              $this->response(array("status" => "Failed", "response_code" => 200, "message"=>"Data Not available" , "result" =>''), 200);
         }
         
      }

      /* Color product Filters List */
      public function colorFilterAttributes_post()
      {
         $cat_id = $this->post("category_id");
         $product_type = $this->post("product_type");
        
         
         $wh = array('CategoryID'=>$cat_id,"Rental"=>$product_type);

         if($this->post("brand_id") != ''){
            $wh['BrandID'] = $this->post("brand_id");
         }
         $attrlistdetail = $this->Webapi_model->get_colorattrdata($wh);
        
         if(!empty($attrlistdetail)){
             $attr_list = array();
             $i = 0;
             foreach($attrlistdetail as $key => $value) { 
                 $wh['ColorID'] = $value['ID'];
                 $pro_total = $this->Webapi_model->get_total_product($wh)[0]['Total'];
                 if($pro_total >0){
                     $attr_list[$i] = $value;
                     $attr_list[$i]['show_text'] = $value['Color']."(".$pro_total.")";
                     $i++;
                 }
             }
             $this->response(array("status" => "Success", "response_code" => 200,"message"=>"Models Fetched Successfully", "result" =>$attr_list), 200);  
         }else{
             $this->response(array("status" => "Failed", "response_code" => 200, "message"=>"Data Not available" , "result" =>''), 200);
         }
         
      }

      /* roduct Filters List By CategoryType productFiltersListByCategoryType*/
     public function interiorColorFilterAttributes_post()
     {
         $cat_id = $this->post("category_id");
         $product_type = $this->post("product_type");
      
         
         $wh = array('CategoryID'=>$cat_id,"Rental"=>$product_type);
         if($this->post("brand_id") != ''){
            $wh['BrandID'] = $this->post("brand_id");
         }
         $attrlistdetail = $this->Webapi_model->get_interiorcolorattrdata($wh);
        
         if(!empty($attrlistdetail)){
             $attr_list = array();
             $i = 0;
             foreach($attrlistdetail as $key => $value) { 
                 $wh['InteriorColorID'] = $value['ID'];
                 $pro_total = $this->Webapi_model->get_total_product($wh)[0]['Total'];
                 if($pro_total >0){
                     $attr_list[$i] = $value;
                     $attr_list[$i]['show_text'] = $value['InteriorColor']."(".$pro_total.")";
                     $i++;
                 }
             }
             $this->response(array("status" => "Success", "response_code" => 200,"message"=>"Models Fetched Successfully", "result" =>$attr_list), 200);  
         }else{
             $this->response(array("status" => "Failed", "response_code" => 200, "message"=>"Data Not available" , "result" =>''), 200);
         }
         
     }

      /* roduct Filters List By CategoryType productFiltersListByCategoryType*/
      public function typeFilterAttributes_post()
      {
           $cat_id = $this->decrypt_ID($this->post("category_id"));
           $product_type = $this->post("product_type");
           
           //$wh = array('CategoryID'=>$cat_id,"Rental"=>$product_type);
           $wh = array('CategoryID'=>$cat_id,"Rental"=>$product_type);
            if($this->post("brand_id") != ''){
                $wh['BrandID'] = $this->post("brand_id");
            }
           
           $attrlistdetail = $this->Webapi_model->get_typeattrdata($wh);
          
           if(!empty($attrlistdetail)){
               $attr_list = array();
               $i = 0;
               foreach($attrlistdetail as $key => $value) { 
                   $wh['TypeID'] = $value['ID'];
                   $pro_total = $this->Webapi_model->get_total_product($wh)[0]['Total'];
                   if($pro_total >0){
                       $attr_list[$i] = $value;
                       $attr_list[$i]['show_text'] = $value['Type']."(".$pro_total.")";
                       $i++;
                   }
               }
               $this->response(array("status" => "Success", "response_code" => 200,"message"=>"Models Fetched Successfully", "result" =>$attr_list), 200);  
           }else{
              $this->response(array("status" => "Failed", "response_code" => 200, "message"=>"Data Not available" , "result" =>''), 200);
           }
           
      }

        /* roduct Filters List By CategoryType productFiltersListByCategoryType*/
    public function driveFilterAttributes_post()
    {
         $cat_id = $this->post("category_id");
         $product_type = $this->post("product_type");
      
         $wh = array('CategoryID'=>$cat_id,"Rental"=>$product_type);
         if($this->post("brand_id") != ''){
            $wh['BrandID'] = $this->post("brand_id");
         }
         $attrlistdetail = $this->Webapi_model->get_driveattrdata($wh);
        
         if(!empty($attrlistdetail)){
             $attr_list = array();
             $i = 0;
             foreach($attrlistdetail as $key => $value) { 
                 $wh['DriveId'] = $value['ID'];
                 $pro_total = $this->Webapi_model->get_total_product($wh)[0]['Total'];
                 if($pro_total >0){
                     $attr_list[$i] = $value;
                     $attr_list[$i]['show_text'] = $value['Drive']."(".$pro_total.")";
                     $i++;
                 }
             }
             $this->response(array("status" => "Success", "response_code" => 200,"message"=>"Models Fetched Successfully", "result" =>$attr_list), 200);  
         }else{
             $this->response(array("status" => "Failed", "response_code" => 200, "message"=>"Data Not available" , "result" =>''), 200);
         }
         
    }

    /* roduct Filters List By CategoryType productFiltersListByCategoryType*/
    public function countryFilterAttributes_post()
    {
            $cat_id = $this->decrypt_ID($this->post("category_id"));
            $product_type = $this->post("product_type");
            $wh = array('CategoryID'=>$cat_id,"Rental"=>$product_type);
            if($this->post("brand_id") != ''){
                $wh['BrandID'] = $this->post("brand_id");
            }
            $attrlistdetail = $this->Webapi_model->get_countryattrdata($wh);        
            if(!empty($attrlistdetail)){
                $attr_list = array();
                $i = 0;
                foreach($attrlistdetail as $key => $value) { 
                    $wh['CountriesID'] = $value['ID'];
                    $pro_total = $this->Webapi_model->get_total_product($wh)[0]['Total'];
                    if($pro_total >0){
                        $attr_list[$i] = $value;
                        $attr_list[$i]['show_text'] = $value['Countries']."(".$pro_total.")";
                        $i++;
                    }
                }
                $this->response(array("status" => "Success", "response_code" => 200,"message"=>"Models Fetched Successfully", "result" =>$attr_list), 200);  
            }else{
                 $this->response(array("status" => "Failed", "response_code" => 200, "message"=>"Data Not available" , "result" =>''), 200);
            }           
    }
    
    
      public function filtercities_post()
    {
               $cat_id = $this->decrypt_ID($this->post("category_id"));  
            $product_type = $this->post("product_type");
            $country_id= $this->post("country_id");
            
            $wh = array('CategoryID'=>$cat_id,"Rental"=>$product_type);
            if($this->post("brand_id") != ''){
                $wh['BrandID'] = $this->post("brand_id");
                
            }
            $attrlistdetail = $this->Webapi_model->get_citydata($wh);        
            if(!empty($attrlistdetail)){
                $attr_list = array();
                $i = 0;
                foreach($attrlistdetail as $key => $value) { 
                    $wh['CityID'] = $value['ID'];
                    $pro_total = $this->Webapi_model->get_total_product($wh)[0]['Total'];
                    if($pro_total >0){
                        $attr_list[$i] = $value;
                        $attr_list[$i]['show_text'] = $value['City']."(".$pro_total.")";
                        $i++;
                    }
                }
                $this->response(array("status" => "Success", "response_code" => 200,"message"=>"Models Fetched Successfully", "result" =>$attr_list), 200);  
            }else{
                $this->response(array("status" => "Failed", "response_code" => 200, "message"=>"Data Not available" , "result" =>''), 200);
            }           
    }

    /* roduct Filters List By CategoryType productFiltersListByCategoryType*/
    public function stateFilterAttributes_post()
    {
            $cat_id = $this->post("category_id");
            $product_type = $this->post("product_type");
            $wh = array('CategoryID'=>$cat_id,"Rental"=>$product_type,"CountriesID"=>'231');
            $attrlistdetail = $this->Webapi_model->get_stateattrdata($wh);        
            if(!empty($attrlistdetail)){
                $attr_list = array();
                $i = 0;
                foreach($attrlistdetail as $key => $value) { 
                    $wh['StatesID'] = $value['ID'];
                    $pro_total = $this->Webapi_model->get_total_product($wh)[0]['Total'];
                    $attr_list['Title'] = "US State";
                    if($pro_total >0){
                        $attr_list[$i] = $value;
                        $attr_list[$i]['show_text'] = $value['States']."(".$pro_total.")";
                        $i++;
                    }
                }
                $this->response(array("status" => "Success", "response_code" => 200,"message"=>"Models Fetched Successfully", "result" =>$attr_list), 200);  
            }else{
                 $this->response(array("status" => "Failed", "response_code" => 200, "message"=>"Data Not available" , "result" =>''), 200);
            }
            
    }

    /* Price product Filters List */
    public function priceFilterAttributes_post()
    {
            $cat_id = $this->post("category_id");
            $product_type = $this->post("product_type");
            $currency_id = $this->post("currency_id");
           
            
            $wh = array('CategoryId'=>$cat_id,"Status"=>1);
            $attrlistdetail = $this->Webapi_model->get_data_where('tbl_mas_price',$wh);  
            $currencydetail = $this->Webapi_model->get_data_where('tbl_mas_currency',array('ID'=>$currency_id,"Status"=>1));    
            
         
            if(!empty($attrlistdetail) && !empty($currencydetail)){
                $attr_list = array();
                $i = 0;
                foreach($attrlistdetail as $key => $value) { 
                   
                        $wh = array('CategoryID'=>$cat_id,"Rental"=>$product_type);
                        $final_FromPrice = $data['FromPrice'] = $value['FromPrice'];
                        $final_ToPrice = $data['ToPrice'] = $value['ToPrice'];
                        $pro_total = $this->Webapi_model->get_total_priceproduct($wh,$data)[0]['Total'];
                        $attr_list[$i] = $value;
                        if(!empty($currencydetail)){   
                            if($currencydetail[0]['image'] != ''){
                                $attr_list[$key]['Currency_image'] = 'uploads/currency/'.$currencydetail[0]['image'];

                            }
                            if($currencydetail[0]['Price'] != ''){
                                $final_FromPrice = ($value['FromPrice']*$currencydetail[0]['Price']);                            
                                $final_ToPrice = ($value['ToPrice']*$currencydetail[0]['Price']);
                            }  

                        }                          
                        $show_text = '<img width="20" src="'.base_url().$attr_list[$key]["Currency_image"].'"> ';
                        $show_text .= $final_FromPrice;
                        $show_text .= " - ".'<img width="20" src="'.base_url().$attr_list[$key]["Currency_image"].'"> ';
                        $show_text .= $final_ToPrice;
                        $show_text .= "(".$pro_total.")";
                        $attr_list[$i]['show_text'] = $show_text;
                        $i++;
                           
                        
                       
                    
                }
                $this->response(array("status" => "Success", "response_code" => 200,"message"=>"Models Fetched Successfully", "result" =>$attr_list), 200);  
            }else{
                $this->response(array("status" => "Failed", "response_code" => 200, "message"=>"Data Not available" , "result" =>''), 200);
            }
            
    }

    /* mileage product Filters List */
    public function mileageFilterAttributes_post()
    {
            $cat_id = $this->post("category_id");
            $product_type = $this->post("product_type"); 
            $wh = array('CategoryId'=>$cat_id,"Status"=>1);
            $attrlistdetail = $this->Webapi_model->get_data_where("tbl_mas_mileage",$wh);
          
            if(!empty($attrlistdetail)){
                $attr_list = array();
                $i = 0;
                foreach($attrlistdetail as $key => $value) { 
                    $wh = array('CategoryID'=>$cat_id,"Rental"=>$product_type);
                    $data['From_mileage'] = $value['From_mileage'];
                    $data['To_mileage'] = $value['To_mileage'];
                    $pro_total = $this->Webapi_model->get_total_mileageproduct($wh,$data)[0]['Total'];
                   
                    //if($pro_total >0){
                        $attr_list[$i] = $value;
                        $attr_list[$i]['show_text'] = $value['From_mileage']." mi - ".$value['To_mileage'] ." mi (".$pro_total.")";
                        $i++;
                    //}
                }
                $this->response(array("status" => "Success", "response_code" => 200,"message"=>"Models Fetched Successfully", "result" =>$attr_list), 200);  
            }else{
                 $this->response(array("status" => "Failed", "response_code" => 200, "message"=>"Data Not available" , "result" =>''), 200);
            }
            
    }

     /* LivingArea product Filters List */
     public function livingAreaFilterAttributes_post()
     {
            $cat_id = $this->post("category_id");
            $product_type = $this->post("product_type"); 
           
            
            $wh = array('CategoryId'=>$cat_id,"Status"=>1);
            $attrlistdetail = $this->Webapi_model->get_data_where("tbl_mas_livingarea",$wh);
         
            if(!empty($attrlistdetail)){
                $attr_list = array();
                $i = 0;
                foreach($attrlistdetail as $key => $value) { 
                    $wh = array('CategoryID'=>$cat_id,"Rental"=>$product_type);
                    $data['FromAreaRange'] = $value['FromAreaRange'];
                    $data['ToAreaRange'] = $value['ToAreaRange'];
                    $pro_total = $this->Webapi_model->get_total_livingareaproduct($wh,$data)[0]['Total'];
                   
                    $attr_list[$i] = $value;
                    $attr_list[$i]['show_text'] = $value['FromAreaRange']." sqm - ".$value['ToAreaRange'] ." sqm (".$pro_total.")";
                    $i++;
                   
                }
                $this->response(array("status" => "Success", "response_code" => 200,"message"=>"Models Fetched Successfully", "result" =>$attr_list), 200);  
            }else{
                $this->response(array("status" => "Failed", "response_code" => 200, "message"=>"Data Not available" , "result" =>''), 200);
            }
            
    }

    /* Hull Material product Filters List*/
    public function hullMaterialFilterAttributes_post()
    {
            $cat_id = $this->post("category_id");
            $product_type = $this->post("product_type");
           
            
            $wh = array('CategoryID'=>$cat_id,"Rental"=>$product_type,"Status"=>1);
            if($this->post("brand_id") != ''){
                $wh['BrandID'] = $this->post("brand_id");
            }
            $attrlistdetail = $this->Webapi_model->get_attrfromproductdata($wh,"Hullmaterial");
            
            if(!empty($attrlistdetail)){
                $attr_list = array();
                $i = 0;
                foreach($attrlistdetail as $key => $value) { 
                    $wh['Hullmaterial'] = $value['attr'];
                    $pro_total = $this->Webapi_model->get_total_product($wh)[0]['Total'];
                    if($pro_total >0){
                        $attr_list[$i] = $value;
                        $attr_list[$i]['show_text'] = $value['attr']." (".$pro_total.")";
                        $i++;
                    }
                }
                $this->response(array("status" => "Success", "response_code" => 200,"message"=>"Models Fetched Successfully", "result" =>$attr_list), 200);  
            }else{
                $this->response(array("status" => "Failed", "response_code" => 200, "message"=>"Data Not available" , "result" =>''), 200);
            }
            
    }

    /* length product Filters List*/
    public function lengthFilterAttributes_post()
    {
        $cat_id = $this->post("category_id");
        $product_type = $this->post("product_type"); 
        
        
        $wh = array('CategoryId'=>$cat_id,"Status"=>1);
        $attrlistdetail = $this->Webapi_model->get_data_where("tbl_mas_length",$wh);
        
        if(!empty($attrlistdetail)){
            $attr_list = array();
            $i = 0;
            foreach($attrlistdetail as $key => $value) { 
                $wh = array('CategoryID'=>$cat_id,"Rental"=>$product_type);
                $data['FromLength'] = $value['FromLength'];
                $data['ToLength'] = $value['ToLength'];
                $pro_total = $this->Webapi_model->get_total_lengthproduct($wh,$data)[0]['Total'];
                
                $attr_list[$i] = $value;
                $attr_list[$i]['show_text'] = $value['FromLength']." ft - ".$value['ToLength'] ." ft (".$pro_total.")";
                $i++;
                
            }
            $this->response(array("status" => "Success", "response_code" => 200,"message"=>"Models Fetched Successfully", "result" =>$attr_list), 200);  
        }else{
             $this->response(array("status" => "Failed", "response_code" => 200, "message"=>"Data Not available" , "result" =>''), 200);
        }
              
    }

    /* Gender product Filters List*/
    public function genderFilterAttributes_post() 
    { 
            $cat_id = $this->post("category_id");   
            $product_type = $this->post("product_type");        
            
            $wh = array('CategoryID'=>$cat_id,"Rental"=>$product_type,"Status"=>1);
            if($this->post("brand_id") != ''){
                $wh['BrandID'] = $this->post("brand_id");
            }
            $attrlistdetail = $this->Webapi_model->get_attrfromproductdata($wh,"Gender");
            
            if(!empty($attrlistdetail)){
                $attr_list = array();
                $i = 0;
                foreach($attrlistdetail as $key => $value) { 
                    $wh['Gender'] = $value['attr'];
                    $pro_total = $this->Webapi_model->get_total_product($wh)[0]['Total'];
                    if($pro_total >0){
                        $attr_list[$i] = $value;
                        $attr_list[$i]['show_text'] = $value['attr']." (".$pro_total.")";
                        $i++;
                    }
                }
                $this->response(array("status" => "Success", "response_code" => 200,"message"=>"Models Fetched Successfully", "result" =>$attr_list), 200);  
            }else{
                 $this->response(array("status" => "Failed", "response_code" => 200, "message"=>"Data Not available" , "result" =>''), 200);
            }
            
    }

    /* Case Material product Filters List*/
    public function casematerialFilterAttributes_post() 
    { 
            $cat_id = $this->post("category_id");   
            $product_type = $this->post("product_type");        
            
            $wh = array('CategoryID'=>$cat_id,"Rental"=>$product_type,"Status"=>1);
            if($this->post("brand_id") != ''){
                $wh['BrandID'] = $this->post("brand_id");
            }
            $attrlistdetail = $this->Webapi_model->get_attrfromproductdata($wh,"CaseMaterial");
            
            if(!empty($attrlistdetail)){
                $attr_list = array();
                $i = 0;
                foreach($attrlistdetail as $key => $value) { 
                    $wh['CaseMaterial'] = $value['attr'];
                    $pro_total = $this->Webapi_model->get_total_product($wh)[0]['Total'];
                    if($pro_total >0){
                        $attr_list[$i] = $value;
                        $attr_list[$i]['show_text'] = $value['attr']." (".$pro_total.")";
                        $i++;
                    }
                }
                $this->response(array("status" => "Success", "response_code" => 200,"message"=>"Models Fetched Successfully", "result" =>$attr_list), 200);  
            }else{
                 $this->response(array("status" => "Failed", "response_code" => 200, "message"=>"Data Not available" , "result" =>''), 200);
            }
            
    }
    /* Strap Material product Filters List*/
    public function strapmaterialFilterAttributes_post() 
    { 
            $cat_id = $this->post("category_id");   
            $product_type = $this->post("product_type");            
            $wh = array('CategoryID'=>$cat_id,"Rental"=>$product_type,"Status"=>1);
            if($this->post("brand_id") != ''){
                $wh['BrandID'] = $this->post("brand_id");
            }
            $attrlistdetail = $this->Webapi_model->get_attrfromproductdata($wh,"StrapMaterial");
            
            if(!empty($attrlistdetail)){
                $attr_list = array();
                $i = 0;
                foreach($attrlistdetail as $key => $value) { 
                    $wh['StrapMaterial'] = $value['attr'];
                    $pro_total = $this->Webapi_model->get_total_product($wh)[0]['Total'];
                    if($pro_total >0){
                        $attr_list[$i] = $value;
                        $attr_list[$i]['show_text'] = $value['attr']." (".$pro_total.")";
                        $i++;
                    }
                }
                $this->response(array("status" => "Success", "response_code" => 200,"message"=>"Models Fetched Successfully", "result" =>$attr_list), 200);  
            }else{
                 $this->response(array("status" => "Failed", "response_code" => 200, "message"=>"Data Not available" , "result" =>''), 200);
            }
            
    }
    /* Movement product Filters List*/
    public function movementFilterAttributes_post() 
    { 
            $cat_id = $this->post("category_id");   
            $product_type = $this->post("product_type");            
            $wh = array('CategoryID'=>$cat_id,"Rental"=>$product_type,"Status"=>1);
            if($this->post("brand_id") != ''){
                $wh['BrandID'] = $this->post("brand_id");
            }
            $attrlistdetail = $this->Webapi_model->get_attrfromproductdata($wh,"Movement");
            
            if(!empty($attrlistdetail)){
                $attr_list = array();
                $i = 0;
                foreach($attrlistdetail as $key => $value) { 
                    $wh['Movement'] = $value['attr'];
                    $pro_total = $this->Webapi_model->get_total_product($wh)[0]['Total'];
                    if($pro_total >0){
                        $attr_list[$i] = $value;
                        $attr_list[$i]['show_text'] = $value['attr']." (".$pro_total.")";
                        $i++;
                    }
                }
                $this->response(array("status" => "Success", "response_code" => 200,"message"=>"Models Fetched Successfully", "result" =>$attr_list), 200);  
            }else{
                 $this->response(array("status" => "Failed", "response_code" => 200, "message"=>"Data Not available" , "result" =>''), 200);
            }
            
    }

    /* Authenticity product Filters List*/
    public function authenticityFilterAttributes_post() 
    {
            $cat_id = $this->post("category_id");   
            $product_type = $this->post("product_type");           
            $wh = array('CategoryID'=>$cat_id,"Rental"=>$product_type,"Status"=>1);
            if($this->post("brand_id") != ''){
                $wh['BrandID'] = $this->post("brand_id");
            }
            $attrlistdetail = $this->Webapi_model->get_attrfromproductdata($wh,"Authenticity");            
            if(!empty($attrlistdetail)){
                $attr_list = array();
                $i = 0;
                foreach($attrlistdetail as $key => $value) { 
                    $wh['Authenticity'] = $value['attr'];
                    $pro_total = $this->Webapi_model->get_total_product($wh)[0]['Total'];
                    if($pro_total >0){
                        $attr_list[$i] = $value;
                        $attr_list[$i]['show_text'] = $value['attr']." (".$pro_total.")";
                        $i++;
                    }
                }
                $this->response(array("status" => "Success", "response_code" => 200,"message"=>"Models Fetched Successfully", "result" =>$attr_list), 200);  
            }else{
                $this->response(array("status" => "Failed", "response_code" => 200, "message"=>"Data Not available" , "result" =>''), 200);
            }
            
    }
    /* Main Stone product Filters List*/
    public function mainstoneFilterAttributes_post() 
    { 
            $cat_id = $this->post("category_id");   
            $product_type = $this->post("product_type");        
            
            $wh = array('CategoryID'=>$cat_id,"Rental"=>$product_type,"Status"=>1);
            if($this->post("brand_id") != ''){
                $wh['BrandID'] = $this->post("brand_id");
            }
            $attrlistdetail = $this->Webapi_model->get_attrfromproductdata($wh,"Mainstone");
            
            if(!empty($attrlistdetail)){
                $attr_list = array();
                $i = 0;
                foreach($attrlistdetail as $key => $value) { 
                    $wh['Mainstone'] = $value['attr'];
                    $pro_total = $this->Webapi_model->get_total_product($wh)[0]['Total'];
                    if($pro_total >0){
                        $attr_list[$i] = $value;
                        $attr_list[$i]['show_text'] = $value['attr']." (".$pro_total.")";
                        $i++;
                    }
                }
                $this->response(array("status" => "Success", "response_code" => 200,"message"=>"Models Fetched Successfully", "result" =>$attr_list), 200);  
            }else{
                $this->response(array("status" => "Failed", "response_code" => 200, "message"=>"Data Not available" , "result" =>''), 200);
            }
            
    }
    
    /* Main materiale product Filters List*/
    public function mainmaterialeFilterAttributes_post() 
    { 
            $cat_id = $this->post("category_id");   
            $product_type = $this->post("product_type");        
            
            $wh = array('CategoryID'=>$cat_id,"Rental"=>$product_type,"Status"=>1);
            if($this->post("brand_id") != ''){
                $wh['BrandID'] = $this->post("brand_id");
            }
            $attrlistdetail = $this->Webapi_model->get_attrfromproductdata($wh,"main_material");
            
            if(!empty($attrlistdetail)){
                $attr_list = array();
                $i = 0;
                foreach($attrlistdetail as $key => $value) { 
                    $wh['main_material'] = $value['attr'];
                    $pro_total = $this->Webapi_model->get_total_product($wh)[0]['Total'];
                    if($pro_total >0){
                        $attr_list[$i] = $value;
                        $attr_list[$i]['show_text'] = $value['attr']." (".$pro_total.")";
                        $i++;
                    }
                }
                $this->response(array("status" => "Success", "response_code" => 200,"message"=>"Models Fetched Successfully", "result" =>$attr_list), 200);  
            }else{
               $this->response(array("status" => "Failed", "response_code" => 200, "message"=>"Data Not available" , "result" =>''), 200);
            }
            
    }


      /* Main Metal Color product Filters List*/
     public function mainmetalcolorFilterAttributes_post()
     {
         $cat_id = $this->post("category_id");
         $product_type = $this->post("product_type");
         $wh = array('CategoryID'=>$cat_id,"Rental"=>$product_type);
         if($this->post("brand_id") != ''){
                $wh['BrandID'] = $this->post("brand_id");
         }
         $attrlistdetail = $this->Webapi_model->get_interiorcolorattrdata($wh,'metal_color');        
         if(!empty($attrlistdetail)){
             $attr_list = array();
             $i = 0;
             foreach($attrlistdetail as $key => $value) { 
                 $wh['metal_color'] = $value['ID'];
                 $pro_total = $this->Webapi_model->get_total_product($wh)[0]['Total'];
                 if($pro_total >0){
                     $attr_list[$i] = $value;
                     $attr_list[$i]['show_text'] = $value['InteriorColor']."(".$pro_total.")";
                     $i++;
                 }
             }
             $this->response(array("status" => "Success", "response_code" => 200,"message"=>"Models Fetched Successfully", "result" =>$attr_list), 200);  
         }else{
             $this->response(array("status" => "Failed", "response_code" => 200, "message"=>"Data Not available" , "result" =>''), 200);
         }
         
     }

       /* Stonecolor product Filters List*/
     public function stonecolorFilterAttributes_post()
     {
         $cat_id = $this->post("category_id");
         $product_type = $this->post("product_type");
      
         
         $wh = array('CategoryID'=>$cat_id,"Rental"=>$product_type);
         if($this->post("brand_id") != ''){
                $wh['BrandID'] = $this->post("brand_id");
            }
         $attrlistdetail = $this->Webapi_model->get_interiorcolorattrdata($wh,'Stonecolor');
        
         if(!empty($attrlistdetail)){
             $attr_list = array();
             $i = 0;
             foreach($attrlistdetail as $key => $value) {
                 $wh['Stonecolor'] = $value['ID'];
                 $pro_total = $this->Webapi_model->get_total_product($wh)[0]['Total'];
                 if($pro_total >0){
                     $attr_list[$i] = $value;
                     $attr_list[$i]['show_text'] = $value['InteriorColor']."(".$pro_total.")";
                     $i++;
                 }
             }
             $this->response(array("status" => "Success", "response_code" => 200,"message"=>"Models Fetched Successfully", "result" =>$attr_list), 200);  
         }else{
             $this->response(array("status" => "Failed", "response_code" => 200, "message"=>"Data Not available" , "result" =>''), 200);
         }
         
     }

     /*View all car filter product list*/
     public function carfilterProducts_post() 
     {
         /* for rent product_type ="Rent" , for sale product_type = "Sale"*/
        
         $limit = '';
         $product_type = $this->post('product_type'); 
         $limit = $this->post('limit'); 
         if($product_type != ''){  
             $data['CategoryID'] = $this->decrypt_ID($this->post('category_id'));
             $data['Rental'] = $product_type; 
             $data['keyword'] = $this->post('keyword');
             $data['BrandID'] = $this->post('brand_id');
             $data['ModelID'] = $this->post('model_id');
             $data['TypeID'] = $this->post('type_id'); 
             $data['ColorID'] = $this->post('color_id'); 
             $data['InteriorColorID'] = $this->post('incolor_id');              
             $data['DriveId'] = $this->post('drive_id');
             if($this->post('country_id')!='0'){
                $data['CountriesID'] = $this->post('country_id');
             }
             $data['StatesID'] = $this->post('state_id'); 
             $data['FromPrice'] = $this->post('from_price');
             $data['ToPrice'] = $this->post('to_price');
             $data['From_mileage'] = $this->post('from_mileage');
             $data['To_mileage'] = $this->post('to_mileage');
             $data['CityID'] = $this->post('city');         
             $pro_list=$this->Webapi_model->filter_product($data,$limit);    
             if(count($pro_list)>0){
                $today = date("Y-m-d");
                foreach($pro_list as $key=>$list1){
                     if($list1['offer_validity']<$today){
                         $pro_list[$key]['offer_validity']= '';
                     }else{
                         $pro_list[$key]['offer_validity']= date("d/m/Y",strtotime($list1['offer_validity']));
                     }
                     if($list1['DImage'] != ''){
                          $pro_list[$key]['DImage']='uploads/products/default/'.$list1['DImage'];
                          
                     }else{
                          $pro_list[$key]['DImage']= "uploads/No_Image_Available.png";
                     }
                     $pro_list[$key]['ID']=$this->encrypt_ID($pro_list[$key]['ID']);
                      $pro_list[$key]['ConCode']= strtolower($pro_list[$key]['ConCode']);

                 }
                 $this->response(array("status" => "Success", "response_code" => 200,"message"=>"Models Fetched Successfully", "result" =>$pro_list), 200);  
             }else{
                /* $this->response(array(), 200); */
                    $this->response(array("status" => "Success", "response_code" => 200, "message"=>"Data Not available" , "result" =>''), 200);
             }      
         }else{
             $this->response(array("status" => "Failed", "response_code" => 200,"message"=>"Failed", "result" =>''), 200);
         }     
        
     }
     

     /*View all realstate filter product list*/
     public function realstatefilterProducts_post() 
     {
         /* for rent product_type ="Rent" , for sale product_type = "Sale"*/
         $limit = '';
         $product_type = $this->post('');          
         $limit = $this->post('limit'); 
 
         if($product_type != ''){  
             $data['keyword'] = $this->post('keyword');
             $data['CategoryID'] = $this->decrypt_ID($this->post('category_id'));
             $data['Rental'] = $product_type; 
             $data['CountriesID'] = $this->post('country_id'); 
             $data['StatesID'] = $this->post('state_id'); 
             $data['FromPrice'] = $this->post('from_price');             
             $data['ToPrice'] = $this->post('to_price');
             $data['TypeID'] = $this->post('type_id');
             $data['FromAreaRange'] = $this->post('from_area');             
             $data['ToAreaRange'] = $this->post('to_area');
            
             $pro_list=$this->Webapi_model->filter_product($data,$limit);        
             
            if(count($pro_list)>0){
                $today = date("Y-m-d");
                foreach($pro_list as $key=>$list1){
                     if($list1['offer_validity']<$today){
                         $pro_list[$key]['offer_validity']= '';
                     }else{
                         $pro_list[$key]['offer_validity']= date("d/m/Y",strtotime($list1['offer_validity']));
                     }
                     if($list1['DImage'] != ''){
                          $pro_list[$key]['DImage']='uploads/products/default/'.$list1['DImage'];
                          
                     }else{
                          $pro_list[$key]['DImage']= "uploads/No_Image_Available.png";
                     }
                     
                     if($list1['Currency_image'] != ''){
                        $pro_list[$key]['Currency_image'] = 'uploads/currency/'.$list1['Currency_image'];
                     }
                    
                     if($list1['Currency_price'] != '' && is_numeric ($list1['Price'])){
                        $pro_list[$key]['Price_in_curreny'] = ($list1['Currency_price']*$list1['Price']);
                     }else{
                        $pro_list[$key]['Price_in_curreny'] = '';
                     }                   
                     
                 }
                 $this->response(array("status" => "Success", "response_code" => 200,"message"=>"Models Fetched Successfully", "result" =>$pro_list), 200); 
             }else{
                 $this->response(array(), 200);
             }      
         }else{           
             $this->response(array("status" => "Failed", "response_code" => 204,"message"=>"Failed", "result" =>''), 204);
         }     
        
     } 
     
     /*View all yatch filter product list*/
     public function yachtfilterProducts_post() 
     {
          $limit = '';
          $product_type = $this->post('product_type');          
          $limit = $this->post('limit');  
          if($product_type != ''){
              $data['CategoryID'] = $this->decrypt_ID($this->post('category_id'));
              $data['Rental'] = $product_type; 
              $data['keyword'] = $this->post('keyword');
              $data['BrandID'] = $this->post('brand_id');
              $data['ModelID'] = $this->post('model_id');
              $data['CountriesID'] = $this->post('country_id'); 
              $data['StatesID'] = $this->post('state_id'); 
              $data['FromPrice'] = $this->post('from_price');             
              $data['ToPrice'] = $this->post('to_price');
              $data['TypeID'] = $this->post('type_id');
              $data['FromLength'] = $this->post('from_length');             
              $data['ToLength'] = $this->post('to_length');
              $data['Hullmaterial'] = $this->post('hull_material');             
              $pro_list=$this->Webapi_model->filter_product($data,$limit);       
              
             if(count($pro_list)>0){
                 $today = date("Y-m-d");
                 foreach($pro_list as $key=>$list1){
                      if($list1['offer_validity']<$today){
                          $pro_list[$key]['offer_validity']= '';
                      }else{
                          $pro_list[$key]['offer_validity']= date("d/m/Y",strtotime($list1['offer_validity']));
                      }
                      if($list1['DImage'] != ''){
                           $pro_list[$key]['DImage']='uploads/products/default/'.$list1['DImage'];
                           
                      }else{
                           $pro_list[$key]['DImage']= "uploads/No_Image_Available.png";
                      }
                      
                      /*if($list1['Currency_image'] != ''){
                         $pro_list[$key]['Currency_image'] = 'uploads/currency/'.$list1['Currency_image'];
                      }
                     
                      if($list1['Currency_price'] != '' && is_numeric ($list1['Price'])){
                         $pro_list[$key]['Price_in_curreny'] = ($list1['Currency_price']*$list1['Price']);
                      }else{
                         $pro_list[$key]['Price_in_curreny'] = '';
                      }*/
                     
                      
                  }
                  $this->response(array("status" => "Success", "response_code" => 200,"message"=>"Models Fetched Successfully", "result" =>$pro_list), 200); 
              }else{
                  $this->response(array(), 200);
              }      
          }else{           
              $this->response(array("status" => "Failed", "response_code" => 204,"message"=>"Failed", "result" =>''), 204);
          }     
         
     } 

     /*View all watch filter product list*/
     public function watchfilterProducts_post() 
     {
          $limit = '';
          $product_type = $this->post('product_type');          
          $limit = $this->post('limit');   
          if($product_type != ''){
              $data['CategoryID'] = $this->decrypt_ID($this->post('category_id'));
              $data['Rental'] = $product_type;
              $data['keyword'] = $this->post('keyword');
              $data['BrandID'] = $this->post('brand_id');
              $data['ModelID'] = $this->post('model_id');
              $data['FromYear'] = $this->post('from_year');
              $data['ToYear'] = $this->post('to_year');
              $data['Gender'] = $this->post('gender');
              $data['CountriesID'] = $this->post('country_id'); 
              $data['StatesID'] = $this->post('state_id');               
              $data['ColorID'] = $this->post('dial_color_id'); 
              $data['InteriorColorID'] = $this->post('strap_color_id'); 
              $data['CaseMaterial'] = $this->post('case_material');
              $data['StrapMaterial'] = $this->post('strap_material');
              $data['Movement'] = $this->post('movement');
              $data['Authenticity'] = $this->post('authenticity');
              $data['FromPrice'] = $this->post('from_price');      
              $data['ToPrice'] = $this->post('to_price');
              $pro_list=$this->Webapi_model->filter_product($data,$limit);
             if(count($pro_list)>0){
                 $today = date("Y-m-d");
                 foreach($pro_list as $key=>$list1){
                      if($list1['offer_validity']<$today){
                          $pro_list[$key]['offer_validity']= '';
                      }else{
                          $pro_list[$key]['offer_validity']= date("d/m/Y",strtotime($list1['offer_validity']));
                      }
                      if($list1['DImage'] != ''){
                           $pro_list[$key]['DImage']='uploads/products/default/'.$list1['DImage'];
                           
                      }else{
                           $pro_list[$key]['DImage']= "uploads/No_Image_Available.png";
                      }
                      
                     /* if($list1['Currency_image'] != ''){
                         $pro_list[$key]['Currency_image'] = 'uploads/currency/'.$list1['Currency_image'];
                      }
                      
                      if($list1['Currency_price'] != '' && is_numeric ($list1['Price'])){
                         $pro_list[$key]['Price_in_curreny'] = ($list1['Currency_price']*$list1['Price']);
                      }else{
                         $pro_list[$key]['Price_in_curreny'] = '';
                      }*/
                     
                      
                  }
                  $this->response(array("status" => "Success", "response_code" => 200,"message"=>"Models Fetched Successfully", "result" =>$pro_list), 200); 
              }else{
                  $this->response(array(), 200);
              }      
          }else{           
              $this->response(array("status" => "Failed", "response_code" => 204,"message"=>"Failed", "result" =>''), 204);
          }     
         
     } 

      /*View all jewelry filter product list*/
     public function jewelryfilterProducts_post() 
     {
          $limit = '';
          $product_type = $this->post('product_type');          
          $limit = $this->post('limit'); 
  
          if($product_type != ''){                
              $data['CategoryID'] = $this->decrypt_ID($this->post('category_id'));
              $data['Rental'] = $product_type; 

              $data['keyword'] = $this->post('keyword');
              $data['BrandID'] = $this->post('brand_id');
              $data['ModelID'] = $this->post('model_id'); 
              $data['TypeID'] = $this->post('type_id');
              $data['FromPrice'] = $this->post('from_price');      
              $data['ToPrice'] = $this->post('to_price'); 
              $data['CountriesID'] = $this->post('country_id'); 
              $data['StatesID'] = $this->post('state_id');   
              $data['Mainstone'] = $this->post('main_stone');
              $data['main_material'] = $this->post('main_material');     
              $data['Stonecolor'] = $this->post('stone_color_id'); 
              $data['metal_color'] = $this->post('metal_color_id');
              $data['Gender'] = $this->post('gender');     
              
             
              $pro_list=$this->Webapi_model->filter_product($data,$limit);        
              
             if(count($pro_list)>0){
                 $today = date("Y-m-d");
                 foreach($pro_list as $key=>$list1){
                      if($list1['offer_validity']<$today){
                          $pro_list[$key]['offer_validity']= '';
                      }else{
                          $pro_list[$key]['offer_validity']= date("d/m/Y",strtotime($list1['offer_validity']));
                      }
                      if($list1['DImage'] != ''){
                           $pro_list[$key]['DImage']='uploads/products/default/'.$list1['DImage'];
                           
                      }else{
                           $pro_list[$key]['DImage']= "uploads/No_Image_Available.png";
                      }
                      
                     /* if($list1['Currency_image'] != ''){
                         $pro_list[$key]['Currency_image'] = 'uploads/currency/'.$list1['Currency_image'];
                      }
                     
                      if($list1['Currency_price'] != '' && is_numeric ($list1['Price'])){
                         $pro_list[$key]['Price_in_curreny'] = ($list1['Currency_price']*$list1['Price']);
                      }else{
                         $pro_list[$key]['Price_in_curreny'] = '';
                      }*/
                     
                      
                  }
                  $this->response(array("status" => "Success", "response_code" => 200,"message"=>"Models Fetched Successfully", "result" =>$pro_list), 200); 
              }else{
                  $this->response(array("status" => "Failed", "response_code" => 200,"message"=>"NO Record Found", "result" =>""), 200);
                  
              }      
          }else{           
              $this->response(array("status" => "Failed", "response_code" => 204,"message"=>"Failed", "result" =>''), 204);
          }     
         
     }
     
     public function user_saved_listings_post(){
        if(!empty($_POST)){
            $id=$_POST['user_id'];
             $list=$this->Webapi_model->get_data_where('tbl_products',array("User_id"=>$id));
             if(!empty($list)){
                $this->response(array("status" => "Success", "response_code" => 200,"message"=>"Products Fetched Successfully", "result" =>$list), 200);
             }else{
                  $this->response(array("status" => "Failed", "response_code" => 200,"message"=>"NO Record Found", "result" =>""), 200);
           }
        }
     }

      /*View all lifestyle filter product list*/
     public function lifestylefilterProducts_post() 
     {
          $limit = '';
          $product_type = $this->post('product_type');          
          $limit = $this->post('limit'); 
  
          if($product_type != ''){                
              $data['CategoryID'] = $this->decrypt_ID($this->post('category_id'));
              $data['Rental'] = $product_type; 
              $data['keyword'] = $this->post('keyword');
              $data['TypeID'] = $this->post('type_id');
              $data['FromPrice'] = $this->post('from_price');      
              $data['ToPrice'] = $this->post('to_price'); 
              $data['CountriesID'] = $this->post('country_id'); 
              $data['StatesID'] = $this->post('state_id');  
              $pro_list=$this->Webapi_model->filter_product($data,$limit);        
              
             if(count($pro_list)>0){
                 $today = date("Y-m-d");
                 foreach($pro_list as $key=>$list1){
                      if($list1['offer_validity']<$today){
                          $pro_list[$key]['offer_validity']= '';
                      }else{
                          $pro_list[$key]['offer_validity']= date("d/m/Y",strtotime($list1['offer_validity']));
                      }
                      if($list1['DImage'] != ''){
                           $pro_list[$key]['DImage']='uploads/products/default/'.$list1['DImage'];
                           
                      }else{
                           $pro_list[$key]['DImage']= "uploads/No_Image_Available.png";
                      }                      
                      if($list1['Currency_image'] != ''){
                         $pro_list[$key]['Currency_image'] = 'uploads/currency/'.$list1['Currency_image'];
                      }
                      if($list1['Currency_price'] != '' && is_numeric ($list1['Price'])){
                         $pro_list[$key]['Price_in_curreny'] = ($list1['Currency_price']*$list1['Price']);
                      }else{
                         $pro_list[$key]['Price_in_curreny'] = '';
                      }
                  }
                  $this->response(array("status" => "Success", "response_code" => 200,"message"=>"Models Fetched Successfully", "result" =>$pro_list), 200); 
              }else{
                  $this->response(array("status" => "Failed", "response_code" => 200,"message"=>"NO Record Found", "result" =>""), 200);
              }      
          }else{           
              $this->response(array("status" => "Failed", "response_code" => 204,"message"=>"Failed", "result" =>''), 204);
          }     
         
     }
/*shakti*/
 /*View all filte product list*/
    public function all_filter_products_post() 
    {
        /* for rent product_type ="Rent" , for sale product_type = "Sale"*/
       
        $limit = '';
        $popular_type = $this->post('popular_type');
        $product_type = $this->post('product_type'); 
        $category_id = $this->decrypt_ID($this->post('category_id'));
        $limit = $this->post('limit'); 
        $currency_id = $this->post('currency_id');
		$opttype=$this->post('opttype');
		
		$originalDate = $this->post('fromdate');
		$fromdate = date("Y", strtotime($originalDate));
		
		$ToDates =$this->post('todate');
		$todate = date("Y", strtotime($ToDates));
        if($product_type != ''){
            if($category_id != ''){
                $categories = array($category_id);
            }else{
                $categories = array(watch_category_ID,lifestyle_category_ID,extraordinary_category_ID,motorcycle_category_ID,car_category_ID,realstate_category_ID,yachts_category_ID,jewelry_category_ID);
            }
            $orderby = "p.ID";
            if($popular_type != ''){
                $orderby = "p.no_of_views";
            }
			$filter = array();
			if($opttype != ''){
				$filter['TypeID'] = $opttype;
				
			}
			if($fromdate != ''){
				$filter['fromYear'] =$fromdate;
				
			}
			if($todate != ''){
				$filter['toYear'] = $todate;
				
			}
              $cat=$this->Webapi_model->all_most_filter_popular_product($categories ,$product_type,$limit,$orderby,$filter);                
            
           if(count($cat)>0){
                $today = date("Y-m-d");
               foreach($cat as $key=>$list1){
                    if($list1['offer_validity']<$today){
                        $cat[$key]['offer_validity']= '';
                    }else{
                        $cat[$key]['offer_validity']= date("d/m/Y",strtotime($list1['offer_validity']));
                    }
                    if($list1['DImage'] != ''){
                         $cat[$key]['DImage']='uploads/products/default/'.$list1['DImage'];
                         
                    }else{
                         $cat[$key]['DImage']= "uploads/No_Image_Available.png";
                    } 
                } 
                 $this->response(array("status" => "Success", "response_code" => 200,"message"=>"Products Fetched Successfully", "result" =>$cat), 200);
             }else{
                 $this->response(array("status" => "Success", "response_code" => 200, "message"=>"Data Not available" , "result" =>''), 200);
            }      
        }else{           
             $error = array('status' => "Failed", "response_code" => 400, "message"=>"Please select product type (Rent or Sale).","result" => "" );
            $this->response($error, 400);
        }     
       
    } 
	 
	 
	  /*View all papular product list*/
    public function all_car_filter_products_post() 
    {
        /* for rent product_type ="Rent" , for sale product_type = "Sale"*/       
        $limit = '';        
        $category_id = car_category_ID;
        $product_type = $this->post('product_type'); 
        $type_id = $this->post('type_id');
        $from_date = $this->post('from_date');
        $to_date = $this->post('to_date');
        $liproduct_typemit = $this->post('limit');
        if($product_type != ''){
        $filter = array();
            if($category_id != ''){
                $filter['category'] = $category_id;
            }
            if($product_type != ''){
                $filter['product_type'] = $product_type;
            }
            if($type_id != ''){
                $filter['type_id'] = $type_id;
            }         
            $cat=$this->Webapi_model->all_car_filter_product($filter,$limit);			
           if(count($cat)>0){
                $today = date("Y-m-d");
               foreach($cat as $key=>$list1){                   
                    if($list1['DImage'] != ''){
                         $cat[$key]['DImage']='uploads/products/default/'.$list1['DImage'];
                         
                    }else{
                         $cat[$key]['DImage']= "uploads/No_Image_Available.png";
                    }  
                } 
				  $this->response(array("status" => "Success", "response_code" => 200,"message"=>"Product Fetched Successfully", "result" =>$cat), 200);
            }else{
              $this->response(array("status" => "Failed", "response_code" => 200,"message"=>"Failed", "result" =>''), 200);
            }      
        }else{           
            $this->response(array("status" => "Failed", "response_code" => 204,"message"=>"Failed", "result" =>''), 204);
        }       
    }
    
    
    /*video*/
    public function videos_post() 
    {
       $category_id = $this->decrypt_ID($this->post('category_id'));
       
		if( $category_id!=''){
            if($category_id=='all'){
                $category_id=$category_id;         
           }else{
                 $category_id= $category_id;
               }
            $cat=$this->Webapi_model->get_video($category_id);
        
           if(count($cat)>0){
               foreach($cat as $key=>$list1){				   
                    if($list1['video_name'] != ''){
                         $cat[$key]['video_name']='uploads/videos/'.$list1['video_name'];
                    }else{
						$cat[$key]['video_name']= "uploads/No_Image_Available.png";
                        }
					if($list1['image_name'] != ''){					
                        $cat[$key]['image_name']='uploads/videos/'.$list1['image_name'];
                    } else{					
						$cat[$key]['image_name']= "uploads/No_Image_Available.png";			   
					}
			   }
          
                 $this->response(array("status" => "Success", "response_code" => 200,"message"=>"Products Fetched Successfully", "result" =>array_shift($cat)), 200);
             }else{
                 $this->response(array("status" => "Success", "response_code" => 200, "message"=>"Data Not available" , "result" =>''), 200);
            }      
        }else{           
             $error = array('status' => "Failed", "response_code" => 400, "message"=>"Please select product type (Rent or Sale).","result" => "" );
            $this->response($error, 400);
        }       
    }
    
    
    
 /*footer menu*/
    public function footermenu_post() 
    {
		$land=$_POST['lang'];
       	$footer=$this->Webapi_model->get_footermenu();
		if(count($footer)>0){
         foreach($footer as $key=>$list1){				   
                    if($land == 'en'){						
                      $footer[$key]['name']=$list1['en_name'];                         
                    }else{						
				    $footer[$key]['name']=$list1['ar_name'];
					}					
			   }			
            $this->response(array("status" => "Success", "response_code" => 200,"message"=>"Products Fetched Successfully", "result" =>$footer), 200);
        }else{
             $this->response(array("status" => "Success", "response_code" => 200, "message"=>"Data Not available" , "result" =>''), 200);
       }
    }
    
 /*footer menu*/
    public function footerprivacy_post() 
    {	
		$land=$_POST['lang'];
       	$footerp=$this->Webapi_model->get_footerprivacy();
		if(count($footerp)>0){
			foreach($footerp as $key=>$list1){
				   if($land == 'en'){
                      $footerp[$key]['name']=$list1['en_name'];
                    }else{
				    $footerp[$key]['name']=$list1['ar_name'];
					}
			   }
            $this->response(array("status" => "Success", "response_code" => 200,"message"=>"Products Fetched Successfully", "result" =>$footerp), 200);
        }else{
             $this->response(array("status" => "Success", "response_code" => 200, "message"=>"Data Not available" , "result" =>''), 200);
       }
    }
    
 	 /* Category lange */
    public function footerone_post()
    {       
		$lang=$this->post('lang');		
        $footero=$this->Webapi_model->get_footerone();    
        if(!empty($footero)) 
        {
            foreach($footero as $key => $one){				
				if($lang == 'en'){					 
					$one['first_download']=$one['en_first_download'];
					$one['second_found']=$one['en_second_found'];
					$one['second_have']=$one['en_second_have'];
					$one['thread_placeholder']=$one['en_thread_placeholder'];
					$one['thread_button']=$one['en_thread_button'];
					$one['fourd_copyright']=$one['en_fourd_copyright'];
                }else{						
				    $one['first_download']=$one['ar_first_download'];
					$one['second_found']=$one['ar_second_found'];
					$one['second_have']=$one['ar_second_have'];
					$one['thread_placeholder']=$one['ar_thread_placeholder'];
					$one['thread_button']=$one['ar_thread_button'];
					$one['fourd_copyright']=$one['ar_fourd_copyright'];
				}
			$footers[]=$one;
            }                                              
           $this->response(array("status" => "Success", "response_code" => 200,"message"=>"footer Fetched Successfully", "result" =>array_shift($footers)), 200);   
        }else{
          $this->response(array("status" => "Failed", "response_code" => 200,"message"=>"Data Not Available", "result" =>""), 200);              
        }        
    }
   
   /* categorys  lange */
    public function categorys_post()
    {       
		$lang=$this->post('lang');		
        $categorys=$this->Admin_model->get_data_where('tbl_category',array("show_in_header"=>1,"Status"=>1)); 
		if(!empty($categorys)) 
        {
            foreach($categorys as $key => $cat){
				
				 if($lang == 'en'){					 
					$cat['Category']=$cat['Category'];
                }else{						
				    $cat['Category']=$cat['ar_Category'];
				}
			
                if($cat['Image'] != ''){
                    $cat['Image']="uploads/category/default/".$cat['Image'];
                }else{
                    $cat['Image']= "uploads/No_Image_Available.png";
                }
                $cat['ID']= $this->encrypt_ID($cat['ID']);
                 $category[]=$cat;
            }                                              
           $this->response(array("status" => "Success", "response_code" => 200,"message"=>"Category Fetched Successfully", "result" =>$category), 200);   
        }else{
          $this->response(array("status" => "Failed", "response_code" => 200,"message"=>"Data Not Available", "result" =>""), 200);              
        }        
    }
    
/* get_mainmenu  lange */
    public function mainmenu_post()
    {       
		$lang=$this->post('lang');		
        $mainmenu=$this->Webapi_model->get_mainmenu();		
        if(!empty($mainmenu)) 
        {
            foreach($mainmenu as  $menu){				
				if($lang == 'en'){					 
					$menu['name']=$menu['en_name'];
                }else{						
				    $menu['name']=$menu['ar_name'];
				}
			   $menus[]=$menu;
            }                                              
           $this->response(array("status" => "Success", "response_code" => 200,"message"=>"menus Fetched Successfully", "result" =>$menus), 200);   
        }else{
          $this->response(array("status" => "Failed", "response_code" => 200,"message"=>"Data Not Available", "result" =>""), 200);              
        }        
    }
    
    
    
    /*get country list*/
    public function getCountryList_get(){
          $cntry=$this->Webapi_model->get_countrylist();
          $this->response(array("status" => "Success", "response_code" => 200,"message"=>"Countries Fetched Successfully", "result" =>$cntry), 200);
    }
	   public function getCountryCode_get(){
          $cntry=$this->Webapi_model->get_countrycode();
          $this->response(array("status" => "Success", "response_code" => 200,"message"=>"Countries Fetched Successfully", "result" =>$cntry), 200);
    }
    
   /*get state list*/
    public function getCityList_post(){
        $country_id=$this->post('country_id');    
         $state_id=$this->post('state_id');    
         if($country_id!=''){  
              $city=$this->Webapi_model->get_citylist($country_id);
          }

           if($state_id!=''){  
              $city=$this->Webapi_model->get_cityByStatelist($state_id);
          }
          if(!empty($city)){
          $this->response(array("status" => "Success", "response_code" => 200,"message"=>"City Fetched Successfully", "result" =>$city), 200);
          }else{
            $this->response(array("status" => "Failed", "response_code" => 200,"message"=>"Data Not Available", "result" =>""), 200);      
          }
    }



       /*get StateByCountry list*/
     public function getStateByCountryID_post(){
        $country_id=$this->post('country_id');        
          $state=$this->Webapi_model->get_statelist($country_id);

          if(!empty($state)){
          $this->response(array("status" => "Success", "response_code" => 200,"message"=>"State Fetched Successfully", "result" =>$state), 200);
          }else{
            $this->response(array("status" => "Failed", "response_code" => 200,"message"=>"Data Not Available", "result" =>""), 200);      
          }
    }
    
 
    
     /*get brands by category id*/
    public function getBrandByCategory_post(){
        $catgeory_id=$this->decrypt_ID($this->post('category_id'));        
          $brands=$this->Webapi_model->get_data_where("tbl_mas_brand",array("CategoryId"=>$catgeory_id));
          if(!empty($brands)){
            foreach($brands as $brnd){
                $bresult['value']=$brnd['ID'];
                $bresult['label']=$brnd['Brand'];
                $brandsall[]=$bresult;
            }
          $this->response(array("status" => "Success", "response_code" => 200,"message"=>"Brands Fetched Successfully", "result" =>$brandsall), 200);
          }else{
            $this->response(array("status" => "Failed", "response_code" => 200,"message"=>"Data Not Available", "result" =>""), 200);      
          }          
    }

     /*get model by brand id*/
    public function getModelByBrand_post(){
        $BrandId=$this->post('brand_id');        
          $brands=$this->Webapi_model->get_data_where("tbl_mas_model",array("BrandId"=>$BrandId));
          if(!empty($brands)){
            foreach($brands as $brnd){
                $bresult['value']=$brnd['ID'];
                $bresult['label']=$brnd['Model'];
                $brandsall[]=$bresult;
            }
          $this->response(array("status" => "Success", "response_code" => 200,"message"=>"Model Fetched Successfully", "result" =>$brandsall), 200);
          }else{
            $this->response(array("status" => "Failed", "response_code" => 200,"message"=>"Data Not Available", "result" =>""), 200);      
          }          
    }

    /*get Drive details*/
         public function getDrive_get(){
                  $DRIVE=$this->Webapi_model->get_data("tbl_mas_drive");
                  if(!empty($DRIVE)){
                    foreach($DRIVE as $drv){
                        $Dresult['value']=$drv['ID'];
                        $Dresult['label']=$drv['Drive'];
                        $Driveall[]=$Dresult;
                    }
                  $this->response(array("status" => "Success", "response_code" => 200,"message"=>"Model Fetched Successfully", "result" =>$Driveall), 200);
                  }else{
                    $this->response(array("status" => "Failed", "response_code" => 200,"message"=>"Data Not Available", "result" =>""), 200);      
                  }          
            }


        
        /*get Tags details*/
         public function getTags_get(){
             $tags=$this->Webapi_model->get_data("tbl_mas_tag");
                  if(!empty($tags)){
                    foreach($tags as $tag){
                        $Dresult['value']=$tag['Tag_ID'];
                        $Dresult['label']=$tag['tag_name'];
                        $Driveall[]=$Dresult;
                    }
                  $this->response(array("status" => "Success", "response_code" => 200,"message"=>"Tags Fetched Successfully", "result" =>$Driveall), 200);
                  }else{
                    $this->response(array("status" => "Failed", "response_code" => 200,"message"=>"Data Not Available", "result" =>""), 200);      
                  }           
         }
        

        /*get Year details*/
         public function getYear_get(){
                  $year=$this->Webapi_model->get_data("tbl_mas_year");
                  if(!empty($year)){
                    foreach($year as $drv){
                        $Dresult['value']=$drv['ID'];
                        $Dresult['label']=$drv['Year'];
                        $Driveall[]=$Dresult;
                    }
                  $this->response(array("status" => "Success", "response_code" => 200,"message"=>"Year Fetched Successfully", "result" =>$Driveall), 200);
                  }else{
                    $this->response(array("status" => "Failed", "response_code" => 200,"message"=>"Data Not Available", "result" =>""), 200);      
                  }          
            }


           
         /*get color details*/
         public function getColor_get(){
                  $color=$this->Webapi_model->get_data("tbl_mas_color");
                  if(!empty($color)){
                    foreach($color as $drv){
                        $Dresult['value']=$drv['ID'];
                        $Dresult['label']=$drv['Color'];
                        $colorall[]=$Dresult;
                    }
                  $this->response(array("status" => "Success", "response_code" => 200,"message"=>"color Fetched Successfully", "result" =>$colorall), 200);
                  }else{
                    $this->response(array("status" => "Failed", "response_code" => 200,"message"=>"Data Not Available", "result" =>""), 200);      
                  }          
            }


         /*get color details*/
         public function getInteriorColor_get(){
                  $color=$this->Webapi_model->get_data("tbl_mas_interior_color");
                  if(!empty($color)){
                    foreach($color as $drv){
                        $Dresult['value']=$drv['ID'];
                        $Dresult['label']=$drv['InteriorColor'];
                        $colorall[]=$Dresult;
                    }
                  $this->response(array("status" => "Success", "response_code" => 200,"message"=>"Interior color Fetched Successfully", "result" =>$colorall), 200);
                  }else{
                    $this->response(array("status" => "Failed", "response_code" => 200,"message"=>"Data Not Available", "result" =>""), 200);      
                  }          
            }

        /*get Type details*/
         public function getTypeByCategory_post(){
                 $categoryid=$this->decrypt_ID($this->post('category_id'));
                  $type=$this->Webapi_model->get_data_where("tbl_mas_type",array("CategoryId"=>$categoryid));
                  if(!empty($type)){
                    foreach($type as $drv){
                        $Dresult['value']=$drv['ID'];
                        $Dresult['label']=$drv['Type'];
                        $colorall[]=$Dresult;
                    }
                  $this->response(array("status" => "Success", "response_code" => 200,"message"=>"Type Fetched Successfully", "result" =>$colorall), 200);
                  }else{
                    $this->response(array("status" => "Failed", "response_code" => 200,"message"=>"Data Not Available", "result" =>""), 200);      
                  }          
            }
            
            
        /*Get Landing page video */            
        public function LandingPageVideo_get(){
                        $slider=$this->Webapi_model->get_data_where("landingpage_videos",array("status"=>1));
                         if(!empty($slider)){
                          foreach($slider as $sld){
                                /*$Dresult['id']=$sld['id'];*/
                                if($sld['position']=='right'){
                                     $Dresult['video_name_right']='uploads/videos/'.$sld['video_name'];
                                }
                                 if($sld['position']=='left'){
                                     $Dresult['video_name_left']='uploads/videos/'.$sld['video_name'];
                                }
                            /*$Dresult['status']=$sld['status']; */                       
                            }
                             $all[]=$Dresult;
                          $this->response(array("status" => "Success", "response_code" => 200,"message"=>"Videos Fetched Successfully", "result" =>$Dresult), 200);
                          }else{
                            $this->response(array("status" => "Failed", "response_code" => 200,"message"=>"Data Not Available", "result" =>""), 200);      
                          }
             }
             
             
             /*Get user profile data*/
             
             public function GetUserProfile_post(){
                $id=$this->decrypt_ID($this->post('user_id'));
                $userdata=$this->Webapi_model->get_data_where("tbl_users",array("status"=>1,"ID"=>$id));
                if(!empty($userdata)){
                    foreach($userdata as $data){
                        $user['FName']=$data['FName'];
                        $user['LName']=$data['LName'];
                        $user['Mobile']=$data['Mobile'];
                        $user['Email']=$data['Email'];
                        if($data['PImage']!=''){
                            $user['PImage']=$data['PImage'];
                        }else{
                            $user['PImage']="";
                        }                        
                    }
                    $this->response(array("status" => "Success", "response_code" => 200,"message"=>"Profile Data Fetched Successfully", "result" =>$user), 200);
                   }else{
                    $this->response(array("status" => "Failed", "response_code" => 200,"message"=>"Data Not Available", "result" =>""), 200);      
                  }
             }
             
             /*Update user profile*/
             public function UpdateUserProfile_post(){
                   $id=$this->decrypt_ID($this->post('user_id'));
                   $update['FName']=$this->post('FName');
                   $update['LName']=$this->post('LName');
                   $update['Mobile']=$this->post('Mobile');
                   
                   if($this->post('Mobile')!=''){
                     $userdata=$this->db->where("Mobile",$this->post('Mobile'))->where_not_in('ID',$id)->get("tbl_users")->result_array();
                     if(!empty($userdata)){
                      $this->response(array("status" => "Failed", "response_code" => 200,"message"=>"Mobile Number Already Exist", "result" =>""), 200);      
                     }
                    }                   
                    if(!empty($_FILES['PImage']['name'])){
                            $move="./uploads/";
                           if($_FILES['PImage']['name']!=''){
                              $extra_multi=uniqid().'_'.basename($_FILES['PImage']['name']);
                              $uploadimages=$extra_multi;
                             $uploadfile = $move .$extra_multi ;
                              move_uploaded_file($_FILES['PImage']['tmp_name'], $uploadfile);
                                $update['PImage']=$uploadfile;
                              /*compress($uploadfile,  $uploadfile, 60);*/
                           }
                        }
                   $res=$this->Webapi_model->update_data(array("ID"=>$id),'tbl_users',$update);
                   if($res){                       
                          $this->response(array("status" => "Success", "response_code" => 200,"message"=>"Profile Updated Successfully", "result" =>""), 200);      
                    }else{
                             $this->response(array("status" => "Failed", "response_code" => 200,"message"=>"Not Updated", "result" =>""), 200);      
                    }
             }
            
            
            /*Ask seller */
             public function askSeller_post(){
               if($this->post('user_id')!=''){
                $data['user_id']=$this->decrypt_ID($this->post('user_id'));
               }
            if($this->post('product_id')!=''){
                        $data['product_id']=$this->decrypt_ID($this->post('product_id'));           
                  }
                $data['Name']=$this->post('Name');
                $data['Email']=$this->post('Email');
                $data['Mobile']=$this->post('Phone');
                $data['message']=$this->post('Message');
                $data['quantity']=$this->post('quantity');
                $checkUserRequest=$this->Admin_model->get_data_where('ask_seller',array("user_id"=>$data['user_id'],"product_id"=>$data['product_id']));
                if(!empty($checkUserRequest)){
                     $this->response(array("status" => "Failed", "response_code" => 200,"message"=>"Already Sent Request for this Product", "result" =>""), 200);  
                }else{
                  $id=$this->Admin_model->insert_data('ask_seller',$data);
                   if($id){
                          $this->response(array("status" => "Success", "response_code" => 200,"message"=>"Successfully Submit Request", "result" =>""), 200);
                   }else{
                        $this->response(array("status" => "Failed", "response_code" => 200,"message"=>"Something went wrong", "result" =>""), 200);      
                  }
                }
             }
            
             /*recently viewed product*/             
             public function recently_viewed_post(){
                    if(!empty($this->post('user_id'))){
                        $data['user_id']=$this->decrypt_ID($this->post('user_id'));
                         $data['product_id']=$this->decrypt_ID($this->post('product_id'));                     
                         $checkpr=$this->Admin_model->get_data_where("recently_viewed",array("user_id"=>$data['user_id'],"product_id"=>$data['product_id']));
                         if(!empty($checkpr)){
                            $this->Webapi_model->update_data(array("user_id"=>$data['user_id'],"product_id"=>$data['product_id']),'recently_viewed',array("UpdateDate"=>date('Y-m-d h:i:s')));
                           $this->response(array("status" => "Success", "response_code" => 200,"message"=>"Successfully Updated Recently viewed", "result" =>""), 200);
                         }else{
                            $data['UpdateDate']=date('Y-m-d h:i:s');
                            $id=$this->Webapi_model->insert_data('recently_viewed',$data);
                              if($id){
                                 $this->response(array("status" => "Success", "response_code" => 200,"message"=>"Successfully Submit Recently viewed", "result" =>""), 200);
                               }else{
                                    $this->response(array("status" => "Failed", "response_code" => 200,"message"=>"Something went wrong", "result" =>""), 200);      
                              }
                         }
                    }
              }
             
             /*List of recently viewed*/
             public function recently_viewed_List_post(){
                  if(!empty($this->post('user_id'))){
                    $data['user_id']=$this->decrypt_ID($this->post('user_id'));
                    $data['product_id']=$this->decrypt_ID($this->post('product_id'));                    
                    $list=   $this->Webapi_model->get_recently_viewed($data['user_id']);
                    foreach($list as $list1){
                        $list1['DImage']="uploads/products/default/".$list1['DImage'];
                        $list1['ConCode']=strtolower($list1['ConCode']);
                        $list1['ID']=$this->encrypt_ID($list1['ID']);
                        $list1['product_id']=$this->encrypt_ID($list1['product_id']);
                        $plist[]=$list1;
                    }
                    if($plist){
                        $this->response(array("status" => "Success", "response_code" => 200,"message"=>"Recently viewed List Fetched", "result" =>$plist), 200);
                    }else{
                         $this->response(array("status" => "Failed", "response_code" => 200,"message"=>"Something went wrong", "result" =>""), 200);      
                     
                    }
                  }
             }
             
             
            /*Ask seller */
             public function askSeller_list_post(){
                if($this->post('user_id')!=''){
                 $user_id=$this->decrypt_ID($this->post('user_id'));
                }
                 $list=$this->Webapi_model->get_askseller('ask_seller',$user_id);
                 foreach($list as $ll){
                    $ll['pimage']= "uploads/products/default/".$ll['pimage'];
                    $ll['CreateDate']= date('m-d-Y',strtotime($ll['CreateDate']));
                    $ll['UpdateDate']= date('m-d-Y',strtotime($ll['UpdateDate']));
                    $ll['product_id']= $this->encrypt_ID($ll['product_id']);
                    $ll['ID']= $this->encrypt_ID($ll['ID']);
                    $listseller[]=$ll;
                 }                 
                 if($list){
                          $this->response(array("status" => "Success", "response_code" => 200,"message"=>"Ask seller List Fetched", "result" =>$listseller), 200);
                   }else{
                        $this->response(array("status" => "Failed", "response_code" => 200,"message"=>"Something went wrong", "result" =>""), 200);      
                  }               
             }
             
        /*Saved Searches  */
         public function savedSearches_post(){
                    $data['user_id']=$this->decrypt_ID($this->post('user_id'));
                    $data['CategoryId']=$this->decrypt_ID($this->post('category_id'));
                    $data['country_id']=$this->post('country_id');
                    $data['city_id']=$this->post('city_id');
                    $data['brand_id']=$this->post('brand_id');
                    $data['model_id']=$this->post('model_id');
					$data['type_id']=$this->post('type_id');
                     $id=$this->Admin_model->insert_data('tbl_saved_searches',$data);
                       if($id){
                              $this->response(array("status" => "Success", "response_code" => 200,"message"=>"Successfully Saved Searches", "result" =>""), 200);
                       }else{
                            $this->response(array("status" => "Failed", "response_code" => 200,"message"=>"Something went wrong", "result" =>""), 200);      
                      }
             }
             
               /*get Saved Searches  */
             public function getsavedSearches_post(){
                  $user_id=$this->decrypt_ID($this->post('user_id'));
                   //$list=$this->Webapi_model->get_data_where('tbl_saved_searches',array("user_id"=>$user_id,"status"=>1));
                      $list=$this->Webapi_model->get_saved_searches_data('tbl_saved_searches',array("tbl_saved_searches.user_id"=>$user_id,"tbl_saved_searches.status"=>1));
               
                    foreach($list as $ll){
                        $ll['CreateDate']=date('m-d-Y h:i:a',strtotime($ll['CreateDate']));
                         $ll['UpdateDate']=date('m-d-Y h:i:a',strtotime($ll['UpdateDate']));
                        $ll['CategoryId']=$this->encrypt_ID($ll['CategoryId']);
                        $ll['user_id']=$this->encrypt_ID($ll['user_id']);
                        if(!empty($ll['brand_id'])){
                             $ll['brand_id']=$ll['brand_id'];
                        }
                         if(!empty($ll['model_id'])){
                             $ll['model_id']=$this->encrypt_ID($ll['model_id']);
                        }                   
                        $alllist[]=$ll;
                    }
                     if($alllist){
                          $this->response(array("status" => "Success", "response_code" => 200,"message"=>"Saved Searches List Fetched", "result" =>$alllist), 200);
                   }else{
                        $this->response(array("status" => "Failed", "response_code" => 200,"message"=>"Something went wrong", "result" =>""), 200);      
                  }                  
             }
             
               /*delete Saved Searches  */
             public function deletesavedSearches_post(){
                 $user_id=$this->decrypt_ID($this->post('user_id'));
                 $list=$this->Webapi_model->update_data(array("user_id"=>$user_id),'tbl_saved_searches',array("status"=>0));
                   if($list){
                     $list1=$this->Webapi_model->get_data_where('saved_searches',array("user_id"=>$user_id,"status"=>1));
                          $this->response(array("status" => "Success", "response_code" => 200,"message"=>"Saved Searches Deleted", "result" =>$list1), 200);
                   }else{
                        $this->response(array("status" => "Failed", "response_code" => 200,"message"=>"Something went wrong", "result" =>""), 200);      
                  }     
             } 
           
            public function asksellerRequestList_post(){
                    $RecieverId=$this->post('RecieverId');
                    $SenderId=$this->post('SenderId');
                    $product_id=$this->post('product_id');
                     /*chat*/
                        $getchatlist=$this->Webapi_model->get_UsersChat_list($product_id,$SenderId,$RecieverId);
                        //$gerAssignedUser=$this->Webapi_model->get_Assgined_User($product_id);
                          $gerAssignedUser=$this->Admin_model->get_data_where('tbl_users',array("ID"=>$RecieverId));
                     /*chat*/
                $list['message']=array();
               foreach($gerAssignedUser as $recuser){
                    $receiver['id']=$recuser['ID'];
                    $receiver['username']=trim($recuser['FName']." ".$recuser['LName']);
                    if(!empty($recuser['PImage'])){
                    $receiver['imageUrl']=$recuser['PImage'];
                    }else{
                         $receiver['imageUrl']= "uploads/No_Image_Available.png";
                    }
               }
                $senderID=array("id"=>$SenderId);
                $list["sender"] =$senderID;
                $list["receiver"] =$receiver;                
            if(!empty($getchatlist)){
                $msg=array();
                foreach($getchatlist as $chat){
                   $message['id']=$chat['Id'];
                    $message['msg']=array("type"=>"text","text"=>$chat['Message']);
                     $message['userID']=$chat['SenderId'];
                     $msg[]=$message;
                }  
                 $list['message']=$msg;                  
                $this->response(array("status" => "Success", "response_code" => 200,"message"=>"Messages Fetched Successfully", "result" =>$list), 200);    
            }else{
                $this->response(array("status" => "Failed", "response_code" => 200,"message"=>"No Data Available", "result" =>$list), 200);
            }
         }
             
             /*ask seller chat list*/
             public function askseller_chatingList_post()
             {
                $user_id=$this->decrypt_ID($this->post('user_id'));
                $wh = array("SenderId"=>$user_id);
                 $list=$this->Webapi_model->get_chat_of_asksellers($wh);
                 $checkAssignedUser=$this->Webapi_model->checkAssignedUser($user_id);
                 
                 if(!empty($checkAssignedUser)){
                    foreach($checkAssignedUser as $getUser){
                        $get_user_details=$this->Webapi_model->get_data_where("tbl_users",array("ID"=>$getUser['assigned_to_userid']));
                       foreach($get_user_details as $userdata){
                        $userss['SenderId']=$user_id;
                         $userss['RecieverId']=$userdata['ID'];
                            $userss['receiver_name']=$userdata['FName']." ".$userdata['LName'];
                           $userss['receiver_image']=$userdata['PImage'];
                             $userss['product_id']=$getUser['product_id'];
                           $userD[]=$userss;
                       }
                    }
                 }
                 
                 $checkrequestaiisnedtouser=$this->Webapi_model->checkRequesttoAssignedUser($user_id);
            
                 if(!empty($checkrequestaiisnedtouser)){
                    foreach($checkrequestaiisnedtouser as $assineduser){
                            $getuser=$this->Webapi_model->get_data_where("tbl_users",array("ID"=>$assineduser['user_id']));
                       
                                foreach($getuser as $getuserdata){
                                 $getuserss['SenderId']=$assineduser['assigned_to_userid'];
                                  $getuserss['RecieverId']=$assineduser['user_id'];
                                     $getuserss['receiver_name']=$getuserdata['FName']." ".$getuserdata['LName'];
                                    $getuserss['receiver_image']=$getuserdata['PImage'];
                                    $getuserss['product_id']=$assineduser['product_id'];
                                    $Assignedusers[]=$getuserss;
                                }
                    }
                 }
            
                  if(!empty($list) || !empty($userD) || !empty($Assignedusers)){
                    
                     $chatlistseller = array();
                   if(!empty($list)){                 
                    foreach($list as $ll){
                        $recdata=$this->Webapi_model->get_data_where('tbl_users',array("ID"=>$ll['RecieverId']));
                        $prddata=$this->Webapi_model->get_data_where('tbl_products',array("ID"=>$ll['ProductId']));
                        foreach($recdata as $receiver){
                           $listseller['receiver_name']=$receiver['FName']." ".$receiver['LName'];
                           $listseller['receiver_image']=$receiver['PImage'];
                         }
                          $listseller['RecieverId']=$ll['RecieverId'];
                           $listseller['SenderId']=$ll['SenderId'];
                           $listseller['Message']=$ll['Message'];
                         foreach($prddata as $pdata){
                           $listseller['product_name']=$pdata['Name'];
                            $listseller['product_id']=$pdata['ID'];
                         }
                           $listseller['ID']=$ll['Id'];                            
                           $listseller['CreatedDate']=date('m-d-Y h:i:a',strtotime($ll['CreatedDate']));
                            $chatlistseller[]=$listseller;                       
                    }
                   }
                   
             if(!empty($userD) && !empty($Assignedusers))  {    
                    $response=array_merge($userD,$Assignedusers);
             }elseif(!empty($userD)){
                 $response=$userD;
             }elseif(!empty($Assignedusers)){
                 $response=$Assignedusers;
             }else{
                 $this->response(array("status" => "Failed", "response_code" => 200,"message"=>"No Data Found", "result" =>""), 200);                      
             }
             
                    $this->response(array("status" => "Success", "response_code" => 200,"message"=>"Seller Request Received", "result" =>$response), 200);
                   }else{
                        $this->response(array("status" => "Failed", "response_code" => 200,"message"=>"No Data Found", "result" =>""), 200);      
                  }   
             }
             
             
             
             /*ask seller and receiver chat submit*/
             public function ask_sellerchat_post(){
                 $receiver_id=$this->post('receiver');
                  $sender_id=$this->post('sender_id');
                   $product_id=$this->post('product_id');
                  $msg=$this->post('message');
                  $insert=array("ProductId"=>$product_id,"SenderId"=>$sender_id,"RecieverId"=>$receiver_id,"Message"=>$msg);
                   $id=$this->Admin_model->insert_data('tbl_user_chat',$insert);
                    if($id){
                          $this->response(array("status" => "Success", "response_code" => 200,"message"=>"Message sent Successfully", "result" =>""), 200);
                   }else{
                        $this->response(array("status" => "Failed", "response_code" => 200,"message"=>"Something went wrong", "result" =>""), 200);      
                  }
             }
             
            public function addListingCar_post(){
                $data['User_id']=$this->decrypt_ID($this->post('user_id'));
                $data['Name']=$this->post('heading');
				$data['Alias']=alias($this->post('heading'));
                $data['TypeID']=$this->post('type_id');
                $data['CategoryID']=$this->post('CategoryID');
                $data['BrandID']=$this->post('brand_id');
                $data['ModelID']=$this->post('model_id');
                $data['DriveId']=$this->post('drive_id');
                $data['YearID']=$this->post('year_id');
                $data['FuelType']=$this->post('FuelType');
                $data['ColorID']=$this->post('color_id');
                $data['InteriorColorID']=$this->post('Interiorcolor_id');
                $data['Gearbox']=$this->post('Gearbox');
                $data['VIN']=$this->post('VIN');
                $data['Condition']=$this->post('Condition');
                $data['CurrencyId']=$this->post('CurrencyId');
                $data['Mileage']=$this->post('Mileage');
                $data['Price']=$this->post('Price');
                $data['CountriesID']=$this->post('country_id');
                $data['StatesID']=$this->post('state_id');
                $data['CityID']=$this->post('city_id');
                $data['InternalReference']=$this->post('InternalReference'); 
                $data['Tags']=$this->post('Tags');
                $data['Rental']=$this->post('Rental');
                $data['Address']=$this->post('Address');
                $data['offer_validity']=$this->post('offer_validity');
                $data['Status']=0;
                $data['Rental']='sale';
               /* $this->input->request_headers();*/
                if(!empty($_FILES['default_image']['name'])){
                                $image=uniqid().'_'.basename($_FILES['default_image']['name']);
                                $uploadimages=$image;
                                $uploadfile = "./uploads/products/default/".$image ;
                                move_uploaded_file($_FILES['default_image']['tmp_name'], $uploadfile);
                                resize_image_dynamic($image);
                                $data['DImage']=$image;                                
                                 compress($uploadfile, $uploadfile, 60);                                 
							}
                            
                   $product_id=$this->Admin_model->insert_data('tbl_products',$data);       
                   if(!empty($_FILES)){
                        for($j=0;$j<count($_FILES);$j++){						 
                          $move="./uploads/products/similer/";
                            if($_FILES[$j]!=''){
                               $extra_multi=uniqid().'_'.basename($_FILES[$j]['name']);
                               $uploadimages=$extra_multi;
                               $uploadfile = $move .$extra_multi ;
                               move_uploaded_file($_FILES[$j]['tmp_name'], $uploadfile);
                               $addimage=$extra_multi;
                               resizeSimiler_image_dynamic($extra_multi);
                               compress($uploadfile, $uploadfile, 60);							  
                               $images=array("CategoryID"=>$data['CategoryID'],
                                          "ProductID"=>$product_id,
                                          "BrandID"=>$_POST['brand_id'],
                                          "ModelID"=>$_POST['model_id'],
                                          "SimilerImg"=>$addimage);
                         $this->Admin_model->insert_data('tbl_product_images',$images);
                          }
                        }
                    }
                       
                  if($product_id){
                          $this->response(array("status" => "Success", "response_code" => 200,"message"=>"CarListing Created Successfully", "result" =>""), 200);
                   }else{
                        $this->response(array("status" => "Failed", "response_code" => 200,"message"=>"Something went wrong", "result" =>""), 200);      
                  }
            }
            
            
            /*Add motorcycle Listing*/
            public function addListingMotorcycle_options(){
                 $data['User_id']=$this->decrypt_ID($this->post('user_id'));
                $data['Name']=$this->post('title');
				$data['Alias']=alias($this->post('title'));				
                $data['TypeID']=$this->post('type_id');
                $data['CategoryID']=$this->post('CategoryID');
                $data['BrandID']=$this->post('brand_id');
                $data['ModelID']=$this->post('model_id');
                $data['DriveId']=$this->post('drive_id');
                $data['YearID']=$this->post('year_id');
                $data['FuelType']=$this->post('FuelType');
                $data['ColorID']=$this->post('color_id');
                $data['InteriorColorID']=$this->post('Interiorcolor_id');
                $data['Gearbox']=$this->post('Gearbox');
                $data['VIN']=$this->post('VIN');
                $data['Condition']=$this->post('Condition');
                $data['CurrencyId']=$this->post('CurrencyId');
                $data['Mileage']=$this->post('Mileage');
                $data['Price']=$this->post('Price');
                $data['CountriesID']=$this->post('country_id');
                $data['StatesID']=$this->post('state_id');
                $data['CityID']=$this->post('city_id');
                $data['InternalReference']=$this->post('InternalReference'); 
                $data['Tags']=$this->post('Tags');
                $data['Rental']=$this->post('Rental');
                $data['Address']=$this->post('Address');
                $data['Description']=$this->post('Description');
                $data['offer_validity']=$this->post('offer_validity');
                $data['Status']=0;
                $data['Rental']='sale';
				
                 if(!empty($_FILES['user_file']['name'])){					
                            $move="./uploads/products/default/";
                           if($_FILES['user_file']['name']!=''){
                              $image=uniqid().'_'.basename($_FILES['user_file']['name']);
                              $uploadimages=$image;
                              $uploadfile = $move .$image ;
                              move_uploaded_file($_FILES['user_file']['tmp_name'], $uploadfile);
                              $data['DImage']=$image;
                              resize_image_dynamic($image);
                              compress($uploadfile,  $uploadfile, 60);
                           }
                   }
                   $product_id=$this->Admin_model->insert_data('tbl_products',$data);
                    if(!empty($_FILES)){
                       for($j=0;$j<count($_FILES);$j++){						 
						 $move="./uploads/products/similer/";
                           if($_FILES[$j]!=''){
                              $extra_multi=uniqid().'_'.basename($_FILES[$j]['name']);
                              $uploadimages=$extra_multi;
                              $uploadfile = $move .$extra_multi ;
                              move_uploaded_file($_FILES[$j]['tmp_name'], $uploadfile);
                              $addimage=$extra_multi;
                              resizeSimiler_image_dynamic($extra_multi);
                              compress($uploadfile, $uploadfile, 60);							  
							  $images=array("CategoryID"=>$data['CategoryID'],
										 "ProductID"=>$product_id,
										 "BrandID"=>$_POST['BrandID'],
										 "ModelID"=>$_POST['ModelID'],
										 "SimilerImg"=>$addimage);
						$this->Admin_model->insert_data('tbl_product_images',$images);
                         }
                       }
                   }
                   if($product_id){
                          $this->response(array("status" => "Success", "response_code" => 200,"message"=>"MotorcycleListing Created Successfully", "result" =>""), 200);
                   }else{
                        $this->response(array("status" => "Failed", "response_code" => 200,"message"=>"Something went wrong", "result" =>""), 200);
				}
            }
            
 public function addListingYatch_post(){
				$data['User_id']=$this->decrypt_ID($this->post('user_id'));
				$data['Name']=$this->post('heading');
				$data['Alias']=alias($this->post('heading'));
				$data['TypeID']=$this->post('type_id');
				$data['CategoryID']=$this->post('CategoryID');
				$data['BrandID']=$this->post('brand_id');
				$data['ModelID']=$this->post('model_id');
				$data['Length']=$this->post('Length');
				$data['Beam']=$this->post('Beam');
				$data['Berths']=$this->post('Berths');
				$data['YearID']=$this->post('year_id');
				$data['VIN']=$this->post('VIN');
				$data['Draft']=$this->post('Draft');
				$data['Engineshp']=$this->post('Engineshp');
				$data['Enginehours']=$this->post('Enginehours');
				$data['Cruisespeed']=$this->post('Cruisespeed');
				$data['Maxspeed']=$this->post('Maxspeed');
				$data['Fueltankage']=$this->post('Fueltankage');
				$data['Watertankage']=$this->post('Watertankage');
				$data['Hullmaterial']=$this->post('Hullmaterial');
				$data['Cabins']=$this->post('Cabins');
				$data['Engine']=$this->post('Engine');
				$data['InternalReference']=$this->post('InternalReference');
				$data['Condition']=$this->post('Condition');
				$data['CurrencyId']=$this->post('CurrencyId');
				$data['Price']=$this->post('Price');
				$data['CountriesID']=$this->post('country_id');
				$data['StatesID']=$this->post('state_id');
				$data['CityID']=$this->post('city_id');
				$data['Rental']=$this->post('Rental');
				$data['Address']=$this->post('Address');
				$data['Description']=$this->post('Description');
				$data['Tags']=$this->post('Tags');
				$data['offer_validity']=$this->post('offer_validity');
				$data['Status']=0;
                $data['Rental']='sale';
                    if(!empty($_FILES['default_image']['name'])){
                                $image=uniqid().'_'.basename($_FILES['default_image']['name']);
                                    $uploadimages=$image;
                                   $uploadfile = "./uploads/products/default/".$image ;
                                    move_uploaded_file($_FILES['default_image']['tmp_name'], $uploadfile);
                                     $data['DImage']=$image;
                                     resize_image_dynamic($image);
                                     compress($uploadfile, $uploadfile, 60);
                                 }
						 $product_id=$this->Admin_model->insert_data('tbl_products',$data);
							if(!empty($_FILES)){
							   for($j=0;$j<count($_FILES);$j++){						 
								 $move="./uploads/products/similer/";
								   if($_FILES[$j]!=''){
									  $extra_multi=uniqid().'_'.basename($_FILES[$j]['name']);
									  $uploadimages=$extra_multi;
									  $uploadfile = $move .$extra_multi ;
									  move_uploaded_file($_FILES[$j]['tmp_name'], $uploadfile);
									  $addimage=$extra_multi;
                                       resizeSimiler_image_dynamic($extra_multi);
									  compress($uploadfile, $uploadfile, 60);							  
									  $images=array("CategoryID"=>$data['CategoryID'],
												 "ProductID"=>$product_id,
												 "BrandID"=>$data['BrandID'],
												 "ModelID"=>$data['ModelID'],
												 "SimilerImg"=>$addimage);
								$this->Admin_model->insert_data('tbl_product_images',$images);
								 }
							   }
						   }
                    if($product_id){
                        $this->response(array("status" => "Success", "response_code" => 200,"message"=>"YatchListing Created Successfully", "result" =>""), 200);
                        }else{
                             $this->response(array("status" => "Failed", "response_code" => 200,"message"=>"Something went wrong", "result" =>""), 200);      
                       }
				}
             
             
              public function addListingRealEstate_post(){
				  
					$data['User_id']=$this->decrypt_ID($this->post('user_id'));
					$data['Name']=$this->post('title');
					$data['Alias']=alias($this->post('title'));
					$data['TypeID']=$this->post('type_id');
					$data['CategoryID']=$this->post('CategoryID');
					$data['Bedrooms']=$this->post('Bedrooms');
					$data['LivingArea']=$this->post('LivingArea');
					$data['TypeID']=$this->post('type_id');
					$data['YearID']=$this->post('year_id');
					$data['InternalReference']=$this->post('InternalReference');
					$data['CurrencyId']=$this->post('CurrencyId');
					$data['Price']=$this->post('Price');
					$data['CountriesID']=$this->post('country_id');
					$data['StatesID']=$this->post('state_id');
					$data['CityID']=$this->post('city_id');
					$data['Rental']=$this->post('Rental');
					$data['Condition']=$this->post('Condition');
					$data['Address']=$this->post('Address');
					$data['Description']=$this->post('Description');
					$data['offer_validity']=$this->post('offer_validity');
					$data['Tags']=$this->post('Tags');
					$data['Status']=0;
                    $data['Rental']='sale';
                    if(!empty($_FILES['user_file']['name'])){
                       $image=uniqid().'_'.basename($_FILES['user_file']['name']);
                           $uploadimages=$image;
                          $uploadfile = "./uploads/products/default/".$image ;
                           move_uploaded_file($_FILES['user_file']['tmp_name'], $uploadfile);
                           $data['DImage']=$image;
                           resize_image_dynamic($image);
                            compress($uploadfile, $uploadfile, 60);
                        }
					$product_id=$this->Admin_model->insert_data('tbl_products',$data);
					if(!empty($_FILES)){
                            for($j=0;$j<count($_FILES);$j++){						 
                              $move="./uploads/products/similer/";
                                if($_FILES[$j]!=''){
                                   $extra_multi=uniqid().'_'.basename($_FILES[$j]['name']);
                                   $uploadimages=$extra_multi;
                                   $uploadfile = $move .$extra_multi ;
                                   move_uploaded_file($_FILES[$j]['tmp_name'], $uploadfile);
                                   $addimage=$extra_multi;
                                   resizeSimiler_image_dynamic($extra_multi);
                                   compress($uploadfile, $uploadfile, 60);							  
                                   $images=array("CategoryID"=>$data['CategoryID'],
                                              "ProductID"=>$product_id,
                                              "BrandID"=>"",
                                              "ModelID"=>"",
                                              "SimilerImg"=>$addimage);
                             $this->Admin_model->insert_data('tbl_product_images',$images);
                              }
                            }
					   }
                    if($product_id){
                        $this->response(array("status" => "Success", "response_code" => 200,"message"=>"RealEstateListing Created Successfully", "result" =>""), 200);
                        }else{
                             $this->response(array("status" => "Failed", "response_code" => 200,"message"=>"Something went wrong", "result" =>""), 200);      
                       }
              }
              
              
	public function addListingJewelery_post(){
                $data['User_id']=$this->decrypt_ID($this->post('user_id'));
                $data['Name']=$this->post('title');
				$data['Alias']=alias($this->post('title'));
                $data['TypeID']=$this->post('type_id');
                $data['CategoryID']=$this->post('CategoryID');
                $data['Gender']=$this->post('Gender');
                $data['BrandID']=$this->post('brand_id');
                $data['CurrencyId']=$this->post('CurrencyId');
                $data['Price']=$this->post('Price'); 
                $data['CountriesID']=$this->post('country_id');
                $data['StatesID']=$this->post('state_id');
                $data['CityID']=$this->post('city_id');
                $data['Stonecolor']=$this->post('Stonecolor');
                $data['Mainstone']=$this->post('Mainstone');
                $data['Total_carat_weight']=$this->post('Total_carat_weight');
                $data['InternalReference']=$this->post('InternalReference');
                $data['metal_color']=$this->post('metal_color');
                $data['main_material']=$this->post('main_material');
                $data['metal_color']=$this->post('Interiorcolor_id');
                $data['Tags']=$this->post('Tags');
                $data['Condition']=$this->post('Condition');
                $data['Address']=$this->post('Address');
                $data['Description']=$this->post('Description');
                $data['Status']=0;
                $data['Rental']='sale';
                if(!empty($_FILES['default_image']['name'])){
                       $image=uniqid().'_'.basename($_FILES['default_image']['name']);
                           $uploadimages=$image;
                          $uploadfile = "./uploads/products/default/".$image ;
                           move_uploaded_file($_FILES['default_image']['tmp_name'], $uploadfile);
                            $data['DImage']=$image;
                            resize_image_dynamic($image);
                            compress($uploadfile, $uploadfile, 60);
                        }
				
				   $product_id=$this->Admin_model->insert_data('tbl_products',$data);
							if(!empty($_FILES)){
							   for($j=0;$j<count($_FILES);$j++){						 
								 $move="./uploads/products/similer/";
								   if($_FILES[$j]!=''){
									  $extra_multi=uniqid().'_'.basename($_FILES[$j]['name']);
									  $uploadimages=$extra_multi;
									  $uploadfile = $move .$extra_multi ;
									  move_uploaded_file($_FILES[$j]['tmp_name'], $uploadfile);
									  $addimage=$extra_multi;
                                      resizeSimiler_image_dynamic($extra_multi);
									  compress($uploadfile, $uploadfile, 60);							  
									  $images=array("CategoryID"=>$data['CategoryID'],
												 "ProductID"=>$product_id,
												 "BrandID"=>"",
												 "ModelID"=>"",
												 "SimilerImg"=>$addimage);
								$this->Admin_model->insert_data('tbl_product_images',$images);
								 }
							   }
						   }
						   
				if($product_id){
				   $this->response(array("status" => "Success", "response_code" => 200,"message"=>"JeweleryListing Created Successfully", "result" =>""), 200);
				   }else{
						$this->response(array("status" => "Failed", "response_code" => 200,"message"=>"Something went wrong", "result" =>""), 200);      
				  }
			}
                
                
            public function addListingWatch_post(){
                            $data['User_id']=$this->decrypt_ID($this->post('user_id'));
                            $data['Name']=$this->post('title');
							$data['Alias']=alias($this->post('title'));
                            $data['TypeID']=$this->post('type_id');
                            $data['YearID']=$this->post('year_id');
                            $data['CaseMaterial']=$this->post('CaseMaterial');
                            $data['BrandID']=$this->post('brand_id');
                            $data['ModelID']=$this->post('model_id');
                            $data['ColorID']=$this->post('color_id');
                            $data['InteriorColorID']=$this->post('Interiorcolor_id');
                            $data['StrapMaterial']=$this->post('StrapMaterial');
                            $data['Crystal']=$this->post('Crystal');
                            $data['Movement']=$this->post('Movement');
                            $data['ReferenceNumber']=$this->post('ReferenceNumber');
                            $data['WaterResistance']=$this->post('WaterResistance');
                            $data['CaseDiameter']=$this->post('CaseDiameter');
                            $data['Thickness']=$this->post('Thickness');
                            $data['Authenticity']=$this->post('Authenticity');
                            $data['Features']=$this->post('Features');                                
                            $data['CategoryID']=$this->post('CategoryID');
                            $data['CurrencyId']=$this->post('CurrencyId');
                            $data['Price']=$this->post('Price'); 
                            $data['CountriesID']=$this->post('country_id');
                            $data['StatesID']=$this->post('state_id');
                            $data['CityID']=$this->post('city_id');
                            $data['InternalReference']=$this->post('InternalReference');
                            $data['Tags']=$this->post('Tags');
                            $data['Condition']=$this->post('Condition');
                            $data['Address']=$this->post('Address');
                            $data['Description']=$this->post('Description');
                            $data['Functions']=$this->post('Functions');
                            $data['Gender']=$this->post('Gender');
                            $data['Status']=0;
                            $data['Rental']='sale';
                            if(!empty($_FILES['user_file']['name'])){
                                    $image=uniqid().'_'.basename($_FILES['user_file']['name']);
                                    $uploadimages=$image;
                                    $uploadfile = "./uploads/products/default/".$image ;
                                    move_uploaded_file($_FILES['user_file']['tmp_name'], $uploadfile);
                                    $data['DImage']=$image;
                                    resize_image_dynamic($image);
                                    compress($uploadfile, $uploadfile, 60);
                            }
                        $product_id=$this->Admin_model->insert_data('tbl_products',$data);
						if(!empty($_FILES)){
						   for($j=0;$j<count($_FILES);$j++){
								$move="./uploads/products/similer/";
								  if($_FILES[$j]!=''){
									 $extra_multi=uniqid().'_'.basename($_FILES[$j]['name']);
									 $uploadimages=$extra_multi;
									 $uploadfile = $move .$extra_multi ;
									 move_uploaded_file($_FILES[$j]['tmp_name'], $uploadfile);
									 $addimage=$extra_multi;
                                     resizeSimiler_image_dynamic($extra_multi);
									 compress($uploadfile, $uploadfile, 60);							  
									 $images=array("CategoryID"=>$data['CategoryID'],
												"ProductID"=>$product_id,
												"BrandID"=>$data['BrandID'],
												"ModelID"=>$data['ModelID'],
												"SimilerImg"=>$addimage);
							   $this->Admin_model->insert_data('tbl_product_images',$images);
								}
						   }
					   }
                                       
                            if($product_id){
                               $this->response(array("status" => "Success", "response_code" => 200,"message"=>"WatchListing Created Successfully", "result" =>""), 200);
                               }else{
                                    $this->response(array("status" => "Failed", "response_code" => 200,"message"=>"Something went wrong", "result" =>""), 200);      
                              }

                }
                

            public function addListingLifestyle_post(){
                       $data['User_id']=$this->decrypt_ID($this->post('user_id'));
                       $data['Name']=$this->post('heading');
					   $data['Alias']=alias($this->post('heading'));
                       $data['TypeID']=$this->post('type_id');
                       $data['YearID']=$this->post('year_id');
                       $data['CategoryID']=$this->post('CategoryID');
                       $data['CurrencyId']=$this->post('CurrencyId');
                       $data['Price']=$this->post('Price'); 
                       $data['CountriesID']=$this->post('country_id');
                       $data['StatesID']=$this->post('state_id');
                       $data['CityID']=$this->post('city_id');
                       $data['InternalReference']=$this->post('InternalReference');
                       $data['Tags']=$this->post('Tags');
                       $data['Condition']=$this->post('Condition');
                       $data['Address']=$this->post('Address');
                       $data['Description']=$this->post('Description');
                       $data['Status']=0;
                       $data['Rental']='sale';
                    if(!empty($_FILES['default_image']['name'])){
                      $image=uniqid().'_'.basename($_FILES['default_image']['name']);
                          $uploadimages=$image;
                         $uploadfile = "./uploads/products/default/".$image ;
                          move_uploaded_file($_FILES['default_image']['tmp_name'], $uploadfile);
                           $data['DImage']=$image;
                           resize_image_dynamic($image);
                           compress($uploadfile, $uploadfile, 60);
                       }
                          $product_id=$this->Admin_model->insert_data('tbl_products',$data);
                                   if(!empty($_FILES)){
                                      for($j=0;$j<count($_FILES);$j++){						 
                                        $move="./uploads/products/similer/";
                                          if($_FILES[$j]!=''){
                                             $extra_multi=uniqid().'_'.basename($_FILES[$j]['name']);
                                             $uploadimages=$extra_multi;
                                             $uploadfile = $move .$extra_multi ;
                                             move_uploaded_file($_FILES[$j]['tmp_name'], $uploadfile);
                                             $addimage=$extra_multi;
                                             resizeSimiler_image_dynamic($extra_multi);
                                             compress($uploadfile, $uploadfile, 60);							  
                                             $images=array("CategoryID"=>$data['CategoryID'],
                                                        "ProductID"=>$product_id,
                                                        "BrandID"=>"",
                                                        "ModelID"=>"",
                                                        "SimilerImg"=>$addimage);
                                       $this->Admin_model->insert_data('tbl_product_images',$images);
                                        }
                                      }
                                  }
                       
                       if($product_id){
                          $this->response(array("status" => "Success", "response_code" => 200,"message"=>"LifestyleListing Created Successfully", "result" =>""), 200);
                          }else{
                               $this->response(array("status" => "Failed", "response_code" => 200,"message"=>"Something went wrong", "result" =>""), 200);      
                         }
                }
                   
			/* user booking */
            public function userBooking_post(){
                   if(!empty($_POST)){
                            $insert['name']=$_POST['name'];
                            $insert['phone']=$_POST['phone'];
                            $insert['email']=$_POST['email'];
                            $insert['message']=$_POST['message'];
                            $insert['product_id']=$this->decrypt_ID($_POST['product_id']);
                            $insert['category_id']=$this->decrypt_ID($_POST['category_id']);
                            $insert['user_id']=$this->decrypt_ID($_POST['user_id']);
                            $this->Admin_model->insert_data('tbl_user_booking',$insert);			
                            $this->response(array("Status" => "Success", "response_code" => 200,"message"=>"User Booking Created Successfully", "result" =>""), 200);
                       }
                    }
                    
                    
                    
                public function getuserBooking_post(){
                    if($this->post('user_id') != '')
                     {
                        $user_id = $this->decrypt_ID($this->post('user_id'));
                        $getlist=$this->Webapi_model->userbookings($user_id);
                        if(!empty($getlist)){
                            foreach($getlist as $list){
                                $list['DImage']="uploads/products/default/".$list['DImage'];
                                 $list['ID']=$this->encrypt_ID($list['ID']);                         
                                $ll[]=$list;
                            }
                               $this->response(array("Status" => "Success", "response_code" => 200,"message"=>"User Booking get Successfully", "result" =>$ll), 200);
                        }else{
                            $this->response(array("status" => "Failed", "response_code" => 200,"message"=>"Something went wrong", "result" =>""), 200);      
                       }
                   }  
                }
                
                public function getsearchheader_post(){
                 if($this->post('Name') != '')
                  {
                     $Name=$this->post('Name'); 
                     $search=$this->Webapi_model->sercheader($Name);			
                     $this->response(array("Status" => "Success", "response_code" => 200,"message"=>"search Successfully", "result" =>$search), 200);
                  }  
                }
        
            /* add designer */ 
           public function addListingDesigner_post(){
				  
					$data['User_id']=$this->decrypt_ID($this->post('user_id'));
					$data['Name']=$this->post('title');
					$data['CategoryID']=$this->post('CategoryID');
					$data['CurrencyId']=$this->post('CurrencyId');
					$data['Price']=$this->post('Price');
					$data['CountriesID']=$this->post('country_id');
					$data['StatesID']=$this->post('state_id');
					$data['CityID']=$this->post('city_id');
					$data['Rental']=$this->post('Rental');
					$data['Address']=$this->post('Address');
					$data['Description']=$this->post('Description');
					$data['offer_validity']=$this->post('offer_validity');
					$data['Tags']=$this->post('Tags');
					$data['Status']=0;
                    $data['Rental']='sale';
				if(!empty($_FILES['user_file']['name'])){
                            $image=uniqid().'_'.basename($_FILES['user_file']['name']);
                            $uploadimages=$image;
                            $uploadfile = "./uploads/products/default/".$image ;
                            move_uploaded_file($_FILES['user_file']['tmp_name'], $uploadfile);
                            $data['DImage']=$image;
                            resize_image_dynamic($image);
                            compress($uploadfile, $uploadfile, 60);
					}
					$product_id=$this->Admin_model->insert_data('tbl_products',$data);
						if(!empty($_FILES)){
						   for($j=0;$j<count($_FILES);$j++){						 
							 $move="./uploads/products/similer/";
							   if($_FILES[$j]!=''){
                                        $extra_multi=uniqid().'_'.basename($_FILES[$j]['name']);
                                        $uploadimages=$extra_multi;
                                        $uploadfile = $move .$extra_multi ;
                                        move_uploaded_file($_FILES[$j]['tmp_name'], $uploadfile);
                                        $addimage=$extra_multi;
                                        resizeSimiler_image_dynamic($car_multi);
                                        compress($uploadfile, $uploadfile, 60);							  
                                        $images=array("CategoryID"=>$data['CategoryID'],
                                                   "ProductID"=>$product_id,
                                                   "BrandID"=>"",
                                                   "ModelID"=>"",
                                                   "SimilerImg"=>$addimage);
                                        $this->Admin_model->insert_data('tbl_product_images',$images);
							 }
						   }
					   }
			if($product_id){
				$this->response(array("status" => "Success", "response_code" => 200,"message"=>"add Listing Designer Created Successfully", "result" =>""), 200);
				}else{
					 $this->response(array("status" => "Failed", "response_code" => 200,"message"=>"Something went wrong", "result" =>""), 200);      
			   }
              }
              
              
        /* add Fragrance */ 
       public function addListingFragrance_post(){
				  
					$data['User_id']=$this->decrypt_ID($this->post('user_id'));
					$data['Name']=$this->post('title');
					$data['CategoryID']=$this->post('CategoryID');
					$data['CurrencyId']=$this->post('CurrencyId');
					$data['Price']=$this->post('Price');
					$data['CountriesID']=$this->post('country_id');
					$data['StatesID']=$this->post('state_id');
					$data['CityID']=$this->post('city_id');
					$data['Rental']=$this->post('Rental');
					$data['Address']=$this->post('Address');
					$data['Description']=$this->post('Description');
					$data['offer_validity']=$this->post('offer_validity');
					$data['Tags']=$this->post('Tags');
					$data['Status']=0;
                    $data['Rental']='sale';
				if(!empty($_FILES['user_file']['name'])){
                            $image=uniqid().'_'.basename($_FILES['user_file']['name']);
                            $uploadimages=$image;
                            $uploadfile = "./uploads/products/default/".$image ;
                            move_uploaded_file($_FILES['user_file']['tmp_name'], $uploadfile);
                            $data['DImage']=$image;
                            resize_image_dynamic($image);
                            compress($uploadfile, $uploadfile, 60);
					}
					$product_id=$this->Admin_model->insert_data('tbl_products',$data);
						if(!empty($_FILES)){
						   for($j=0;$j<count($_FILES);$j++){
                                    $move="./uploads/products/similer/";
                                    if($_FILES[$j]!=''){
                                        $extra_multi=uniqid().'_'.basename($_FILES[$j]['name']);
                                        $uploadimages=$extra_multi;
                                        $uploadfile = $move .$extra_multi ;
                                        move_uploaded_file($_FILES[$j]['tmp_name'], $uploadfile);
                                        $addimage=$extra_multi;
                                        resizeSimiler_image_dynamic($car_multi);
                                        compress($uploadfile, $uploadfile, 60);							  
                                        $images=array("CategoryID"=>$data['CategoryID'],
                                                   "ProductID"=>$product_id,
                                                   "BrandID"=>"",
                                                   "ModelID"=>"",
                                                   "SimilerImg"=>$addimage);
                                        $this->Admin_model->insert_data('tbl_product_images',$images);
                                    }
						   }
					   }
                        if($product_id){
                            $this->response(array("status" => "Success", "response_code" => 200,"message"=>"add Listing Fragrance Created Successfully", "result" =>""), 200);
                            }else{
                                 $this->response(array("status" => "Failed", "response_code" => 200,"message"=>"Something went wrong", "result" =>""), 200);      
                           }
              }
			  /* add Antiques */
 
       public function addListingAntiques_post(){
				  
					$data['User_id']=$this->decrypt_ID($this->post('user_id'));
					$data['Name']=$this->post('title');
					$data['CategoryID']=$this->post('CategoryID');
					$data['CurrencyId']=$this->post('CurrencyId');
					$data['Price']=$this->post('Price');
					$data['CountriesID']=$this->post('country_id');
					$data['StatesID']=$this->post('state_id');
					$data['CityID']=$this->post('city_id');
					$data['Rental']=$this->post('Rental');
					$data['Address']=$this->post('Address');
					$data['Description']=$this->post('Description');
					$data['offer_validity']=$this->post('offer_validity');
					$data['Tags']=$this->post('Tags');
					$data['Status']=0;
                    $data['Rental']='sale';                    
                    if(!empty($_FILES['user_file']['name'])){
                       $image=uniqid().'_'.basename($_FILES['user_file']['name']);
                           $uploadimages=$image;
                          $uploadfile = "./uploads/products/default/".$image ;
                           move_uploaded_file($_FILES['user_file']['tmp_name'], $uploadfile);
                           $data['DImage']=$image;
                            resize_image_dynamic($image);
                            compress($uploadfile, $uploadfile, 60);
                        }
					$product_id=$this->Admin_model->insert_data('tbl_products',$data);
						if(!empty($_FILES)){
						   for($j=0;$j<count($_FILES);$j++){						 
							 $move="./uploads/products/similer/";
							   if($_FILES[$j]!=''){
                                    $extra_multi=uniqid().'_'.basename($_FILES[$j]['name']);
                                    $uploadimages=$extra_multi;
                                    $uploadfile = $move .$extra_multi ;
                                    move_uploaded_file($_FILES[$j]['tmp_name'], $uploadfile);
                                    $addimage=$extra_multi;
                                    resizeSimiler_image_dynamic($car_multi);
                                    compress($uploadfile, $uploadfile, 60);							  
                                    $images=array("CategoryID"=>$data['CategoryID'],
                                            "ProductID"=>$product_id,
                                            "BrandID"=>"",
                                            "ModelID"=>"",
                                            "SimilerImg"=>$addimage);
                                    $this->Admin_model->insert_data('tbl_product_images',$images);
							 }
						   }
					   }
                        if($product_id){
                        $this->response(array("status" => "Success", "response_code" => 200,"message"=>"add Listing Fragrance Created Successfully", "result" =>""), 200);
                        }else{
                         $this->response(array("status" => "Failed", "response_code" => 200,"message"=>"Something went wrong", "result" =>""), 200);      
                        }
                  }
                  
                  
                  /*List of reasons for contacting*/
                  public function reason_contact_list_get(){
                        $list=$this->Admin_model->get_data("reasons_for_contact");
                        foreach($list as $ll){
                            $listreason['value']=$ll['ID'];
                            $listreason['label']=$ll['reason_name'];
                            $reasons[]=$listreason;
                        }
                        $this->response(array("status" => "Success", "response_code" => 200,"message"=>"Conatct List fetched Successfully", "result" =>$reasons), 200);
                   }
                   
                   
                /*List of category for contacting*/
                 public function category_list_get(){
                        $list=$this->Admin_model->get_data_where("tbl_category",array("Status"=>1));
                        foreach($list as $ll){
                            $listcat['value']=$ll['ID'];
                            $listcat['label']=$ll['Category'];
                            $cat[]=$listcat;
                        }
                        $this->response(array("status" => "Success", "response_code" => 200,"message"=>"Category List fetched Successfully", "result" =>$cat), 200);
                   }
                   
                   /*submit contact us request*/                   
                    public function contact_us_requst_post(){                  
                        $data['category_id']=$this->POST('category_id');
                        $data['reason_for_contact_id']=$this->POST('reason_for_contact');
                        $data['name']=$this->POST('name');
                        $data['company_name']=$this->POST('company_name'); 
                        $data['description']=$this->POST('description');
                        $data['emaiID']=$this->POST('emaiID');
                        $data['phone_number']=$this->POST('phone_number');
                        if(!empty($_FILES['contact_attachment']['name'])){
                            $image=uniqid().'_'.basename($_FILES['contact_attachment']['name']);
                            $uploadimages=$image;
                            $uploadfile = "./uploads/contactus_files/".$image ;
                            move_uploaded_file($_FILES['contact_attachment']['tmp_name'], $uploadfile);
                            $data['contact_attachment']=$image;                           
                        }
                        $insert=$this->Admin_model->insert_data('contact_us_request',$data);
                        if($insert){
                            $this->response(array("status" => "Success", "response_code" => 200,"message"=>"ContactUs requst submitted Successfully", "result" =>""), 200);
                        }else{
                                $this->response(array("status" => "Failed", "response_code" => 200,"message"=>"Something went wrong", "result" =>""), 200);      
                         }
                    }
                    
                    
                    public function test_api_post(){
                        print_r($_POST);
                         for($i=0; $i<=count($_FILES['contact_attachment']['name']); $i++){
                            echo $_FILES['contact_attachment']['name'][$i];
                         }                         
                        print_r($_FILES);
                          /*  if(!empty($_FILES['contact_attachment']['name'])){
                            $image=uniqid().'_'.basename($_FILES['contact_attachment']['name']);
                            $uploadimages=$image;
                            $uploadfile = "./uploads/".$image ;
                            move_uploaded_file($_FILES['contact_attachment']['tmp_name'], $uploadfile);
                                                 
                        }*/
                    }
    } /*end of reactapi controller*/
    
    
    
    
    
    
    
    
    
    
    