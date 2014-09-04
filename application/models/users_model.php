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
 
class Users_Model extends CI_Model
{
 
	 public $_dataMap = ''; 
	 
	 

	function Log_Update( $arg )
	{
	 	$this->db->insert(TOOL_DB_NAME.'.login_log', $arg );
	 	return $this->db->insert_id(); 
        	
	} 
	
	
	function Last_Login_Update( $arg, $user_id )
	{
	
		$this->db->where('users.user_id', $user_id);
		$this->db->update(TOOL_DB_NAME.'.users', $arg);    	
	}
	
	
	function Last_Logged_Out_Update( $arg, $user_id )
	{
	
		$this->db->where('users.user_id', $user_id);
		$this->db->update(TOOL_DB_NAME.'.users', $arg);    	
		
		return true;
	}
	
	function Get_All_User_Type( )
	{
	
        $this->db->select("user_type_id, user_type");
        $this->db->from(TOOL_DB_NAME.'.user_type');        
        $this->db->where('user_type.user_type_is_active', '1');         
        
        $query = $this->db->get();
		$db_results = $query->result_array();		 
		
        if (count($db_results) > 0 )
        { 
            return $db_results;
            
        } else {            
        
            return FALSE;
        } 
	}
	
    function User_Login($user_name, $password)
    {
    	
    	$this->db->select("*");
        $this->db->from('users');      
        $this->db->where(array('users.user_name'=>$user_name,"users.user_password"=> $password));        
        $query = $this->db->get();
        
		$db_results = $query->result_array();	
		
		 if (count($db_results) > 0 && $db_results[0]['user_is_active'] == 1)
        {            
        	
        	return $db_results[0];
            
        }else if(count($db_results) > 0 && $db_results[0]['user_is_active'] == 0)
        {
        	return 'inactive';

        }else{
        
        	 return 'ER';
        	 
        } 
        
        
    }
    
    
    function Add_New_User( $arg )
    {
    
	 $this->db->insert(TOOL_DB_NAME.'.users', $arg );
	 
	 return $this->db->insert_id();     
	 
    }
    
    
    function Add_New_Product( $arg )
    {
    
	 $this->db->insert(TOOL_DB_NAME.'.product', $arg );
	 
	 return $this->db->insert_id();     
	 
    }
    
    
    function Add_New_Company( $arg )
    {
    
	 $this->db->insert(TOOL_DB_NAME.'.clients', $arg );
	 
	 return $this->db->insert_id();     
	 
    }
    
    
    function Add_New_Category( $arg )
    {
    
	 	$this->db->insert(TOOL_DB_NAME.'.categories', $arg );
	 
	 	return $this->db->insert_id();     
	 
    }
    
    
    function Change_Password( $data, $user_id )
    {
	
		$this->db->where('users.user_id', $user_id);
		$this->db->update(TOOL_DB_NAME.'.users', $data);    	
		
		return true;
    
    }
    
    
    function UserInfo( $user_id )
    {
    
    	$this->db->select("*");
        $this->db->from('users');      
        $this->db->where(array('users.user_id'=>$user_id));        
        $query = $this->db->get();
        
		$db_results = $query->result_array();	
		
		 if (count($db_results) > 0 )
        {            
        	
        	return $db_results[0];
            
        }else{
        
        	 return 'ER';
        	 
        } 
        
    }
    
    
  	function CategoryInfo( $category_id )
    {
    
    	$this->db->select("*");
        $this->db->from('categories');      
        $this->db->where(array('categories.category_id'=>$category_id));        
        $query = $this->db->get();
        
		$db_results = $query->result_array();	
		
		 if (count($db_results) > 0 )
        {            
        	
        	return $db_results[0];
            
        }else{
        
        	 return 'ER';
        	 
        } 
        
    }
    
    function Edit_User_Info( $arg, $user_id )
    {

		$this->db->where('users.user_id', $user_id);
		$this->db->update(TOOL_DB_NAME.'.users', $arg);    	

		return true;    
    }
    
    
    
    function Edit_Category_Info( $arg, $category_id )
    {

		$this->db->where('categories.category_id', $category_id);
		$this->db->update(TOOL_DB_NAME.'.categories', $arg);    	

		return true;    
    }

    function ClientInfo( $client_id )
    {
    
    	$this->db->select("*");
        $this->db->from('clients');
        $this->db->where(array('clients.client_id'=>$client_id));
        $query = $this->db->get();
        
		$db_results = $query->result_array();	
		
		 if (count($db_results) > 0 )
        {            
        	
        	return $db_results[0];
            
        }else{
        
        	 return 'ER';
        	 
        } 
    }
    
    
    function Edit_Client_Info( $arg, $client_id )
    {

		$this->db->where('clients.client_id', $client_id);
		$this->db->update(TOOL_DB_NAME.'.clients', $arg);    	

		return true;    
    }
    
    
    function Check_Availability( $email, $table )
    {
    
    	if($table == 'users')
    	{
	    	
	        $this->db->select("users.user_id");
	        $this->db->from(TOOL_DB_NAME.'.users');        
	        $this->db->where('users.user_name',  $email);         
        
    	}else if($table == 'category')
    	{
    	
	        $this->db->select("categories.category_id");
	        $this->db->from(TOOL_DB_NAME.'.categories');        
	        $this->db->where('categories.category_name',  $email);         
        
    	}
    
        
        $query = $this->db->get();
		$db_results = $query->result_array();		 
		
        if (count($db_results) > 0 )
        { 
            return $db_results;
            
        } else {            
        
            return FALSE;
        } 
    }
    
    
    function Add_AdType_Info( $arg )
    {
	 	$this->db->insert(TOOL_DB_NAME.'.code', $arg );
	 	return $this->db->insert_id(); 
        	
    }
    
    
    
    
    function AdTypeInfo( $id )
    {
    	
    	$this->db->select("*");
        $this->db->from('code');
        $this->db->join(TOOL_DB_NAME.'.form_type', 'form_type.form_type_id = code.form_type_id', 'left');
        $this->db->where(array('code.code_id'=>$id));
        $query = $this->db->get();
        
		$db_results = $query->result_array();	
		
		 if (count($db_results) > 0 )
        {            
        	
        	return $db_results[0];
            
        }else{
        
        	 return 'ER';
        	 
        } 
    }
    
    
	function Edit_AdType_Info( $arg, $id )
	{
	
		$this->db->where('code.code_id', $id);

		$this->db->update(TOOL_DB_NAME.'.code', $arg);    	
		
		return true;
	}
	
    
}
/* End of file users_model.php */
?>