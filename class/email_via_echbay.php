<?php


/*
* Chức năng gửi email qua echbay.com
*/

class mailViaEchBay {
	
	function http_post_form($url, $data, $timeout = 20) {
		$ch = curl_init ();
		
		curl_setopt ( $ch, CURLOPT_URL, $url );
		
		curl_setopt ( $ch, CURLOPT_FAILONERROR, 1 );
		
		curl_setopt ( $ch, CURLOPT_FOLLOWLOCATION, 1 );
		
		curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, 1 );
		
		curl_setopt ( $ch, CURLOPT_TIMEOUT, $timeout );
		
		curl_setopt ( $ch, CURLOPT_FOLLOWLOCATION, 0 );
		
		curl_setopt ( $ch, CURLOPT_POST, 1 );
		
		curl_setopt ( $ch, CURLOPT_RANGE, "1-2000000" );
		
		curl_setopt ( $ch, CURLOPT_POSTFIELDS, $data );
		
		curl_setopt ( $ch, CURLOPT_REFERER, $_SERVER ['REQUEST_URI'] );
		
		curl_setopt ( $ch, CURLOPT_SSL_VERIFYPEER, false );
		
		$result = curl_exec ( $ch );
		
		$result = curl_error ( $ch ) ? curl_error ( $ch ) : $result;
		
		curl_close ( $ch );
		
		return $result;
	}
	
	function send ( $data = array() ) {
		
		//
		$api_uri = file_get_contents( 'http://www.api.echbay.com/send_mail.php', 1 );
		
		//
		$result = $this->http_post_form ( 'http://' . $api_uri . '/send_mail.php', $data );
		
		//
		return trim ( $result );
	}
}

//
//$mail_via_eb = new mailViaEchBay ();


