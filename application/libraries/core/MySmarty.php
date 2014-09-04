<?php
/**
 * The (my)Smarty class file.
 *
 * @category Smarty
 * @package  None
 * @author   Sean Cherchio <sean.cherchio@flycell.com>
 * @license  http://www.gamorama.com Gamorama
 * @link     Remote
 */

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

require_once APPPATH . "libraries/external/smarty/Smarty.class.php";

/**
 * MySmarty library class.
 * A class to wrap around the Smarty templating engine class
 * 
 * It uses and loads the Smarty instance (for its libraries.)
 *
 * @category Smarty
 * @package  None
 * @author   Sean Cherchio <sean.cherchio@flycell.com>
 * @license  http://www.gamorama.com Gamorama
 * @link     Remote
 */
class MySmarty extends Smarty
{
    
    /*
    |==========================================================
    | Constructor
    |==========================================================
    |
    |
    */
    
    public $CI = null;
    
    /**
     * Constructor.
     * Loads the Smarty instance and sets some default values
     * 
     * @access public
     * 
     * @return none
     */
    public function __construct()
    {
        parent::Smarty();
        $this->register_block('dynamic', 'smarty_block_dynamic', false);
        $this->cache_dir = (TMPPATH . "tm/smarty/cache");
          $this->compile_dir = (TMPPATH . "tm/smarty/templates_c");
         ;
        $this->template_dir = (APPPATH . "views");
        $this->default_template_dir = $this->template_dir . "/";
        $this->locale_template_dir = $this->template_dir . "/" ;
        $this->lang_template_dir = $this->template_dir . "/"  ;
         
        $this->caching = 0;
        $this->cache_lifetime = 3600;
        $this->compile_check = true;
        log_message('debug', "Smarty Class Initialized");
        
        $this->CI = & get_instance();
    }
    
    /**
     * display
     * Loads the CodeIgniter instance
     *
     * @param string  $resource   The template to display
     * @param string  $cache_id   identifier of specific cache
     * @param string  $compile_id identifier of compilation
     * @param boolean $display    display
     * 
     * @access public
     * 
     * @return none
     */
    public function fetch($resource, $cache_id = null, $compile_id = null, $display = false)
    {
        if (file_exists($this->lang_template_dir . '/' . $resource)) {
            $this->template_dir = $this->lang_template_dir;
        } elseif (file_exists($this->locale_template_dir . '/' . $resource)) {
            $this->template_dir = $this->locale_template_dir;
        } else {
            $this->template_dir = $this->default_template_dir;
        }
        $result = parent::fetch($resource, $cache_id, $compile_id, $display);
        if (!empty($result)) {
        	$this->template_dir = APPPATH . "views";
        	return $result;
        }
    }
}

/**
* Smarty_block_dynamic.
* function for the dynamic block
* 
* @param string $param   The parameter
* @param string $content The content to display
* @param object &$smarty The smarty object
* 
* @return none
*/
function Smarty_Block_dynamic($param, $content, &$smarty)
{
    return $content;
}
?>
