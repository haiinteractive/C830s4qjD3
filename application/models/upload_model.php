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
 
class Upload_Model extends CI_Model
{
 
	 public $_dataMap = ''; 
	 
	 
	function Check_Ro_Number( $ro_number )
	{
	
    	$this->db->select("pub_information.pub_information_id");
        $this->db->from('pub_information');      
        $this->db->where(array('pub_information.ro_number'=> "$ro_number" ));        
        $this->db->limit(1);
        
        $query = $this->db->get();
        
		$db_results = $query->result_array();	
		
		 if (count($db_results) > 0 )
        {            
        	
        	return $db_results[0];
            
        }else{
        
        	 return 0;
        	 
        } 
        
	}
	
	
	
	function Get_Company_Id( $company_name )
	{
	
    	$this->db->select("clients.client_id");
        $this->db->from('clients');      
        $this->db->where(array('clients.company_name'=>$company_name));        
        $this->db->limit(1);
        
        $query = $this->db->get();
        
		$db_results = $query->result_array();	
		
		 if (count($db_results) > 0 )
        {            
        	
        	return $db_results[0];
            
        }else{
        
        	 return 0;
        	 
        } 
	}
	
	
	function Add_Pub_Info( $pub_info )
	{
	 	$this->db->insert(TOOL_DB_NAME.'.pub_information', $pub_info);
	 	return $this->db->insert_id(); 	
	}
	
	
	function Add_Ad_Info( $ad_info )
	{
	 	$this->db->insert(TOOL_DB_NAME.'.ad_data', $ad_info);
	 	return $this->db->insert_id(); 	
	}
	
	
	
	function Get_Code_Id( $code, $form_type ){
		
	
    	$this->db->select("code.code_id");
        $this->db->from('code');
        $this->db->join(TOOL_DB_NAME.'.form_type', 'form_type.form_type_id = code.form_type_id', 'left');
        $this->db->where(array('code.code'=>$code, 'form_type.form_type_code' => $form_type , 'code.code_status' => '1' ));        
        $this->db->limit(1);
        
        $query = $this->db->get();
        
		$db_results = $query->result_array();	
		
		 if (count($db_results) > 0 )
        {            
        	
        	return $db_results[0];
            
        }else{
        
        	 return 0;
        	 
        } 
	}
	
	
	
	
	function Get_Category_Id( $category )
	{
	
    	$this->db->select("categories.category_id");
        $this->db->from('categories');      
        $this->db->where(array('categories.category_name' => "$category" ));        
        $this->db->limit(1);
        
        $query = $this->db->get();
        
		$db_results = $query->result_array();	
		
		 if (count($db_results) > 0 )
        {            
        	
        	return $db_results[0];
            
        }else{
        
        	 return 0;
        	 
        } 
	}
	
	
	function Insert_Company_Info( $arg )
	{
	 	$this->db->insert(TOOL_DB_NAME.'.clients', $arg );
	 	return $this->db->insert_id(); 	
	
	}
	
	function Get_Sales_Person_Id( $sales_person, $arg )
	{
	
    	$this->db->select("users.user_id");
        $this->db->from('users');      
        $this->db->where(array('users.user_first_name' => "$sales_person", 'users.user_type_id' => 3 ));        
        $this->db->limit(1);
        
        $query = $this->db->get();
        
		$db_results = $query->result_array();	
		
		 if (count($db_results) > 0 )
        {            
        	
        	return $db_results[0];
            
        }else{
        
		 	$this->db->insert(TOOL_DB_NAME.'.users', $arg );
		 	return $this->db->insert_id(); 	
        
        } 
	}
	
	
	
	function Valid_Ad_data( $ad_info, $form_type )
	{
	
    	$this->db->select("ad_data.ad_data_id");
        $this->db->from('ad_data');      
        $this->db->where(array('ad_data.pub_information_id' => $ad_info['pub_information_id'] ));        
        
        if($form_type == 'EG')
        {
        	$this->db->where(array('ad_data.session' => $ad_info['session'], 'ad_data.city' => $ad_info['city'], 'ad_data.publish_date' => $ad_info['publish_date'], 'ad_data.publish_type' => $ad_info['publish_type'] ));
        
        }
        else if($form_type == 'EXEC')
        {
        	$this->db->where(array('ad_data.publish_date' => $ad_info['publish_date'], 'ad_data.publish_type' => $ad_info['publish_type'], 'ad_data.offered_rate' => $ad_info['offered_rate'] ));        
        }
        else
        {
        	$this->db->where(array('ad_data.publish_date' => $ad_info['publish_date'], 'ad_data.publish_type' => $ad_info['publish_type'], 'ad_data.product_name' => $ad_info['product_name'], 'ad_data.start_date' => $ad_info['start_date'], 'ad_data.end_date' => $ad_info['end_date'] ));        
        }
        
        $this->db->limit(1);
        
        $query = $this->db->get();
        
		$db_results = $query->result_array();	
		
		 if (count($db_results) > 0 )
        {            
        	
        	return $db_results[0];
            
        }else{
        
		 	return false; 	
        
        } 
	}
	
}
/* End of file users_model.php */
?>