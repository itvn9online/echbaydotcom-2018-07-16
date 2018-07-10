<?php



/*
* https://developer.wordpress.org/reference/classes/wp_widget/
*/




//
include EB_THEME_CORE . 'widget/product_small.php';
include EB_THEME_CORE . 'widget/blog.php';
include EB_THEME_CORE . 'widget/home_product.php';
include EB_THEME_CORE . 'widget/home_hot.php';
include EB_THEME_CORE . 'widget/home_list.php';
include EB_THEME_CORE . 'widget/home_list_blog.php';
//include EB_THEME_CORE . 'widget/search_advanced.php';
include EB_THEME_CORE . 'widget/categories.php';
include EB_THEME_CORE . 'widget/price.php';

//
include EB_THEME_CORE . 'widget/menu.php';
include EB_THEME_CORE . 'widget/logo.php';
include EB_THEME_CORE . 'widget/copyright.php';
include EB_THEME_CORE . 'widget/tags_open.php';
include EB_THEME_CORE . 'widget/tags_close.php';
include EB_THEME_CORE . 'widget/social.php';
include EB_THEME_CORE . 'widget/contact.php';
include EB_THEME_CORE . 'widget/search.php';
include EB_THEME_CORE . 'widget/banner_big.php';
include EB_THEME_CORE . 'widget/go_to.php';
include EB_THEME_CORE . 'widget/same_price.php';
include EB_THEME_CORE . 'widget/view_history.php';
include EB_THEME_CORE . 'widget/youtube.php';
include EB_THEME_CORE . 'widget/adsense.php';





add_filter ( 'widgets_init', '___add_echbay_widget' );
function ___add_echbay_widget() {
	
	register_widget ( '___echbay_widget_same_same_price' );
	register_widget ( '___echbay_widget_product_view_history' );
	
	register_widget ( '___echbay_widget_random_product' );
	
	register_widget ( '___echbay_widget_google_map' );
	
	register_widget ( '___echbay_widget_youtube_video' );
	
	register_widget ( '___echbay_widget_list_current_category' );
	
	register_widget ( '___echbay_widget_random_blog' );
	
	register_widget ( '___echbay_widget_loc_san_pham_theo_gia' );
	
	register_widget ( '___echbay_widget_home_category_content' );
	
	register_widget ( '___echbay_widget_home_hot_content' );
	register_widget ( '___echbay_widget_home_list_content' );
	register_widget ( '___echbay_widget_home_list_blog' );
	
	//
	register_widget ( '___echbay_widget_get_menu' );
	
	register_widget ( '___echbay_widget_logo_favicon' );
	
	register_widget ( '___echbay_widget_set_copyright' );
	
	register_widget ( '___echbay_widget_menu_open_tag' );
	register_widget ( '___echbay_widget_menu_close_tag' );
	
	register_widget ( '___echbay_widget_set_social_menu' );
	
	register_widget ( '___echbay_widget_set_contact_menu' );
	
	register_widget ( '___echbay_widget_add_search_form' );
	
	register_widget ( '___echbay_widget_banner_big' );
	
	register_widget ( '___echbay_widget_go_to' );
	
	register_widget ( '___echbay_widget_set_adsense_code' );
	
//	register_widget ( '___echbay_widget_search_advanced' );
	
}





// Hiển thị thêm title cho widget để dễ phân biệt
function WGR_show_widget_name_by_title () {
	echo '<script type="text/javascript">
	WGR_show_widget_name_by_title();
	</script>';
}



function _eb_top_footer_form_for_widget ( $instance, $field_name = array() ) {
	foreach ( $instance as $k => $v ) {
		$$k = esc_attr ( $v );
	}
	
	
	_eb_widget_echo_widget_input_title( $field_name['title'], $title );
	
	
	_eb_menu_width_form_for_widget( $field_name['width'], $width );
	
	
	_eb_widget_echo_widget_input_title( $field_name['custom_style'], $custom_style, 'Custom CSS:', '', '' );
	
	
	_eb_widget_echo_widget_input_checkbox( $field_name['hide_mobile'], $hide_mobile, 'Ẩn trên mobile', 'Mặc định, module này sẽ được hiển thị trên mọi thiết bị, tích vào đây nếu muốn nó bị ẩn trên mobile.' );
	
	
	_eb_widget_echo_widget_input_checkbox( $field_name['full_mobile'], $full_mobile, 'Fullsize if mobile', 'Module này sẽ chuyển sang dạng tràn khung trên các thiết bị mobile nếu tích vào.' );
	
}



