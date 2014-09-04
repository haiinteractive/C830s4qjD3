<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	/**
	 * Controller  : Home, Landing Page
	 * Created on  : 21-Nov-2011
	 * Created By  : Vijayaragavan S
	 * Modified On :
	 * Modified By :	  
	 * Project     : Rightern
	 */

class Updates extends CI_Controller {
	
	function __construct()
    {
        parent::__construct();        			
        // load the necessary libraries
        $this->load->library('form_validation');
        $this->load->library('parser');
        $this->load->helper(array('form', 'url', 'cookie'));
        $this->load->library('core/sh_views');
        $this->load->library('core/sh_updates');
        
        
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
            
		if(isset($sessionUserdata['user_id']) )
		{
		 	redirect(SITE_URL."home/welcome/");      
		}
		
		
        $filename = 'site/'.SITE_LANG.'/login.html' ;
				
        $this->mysmarty->assign('filename',$filename);
        $this->mysmarty->display('site/home.html'); 
		
	}
	
	
	public function Ro_Form()
	{
	
		$sessionUserdata = $this->session->userdata('ECITY');
            
		if(!isset($sessionUserdata['user_id']) )
		{
		 	redirect(SITE_URL."home/index/");
		}
		
		$response = $this->security->xss_clean( $this->input->post("response") );
		
		if( $response == 'add')
		{
		
			$company_id = $this->security->xss_clean( $this->input->post("company_name") );
			$RO_Number = $this->security->xss_clean( $this->input->post("RO_Number") );
			
			$form_type = $this->security->xss_clean( $this->input->post("form_type") );
			$Name_Establishment = $this->security->xss_clean( $this->input->post("Name_Establishment") );
			$Category_Business = $this->security->xss_clean( $this->input->post("Category_Business") );
			$user_city = $this->security->xss_clean( $this->input->post("user_city") );
			$Net_Pay = $this->security->xss_clean( $this->input->post("Net_Pay") );
			$Special_Instruction = $this->security->xss_clean( $this->input->post("Special_Instruction") );
			
			$Sales_Person = $this->security->xss_clean( $this->input->post("Sales_Person") );
			
			$Approving_Authonity = $this->security->xss_clean( $this->input->post("Approving_Authonity") );
			
			$approve_date = $this->security->xss_clean( $this->input->post("approve_date") );
			
			$pub_id = $this->security->xss_clean( $this->input->post("pub_id") );

			$i =0;
			 $arg = array(
			 			'pub_status'	=> '0'
			 			);

			$inactive = $this->sh_updates->Inactive_Pub( $arg, $pub_id );
			
			if($inactive)
			{
				$result = $this->sh_views->Add_Pub_Information( $company_id, $RO_Number, $form_type , $Name_Establishment, $Category_Business, $user_city, $Sales_Person, $Approving_Authonity, $approve_date, $Net_Pay, $Special_Instruction, $sessionUserdata['user_id'], $pub_id );
			}	
				
				if($result )
				{
				
					//$remove_ad_data = $this->sh_updates->Remove_Ad_Type( $pub_id ); // Exec Form
					$inactive = $this->sh_updates->Inactive_Ad_Type( $pub_id );
				
					while( $row = $this->security->xss_clean( $this->input->post("row".$i) ) )
						{
							if( $this->security->xss_clean( $this->input->post("row".$i) ) )
							{
								$codes = $this->security->xss_clean( $this->input->post("publish_AddType_row".$i) );
								
								$OfferRate_row = $this->security->xss_clean( $this->input->post("OfferRate_row".$i) );
								
								$publish_city_row = $this->security->xss_clean( $this->input->post("publish_city_row".$i) );
																
								foreach( $row as $data )
								{
									$dates =explode(" ", $data);
									$session = $dates[0];
									$str = strtotime($dates[1] .$dates[2]);
									$month = date('m', $str);
									$year  = date('Y', $str);

									$company_info = $this->sh_views->Insert_Ro_Ad_Type( $result, $codes, $data, $month, $year, $OfferRate_row , $session, $publish_city_row ); // RO Form

								}
							}
							$i++;
						}
				}
		 	redirect(SITE_URL."forms/Ro_Form/success");
								
		}else{
				
		 	redirect(SITE_URL."home/welcome/");
		}
	}
	
	
	
