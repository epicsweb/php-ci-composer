<?php

namespace Epicsweb;

class PhpMessages
{

	private $framework;

	//CONSTRUCT
	public function __construct($framework = 'ci') {

		$this->framework = $framework;

	}

    //FUNÇAO QUE EXECUTA O CURL
    private function executeCurl($param) {

    	if( is_array($param) && $param['url'] && $param['data'] ) {

	    	//VERIFICA FRAMEWORK
	    	switch ($this->framework) {
	    		case 'laravel':
	    			
	    			$url 			= env('PM_URL');
	    			$userpwd 		= env('PM_USER');
	    			$passpwd 		= env('PM_PASS');

	    		break;
	    		case 'ci':
	    			
	    			//LOAD THE CONFIG FILE
	    			$ci =& get_instance();
	    			$ci->config->load('epicsweb');
			    	$url 			= $ci->config->item('pm_url');
	    			$userpwd 		= $ci->config->item('pm_user');
	    			$passpwd 		= $ci->config->item('pm_pass');

	    		break;
	    		default:

	    			return false;

	    		break;
	    	}

	    	//PREPARA OS DADS
	    	$url 			= $url . $param['url'];
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

                    if( $param['data'] && is_array($param['data']) )
                        $url = $url . '?' . http_build_query($param['data'], NULL, '&');

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

    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - 
    // MAIL
    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - 

    //FUNCTION TO SEND A EMAIL
    public function send_mail($data)
    {
        return $this->executeCurl([
            'url'       => 'send',
            'data'      => $data,
            'method'    => 'post'
        ]);
    }

    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - 
    // SMS
    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - 

    //FUNCTION TO SEND A SMS
    public function send_sms($data)
    {
        return $this->executeCurl([
            'url'   	=> 'sendsms',
            'data'    	=> $data,
            'method'    => 'post'
        ]);
    }

    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - 
    // PUSH
    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - 

    //FUNCTION TO SEND A PUSH NOTIFICATION
    public function send_push($data)
    {
        if( isset($data['recipients']) && count($data['recipients']) > 0 ) {
            return $this->executeCurl([
                'url'       => 'push/send',
                'data'      => $data,
                'method'    => 'post'
            ]);
        } else return false;
    }

    //FUNCTION TO SEND A PUSH NOTIFICATION - ACCOUNT ID
    public function push_create( $data )
    {
        return $this->executeCurl([
            'url'       => 'push/create',
            'data'      => $data,
            'method'    => 'post'
        ]);
    }

    // GET ACTIVE TOKENS FROM USER
    public function push_tokens( $data )
    {
        return $this->executeCurl([
            'url'       => 'push/tokens',
            'data'      => $data,
            'method'    => 'get'
        ]);
    }

    // CREATE A NEW TOKEN
    public function push_token_create( $data )
    {
        return $this->executeCurl([
            'url'       => 'push/token_create',
            'data'      => $data,
            'method'    => 'post'
        ]);
    }

    // DELETE TOKEN
    public function push_token_remove( $data )
    {
        return $this->executeCurl([
            'url'       => 'push/token_remove',
            'data'      => $data,
            'method'    => 'post'
        ]);
    }
    
    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - 
    // LEAD - MAILCHIMP
    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - 

    //FUNCTION TO CREATE A MEMBER IN LIST
    public function mailchimp_create($data)
    {
        return $this->executeCurl([
            'url'   	=> 'lists/mailchimp',
            'data'    	=> $data,
            'method'    => 'post'
        ]);
    }

    //FUNCTION TO CREATE A MEMBER IN LIST
    public function mailchimp_delete($data)
    {
        return $this->executeCurl([
            'url'   	=> 'lists/mailchimp_delete',
            'data'    	=> $data,
            'method'    => 'post'
        ]);
    }

    //FUNCTION TO CREATE A MEMBER IN LIST
    public function mailchimp_edit($data)
    {
        return $this->executeCurl([
            'url'   	=> 'lists/mailchimp_edit',
            'data'    	=> $data,
            'method'    => 'post'
        ]);
    }

    //FUNCTION TO CREATE A MEMBER IN LIST
    public function mailchimp_tag($data)
    {
        return $this->executeCurl([
            'url'   	=> 'lists/mailchimp_tag',
            'data'    	=> $data,
            'method'    => 'post'
        ]);
    }

    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - 
    // NOTIFICATIONS - PUSH
    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - 

    // CREATE OR UPDATE A NEW NOTIFICATION
    public function notifications_create_or_update($data)
    {
        return $this->executeCurl([
            'url'       => 'notifications/create_or_update',
            'data'      => $data,
            'method'    => 'post'
        ]);
    }

    // RETURN ALL NOTIFICATIONS FROM A USER
    public function notifications_get_all($data)
    {
        return $this->executeCurl([
            'url'       => 'notifications/get_all_user',
            'data'      => $data,
            'method'    => 'get'
        ]);
    }

    // RETURN ONE NOTIFICATION FROM A USER
    public function notifications_get_one($data)
    {
        return $this->executeCurl([
            'url'       => 'notifications/get_one_user',
            'data'      => $data,
            'method'    => 'get'
        ]);
    }
    
}