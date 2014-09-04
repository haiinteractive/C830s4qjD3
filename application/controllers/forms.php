<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	/**
	 * Controller  : Home, Landing Page
	 * Created on  : 21-Nov-2011
	 * Created By  : Vijayaragavan S
	 * Modified On :
	 * Modified By :	  
	 * Project     : Rightern
	 */

class Forms extends CI_Controller {
	
	function __construct()
    {
        parent::__construct();        			
        // load the necessary libraries
        $this->load->library('form_validation');
        $this->load->library('parser');
        $this->load->helper(array('form', 'url', 'cookie'));
        $this->load->library('core/sh_views');
        
        
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
	
	
	public function welcome()
	{
		
		$sessionUserdata = $this->session->userdata('ECITY');
            
		if(!isset($sessionUserdata['user_id']) )
		{
		 	redirect(SITE_URL."users/index/");
		}
		
		
        $filename = 'site/'.SITE_LANG.'/dashboard.html' ;
				
        $this->mysmarty->assign('sess',$sessionUserdata);
        $this->mysmarty->assign('filename',$filename);
        $this->mysmarty->display('site/home.html'); 
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
			
				$i = 0;
				
			   $pub_id = $this->sh_views->Add_Pub_Information( $company_id, $RO_Number, $form_type, $Name_Establishment, $Category_Business, $user_city, $Sales_Person, $Approving_Authonity, $approve_date, $Net_Pay, $Special_Instruction, $sessionUserdata['user_id'] );
			   
				if($pub_id )
				{
				
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
									if($form_type =='EG')
									{
									
										$session = $dates[0];
									
									}
									$str = strtotime($dates[1] .$dates[2]);
									$month = date('m', $str);
									$year  = date('Y', $str);
									
									$company_info = $this->sh_views->Insert_Ad_Type( $pub_id, $codes, $data, $month, $year, $OfferRate_row , $session, $publish_city_row ); // Exec Form
								}
							}
							$i++;
						}
				}	
				
		 	redirect(SITE_URL."forms/Exec_Form/success");
								
		}else{
		
			$company_info = $this->sh_views->Clients_List( );
					
			$users = $this->sh_views->Users_List( );
			
			$categories_list = $this->sh_views->Categories_List( );
						
			$codes_list = $this->sh_views->Codes_List( 1 ); // 1 - Exec Form
			
			$filename = 'site/'.SITE_LANG.'/exec_form.html' ;
			
	        $this->mysmarty->assign('users',$users);
	        
	        $msg = $this->url_input[$this->url_count];
	        
	        if( !empty( $msg) )
	        {
	        	$this->mysmarty->assign('success', "Inserted Successfully");
	        }
	        
	        $arg[]		= 'Select';
	        foreach( $codes_list as $list )
	        {
	        	$arg[$list['code_id']] =  $list['code'];
	        }
	        
	        $this->mysmarty->assign('current_date', date('Y-m-d'));
	        
	        $this->mysmarty->assign('codesinfo',$codes_list);
	        $this->mysmarty->assign('codes_list',$arg);
	        $this->mysmarty->assign('categories_list',$categories_list);
	        $this->mysmarty->assign('company_info',$company_info);
	        $this->mysmarty->assign('sess',$sessionUserdata);
	        $this->mysmarty->assign('filename',$filename);
	        $this->mysmarty->display('site/home.html'); 	
		}
	}
	
	
	
	function Get_Rack_Rate()
	{
		
		$sessionUserdata = $this->session->userdata('ECITY');
            
		if(!isset($sessionUserdata['user_id']) )
		{
		 	redirect(SITE_URL."home/index/");
		}
		
		$pro_type = $this->security->xss_clean( $this->input->get("PType") );
		$add_type = $this->security->xss_clean( $this->input->get("AddType") );
		
		
		$rate = $this->sh_views->Get_Rack_Rate( $pro_type, $add_type ); // Exec Form
		
		echo $rate['rack_rate'];
		die;
		
	}
	
	function Get_Company_Info( )
	{
		
		$sessionUserdata = $this->session->userdata('ECITY');
            
		if(!isset($sessionUserdata['user_id']) )
		{
		 	redirect(SITE_URL."home/index/");
		}
		
		$company_id = $this->security->xss_clean( $this->input->post("company_id") );
		
		$companies = $this->sh_views->Get_Company_Info( $company_id ); // Exec Form
		
		print json_encode( $companies );
		die;
		
	}
	



	function RO_Form( )
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
			
				$i = 0;
				
			   $pub_id = $this->sh_views->Add_Pub_Information( $company_id, $RO_Number, $form_type, $Name_Establishment, $Category_Business, $user_city, $Sales_Person, $Approving_Authonity, $approve_date, $Net_Pay, $Special_Instruction, $sessionUserdata['user_id'] );
			   
				if($pub_id )
				{
				
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
									
									$company_info = $this->sh_views->Insert_Ad_Type( $pub_id, $codes, $data, $month, $year, $OfferRate_row , $session, $publish_city_row ); // Exec Form
								}
							}
							$i++;
						}
				}	
				
		 	redirect(SITE_URL."forms/RO_Form/success");
								
		}else{
			
			$company_info = $this->sh_views->Clients_List( );

			$users = $this->sh_views->Users_List( );

			$categories_list = $this->sh_views->Categories_List( );

			$codes_list = $this->sh_views->Codes_List( 2 ); // 1 - Ro Form
			
	        $msg = $this->url_input[$this->url_count];
	        
	        if( !empty( $msg) )
	        {
	        	$this->mysmarty->assign('success', "Inserted Successfully");
	        }
	        
	        $arg[]		= 'Select';
	        foreach( $codes_list as $list )
	        {
	        	$arg[$list['code_id']] =  $list['code'];
	        }
	        
		    $filename = 'site/'.SITE_LANG.'/ro_form.html' ;
		        
	        $this->mysmarty->assign('codesinfo',$codes_list);
	        $this->mysmarty->assign('codes_list',$arg);
		    $this->mysmarty->assign('current_date', date('Y-m-d'));
		    $this->mysmarty->assign('users',$users);
		    $this->mysmarty->assign('categories_list',$categories_list);
		    $this->mysmarty->assign('categories',$categories_list);
		    $this->mysmarty->assign('company_info',$company_info);	        
		    $this->mysmarty->assign('sess',$sessionUserdata);
		    $this->mysmarty->assign('filename',$filename);
		    $this->mysmarty->display('site/home.html'); 	
		}
		
	}
	
	
	
	function Digital_Form()
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
			
				$i = 0;
				
			   $pub_id = $this->sh_views->Add_Pub_Information( $company_id, $RO_Number, $form_type , $Name_Establishment, $Category_Business, $user_city, $Sales_Person, $Approving_Authonity, $approve_date, $Net_Pay, $Special_Instruction, $sessionUserdata['user_id'] );

				if($pub_id )
				{

					//$last_inserted_id = $this->sh_view->Last_Inserted_Id( );
				
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
																	
									$company_info = $this->sh_views->Insert_Digital_Ad_Type( $pub_id, $codes, $data, $OfferRate_row, $product_row, $start_date, $end_date, $month, $year ); // Digital Form
									
								}
							}
							$i++;
						}
				}	
				
		 	redirect(SITE_URL."forms/Digital_Form/success");
								
		}else{
			
			$company_info = $this->sh_views->Clients_List( );
				
			$users = $this->sh_views->Users_List( );
				
			$categories_list = $this->sh_views->Categories_List( );
			
			$product_list = $this->sh_views->Product_List( );
			
			$msg = $this->url_input[$this->url_count];
	        
			$codes_list = $this->sh_views->Codes_List( 3 ); // 3 - Digital Form
			
	        $arg[]		= 'Select';
	        foreach( $codes_list as $list )
	        {
	        	$arg[$list['code_id']] =  $list['code'];
	        }
			
	        if( !empty( $msg) )
	        {
	        	$this->mysmarty->assign('success', "Inserted Successfully");
	        }
			
		    $filename = 'site/'.SITE_LANG.'/digital_form.html' ;
		        
			$this->mysmarty->assign('current_date', date('Y-m-d'));
		    $this->mysmarty->assign('users',$users);
	        $this->mysmarty->assign('codesinfo',$codes_list);
	        $this->mysmarty->assign('codes_list',$arg);
		    $this->mysmarty->assign('product_list', $product_list);
		    $this->mysmarty->assign('categories_list', $categories_list);
		    $this->mysmarty->assign('company_info',$company_info);	        
		    $this->mysmarty->assign('sess',$sessionUserdata);
			$this->mysmarty->assign('filename',$filename);
			$this->mysmarty->display('site/home.html'); 	
		}
		
		
		
	}
	
	
}

/* End of file home.php */
?>