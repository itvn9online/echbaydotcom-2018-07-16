<?php



//print_r($_POST);
if ( ! isset($_POST['t_email']) || ! isset($_POST['t_matkhau']) ) {
	_eb_alert( EBE_get_lang('reg_no_email') );
}


//
$user_email = _eb_non_mark( strtolower( trim( $_POST['t_email'] ) ) );
$t_matkhau = $_POST['t_matkhau'];
$t_matkhau2 = $_POST['t_matkhau2'];


//
if ( trim( $t_matkhau ) == '' || strlen( $t_matkhau ) < 6 ) {
	_eb_alert( EBE_get_lang('reg_pass_short') );
}
if ( $t_matkhau != $t_matkhau ) {
	_eb_alert( EBE_get_lang('reg_pass_too') );
}


//
if ( _eb_check_email_type ( $user_email ) != 1 ) {
	_eb_alert( EBE_get_lang('reg_email_format') );
}

// tìm theo email
$user_id = email_exists( $user_email );

// có thì trả về luôn
if ( $user_id > 0 ) {
	if ( isset( $_POST['for_quick_register'] ) ) {
		_eb_alert( EBE_get_lang('reg_thanks') );
	}
	else {
		_eb_alert( EBE_get_lang('reg_email_exist') );
	}
}
//exit();


// tạo username từ email
$user_name = explode( '@', $user_email );
$user_name = $user_name[0];
$user_name = str_replace( '.', '_', $user_name );

//
$check_user_exist = $user_name;

// Kiểm tra user có chưa (chạy khoảng 99 lần để kiểm tra)
for ( $i = 1; $i < 100; $i++ ) {
	$user_id = username_exists( $check_user_exist );
	
	// nếu có -> thêm $i vào sau để tạo user mới
	if ( $user_id > 0 ) {
		$check_user_exist = $user_name .  $i;
	} else {
		break;
	}
//	echo $check_user_exist . '<br>' . "\n";
//	echo $i . '<br>' . "\n";
}

//
$user_name = $check_user_exist;


// tạo tài khoản
$user_id = wp_create_user( $user_name, $t_matkhau, $user_email );




// nếu là quick register -> dừng ở đây là được
if ( isset( $_POST['for_quick_register'] ) ) {
//	echo $user_id . '<br>';
	
	// cho vào nhóm đăng ký nhận tin
	$user_id_role = new WP_User($user_id);
	$user_id_role->set_role('quickregister');
	
	// thêm thông tin
	$t_ten = '';
	if ( isset( $_POST['t_hoten'] ) ) {
		$t_ten = trim( $_POST['t_hoten'] );
		
		wp_update_user(
			array(
				'ID' => $user_id,
				'first_name' => $t_ten
			)
		);
	}
//	echo $t_ten . '<br>';
	
	$t_dienthoai = '';
	if ( isset( $_POST['t_dienthoai'] ) ) {
		$t_dienthoai = trim( $_POST['t_dienthoai'] );
		
		update_user_meta( $user_id, 'phone', $t_dienthoai );
	}
//	echo $t_dienthoai . '<br>';
	
	
	
	
	
	
	// gửi mail thông báo
	$bcc_email = '';
	if (strstr ( $user_email, '@gmail.com' ) == true
	|| strstr ( $user_email, '@yahoo.' ) == true
	|| strstr ( $user_email, '@hotmail.com' ) == true) {
		$bcc_email = $user_email;
	}
	
	
	
	// gửi email cho admin
	$mail_to_admin = $__cf_row ['cf_email'];
	if ($__cf_row ['cf_email_note'] != '') {
		$mail_to_admin = $__cf_row ['cf_email_note'];
	}
	
	//
	$mail_title = 'Dang ky nhan tin tu ' . $user_email;
	
	
	// Gửi email thông báo
	$custom_lang_html = EBE_get_lang('quick_register_mail');
	// mặc định là lấy theo file HTML -> act
	if ( trim( $custom_lang_html ) == 'quick_register_mail' ) {
		$custom_lang_html = file_get_contents( EB_THEME_PLUGIN_INDEX . 'html/mail/qregister.html' );
	}
	
	//
	$message = EBE_html_template( $custom_lang_html, array(
			'tmp.web_link' => web_link,
			'tmp.web_name' => $web_name,
			'tmp.t_ten' => $t_ten == '' ? $user_email : $t_ten,
			'tmp.t_dienthoai' => $t_dienthoai,
			'tmp.user_email' => $user_email
	) );
//	echo $message . '<br>'; exit();
	
	
	//
	if ( _eb_send_email ( $mail_to_admin, $mail_title, $message, '', $bcc_email ) ) {
		echo '<script>
console.log("Send mail to: ' . $mail_to_admin . ', BCC: ' . $bcc_email . '");
</script>';
	}
	
	
	
	
	
	
	//
	die('<script type="text/javascript">

//
if ( top != self ) {
	parent.document.frm_dk_nhantin.reset();
}
else {
	window.opener.document.frm_dk_nhantin.reset();
}

alert("' . EBE_get_lang('reg_done') . '");

</script>');
	
	exit();
}




//
//exit();

// tự động đăng nhập luôn
$creds = array();
$creds['user_login'] = $user_email;
$creds['user_password'] = $t_matkhau;

//
$user = wp_signon( $creds, false );
if ( is_wp_error($user) ) {
	_eb_alert( EBE_get_lang('reg_error') );
//	echo $user->get_error_message();
}
//print_r($user);
//___eb_custom_login( $creds );



//
die('<script type="text/javascript">
parent.___eb_custom_login_done();
</script>');

exit();




