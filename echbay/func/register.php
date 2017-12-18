<?php



//print_r($_POST);
if ( ! isset($_POST['t_email']) || ! isset($_POST['t_matkhau']) ) {
	_eb_alert('Dữ liệu đầu vào không chính xác');
}


//
$user_email = _eb_non_mark( strtolower( trim( $_POST['t_email'] ) ) );
$t_matkhau = $_POST['t_matkhau'];
$t_matkhau2 = $_POST['t_matkhau2'];


//
if ( trim( $t_matkhau ) == '' || strlen( $t_matkhau ) < 6 ) {
	_eb_alert( 'Mật khẩu tối thiểu phải có 6 ký tự' );
}
if ( $t_matkhau != $t_matkhau ) {
	_eb_alert( 'Mật khẩu xác nhận không chính xác' );
}


//
if ( _eb_check_email_type ( $user_email ) != 1 ) {
	_eb_alert( 'Email không đúng định dạng' );
}

// tìm theo email
$user_id = email_exists( $user_email );

// có thì trả về luôn
if ( $user_id > 0 ) {
	_eb_alert( 'Email đã được sử dụng' );
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
wp_create_user( $user_name, $t_matkhau, $user_email );




// nếu là quick register -> dừng ở đây là được
if ( isset( $_POST['for_quick_register'] ) ) {
	die('<script type="text/javascript">

parent.document.frm_dk_nhantin.reset();

alert("Đăng ký nhận bản tin thành công");

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
	_eb_alert('Lỗi chưa xác định!');
//	echo $user->get_error_message();
}
//print_r($user);
//___eb_custom_login( $creds );



//
die('<script type="text/javascript">
parent.___eb_custom_login_done();
</script>');

exit();




