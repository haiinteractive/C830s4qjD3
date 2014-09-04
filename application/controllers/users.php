<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	/**
	 * Controller  : Home, Landing Page
	 * Created on  : 21-Nov-2011
	 * Created By  : Vijayaragavan S
	 * Modified On :
	 * Modified By :	  
	 * Project     : Rightern
	 */

class Users extends CI_Controller {
	
	function __construct()
    {
        parent::__construct();        			
        // load the necessary libraries
        $this->load->library('form_validation');
        $this->load->library('parser');
        $this->load->library('core/sh_users');
        $this->load->library('core/constants');                
        $this->load->helper(array('form', 'url', 'cookie'));
        
        error_reporting(0);
        
        $this->current_date = date("Y-m-d H:i:s");
        
        $this->email_date = date("Y-M-d");
        
        $this->url = $_SERVER['REQUEST_URI'];

        $this->current_user_ip = $_SERVER['REMOTE_ADDR'];
        
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
		
		$filename = 'site/'.SITE_LANG.'/home.html' ;
				
        $this->mysmarty->assign('filename',$filename);
        $this->mysmarty->display('site/home.html'); 
		
	}
	
	
	
	/*
	 * Function: User Login
	 * Purpose : Loading the landing page
	 */	
	public function user_login()
	{
		
		
		$sessionUserdata = $this->session->userdata('ECITY');
            
		if(isset($sessionUserdata['user_id']) )
		{
		 	redirect(SITE_URL."home/welcome/");      
		}
		
		$user_name = $this->security->xss_clean( $this->input->post("user_name") );
		$user_pwd = md5( $this->security->xss_clean( $this->input->post("user_password") ) );
		
		$res = $this->sh_users->User_Login( $user_name , $user_pwd);
		
		$allowded_ips = explode(',', $res['user_allowed_ips']);
		
		foreach( $allowded_ips as $ip )
		{
			if( $ip == $this->current_user_ip || $ip == 'all')
			{
			
				if($res != 'ER' && $res != 0){
				
					$last_update = $this->sh_users->Last_Login_Update( $this->current_user_ip, $res['user_id'] );
					
					$log_response = $this->sh_users->Log_Update( $user_name, $user_pwd, $this->current_user_ip, '1' );
				
					$sessionUserdata['user_id'] = $res['user_id']; 
					$sessionUserdata['user_type'] = $res['user_type_id'];
					$sessionUserdata['user_name'] = $res['user_name'];
					$sessionUserdata['user_first_name'] = $res['user_first_name'];
					$sessionUserdata['user_last_name'] = $res['user_last_name'];
					$sessionUserdata['user_email'] = $res['user_email'];
					$sessionUserdata['user_allowed_ips'] = $res['user_allowed_ips'];
					$sessionUserdata['user_last_logged_in_ip'] = $res['user_last_logged_in_ip'];
					$sessionUserdata['user_last_logged_in'] = $res['user_last_logged_in'];
					$sessionUserdata['user_created_on'] = $res['user_created_on'];
					
					$sessionUserdata['user_password'] = md5($this->input->post("user_password"));
					            
					$this->session->unset_userdata('ECITY');    
				    $this->session->set_userdata(array('ECITY'=>$sessionUserdata));
				           				           		
					// clear user lang cookie
					$cookie = array(
						'name'   => 'ss_auth_lang',
						'value'  => '',
						'expire' => '0',
						'prefix' => '',
						'path'   => '/'
					);
					delete_cookie($cookie);
					// set user lang cookie
					$cookie = array(
						'name'   => 'ss_auth_lang',
						'value'  => $res->user_id,
						'expire' => time()+60*60*24*30,
						'path'   => '/',
						'prefix' => '',
					);
		
					$this->input->set_cookie($cookie);
		
				    //echo SITE_URL."/home/index/";die;   
				           		//echo 1;
				    redirect(SITE_URL."home/welcome/");      
			        die;
				}else if($res == 0){
				
					$log_response = $this->sh_users->Log_Update( $user_name, $user_pwd, $this->current_user_ip, '0' );
					
					echo 'inactive';
					die;
					
				    //redirect(SITE_URL."home/login/failed");      
				}else if($res == 'ER'){
				
					$log_response = $this->sh_users->Log_Update( $user_name, $user_pwd, $this->current_user_ip, '0' );
					
					echo 'ER';
					die;
					//redirect(SITE_URL."home/login/failed");      
				}
			
			}else if($res == 'inactive'){
				
					$log_response = $this->sh_users->Log_Update( $user_name, $user_pwd, $this->current_user_ip, '0' );
					
					echo 'inactive';
					die;
					
				    //redirect(SITE_URL."home/login/failed");      
			}else if($res == 'ER'){
				
					$log_response = $this->sh_users->Log_Update( $user_name, $user_pwd, $this->current_user_ip, '0' );
					
					echo 'ER';
					die;
					//redirect(SITE_URL."home/login/failed");      
			}else if($res['user_allowed_ips'] > 0 ){
				
					$log_response = $this->sh_users->Log_Update( $user_name, $user_pwd, $this->current_user_ip, '0' );
					
				echo "ip";
				die;
				
			}else{
			
					$log_response = $this->sh_users->Log_Update( $user_name, $user_pwd, $this->current_user_ip, '0' );
					
				echo 'invalid';
				die;
			}
		}
		
				
	}
	
	
	
	
	function logout()
	{
		
		$last_update = false;
		
		$sessionUserdata = $this->session->userdata('ECITY');
            
		if(!isset($sessionUserdata['user_id']) )
		{
		 	redirect(SITE_URL."home/index/");      
		}

		$last_update = $this->sh_users->Last_Logged_Out_Update( $sessionUserdata['user_id'] );
	   
		if( $last_update )
		{
		   $this->session->unset_userdata('ECITY'); 
		   redirect(SITE_URL."home/index/"); 		
		}
	}
	
	
	
