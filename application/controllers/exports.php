<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	/**
	 * Controller  : Home, Landing Page
	 * Created on  : 21-Nov-2011
	 * Created By  : Vijayaragavan S
	 * Modified On :
	 * Modified By :	  
	 * Project     : Rightern
	 */

class Exports extends CI_Controller {
	
	function __construct()
    {
        parent::__construct();        			
        // load the necessary libraries
        $this->load->library('form_validation');
        $this->load->library('parser');
        $this->load->helper(array('form', 'url', 'cookie'));
        $this->load->library('core/sh_views');
        
        $this->load->library('core/sh_report');
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
	
	
	public function Sales_Report()
	{
	
		$sessionUserdata = $this->session->userdata('ECITY');
            
		if(!isset($sessionUserdata['user_id']) )
		{
		 	redirect(SITE_URL."home/index/");
		}
		
		$export = $this->security->xss_clean( $this->input->get("export") );
		
		if( $export == 1 )
		{
		
			$Sales_Person = $this->security->xss_clean( $this->input->get("Sales_Person") );
			$Category_Business = $this->security->xss_clean( $this->input->get("Category_Business") );
			$adtype = $this->security->xss_clean( $this->input->get("adtype") );
			$lapsed_client = $this->security->xss_clean( $this->input->get("lapsed_client") );

			$data = $this->sh_report->Sales_Report_data( $Sales_Person, $Category_Business, $adtype, $lapsed_client );
			
			$total_revenue = $this->sh_report->Sales_Total_Renevue( $Sales_Person, $Category_Business, $adtype, $lapsed_client );

			$contents="Ro Number, Client,Type,Sales Person,Qty,Category,Rack Rate,Discount,Net Rate,Net Bill\n";

	   		foreach($data as $visit)
	   		{
	   			$contents .= $visit['ro_number'].',';
	   			$contents .= $visit['company_name'].',';
	   			$contents .= $visit['code'].',';
	   			$contents .= $visit['sales_person'].',';
	   			$contents .= $visit['qty'].',';
	   			$contents .= $visit['category_name'].',';
	   			$contents .= $visit['rack_rate'].',';
	   			$contents .= abs( $visit['offered_rate']/$visit['rack_rate']*100-100 ).',';
	   			$contents .= $visit['rack_rate']-$visit['offered_rate'];
	   			$contents .= $visit['offered_rate'].',';
	   			$contents .= $visit['net_bill']."\n";
	   		}
	   			$contents .= "\n \n \n Total Turnover".',';
	   			$contents .= $total_revenue['total_turnover'].',';
	   			$contents .= "Net Revenue".',';
	   			$contents .= $total_revenue['total_amount'].',';
	   			$contents .= "Total Discount".',';
	   			$contents .= $total_revenue['total_turnover']-$total_revenue['total_amount'].',';
	   			$contents .= "Total Discount Of Sale".',';
	   			$contents .= abs( $total_revenue['total_amount']/$total_revenue['total_turnover']*100-100)."\n";
	   			
	   		$contents = strip_tags($contents); 
			Header("Content-Disposition: attachment; filename=export".date('d-m-Y').".csv");
			print $contents;
			die;
		}else{
				
		 	redirect(SITE_URL."home/welcome/");
		}
	}
	
	function Report_Data( )
	{
	
		$export = $this->security->xss_clean( $this->input->get("export") );

		if( $export == 1)
		{
		
			$Product = $this->security->xss_clean( $this->input->get("form_type") );
			$select_city = $this->security->xss_clean( $this->input->get("select_city") );
			$eg_month = $this->security->xss_clean( $this->input->get("eg_month") );
			$eg_year = $this->security->xss_clean( $this->input->get("eg_year") );
			$session = $this->security->xss_clean( $this->input->get("session") );

			$data = $this->sh_report->Issue_Report_data( $Product, $select_city, $eg_month, $eg_year, $session );

			$total_revenue = $this->sh_report->Total_Renevue( $Product, $select_city, $eg_month, $eg_year, $session );
			
			$contents="Ro Number, Client,Type,Sales Person,Qty,Category,Rack Rate,Discount,Net Rate,Net Bill\n";

	   		foreach($data as $visit)
	   		{
	   			$contents .= $visit['ro_number'].',';
	   			$contents .= $visit['company_name'].',';
	   			$contents .= $visit['code'].',';
	   			$contents .= $visit['sales_person'].',';
	   			$contents .= $visit['qty'].',';
	   			$contents .= $visit['category_name'].',';
	   			$contents .= $visit['rack_rate'].',';
	   			$contents .= abs( $visit['offered_rate']/$visit['rack_rate']*100-100 ).',';
	   			$contents .= $visit['rack_rate']-$visit['offered_rate'];
	   			$contents .= $visit['offered_rate'].',';
	   			$contents .= $visit['net_bill']."\n";
	   		}
	   			$contents .= "\n \n \n Total Turnover".',';
	   			$contents .= $total_revenue['total_turnover'].',';
	   			$contents .= "Net Revenue".',';
	   			$contents .= $total_revenue['total_amount'].',';
	   			$contents .= "Total Discount".',';
	   			$contents .= $total_revenue['total_turnover']-$total_revenue['total_amount'].',';
	   			$contents .= "Total Discount Of Sale".',';
	   			$contents .= abs( $total_revenue['total_amount']/$total_revenue['total_turnover']*100-100)."\n";
	   			
	   			
	   		$contents = strip_tags($contents); 
			header("Content-Disposition: attachment; filename=export".date('d-m-Y').".csv");
			print $contents;
			die;
			
		}else{
				
		 	redirect(SITE_URL."home/welcome/");
		}
	}
	
}
/* End of file home.php */
?>