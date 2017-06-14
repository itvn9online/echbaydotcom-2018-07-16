<?php


//
/*
if ( ! is_admin() ) {
	exit();
}
*/

// nếu tài khoản có quyền admin -> cho xem dữ liệu
if ( current_user_can( 'manage_options' ) ) {
	phpinfo();
}




//
exit();