	function add_new_user()
	{
	
		$sessionUserdata = $this->session->userdata('ECITY');
            
		if(!isset($sessionUserdata['user_id']) || $sessionUserdata['user_type'] == 3)
		{
		 	redirect(SITE_URL."home/index/");
		}
		
		$response = $this->security->xss_clean( $this->input->post("response") );
		
		if( $response == 'add')
		{
			
			$FirstName = $this->security->xss_clean( $this->input->post("FirstName") );
			$LastName = $this->security->xss_clean( $this->input->post("LastName") );			
			$user_type = $this->security->xss_clean( $this->input->post("user_type") );
			$user_name = $this->security->xss_clean( $this->input->post("user_name") );
			$pwd = md5( $this->security->xss_clean( $this->input->post("user_password") ) );
			$user_ips = $this->security->xss_clean( $this->input->post("user_ips") );
			
			$email_availability = $this->sh_users->Check_Availability( $user_name, 'users');
			
			if($email_availability == false )
			{
				$user_types = $this->sh_users->Add_New_User( $FirstName, $LastName, $user_type, $user_name, $pwd, $user_ips );
			
				echo $user_types;
				die;
				
			}else{
				echo 0;
				die;
			}
			
			
		}else{
		
			$user_types = $this->sh_users->Get_All_User_Type( );
			
	        $this->mysmarty->assign('user_types', $user_types);
			$filename = 'site/'.SITE_LANG.'/add_new_user.html' ;
					
	        $this->mysmarty->assign('filename',$filename);
	        $this->mysmarty->display('site/home.html'); 
		}
		
	}
	
	
	
