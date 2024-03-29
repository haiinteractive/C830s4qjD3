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
 
class Dashboard_Model extends CI_Model
{
	 public $_dataMap = ''; 
	    function Total_Earning( $start_date, $end_date )
	    {
	        $this->db->select("sum(net_pay) as total_earning");
	        $this->db->from(TOOL_DB_NAME.'.pub_information');        
	        $this->db->where('pub_information.pub_status', '1');
	         $this->db->where( 'DATE(pub_information.created_on) BETWEEN "'.$start_date.'" AND "' .$end_date.'"'  );
	        $this->db->limit(1);
	        
	        	$query = $this->db->get();
		$db_results = $query->result();		 
	        if (count($db_results) > 0 )
	        { 
	            return number_format($db_results[0]->total_earning);
	        } else {            
	            return FALSE;
	        } 
	}

	function Total_Clients(  $start_date, $end_date )
	{
	        $this->db->select("count(client_id) as total_clients");
	        $this->db->from(TOOL_DB_NAME.'.clients');        
	        $this->db->where('clients.client_status', '1');
	         $this->db->where( 'DATE(clients.client_created_on) BETWEEN "'.$start_date.'" AND "' .$end_date.'"'  );
	        $this->db->limit(1);
	        $query = $this->db->get();
		$db_results = $query->result();		 
	        if (count($db_results) > 0 )
	        { 
	            return $db_results[0]->total_clients;
	        } else {            
	            return FALSE;
	        } 
	}

	function Total_Products(  $start_date, $end_date )
	{
	        $this->db->select("count(product_id) as total_products");
	        $this->db->from(TOOL_DB_NAME.'.product');        
	        $this->db->where('product.product_status', '1');
	         $this->db->where( 'DATE(product.product_created_on) BETWEEN "'.$start_date.'" AND "' .$end_date.'"'  );
	        $this->db->limit(1);
	        $query = $this->db->get();
		$db_results = $query->result();		 
	        if (count($db_results) > 0 )
	        { 
	            return $db_results[0]->total_products;
	        } else {            
	            return FALSE;
	        } 
	}

	function Total_Users(  $start_date, $end_date )
	{
	        $this->db->select("count(user_id) as total_users");
	        $this->db->from(TOOL_DB_NAME.'.users');        
	        $this->db->where('users.user_is_active', '1');
    	         $this->db->where( 'DATE(users.user_created_on) BETWEEN "'.$start_date.'" AND "' .$end_date.'"'  );
	        $this->db->limit(1);
	        $query = $this->db->get();
		$db_results = $query->result();		 
	        if (count($db_results) > 0 )
	        { 
	            return $db_results[0]->total_users;
	        } else {            
	            return FALSE;
	        } 
	}
	 
	function Total_AdType(  $start_date, $end_date )
	{
	        $this->db->select("count(code_id) as total_adtype");
	        $this->db->from(TOOL_DB_NAME.'.code');        
	        $this->db->where('code.code_status', '1');
	         $this->db->where( 'DATE(code.code_created_on) BETWEEN "'.$start_date.'" AND "' .$end_date.'"'  );
	        $this->db->limit(1);
	        $query = $this->db->get();
		$db_results = $query->result();		 
	        if (count($db_results) > 0 )
	        { 
	            return $db_results[0]->total_adtype;
	        } else {            
	            return FALSE;
	        } 
	}

	
	function Net_Revenue(  $start_date, $end_date )
	{
	        $this->db->select("sum(offered_rate) as net_revenue");
	        $this->db->from(TOOL_DB_NAME.'.ad_data');        
	        $this->db->where('ad_data.ad_data_status', '1');
	         $this->db->where( 'ad_data.published_date_formatted BETWEEN "'.$start_date.'" AND "' .$end_date.'"'  );
	        $this->db->limit(1);
	        $query = $this->db->get();
		$db_results = $query->result();		 
	        if (count($db_results) > 0 )
	        { 
	            return $db_results[0]->net_revenue;
	        } else {            
	            return FALSE;
	        } 
	}

}
/* End of file users_model.php */
?>