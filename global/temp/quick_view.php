<?php


//
if ( ! isset( $_GET['id'] ) ) {
	die('Product ID not found!');
}

//
$quick_view_id = (int) $_GET['id'];



//
$sql = _eb_load_post_obj( 1, array(
	'p' => $quick_view_id
) );
//print_r( $sql );
//$GLOBALS['wp_query'] = $sql;
//print_r( $GLOBALS );

//
/*
$post = _eb_q("SELECT *
	FROM
		`" . $wpdb->posts . "`
	WHERE
		ID = " . $quick_view_id);
//print_r( $post );
$post = $post[0];
$posts = $post;
*/

//
while ( $sql->have_posts() ) {
	$sql->the_post();
	
	//
//	print_r( $post );
	$post = $sql->post;
//	print_r( $post );
	
	//
//	print_r( $posts );
	$posts = $sql->posts;
//	print_r( $posts );
	
	// reset lại mảng css -> chỉ nạp cho trang chi tiết thôi
	$arr_for_add_css = array();
	
	//
	include EB_THEME_PLUGIN_INDEX . 'global/details.php';
	include EB_THEME_PLUGIN_INDEX . 'common_content.php';
	
	// nạp css
//	print_r( $arr_for_add_css );
	_eb_add_compiler_css( $arr_for_add_css );
	
	
	//
	echo $main_content;
	
}