	function add_new_category( )
	{
		
		$sessionUserdata = $this->session->userdata('ECITY');
            
		if(!isset($sessionUserdata['user_id']) )
		{
		 	redirect(SITE_URL."home/index/");
		}
		
		$response = $this->security->xss_clean( $this->input->post("response") );
		
		if( $response == 'add')
		{
		
			$category_name = $this->security->xss_clean( $this->input->post("category_name") );
			
			
			$email_availability = $this->sh_users->Check_Availability( $category_name_name, 'category');
			
			if($email_availability == false )
			{
				$user_category = $this->sh_users->Add_New_Category( $category_name );
			
				echo $user_category;
				die;
							
			}else{
				echo 0;
				die;
			}
			
		}else{
		
			$filename = 'site/'.SITE_LANG.'/add_new_category.html' ;
					
	        $this->mysmarty->assign('filename',$filename);
	        $this->mysmarty->display('site/home.html'); 
		}
		
	}
	
	
	function add_new_company( )
	{
		
		$sessionUserdata = $this->session->userdata('ECITY');
            
		if(!isset($sessionUserdata['user_id']) )
		{
		 	redirect(SITE_URL."home/index/");
		}
		
		$response = $this->security->xss_clean( $this->input->post("response") );
		
		if( $response == 'add')
		{
		
			$company_name = $this->security->xss_clean( $this->input->post("company_name") );
			$contact_person = $this->security->xss_clean( $this->input->post("contact_person") );
			$contact_no = $this->security->xss_clean( $this->input->post("contact_no") );
			$address = $this->security->xss_clean( $this->input->post("address") );
			
			$alternative_contact_no = $this->security->xss_clean( $this->input->post("alternative_contact_no") );
			$alternative_email_id = $this->security->xss_clean( $this->input->post("alternative_email_id") );
			
			
			
			$pin_code = $this->security->xss_clean( $this->input->post("pin_code") );
			$email_id = $this->security->xss_clean( $this->input->post("email_id") );
			

			$company = $this->sh_users->Add_New_Company( $company_name, $contact_person, $contact_no, $address, $email_id, $pin_code, $alternative_contact_no, $alternative_email_id );
			
			echo $company;
			die;

		}else{

			$filename = 'site/'.SITE_LANG.'/add_new_company.html' ;

	        $this->mysmarty->assign('filename',$filename);
	        $this->mysmarty->display('site/home.html'); 
		}
		
	}
	
	
	
	
	function add_new_product( )
	{
		
		$sessionUserdata = $this->session->userdata('ECITY');
            
		if(!isset($sessionUserdata['user_id']) )
		{
		 	redirect(SITE_URL."home/index/");
		}
		
		$response = $this->security->xss_clean( $this->input->post("response") );
		
		if( $response == 'add')
		{
		
			$product_name = $this->security->xss_clean( $this->input->post("product_name") );
			
			$company = $this->sh_users->Add_New_Product( $product_name );
			
			echo $company;
			die;
			
		}else{
		
			$filename = 'site/'.SITE_LANG.'/add_new_company.html' ;
					
	        $this->mysmarty->assign('filename',$filename);
	        $this->mysmarty->display('site/home.html'); 
		}
		
	}
	
	
	
	function Change_Password( )
	{
	
		$sessionUserdata = $this->session->userdata('ECITY');
            
		if(!isset($sessionUserdata['user_id']) )
		{
		 	redirect(SITE_URL."home/index/");
		}
		
		$response = $this->security->xss_clean( $this->input->post("response") );
		
		if( $response == 'add')
		{
		
			$new_password = $this->security->xss_clean( $this->input->post("new_password") );

			$company = $this->sh_users->Change_Password( $new_password, $sessionUserdata['user_id'] );
			
			echo $company;
			die;
			
		}else{
		
			$filename = 'site/'.SITE_LANG.'/add_new_company.html' ;
					
	        $this->mysmarty->assign('filename',$filename);
	        $this->mysmarty->display('site/home.html'); 
		}
	}
	
	
	
