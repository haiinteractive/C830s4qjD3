<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	/**
	 * Controller  : Home, Landing Page
	 * Created on  : 21-Nov-2011
	 * Created By  : Vijayaragavan S
	 * Modified On :
	 * Modified By :	  
	 * Project     : Rightern
	 */

class Upload extends CI_Controller {
	
	function __construct()
    {
        parent::__construct();        			
        // load the necessary libraries
        $this->load->library('form_validation');
        $this->load->library('parser');
        $this->load->helper(array('form', 'url', 'cookie'));
        $this->load->library('core/sh_views');
        $this->load->library('core/sh_updates');
        $this->load->library('core/sh_upload');
                
        
        error_reporting(0);
        
        $this->start = '';
        $this->perPage = 6;
        $this->current_date = date("Y-m-d H:i:s");
        
        $this->email_date = date("Y-M-d");
        
        $this->url = $_SERVER['REQUEST_URI'];

        $this->url_input = split('/', $this->url);

        $this->url_count = count($this->url_input) -1;
        
        $this->url_category = count($this->url_input) -2;
    }
    
	/*
	 * Function: Index 
	 * Purpose : Loading the landing page
	 */	
	public function index()
	{
		
		$sessionUserdata = $this->session->userdata('ECITY');
            
		if(!isset($sessionUserdata['user_id']) )
		{
		 	redirect(SITE_URL."home/welcome/");      
		}
		
        $filename = 'site/'.SITE_LANG.'/upload.html' ;

        $msg = $this->url_input[$this->url_count];
		
		if($msg == 'success')
		{
        	$this->mysmarty->assign('success', "Data Imported Successfully");		
        	
		}else if($msg == 'failed') {

        	$this->mysmarty->assign('error', "Failed");		
		}
		
        
        $this->mysmarty->assign('filename',$filename);
        $this->mysmarty->display('site/home.html'); 
		
	}
	
	
	
	public function Upload_Data()
	{
	
		$result = false;
		
		$sessionUserdata = $this->session->userdata('ECITY');
            
		if(!isset($sessionUserdata['user_id']) )
		{
		 	redirect(SITE_URL."home/welcome/");      
		}
		
	    
    $csv_file = $_FILES[datas][tmp_name];; // Name of your CSV file
    
    $handle = fopen($csv_file, 'r');


     do {
        if ($data[0]) {
        
				$form_type = $this->security->xss_clean( $this->input->post("form_type") );
				
				if($data[0] != 'company_name')
				{
				
					$check_ro_availability = $this->sh_upload->Check_Ro_Number( $data[1] );
					
					if($check_ro_availability['pub_information_id'] > 0)
					{
						$result = 'update';
						
						$pub_id = $check_ro_availability['pub_information_id'];
						$ro_number = $data[1];
						
					}else{
						
						$result = 'insert';
						
						$ro_number = $data[1];
					}
					
					$company_info = $this->sh_upload->Get_Company_Id( $data[0] );
					
					$company_id = $company_info['client_id'];
					
					if($company_id == '' || $company_id == null)
					{
						$company_id = $this->sh_upload->Insert_Company_Info( $data[0] );
					}
					
					
				  if($form_type == 'EG')
				  {
				  
				  		$res = $this->sh_upload->Get_Code_Id( $data[9], $form_type );
				  		
				  		if($res['code_id'] == '' || $res['code_id'] == null)
				  		{
							redirect(SITE_URL."Upload/failed/Advertisement_Type/$data[9]");      
				  		}
				  		
						$rt = $this->EG_Data( $form_type, $company_id, $sessionUserdata['user_id'], $ro_number, $res['code_id'], $data, $result, $pub_id );
						
				  }else if( $form_type == 'EXEC')
				  {
				  		$res = $this->sh_upload->Get_Code_Id( $data[8], $form_type );
				  		
				  		if($res['code_id'] == '' || $res['code_id'] == null)
				  		{
							redirect(SITE_URL."Upload/failed/Advertisement_Type/$data[8]");      
				  		}
				  		
				  		$this->EXEC_Data( $form_type, $company_id, $sessionUserdata['user_id'], $ro_number, $res['code_id'], $data, $result, $pub_id  );
				  	
				  }else{
				  	
				  		$res = $this->sh_upload->Get_Code_Id( $data[9], $form_type );
				  	
				  		if($res['code_id'] == '' || $res['code_id'] == null)
				  		{
							redirect(SITE_URL."Upload/failed/Advertisement_Type/$data[9]");      
				  		}
				  		
				  		$this->DIGITAL_Data( $form_type, $company_id, $sessionUserdata['user_id'], $ro_number, $res['code_id'], $data, $result, $pub_id  );
	
				  }
        	}
				  
        }
    } while ($data = fgetcsv($handle,1000,",","'"));
    
		redirect(SITE_URL."Upload/index/success");      
        
	}
	
	
	
