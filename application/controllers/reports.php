<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	/**
	 * Controller  : Home, Landing Page
	 * Created on  : 21-Nov-2011
	 * Created By  : Vijayaragavan S
	 * Modified On :
	 * Modified By :	  
	 * Project     : Rightern
	 */

class Reports extends CI_Controller {
	
	function __construct()
    {
        parent::__construct();        			
        // load the necessary libraries
        $this->load->library('form_validation');
        $this->load->library('parser');
        $this->load->helper(array('form', 'url', 'cookie'));
        $this->load->library('core/sh_views');
        $this->load->library('core/sh_report');
        $this->load->library('core/sh_calc');
        

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
	
	
	public function Issue_Reports()
	{
		
		$sessionUserdata = $this->session->userdata('ECITY');
            
		if(!isset($sessionUserdata['user_id']) )
		{
		 	redirect(SITE_URL."home/index/");
		}
		
        $filename = 'site/'.SITE_LANG.'/IssuesReport2.html' ;
				
        $this->mysmarty->assign('sess',$sessionUserdata);
        $this->mysmarty->assign('filename',$filename);
        $this->mysmarty->display('site/home.html'); 
	}
	
	
	public function report_data( )
	{
	
		$sessionUserdata = $this->session->userdata('ECITY');
            
		if(!isset($sessionUserdata['user_id']) )
		{
		 	redirect(SITE_URL."home/index/");
		}
		
		$response = $this->security->xss_clean( $this->input->get("response") );
		
		if( $response == 'add')
		{
		
			$Product = $this->security->xss_clean( $this->input->get("form_type") );
			$select_city = $this->security->xss_clean( $this->input->get("select_city") );
			$eg_month = $this->security->xss_clean( $this->input->get("eg_month") );
			$eg_year = $this->security->xss_clean( $this->input->get("eg_year") );
			$session = $this->security->xss_clean( $this->input->get("session") );

			$data = $this->sh_report->Issue_Report_data( $Product, $select_city, $eg_month, $eg_year, $session, 'basic' );
			
			$total_revenue = $this->sh_report->Total_Renevue( $Product, $select_city, $eg_month, $eg_year, $session );
			
		}

        $filename = 'site/'.SITE_LANG.'/Report2.html';
        
        $this->mysmarty->assign('product',$Product);
        $this->mysmarty->assign('city',$select_city);
        $this->mysmarty->assign('eg_month',$eg_month);
        $this->mysmarty->assign('eg_year',$eg_year);
        $this->mysmarty->assign('session',$session);
                        
        $this->mysmarty->assign('datas',$data);
        $this->mysmarty->assign('total_revenue',$total_revenue);        
        $this->mysmarty->assign('sess',$sessionUserdata);
        $this->mysmarty->assign('filename',$filename);
        $this->mysmarty->display('site/home.html'); 
	}
	
	
	
	
	function view_report()
	{

		$sessionUserdata = $this->session->userdata('ECITY');

		if(!isset($sessionUserdata['user_id']) )
		{
		 	redirect(SITE_URL."home/index/");
		}

		$response = $this->security->xss_clean( $this->input->get("response") );

		if( $response == 'add')
		{
		
			$Product = $this->security->xss_clean( $this->input->get("form_type") );
			$select_city = $this->security->xss_clean( $this->input->get("select_city") );
			$eg_month = $this->security->xss_clean( $this->input->get("eg_month") );
			$eg_year = $this->security->xss_clean( $this->input->get("eg_year") );
			$session = $this->security->xss_clean( $this->input->get("session") );

			$data = $this->sh_report->Issue_Report_data( $Product, $select_city, $eg_month, $eg_year, $session, 'all' );

			$total_revenue = $this->sh_report->Total_Renevue( $Product, $select_city, $eg_month, $eg_year, $session );
			
		}
		
        $filename = 'site/'.SITE_LANG.'/view_report.html';

        $this->mysmarty->assign('product',$Product);
        $this->mysmarty->assign('city',$select_city);
        $this->mysmarty->assign('eg_month',$eg_month);
        $this->mysmarty->assign('eg_year',$eg_year);
        $this->mysmarty->assign('session',$session);
                        
        $this->mysmarty->assign('datas',$data);
        $this->mysmarty->assign('total_revenue',$total_revenue);        
        $this->mysmarty->assign('sess',$sessionUserdata);
        $this->mysmarty->assign('filename',$filename);
        $this->mysmarty->display('site/home.html'); 
	}
	
	

	
	
	
	
	function Master_Client_List( )
	{
	
		$sessionUserdata = $this->session->userdata('ECITY');

		if(!isset($sessionUserdata['user_id']) )
		{
		 	redirect(SITE_URL."home/index/");
		}

		$response = $this->security->xss_clean( $this->input->get("response") );

		if( $response == 'add')
		{
		
			$start_month = $this->security->xss_clean( $this->input->get("start_month") );
			$start_year = $this->security->xss_clean( $this->input->get("start_year") );
			$end_month = $this->security->xss_clean( $this->input->get("end_month") );
			$end_year = $this->security->xss_clean( $this->input->get("end_year") );
			$start_session = $this->security->xss_clean( $this->input->get("start_session") );
			$end_session = $this->security->xss_clean( $this->input->get("end_session") );
			
			$data = $this->sh_report->Master_List( $start_month, $start_year, $start_session, $end_month, $end_year, $end_session );

			$total_revenue = $this->sh_report->Total_Renevue( $Product, $select_city, $eg_month, $eg_year, $session );
			
		}
		
        $filename = 'site/'.SITE_LANG.'/Report3.html';
        
        $this->mysmarty->assign('product',$Product);
        $this->mysmarty->assign('city',$select_city);
        $this->mysmarty->assign('eg_month',$eg_month);
        $this->mysmarty->assign('eg_year',$eg_year);
        $this->mysmarty->assign('session',$session);
                        
        $this->mysmarty->assign('datas',$data);
        $this->mysmarty->assign('total_revenue',$total_revenue);        
        $this->mysmarty->assign('sess',$sessionUserdata);
        $this->mysmarty->assign('filename',$filename);
        $this->mysmarty->display('site/home.html'); 
	}
	
	
	
	
	
	function Views()
	{
		
		$sessionUserdata = $this->session->userdata('ECITY');

		if(!isset($sessionUserdata['user_id']) )
		{
		 	redirect(SITE_URL."home/index/");
		}

		$id = $this->url_input[$this->url_count];
		
		$data = $this->sh_report->View_Ro( $id );
		
		$total_insertions = $this->sh_report->Total_Insertions( $data['pub_information_id'] );
		
		if($data['form_type'] == 'EG')
		{
			$pud_ate = split(' ', $data['publish_date']);
			
			$eg = $this->sh_calc->Get_EG_Label( $pud_ate['1']." ".$pud_ate['2']  );
	        $this->mysmarty->assign('eg',$eg);
		}
		else if($data['form_type'] == 'EXEC')
		{
			$exec = $this->sh_calc->Get_Exec_Label( $data['publish_date'] );
			
        	$this->mysmarty->assign('exec',$exec);
        	
		}else if($data['form_type'] == 'EXEC')
		{
		
			$digital = array('Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun');
			
        	$this->mysmarty->assign('digital',$digital);
		}		
		$filename = 'site/'.SITE_LANG.'/view_form.html';
		
		$this->mysmarty->assign('id',$id );
		$this->mysmarty->assign('data',$data);
		$this->mysmarty->assign('total_insertions',$total_insertions);
		
        $this->mysmarty->assign('sess',$sessionUserdata);
        $this->mysmarty->assign('filename',$filename);
        $this->mysmarty->display('site/home.html'); 
	}
	
	
	
	function New_Ro_Signed( )
	{
	
		$sessionUserdata = $this->session->userdata('ECITY');

		if(!isset($sessionUserdata['user_id']) )
		{
		 	redirect(SITE_URL."home/index/");
		}

		$data = $this->sh_report->New_Ro_Signed( );
		
		$total_insertions = $this->sh_report->Total_Insertions( $data['pub_information_id'] );
		
		$eg = $this->sh_calc->Get_EG_Label( );
		
		$filename = 'site/'.SITE_LANG.'/view_form.html';
        
        $this->mysmarty->assign('eg',$eg);
		$this->mysmarty->assign('total_insertions',$total_insertions);
		$this->mysmarty->assign('data',$data);
        $this->mysmarty->assign('sess',$sessionUserdata);
        $this->mysmarty->assign('filename',$filename);
        $this->mysmarty->display('site/home.html'); 
	}
	
	
	
	
	
	function Revenue_Report( )
	{
	
		$sessionUserdata = $this->session->userdata('ECITY');

		if(!isset($sessionUserdata['user_id']) )
		{
		 	redirect(SITE_URL."home/index/");
		}

		$response = $this->security->xss_clean( $this->input->get("response") );

		if( $response == 'add')
		{
		
			$start_month = $this->security->xss_clean( $this->input->get("start_month") );
			$start_year = $this->security->xss_clean( $this->input->get("start_year") );
			$end_month = $this->security->xss_clean( $this->input->get("end_month") );
			$end_year = $this->security->xss_clean( $this->input->get("end_year") );
			$start_session = $this->security->xss_clean( $this->input->get("start_session") );
			$end_session = $this->security->xss_clean( $this->input->get("end_session") );
			
			$data = $this->sh_report->Revenue_Report( $start_month, $start_year, $start_session, $end_month, $end_year, $end_session );
			
			$count_bills = $this->sh_report->Calc_Count_Bills( $start_month, $start_year, $start_session, $end_month, $end_year, $end_session);
			
			$total_revenue = $this->sh_report->Renevue_Calc( $start_month, $start_year, $start_session, $end_month, $end_year, $end_session);
			
		}
		
		
        $filename = 'site/'.SITE_LANG.'/revenue_report.html';
        
        $this->mysmarty->assign('product',$Product);
        $this->mysmarty->assign('city',$select_city);
        $this->mysmarty->assign('eg_month',$eg_month);
        $this->mysmarty->assign('eg_year',$eg_year);
        $this->mysmarty->assign('session',$session);
                        
        $this->mysmarty->assign('datas',$data);
        $this->mysmarty->assign('total_revenue',$total_revenue);        
        $this->mysmarty->assign('sess',$sessionUserdata);
        $this->mysmarty->assign('filename',$filename);
        $this->mysmarty->display('site/home.html'); 
	}
	
	
	
	
	function Edit()
	{
	
		$sessionUserdata = $this->session->userdata('ECITY');
            
		if(!isset($sessionUserdata['user_id']) )
		{
		 	redirect(SITE_URL."home/index/");
		}
		
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
			
			$pub_information_id = $this->security->xss_clean( $this->input->post("pub_id") );
			
			$pub_id = $this->sh_views->Update_Pub_Information( $company_id, $RO_Number, $form_type , $Name_Establishment, $Category_Business, $user_city, $Sales_Person, $Approving_Authonity, $approve_date, $Net_Pay, $Special_Instruction, $sessionUserdata['user_id'] );
			
			echo $pub_id;
			die;
		}
		else{
		
			$id = $this->url_input[$this->url_count];
			
			$form_details = $this->sh_report->View_Ro( $id );
			
			$data = $this->sh_report->View_Ro_Details( $id );
			
			$response = $this->security->xss_clean( $this->input->get("response") );
			
			if($form_details['form_type'] == 'EG')
			{
				$codes_list = $this->sh_views->Codes_List( 2 ); // 2 - EG Form
				$filename = 'site/'.SITE_LANG.'/edit_ro_form.html' ;
		    					
		    	$this->mysmarty->assign('values', array('FH Nov 2013', 'SH Nov 2013', 'FH Dec 2013', 'SH Dec 2013', 'FH Jan 2014', 'SH Jan 2014', 'FH Feb 2014', 'SH Feb 2014', 'FH Mar 2014', 'SH Mar 2014', 'FH Apr 2014', 'SH Apr 2014', 'FH May 2014', 'SH May 2014', 'FH Jun 2014', 'SH Jun 2014', 'FH Jul 2014', 'SH Jul 2014', 'FH Aug 2014', 'SH Aug 2014', 'FH Sep 2014', 'SH Sep 2014', 'FH Oct 2014', 'SH Oct 2014'));
			}
			else if($form_details['form_type'] == 'EXEC')
			{
				$codes_list = $this->sh_views->Codes_List( 1 ); // 1 - EXEC Form
				$filename = 'site/'.SITE_LANG.'/edit_exec_form.html' ;		
		    	
		    	$this->mysmarty->assign('values', array('Nov 2013', 'Dec 2013', 'Jan 2014', 'Feb 2014', 'Mar 2014', 'Apr 2014', 'May 2014', 'Jun 2014', 'Jul 2014', 'Aug 2014', 'Sep 2014', 'Oct 2014'));
			}
			else if($form_details['form_type'] == 'DIGITAL')
			{
				$codes_list = $this->sh_views->Codes_List( 3 ); // 3 - Digital Form
				$this->mysmarty->assign('values', array('Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'));
				$filename = 'site/'.SITE_LANG.'/edit_digital_form.html' ;		
			}
	
			$company_info = $this->sh_views->Clients_List( );
	
			$users = $this->sh_views->Users_List( );
	
			$categories_list = $this->sh_views->Categories_List( );
			
			$product_list = $this->sh_views->Product_List( );
			
			$msg = $this->url_input[$this->url_count];
	        
	        $arg[]		= 'Select';
	        foreach( $codes_list as $list )
	        {
	        	$arg[$list['code_id']] =  $list['code'];
	        }
			
		    $this->mysmarty->assign('users',$users);
	
		    $i =0;
			foreach( $data as $d )
			{
				$items[$i]['ad_data_id'] = $d['ad_data_id'];
				$items[$i]['publish_date'] = explode(',', $d['publish_date']);
				$items[$i]['insertions'] = count( explode(',', $d['publish_date']) );
				$items[$i]['start_date'] = $d['start_date'];
				$items[$i]['end_date'] = $d['end_date'];
				$items[$i]['city'] = $d['city'];
				$items[$i]['code'] = $d['publish_type'];
				$items[$i]['rack_rate'] = $d['rack_rate'];
				$items[$i]['offered_rate'] = $d['offered_rate'];
				
				$single['pub_information_id'] = $d['pub_information_id'];
				$single['spl_instructions'] = $d['spl_instruction'];
				$single['net_pay'] = $d['net_pay'];
				$single['company_id'] = $d['company_id'];
				$single['ro_number'] = $d['ro_number'];
				$single['sales_person'] = $d['sales_person'];
				$single['category'] = $d['category'];
				$single['name_estalishment'] = $d['name_estalishment'];
				$single['approving_authority'] = $d['approving_authority'];
				$single['total_insertions'] +=$items[$i]['insertions'];
				$single['user_city'] = $d['user_city'];
				$single['approve_date'] = $d['approve_date'];
				$single['count_of_item'] +=$i;
				$i++;
			}
			
			$cities = array('Bangalore'=>'Bangalore', 'Chennai'=>'Chennai','Hyderabad'=> 'Hyderabad', 'Kolkata' => 'Kolkata', 'Mumbai' =>'Mumbai', 'Delhi'=> 'Delhi' );
	
			$categories = array( '1'=> 'Business', '2'=> 'hotel', '3'=> 'Shopping', '4'=> 'Body & Soul', '5'=> 'Eating Out', '6'=> 'Nightlife', '7'=> 'Others', '8'=> 'Special' );
	
			$this->mysmarty->assign('single_data', $single);
			$this->mysmarty->assign('cities', $cities);
		    $this->mysmarty->assign('current_date', date('Y-m-d'));
		    
		    $this->mysmarty->assign('categories',$categories);
		    $this->mysmarty->assign('categories_list',$categories_list);
		    $this->mysmarty->assign('company_info',$company_info);
	
			$this->mysmarty->assign('ad_code', $arg);
			$this->mysmarty->assign('items', $items);
		    $this->mysmarty->assign('product_list', $product_list);
			$this->mysmarty->assign('selected_items', $selected_items);
		    $this->mysmarty->assign('datas',$data);
		    $this->mysmarty->assign('sess',$sessionUserdata);
		    $this->mysmarty->assign('filename',$filename);
		    $this->mysmarty->display('site/home.html'); 	
		}
		
	}
	
	
	
