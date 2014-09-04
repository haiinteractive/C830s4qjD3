<?php
 
class Report_Model extends CI_Model
{
 
	 public $_dataMap = ''; 
	 
	function Issue_Report_data( $Product, $select_city, $eg_month, $eg_year, $session, $request_for )
	{
	
		if($request_for == 'basic')
        	$this->db->select("*");
        else
        	$this->db->select("*, COUNT(ad_data_id) as qty, SUM(ad_data.offered_rate) as net_bill");
        
	    $this->db->from(TOOL_DB_NAME.'.pub_information');
        $this->db->join(TOOL_DB_NAME.'.ad_data', 'ad_data.pub_information_id = pub_information.pub_information_id', 'left');
        $this->db->join(TOOL_DB_NAME.'.code', 'code.code_id = ad_data.publish_type', 'left');
        $this->db->join(TOOL_DB_NAME.'.form_type', 'form_type.form_type_id = code.form_type_id', 'left');
        $this->db->join(TOOL_DB_NAME.'.clients', 'clients.client_id = pub_information.company_id', 'left');
        
        $this->db->where(array('form_type.form_type_code'=>$Product, 'pub_information.form_type'=>$Product, 'pub_information.pub_status'=>'1', 'ad_data.ad_data_status'=>'1'));
        
        if($eg_month != '')
        {
        	$this->db->where(array('ad_data.month'=>$eg_month));        
        }
        if($eg_year != '')
        {
        	$this->db->where(array('ad_data.year'=>$eg_year));        
        }
        
        
        if($select_city != '')
        {
        	$this->db->where(array('ad_data.city'=>$select_city));        
        }
        
        if($session != '')
        {
        	$this->db->where(array('ad_data.session'=>$session));        
        }
        
		if($request_for != 'basic')
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
	
	
	
	
	
	
	function Sales_Report_data( $Sales_Person, $Category_Business, $adtype, $lapsed_client )
	{
	
	
        $this->db->select("*, COUNT(ad_data_id) as qty, SUM(ad_data.offered_rate) as net_bill");
        $this->db->from(TOOL_DB_NAME.'.pub_information');
        $this->db->join(TOOL_DB_NAME.'.ad_data', 'ad_data.pub_information_id = pub_information.pub_information_id', 'left');
        $this->db->join(TOOL_DB_NAME.'.code', 'code.code_id = ad_data.publish_type', 'left');
        $this->db->join(TOOL_DB_NAME.'.categories', 'categories.category_id = pub_information.category', 'left');
        $this->db->join(TOOL_DB_NAME.'.form_type', 'form_type.form_type_id = code.form_type_id', 'left');
        $this->db->join(TOOL_DB_NAME.'.clients', 'clients.client_id = pub_information.company_id', 'left');
        $this->db->where(array('pub_information.pub_status'=>'1', 'ad_data.ad_data_status'=>'1'));
        
        if($Sales_Person != '')
        {
        	$this->db->where(array('pub_information.sales_person'=>$Sales_Person));        
        }
        if($Category_Business != '')
        {
        	$this->db->where(array('pub_information.category'=>$Category_Business));        
        }
        
        
        if($adtype != '')
        {
        	$this->db->where(array('ad_data.publish_type'=>$adtype));        
        }
        
        if($lapsed_client != '')
        {
        	$this->db->where(array('pub_information.company_id'=>$lapsed_client));        
        }
         
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
	
	
	
	
	function Sales_Total_Renevue( $Sales_Person, $Category_Business, $adtype, $lapsed_client )
	{
	
        $this->db->select("SUM(ad_data.offered_rate) as total_amount, SUM(code.rack_rate) as total_turnover ");
        $this->db->from(TOOL_DB_NAME.'.pub_information');
        $this->db->join(TOOL_DB_NAME.'.ad_data', 'ad_data.pub_information_id = pub_information.pub_information_id', 'left');
        $this->db->join(TOOL_DB_NAME.'.code', 'code.code_id = ad_data.publish_type', 'left');
        $this->db->join(TOOL_DB_NAME.'.form_type', 'form_type.form_type_id = code.form_type_id', 'left');
        $this->db->join(TOOL_DB_NAME.'.clients', 'clients.client_id = pub_information.company_id', 'left');
        
        $this->db->where(array('pub_information.pub_status'=>'1', 'ad_data.ad_data_status'=>'1'));
        
        if($Sales_Person != '')
        {
        	$this->db->where(array('pub_information.sales_person'=>$Sales_Person));        
        }
        if($Category_Business != '')
        {
        	$this->db->where(array('pub_information.category'=>$Category_Business));        
        }
        
        
        if($adtype != '')
        {
        	$this->db->where(array('ad_data.publish_type'=>$adtype));        
        }
        
        if($lapsed_client != '')
        {
        	$this->db->where(array('pub_information.company_id'=>$lapsed_client));        
        }
                                        
        $query = $this->db->get();
        
		$db_results = $query->result_array();		 
		
		if (count($db_results) > 0 )
        { 
            return $db_results[0];
            
        } else {            
        
            return FALSE;
        } 		
	}
	
	
	
	
	function Total_Renevue( $Product, $select_city, $eg_month, $eg_year, $session )
	{
	
        $this->db->select("SUM(ad_data.offered_rate) as total_amount, SUM(code.rack_rate) as total_turnover ");
	    $this->db->from(TOOL_DB_NAME.'.pub_information');
        $this->db->join(TOOL_DB_NAME.'.ad_data', 'ad_data.pub_information_id = pub_information.pub_information_id', 'left');
        $this->db->join(TOOL_DB_NAME.'.code', 'code.code_id = ad_data.publish_type', 'left');
        $this->db->join(TOOL_DB_NAME.'.categories', 'categories.category_id = pub_information.category', 'left');
        $this->db->join(TOOL_DB_NAME.'.form_type', 'form_type.form_type_id = code.form_type_id', 'left');
        $this->db->join(TOOL_DB_NAME.'.clients', 'clients.client_id = pub_information.company_id', 'left');
        $this->db->where(array('form_type.form_type_code'=>$Product, 'pub_information.form_type'=>$Product, 'pub_information.pub_status'=>'1', 'ad_data.ad_data_status'=>'1'));
        
        
        if($eg_month != '')
        {
        	$this->db->where(array('ad_data.month'=>$eg_month));        
        }
        if($eg_year != '')
        {
        	$this->db->where(array('ad_data.year'=>$eg_year));        
        }
        
        
        if($select_city != '')
        {
        	$this->db->where(array('ad_data.city'=>$select_city));        
        }
        
        if($session != '')
        {
        	$this->db->where(array('ad_data.session'=>$session));        
        }
                
        $query = $this->db->get();
        
        $db_results = $query->result_array();		 
	                                
    	
		if (count($db_results) > 0 )
        { 
            return $db_results[0];
            
        } else {            
        
            return FALSE;
        } 		
	}
	
	
	
	
	
	function Master_List( $start_month, $start_year, $start_session, $end_month, $end_year, $end_session  )
	{
	
        $this->db->select("*");
        $this->db->from(TOOL_DB_NAME.'.pub_information');
        $this->db->join(TOOL_DB_NAME.'.ad_data', 'ad_data.pub_information_id = pub_information.pub_information_id', 'left');
        $this->db->join(TOOL_DB_NAME.'.code', 'code.code_id = ad_data.publish_type', 'left');
        $this->db->join(TOOL_DB_NAME.'.categories', 'categories.category_id = pub_information.category', 'left');
        $this->db->join(TOOL_DB_NAME.'.form_type', 'form_type.form_type_id = code.form_type_id', 'left');
        $this->db->join(TOOL_DB_NAME.'.clients', 'clients.client_id = pub_information.company_id', 'left');

	    $this->db->where( array( 'pub_information.pub_status'=>'1', 'ad_data.ad_data_status'=>'1' ));
	    
		if($start_month != '' && $end_month == '')
	        $this->db->where( array( 'ad_data.month >' => $start_month ));
	        
        if($start_month == '' && $end_month != '')
	        $this->db->where( array( 'ad_data.month <' => $end_month ));
        
	        
        if($start_year != '' && $end_year == '')
	        $this->db->where( array( 'ad_data.year>' => $start_year));
	        
        if($start_year == '' && $end_year != '')
	        $this->db->where( array( 'ad_data.year <' => $end_year));
	        
	        
	    if($start_month != '' && $end_month != '')
	        $this->db->where( 'ad_data.month BETWEEN "'.$start_month.'" AND "' .$end_month.'"'  );
	    if($start_year != '' && $end_year != '')    
	        $this->db->where( 'ad_data.year BETWEEN "'.$start_year.'" AND "' .$end_year.'"'  );
        
        if($start_session != '')
        {
        	$this->db->where(array('ad_data.session'=>$start_session));
        }
        
        if($end_session != '')
        {
        	$this->db->where(array('ad_data.session'=>$end_session));
        }
        
        $this->db->group_by("clients.client_id");
        $this->db->order_by("ad_data.created_on", "DESC");
        
        if($select_city != '')
        {
        	$this->db->where(array('ad_data.city'=>$select_city));        
        }
        
        if($session != '')
        {
        	$this->db->where(array('ad_data.session'=>$session));        
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
	
	
	
	
	function View_Ro( $id )
	{
		
        $this->db->select("*");
        $this->db->from(TOOL_DB_NAME.'.pub_information');
        $this->db->join(TOOL_DB_NAME.'.ad_data', 'ad_data.pub_information_id = pub_information.pub_information_id', 'left');
        $this->db->join(TOOL_DB_NAME.'.code', 'code.code_id = ad_data.publish_type', 'left');
        $this->db->join(TOOL_DB_NAME.'.categories', 'categories.category_id = pub_information.category', 'left');
        $this->db->join(TOOL_DB_NAME.'.clients', 'clients.client_id = pub_information.company_id', 'left');
        $this->db->where( array( 'pub_information.ro_number' => $id, 'pub_information.pub_status'=>'1' ));
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
	
	

	function Total_Insertions( $pub_id )
	{
	
        $this->db->select("count(ad_data.ad_data_id) as total_insertion");
        $this->db->from(TOOL_DB_NAME.'.ad_data');
        $this->db->where( array( 'ad_data.ad_data_status'=>'1', 'ad_data.pub_information_id' => $pub_id ));
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
	
	function New_Ro_Signed( )
	{
	
        $this->db->select("*");
        $this->db->from(TOOL_DB_NAME.'.pub_information');
        $this->db->join(TOOL_DB_NAME.'.ad_data', 'ad_data.pub_information_id = pub_information.pub_information_id', 'left');
        $this->db->join(TOOL_DB_NAME.'.code', 'code.code_id = ad_data.publish_type', 'left');
        $this->db->join(TOOL_DB_NAME.'.categories', 'categories.category_id = pub_information.category', 'left');
        $this->db->join(TOOL_DB_NAME.'.clients', 'clients.client_id = pub_information.company_id', 'left');
        
        $this->db->where( array( 'pub_information.pub_status'=>'1' , 'ad_data.ad_data_status'=>'1'));
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
	




	function Revenue_Report( $start_month, $start_year, $start_session, $end_month, $end_year, $end_session  )
	{
	
        $this->db->select("*, COUNT(ad_data_id) as qty, SUM(ad_data.offered_rate) as net_bill");
        $this->db->from(TOOL_DB_NAME.'.pub_information');
        $this->db->join(TOOL_DB_NAME.'.ad_data', 'ad_data.pub_information_id = pub_information.pub_information_id', 'left');
        $this->db->join(TOOL_DB_NAME.'.code', 'code.code_id = ad_data.publish_type', 'left');
        $this->db->join(TOOL_DB_NAME.'.categories', 'categories.category_id = pub_information.category', 'left');
        $this->db->join(TOOL_DB_NAME.'.form_type', 'form_type.form_type_id = code.form_type_id', 'left');
        $this->db->join(TOOL_DB_NAME.'.clients', 'clients.client_id = pub_information.company_id', 'left');
        $this->db->where( array( 'pub_information.pub_status'=>'1' , 'ad_data.ad_data_status'=>'1'));
        
        if($start_month != '' && $end_month == '')
	        $this->db->where( array( 'ad_data.month >' => $start_month ));
	        
        if($start_month == '' && $end_month != '')
	        $this->db->where( array( 'ad_data.month <' => $end_month ));
        
	        
        if($start_year != '' && $end_year == '')
	        $this->db->where( array( 'ad_data.year>' => $start_year));
	        
        if($start_year == '' && $end_year != '')
	        $this->db->where( array( 'ad_data.year <' => $end_year));
	        
	        
	    if($start_month != '' && $end_month != '')
	        $this->db->where( 'ad_data.month BETWEEN "'.$start_month.'" AND "' .$end_month.'"'  );
	    if($start_year != '' && $end_year != '')    
	        $this->db->where( 'ad_data.year BETWEEN "'.$start_year.'" AND "' .$end_year.'"'  );
        
        if($start_session != '')
        {
        	$this->db->where(array('ad_data.session'=>$start_session));
        }
        
        if($end_session != '')
        {
        	$this->db->where(array('ad_data.session'=>$end_session));
        }
        
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
	


	function Renevue_Calc( $start_month, $start_year, $start_session, $end_month, $end_year, $end_session )
	{
	
        $this->db->select("SUM(ad_data.offered_rate) as total_amount, SUM(code.rack_rate) as total_turnover ");
        $this->db->from(TOOL_DB_NAME.'.pub_information');
        $this->db->join(TOOL_DB_NAME.'.ad_data', 'ad_data.pub_information_id = pub_information.pub_information_id', 'left');
        $this->db->join(TOOL_DB_NAME.'.code', 'code.code_id = ad_data.publish_type', 'left');
        $this->db->join(TOOL_DB_NAME.'.form_type', 'form_type.form_type_id = code.form_type_id', 'left');
        $this->db->join(TOOL_DB_NAME.'.clients', 'clients.client_id = pub_information.company_id', 'left');
        $this->db->where( array( 'pub_information.pub_status'=>'1', 'ad_data.ad_data_status'=>'1'));
        if($start_month != '' && $end_month == '')
	        $this->db->where( array( 'ad_data.month >' => $start_month ));
	        
        if($start_month == '' && $end_month != '')
	        $this->db->where( array( 'ad_data.month <' => $end_month ));
        
	        
        if($start_year != '' && $end_year == '')
	        $this->db->where( array( 'ad_data.year>' => $start_year));
	        
        if($start_year == '' && $end_year != '')
	        $this->db->where( array( 'ad_data.year <' => $end_year));
	        
	        
	    if($start_month != '' && $end_month != '')
	        $this->db->where( 'ad_data.month BETWEEN "'.$start_month.'" AND "' .$end_month.'"'  );
	    if($start_year != '' && $end_year != '')    
	        $this->db->where( 'ad_data.year BETWEEN "'.$start_year.'" AND "' .$end_year.'"'  );
        
        if($start_session != '')
        {
        	$this->db->where(array('ad_data.session'=>$start_session));
        }
        
        if($end_session != '')
        {
        	$this->db->where(array('ad_data.session'=>$end_session));
        }
        

        $query = $this->db->get();
        
		$db_results = $query->result_array();		 
		
		if (count($db_results) > 0 )
        { 
            return $db_results[0];
            
        } else {            
        
            return FALSE;
        } 		
	}
	




	function Calc_Count_Bills( $start_month, $start_year, $start_session, $end_month, $end_year, $end_session )
	{
	
        $this->db->select("SUM(ad_data.offered_rate) as total_net_bill, count(ad_data.ad_data_id) as qty, pub_information.pub_information_id ");
        $this->db->from(TOOL_DB_NAME.'.pub_information');
        $this->db->join(TOOL_DB_NAME.'.ad_data', 'ad_data.pub_information_id = pub_information.pub_information_id', 'left');
        $this->db->join(TOOL_DB_NAME.'.code', 'code.code_id = ad_data.publish_type', 'left');
        $this->db->join(TOOL_DB_NAME.'.form_type', 'form_type.form_type_id = code.form_type_id', 'left');
        $this->db->join(TOOL_DB_NAME.'.clients', 'clients.client_id = pub_information.company_id', 'left');
        $this->db->where( array( 'pub_information.pub_status'=>'1', 'ad_data.ad_data_status'=>'1'));
        
        if($start_month != '' && $end_month == '')
	        $this->db->where( array( 'ad_data.month >' => $start_month ));
	        
        if($start_month == '' && $end_month != '')
	        $this->db->where( array( 'ad_data.month <' => $end_month ));
        
	        
        if($start_year != '' && $end_year == '')
	        $this->db->where( array( 'ad_data.year>' => $start_year));
	        
        if($start_year == '' && $end_year != '')
	        $this->db->where( array( 'ad_data.year <' => $end_year));
	        
	        
	    if($start_month != '' && $end_month != '')
	        $this->db->where( 'ad_data.month BETWEEN "'.$start_month.'" AND "' .$end_month.'"'  );
	    if($start_year != '' && $end_year != '')    
	        $this->db->where( 'ad_data.year BETWEEN "'.$start_year.'" AND "' .$end_year.'"'  );
        
        if($start_session != '')
        {
        	$this->db->where(array('ad_data.session'=>$start_session));
        }
        
        if($end_session != '')
        {
        	$this->db->where(array('ad_data.session'=>$end_session));
        }
        
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