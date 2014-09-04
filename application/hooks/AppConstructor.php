<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class AppConstructor extends CI_Hooks {

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

        $this->CI = & get_instance();
        $this->CI->load->library('carabiner'); 
        $carabiner_config = array(
            'script_dir' => 'assets/', 
            'style_dir'  => 'assets/',
            'cache_dir'  => 'assets/cache/',
            'base_uri'   => '',
            'combine'    => TRUE,
            'dev'        => FALSE
        );
        $this->CI->carabiner->config($carabiner_config);
        $this->CI->load->helper(array('form', 'url', 'cookie')); 

    } 
    /**
     * @method doConstruct
     * @param  none      
     * @access public    
     * @return $response
     */
    function doConstruct()
    {
    	$view_info = false;
/*    $this->CI->carabiner->js('files/ugc/js/jquery-1.10.1.min.js');
 //   $this->CI->carabiner->js('js/app.v1.js');
    $this->CI->carabiner->js('js/app.plugin.js');
    $this->CI->carabiner->js('files/js/jquery.validate.min.js');
    $this->CI->carabiner->js('files/ugc/js/user.js');
    $this->CI->carabiner->js('files/js/main.js');
    $this->CI->carabiner->js('js/validation.js');
    $this->CI->carabiner->js('js/charts/easypiechart/jquery.easy-pie-chart.js');
    $this->CI->carabiner->js('js/charts/sparkline/jquery.sparkline.min.js');
    $this->CI->carabiner->js('js/calendar/bootstrap_calendar.js');
    $this->CI->carabiner->js('js/calendar/demo.js');
    $this->CI->carabiner->js('js/sortable/jquery.sortable.js');
    $this->CI->carabiner->js('files/js/jquery.quicksand.js');
    $this->CI->carabiner->js('files/js/jquery.easing.1.3.js');
    $this->CI->carabiner->js('files/js/jquery.tipsy.js');
    $this->CI->carabiner->js('files/js/jquery.ui.core.js');
    $this->CI->carabiner->js('files/js/jquery.ui.widget.js');
    $this->CI->carabiner->js('files/js/jquery.ui.mouse.js');
    $this->CI->carabiner->js('files/js/jquery.ui.slider.js');
    $this->CI->carabiner->js('files/js/jquery.ui.progressbar.js');
    $this->CI->carabiner->js('files/js/jquery.ui.datepicker.js');
    $this->CI->carabiner->js('files/js/jquery.ui.tabs.js');
    $this->CI->carabiner->js('files/js/fullcalendar.js');
    $this->CI->carabiner->js('files/js/gcal.js');
  //  $this->CI->carabiner->js('files/js/bootstrap-modal.js');
    $this->CI->carabiner->js('files/js/fancybox/jquery.mousewheel-3.0.4.pack.js');
    $this->CI->carabiner->js('js/moment.js');
    $this->CI->carabiner->js('js/daterangepicker.js');

	$this->CI->carabiner->display('js');
        $this->CI->carabiner->empty_cache('both', 'yesterday');*/
    }    
	
	
}
?>