	public function EditUser( )
	{
	
		$sessionUserdata = $this->session->userdata('ECITY');
            
		if(!isset($sessionUserdata['user_id']) || $sessionUserdata['user_type'] != 1)
		{
		 	redirect(SITE_URL."home/index/");
		}
		
		$response = $this->security->xss_clean( $this->input->post("response") );
		
		if( $response == 'add')
		{
		
			$first_name = $this->security->xss_clean( $this->input->post("FirstName") );
			$last_name = $this->security->xss_clean( $this->input->post("LastName") );

			$user_email = $this->security->xss_clean( $this->input->post("user_name") );
			$user_type = $this->security->xss_clean( $this->input->post("user_type") );
			$user_ips = $this->security->xss_clean( $this->input->post("user_ips") );
			$user_id = $this->security->xss_clean( $this->input->post("user_id") );
			$user_status = $this->security->xss_clean( $this->input->post("user_is_active") );
			
			$company = $this->sh_users->Edit_User_Info( $first_name, $last_name, $user_email, $user_type, $user_ips, $user_id, $user_status );
			
			echo $company;
			die;
			
		}else{
		
			$id = $this->url_input[$this->url_count];
			
			$userinfo = $this->sh_users->UserInfo( $id );
			
			$filename = 'site/'.SITE_LANG.'/edit_user.html' ;
			
			$user_types = $this->sh_users->Get_All_User_Type( );
			
	        $this->mysmarty->assign('user_types', $user_types);
	        $this->mysmarty->assign('options', array( 1 => 'Active', 0 => 'Inactive'));
	        
	        $this->mysmarty->assign('userinfo',$userinfo);
			$this->mysmarty->assign('filename',$filename);
	        $this->mysmarty->display('site/home.html'); 
		}
		
	}
	
	
	function EditClient( )
	{
	
		$sessionUserdata = $this->session->userdata('ECITY');
            
		if(!isset($sessionUserdata['user_id']) || $sessionUserdata['user_type'] != 1)
		{
		 	redirect(SITE_URL."home/index/");
		}
		
		$response = $this->security->xss_clean( $this->input->post("response") );
		
		if( $response == 'add')
		{
		
			$company_name = $this->security->xss_clean( $this->input->post("company_name") );
			$contact_person = $this->security->xss_clean( $this->input->post("contact_person") );

			$address = $this->security->xss_clean( $this->input->post("address") );
			$pin_code = $this->security->xss_clean( $this->input->post("pin_code") );
			$contact_no = $this->security->xss_clean( $this->input->post("contact_no") );
			$email_id = $this->security->xss_clean( $this->input->post("email_id") );
			$client_id = $this->security->xss_clean( $this->input->post("client_id") );
			$client_status = $this->security->xss_clean( $this->input->post("client_status") );
			
			$company = $this->sh_users->Edit_Client_Info( $company_name, $contact_person, $address, $pin_code, $contact_no, $email_id, $client_id, $client_status );
			
			echo $company;
			die;
			
		}else{
		
			$id = $this->url_input[$this->url_count];
			
			$clientinfo = $this->sh_users->ClientInfo( $id );
			
			$filename = 'site/'.SITE_LANG.'/edit_company.html' ;
			
	        $this->mysmarty->assign('options', array( 1 => 'Active', 0 => 'Inactive'));
			$this->mysmarty->assign('clientinfo', $clientinfo);
			$this->mysmarty->assign('filename',$filename);
	        $this->mysmarty->display('site/home.html'); 
		}
		
	}
	
	
	function EditCategory( )
	{
	
		$sessionUserdata = $this->session->userdata('ECITY');
            
		if(!isset($sessionUserdata['user_id']) || $sessionUserdata['user_type'] != 1)
		{
		 	redirect(SITE_URL."home/index/");
		}
		
		$response = $this->security->xss_clean( $this->input->post("response") );
		
		$id = $this->url_input[$this->url_count];
		
		if( $response == 'add')
		{
		
			$category_name = $this->security->xss_clean( $this->input->post("category_name") );

			$category_status = $this->security->xss_clean( $this->input->post("category_status") );
			
			$category_id = $this->security->xss_clean( $this->input->post("category_id") );
			

			$category = $this->sh_users->Edit_Category_Info( $category_name, $category_status, $category_id );
			
			echo $category;
			die;
			
		}else{
		
			
			$categoryinfo = $this->sh_users->CategoryInfo( $id );
			
			$filename = 'site/'.SITE_LANG.'/edit_category.html' ;
			
	        $this->mysmarty->assign('options', array( 1 => 'Active', 0 => 'Inactive'));
			$this->mysmarty->assign('categoryinfo', $categoryinfo);
			$this->mysmarty->assign('filename',$filename);
	        $this->mysmarty->display('site/home.html'); 
		}
		
	}
	
	
	