	function Cancel( )
	{
	
		$sessionUserdata = $this->session->userdata('ECITY');
            
		if(!isset($sessionUserdata['user_id']) )
		{
		 	redirect(SITE_URL."home/index/");
		}
		
		$id = $this->url_input[$this->url_count];
		
		$response = $this->sh_report->Cancel( $id );
		
		if($response)
		{
		 	redirect(SITE_URL."home/welcome/success");      
		}else{
		 	redirect(SITE_URL."home/welcome/failed");      		
		}
		
	}
	
	
	
	function MIS_Report( )
	{
		
		$sessionUserdata = $this->session->userdata('ECITY');

		if(!isset($sessionUserdata['user_id']) )
		{
		 	redirect(SITE_URL."home/index/");
		}

		$response = $this->security->xss_clean( $this->input->get("response") );

		if( $response == 'add')
		{
		
			$start_month = $this->security->xss_clean( $this->input->get("start_month") );
			$start_year = $this->security->xss_clean( $this->input->get("start_year") );
			$end_month = $this->security->xss_clean( $this->input->get("end_month") );
			$end_year = $this->security->xss_clean( $this->input->get("end_year") );
			$start_session = $this->security->xss_clean( $this->input->get("start_session") );
			$end_session = $this->security->xss_clean( $this->input->get("end_session") );
			
			$data = $this->sh_report->Revenue_Report( $start_month, $start_year, $start_session, $end_month, $end_year, $end_session );
			
			$count_bills = $this->sh_report->Calc_Count_Bills( $start_month, $start_year, $start_session, $end_month, $end_year, $end_session);
			
			$total_revenue = $this->sh_report->Renevue_Calc( $start_month, $start_year, $start_session, $end_month, $end_year, $end_session);
			
		}
		
		$users = $this->sh_views->Users_List( );
		$categories_list = $this->sh_views->Categories_List( );
		$codes_list = $this->sh_views->Codes_List( 'all' ); // all - All Adtype List
		$company_info = $this->sh_views->Inactive_Clients_List( );
		
		$filename = 'site/'.SITE_LANG.'/mis_report.html';
        
        $this->mysmarty->assign('company_info',$company_info);
		$this->mysmarty->assign('codes_list',$codes_list);
		$this->mysmarty->assign('categories_list',$categories_list);
		$this->mysmarty->assign('users',$users);
        $this->mysmarty->assign('sess',$sessionUserdata);
        $this->mysmarty->assign('filename',$filename);
        $this->mysmarty->display('site/home.html'); 
	}
	
	
	
	
	public function Sales_Report( )
	{
	
		$sessionUserdata = $this->session->userdata('ECITY');
            
		if(!isset($sessionUserdata['user_id']) )
		{
		 	redirect(SITE_URL."home/index/");
		}
		
		$response = $this->security->xss_clean( $this->input->get("response") );
		
		if( $response == 'add')
		{
		
			$Sales_Person = $this->security->xss_clean( $this->input->get("Sales_Person") );
			$Category_Business = $this->security->xss_clean( $this->input->get("Category_Business") );
			$adtype = $this->security->xss_clean( $this->input->get("adtype") );
			$lapsed_client = $this->security->xss_clean( $this->input->get("lapsed_client") );

			$data = $this->sh_report->Sales_Report_data( $Sales_Person, $Category_Business, $adtype, $lapsed_client );
			
			$total_revenue = $this->sh_report->Sales_Total_Renevue( $Sales_Person, $Category_Business, $adtype, $lapsed_client );
			
		}
		$users = $this->sh_views->Users_List( );
		$categories_list = $this->sh_views->Categories_List( );
		$codes_list = $this->sh_views->Codes_List( 'all' ); // all - All Adtype List
		$company_info = $this->sh_views->Inactive_Clients_List( );
		
		
        $filename = 'site/'.SITE_LANG.'/mis_report.html';
		
        
        $this->mysmarty->assign('company_info',$company_info);
		$this->mysmarty->assign('codes_list',$codes_list);
		$this->mysmarty->assign('categories_list',$categories_list);
        
		
        $this->mysmarty->assign('Sales_Person',$Sales_Person);
        $this->mysmarty->assign('Category',$Category_Business);
        $this->mysmarty->assign('Adtype',$adtype);
        $this->mysmarty->assign('lapsed_client',$lapsed_client);
                        
        $this->mysmarty->assign('users',$users);
        $this->mysmarty->assign('datas',$data);
        $this->mysmarty->assign('total_revenue',$total_revenue);        
        $this->mysmarty->assign('sess',$sessionUserdata);
        $this->mysmarty->assign('filename',$filename);
        $this->mysmarty->display('site/home.html'); 
	}
	
	
	
