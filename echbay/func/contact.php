<?php



//print_r( $_POST );
//print_r( $_GET );
//exit();
$_POST = EBE_stripPostServerClient ();


//
$t_email = strtolower ( trim ( $_POST ['t_email'] ) );

if ( _eb_check_email_type ( $t_email ) != 1 ) {
	_eb_alert( EBE_get_lang('cart_emailformat') );
}


//
if (mtv_id > 0) {
	$tv_id = mtv_id;
	$t_email = mtv_email;
} else {
	$tv_id = _eb_create_account_auto ( array(
		'tv_matkhau' => '',
		'tv_hoten' => $_POST['t_ten'],
		'tv_dienthoai' => $_POST['t_dienthoai'],
//		'user_name' => '',
		'tv_diachi' => $_POST['t_diachi'],
		'tv_email' => $t_email
	) );
}
$user_info = get_userdata( $tv_id );
//print_r($user_info);
$user_login = $user_info->user_login;




// Gửi email thông báo
$message = EBE_str_template ( 'html/mail/contact.html', array (
		'tmp.t_ten' => $_POST['t_ten'],
		// email giữ nguyên như lúc người dùng nhập vào
		'tmp.t_email' => $_POST ['t_email'],
		'tmp.t_diachi' => $_POST['t_diachi'],
		'tmp.t_dienthoai' => $_POST['t_dienthoai'],
		'tmp.t_noidung' => nl2br( $_POST['t_noidung'] ),
		
		// lang
		'tmp.lh_hoten' => EBE_get_lang('lh_hoten'),
		'tmp.lh_diachi' => EBE_get_lang('lh_diachi'),
		'tmp.lh_dienthoai' => EBE_get_lang('lh_dienthoai'),
		'tmp.lh_noidung' => EBE_get_lang('lh_noidung'),
), EB_THEME_PLUGIN_INDEX );
//echo $message . '<br>' . "\n";
//exit();




//
EBE_insert_comment( array(
	'comment_author' => $user_login,
	'comment_author_email' => $t_email,
	'comment_content' => $message,
	'user_id' => $tv_id,
) );



//
$mail_title = 'Contact from ' . _eb_non_mark( $_POST['t_ten'] ) . ' (' . $_POST['t_email'] . ')';




// gửi email cho admin
$mail_to_admin = $__cf_row ['cf_email'];
if ($__cf_row ['cf_email_note'] != '') {
	$mail_to_admin = $__cf_row ['cf_email_note'];
}



$bcc_email = '';
if (strstr ( $t_email, '@gmail.com' ) == true
|| strstr ( $t_email, '@yahoo.' ) == true
|| strstr ( $t_email, '@hotmail.com' ) == true) {
	$bcc_email = $t_email;
//	_eb_send_email( $t_email, $mail_title, $message, '', $mail_to_admin );
}

// -> ép buộc sử dụng hàm mail mặc định
//$__cf_row ['cf_sys_email'] = 0;

_eb_send_email ( $mail_to_admin, $mail_title, $message, '', $bcc_email );





//
echo '<script>
parent.document.frm_contact.t_noidung.value = "";
</script>';

//
_eb_alert( EBE_get_lang('lh_done') );




