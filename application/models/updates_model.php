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
 
class Updates_Model extends CI_Model
{
 
	 public $_dataMap = ''; 
	 
	 
	function Update_Pub_Information( $arg, $pub_id )
	{
	
		$this->db->where('pub_information.pub_information_id', $pub_id);
		$this->db->update(TOOL_DB_NAME.'.pub_information', $arg);    	
		
		return true;
	}
	
	
	function Remove_Ad_Type( $pub_id )
	{
	
		$this->db->where('ad_data.pub_information_id', $pub_id);
		$this->db->delete(TOOL_DB_NAME.'.ad_data');    	
		
		return true;
		
	}
	
	
	function Inactive_Ad_Type( $arg, $ad_data_id )
	{
	
		$this->db->where('ad_data.pub_information_id', $ad_data_id);
		$this->db->update(TOOL_DB_NAME.'.ad_data', $arg);    	
		
		return true;
	}
	
	function Update_Ad_Type( $arg, $ad_data_id )
	{
	
		$this->db->where('ad_data.ad_data_id', $ad_data_id);
		$this->db->update(TOOL_DB_NAME.'.ad_data', $arg);    	
		
		return true;
	}
	
	
	function Inactive_Pub( $arg, $pub_id )
	{
	
		$this->db->where('pub_information.pub_information_id', $pub_id);
		$this->db->update(TOOL_DB_NAME.'.pub_information', $arg);    	
		
		return true;
	}
	
}
/* End of file users_model.php */
?>