<?php





/*
* Đây là file chứa các function của website như booking và một số chức năng của admin
*/
//print_r( $_GET );
//print_r( $_POST );




// tham số không thể thiếu
if ( ! isset( $_GET['set_module'] ) || $_GET['set_module'] == '' ) {
	WGR_parameter_not_found(__FILE__);
}



// kiểm tra an toàn dữ liệu -> chỉ chấp nhận phương thức POST
$_POST = _eb_checkPostServerClient ();
//print_r( $_POST );



//
$module_name = trim( $_GET['set_module'] );
//echo $module_name . '<br>';
$module_name = str_replace( 'eb-', '', $module_name );
$module_name = str_replace( '-', '_', $module_name );
//echo $module_name . '<br>';



// chuyển file sang chế độ function
$submit_admin_file = ECHBAY_PRI_CODE . 'func/' .$module_name . '.php';
//echo $submit_admin_file . '<br>';

$submit_guest_file = EB_THEME_URL . 'func/' .$module_name . '.php';
//echo $submit_guest_file . '<br>';





// nếu xuất hiện cả 2 nơi -> lỗi luôn
if ( file_exists( $submit_guest_file ) && file_exists( $submit_admin_file ) ) {
	_eb_alert('WARNING! module toooooooo');
}
// dành cho khách hàng
else if ( file_exists( $submit_guest_file ) ) {
	include_once $submit_guest_file;
}
// dành cho admin
else if ( file_exists( $submit_admin_file ) ) {
	include_once $submit_admin_file;
}
// nếu không module nào được tìm thấy -> lỗi
else {
	_eb_alert('Module not found (process)');
}

//
//_eb_alert('Test');



//
exit();