	public function SalesP_Report()
	{
	
		$sessionUserdata = $this->session->userdata('ECITY');

		if(!isset($sessionUserdata['user_id']) )
		{
		 	redirect(SITE_URL."home/index/");
		}

		$response = $this->security->xss_clean( $this->input->get("response") );

		if( $response == 'add')
		{
		
			$Sales_Person = $this->security->xss_clean( $this->input->get("Sales_Person") );
			$start_date = $this->security->xss_clean( $this->input->get("start_date") );
			$end_date = $this->security->xss_clean( $this->input->get("end_date") );
			
			$data = $this->sh_report->Sales_Person_Report( $start_date, $end_date, $Sales_Person );
			
			$count_bills = $this->sh_report->Sales_Calc_Count_Bills( $start_date, $end_date, $Sales_Person );
			
			$total_revenue = $this->sh_report->Sales_Renevue_Calc( $start_date, $end_date, $Sales_Person );
			
		}
		
		$users = $this->sh_views->Users_List( );
		$categories_list = $this->sh_views->Categories_List( );
		$codes_list = $this->sh_views->Codes_List( 'all' ); // all - All Adtype List
		$company_info = $this->sh_views->Inactive_Clients_List( );
		
		$filename = 'site/'.SITE_LANG.'/sales_person_report.html';
        
		$this->mysmarty->assign('datas',$data);
		$this->mysmarty->assign('total_revenue',$total_revenue);
		$this->mysmarty->assign('count_bills',$count_bills);
		$this->mysmarty->assign('users',$users);
        $this->mysmarty->assign('sess',$sessionUserdata);
        $this->mysmarty->assign('filename',$filename);
        $this->mysmarty->display('site/home.html'); 
	}
}

/* End of file home.php */
?>