	function EG_Data( $form_type, $company_id, $user_id, $ro_number, $code_id, $data, $result, $pub_id  )
	{
	
		$ad_response = false;
		
			$str = strtotime($data[5]);
			
			$approve_date = date('y-m-d', $str);
	
			
		$category_id = $this->sh_upload->Get_Category_Id( $data[7]);
		
		if($category_id['category_id'] == '' || $category_id['category_id'] == null)
		{
			redirect(SITE_URL."Upload/failed/Caregory/$data[7]");      
		}
		
		$sales_person = $this->sh_upload->Get_Sales_Person_Id( $data[3]);
		
		
		$pub_info = array(
			'company_id' => $company_id,
			'ro_number'	=> $ro_number,
			'user_city'	=> $data[2],
			'form_type'	=> $form_type,
			'sales_person'	=> $data[3],
			'approving_authority' => $data[4],
			'approve_date'	=> $approve_date,
			'name_estalishment' => $data[6],
			'category' 		=> $category_id['category_id'],
			'spl_instruction' 		=> $data[12],
			'net_pay' 		=> $data[13],
			'created_by' 		=> $user_id,
			'created_on' 		=> $this->current_date
		);

		if($result == 'insert')
		{
			$pub_id = $this->sh_upload->Add_Pub_Info( $pub_info );
			
		}else{
					
			$pub_id = $pub_id;
						
		}
		
		$dat = explode("-", $data[11]);
		
		$str_pub_date = strtotime($data[11]);
		
		$pub_date = date("M Y", $str_pub_date);
		
		$publish_date = $data[14]." ".$pub_date;
		
		$ad_info = array(
			'pub_information_id'	=> $pub_id,	
			'month'	=> $dat[1],
			'year'	=> $dat[2],
			'session' => $data[14],
			'city'    => $data[8],
			'publish_date' => $publish_date,
			'publish_type' => $code_id,
			'offered_rate' => $data[10],
			'created_on' 		=> $this->current_date
		);
		
		$ad_valid = $this->sh_upload->Valid_Ad_data( $ad_info, $form_type );
		
		if($ad_valid == '' || $ad_valid == null)
			$ad_response = $this->sh_upload->Add_Ad_Info( $ad_info );

		return $ad_response;
		
	}
	
	
	
	
	function EXEC_Data( $form_type, $company_id, $user_id, $ro_number, $code_id, $data, $result, $pub_id  )
	{
	
		$ad_response = false;
		
		$str = strtotime($data[5]);
			
		$approve_date = date('y-m-d', $str);
	
		$category_id = $this->sh_upload->Get_Category_Id( $data[7]);
		
		if($category_id['category_id'] == '' || $category_id['category_id'] == null)
		{
			redirect(SITE_URL."Upload/failed/Caregory/$data[7]");      
		}
		
		$sales_person = $this->sh_upload->Get_Sales_Person_Id( $data[3]);
		
		$pub_info = array(
			'company_id' => $company_id,
			'ro_number'	=> $ro_number,
			'user_city'	=> $data[2],
			'form_type'	=> $form_type,
			'sales_person'	=> $data[3],
			'approving_authority' => $data[4],
			'approve_date'	=> $approve_date,
			'name_estalishment' => $data[6],
			'category' 		=> $category_id['category_id'],
			'spl_instruction' 		=> $data[11],
			'net_pay' 		=> $data[12],
			'created_by' 		=> $user_id,
			'created_on' 		=> $this->current_date
		);
					
		if($result == 'insert')
		{
			$pub_id = $this->sh_upload->Add_Pub_Info( $pub_info );
			
		}else{
					
			$pub_id = $pub_id;
						
		}
					
/*		$pub_date = explode('-', $data[10]);

		if($pub_date[0] == 'Jan'){
			$month = 01;		
		}else if($pub_date[0] == 'Feb'){
			$month = 02;		
		}else if($pub_date[0] == 'Mar'){
			$month = 03;		
		}else if($pub_date[0] == 'Apr'){
			$month = 04;		
		}else if($pub_date[0] == 'May'){
			$month = 05;		
		}else if($pub_date[0] == 'Jun'){
			$month = 06;		
		}else if($pub_date[0] == 'Jul'){
			$month = 07;		
		}else if($pub_date[0] == 'Aug'){
			$month = 08;		
		}else if($pub_date[0] == 'Sep'){
			$month = 09;		
		}else if($pub_date[0] == 'Oct'){
			$month = 10;		
		}else if($pub_date[0] == 'Nov'){
			$month = 11;		
		}else if($pub_date[0] == 'Dec'){
			$month = 12;		
		}
		
		$year = '20'.$pub_date[1];		
*/		
		
		$dat = explode("-", $data[10]);
		
		$str_pub_date = strtotime($data[10]);
		
		$pub_date = date("M Y", $str_pub_date);
		
		$ad_info = array(
			'pub_information_id'	=> $pub_id,	
			'month'	=> $dat[1],
			'year'	=> $dat[2],
			'publish_date' => $pub_date,
			'publish_type' => $code_id,
			'offered_rate' => $data[9],
			'created_on' 		=> $this->current_date
		);
							
		$ad_valid = $this->sh_upload->Valid_Ad_data( $ad_info, $form_type );
		
		if($ad_valid == '' || $ad_valid == null)
		$ad_response = $this->sh_upload->Add_Ad_Info( $ad_info );
		
		return $ad_response;
	}
	
	
	function DIGITAL_Data( $form_type, $company_id, $user_id, $ro_number, $code_id, $data, $result, $pub_id )
	{

		$ad_response = false;
	
		$str = strtotime($data[5]);
			
		$approve_date = date('y-m-d', $str);
	
		$category_id = $this->sh_upload->Get_Category_Id( $data[7]);
		
		if($category_id['category_id'] == '' || $category_id['category_id'] == null)
		{
			redirect(SITE_URL."Upload/failed/Caregory/$data[7]");      
		}
		
		$sales_person = $this->sh_upload->Get_Sales_Person_Id( $data[3]);
		
		$pub_info = array(
			'company_id' => $company_id,
			'ro_number'	=> $ro_number,
			'user_city'	=> $data[2],
			'form_type'	=> $form_type,
			'sales_person'	=> $data[3],
			'approving_authority' => $data[4],
			'approve_date'	=> $approve_date,
			'name_estalishment' => $data[6],
			'category' 		=> $category_id['category_id'],
			'spl_instruction' 		=> $data[14],
			'net_pay' 		=> $data[15],
			'created_by' 		=> $user_id,
			'created_on' 		=> $this->current_date
		);
					
		if($result == 'insert')
		{
			$pub_id = $this->sh_upload->Add_Pub_Info( $pub_info );
			
		}else{
					
			$pub_id = $pub_id;
						
		}
					
		$str = strtotime($data[5]);
		$month = date('m', $str);
		$year  = date('Y', $str);
		
		$strdate = strtotime($data[10]);
		
		$start_date = date('Y-m-d', $strdate);
		
		$enddate = strtotime($data[11]);
		
		$end_date = date('Y-m-d', $enddate);
		
		$ad_info = array(
			'pub_information_id'	=> $pub_id,	
			'month'	=> $month,
			'year'	=> $year,
			'product_name' => $data[8],
			'start_date' => $start_date,
			'end_date' => $end_date,
			'publish_date' => $data[13],
			'publish_type' => $code_id,
			'offered_rate' => $data[12],
			'created_on' 		=> $this->current_date
		);
					
		$ad_valid = $this->sh_upload->Valid_Ad_data( $ad_info, $form_type );
		
		if($ad_valid == '' || $ad_valid == null)
			$ad_response = $this->sh_upload->Add_Ad_Info( $ad_info );
			
		return $ad_response;
	}
	
	
	
	function failed()
	{
	
		$sessionUserdata = $this->session->userdata('ECITY');
            
		if(!isset($sessionUserdata['user_id']) )
		{
		 	redirect(SITE_URL."home/welcome/");      
		}
		
        $filename = 'site/'.SITE_LANG.'/upload.html' ;

		$msg = $this->url_input[$this->url_count];
		
		$msg1 = $this->url_input[$this->url_category];
		
        $this->mysmarty->assign('msg', $msg. " " .$msg1. " Not Found in Database. Please check and update");
		
		
        $this->mysmarty->assign('sess',$sessionUserdata);
        $this->mysmarty->assign('filename',$filename);
        $this->mysmarty->display('site/home.html'); 
	}
	
}
/* End of file home.php */
?>