<?php




// tham số không thể thiếu
if ( ! isset( $_GET['set_module'] ) || $_GET['set_module'] == '' ) {
	WGR_parameter_not_found(__FILE__);
}



//
if ($_SERVER ['REQUEST_METHOD'] == 'POST') {
	$_POST = _eb_checkPostServerClient ();
}



//
$module_name = trim( $_GET['set_module'] );



// chuyển file sang chế độ function
$submit_admin_file = EB_THEME_PLUGIN_INDEX . 'global/temp/' .$module_name . '.php';
//echo $submit_admin_file . '<br>';




//
include_once $submit_admin_file;





exit();