	function Exec_Form( )
	{
	
		$sessionUserdata = $this->session->userdata('ECITY');
            
		if(!isset($sessionUserdata['user_id']) )
		{
		 	redirect(SITE_URL."home/index/");
		}
		
		$response = $this->security->xss_clean( $this->input->post("response") );
		
		if( $response == 'add')
		{
		
			$company_id = $this->security->xss_clean( $this->input->post("company_name") );
			$RO_Number = $this->security->xss_clean( $this->input->post("RO_Number") );
			
			$form_type = $this->security->xss_clean( $this->input->post("form_type") );
			$Name_Establishment = $this->security->xss_clean( $this->input->post("Name_Establishment") );
			$Category_Business = $this->security->xss_clean( $this->input->post("Category_Business") );
			$user_city = $this->security->xss_clean( $this->input->post("user_city") );
			$Net_Pay = $this->security->xss_clean( $this->input->post("Net_Pay") );
			$Special_Instruction = $this->security->xss_clean( $this->input->post("Special_Instruction") );
			
			$Sales_Person = $this->security->xss_clean( $this->input->post("Sales_Person") );
			
			$Approving_Authonity = $this->security->xss_clean( $this->input->post("Approving_Authonity") );
			
			$approve_date = $this->security->xss_clean( $this->input->post("approve_date") );
			
			$pub_id = $this->security->xss_clean( $this->input->post("pub_id") );
			
			$i = 0;
			$arg = array(
			 			'pub_status'	=> '0'
			 			);

			$inactive = $this->sh_updates->Inactive_Pub( $arg, $pub_id );
			
			if($inactive)
			{
			
				$result = $this->sh_views->Add_Pub_Information( $company_id, $RO_Number, $form_type , $Name_Establishment, $Category_Business, $user_city, $Sales_Person, $Approving_Authonity, $approve_date, $Net_Pay, $Special_Instruction, $sessionUserdata['user_id'], $pub_id );
			}	
				
				if($result )
				{

					//$remove_ad_data = $this->sh_updates->Remove_Ad_Type( $pub_id ); // Exec Form
					$inactive = $this->sh_updates->Inactive_Ad_Type( $pub_id );
				
					while( $row = $this->security->xss_clean( $this->input->post("row".$i) ) )
						{
							if( $this->security->xss_clean( $this->input->post("row".$i) ) )
							{
								$codes = $this->security->xss_clean( $this->input->post("publish_AddType_row".$i) );
								
								$OfferRate_row = $this->security->xss_clean( $this->input->post("OfferRate_row".$i) );
								
								$publish_city_row = $this->security->xss_clean( $this->input->post("publish_city_row".$i) );
																
								foreach( $row as $data )
								{
									$dates =explode(" ", $data);
									$session = $dates[0];
									$str = strtotime($dates[1] .$dates[2]);
									$month = date('m', $str);
									$year  = date('Y', $str);

									$company_info = $this->sh_views->Insert_Ad_Type( $result, $codes, $data, $month, $year, $OfferRate_row , $session, $publish_city_row ); // Exec Form
								}
							}
							$i++;
						}
				}
		 	redirect(SITE_URL."forms/Exec_Form/success");
								
		}else{
				
		 	redirect(SITE_URL."home/welcome/");
		}
	}
	
	
	
	
	
	public function Digital_Form()
	{
	
		$sessionUserdata = $this->session->userdata('ECITY');
            
		if(!isset($sessionUserdata['user_id']) )
		{
		 	redirect(SITE_URL."home/index/");
		}
		
		$response = $this->security->xss_clean( $this->input->post("response") );
		
		if( $response == 'add')
		{
		
			$company_id = $this->security->xss_clean( $this->input->post("company_name") );
			$RO_Number = $this->security->xss_clean( $this->input->post("RO_Number") );
			
			$form_type = $this->security->xss_clean( $this->input->post("form_type") );
			$Name_Establishment = $this->security->xss_clean( $this->input->post("Name_Establishment") );
			$Category_Business = $this->security->xss_clean( $this->input->post("Category_Business") );
			$user_city = $this->security->xss_clean( $this->input->post("user_city") );
			$Net_Pay = $this->security->xss_clean( $this->input->post("Net_Pay") );
			$Special_Instruction = $this->security->xss_clean( $this->input->post("Special_Instruction") );
			
			$Sales_Person = $this->security->xss_clean( $this->input->post("Sales_Person") );
			
			$Approving_Authonity = $this->security->xss_clean( $this->input->post("Approving_Authonity") );
			
			$approve_date = $this->security->xss_clean( $this->input->post("approve_date") );
			
			$pub_id = $this->security->xss_clean( $this->input->post("pub_id") );
			
			
			$i = 0;

			 $arg = array(
			 			'pub_status'	=> '0'
			 			);

			$inactive = $this->sh_updates->Inactive_Pub( $arg, $pub_id );
			
			if($inactive)
			{
			
				$result = $this->sh_views->Add_Pub_Information( $company_id, $RO_Number, $form_type , $Name_Establishment, $Category_Business, $user_city, $Sales_Person, $Approving_Authonity, $approve_date, $Net_Pay, $Special_Instruction, $sessionUserdata['user_id'], $pub_id );
			}	
				
				if($result )
				{

					//$remove_ad_data = $this->sh_updates->Remove_Ad_Type( $pub_id ); // Exec Form
					$inactive = $this->sh_updates->Inactive_Ad_Type( $pub_id );
				
					while( $row = $this->security->xss_clean( $this->input->post("row".$i) ) )
						{
							if( $this->security->xss_clean( $this->input->post("row".$i) ) )
							{
								$codes = $this->security->xss_clean( $this->input->post("publish_AddType_row".$i) );
								
								$OfferRate_row = $this->security->xss_clean( $this->input->post("RackRate_row".$i) );
								
								$product_row = $this->security->xss_clean( $this->input->post("product_row".$i) );
								
								$start_date = $this->security->xss_clean( $this->input->post("start_date".$i) );
								
								$end_date = $this->security->xss_clean( $this->input->post("end_date".$i) );
								
								foreach( $row as $data )
								{
									$dates =explode(" ", $data);
									$session = $dates[0];
									$str = strtotime($this->security->xss_clean( $this->input->post("approve_date") ));
									$month = date('m', $str);
									$year  = date('Y', $str);
																	
									$company_info = $this->sh_views->Insert_Digital_Ad_Type( $result, $codes, $data, $OfferRate_row, $product_row, $start_date, $end_date, $month, $year ); // Digital Form
									
								}
															}
							$i++;
						}
				}
		 	redirect(SITE_URL."forms/Ro_Form/success");
								
		}else{
				
		 	redirect(SITE_URL."home/welcome/");
		}
	}
	
}
/* End of file home.php */
?>