function _eb_product_form_for_widget ( $instance, $field_name = array() ) {
	
	global $arr_eb_product_status;
	global $arr_eb_ads_status;
	global $wpdb;
	
	//
//	print_r( $instance );
	foreach ( $instance as $k => $v ) {
		$$k = esc_attr ( $v );
	}
//	print_r( $field_name );
	/*
	$title = esc_attr ( $instance ['title'] );
	$sortby = esc_attr ( $instance ['sortby'] );
	$num_line = esc_attr ( $instance ['num_line'] );
	$post_number = esc_attr ( $instance ['post_number'] );
	$cat_ids = esc_attr ( $instance ['cat_ids'] );
	$post_eb_status = esc_attr ( $instance ['post_eb_status'] );
	*/
	
	// tạo ID riêng cho từng widget để điều khiển cho dễ
	$random_current_widget_id = 'ebe_widget_id_change' . md5( rand( 1, 1000 ) );
	
	//
	echo '<div class="eb-widget-fixed ' . $random_current_widget_id . '">';
	
	
	//
	_eb_widget_echo_widget_input_title( $field_name['title'], $title );
	
	//
	_eb_widget_echo_widget_input_checkbox( $field_name[ 'hide_widget_title' ], $hide_widget_title, 'Ẩn tiêu đề widget.' );
	
	//
	echo '<p><strong>HTML tag cho Tiêu đề</strong>: ';
	
	__eb_widget_load_select(
		array(
//			'' => '[ Trống ]',
			'div' => 'DIV',
			'p' => 'P',
			'li' => 'LI',
			'h2' => 'H2',
			'h3' => 'H3',
			'h4' => 'H4',
			'h5' => 'H5',
			'h6' => 'H6'
		),
		 $field_name['dynamic_tag'],
		$dynamic_tag
	);
	
	echo '</p>';
	
	//
	echo '<p><strong>HTML tag cho Tên bài viết</strong>: ';
	
	__eb_widget_load_select(
		array(
			'' => '[ Trống ]',
			'div' => 'DIV',
			'p' => 'P',
//			'li' => 'LI',
			'h2' => 'H2',
			'h3' => 'H3',
			'h4' => 'H4',
			'h5' => 'H5',
			'h6' => 'H6'
		),
		 $field_name['dynamic_post_tag'],
		$dynamic_post_tag
	);
	
	echo '</p>';
	
	
	//
	echo '<p><strong>Mô tả</strong>: <textarea class="widefat" name="' . $field_name['description'] . '">' . $description . '</textarea></p>';
	
	//
	_eb_widget_echo_widget_input_checkbox( $field_name[ 'get_full_content' ], $get_full_content, 'Lấy Nội dung bài viết thay vì lấy Mô tả.' );
	
	
	//
	echo '<p><strong>Định dạng bài viết</strong>: ';
	
	__eb_widget_load_select(
		array(
			'post' => 'post',
			'ads' => 'ads',
			'blog' => 'blog',
		),
		$field_name['post_type'],
		$post_type,
		'ebe-post-type'
	);
	
	echo '</p>';
	
	
	//
	echo '<div class="ebe-widget-ads-show">';
	_eb_widget_echo_widget_input_checkbox( $field_name[ 'open_youtube' ], $open_youtube, 'Mở video Youtube' );
	echo '</div>';
	
	
	//
	_eb_widget_echo_widget_input_checkbox( $field_name[ 'same_cat' ], $same_cat, 'Chỉ lấy các bài viết của nhóm đang xem hoặc bài viết cùng nhóm với bài viết đang xem. * <em>Lựa chọn này sẽ tự động xác định lại post_type và taxonomy của nhóm hoặc bài viết hiện tại</em>.' );
	
	
	//
	echo '<blockquote>';
	
	_eb_widget_echo_widget_input_checkbox( $field_name[ 'get_post_type' ], $get_post_type, 'Xác định lại post_type của bài viết hiện tại. * <em>Áp dụng cho trường hợp bài viết định lấy cùng kiểu dữ liệu với bài đang xem</em>.' );
	
	echo '</blockquote>';
	
	
	
	//
	__eb_widget_load_cat_select ( array(
		'cat_ids_name' => $field_name['cat_ids'],
		'cat_ids' => $cat_ids,
		'cat_type_name' => $field_name['cat_type'],
		'cat_type' => $cat_type,
	), '', true );
	
	
	
	//
	_eb_widget_echo_widget_input_checkbox( $field_name[ 'get_childs' ], $get_childs, 'Lấy danh sách nhóm con' );
	
	
	//
	_eb_widget_echo_number_of_posts_to_show( $field_name['post_number'], $post_number );
	
	
	//
	_eb_widget_number_of_posts_inline( $field_name['num_line'], $num_line );
	
	
	//
	_eb_widget_style_for_post_cloumn( $field_name['post_cloumn'], $post_cloumn );
	
	
	//
	_eb_widget_echo_widget_input_checkbox( $field_name[ 'hide_title' ], $hide_title, 'Ẩn tiêu đề của bài viết.' );
	
	//
	_eb_widget_echo_widget_input_checkbox( $field_name[ 'hide_description' ], $hide_description, 'Ẩn tóm tắt của bài viết.' );
	
	//
	_eb_widget_echo_widget_input_checkbox( $field_name[ 'hide_info' ], $hide_info, 'Ẩn ngày tháng, danh mục của bài viết.' );
	
	//
	_eb_widget_echo_widget_input_checkbox( $field_name[ 'run_slider' ], $run_slider, 'Chạy slider.' );
	
	
	//
	echo '<p class="ebe-widget-post-show"><strong>Trạng thái bài viết</strong>: ';
	
	__eb_widget_load_select(
		$arr_eb_product_status,
		$field_name['post_eb_status'],
		$post_eb_status
	);
	
	echo '</p>';
	
	
	//
	echo '<p class="ebe-widget-ads-show"><strong>Trạng thái quảng cáo</strong>: ';
	
	__eb_widget_load_select(
		$arr_eb_ads_status,
		$field_name['ads_eb_status'],
		$ads_eb_status
	);
	
	echo '</p>';
	
	
	//
	_eb_widget_set_sortby_field( $field_name['sortby'], $sortby );
	
	
	//
	_eb_widget_max_width_for_module( $field_name['max_width'], $max_width );
	
	
	//
	_eb_widget_list_html_file_plugin_theme( $field_name['html_template'], $html_template );
	
	
	//
	_eb_widget_list_html_file_plugin_theme( $field_name['html_node'], $html_node, 'Tệp HTML con' );
	
	
	//
	echo '<p><strong>Tùy chỉnh CSS</strong>: <input type="text" class="widefat" name="' . $field_name['custom_style'] . '" value="' . $custom_style . '" /> * Tạo class CSS để custom riêng:<br>
	- bgtrans: nền trong suốt cho ảnh đại diện.</p>';
	
	
	//
	echo '<p><strong>Tùy chỉnh ID</strong>: <input type="text" class="widefat" name="' . $field_name['custom_id'] . '" value="' . $custom_id . '" /> * Tương tự như CSS -&gt; gán ID để xử lý cho tiện.</p>';
	
	
	//
	echo '<p><strong>Tùy chỉnh size ảnh</strong>: <input type="text" class="widefat fixed-size-for-config" name="' . $field_name['custom_size'] . '" value="' . $custom_size . '" /> * Điều chỉnh size ảnh theo kích thước riêng (nếu có), có thể đặt <strong>auto</strong> để lấy kích thước tự động của ảnh!</p>';
	
	
	//
	echo '<p><strong>Quan hệ liên kết (XFN)</strong>: <input type="text" class="widefat" name="' . $field_name['rel_xfn'] . '" value="' . $rel_xfn . '" /> <strong>rel</strong>: noreferrer, nofollow...</p>';
	
	
	//
	_eb_widget_echo_widget_input_checkbox( $field_name[ 'open_target' ], $open_target, '<strong>Mở liên kết trong tab mới</strong>' );
	
	
	
	//
	_eb_widget_echo_widget_input_checkbox( $field_name[ 'content_only' ], $content_only, '<strong>Chỉ lấy nội dung bài viết</strong>! với lựa chọn này, nội dung bài viết có số order lớn nhất sẽ được lấy ra và hiển thị. Thường dùng khi cần nhúng một nội dung bài viết vào một nội dung khác.' );
	
	
	
	//
	$arr_list_all_page = array();
	$arr_list_all_page[] = '[ Chọn trang riêng ]';
	
	$sql = _eb_q( "SELECT *
	FROM
		`" . wp_posts . "`
	WHERE
		post_type = 'page'
		AND post_status = 'publish'
	ORDER BY
		post_name
	LIMIT 0, 100" );
//	print_r( $sql );
	if ( ! empty( $sql ) ) {
		foreach ( $sql as $v ) {
			$arr_list_all_page[$v->ID] = $v->post_title;
		}
	}
	
	echo '<p><strong>Hiển thị trên trang</strong>: ';
	
	__eb_widget_load_select(
		$arr_list_all_page,
		$field_name['page_id'],
		$page_id
	);
	
	echo '</p><div class="small">* Trường hợp widget này được tạo cho trang tĩnh (page) và bạn muốn nó chỉ hiển thị trong page cụ thể nào đó, hãy chọn chính xác một page để hiển thị.</div>';
	
	
	
	//
	echo '</div>';
	
	
	echo '<script type="text/javascript">
	convert_size_to_one_format();
	WGR_widget_show_option_by_post_type("' . $random_current_widget_id . '");
	</script>';
	
	
	//
	WGR_show_widget_name_by_title();
	
}



function _eb_widget_create_html_template ( $tem, $default ) {
	return ( $tem == '' ) ? $default : str_replace( '.html', '', $tem );
}




function _eb_widget_list_html_file_by_dir ( $dir = EB_THEME_HTML ) {
	if ( substr( $dir, -1 ) == '/' ) {
		$dir = substr( $dir, 0, -1 );
	}
//	echo $dir;
	$arr = glob ( $dir . '/*' );
//	print_r( $arr );
	
	//
	$new_array = array();
	foreach ( $arr as $v ) {
		$v = basename( $v );
		$new_array[$v] = $v;
	}
	
	//
	return $new_array;
}



function _eb_widget_echo_widget_input_checkbox ( $select_name, $select_val, $menu_name = '', $menu_title = '' ) {
	echo '<p><input type="checkbox" class="checkbox" id="' . $select_name . '" name="' . $select_name . '" ';
	checked( $select_val, 'on' );
	echo '><label title="' . $menu_title . '" for="' . $select_name . '">' . $menu_name . '</label></p>';
}



function _eb_widget_echo_widget_input_title (
	$select_name,
	$select_val,
	$menu_name = '',
	$pla = '',
	// class CSS để phân định các điểm khác nhau
	$class_css = 'eb-get-widget-title'
) {
	
	if ( $menu_name == '' ) {
		$menu_name = 'Tiêu đề:';
	}
	if ( $pla == '' ) {
		$pla = $menu_name;
	}
	
	echo '<p><strong>' . $menu_name . '</strong> <input type="text" class="widefat ' . $class_css . '" name="' . $select_name . '" value="' . $select_val . '" placeholder="' . $pla . '" /></p>';
	
}



function _eb_widget_echo_number_of_posts_to_show ( $select_name, $select_val ) {
	echo '<p><strong>Số lượng bài để hiển thị</strong>: <input type="number" class="tiny-text" name="' . $select_name . '" value="' . $select_val . '" min="1" max="30" size="3" /></p>';
}




function _eb_widget_set_sortby_field ( $select_name, $select_val ) {
	echo '<p><strong>Sắp xếp bởi</strong>: ';
	
	__eb_widget_load_select(
		array (
			'menu_order' => 'Post order',
			'ID' => 'Post ID',
			'post_title' => 'Post title',
			'rand' => 'Random'
		),
		$select_name,
		$select_val
	);
	
	echo '</p>';
}




function _eb_widget_style_for_post_cloumn ( $select_name, $select_val ) {
	echo '<p><strong>Bố cục bài viết</strong>: ';
	
	__eb_widget_load_select(
		array(
			'' => 'Mặc định',
			'chu_anh' => 'Chữ trái - ảnh phải',
			'anhtren_chuduoi' => 'Ảnh trên - chữ dưới',
			'chutren_anhduoi' => 'Chữ trên - ảnh dưới',
			'chi_chu' => 'Chỉ chữ',
			'chi_anh' => 'Chỉ ảnh',
			'chi_anh_chu' => 'Chỉ ảnh + chữ'
		),
		$select_name,
		$select_val
	);
	
	echo '</p>';
}




function _eb_widget_number_of_posts_inline ( $select_name, $select_val, $default_arr_select = array (
	'' => 'Mặc định',
	'thread-list100' => 1,
	'thread-list50' => 2,
	'thread-list33' => 3,
	'thread-list25' => 4,
	'thread-list20' => 5,
	'thread-list16' => 6,
	'thread-list14' => 7,
	'thread-list12' => 8,
	'thread-list11' => 9,
	'thread-list10' => 10,
	/*
	'' => 'Mặc định',
	'echbay-blog100' => 'Một',
	'echbay-blog50' => 'Hai',
	'echbay-blog33' => 'Ba',
	'echbay-blog25' => 'Bốn',
	'echbay-blog20' => 'Năm'
	*/
) ) {
	echo '<p><strong>Số bài viết trên mỗi dòng</strong>: ';
	
	__eb_widget_load_select(
		$default_arr_select,
		$select_name,
		$select_val
	);
	
	echo '</p>';
}




function _eb_widget_max_width_for_module ( $select_name, $select_val ) {
	echo '<p><strong>Chiều rộng tối đa</strong>: ';
	
	__eb_widget_load_select(
		array(
			'' => 'Không giới hạn chiều rộng',
			'w99' => 'Rộng tối đa 999px',
			'w90' => 'Rộng tối đa 1366px',
		),
		$select_name,
		$select_val
	);
	
	echo '</p>';
}




function _eb_widget_list_html_file_plugin_theme ( $select_name, $select_val, $html_show = '' ) {
	
	
	// các file mặc định -> có độ ưu tiên cao
	$arr = array(
		'' => 'Mặc định',
	);
	
	// node
	if ( $html_show != '' ) {
		echo '<p><strong>' . $html_show . '</strong>: ';
		
		$arr['thread_node.html'] = 'thread_node (*)';
		$arr['blogs_node.html'] = 'blogs_node (*)';
		$arr['thread_node_small.html'] = 'thread_node_small (*)';
	}
	// module
	else {
		echo '<p><strong>Tệp HTML cha</strong>: ';
		
		$arr['home_hot.html'] = 'home_hot (*)';
		$arr['home_node.html'] = 'home_node (*)';
		$arr['product_small.html'] = 'product_small (*)';
		$arr['widget_echbay_blog.html'] = 'widget_echbay_blog (*)';
	}
	
	// _eb_remove_ebcache_content
	// EB_THEME_HTML
	// EB_THEME_PLUGIN_INDEX . 'html/'
	$arr_in_plugin = _eb_widget_list_html_file_by_dir( EB_THEME_PLUGIN_INDEX . 'html/' );
	$arr_in_theme = _eb_widget_list_html_file_by_dir();
	
	// lấy trong child theme
	if ( using_child_wgr_theme == 1 ) {
		$arr_in_child_theme = _eb_widget_list_html_file_by_dir( EB_CHILD_THEME_URL . 'html/' );
		
		foreach ( $arr_in_child_theme as $k => $v ) {
			if ( ! isset( $arr[$k] ) ) {
				$arr[$k] = $v . ' (child theme)';
			}
		}
	}
	
	//
//	$arr = _eb_parse_args( $arr_in_theme, $arr );
	foreach ( $arr_in_theme as $k => $v ) {
		if ( ! isset( $arr[$k] ) ) {
			$arr[$k] = $v . ' (theme)';
		}
	}
	
	//
	foreach ( $arr_in_plugin as $k => $v ) {
		if ( ! isset( $arr[$k] ) ) {
			$arr[$k] = $v . ' (plugin)';
		}
	}
	
	
	//
	__eb_widget_load_select(
		$arr,
		$select_name,
		$select_val
	);
	
	echo '</p>';
}



function _eb_echo_widget_name ( $name, $before_widget ) {
	echo '<!-- Widget name: ' . $name . ' -->' . "\n" . $before_widget;
}

function _eb_get_echo_widget_title ( $title, $clat = '', $before_title = '', $dynamic_tag = 'div', $after_title = '' ) {
	if ( $title == '' ) {
		return '';
	}
	
	//
	if ( $dynamic_tag == '' ) {
		$dynamic_tag = 'div';
	}
	
	//
//	echo '<div class="echbay-widget-title">' . $before_title . $title . $after_title . '</div>';
	return '
	<div class="echbay-widget-title ' . $clat . '">
		<' . $dynamic_tag . ' title="' . strip_tags( $title ) . '" class="' . $before_title . '">' . $title . '</' . $dynamic_tag . '>
	</div>';
}

function _eb_echo_widget_title ( $title = '', $clat = '', $before_title = '', $dynamic_tag = 'div', $after_title = '' ) {
	echo _eb_get_echo_widget_title( $title, $clat, $before_title, $dynamic_tag, $after_title );
}


function __eb_widget_load_select ( $arr, $select_name, $select_val, $select_class_css = '' ) {
	echo '<select name="' . $select_name . '" class="widefat ' . $select_class_css . '">';
	
	foreach ( $arr as $k => $v ) {
		echo '<option value="' . $k . '"' . _eb_selected( $k, $select_val ) . '>' . $v . '</option>';
	}
	
	echo '</select>';
}


function _eb_menu_width_form_for_widget ( $select_name, $select_val ) {
	echo '<p>Chiều rộng: ';
	
	__eb_widget_load_select( array(
		'' => '100%',
		'f90' => '90%',
		'f80' => '80%',
		'f75' => '75%',
		'f70' => '70%',
		'f65' => '65%',
		'f62' => '62%',
		'f60' => '60%',
		'f55' => '55%',
		'f50' => '50%',
		'f45' => '45%',
		'f40' => '40%',
		'f38' => '38%',
		'f35' => '35%',
		'f33' => '33%',
		'f30' => '30%',
		'f25' => '25%',
		'f20' => '20%',
		'f10' => '10%',
	), $select_name, $select_val );
	
	echo '</p>';
}


function __eb_widget_load_cat_select ( $option, $tax = '', $get_child = false ) {
	
//	print_r( $option );
	
	$select_name = $option['cat_ids_name'];
	$select_val = $option['cat_ids'];
	$cat_type_name = $option['cat_type_name'];
	$cat_type = $option['cat_type'];
	
//	echo $select_name . '<br>' . "\n";
//	echo $select_val . '<br>' . "\n";
	
	// mặc định là lấy tất cả taxonomy được hỗ trợ
	if ( $tax == '' ) {
		$categories = get_categories( array(
			'hide_empty' => 0,
			'parent' => 0
		) );
		
		//
		$categories2 = get_categories( array(
			'taxonomy' => EB_BLOG_POST_LINK,
			'hide_empty' => 0,
			'parent' => 0
		) );
		$categories[] = '[ Danh mục tin tức ]';
		foreach ( $categories2 as $v ) {
			$categories[] = $v;
		}
		
		//
		$categories3 = get_categories( array(
			'taxonomy' => 'post_options',
			'hide_empty' => 0,
			'parent' => 0
		) );
		$categories[] = '[ Thuộc tính sản phẩm ]';
		foreach ( $categories3 as $v ) {
			$categories[] = $v;
		}
		
		//
		/*
		$categories4 = get_categories( array(
			'taxonomy' => 'post_tag',
			'hide_empty' => 0,
			'parent' => 0
		) );
		$categories[] = '[ Thẻ ]';
		foreach ( $categories4 as $v ) {
			$categories[] = $v;
		}
		*/
	}
	// chỉ lấy 1 taxonomy theo chỉ định
	else {
		$args = array(
			'hide_empty' => 0,
			'parent' => 0
		);
		
//		if ( $tax != '' ) {
			$args['taxonomy'] = $tax;
//		}
		$categories = get_categories($args);
	}
//	print_r( $categories );
	
	
	// ID của phiên làm việc hiện tại
	$animate_id = 'ebwg_' . md5( time() ) . rand( 1, 5000 ) . rand( 1, 5000 );
	
	
	
	//
	echo '<p><strong>Chuyên mục</strong>: <em class="' . $animate_id . '_span"></em> <select name="' . $select_name . '" id="' . $animate_id . '" class="widefat eb-get-widget-category">
	<option value="0">[ Select category ]</option>';
	
	foreach ( $categories as $v ) {
		if ( isset( $v->term_id ) ) {
			$k = $v->term_id;
			
			echo '<option data-taxonomy="' . $v->taxonomy . '" value="' . $k . '"' . _eb_selected( $k, $select_val ) . '>' . $v->name . ' (' . $v->count . ')</option>';
			
			// lấy nhóm con (nếu có)
			$arr_sub_cat = array(
				'hide_empty' => 0,
				'taxonomy' => $v->taxonomy,
				'parent' => $k
			);
			$sub_cat = get_categories($arr_sub_cat);
//			print_r( $sub_cat );
			
			//
			if ( ! empty ( $sub_cat ) ) {
				foreach ( $sub_cat as $sub_v ) {
					$sl = '';
					if ( $sub_v->term_id == $select_val ) {
						$sl = ' selected="selected"';
					}
					
					echo '<option data-taxonomy="' . $v->taxonomy . '" value="' . $sub_v->term_id . '"' . $sl . '>---' . $sub_v->name . ' (' . $v->count . ')</option>';
				}
			}
		}
		else {
			echo '<option value="0" disabled>' . $v . '</option>';
		}
	}
	echo '</select></p>';
	
	
	// v3 -> thêm option chọn taxonomy thay vì chỉ tự động
	if ( isset( $option['cat_input_type'] ) && $option['cat_input_type'] == 'select' ) {
		echo '<p>Kiểu dữ liệu: ';
		
		__eb_widget_load_select(
			array (
				'category' => 'Danh mục sản phẩm',
				EB_BLOG_POST_LINK => 'Danh mục tin tức',
				'post_options' => 'Thuộc tính sản phẩm',
			),
			$cat_type_name,
			$cat_type
		);
		
		echo '</p>';
	}
	// v2 -> tự động thay đổi taxonomy khi chọn nhóm
	else {
		echo '<p style="display:none;">Kiểu dữ liệu: <input type="text" class="widefat ' . $animate_id . '" name="' . $cat_type_name . '" value="' . $cat_type . '" /></p>';
		
		//
		echo '<script type="text/javascript">
		WGR_widget_change_taxonomy_if_change_category("' . $animate_id . '");
		</script>';
		
	}
	
	//
	return $animate_id;
	
}




/*
* Widget bản đồ google
*/
class ___echbay_widget_google_map extends WP_Widget {
	function __construct() {
		parent::__construct ( 'echbay_gg_map', 'EchBay GG Map', array (
				'description' => 'Tạo danh sách Google map cho giao diện của EchBay.com' 
		) );
	}
	
	function form($instance) {
		$default = array (
				'title' => 'EchBay GG Map',
				'url_video' => '',
		);
		$instance = wp_parse_args ( ( array ) $instance, $default );
		foreach ( $instance as $k => $v ) {
			$$k = esc_attr ( $v );
		}
		/*
		$title = esc_attr ( $instance ['title'] );
		$url_video = esc_attr ( $instance ['url_video'] );
		*/
		
		echo '<p>Title: <input type="text" class="widefat" name="' . $this->get_field_name ( 'title' ) . '" value="' . $title . '" /></p>';
		
		echo '<p>URL map: <input type="text" class="widefat" name="' . $this->get_field_name ( 'url_video' ) . '" value="' . $url_video . '" /></p>';
	}
	
	function update($new_instance, $old_instance) {
		$instance = _eb_widget_parse_args ( $new_instance, $old_instance );
		return $instance;
	}
	
	function widget($args, $instance) {
//		global $func;
		
		extract ( $args );
		
		$title = apply_filters ( 'widget_title', $instance ['title'] );
		$url_video = isset( $instance ['url_video'] ) ? $instance ['url_video'] : '';
		
		//
		_eb_echo_widget_name( $this->name, $before_widget );
		
		//
		_eb_echo_widget_title( $title, 'echbay-widget-ggmap-title', $before_title );
		
		//
		echo '<div class="url-to-google-map d-none">' . $url_video . '</div>';
		
		//
		echo $after_widget;
	}
}





