<?php




function WGR_remove_html_comments ( $a ) {
	
	$str = '';
	
	$a = explode( '-->', $a );
	foreach ( $a as $v ) {
		$v = explode('<!--', $v);
		$str .= $v[0];
	}
	
	return trim( $str );
	
}



function WGR_copy_secure_file($FromLocation, $ToLocation, $VerifyPeer = false, $VerifyHost = true) {
	// Initialize CURL with providing full https URL of the file location
	$Channel = curl_init ( $FromLocation );
	
	// Open file handle at the location you want to copy the file: destination path at local drive
	$File = fopen ( $ToLocation, "w" );
	
	// Set CURL options
	curl_setopt ( $Channel, CURLOPT_FILE, $File );
	
	// We are not sending any headers
	curl_setopt ( $Channel, CURLOPT_HEADER, 0 );
	
	// Disable PEER SSL Verification: If you are not running with SSL or if you don't have valid SSL
	curl_setopt ( $Channel, CURLOPT_SSL_VERIFYPEER, $VerifyPeer );
	
	// Disable HOST (the site you are sending request to) SSL Verification,
	// if Host can have certificate which is nvalid / expired / not signed by authorized CA.
	curl_setopt ( $Channel, CURLOPT_SSL_VERIFYHOST, $VerifyHost );
	
	// Execute CURL command
	curl_exec ( $Channel );
	
	// Close the CURL channel
	curl_close ( $Channel );
	
	// Close file handle
	fclose ( $File );
	
	// return true if file download is successfull
	return file_exists ( $ToLocation );
}




/*
* Tải file theo thời gian thực
*/
function EBE_admin_get_realtime_for_file ( $v ) {
	return filemtime( str_replace( EB_URL_OF_PLUGIN, EB_THEME_PLUGIN_INDEX, $v ) );
}

function EBE_admin_set_realtime_for_file ( $arr ) {
	foreach ( $arr as $k => $v ) {
		$arr[$k] = $v . '?v=' . EBE_admin_get_realtime_for_file( $v );
	}
	return $arr;
}



