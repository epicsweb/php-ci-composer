<?php

namespace Epicsweb;

class PhpCiMessages
{

    //FUNÇAO QUE EXECUTA O CURL
    private function executeCurl($param) {

    	$ci =& get_instance();

    	if( is_array($param) && $param['url'] && $param['data'] ) {

			//LOAD THE CONFIG FILE
	    	$ci->config->load('phpmessages');

	    	//URL
	    	$url 			= $ci->config->item('pm_url');
	    	$url 			= $url . $param['url'];

	    	//USER AND PASSWORD (AUTH)
	    	$userpwd 		= $ci->config->item('pm_user');
	    	$passpwd 		= $ci->config->item('pm_pass');
	    	$auth			= $userpwd . ':' . $passpwd;
  
	        switch ($param['method']) {

	            case 'post':

	                $curl 			= curl_init($url);
	                curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	                curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
	                curl_setopt($curl, CURLOPT_USERPWD, $auth);
	                curl_setopt($curl, CURLOPT_POST, true);
	                curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($param['data'], NULL, '&'));
	                $curl_response = curl_exec($curl);
	                curl_close($curl);
	                return json_decode($curl_response);

	            break;
	            case 'get':

	                $curl = curl_init($url);
	                curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	                curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
	                curl_setopt($curl, CURLOPT_USERPWD, $auth);
	                $curl_response = curl_exec($curl);
	                curl_close($curl);

	                return json_decode($curl_response);

	            break;
	        }

	   	} else return false;

    }

    //FUNCTION TO SEND A SMS
    public function send_sms($message)
    {
        return $this->executeCurl([
            'url'   	=> 'sendsms',
            'data'    	=> $message,
            'method'    => 'post'
        ]);
    }
    
    //FUNCTION TO SEND A EMAIL
    public function send_mail($message)
    {
        return $this->executeCurl([
            'url'   	=> 'send',
            'data'    	=> $message,
            'method'    => 'post'
        ]);
    }
    
}