<?php


//
if ( mtv_id == 0 ) {
	die('For user only');
}


//
$email = '';
if (isset ( $_GET ['email'] ) ) {
	$email = trim ( $_GET ['email'] );
	
	if ( _eb_check_email_type( $__cf_row['cf_smtp_email'] ) != 1 ) {
		$email = '';
	}
}

if ( $email == '' ) {
	$email = $__cf_row['cf_email'];
}


//
$mesage = nl2br( trim( '

Nội dung: test email
Host: ' . $_SERVER ['HTTP_HOST'] . '
Ngày thử: ' . date ( 'd-m-Y H:i:s', $date_time ) . '
IP thử: ' . $client_ip . '
User: #' . mtv_id . '

' ) );


//
if ( _eb_send_email( $email, 'Test email via EchBay e-commerce plugin', $mesage ) == true ) {
	echo 'OK';
}
else {
	echo 'ERROR';
}




exit();




