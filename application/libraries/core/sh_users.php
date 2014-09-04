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
 
class Sh_Users
{
    private $_CI;    
    // present for all users
    public $userId = '';
    public $userName = '';
    public $password = '';
    public $lastLogin = '';    
    public $status = '';    
    public $createDate = '';
    public $emailId = '';  
    public $firstName = '';
    public $lastName = '';
    public $privilage = '';  
    public $loggedIn = false;
    public $corpID = '';

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
        $this->_CI->load->model('users_model');         
        $this->_CI->load->config('account');  
        $this->perPage = 2;
		$this->current_date = date('Y-m-d H:i:s');
        //$this->_CI->load->helper(array('form', 'url', 'cookie'));         
    }
    
    
    function Log_Update( $user_name, $pwd, $ip, $login_status )
    {
        
    	$response = false;
    	
    	$arg = array(
    					'user_name' => $user_name,
    					'password' => $pwd,
    					'user_ip'  => $ip,
    					'status' => $login_status
    				);
    	
    	$response = $this->_CI->users_model->Log_Update( $arg );
    	
    	return $response;
    
    }
    
    
    function Last_Login_Update( $ip, $user_id )
    {
    	
    	$response = false;
    	
    	$arg = array(
    					'user_last_logged_in_ip'  => $ip,
    					'user_last_logged_in' => $this->current_date
     				);
    	
    	$response = $this->_CI->users_model->Last_Login_Update( $arg, $user_id );
    	
    	return $response;
    
    }
    
    function Last_Logged_Out_Update( $user_id )
    {
    
    	
    	$response = false;
    	
    	$arg = array(
    					'user_last_logged_out' => $this->current_date
     				);
    	
    	$response = $this->_CI->users_model->Last_Logged_Out_Update( $arg, $user_id );
    	
    	return $response;
    
    }
    
    
    
    function Get_All_User_Type( )
    {
    	$response = false;
    	
    	$response = $this->_CI->users_model->Get_All_User_Type( );
    	
    	return $response;
        
    }
    
    
    function Add_New_User( $first_name, $last_name, $user_type, $user_name, $pwd, $ip )
    {
    	
    	$response = false;
    	
    	$arg = array(    	
    					'user_type_id'		 => $user_type,
    					'user_name'   		 => $user_name,
    					'user_first_name'    => $first_name,
    					'user_last_name'    => $last_name,
    					'user_password'		 => $pwd,
    					'user_allowed_ips'	 => $ip,
     					'user_created_on' => $this->current_date
     				);
    	
    	$response = $this->_CI->users_model->Add_New_User( $arg );
    	
    	return $response;
    
    }
    
    
    function Add_New_Category( $category_name )
    {
    
    	$response = false;
    	
    	$arg = array(
    					'category_name'		 => $category_name,
     					'category_created_on' => $this->current_date
     				);
    	
    	$response = $this->_CI->users_model->Add_New_Category( $arg );
    	
    	return $response;
    }
    
    
    
    function Add_New_Product( $product_name )
    {
    
    	$response = false;
    	
    	$arg = array(
    					'product_name'		 => $product_name,
     					'product_created_on' => $this->current_date
     				);
    	
    	$response = $this->_CI->users_model->Add_New_Product( $arg );
    	
    	return $response;
    }
    
    
    function Add_New_Company( $company_name, $contact_person, $contact_no, $address, $email, $pin_code, $alternative_contact_no, $alternative_email_id  )
    {
    
    	$response = false;
    	
    	$arg = array(
    					'company_name'		 => $company_name,
    					'contact_person'		 => $contact_person,
    					'contact_no'		 => $contact_no,
    					'address'		 => $address,
    					'email_id'		 => $email,
    					'alternative_contact_no'		 => $alternative_contact_no,
    	    			'alternative_email_id'		 => $alternative_email_id,
    					'pincode'		 => $pin_code,
    					'client_created_on' => $this->current_date
     				);
    	
    	$response = $this->_CI->users_model->Add_New_Company( $arg );
    	
    	return $response;
    }
    
    function User_Login( $user_name, $user_pwd )
    {
        
    	$response = false;
    	
    	$response = $this->_CI->users_model->User_Login( $user_name, $user_pwd );
    	
    	return $response;
    }
    
    
    function Change_Password ( $new_password, $user_id )
    {
    
    	$response = false;
    	
    	$arg = array(
    					'user_password'		 => md5( $new_password ),
    					'user_last_modified_on' => $this->current_date
     				);
    	
    	$response = $this->_CI->users_model->Change_Password( $arg, $user_id );
    	
    	return $response;
    }
    
    
    function UserInfo( $user_id )
    {
    	$response = false;
    	
    	$response = $this->_CI->users_model->UserInfo( $user_id );
    	
    	return $response;    
    }
    
    
    function Edit_User_Info( $first_name, $last_name, $email, $user_type, $user_ips, $user_id, $user_status  )
    {
    
    	$response = false;
    	
    	$arg = array(
    					'user_first_name'		 => $first_name,
    					'user_last_name'		 => $last_name,
    					'user_name'		 		 => $email,
    					'user_type_id'		 	=> $user_type,
    					'user_allowed_ips'		 => $user_ips,
    					'user_is_active'		=> "$user_status",
    					'user_last_modified_on' => $this->current_date
     				);
    	
    	$response = $this->_CI->users_model->Edit_User_Info( $arg, $user_id );
    	
    	return $response;    
    }
    
    
    function ClientInfo( $client_id )
    {
    	$response = false;
    	
    	$response = $this->_CI->users_model->ClientInfo( $client_id );
    	
    	return $response;        
    }
    
    function CategoryInfo( $category_id )
    {
    	$response = false;
    	
    	$response = $this->_CI->users_model->CategoryInfo( $category_id );
    	
    	return $response;        
    }
    
    function Edit_Client_Info( $company_name, $contact_person, $address, $pin_code, $contact_no, $email_id, $client_id, $client_status )
    {
    
    	$response = false;
    	
    	$arg = array(
    					'company_name'		 => $company_name,
    					'contact_person'		 => $contact_person,
    					'contact_no'		 		 => $contact_no,
    					'address'		 	=> $address,
    					'pincode'		 	=> $pin_code,
    					'email_id'		 => $email_id,
    					'client_status'	 => "$client_status"
     				);
    	
    	$response = $this->_CI->users_model->Edit_Client_Info( $arg, $client_id );
    	
    	return $response;    
    }

    function Edit_Category_Info( $category_name, $category_status, $category_id )
    {
    
    	$response = false;
    	
    	$arg = array(
    					'category_name'		 => $category_name,
    					'category_is_active'	 => "$category_status"
     				);
    	
    	$response = $this->_CI->users_model->Edit_Category_Info( $arg, $category_id );
    	
    	return $response;    
    }
 
    function Check_Availability( $email, $table )
    {
    
    	$response = false;
    	
    	$response = $this->_CI->users_model->Check_Availability( $email, $table );
    	
    	return $response;    
     }
     
     
     function AdTypeInfo( $id )
     {
    
    	$response = false;
    	
    	$response = $this->_CI->users_model->AdTypeInfo( $id );
    	
    	return $response;    
     }
     
     
     function Add_AdType_Info( $form_type, $code_type, $codes, $rack_rate )
     {
     	
    	$response = false;
    	
    	$arg = array(
    					'form_type_id'		 => $form_type,
    					'code_type'		 => $code_type,
    					'code'		 => $codes,
    					'rack_rate'		 => $rack_rate,
    					'code_created_on'		 => $this->current_date
    				);
    	
    	$response = $this->_CI->users_model->Add_AdType_Info( $arg );
    	
    	return $response;    
     }
     
     
     
     function Edit_AdType_Info( $form_type, $code_type, $codes, $rack_rate, $code_status, $id )
     {
     	
    	$response = false;
    	
    	$arg = array(
    					'form_type_id'		 => $form_type,
    					'code_type'		 => $code_type,
    					'code'		 => $codes,
    					'rack_rate'		 => $rack_rate,
    					'code_status'		 => "$code_status"
    				);
    	
    	$response = $this->_CI->users_model->Edit_AdType_Info( $arg, $id );
    	
    	return $response;    
     }
}