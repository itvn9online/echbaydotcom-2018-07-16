<?php




//
$str_for_category_top_sidebar = '';
	
	
	
	
	// không index trong 1 số trường hợp
	if ( $switch_taxonomy == 'post_options' && $__cf_row['cf_alow_post_option_index'] != 1 ) {
		$__cf_row ["cf_blog_public"] = 0;
	}
	else if ( isset( $_GET['search_advanced'] ) || _eb_get_cat_object( $cid, '_eb_category_noindex', 0 ) == 1 ) {
		$__cf_row ["cf_blog_public"] = 0;
	}
	
	
	
	
	// Chỉ lấy banner riêng khi chế độ global không được kích hoạt
	if ( $__cf_row['cf_global_big_banner'] != 1 ) {
		/*
		$arr_select_by_taxonomy = array(
			'taxonomy' => $switch_taxonomy,
		);
		echo '<!-- ';
		print_r( $arr_select_by_taxonomy );
		echo ' -->';
		*/
		
		if ( $switch_taxonomy == 'post_options'
		|| $switch_taxonomy == EB_BLOG_POST_LINK ) {
			$str_big_banner = EBE_get_big_banner( EBE_get_lang('bigbanner_num'), array(
				'tax_query' => array(
					array (
						'taxonomy' => $switch_taxonomy,
						'field' => 'term_id',
						'terms' => $cid,
						'operator' => 'IN'
					)
				)
			) );
//			echo $str_big_banner;
		}
		// lấy theo taxonomy mặc định
		else if ( $switch_taxonomy == 'category' ) {
			$str_big_banner = EBE_get_big_banner( EBE_get_lang('bigbanner_num'), array(
				'category__in' => array( $cid )
			) );
		}
	}
	
	
	
	// SEO
	if ( cf_on_off_echbay_seo == 1 ) {
		$__cf_row ['cf_title'] = _eb_get_cat_object( $__category->term_id, '_eb_category_title', $__category->name );
//		if ( $__cf_row ['cf_title'] == '' ) $__cf_row ['cf_title'] = $__category->name;
		
		$__cf_row ['cf_keywords'] = _eb_get_cat_object( $__category->term_id, '_eb_category_keywords', $__category->name );
//		if ( $__cf_row ['cf_keywords'] == '' ) $__cf_row ['cf_keywords'] = $__category->name;
		
		$__cf_row ['cf_description'] = _eb_get_cat_object( $__category->term_id, '_eb_category_description', $__category->description );
//		echo 1;
//		if ( $__cf_row ['cf_description'] == '' ) $__cf_row ['cf_description'] = $__category->description;
		if ( $__cf_row ['cf_description'] == '' ) {
			$__cf_row ['cf_description'] = $__category->name;
		}
		else {
			$__cf_row ['cf_description'] = strip_tags( $__cf_row ['cf_description'] );
		}
	}
	
	
	
	
	
	
	//
//	$__cf_row ['cf_title'] = $__category->name;
	
//	$group_go_to[] = ' <li>' . $__category->name . '</li>';
	
	// tìm nhóm cha (nếu có)
	$parent_parent_cat = _eb_create_html_breadcrumb( $__category );
	$parent_cid = $parent_parent_cat;
//	echo $parent_parent_cat . '<br>' . "\n";
	
	// -> tạo menu từ nhóm cha hiện tại
	$current_category_menu = _eb_echbay_category_menu( $parent_parent_cat, $__category->taxonomy );
//	echo $current_category_menu;
	
	//
	$url_og_url = _eb_c_link( $__category->term_id, $__category->taxonomy );
	
	// Mặc định là trang sản phẩm
	$web_og_type = 'product';
	// Nếu là tin tức thì báo là tin tức
	if ( $__category->taxonomy == EB_BLOG_POST_LINK || $__cf_row['cf_set_news_version'] == 1 ) {
		$web_og_type = 'blog';
	}
	
	//
	_eb_fix_url( $url_og_url );
	
	//
	if ( $__category->taxonomy == 'category' ) {
		$link_for_fb_comment = web_link . '?cat=' . $__category->term_id;
	} else {
		$link_for_fb_comment = web_link . '?taxonomy=' . $__category->taxonomy . '&cat=' . $__category->term_id;
	}
