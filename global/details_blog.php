<?php




$eb_blog_2content = _eb_get_post_object( $pid, '_eb_blog_2content' );
if ( $eb_blog_2content != '' ) {
	$eb_blog_2content = '<div class="blog-details-2content">' . $eb_blog_2content . '</div>';
}

// tag of blog
$arr_list_tag = wp_get_object_terms( $pid, 'blog_tag' );



// thêm H2 cho phần blog
if ( $__post->post_excerpt != '' ) {
	$__post->post_excerpt = '<' . EBE_get_lang('tag_blog_excerpt') . ' class="echbay-tintuc-gioithieu">' . nl2br( trim( $__post->post_excerpt ) ) . '</' . EBE_get_lang('tag_blog_excerpt') . '>';
}



// bài xem nhiều
$args = array(
	'post_type' => EB_BLOG_POST_TYPE,
	'offset' => 0,
	'tax_query' => array(
		array(
			'taxonomy' => EB_BLOG_POST_LINK,
			'terms' => $ant_id,
		)
	),
	'post__not_in' => array(
		$__post->ID
	)
);


//
$html_v2_file = 'blog_details';
//	$html_file = $html_v2_file . '.html';


// nếu không tồn tại file thiết kế riêng -> kiểm tra file HTML mẫu
//	if ( ! file_exists( EB_THEME_HTML . $html_file ) ) {
	if ( $__cf_row['cf_blog_column_style'] != '' ) {
//			$html_v2_file = $html_v2_file . '_' . $__cf_row['cf_blog_column_style'];
		
		$custom_product_flex_css = EBE_get_html_file_addon( $html_v2_file, $__cf_row['cf_blog_column_style'] );
	}
//	}
//	echo $__cf_row['cf_blog_column_style'] . '<br>' . "\n";
//	echo $html_v2_file . '<br>' . "\n";


// kiểm tra nếu có file html riêng -> sử dụng html riêng
//	$check_html_rieng = _eb_get_private_html( $html_file, 'blog_node.html' );

//	$thu_muc_for_html = $check_html_rieng['dir'];
//	$blog_html_small_node = $check_html_rieng['html'];

//
//	$blog_list_medium = _eb_load_post( 10, $args, _eb_get_html_for_module( 'blog_node.html' ) );

//
//	$blog_list_medium = _eb_load_post( 10, $args, EBE_get_page_template( 'blog_node' ) );
//	$custom_blog_node_flex_css = EBE_get_html_file_addon( 'blog_node', $__cf_row['cf_blog_node_html'] );

//
if ( $__cf_row['cf_num_details_blog_list'] > 0 ) {
	$blog_list_medium = _eb_load_post( $__cf_row['cf_num_details_blog_list'], $args, EBE_get_page_template( 'blogs_node' ) );
}
$custom_blog_node_flex_css = EBE_get_html_file_addon( 'blogs_node', $__cf_row['cf_blog_node_html'] );

//
$str_for_details_sidebar = _eb_echbay_get_sidebar( 'blog_content_details_sidebar' );



