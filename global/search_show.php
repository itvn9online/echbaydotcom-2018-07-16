<?php


// cho vào log
_eb_log_search( $current_search_key );

//
$__cf_row ['cf_title'] = 'Kết quả tìm kiếm cho: ' . $current_search_key;

$group_go_to[] = ' <li>' . $__cf_row ['cf_title'] . '</li>';



//
$list_post = '';
$str_page = '';
$class_for_search_page = 'thread-search l19';
$by_post_type = isset($_GET['post_type']) ? trim($_GET['post_type']) : '';
$search_not_found = '';





// v2 -> thay đổi giao diện khung tìm kiếm theo post_type mặc định
if ( $by_post_type == 'post' ) {
	$search_html = __eb_thread_template;
	
	$class_for_search_page = 'fix-li-wit cf thread-list';
}
// Nếu có chọn file thiết kế -> sử dụng nguyên mẫu
/*
if ( $__cf_row['cf_threadsearchnode_include_file'] != '' ) {
	$inc_threadnode = EB_THEME_PLUGIN_INDEX . 'themes/threadnode/' . $__cf_row['cf_threadsearchnode_include_file'];
	
	if ( file_exists($inc_threadnode) ) {
		$arr_for_show_html_file_load[] = '<!-- config HTML: ' . $__cf_row['cf_threadsearchnode_include_file'] . ' -->';
		
		$search_html = file_get_contents( $inc_threadnode, 1 );
		
		// dùng chung thì gán CSS dùng chung luôn (nếu có)
		$arr_for_add_css[ EBE_get_css_for_config_design ( $__cf_row['cf_threadsearchnode_include_file'], '.html' ) ] = 1;
		
		$class_for_search_page = 'thread-list';
	}
	else {
		$search_html = 'File ' . $inc_threadnode . ' not exist';
	}
}
*/
// lấy mặc định -> áp dụng cho blog
else {
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
}




// chức năng tìm kiếm riêng của echbay
if ( $act == 'ebsearch' ) {
	$posts_per_page = _eb_get_option('posts_per_page');
	
	$list_post = _eb_load_post( $posts_per_page, array(
		'post__in' => explode( ',', substr( $strFilter, 1 ) )
	) );
}
// chức năng tìm kiếm của wordpress
else if ( have_posts() ) {
	
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
else {
	// xem có dùng mã tìm kiếm khác không
	$search_not_found = EBE_get_lang('search_addon');
	if ( $search_not_found == '' ) {
		$search_not_found = '<li class="text-center bold" style="padding:90px 0;
		width: 100%;
		margin: 0 auto;
		float: none;">' . EBE_get_lang('search_not_found') . '</li>';
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
$main_content = EBE_html_template( EBE_get_page_template( $show_html_template ), array(
	'tmp.search_not_found' => $search_not_found,
	'tmp.list_post' => $list_post,
	'tmp.str_page' => $str_page,
	'tmp.class_for_search_page' => $class_for_search_page,
) );



