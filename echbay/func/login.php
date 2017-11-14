<?php



// https://codex.wordpress.org/Function_Reference/wp_signon


//
WGR_auto_update_link_for_demo ( _eb_get_option('home'), _eb_get_option('siteurl') );


//print_r($_POST);
if ( ! isset($_POST['t_email']) || ! isset($_POST['t_matkhau']) ) {
	_eb_alert('Dữ liệu đầu vào không chính xác');
}

//
$creds = array();

//
$creds['user_login'] = trim( $_POST['t_email'] );
$creds['user_password'] = $_POST['t_matkhau'];
if ( isset($_POST['t_remember']) && $_POST['t_remember'] == 1 ) {
	$creds['remember'] = true;
} else {
	$creds['remember'] = false;
}

//
if ( _eb_check_email_type ( $creds['user_login'] ) != 1 ) {
	_eb_alert( 'Email không đúng định dạng' );
}

// true -> với site có SSL không cần đăng nhập lại
if ( eb_web_protocol == 'https' ) {
	$user = wp_signon( $creds, true );
}
// false -> với site SSL thì phải đăng nhập lại
else {
	$user = wp_signon( $creds, false );
}

if ( is_wp_error($user) ) {
	_eb_alert('Tài khoản hoặc mật khẩu không chính xác');
//	echo $user->get_error_message();
}
//print_r($user);
//___eb_custom_login( $creds );


//
//wp_set_current_user($user_ID);
//wp_set_auth_cookie($user_ID);



//
die('<script type="text/javascript">
parent.___eb_custom_login_done();
</script>');

exit();




