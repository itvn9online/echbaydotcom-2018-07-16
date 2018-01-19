<?php



//
if ( ! isset( $_GET['id'] ) ) {
	die('Booking ID not found!');
}
$hd_id = (int)$_GET['id'];



//
$file_for_sendmail = EB_THEME_CACHE . 'booking_mail/' . $hd_id . '.txt';
//echo $file_for_sendmail . '<br>' . "\n";



// nếu file không tồn tại -> mail đã được gửi -> bỏ qua
if ( ! file_exists( $file_for_sendmail ) ) {
	EBE_show_log( 'Mail has been send or mail content not create!' ); exit();
}



//
$mail_content = file_get_contents($file_for_sendmail, 1);

//
$mail_to_admin = WGR_get_dom_xml($mail_content, 'mail_to_admin');
//echo $mail_to_admin . '<br>' . "\n";
$mail_title = WGR_get_dom_xml($mail_content, 'mail_title');
//echo $mail_title . '<br>' . "\n";
$message = WGR_get_dom_xml($mail_content, 'message');
$bcc_email = WGR_get_dom_xml($mail_content, 'bcc_email');
//echo $bcc_email . '<br>' . "\n";


// Nếu gửi mail thành công
if ( _eb_send_email ( $mail_to_admin, $mail_title, $message, '', $bcc_email ) == true ) {
	// Xóa file
	_eb_remove_file( $file_for_sendmail );
	
	//
	$m_log = 'Send mail OK!';
}
else {
	$m_log = 'ERROR! mail not send';
}

//
_eb_log_admin_order( $m_log . ' (To: ' . $mail_to_admin . '. Bcc: ' . $bcc_email . ')', $hd_id );




