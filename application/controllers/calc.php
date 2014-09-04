<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	/**
	 * Controller  : Home, Landing Page
	 * Created on  : 21-Nov-2011
	 * Created By  : Vijayaragavan S
	 * Modified On :
	 * Modified By :	  
	 * Project     : Rightern
	 */

class Calc extends CI_Controller {
	
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
	
	
	public function Get_Count_Insertions()
	{
	
		$sessionUserdata = $this->session->userdata('ECITY');
            
		if(!isset($sessionUserdata['user_id']) )
		{
		 	redirect(SITE_URL."home/index/");
		}
		
		$start_date = $this->security->xss_clean( $this->input->get("start_date") );
		$end_date = $this->security->xss_clean( $this->input->get("end_date") );
		$month = $this->security->xss_clean( $this->input->get("checkrow") );
		$case_validation = $this->security->xss_clean( $this->input->get("case_validation") );
		$case_count = $this->security->xss_clean( $this->input->get("case_count") );
		
		if($month == 'Mon')
		{
			$month_case = 1;
		}
		else if($month == 'Tue')
		{
			$month_case = 2;
		}
		else if($month == 'Wed')
		{
			$month_case = 3;
		}
		else if($month == 'Thu')
		{
			$month_case = 4;
		}
		else if($month == 'Fri')
		{
			$month_case = 5;
		}
		else if($month == 'Sat')
		{
			$month_case = 6;
		}
		else if($month == 'Sun')
		{
			$month_case = 0;
		}

		$dateArr = $this->getDateForSpecificDayBetweenDates($start_date , $end_date, $month_case ); // 0 Sun, 1 Mon, etc.

		if($case_validation == 'checked')
		{
			$totals = $case_count + $dateArr;
			
		}else{
			$totals = $case_count - $dateArr;
		
		}
		echo $totals;
		die;
	}
	
	function getDateForSpecificDayBetweenDates($start, $end, $weekday = 0)
	{
	
		$weekdays="Sunday,Monday,Tuesday,Wednesday,Thursday,Friday,Saturday";
		
		$arr_weekdays=split(",", $weekdays);
		$weekday = $arr_weekdays[$weekday];
		if(!$weekday)
		    die(0);
		
		$start= strtotime("+0 day", strtotime($start) );
		$end= strtotime($end);
		
		$dateArr = array();
		$friday = strtotime($weekday, $start);
		while($friday <= $end)
		{
		    $dateArr[] = date("Y-m-d", $friday);
		    $friday = strtotime("+1 weeks", $friday);
		}
		$dateArr[] = date("Y-m-d", $friday);
		
		return count($dateArr) - 1;
	}

}
/* End of file home.php */
?>