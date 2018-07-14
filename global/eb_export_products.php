<?php



//
//if ( ! current_user_can('delete_posts') || ! isset( $_GET['token'] ) || $_GET['token'] != _eb_mdnam( $_SERVER['HTTP_HOST'] ) ) {
if ( ! isset( $_GET['token'] ) || $_GET['token'] != _eb_mdnam( $_SERVER['HTTP_HOST'] ) ) {
	die('<h1>Permission deny!</h1>');
}



header("Content-type: text/xml");



// test
$limit = 2000;
if ( isset($_GET['test']) ) {
	$limit = 20;
}



//
$export_type = isset( $_GET['export_type'] ) ? $_GET['export_type'] : '';



function WGR_export_product_to_xml ( $limit, $filter = '', $post_type = 'post' ) {
	global $wpdb;
	
	//
	return _eb_q( "SELECT *
	FROM
		`" . wp_posts . "`
	WHERE
		post_type = '" . $post_type . "'
		" . $filter . "
		AND ( post_status = 'publish' OR post_status = 'pending' OR post_status = 'draft' )
	ORDER BY
		ID
	LIMIT 0, " . $limit );
}


//
if ( $export_type == 'facebook'
|| $export_type == 'google' ) {
	$sql = WGR_export_product_to_xml( $limit, " AND post_status = 'publish' " );
//	print_r( $sql );
	
	include EB_THEME_PLUGIN_INDEX . 'global/eb_export_products_facebook.php';
}
else if ( $export_type == 'woo' ) {
	$sql = WGR_export_product_to_xml( $limit, " AND ( post_status = 'publish' OR post_status = 'pending' OR post_status = 'draft' ) ", 'product' );
	
	include EB_THEME_PLUGIN_INDEX . 'global/eb_export_products_woo.php';
}
else {
	$sql = WGR_export_product_to_xml( $limit, " AND ( post_status = 'publish' OR post_status = 'pending' OR post_status = 'draft' ) " );
	
	include EB_THEME_PLUGIN_INDEX . 'global/eb_export_products_default.php';
}





exit();




