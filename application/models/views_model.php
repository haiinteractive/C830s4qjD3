<?php
/**
 * The users model
 *
 * @category Users
 * @package  None
 * @author   Anoop kP
 * @license  http://www.flycell.com Flycell
 * @link     libraries/core/users.php
 *
 */
 
class Views_Model extends CI_Model
{
 
	 public $_dataMap = ''; 
	 
	function Users_List( )
	{
	
        $this->db->select("*");
        $this->db->from(TOOL_DB_NAME.'.users');        
        
        $query = $this->db->get();
		$db_results = $query->result_array();		 
		
        if (count($db_results) > 0 )
        { 
            return $db_results;
            
        } else {            
        
            return FALSE;
        } 
	}
	
    
	function AdType_List( )
	{
	
        $this->db->select("*");
        $this->db->from(TOOL_DB_NAME.'.code');        
        $this->db->join(TOOL_DB_NAME.'.form_type', 'form_type.form_type_id = code.form_type_id', 'left');
        
        $query = $this->db->get();
		$db_results = $query->result_array();		 
		
        if (count($db_results) > 0 )
        { 
            return $db_results;
            
        } else {            
        
            return FALSE;
        } 
	}
	
	function Clients_List( )
	{
	
        $this->db->select("*");
        $this->db->from(TOOL_DB_NAME.'.clients');        
        $this->db->where('clients.client_status', '1');         
        
        $query = $this->db->get();
		$db_results = $query->result_array();		 
		
        if (count($db_results) > 0 )
        { 
            return $db_results;
            
        } else {            
        
            return FALSE;
        } 
	}
	
	
	
    
	function Categories_List( )
	{
	
        $this->db->select("*");
        $this->db->from(TOOL_DB_NAME.'.categories');        
        $this->db->where('categories.category_is_active', '1');         
        
        $query = $this->db->get();
		$db_results = $query->result_array();		 
		
        if (count($db_results) > 0 )
        { 
            return $db_results;
            
        } else {            
        
            return FALSE;
        } 
	}
	
	
	function Product_List( )
	{
	
        $this->db->select("*");
        $this->db->from(TOOL_DB_NAME.'.product');        
        $this->db->where('product.product_status', '1');         
        
        $query = $this->db->get();
		$db_results = $query->result_array();		 
		
        if (count($db_results) > 0 )
        { 
            return $db_results;
            
        } else {            
        
            return FALSE;
        } 
	}
	
	
	function Get_Rack_Rate( $pro_type, $ad_type )
	{
        $this->db->select("code.rack_rate");
        $this->db->from(TOOL_DB_NAME.'.code');     
        $this->db->join(TOOL_DB_NAME.'.form_type', 'form_type.form_type_id = code.form_type_id', 'left');
        $this->db->where(array('code.code_id'=>$ad_type , "form_type.form_type_code" => $pro_type ));
        $this->db->limit(1);
        
        $query = $this->db->get();
        
		$db_results = $query->result_array();		 
		
		if (count($db_results) > 0 )
        { 
            return $db_results[0];
            
        } else {            
        
            return FALSE;
        } 		
	}
	
	
	
	function Get_Company_Info( $company_id )
	{
		
        $this->db->select("*");
        $this->db->from(TOOL_DB_NAME.'.clients');
        $this->db->where('clients.client_id', $company_id );         
        
        $query = $this->db->get();
		$db_results = $query->result();		 
		
        if (count($db_results) > 0 )
        { 
            return $db_results[0];
            
        } else {            
        
            return FALSE;
        } 		
	}
	
	
	
	function Last_Inserted_Id( )
	{
	
		
        $this->db->select("pub_information.pub_information_id");
        $this->db->from(TOOL_DB_NAME.'.pub_information');
        $this->db->order_by('pub_information.pub_information_id', 'DESC');
        $this->db->limit(1);
        
        $query = $this->db->get();
		$db_results = $query->result_array();		 
		
        if (count($db_results) > 0 )
        { 
            return $db_results[0];
            
        } else {            
        
            return FALSE;
        } 		
	}
	
	function Add_Pub_Information( $arg )
	{
	
	 	$this->db->insert(TOOL_DB_NAME.'.pub_information', $arg );
	 	
	 	return $this->db->insert_id(); 	
	}
	
	function Insert_Ad_Type( $arg )
	{
	
	 	$this->db->insert(TOOL_DB_NAME.'.ad_data', $arg );
	 	return $this->db->insert_id(); 
	}
	
	
	function Inactive_Clients_List( )
	{
	
        $this->db->select("*");
        $this->db->from(TOOL_DB_NAME.'.clients');
        $this->db->where('clients.client_status', '0');         
        
        $query = $this->db->get();
		$db_results = $query->result_array();		 
		
        if (count($db_results) > 0 )
        { 
            return $db_results;
            
        } else {            
        
            return FALSE;
        } 
	}
	
	function Codes_List( $id )
	{
	
        $this->db->select("*");
        $this->db->from(TOOL_DB_NAME.'.code');
        
        if($id != 'all' )
        	$this->db->where('code.form_type_id', $id );         
        
        $query = $this->db->get();
		$db_results = $query->result_array();		 
		
        if (count($db_results) > 0 )
        { 
            return $db_results;
            
        } else {            
        
            return FALSE;
        } 
	}
}
/* End of file users_model.php */
?>