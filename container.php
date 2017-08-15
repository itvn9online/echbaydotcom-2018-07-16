<?php



// file main mặc định
if ( $__cf_row['cf_main_include_file'] == '' ) {
	include EB_THEME_PLUGIN_INDEX . 'themes/main/echbaytwo-main.php';
}
// file main theo lựa chọn của khách
else {
	include EB_THEME_PLUGIN_INDEX . 'themes/main/' . $__cf_row['cf_main_include_file'];
}




