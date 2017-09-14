<?php


//
$gio_vang_list = _eb_load_post( $__cf_row['cf_num_home_hot'], array(
	'meta_key' => '_eb_product_status',
	'meta_value' => 6
) );


//
$__cf_row ['cf_title'] = EBE_get_lang('golden_time');
$__cf_row ['cf_keywords'] = $__cf_row ['cf_title'];
$__cf_row ['cf_description'] = EBE_get_lang('golden_desc_time');


//
$url_og_url = web_link . $act;
$schema_BreadcrumbList[$url_og_url] = _eb_create_breadcrumb( $url_og_url, 'Giờ vàng' );
$dynamic_meta .= '<link rel="canonical" href="' . $url_og_url . '" />';


//
if ( $gio_vang_list != '' ) {
	//
//	echo $gio_vang_list;
	
	// Lấy theo mẫu của widget #home_hot
	$main_content = EBE_html_template( EBE_get_page_template( 'home_hot' ), array(
//		'tmp.custom_blog_css' => $__cf_row['cf_blog_class_style'],
//		'tmp.max_width' => '',
		'tmp.num_post_line' => '',
		'tmp.home_hot_title' => EBE_get_lang('golden_time'),
		'tmp.description' => '',
		'tmp.home_hot' => $gio_vang_list
	) );
	
	
	//
	$main_content = '<div class="golden_time-page">' . $main_content . '</div>';
}
else {
	include EB_THEME_PLUGIN_INDEX . 'global/content-none.php';
}




