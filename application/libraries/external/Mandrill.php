<?php

class Mandrill
{
	
	private $_CI;
	
    /**
     * Constructor.
     * Loads the CI instance, the users_model and some useful helpers.
     * Creates a users_lib object, populated if passed a valid $init.
     *
     * @param None
     * 
     * @access public
     * 
     * @return none
     */
    public function __construct()
    {
    	
        $this->_CI = & get_instance(); 
        $this->current_date	= date("Y-m-d H:i:s");
        
    }
	
	//public static function __callStatic($method, $args)
	public function request($method, $arguments = array())
	{

		// determine endpoint
		$endpoint = 'https://mandrillapp.com/api/1.0/'.$method.'.json';
		
		// build payload
		$arguments['key'] = 'TCHM17uAxP-6rNcovt5jYg';
		// setup curl request
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $endpoint);
		curl_setopt($ch, CURLOPT_TIMEOUT, 30);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
		curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($arguments));
		$response = curl_exec($ch);

		// catch errors
		if (curl_errno($ch))
		{
			#$errors = curl_error($ch);
			curl_close($ch);
			
			return false;
			//return $errors;
		}
		else
		{
			curl_close($ch);
			
			// return array
			return json_decode($response);
		}

	}

	
    /**
     * mandrill_send_mail
     *
     * @param $to_addresses - $to_addresses
     * @param $subject - $subject
     * @param $body - $body
     * 
     * @access public
     * 
     * @return None
    */      
    public function mandrill_send_mail( $from_address, $to_address, $subject, $body, $tag ) {
    	
    	if (is_array($to_address) && !empty($to_address)) {
    	
			$response = $this->request('messages/send', array(
								    'message' 		=> array(
									'html' 			=> $body,
									'subject' 		=> $subject,
									'from_name'		=> $from_address['name'],
									'from_email' 	=> $from_address['email'],
									'to' 			=> array($to_address),
			        				'track_opens'	=> true,
        							'track_clicks'	=> true,
									'url_strip_qs' 	=> true,			
								),
			));

			return $response;
    	}

    	return false;
    		
    }	
	
}