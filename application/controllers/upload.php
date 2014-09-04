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
        
        $this->starts_with = 1;
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
				  
						$this->EG_Data( $form_type, $company_id, $sessionUserdata['user_id'], $ro_number, $data, $result, $pub_id );
						
						
				  }else if( $form_type == 'EXEC')
				  {
				  		
				  		$rt = $this->EXEC_Data( $form_type, $company_id, $sessionUserdata['user_id'], $ro_number, $data, $result, $pub_id  );
				  		
				  }else{
				  	
				  		$rt = $this->DIGITAL_Data( $form_type, $company_id, $sessionUserdata['user_id'], $ro_number, $data, $result, $pub_id  );

				  }
        	}
				  
        }
    } while ($data = fgetcsv($handle,1000,",","'"));
    
		redirect(SITE_URL."upload/index/success");      
        
	}
	
	
	
	function EG_Data( $form_type, $company_id, $user_id, $ro_number, $data, $result, $pub_id  )
	{
	
		$ad_response = false;
		
			$str = strtotime($data[5]);
			
			$approve_date = date('y-m-d', $str);
	
		$category_id = $this->sh_upload->Get_Category_Id( $data[7]);
		
		if($category_id['category_id'] == '' || $category_id['category_id'] == null)
		{
			redirect(SITE_URL."upload/failed/Caregory/$data[7]");      
		}
		
		$sales_person = $this->sh_upload->Get_Sales_Person_Id( $data[3]);
		
		$net_pays = explode(';', $data[13]);
		
		$pub_format = explode(';', $data[14]);
		
		$offered_rate = explode(';', $data[10]);
		
		$publish_dates = explode(';', $data[11]);
		
		$ad_codes = explode(';', $data[9]);
		
		$total_arg = count($net_pays);
		
		
		for( $starts_with = 0; $starts_with < $total_arg; $starts_with++)
		{
		
		$res = $this->sh_upload->Get_Code_Id( $ad_codes[$starts_with], $form_type );
		
			if($res['code_id'] == '' || $res['code_id'] == null)
			{
				redirect(SITE_URL."upload/failed/Advertisement_Type/$ad_codes[$starts_with]");      
			}
			
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
				'net_pay' 		=> $net_pays[$starts_with],
				'created_by' 		=> $user_id,
				'created_on' 		=> $this->current_date
			);
	
			if($result == 'insert')
			{
				$pub_id = $this->sh_upload->Add_Pub_Info( $pub_info );
				
			}else{
						
				$pub_id = $pub_id;
							
			}
			
			
			$str_pub_date = strtotime($publish_dates[$starts_with]);
			
			$dat = explode("-", trim($publish_dates[$starts_with]));
			
			$ordered_month = date('m', strtotime($dat[1]));
			
			$ordered_year = date('Y', strtotime($dat[2]));
			
			$publish_date = $dat[0]." ".$dat[1]." ".$ordered_year;
			
			$ad_info = array(
				'pub_information_id'	=> $pub_id,	
				'month'	=> $ordered_month,
				'year'	=> $ordered_year,
				'session' => $dat[0],
				'city'    => $data[8],
				'publish_date' => $publish_date,
				'publish_type' => $res['code_id'],
				'offered_rate' => $offered_rate[$starts_with],
				'created_on' 		=> $this->current_date
			);
	
			$ad_valid = $this->sh_upload->Valid_Ad_data( $ad_info, $form_type );
	
			if($ad_valid == '' || $ad_valid == null)
				$ad_response = $this->sh_upload->Add_Ad_Info( $ad_info );
	
		}
			return $ad_response;
		
	}
	
	
	
	
	function EXEC_Data( $form_type, $company_id, $user_id, $ro_number, $data, $result, $pub_id  )
	{
	
		$ad_response = false;
		
		$str = strtotime($data[5]);
			
		$approve_date = date('y-m-d', $str);
	
		$category_id = $this->sh_upload->Get_Category_Id( $data[7]);
		
		if($category_id['category_id'] == '' || $category_id['category_id'] == null)
		{
			redirect(SITE_URL."upload/failed/Caregory/$data[7]");      
		}
		
		$sales_person = $this->sh_upload->Get_Sales_Person_Id( $data[3]);
		
		
		$net_pays = explode(';', $data[12]);
		
		$ad_codes = explode(';', $data[8]);
		
		$offer_rates = explode(';', $data[9]);
		
		$publish_dates = explode(';', $data[10]);
		
		$total_arg = count($net_pays);
		
		for( $starts_with = 0; $starts_with < $total_arg; $starts_with++)
		{
		
		$res = $this->sh_upload->Get_Code_Id( $ad_codes[$starts_with], $form_type );
				  		
		if($res['code_id'] == '' || $res['code_id'] == null)
		{
			redirect(SITE_URL."upload/failed/Advertisement_Type/$ad_codes[$starts_with]");      
		}
		
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
			'net_pay' 		=> $net_pays[$starts_with],
			'created_by' 		=> $user_id,
			'created_on' 		=> $this->current_date
		);
		
		if($result == 'insert')
		{
			$pub_id = $this->sh_upload->Add_Pub_Info( $pub_info );
			
		}else{
					
			$pub_id = $pub_id;
						
		}
					
	
			$str_pub_date = strtotime($publish_dates[$starts_with]);
			
			$dat = explode("-", trim($publish_dates[$starts_with]));
			
			$ordered_month = date('m', strtotime($dat[0]));
			
			$ordered_year = date('Y', strtotime($dat[1]));
			
			$publish_date = $dat[0]." ".$ordered_year;
			
		$ad_info = array(
			'pub_information_id'	=> $pub_id,	
			'month'	=> $ordered_month,
			'year'	=> $ordered_year,
			'publish_date' => $publish_date,
			'publish_type' => $res['code_id'],
			'offered_rate' => $offer_rates[$starts_with],
			'created_on' 		=> $this->current_date
		);
							
		$ad_valid = $this->sh_upload->Valid_Ad_data( $ad_info, $form_type );
		
		if($ad_valid == '' || $ad_valid == null)
			$ad_response = $this->sh_upload->Add_Ad_Info( $ad_info );
		
		}
		
		return $ad_response;
	}
	
	
	function DIGITAL_Data( $form_type, $company_id, $user_id, $ro_number, $data, $result, $pub_id )
	{

		$ad_response = false;
	
		$str = strtotime($data[5]);
			
		$approve_date = date('y-m-d', $str);
	
		$category_id = $this->sh_upload->Get_Category_Id( $data[7]);
		
		if($category_id['category_id'] == '' || $category_id['category_id'] == null)
		{
			redirect(SITE_URL."upload/failed/Caregory/$data[7]");      
		}
		
		$ad_codes = explode(';', $data[9]);
		
		$net_pays = explode(';', $data[15]);
		
		$start_dates = explode(';', $data[10]);
		
		$end_dates = explode(';', $data[11]);
		
		$publish_dates = explode(';', $data[13]);

		$offer_rates = explode(';', $data[12]);
		
		$total_arg = count($net_pays);
		
		for( $starts_with = 0; $starts_with < $total_arg; $starts_with++)
		{
		
		$sales_person = $this->sh_upload->Get_Sales_Person_Id( $data[3]);
		
		$res = $this->sh_upload->Get_Code_Id( $ad_codes[$starts_with], $form_type );
				  	
		if($res['code_id'] == '' || $res['code_id'] == null)
		{
			redirect(SITE_URL."upload/failed/Advertisement_Type/$ad_codes[$starts_with]");      
		}
				  		
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
			'net_pay' 		=> $net_pays[$starts_with],
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
		
		$strdate = strtotime($start_dates[$starts_with]);
		
		$start_date = date('Y-m-d', $strdate);
		
		$enddate = strtotime($end_dates[$starts_with]);
		
		$end_date = date('Y-m-d', $enddate);
	
		$str_pub_date = strtotime($publish_dates[$starts_with]);
			
		$dat = explode("-", trim($publish_dates[$starts_with]));
			
		
		$ad_info = array(
			'pub_information_id'	=> $pub_id,	
			'month'	=> $month,
			'year'	=> $year,
			'product_name' => $data[8],
			'start_date' => $start_date,
			'end_date' => $end_date,
			'publish_date' => $publish_dates[$starts_with],
			'publish_type' => $res['code_id'],
			'offered_rate' => $offer_rates[$starts_with],
			'created_on' 		=> $this->current_date
		);
					
		$ad_valid = $this->sh_upload->Valid_Ad_data( $ad_info, $form_type );
		
		if($ad_valid == '' || $ad_valid == null)
			$ad_response = $this->sh_upload->Add_Ad_Info( $ad_info );
		
		}
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