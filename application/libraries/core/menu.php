<?php
/**
 * The Menu class file.
 *
 * @category Menu
 * @package  None
 * @author   Anoop KP
 * @license  http://www.skillsweet.com 
 * @link     models/users_model.php
 * 
 */
 
class Menu
{
    private $_CI;    
    // present for all users
    
    public $loggedIn = false;
    /**
     * Constructor.
     * Loads the CI instance, the users_model and some useful helpers.
     * Creates a menu_lib object, populated if passed a valid $init.    
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
        $this->_CI->load->model('users_model');
        $this->_CI->load->library('core/sh_users');         
        $this->_CI->load->config('menu');
        $this->_CI->load->helper('url');        
		$menus= $this->_CI->config->item('menus');
		$finalMenu = array();		
    	$userdata = $this->_CI->session->userdata('user');
        $this->_CI->mysmarty->assign('base_url', base_url());
        $sessionUserdata = $this->_CI->session->userdata('ECITY');
        
        $this->_CI->mysmarty->assign('sess',$sessionUserdata);
     	 
         define('SITE_URL', base_url());
         $this->_CI->mysmarty->assign('static_server',base_url());
		 $this->_CI->mysmarty->assign('menus',$finalMenu);
         
    }
 
        
}
/* End of file menu.php */