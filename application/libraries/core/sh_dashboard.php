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
 
class Sh_Dashboard
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
        $this->_CI->load->model('dashboard_model');         
        $this->_CI->load->config('account');  
        $this->perPage = 2;
		$this->current_date = date('Y-m-d H:i:s');
        //$this->_CI->load->helper(array('form', 'url', 'cookie'));         
    }
    
    
    function Dashboard_Info( $start_date, $end_date  )
    {
    	$response = false;
    	$response['total_earning'] = $this->_CI->dashboard_model->Total_Earning(  $start_date, $end_date  );
              $response['total_clients'] = $this->_CI->dashboard_model->Total_Clients(  $start_date, $end_date  );
              $response['total_products'] = $this->_CI->dashboard_model->Total_Products( $start_date, $end_date  );
              $response['total_users'] = $this->_CI->dashboard_model->Total_Users(   $start_date, $end_date  );
              $response['total_adtype'] = $this->_CI->dashboard_model->Total_AdType(  $start_date, $end_date  );
              $response['net_revenue'] = $this->_CI->dashboard_model->Net_Revenue(  $start_date, $end_date  );
    	return $response;
    }
    
    
}