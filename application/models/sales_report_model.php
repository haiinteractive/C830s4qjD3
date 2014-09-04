<?php
 
class Sales_Report_Model extends CI_Model
{
 
	 public $_dataMap = ''; 
	 
	 
	function Sales_Person_Report( $start_date, $end_date, $sales_person )
	{
	
        $this->db->select("*, COUNT(ad_data_id) as qty, SUM(ad_data.offered_rate) as net_bill");
        $this->db->from(TOOL_DB_NAME.'.pub_information');
        $this->db->join(TOOL_DB_NAME.'.ad_data', 'ad_data.pub_information_id = pub_information.pub_information_id', 'left');
        $this->db->join(TOOL_DB_NAME.'.code', 'code.code_id = ad_data.publish_type', 'left');
        $this->db->join(TOOL_DB_NAME.'.categories', 'categories.category_id = pub_information.category', 'left');
        $this->db->join(TOOL_DB_NAME.'.form_type', 'form_type.form_type_id = code.form_type_id', 'left');
        $this->db->join(TOOL_DB_NAME.'.clients', 'clients.client_id = pub_information.company_id', 'left');
        $this->db->where( array( 'pub_information.pub_status'=>'1' , 'ad_data.ad_data_status'=>'1'));
        
        if($sales_person != '')
	        $this->db->where( array( 'pub_information.sales_person ' => $sales_person ));
        
        if($state_date != '' && $end_date == '')
	        $this->db->where( array( 'pub_information.approve_date >' => $state_date ));

        if($state_date == '' && $end_date != '')
	        $this->db->where( array( 'pub_information.approve_date <' => $end_date ));

        if($start_year != '' && $end_year == '')
	        $this->db->where( array( 'pub_information.approve_date >' => $start_year));

        if($start_year == '' && $end_year != '')
	        $this->db->where( array( 'pub_information.approve_date <' => $end_year));

	    if($state_date != '' && $end_date != '')
	        $this->db->where( 'pub_information.approve_date BETWEEN "'.$state_date.'" AND "' .$end_date.'"'  );

        $this->db->group_by("pub_information.pub_information_id");
        $query = $this->db->get();
        
        $db_results = $query->result_array();		 
		
		if (count($db_results) > 0 )
        { 
            return $db_results;
            
        } else {            
        
            return FALSE;
        } 		
	}
	


	function Sales_Renevue_Calc( $start_date, $end_date, $sales_person )
	{
	
        $this->db->select("SUM(ad_data.offered_rate) as total_amount, SUM(code.rack_rate) as total_turnover ");
        $this->db->from(TOOL_DB_NAME.'.pub_information');
        $this->db->join(TOOL_DB_NAME.'.ad_data', 'ad_data.pub_information_id = pub_information.pub_information_id', 'left');
        $this->db->join(TOOL_DB_NAME.'.code', 'code.code_id = ad_data.publish_type', 'left');
        $this->db->join(TOOL_DB_NAME.'.form_type', 'form_type.form_type_id = code.form_type_id', 'left');
        $this->db->join(TOOL_DB_NAME.'.clients', 'clients.client_id = pub_information.company_id', 'left');
        $this->db->where( array( 'pub_information.pub_status'=>'1', 'ad_data.ad_data_status'=>'1'));
        
        if($start_date != '' && $end_date == '')
	        $this->db->where( array( 'ad_data.month >' => $start_date ));
	        
        if($start_date == '' && $end_date != '')
	        $this->db->where( array( 'ad_data.month <' => $end_date ));
        
        if($sales_person != '' )
	        $this->db->where( array( 'pub_information.sales_person ' => $sales_person));
	        
	    if($start_date != '' && $end_date != '')
	        $this->db->where( 'ad_data.month BETWEEN "'.$start_date.'" AND "' .$end_date.'"'  );
        
        $query = $this->db->get();
        
		$db_results = $query->result_array();		 
		
		if (count($db_results) > 0 )
        { 
            return $db_results[0];
            
        } else {            
        
            return FALSE;
        } 		
	}
	




	function Sales_Calc_Count_Bills( $start_date, $end_date, $sales_person )
	{
	
        $this->db->select("SUM(ad_data.offered_rate) as total_net_bill, count(ad_data.ad_data_id) as qty, pub_information.pub_information_id ");
        $this->db->from(TOOL_DB_NAME.'.pub_information');
        $this->db->join(TOOL_DB_NAME.'.ad_data', 'ad_data.pub_information_id = pub_information.pub_information_id', 'left');
        $this->db->join(TOOL_DB_NAME.'.code', 'code.code_id = ad_data.publish_type', 'left');
        $this->db->join(TOOL_DB_NAME.'.form_type', 'form_type.form_type_id = code.form_type_id', 'left');
        $this->db->join(TOOL_DB_NAME.'.clients', 'clients.client_id = pub_information.company_id', 'left');
        $this->db->where( array( 'pub_information.pub_status'=>'1', 'ad_data.ad_data_status'=>'1'));
        
        if($sales_person != '' )
	        $this->db->where( array( 'pub_information.sales_person >' => $sales_person ));
	        
	        
        if($start_date != '' && $end_date == '')
	        $this->db->where( array( 'ad_data.month >' => $start_date ));
	        
        if($start_date == '' && $end_date != '')
	        $this->db->where( array( 'ad_data.month <' => $end_date ));
        
	        
        if($start_date != '' && $end_date == '')
	        $this->db->where( array( 'ad_data.year>' => $start_date));
	        
	        
	    if($start_date != '' && $end_date != '')
	        $this->db->where( 'ad_data.month BETWEEN "'.$start_date.'" AND "' .$end_date.'"'  );
        
        
        $this->db->group_by("ad_data.pub_information_id");
        
        
        $query = $this->db->get();
        
        return $this->db->last_query();
        
        
		$db_results = $query->result_array();		 
		
		
		if (count($db_results) > 0 )
        { 
            return $db_results;
            
        } else {            
        
            return FALSE;
        } 		
	}
	
	
	
	
	
	function View_Ro_Details( $id )
	{
		
        $this->db->select("*, GROUP_CONCAT(publish_date) as publish_date");
        $this->db->from(TOOL_DB_NAME.'.pub_information');
        $this->db->join(TOOL_DB_NAME.'.ad_data', 'ad_data.pub_information_id = pub_information.pub_information_id', 'left');
        $this->db->join(TOOL_DB_NAME.'.code', 'code.code_id = ad_data.publish_type', 'left');
        $this->db->join(TOOL_DB_NAME.'.categories', 'categories.category_id = pub_information.category', 'left');
        $this->db->join(TOOL_DB_NAME.'.clients', 'clients.client_id = pub_information.company_id', 'left');
        $this->db->where( array( 'pub_information.pub_status'=>'1', 'pub_information.ro_number' => $id ));
        $this->db->group_by( array( 'ad_data.publish_type'));
        $query = $this->db->get();
        
        $db_results = $query->result_array();		 
		
		if (count($db_results) > 0 )
        { 
            return $db_results;
            
        } else {            
        
            return FALSE;
        } 		
	}
	
	
	
	function Cancel( $id, $arg )
	{
	
		$this->db->where('pub_information.ro_number', $id);
		$this->db->update(TOOL_DB_NAME.'.pub_information', $arg);    	
		
		return true;
	}
	
}
/* End of file users_model.php */
?>