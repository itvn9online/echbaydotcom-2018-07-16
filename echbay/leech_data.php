<?php







/*
$a = wp_list_categories( array(
	'hide_empty' => 0,
	'echo' => 0,
	'style' => '<br>',
	'taxonomy' => 'category',
) );
print_r( $a );
*/

//
//$list_cat = _eb_categories_list_v3();
//echo $list_cat;




//
/*
global $wpdb;

$sql = _eb_q ( "SELECT option_value
	FROM
		`" . $wpdb->options . "`
	WHERE
		option_name = '___eld___cookie_by_domain'
	ORDER BY
		option_id DESC
	LIMIT 0, 1" );
//print_r( $sql );
$str_for_save_domain_config = '';
if ( count( $sql ) > 0 ) {
	$str_for_save_domain_config = $sql[0]->option_value;
}
*/

//
$str_for_save_list_category = _eb_get_option( '___eld___list_category' );
$str_for_save_domain_config = _eb_get_option( '___eld___cookie_by_domain' );




// chỉ coder mới được xem thông tin này
$main_content = EBE_str_template( 'html/leech_data.html', array(
	'tmp.js' => 'var arr_for_save_domain_config = "' . $str_for_save_domain_config . '";',
	'tmp.str_for_save_list_category' => $str_for_save_list_category,
	'tmp.list_cat' => _eb_categories_list_v3(),
	'tmp.list_blog_cat' => _eb_categories_list_v3( 't_blog_ant', EB_BLOG_POST_LINK ),
	'tmp.media_version' => time(),
), ECHBAY_PRI_CODE );



