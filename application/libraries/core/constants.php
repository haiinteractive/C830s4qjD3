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
 
class Constants
{
    private $_CI;    
    // present for all users
    
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
    }
    
    
    /**
     * RETURN PUBLIC ACCESS
     */
    
    function Get_Public_Access( )
    {
		/**
		 *      		1 - Public , 2 - Private, 3 - Only for Friends
		 */
    
    	$public_access = false;
    	
    	$public_access = array( 1 => 'Public',	2 => 'Private',	3 => 'Friends' );
    	
    	return $public_access;
    }
    
    /**
     * RETURN RIGHTERN STATUS
     */
        
    function Get_Rightern_Status( )
    {
		/**
		 *      		    0 - Inactive, 1 - Active, 2 - Warning, 3 - Suspension
		 */
    
    	$rightern_status = false;
    	
    	$rightern_status = array( 0 => 'Inactive',	1 => 'Active',	2 => 'Warning', 3 => 'Suspension'  );
    	
    	return $rightern_status;
    }
    
    
    
    /**
     * RETURN RIGHTERN STATUS
     */
        
    function Get_English( )
    {
		/**
		 *      		    1 - 50 Years Of Experience
		 */
    
    	$english = false;
    	
    	$english = array( 1 => 'Basic',	2 => 'Good', 3 => 'Fluent writtern and basic ');
    	
    	return $english;
    }
    
    
    
    /**
     * RETURN Category : Web Development
     */
        
    function Get_Categories( )
    {
		/**
		 *      		    Main Categories
		 */
    
    	$web_development = false;

    	$web_development = array( 1 => 'Web Development',	2 => 'Software Development', 3 => 'Networking & Information Systems', 4 => 'Writing & Translation', 5 => 'Administrative Support', 6 => 'Design & Multimedia', 7 => 'Customer Service', 7 => 'Sales & Marketing', 7 => 'Business Services' );
    	
    	return $web_development;
    }
    
}