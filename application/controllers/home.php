<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	/**
	 * Controller  : Home, Landing Page
	 * Created on  : 21-Nov-2011
	 * Created By  : Vijayaragavan S
	 * Modified On :
	 * Modified By :	  
	 * Project     : Rightern
	 */

class Home extends CI_Controller {
	
	function __construct()
    {
        parent::__construct();        			
        // load the necessary libraries
        $this->load->library('form_validation');
        $this->load->library('parser');
        $this->load->helper(array('form', 'url', 'cookie'));
        $this->load->library('core/sh_views');
        $this->load->library('core/sh_dashboard');
        $this->load->library('core/sh_users');
        
        
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
		 	//redirect(SITE_URL."reports/Revenue_Report/?form_type=&start_month=&start_year=2013&start_session=&end_month=&end_year=2014&end_session=&populate=GO&response=add");      
		 	redirect(SITE_URL."home/welcome");      
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
		 	redirect(SITE_URL."home/index/");
		}
		$msg = $this->url_input[$this->url_count];
		if($msg == 'success')
		{
		        	$this->mysmarty->assign('success', "Cancelled Successfully");		
		}else if($msg == 'failed') {
		        	$this->mysmarty->assign('error', "Failed");		
		}
		        $filename = 'site/'.SITE_LANG.'/dashboard.html' ;
		        $this->mysmarty->assign('sess',$sessionUserdata);
		        $this->mysmarty->assign('filename',$filename);
		        $this->mysmarty->display('site/home.html'); 
	}
	public function LeaderBoard( $start_date, $end_date )
	{
		 $dash = $this->sh_dashboard->Dashboard_Info( $start_date, $end_date  );
		 echo json_encode($dash);
		 die;
	}
	
	public function ManageUsers( )
	{
	
		$sessionUserdata = $this->session->userdata('ECITY');
            
		if(!isset($sessionUserdata['user_id']) )
		{
		 	redirect(SITE_URL."home/index/");
		}
		
		$users_list = $this->sh_views->Users_List( );
		
		
        $filename = 'site/'.SITE_LANG.'/manage_users.html' ;
				
        $this->mysmarty->assign('users_list',$users_list);
        $this->mysmarty->assign('sess',$sessionUserdata);
        $this->mysmarty->assign('filename',$filename);
        $this->mysmarty->display('site/home.html'); 
	}

	
	
	public function ManageCompanies()
	{
	
		$sessionUserdata = $this->session->userdata('ECITY');
            
		if(!isset($sessionUserdata['user_id']) )
		{
		 	redirect(SITE_URL."home/index/");
		}
		
		$clients_list = $this->sh_views->Clients_List( );
		
		
        $filename = 'site/'.SITE_LANG.'/manage_companies.html' ;
				
        $this->mysmarty->assign('clients_list',$clients_list);
        $this->mysmarty->assign('sess',$sessionUserdata);
        $this->mysmarty->assign('filename',$filename);
        $this->mysmarty->display('site/home.html'); 
	}


	public function ManageCategories()
	{
	
		$sessionUserdata = $this->session->userdata('ECITY');
            
		if(!isset($sessionUserdata['user_id']) )
		{
		 	redirect(SITE_URL."home/index/");
		}
		
		$categories_list = $this->sh_views->Categories_List( );
		
        $filename = 'site/'.SITE_LANG.'/manage_categories.html' ;
				
        $this->mysmarty->assign('categories_list',$categories_list);
        $this->mysmarty->assign('sess',$sessionUserdata);
        $this->mysmarty->assign('filename',$filename);
        $this->mysmarty->display('site/home.html'); 
	}
	
	

	public function ChangePassword()
	{
	
		$sessionUserdata = $this->session->userdata('ECITY');
            
		if(!isset($sessionUserdata['user_id']) )
		{
		 	redirect(SITE_URL."home/index/");
		}
		
        $filename = 'site/'.SITE_LANG.'/change_password.html' ;
				
        $this->mysmarty->assign('sess',$sessionUserdata);
        $this->mysmarty->assign('filename',$filename);
        $this->mysmarty->display('site/home.html'); 
	}
	
	
	
	function ROForm( )
	{
	
		$sessionUserdata = $this->session->userdata('ECITY');
            
		if(!isset($sessionUserdata['user_id']) )
		{
		 	redirect(SITE_URL."home/index/");
		}
		
        $filename = 'site/'.SITE_LANG.'/form_list.html' ;
				
        $this->mysmarty->assign('sess',$sessionUserdata);
        $this->mysmarty->assign('filename',$filename);
        $this->mysmarty->display('site/home.html'); 	
	}
	
	
	
	function AddProduct( )
	{
		
	
		$sessionUserdata = $this->session->userdata('ECITY');
            
		if(!isset($sessionUserdata['user_id']) )
		{
		 	redirect(SITE_URL."home/index/");
		}
		
        $filename = 'site/'.SITE_LANG.'/add_product.html' ;
				
        $this->mysmarty->assign('sess',$sessionUserdata);
        $this->mysmarty->assign('filename',$filename);
        $this->mysmarty->display('site/home.html'); 	
	}
	
	
	function ManageAdType( )
	{
		
	
		$sessionUserdata = $this->session->userdata('ECITY');
            
		if(!isset($sessionUserdata['user_id']) )
		{
		 	redirect(SITE_URL."home/index/");
		}
		
		$adtype_list = $this->sh_views->AdType_List( );
		
        $filename = 'site/'.SITE_LANG.'/manage_adtype.html' ;
				
        $this->mysmarty->assign('adtype_list', $adtype_list);
        $this->mysmarty->assign('sess',$sessionUserdata);
        $this->mysmarty->assign('filename',$filename);
        $this->mysmarty->display('site/home.html'); 	
	}
	
	
	function AddAdType( )
	{
		
		$sessionUserdata = $this->session->userdata('ECITY');
            
		if(!isset($sessionUserdata['user_id']) )
		{
		 	redirect(SITE_URL."home/index/");
		}
		
		$response = $this->security->xss_clean( $this->input->post("response") );
		
		if( $response == 'add')
		{
			
			$form_type = $this->security->xss_clean( $this->input->post("form_type") );

			$code_type = $this->security->xss_clean( $this->input->post("code_type") );
			
			$codes = $this->security->xss_clean( $this->input->post("codes") );
			
			$rack_rate = $this->security->xss_clean( $this->input->post("rack_rate") );
			

			$category = $this->sh_users->Add_AdType_Info( $form_type, $code_type, $codes, $rack_rate );
			
			echo $category;
			die;
		}else{
			
			$filename = 'site/'.SITE_LANG.'/add_adtype.html' ;
					
	        $this->mysmarty->assign('sess',$sessionUserdata);
	        $this->mysmarty->assign('filename',$filename);
	        $this->mysmarty->display('site/home.html'); 	
		}
		
	}
}

/* End of file home.php */
?>