//	$link_for_fb_comment = wp_get_shortlink();
//	the_shortlink();
	
	$dynamic_meta .= '<link rel="canonical" href="' . $url_og_url . '" />';
	$dynamic_meta .= '<link rel="shortlink" href="' . $link_for_fb_comment . '" />';
	
	$schema_BreadcrumbList[$url_og_url] = _eb_create_breadcrumb( $url_og_url, $__category->name, $__category->term_id );
	
	
	
	
	// mod
//	$eb_new_query = array();
	
	// nếu có thuộc tính sắp xếp
	$current_order = isset ( $_GET ['orderby'] ) ? trim ( strtolower( $_GET ['orderby'] ) ) : '';
	
	//
	$tim_nang_cao = isset ( $_GET ['filter'] ) ? trim ( strtolower( $_GET ['filter'] ) ) : '';
	
	//
	$seach_advanced_by_cats = isset ( $_GET ['filter_cats'] ) ? trim ( strtolower( $_GET ['filter_cats'] ) ) : '';
	
	
	
//
$current_page = max( 1, get_query_var('paged') );
/*
$strCacheFilter = 'list' . $__category->term_id . '-' . $current_page . '-' . $current_order . '-' . str_replace( ',', '', $tim_nang_cao );
//echo $strCacheFilter;
$main_content = _eb_get_static_html ( $strCacheFilter );
if ( $main_content == false ) {
	*/
	
	//
	$list_post = '';
	
	//
//	if ( have_posts() ) {
		
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
			if ( ( $switch_taxonomy == EB_BLOG_POST_LINK && $__cf_row['cf_on_off_amp_blogs'] == 1 )
			|| ( $switch_taxonomy == 'category' && $__cf_row['cf_on_off_amp_category'] == 1 ) ) {
				
				// xác định tệp cho việc tạo amp
				$_GET['amp_act'] = 'list';
				
				//
				include EB_THEME_PLUGIN_INDEX . 'amp.php';
			}
		}
		else if ( ( $switch_taxonomy == EB_BLOG_POST_LINK && $__cf_row['cf_on_off_amp_blogs'] == 1 )
		|| ( $switch_taxonomy == 'category' && $__cf_row['cf_on_off_amp_category'] == 1 ) ) {
			$amphtml = $url_og_url;
			
			// tạo url phân trang nếu khách đang xem trang thứ 2 trở đi
			if ( $current_page > 1 ) {
				// bỏ dấu / ở cuối
				if ( substr( $amphtml, strlen( $amphtml ) - 1 ) == '/' ) {
					$amphtml = substr( $amphtml, 0, strlen( $amphtml ) - 1 );
				}
				$amphtml .= '/page/' . $current_page . '/';
			}
			
			$global_dymanic_meta .= '<link rel="amphtml" href="' . $amphtml . '?amp" />';
		}
		
		
		
		
		
		// Lấy nội dung danh mục -> sử dụng module SEO của EchBay
		if ( cf_on_off_echbay_seo == 1 ) {
			$cats_description = _eb_get_cat_object( $__category->term_id, '_eb_category_content' );
			if ( $cats_description == '' ) {
//				$cats_description = $__category->description;
				// mặc định thì EchBay không hỗ trợ HTML -> thêm BR vào description
				$cats_description = nl2br( $__category->description );
			}
			else {
				$cats_description = '<div class="each-to-fix-ptags">' . $cats_description . '</div>';
			}
		}
		// các ứng dụng seo khác -> ưu tiên sử dụng description mặc định
		else if ( $__category->description != '' ) {
			// Với plugin khác như Yoast SEO, description được hỗ trợ HTML sẵn -> dùng luôn thôi
			$cats_description = '<div class="each-to-fix-ptags">' . $__category->description . '</div>';
//			$cats_description = nl2br( $__category->description );
		}
		// còn lại, thử kiểm tra xem trước có dùng plugin seo của EchBay không
		else {
			$cats_description = _eb_get_cat_object( $__category->term_id, '_eb_category_content' );
			
			// cập nhật description -> có thể trước đó khách chuyển từ plugin SEO mặc định sang Yoast SEO
			if ( $cats_description != '' ) {
			}
		}
		
		
		
		
		
		
		
		
		
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
				
				//
				if ( $image_og_image == '' ) {
					$image_og_image = _eb_get_post_img( $post->ID );
				}
				
				//
				$list_post .= EBE_select_thread_list_all( $post );
				
			}
			
			
			// kiểm tra và gắn HTML riêng cho khách hàng
