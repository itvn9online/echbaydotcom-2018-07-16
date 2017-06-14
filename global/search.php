<?php


$current_search_key = get_search_query();

$__cf_row ['cf_title'] = 'Kết quả tìm kiếm cho: ' . $current_search_key;

$group_go_to[] = ' <li>' . $__cf_row ['cf_title'] . '</li>';



//
$list_post = '';
$str_page = '';




// sử dụng mẫu giao diện chung nếu không có mẫu riêng
$check_html_rieng = EB_THEME_HTML . 'search.html';
$thu_muc_for_html = EB_THEME_HTML;

// riêng
if ( file_exists($check_html_rieng) ) {
	$check_html_node_rieng = EB_THEME_HTML . 'search_node.html';
	
	// nếu có file thiết kế riêng cho phần html này
	if ( file_exists($check_html_node_rieng) ) {
		$search_html = file_get_contents( $check_html_node_rieng, 1 );
	}
	// không có -> lấy mặc định theo sản phẩm
	else {
		$search_html = __eb_thread_template;
	}
}
// chung
else {
	$thu_muc_for_html = EB_THEME_PLUGIN_INDEX . 'html/';
	
	$search_html = file_get_contents( $thu_muc_for_html . 'search_node.html', 1 );
}



//
if ( have_posts() ) {
	
	//
	if ( paginate_links() != '' ) {
//		global $wp_query;
		$big = 999999999;
		
		$current_page = max( 1, get_query_var('paged') );
//		echo $current_page;
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
		
//		echo $part_page;
	}
	
	
	
	//
	while ( have_posts() ) {
		
		the_post();
		
		$list_post .= EBE_select_thread_list_all( $post, $search_html );
		
	}
}


//
/*
$main_content = EBE_str_template( 'search.html', array(
	'tmp.list_post' => $list_post,
	'tmp.str_page' => $str_page,
), $thu_muc_for_html );
*/

//
$main_content = EBE_html_template( EBE_get_page_template( $act ), array(
	'tmp.list_post' => $list_post,
	'tmp.str_page' => $str_page,
) );



