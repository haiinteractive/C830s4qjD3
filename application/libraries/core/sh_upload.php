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
 
class Sh_Upload
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
        $this->_CI->load->model('upload_model');         
        $this->_CI->load->config('account');  
        $this->perPage = 2;
		$this->current_date = date('Y-m-d H:i:s');
        //$this->_CI->load->helper(array('form', 'url', 'cookie'));         
    }
    
    
    function Check_Ro_Number( $ro_number )
    {
        
    	$response = false;
    	
    	$response = $this->_CI->upload_model->Check_Ro_Number(  $ro_number );
    	
    	return $response;
    }
    
    function Get_Company_Id( $company_name )
    {
        
    	$response = false;
    	
    	$response = $this->_CI->upload_model->Get_Company_Id( $company_name );
    	
    	return $response;
    }
    
    function Add_Pub_Info( $pub_info )
    {
        
    	$response = false;
    	
    	$response = $this->_CI->upload_model->Add_Pub_Info( $pub_info );
    	
    	return $response;
    }
    
    
    function Add_Ad_Info( $ad_info )
    {
        
    	$response = false;
    	
    	$response = $this->_CI->upload_model->Add_Ad_Info( $ad_info );
    	
    	return $response;
    }
    
    
    function Get_Code_Id( $code, $form_type )
    {
        
    	$response = false;
    	
    	$response = $this->_CI->upload_model->Get_Code_Id( $code, $form_type );
    	
    	return $response;
    }
    
    
    function Get_Category_Id( $category )
    {
        
    	$response = false;
    	
    	$response = $this->_CI->upload_model->Get_Category_Id( $category );
    	
    	return $response;    
    }
    
    
    
    function Insert_Company_Info( $company_name )
    {
    	$response = false;
    	
    	$arg = array(
    					'company_name' => $company_name,
    					'client_created_on' => $this->current_date
    				);
    				
    	$response = $this->_CI->upload_model->Insert_Company_Info( $arg );
    	
    	return $response;
    
    }
    
    
    function Get_Sales_Person_Id( $sales_person )
    {
    
    	$response = false;
    	
    	$arg = array(
    				'user_first_name' => $sales_person,
    				'user_type_id'  => 3,
    				'user_created_on' => $this->current_date
    			);
    	
    	$response = $this->_CI->upload_model->Get_Sales_Person_Id( $sales_person, $arg );
    	
    	return $response;        
    }
    
    
    function Valid_Ad_data( $ad_info, $form_type )
    {
    	
    	$response = $this->_CI->upload_model->Valid_Ad_data( $ad_info, $form_type );
    	
    	return $response;        
    
    }
    

}