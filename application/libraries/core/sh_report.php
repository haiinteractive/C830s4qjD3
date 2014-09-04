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
 
class Sh_Report
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
        $this->_CI->load->model('report_model');         
        $this->_CI->load->model('sales_report_model');
        $this->_CI->load->config('account');  
        $this->perPage = 2;
		$this->current_date = date('Y-m-d H:i:s');
        //$this->_CI->load->helper(array('form', 'url', 'cookie'));         
    }
    
    
    function Issue_Report_data(  $Product, $select_city, $eg_month, $eg_year, $session, $request_for )
    {
        
    	$response = false;
    	
    	$response = $this->_CI->report_model->Issue_Report_data(  $Product, $select_city, $eg_month, $eg_year, $session, $request_for );
    	
    	return $response;
    }
    
    
    function Total_Renevue(  $Product, $select_city, $eg_month, $eg_year, $session )
    {
        
    	$response = false;
    	
    	$response = $this->_CI->report_model->Total_Renevue(  $Product, $select_city, $eg_month, $eg_year, $session );
    	
    	return $response;
    }
    
    
    
    function Master_List( $start_month, $start_year, $start_session, $end_month, $end_year, $end_session  )
    {
        
    	$response = false;
    	
    	$response = $this->_CI->report_model->Master_List( $start_month, $start_year, $start_session, $end_month, $end_year, $end_session );
    	
    	return $response;
    }
    
    
    function View_Ro( $id )
    {
    	$response = false;
    	
    	$response = $this->_CI->report_model->View_Ro( $id );
    	
    	return $response;    	
    }
    
    
    
    function New_Ro_Signed( )
    {
    	$response = false;
    	
    	$response = $this->_CI->report_model->New_Ro_Signed( );
    	
    	return $response;    	
    }
    
    
    
    function Revenue_Report( $start_month, $start_year, $start_session, $end_month, $end_year, $end_session  )
    {
    
    	$response = false;
    	
    	$response = $this->_CI->report_model->Revenue_Report( $start_month, $start_year, $start_session, $end_month, $end_year, $end_session );
    	
    	return $response;
    }
    
    
    
    function Renevue_Calc( $start_month, $start_year, $start_session, $end_month, $end_year, $end_session  )
    {
    
    	$response = false;
    	
    	$response = $this->_CI->report_model->Renevue_Calc( $start_month, $start_year, $start_session, $end_month, $end_year, $end_session );
    	
    	return $response;    
    }
    
    
    
    function Calc_Count_Bills( $start_month, $start_year, $start_session, $end_month, $end_year, $end_session)
    {
    
    	$response = false;
    	
    	$response = $this->_CI->report_model->Calc_Count_Bills( $start_month, $start_year, $start_session, $end_month, $end_year, $end_session);
    	
    	return $response;    
    }
    
    
    
    function View_Ro_Details( $id )
    {
    
    	$response = false;
    	
    	$response = $this->_CI->report_model->View_Ro_Details( $id );
    	
    	return $response;    
    }
    
    
    function Sales_Report_data( $Sales_Person, $Category_Business, $adtype, $lapsed_client )
    {
    	
    	$response = false;
    	
    	$response = $this->_CI->report_model->Sales_Report_data( $Sales_Person, $Category_Business, $adtype, $lapsed_client );
    	
    	return $response;    
    }
    
    
    function Sales_Total_Renevue( $Sales_Person, $Category_Business, $adtype, $lapsed_client )
    {
    	
    	$response = false;
    	
    	$response = $this->_CI->report_model->Sales_Total_Renevue( $Sales_Person, $Category_Business, $adtype, $lapsed_client );
    	
    	return $response;    
    }
    
    function Cancel( $id )
    {
    
    	$response = false;
    	
    	$arg = array(
    			'pub_status' => '0'
    	);
    	
    	$response = $this->_CI->report_model->Cancel( $id, $arg );
    	
    	return $response;    
    }
    
    
    
    function Sales_Person_Report( $start_date, $end_date, $Sales_Person )
    {
    	
    	$response = false;
    	
    	$response = $this->_CI->sales_report_model->Sales_Person_Report( $start_date, $end_date, $Sales_Person );
    	
    	return $response;    
    }
    
    
    function Sales_Calc_Count_Bills( $start_date, $end_date, $Sales_Person )
    {
    	
    	$response = false;
    	
    	$response = $this->_CI->sales_report_model->Sales_Calc_Count_Bills( $start_date, $end_date, $Sales_Person );
    	
    	return $response;    
    }
    
    function Sales_Renevue_Calc( $start_date, $end_date, $Sales_Person )
    {
    	
    	$response = false;
    	
    	$response = $this->_CI->sales_report_model->Sales_Renevue_Calc( $start_date, $end_date, $Sales_Person );
    	
    	return $response;    
    }

    function Total_Insertions( $pub_id )
    {
    	
    	$response = false;
    	
    	$response = $this->_CI->report_model->Total_Insertions( $pub_id );
    	
    	return $response;    
    }
}