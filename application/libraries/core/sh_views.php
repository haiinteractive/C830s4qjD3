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
 
class Sh_Views
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
        $this->_CI->load->model('views_model');         
        $this->_CI->load->config('account');  
        $this->perPage = 2;
		$this->current_date = date('Y-m-d H:i:s');
        //$this->_CI->load->helper(array('form', 'url', 'cookie'));         
    }
    
    
    function Users_List( )
    {
        
    	$response = false;
    	
    	$response = $this->_CI->views_model->Users_List( );
    	
    	return $response;
    }
    
    
    function Clients_List( )
    {
        
    	$response = false;
    	
    	$response = $this->_CI->views_model->Clients_List( );
    	
    	return $response;    
    }
    
    
    
    function Categories_List( )
    {
        
    	$response = false;
    	
    	$response = $this->_CI->views_model->Categories_List( );
    	
    	return $response;        
    }
    
    
    function Get_Rack_Rate( $pro_type, $ad_type )
    {
        
    	$response = false;
    	
    	$response = $this->_CI->views_model->Get_Rack_Rate( $pro_type, $ad_type );
    	
    	return $response;            	
    }
    
    
    function Get_Company_Info( $company_id )
    {
        
    	$response = false;
    	
    	$response = $this->_CI->views_model->Get_Company_Info( $company_id );
    	
    	return $response;            	
    }
    
    
    
    function Last_Inserted_Id( )
    {
    	
    	$response = false;
    	
    	$response = $this->_CI->views_model->Last_Inserted_Id( );
    	
    	return $response;            	
    }
    
    

    function Product_List( )
    {
    	
    	$response = false;
    	
    	$response = $this->_CI->views_model->Product_List( );
    	
    	return $response;            	
    }

	function Insert_Ad_Type( $pub_id, $codes, $data, $month, $year , $OfferRate_row , $session,  $publish_city_row )
    {

    	$response = false;
    	
    	$arg = array( 
				'pub_information_id' => $pub_id,
    			'month'			=> $month,
    			'year'			=> $year,
    			'city'			=> $publish_city_row,
    			'publish_date'	=> $data,
    			'publish_type'	=> $codes,
    			'offered_rate'	=> $OfferRate_row,
    			'session'		=> $session,
    			'created_on'   => $this->current_date  	
    	);
    	
    	$response = $this->_CI->views_model->Insert_Ad_Type( $arg );
    	
    	return $response;            	
    }
    
    function Add_Pub_Information( $company_id, $ro_number, $form_type, $Name_Establishment, $Category_Business, $user_city, $Sales_Person, $Approving_Authonity, $approve_date, $Net_Pay, $Special_Instruction, $user_id, $pub_id )
    {
    	$response = false;
    	
    	$arg = array(
    				'company_id'		=> $company_id,
    				'ro_number'			=> $ro_number,
    				'form_type' 		=> $form_type,
    				'modified_from'		=> $pub_id,
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
    	
    	$response = $this->_CI->views_model->Add_Pub_Information( $arg );
    	
    	return $response;            	
    
    }
    

    function Insert_Ro_Ad_Type( $result, $codes, $data, $month, $year, $OfferRate_row , $session, $publish_city_row )
    {
    	$response = false;
    	
    	$arg = array( 
				'pub_information_id' => $result,
    			'publish_date'	=> $data,
    			'publish_type'	=> $codes,
    			'offered_rate'	=> $OfferRate_row,
    			'session'		=> $session,
    			'city'		=> $publish_city_row,
    			'month'			=> $month,
    			'year'			=> $year,
    			'created_on'   => $this->current_date  	
    	);
    	
    	$response = $this->_CI->views_model->Insert_Ad_Type( $arg );
    	
    	return $response;            	
    
    }
    
    function Insert_Digital_Ad_Type( $pub_id, $codes, $data, $OfferRate_row, $product_row, $start_date, $end_date, $month, $year  )
    {
    	$response = false;
    	
    	$arg = array( 
				'pub_information_id' => $pub_id,
    			'publish_date'	=> $data,
    			'publish_type'	=> $codes,
    			'offered_rate'	=> $OfferRate_row,
    			'product_name'		=> $product_row,
    			'start_date'		=> $start_date,
    			'end_date'		=> $end_date,
    			'month'			=> $month,
    			'year'			=> $year,
    			'created_on'   => $this->current_date  	
    	);
    	
    	$response = $this->_CI->views_model->Insert_Ad_Type( $arg );
    	
    	return $response;            	
    }
    
    
    function AdType_List( )
    {
    	
    	$response = false;
    	
    	$response = $this->_CI->views_model->AdType_List( );
    	
    	return $response;            	
    }
    
    
    
    function Codes_List( $id )
    {
    	
    	$response = false;
    	
    	$response = $this->_CI->views_model->Codes_List( $id );
    	
    	return $response;            	
    }
    
    
    
    function Inactive_Clients_List( )
    {
    	
    	$response = false;
    	
    	$response = $this->_CI->views_model->Inactive_Clients_List( );
    	
    	return $response;            	
    	
    }
    
}