	function add_new_ad_type( )
	{
		
		$sessionUserdata = $this->session->userdata('ECITY');
            
		if(!isset($sessionUserdata['user_id']) || $sessionUserdata['user_type'] != 1)
		{
		 	redirect(SITE_URL."home/index/");
		}
		
		$response = $this->security->xss_clean( $this->input->post("response") );
		
		$id = $this->url_input[$this->url_count];
		
		if( $response == 'add')
		{
		
			$category_name = $this->security->xss_clean( $this->input->post("category_name") );

			$category_status = $this->security->xss_clean( $this->input->post("category_status") );
			
			$category_id = $this->security->xss_clean( $this->input->post("category_id") );
			

			$category = $this->sh_users->Edit_Category_Info( $category_name, $category_status, $category_id );
			
			echo $category;
			die;
			
		}else{
		
			
			$categoryinfo = $this->sh_users->CategoryInfo( $id );
			
			$filename = 'site/'.SITE_LANG.'/edit_category.html' ;
			
	        $this->mysmarty->assign('options', array( 1 => 'Active', 0 => 'Inactive'));
			$this->mysmarty->assign('categoryinfo', $categoryinfo);
			$this->mysmarty->assign('filename',$filename);
	        $this->mysmarty->display('site/home.html'); 
		}
	}
	
	
	
	
	function EditAdType( )
	{
		
		$sessionUserdata = $this->session->userdata('ECITY');
            
		if(!isset($sessionUserdata['user_id']) || $sessionUserdata['user_type'] != 1)
		{
		 	redirect(SITE_URL."home/index/");
		}
		
		$response = $this->security->xss_clean( $this->input->post("response") );
		
		$id = $this->url_input[$this->url_count];
		if( $response == 'add')
		
		{
		
			$form_type = $this->security->xss_clean( $this->input->post("form_type") );

			$code_type = $this->security->xss_clean( $this->input->post("code_type") );
			$codes = $this->security->xss_clean( $this->input->post("codes") );
			$rack_rate = $this->security->xss_clean( $this->input->post("rack_rate") );
			
			$code_id = $this->security->xss_clean( $this->input->post("code_id") );
			
			$adtype_status = $this->security->xss_clean( $this->input->post("adtype_status") );
			

			$category = $this->sh_users->Edit_AdType_Info( $form_type, $code_type, $codes, $rack_rate, $adtype_status, $code_id );
			
			echo $category;
			die;
			
		}else{
		
			
			$adtypeinfo = $this->sh_users->AdTypeInfo( $id );
			
			$filename = 'site/'.SITE_LANG.'/edit_adtype.html' ;
			
	        $this->mysmarty->assign('options', array( 1 => 'Active', 0 => 'Inactive'));
			$this->mysmarty->assign('adtypeinfo', $adtypeinfo);
			$this->mysmarty->assign('filename',$filename);
	        $this->mysmarty->display('site/home.html'); 
		}
	}
	
	
	
	function Get_AdType( )
	{
	
		$adtypeinfo = $this->sh_users->AdTypeInfo( 'all' );
		
		var_dump($adtypeinfo);
		die;
	}
}

/* End of file home.php */
?>