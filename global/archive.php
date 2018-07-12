<?php




$list_post = '';

while ( have_posts() ) {
	
	the_post();
//	print_r( $post );
	
	//
	if ( $image_og_image == '' ) {
		$image_og_image = _eb_get_post_img( $post->ID );
	}
	
	//
	$list_post .= EBE_select_thread_list_all( $post );
	
}



//
$html_v2_file = 'thread_list';

// kiểm tra và gắn HTML riêng cho khách hàng
$custom_cats_flex_css = EBE_get_html_file_addon( $html_v2_file, $__cf_row['cf_cats_column_style'] );

//
$arr_main_content = array(
	'tmp.str_for_category_top_sidebar' => _eb_echbay_get_sidebar( 'category_top_content_sidebar' ),
	
	'tmp.custom_cats_li_css' => $__cf_row['cf_cats_num_line'],
	'tmp.custom_cats_flex_css' => $custom_cats_flex_css,
	'tmp.cf_cats_class_style' => $__cf_row ['cf_cats_class_style'],
	
	'tmp.category_content_sidebar' => _eb_echbay_get_sidebar( 'category_content_sidebar' ),
);



//
$str_page = '';
$current_page = max( 1, get_query_var('paged') );
if ( paginate_links() != '' ) {
	$big = 999999999;
	
	if ( $current_page > 1 ) {
		$__cf_row ['cf_title'] .= ' (Trang ' . $current_page . ')';
	}
	
	//
	$str_page = paginate_links( array(
		'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
		'format' => '?paged=%#%',
		'prev_text' => '&laquo;',
		'next_text' => '&raquo;',
		'current' => $current_page,
		'total' => $wp_query->max_num_pages
	) );
}


//
$arr_main_content['tmp.list_post'] = EBE_check_list_post_null( $list_post );

$arr_main_content['tmp.cats_description'] = '';
$arr_main_content['tmp.link_for_fb_comment'] = '';
$arr_main_content['tmp.html_for_fb_comment'] = '';
$arr_main_content['tmp.str_page'] = $str_page;

$archive_title = 'aaaaaaaaaa';
$arr_main_content['tmp.home_cf_title'] = $__cf_row['cf_set_link_for_h1'] == 1 ? '<a href="' . $url_og_url . '" rel="nofollow">' . $archive_title . '</a>' : $archive_title;

//
$main_content = EBE_html_template( EBE_get_page_template( $html_v2_file ), $arr_main_content );





// -> thêm đoạn JS dùng để xác định xem khách đang ở đâu trên web
$main_content .= '<script type="text/javascript">
var current_order="",
seach_advanced_value="",
seach_advanced_by_cats="",
cf_cats_description_viewmore=0,
switch_taxonomy="' . $act . '";
</script>';