//			$html_v2_file = EBE_get_html_file_addon( $html_v2_file, $__cf_row['cf_cats_column_style'] );
			$custom_cats_flex_css = EBE_get_html_file_addon( $html_v2_file, $__cf_row['cf_cats_column_style'] );
			
			
			
			
			//
			$arr_main_content = array(
				'tmp.str_for_category_top_sidebar' => _eb_echbay_get_sidebar( 'category_top_content_sidebar' ),
//				'tmp.home_cf_title' => $__category->name,
				'tmp.cats_description' => $cats_description,
//				'tmp.link_for_fb_comment' => $link_for_fb_comment,
//				'tmp.list_post' => EBE_check_list_post_null( $list_post ),
//				'tmp.str_page' => $str_page,
				
				'tmp.custom_cats_li_css' => $__cf_row['cf_cats_num_line'],
				'tmp.custom_cats_flex_css' => $custom_cats_flex_css,
				'tmp.cf_cats_class_style' => $__cf_row ['cf_cats_class_style'],
				
				'tmp.category_content_sidebar' => _eb_echbay_get_sidebar( 'category_content_sidebar' ),
			);
			
		}
		// blog
		else if ( $switch_taxonomy == EB_BLOG_POST_LINK
		|| $switch_taxonomy == 'blog_tag' ) {
			
			
			// Nếu config không tạo menu -> không load sidebar
			if ( $__cf_row['cf_blogs_column_style'] == '' ) {
				$id_for_get_sidebar = '';
			} else {
				$id_for_get_sidebar = 'blog_sidebar';
			}
			
			
			
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
			
			// định dạng cột cho blog
			$custom_blogs_node_flex_css = '';
			
			// ưu tiên sử dụng file thiết kế riêng theo theme
			if ( file_exists( EB_THEME_HTML . $get_blog_html_node . '.html' ) ) {
				$blog_html_node = file_get_contents( EB_THEME_HTML . $get_blog_html_node . '.html', 1 );
			}
			// nếu không tồn tại file thiết kế riêng -> kiểm tra file HTML mẫu
			else {
				
				// gán css dùng chung
				if ( file_exists( EB_THEME_PLUGIN_INDEX . 'css/default/' . $get_blog_html_node . '.css' ) ) {
					$arr_for_add_css[ EB_THEME_PLUGIN_INDEX . 'css/default/' . $get_blog_html_node . '.css' ] = 1;
//					$arr_for_add_theme_css[ EB_THEME_PLUGIN_INDEX . 'css/default/' . $get_blog_html_node . '.css' ] = 1;
				}
				
				// lấy HTML tương ứng
				if ( $__cf_row['cf_blogs_node_html'] != '' ) {
//					$get_blog_html_node .= '_' . $__cf_row['cf_blogs_node_html'];
					$custom_blogs_node_flex_css = $get_blog_html_node . '_' . $__cf_row['cf_blogs_node_html'];
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
				
				//
				if ( $image_og_image == '' ) {
					$image_og_image = _eb_get_post_img( $post->ID );
				}
				
				//
				$list_post .= EBE_select_thread_list_all( $post, $blog_html_node, EB_BLOG_POST_LINK );
				
			}
			
			//
			$html_v2_file = 'blogs';
			$tep_tin_for_html = $html_v2_file . '.html';
			
			// kiểu định dạng blogs
			$custom_blogs_flex_css = '';
			
			// nếu không tồn tại file thiết kế riêng -> kiểm tra file HTML mẫu
//			if ( ! file_exists( EB_THEME_HTML . $tep_tin_for_html ) ) {
				if ( $__cf_row['cf_blogs_column_style'] != '' ) {
//					$html_v2_file = $html_v2_file . '_' . $__cf_row['cf_blogs_column_style'];
					$custom_blogs_flex_css = $html_v2_file . '_' . $__cf_row['cf_blogs_column_style'];
				}
//			}
//			echo $__cf_row['cf_blogs_column_style'] . '<br>' . "\n";
//			echo $html_v2_file . '<br>' . "\n";
			
			//
//			$cats_bottom_description = '';
			if ( $__cf_row['cf_blogs_content_bottom'] == 1 ) {
//				$cats_bottom_description = $cats_description;
//				$cats_description = '';
				
				// lật ngược nội dung trong mục blog
				$__cf_row['cf_default_css'] .= '.private-blogs-reverse-content{display: -webkit-flex;display: flex;flex-direction: column-reverse}';
			}
			
			//
			$arr_main_content = array(
//				'tmp.home_cf_title' => $__category->name,
//				'tmp.cats_description' => $__category->description,
				'tmp.cats_description' => $cats_description,
//				'tmp.cats_bottom_description' => $cats_bottom_description,
//				'tmp.link_for_fb_comment' => $link_for_fb_comment,
//				'tmp.list_post' => EBE_check_list_post_null( $list_post ),
//				'tmp.str_page' => $str_page,
				
				'tmp.custom_blogs_flex_css' => $custom_blogs_flex_css,
				'tmp.custom_blogs_node_flex_css' => $custom_blogs_node_flex_css,
				'tmp.cf_blogs_class_style' => $__cf_row ['cf_blogs_class_style'],
				'tmp.custom_blog_li_css' => $__cf_row['cf_blogs_num_line'],
				
				'tmp.blog_content_sidebar' => _eb_echbay_get_sidebar( 'blog_content_sidebar' ),
			);
			
		}
		// error
		else {
			include EB_THEME_PHP . '404.php';
		}
		
		
		//
		$arr_main_content['tmp.list_post'] = EBE_check_list_post_null( $list_post );
		
		$arr_main_content['tmp.link_for_fb_comment'] = $link_for_fb_comment;
		$arr_main_content['tmp.html_for_fb_comment'] = '<div class="fb-comments" data-href="' . $link_for_fb_comment . '" data-width="100%" data-numposts="{tmp.fb_num_comments}" data-colorscheme="light"></div> <!-- <div class="d-none"><div class="fb-comments-count check-new-fb-comment" data-href="' . $link_for_fb_comment . '">0</div></div> -->';
		$arr_main_content['tmp.str_page'] = $str_page;
		$arr_main_content['tmp.home_cf_title'] = $__cf_row['cf_set_link_for_h1'] == 1 ? '<a href="' . $url_og_url . '" rel="nofollow">' . $__category->name . '</a>' : $__category->name;
		
		
		
		
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
//		$main_content = EBE_html_template( EBE_get_page_template( $html_v2_file ), $arr_main_content );
		
		// v3
		if ( $__cf_row['cf_catsmain_include_file'] != '' && $html_v2_file == 'thread_list' ) {
			$main_content = WGR_check_and_load_tmp_theme( $__cf_row['cf_catsmain_include_file'], 'catsmain' );
			$main_content = EBE_html_template( $main_content, $arr_main_content );
		}
		else {
			$main_content = EBE_html_template( EBE_get_page_template( $html_v2_file ), $arr_main_content );
		}
		
	/*
	}
	else {
		include EB_THEME_PLUGIN_INDEX . 'global/content-none.php';
	}
	*/
	
	
	
	
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



