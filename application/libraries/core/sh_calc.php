<?php
/**
 * The Users class file.
 *
 * @category Users
 * @package  None
 * @author   Anoop KP
 * @license  http://www.skillsweet.com 
 * @link     models/users_model.php
 * 
 */
 
class Sh_Calc
{
    private $_CI;    
    

    /**
     * Constructor.
     * Loads the CI instance, the users_model and some useful helpers.
     * Creates a users_lib object, populated if passed a valid $init.    
     * @param string/int $init - user id or email of user to load   
     * @access public   
     * @return none
     */
    public function __construct($init = false)
    {
        // take advantage of codeigniter libraries
        // use $this->_CI in place of normal codeigniter $this
        $this->_CI = & get_instance();
        // load users model
        $this->_CI->load->model('updates_model');         
        $this->_CI->load->config('account');  
        $this->perPage = 2;
		$this->current_date = date('Y-m-d H:i:s');
        //$this->_CI->load->helper(array('form', 'url', 'cookie'));         
    }
    
    function Get_EG_Label( $pub_date )
    {
    	$response = false;
    	
    	$current_year = date('Y');
    	$current_month = date('M');
    	$sh = 'SH';
    	$fh = 'FH';
    	$pub = strtotime( $current_month. " " .$current_year );
    	
    	$pub_date_str = strtotime( $pub_date );
    	
    	if( $pub_date_str > $pub )
    	{
    	
	    	$date = date('Y-m-d');
	    	list($year, $month, $day) = explode('-', $date);
			
	    	$response[] =  $sh. " " .$current_month." ".$current_year;
	    	$response[] =  $fh. " " .$current_month." ".$current_year;
	    	for($i = 1; $i< 12; $i++){
				$next_month = date('M', mktime(0, 0, 0, $month + $i, $day, $year));
				$next_year = date('Y', mktime(0, 0, 0, $month + $i, $day, $year));
				
		    	$response[] .= $sh. " " .$next_month. " ".$next_year;
		    	$response[] .= $fh. " " .$next_month. " ".$next_year;
	    	}
    	}else{
    	
    		$str = strtotime( $pub_date );
    		
	    	$date = date('Y-m-d', $str);
	    	list($year, $month, $day) = explode('-', $date);
			
	    	$current_year = date('Y', $str);
	    	$current_month = date('M', $str);
	    	
	    	$response[] =  $sh. " " .$current_month." ".$current_year;
	    	$response[] =  $fh. " " .$current_month." ".$current_year;

	    	for($i = 1; $i< 12; $i++){
				$next_month = date('M', mktime(0, 0, 0, $month + $i, $day, $year));
				$next_year = date('Y', mktime(0, 0, 0, $month + $i, $day, $year));
				
		    	$response[] .= $sh. " " .$next_month. " ".$next_year;
		    	$response[] .= $fh. " " .$next_month. " ".$next_year;
	    	}
    	
    	}
    	
    	return $response;
    
    }
    
    
    function Get_Exec_Label( $pub_date )
    {
    	$response = false;
    	
    	$current_year = date('Y');
    	$current_month = date('M');
    	
    	$pub = strtotime( $current_month. " " .$current_year );
    	
    	$pub_date_str = strtotime( $pub_date );
    	
    	if( $pub_date_str > $pub )
    	{
	    	$date = date('Y-m-d');
	    	list($year, $month, $day) = explode('-', $date);
			
	    	$response[] =  $current_month." ".$current_year;
	    	for($i = 1; $i< 12; $i++){
				$next_month = date('M', mktime(0, 0, 0, $month + $i, $day, $year));
				$next_year = date('Y', mktime(0, 0, 0, $month + $i, $day, $year));
				
		    	$response[] .= $next_month. " ".$next_year;
	    	}
    	}else{
    	
    		$str = strtotime( $pub_date );
	    	$date = date('Y-m-d', $str);
	    	
	    	list($year, $month, $day) = explode('-', $date);
			
	    	$current_year = date('Y', $str);
	    	$current_month = date('M', $str);
	    	
	    	$response[] =  $current_month." ".$current_year;
	    	
	    	for($i = 1; $i< 12; $i++){
				$next_month = date('M', mktime(0, 0, 0, $month + $i, $day, $year));
				$next_year = date('Y', mktime(0, 0, 0, $month + $i, $day, $year));
				
		    	$response[] .= $next_month. " ".$next_year;
	    	}
    	
    	}
    	return $response;
    }
    
}