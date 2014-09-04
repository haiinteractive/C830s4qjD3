<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class AppProcessor extends CI_Hooks {

    private $CI;    
    // member parametrs    
    
    /**
     * @method __construct
     * @param string/int $init - user id or email of user to load      
     * @access public    
     * @return none
     */
    public function __construct($init = false)
    {
    	parent::__construct();      
        
    } 
    /**
     * @method index
     * @param  none      
     * @access public    
     * @return None
     */
    public function index()
    {
		ini_set('include_path', ini_get('include_path').':'.BASEPATH.'libraries/swift_mailer/');
		
	}    
	
    
}
?>
