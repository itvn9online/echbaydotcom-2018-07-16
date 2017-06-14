<?php
/*
* Mọi code dùng chung cho trang danh sách sản phẩm/ bài viết
*/



//print_r($_GET);





//
//$search = array($_SERVER['QUERY_STRING'], '?');
//$replace = array('', '');
//$currentUrl = str_replace($search, $replace, $_SERVER['REQUEST_URI']);
//echo $currentUrl;
//print_r($_GET);



//
$category = get_queried_object();
//print_r( $category );





//
$switch_taxonomy = isset( $category->taxonomy ) ? $category->taxonomy : '';



//
$id_for_get_sidebar = 'category_sidebar';



// Chỉ nhận bài viết với định dạng được hỗ trợ
if ( $switch_taxonomy != '' ) {
	
	
	
	
	
	// không index trong 1 số trường hợp
	if ( $switch_taxonomy == 'post_options' ) {
		$__cf_row ["cf_blog_public"] = 0;
	}
	
	
	//
	$cid = $category->term_id;
	
	
	
	// SEO
	$__cf_row ['cf_title'] = _eb_get_post_meta( $category->term_id, '_eb_category_title', true, $category->name );
//	if ( $__cf_row ['cf_title'] == '' ) $__cf_row ['cf_title'] = $category->name;
	
	$__cf_row ['cf_keywords'] = _eb_get_post_meta( $category->term_id, '_eb_category_keywords', true, $category->name );
//	if ( $__cf_row ['cf_keywords'] == '' ) $__cf_row ['cf_keywords'] = $category->name;
	
	$__cf_row ['cf_description'] = _eb_get_post_meta( $category->term_id, '_eb_category_description', true, $category->description );
//	if ( $__cf_row ['cf_description'] == '' ) $__cf_row ['cf_description'] = $category->description;
	if ( $__cf_row ['cf_description'] == '' ) $__cf_row ['cf_description'] = $category->name;
	
	
	
	
	
	
	//
//	$__cf_row ['cf_title'] = $category->name;
	
	$group_go_to .= ' <li>' . $category->name . '</li>';
	
	// tìm nhóm cha (nếu có)
	$parent_parent_cat = _eb_create_html_breadcrumb( $category );
//	echo $parent_parent_cat . '<br>' . "\n";
	
	// -> tạo menu từ nhóm cha hiện tại
	$current_category_menu = _eb_echbay_category_menu( $parent_parent_cat, $category->taxonomy );
//	echo $current_category_menu;
	
	//
	$url_og_url = _eb_c_link( $category->term_id );
	
	//
	_eb_fix_url( $url_og_url );
	
	//
	$link_for_fb_comment = web_link . '?cat=' . $category->term_id;
	
	$dynamic_meta .= '<link rel="canonical" href="' . $url_og_url . '" />';
	$dynamic_meta .= '<link rel="shortlink" href="' . $link_for_fb_comment . '" />';
	
	$schema_BreadcrumbList .= _eb_create_breadcrumb( $url_og_url, $category->name );
	
	
	
	
	// mod
//	$eb_new_query = array();
	
	// nếu có thuộc tính sắp xếp
	$current_order = isset ( $_GET ['orderby'] ) ? trim ( strtolower( $_GET ['orderby'] ) ) : '';
	
	//
	$tim_nang_cao = isset ( $_GET ['filter'] ) ? trim ( strtolower( $_GET ['filter'] ) ) : '';
	
	
	
//
$current_page = max( 1, get_query_var('paged') );
/*
$strCacheFilter = 'list' . $category->term_id . '-' . $current_page . '-' . $current_order . '-' . str_replace( ',', '', $tim_nang_cao );
//echo $strCacheFilter;
$main_content = _eb_get_static_html ( $strCacheFilter );
if ( $main_content == false ) {
	*/
	
	//
	$list_post = '';
	
	//
	if ( have_posts() ) {
		
		//
		$str_page = '';
		if ( paginate_links() != '' ) {
//			global $wp_query;
			$big = 999999999;
			
//			echo $current_page;
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
		
		
		
		
		
		
		
		/*
		* phiên bản amp
		*/
		if ( isset($_GET['amp']) ) {
			if ( $switch_taxonomy == EB_BLOG_POST_LINK || $switch_taxonomy == 'category' ) {
				
				// xác định tệp cho việc tạo amp
				$_GET['amp_act'] = 'list';
				
				//
				include EB_THEME_PLUGIN_INDEX . 'amp.php';
			}
		}
		
		//
		$dynamic_meta .= '<link rel="amphtml" href="' . $url_og_url . '?amp" />';
		
		
		
		
		
		
		
		
		
		//
		$arr_main_content = array();
//		$tep_tin_for_html = 'thread_list.html';
		$html_v2_file = 'thread_list';
		$thu_muc_for_html = EB_THEME_HTML;
		
		
		
		// product
		if ( $switch_taxonomy == 'category'
		|| $switch_taxonomy == 'post_tag'
		|| $switch_taxonomy == 'post_options' ) {
			while ( have_posts() ) {
				
				the_post();
//				print_r( $post );
				
				$list_post .= EBE_select_thread_list_all( $post );
				
			}

			
			
			//
			$arr_main_content = array(
				'tmp.home_cf_title' => $category->name,
				'tmp.link_for_fb_comment' => $link_for_fb_comment,
				'tmp.list_post' => $list_post,
				'tmp.str_page' => $str_page,
			);
			
		}
		// blog
		else if ( $switch_taxonomy == EB_BLOG_POST_LINK
		|| $switch_taxonomy == 'blog_tag' ) {
			
			
			//
			$id_for_get_sidebar = 'blog_sidebar';
			
			
			
			// kiểm tra nếu có file html riêng -> sử dụng html riêng
			/*
			$check_html_rieng = _eb_get_private_html( 'blog.html', 'blog_node.html' );
			
			$thu_muc_for_html = $check_html_rieng['dir'];
			$blog_html_node = $check_html_rieng['html'];
			*/
			
			//
			$get_blog_html_node = 'blogs_node';
//			echo $__cf_row['cf_blogs_node_html'] . '<br>' . "\n";
//			echo EB_THEME_HTML . $get_blog_html_node . '<br>' . "\n";
			
			// ưu tiên sử dụng file thiết kế riêng theo theme
			if ( file_exists( EB_THEME_HTML . $get_blog_html_node . '.html' ) ) {
				$blog_html_node = file_get_contents( EB_THEME_HTML . $get_blog_html_node . '.html', 1 );
			}
			// nếu không tồn tại file thiết kế riêng -> kiểm tra file HTML mẫu
			else {
				
				// gán css dùng chung
				if ( file_exists( EB_THEME_PLUGIN_INDEX . 'css/default/' . $get_blog_html_node . '.css' ) ) {
					$arr_for_add_css[ EB_THEME_PLUGIN_INDEX . 'css/default/' . $get_blog_html_node . '.css' ] = 1;
				}
				
				// lấy HTML tương ứng
				if ( $__cf_row['cf_blogs_node_html'] != '' ) {
					$get_blog_html_node .= '_' . $__cf_row['cf_blogs_node_html'];
				}
				$get_blog_html_node = EB_THEME_PLUGIN_INDEX . 'html/' . $get_blog_html_node . '.html';
//				echo $get_blog_html_node . '<br>' . "\n";
				
				//
				$blog_html_node = file_get_contents( $get_blog_html_node, 1 );
			}
			
			
			
			
			//
			while ( have_posts() ) {
				
				the_post();
//				print_r( $post );
				
				$list_post .= EBE_select_thread_list_all( $post, $blog_html_node, EB_BLOG_POST_LINK );
				
			}
			
			
			//
			$arr_main_content = array(
				'tmp.home_cf_title' => $category->name,
				'tmp.link_for_fb_comment' => $link_for_fb_comment,
				'tmp.list_post' => $list_post,
				'tmp.str_page' => $str_page,
				
				// css định dạng chiều rộng cho phần danh sách blog
//				'tmp.custom_blog_css' => $__cf_row['cf_blog_class_style'],
				// css định dạng số cột trên mỗi hàng
//				'tmp.custom_blog_li_css' => $__cf_row['cf_blogs_num_line'],
			);
			
			//
			$html_v2_file = 'blogs';
			$tep_tin_for_html = $html_v2_file . '.html';
			
			// nếu không tồn tại file thiết kế riêng -> kiểm tra file HTML mẫu
//			if ( ! file_exists( EB_THEME_HTML . $tep_tin_for_html ) ) {
				if ( $__cf_row['cf_blogs_column_style'] != '' ) {
					$html_v2_file = $html_v2_file . '_' . $__cf_row['cf_blogs_column_style'];
				}
//			}
//			echo $__cf_row['cf_blogs_column_style'] . '<br>' . "\n";
//			echo $html_v2_file . '<br>' . "\n";
			
		}
		// error
		else {
			include EB_THEME_PHP . '404.php';
		}
		
		// tìm và tạo sidebar luôn
//		$arr_main_content['tmp.str_sidebar'] = _eb_echbay_sidebar( $id_for_get_sidebar );
		
		
		
		
		// gọi đến function riêng của từng site
		if ( function_exists('eb_list_for_current_domain') ) {
			$arr_main_new_content = eb_list_for_current_domain();
			
			// -> chạy vòng lặp, ghi đè lên mảng cũ
			foreach ( $arr_main_new_content as $k => $v ) {
				$arr_main_content[$k] = $v;
			}
		}
		
		
		// v1
//		$main_content = EBE_str_template( $tep_tin_for_html, $arr_main_content, $thu_muc_for_html );
		
		// v2
		$main_content = EBE_html_template( EBE_get_page_template( $html_v2_file ), $arr_main_content );
		
	}
	else {
		include EB_THEME_PLUGIN_INDEX . 'global/content-none.php';
	}
	
	
	
	
	//
	/*
	_eb_get_static_html ( $strCacheFilter, $main_content );
	
} // end cache
*/



/*
$main_content = str_replace ( '{tmp.js}', 'var current_order="' . $current_order . '";', $main_content );
//$main_content = str_replace ( '{tmp.currentUrl}', $currentUrl, $main_content );





//
if ( $switch_taxonomy == 'category'
|| $switch_taxonomy == 'post_tag'
|| $switch_taxonomy == 'post_options' ) {
	// gọi file js dùng chung trước
	$arr_for_add_js[] = 'javascript/list_wp.js';
	
	// sau đó gọi file js riêng của từng domain
	$arr_for_add_js[] = 'list.js';
}
else if ( $switch_taxonomy == EB_BLOG_POST_LINK
|| $switch_taxonomy == 'blog_tag' ) {
	// gọi file js dùng chung trước
	$arr_for_add_js[] = 'javascript/blog_wp.js';
	
	// sau đó gọi file js riêng của từng domain
	$arr_for_add_js[] = 'blog.js';
}
*/





// -> thêm đoạn JS dùng để xác định xem khách đang ở đâu trên web
$main_content .= '<script type="text/javascript">
var current_order="' . $current_order . '",
	seach_advenced_value="' . $tim_nang_cao . '";
	switch_taxonomy="' . $switch_taxonomy . '";
</script>';





}
// nếu người dùng sử dụng taxonomy riêng -> include taxonomy này vào
else if ( file_exists( EB_THEME_PHP . 'archive-' . $switch_taxonomy . '.php' ) ) {
	
	// nếu sử dụng giao diện riêng -> người dùng tự exist chứ mình mặc định là không exist
	include EB_THEME_PHP . 'archive-' . $switch_taxonomy . '.php';
	
}
// không thì in ra file 404 thôi
else {
	include EB_THEME_PHP . '404.php';
}




// loại bỏ chức năng bỏ qua sản phẩm đã lấy, để custom code còn hoạt động được
$___eb_post__not_in = '';




