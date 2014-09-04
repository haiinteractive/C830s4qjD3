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
 
class Sh_Updates
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
    
    
    function Update_Pub_Information( $company_id, $ro_number, $form_type, $Name_Establishment, $Category_Business, $user_city, $Sales_Person, $Approving_Authonity, $approve_date, $Net_Pay, $Special_Instruction, $user_id, $pub_id )
    {
        
    	$response = false;
    	
    	$arg = array(
    				'company_id'		=> $company_id,
    				'ro_number'			=> $ro_number,
    				'form_type' 		=> $form_type,
    				'name_estalishment' => $Name_Establishment,
    				'category'			=> $Category_Business,
    				'user_city'			=> $user_city,
    				'sales_person'		=> $Sales_Person,
    				'approving_authority'	=> $Approving_Authonity,
    				'approve_date'		=> $approve_date,
    				'net_pay'			=> $Net_Pay,
    				'spl_instruction'   => $Special_Instruction,
    				'created_by'		=> $user_id,
    				'created_on'		=> $this->current_date
     			);
    	    	
    	$response = $this->_CI->updates_model->Update_Pub_Information(  $arg, $pub_id );
    	
    	return $response;
    }
    
    
    function Remove_Ad_Type( $pub_id )
    {
    	$response = false;
    	
    	$response = $this->_CI->updates_model->Remove_Ad_Type( $pub_id );
    	
    	return $response;
    }
    
    
    
    function Inactive_Ad_Type( $pub_id )
    {
    	$response = false;
    	
    	$arg = array(
    					'ad_data_status' => '0'
    				);
    	
    	$response = $this->_CI->updates_model->Inactive_Ad_Type( $arg, $pub_id );
    	
    	return $response;
    }
    
    
    function Inactive_Pub( $arg, $pub_id )
    {
    	$response = false;
    	
    	$response = $this->_CI->updates_model->Inactive_Pub( $arg, $pub_id );
    	
    	return $response;
    
    }
    
    
}