<?php


/*
* đây là file được include thông qua function -> các biến bên ngoài muốn sử dụng trong này đều phải global
* Về cơ bản, đây chính là trang admin riêng của Ếch Bay
*/



//global $func;
//global $wpdb;
global $__cf_row;





//$results = _eb_q( 'SELECT * FROM wp_options' );
//print_r( $results );
//print_r( $_GET );


//
if ( ! isset( $_GET['page'] ) || $_GET['page'] == '' ) {
	WGR_parameter_not_found(__FILE__);
}


//
$include_page = trim( $_GET['page'] );
//echo $include_page . '<br>';
$include_page = str_replace( 'eb-', '', $include_page );
$include_page = str_replace( '-', '_', $include_page );
//echo $include_page . '<br>';

$include_file = ECHBAY_PRI_CODE . $include_page . '.php';
//echo $include_file . '<br>';
//echo $include_page . '<br>';




// nếu không có file -> module lỗi -> hủy bỏ
if ( ! file_exists( $include_file ) ) {
	die('Module <strong>' . $include_page . '</strong> not found');
}



//
$main_content = '';



//
echo '<div id="rAdminME">';



//
include_once $include_file;





// một số tham số dùng chung
$admin_dynamic_uri = explode( '/', EB_URL_OF_PLUGIN );
$admin_dynamic_uri[2] = $_SERVER['HTTP_HOST'];
$admin_dynamic_uri = implode( '/', $admin_dynamic_uri );

$web_dynamic_url = explode( '/', web_link );
$web_dynamic_url[2] = $_SERVER['HTTP_HOST'];
$web_dynamic_url = implode( '/', $web_dynamic_url );

$main_content = str_replace( '{tmp.admin_css_uri}', $admin_dynamic_uri . 'css/', $main_content );
$main_content = str_replace( '{tmp.admin_js_uri}', $admin_dynamic_uri . 'echbay/js/', $main_content );
//$main_content = str_replace( '{tmp.web_version}', web_version, $main_content );
$main_content = str_replace( '{tmp.web_version}', date_time, $main_content );
$main_content = str_replace( '{tmp.web_link}', $web_dynamic_url, $main_content );
$main_content = str_replace( '{tmp.web_link}', web_link, $main_content );

//

echo $main_content;

echo '</div>';



// thêm iframe để update dữ liệu không cần tải lại trang
//echo '<iframe id="target_eb_iframe" name="target_eb_iframe" src="about:blank" width="99%" height="600">AJAX form</iframe>';



