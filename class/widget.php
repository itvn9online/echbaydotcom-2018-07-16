<?php



/*
* https://developer.wordpress.org/reference/classes/wp_widget/
*/





add_action ( 'widgets_init', '___add_echbay_widget' );
function ___add_echbay_widget() {
	
	register_widget ( '___echbay_widget_random_product' );
	
	register_widget ( '___echbay_widget_google_map' );
	
	register_widget ( '___echbay_widget_youtube_video' );
	
	register_widget ( '___echbay_widget_list_current_category' );
	
	register_widget ( '___echbay_widget_random_blog' );
	
	register_widget ( '___echbay_widget_loc_san_pham_theo_gia' );
	
	register_widget ( '___echbay_widget_home_category_content' );
	
	register_widget ( '___echbay_widget_home_hot_content' );
	
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
	
//	register_widget ( '___echbay_widget_search_advanced' );
	
}



function _eb_top_footer_form_for_widget ( $instance, $field_name = array() ) {
	foreach ( $instance as $k => $v ) {
		$$k = esc_attr ( $v );
	}
	
	
	_eb_widget_echo_widget_input_title( $field_name['title'], $title );
	
	
	_eb_menu_width_form_for_widget( $field_name['width'], $width );
	
	
	_eb_widget_echo_widget_input_title( $field_name['custom_style'], $custom_style, 'Custom CSS:' );
	
	
	_eb_widget_echo_widget_input_checkbox( $field_name['hide_mobile'], $hide_mobile, 'Ẩn trên mobile', 'Mặc định, module này sẽ được hiển thị trên mọi thiết bị, tích vào đây nếu muốn nó bị ẩn trên mobile.' );
	
	
	_eb_widget_echo_widget_input_checkbox( $field_name['full_mobile'], $full_mobile, 'Fullsize if mobile', 'Module này sẽ chuyển sang dạng tràn khung trên các thiết bị mobile nếu tích vào.' );
	
}



function _eb_product_form_for_widget ( $instance, $field_name = array() ) {
	
	global $arr_eb_product_status;
	global $arr_eb_ads_status;
	
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
	
	
	//
	echo '<div class="eb-widget-fixed">';
	
	
	//
	_eb_widget_echo_widget_input_title( $field_name['title'], $title );
	
	
	//
	__eb_widget_load_cat_select ( array(
		'cat_ids_name' => $field_name['cat_ids'],
		'cat_ids' => $cat_ids,
		'cat_type_name' => $field_name['cat_type'],
		'cat_type' => $cat_type,
	), '', true );
	
	
	//
	_eb_widget_echo_number_of_posts_to_show( $field_name['post_number'], $post_number );
	
	
	//
	_eb_widget_number_of_posts_inline( $field_name['num_line'], $num_line, array(
		'' => 'Mặc định',
		'thread-list100' => 'Một',
		'thread-list50' => 'Hai',
		'thread-list33' => 'Ba',
		'thread-list25' => 'Bốn',
		'thread-list20' => 'Năm',
	) );
	
	
	//
	_eb_widget_style_for_post_cloumn( $field_name['post_cloumn'], $post_cloumn );
	
	
	//
	echo '<p>Post status by: ';
	
	__eb_widget_load_select(
		$arr_eb_product_status,
		$field_name['post_eb_status'],
		$post_eb_status
	);
	
	echo '</p>';
	
	
	//
	echo '<p>Ads status by: ';
	
	__eb_widget_load_select(
		$arr_eb_ads_status,
		$field_name['ads_eb_status'],
		$ads_eb_status
	);
	
	echo '</p>';
	
	
	//
	echo '<p>Post type: ';
	
	__eb_widget_load_select(
		array(
			'post' => 'post',
			'ads' => 'ads',
			'blog' => 'blog',
		),
		$field_name['post_type'],
		$post_type
	);
	
	echo '</p>';
	
	
	//
	_eb_widget_set_sortby_field( $field_name['sortby'], $sortby );
	
	
	//
	_eb_widget_max_width_for_module( $field_name['max_width'], $max_width );
	
	
	//
	_eb_widget_list_html_file_plugin_theme( $field_name['html_template'], $html_template );
	
	
	//
	_eb_widget_list_html_file_plugin_theme( $field_name['html_node'], $html_node, 'node' );
	
	
	//
	echo '<p>Custom CSS: <input type="text" class="widefat" name="' . $field_name['custom_style'] . '" value="' . $custom_style . '"/></p>';
	
	
	
	//
	echo '</div>';
	
}



function _eb_widget_create_html_template ( $tem, $default ) {
	return $tem == '' ? $default : str_replace( '.html', '', $tem );
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



function _eb_widget_echo_widget_input_title ( $select_name, $select_val, $menu_name = 'Title:', $pla = '' ) {
	if ( $pla == '' ) {
		$pla = $menu_name;
	}
	
	echo '<p>' . $menu_name . ' <input type="text" class="widefat" name="' . $select_name . '" value="' . $select_val . '" placeholder="' . $pla . '" /></p>';
}



function _eb_widget_echo_number_of_posts_to_show ( $select_name, $select_val ) {
	echo '<p>Number of posts to show: <input type="number" class="tiny-text" name="' . $select_name . '" value="' . $select_val . '" min="1" max="30" size="3" /></p>';
}




function _eb_widget_set_sortby_field ( $select_name, $select_val ) {
	echo '<p>Sort by: ';
	
	__eb_widget_load_select(
		array (
			'rand' => 'Random',
			'post_title' => 'Post title',
			'menu_order' => 'Post order',
			'ID' => 'Post ID',
		),
		$select_name,
		$select_val
	);
	
	echo '</p>';
}




function _eb_widget_style_for_post_cloumn ( $select_name, $select_val ) {
	echo '<p>Post cloumn: ';
	
	__eb_widget_load_select(
		array(
			'' => 'Mặc định',
			'chu_anh' => 'Chữ trái - ảnh phải',
			'anhtren_chuduoi' => 'Ảnh trên - chữ dưới',
			'chutren_anhduoi' => 'Chữ trên - ảnh dưới',
			'chi_chu' => 'Chỉ chữ',
		),
		$select_name,
		$select_val
	);
	
	echo '</p>';
}




function _eb_widget_number_of_posts_inline ( $select_name, $select_val, $default_arr_select = array (
	'' => 'Mặc định',
	'echbay-blog100' => 'Một',
	'echbay-blog50' => 'Hai',
	'echbay-blog33' => 'Ba',
	'echbay-blog25' => 'Bốn',
	'echbay-blog20' => 'Năm',
) ) {
	echo '<p>Number of posts inline: ';
	
	__eb_widget_load_select(
		$default_arr_select,
		$select_name,
		$select_val
	);
	
	echo '</p>';
}




function _eb_widget_max_width_for_module ( $select_name, $select_val ) {
	echo '<p>Max-width module: ';
	
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




function _eb_widget_list_html_file_plugin_theme ( $select_name, $select_val, $html_show = 'module' ) {
	
	
	// các file mặc định -> có độ ưu tiên cao
	$arr = array(
		'' => 'Mặc định',
	);
	
	// node
	if ( $html_show == 'node' ) {
		echo '<p>HTML node template: ';
		
		$arr['thread_node.html'] = 'thread_node (*)';
		$arr['blogs_node.html'] = 'blogs_node (*)';
		$arr['thread_node_small.html'] = 'thread_node_small (*)';
	}
	// module
	else {
		echo '<p>HTML module template: ';
		
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
	
	//
//	$arr = _eb_parse_args( $arr_in_theme, $arr );
	foreach ( $arr_in_plugin as $k => $v ) {
		if ( ! isset( $arr[$k] ) ) {
			$arr[$k] = $v;
		}
	}
	foreach ( $arr_in_theme as $k => $v ) {
		if ( ! isset( $arr[$k] ) ) {
			$arr[$k] = $v;
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

function _eb_get_echo_widget_title ( $title, $clat = '', $before_title = '', $after_title = '' ) {
	if ( $title != '' ) {
//		echo '<div class="echbay-widget-title">' . $before_title . $title . $after_title . '</div>';
		return '
		<div class="echbay-widget-title ' . $clat . '">
			<div title="' . strip_tags( $title ) . '" class="' . $before_title . '">' . $title . '</div>
		</div>';
	}
	return '';
}

function _eb_echo_widget_title ( $title, $clat = '', $before_title = '', $after_title = '' ) {
	echo _eb_get_echo_widget_title( $title, $clat, $before_title, $after_title );
}


function __eb_widget_load_select ( $arr, $select_name, $select_val ) {
	echo '<select name="' . $select_name . '" class="widefat">';
	
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
	$cat_type_name = $option['cat_type'];
	$cat_type = $option['cat_type'];
	
//	echo $select_name . '<br>' . "\n";
//	echo $select_val . '<br>' . "\n";
	
	// mặc định là lấy tất cả taxonomy được hỗ trợ
	if ( $tax == '' ) {
		$categories = get_categories( array(
			'parent' => 0,
		) );
		
		//
		$categories2 = get_categories( array(
			'parent' => 0,
			'taxonomy' => EB_BLOG_POST_LINK,
		) );
		$categories[] = '[ Danh mục tin tức ]';
		foreach ( $categories2 as $v ) {
			$categories[] = $v;
		}
		
		//
		$categories3 = get_categories( array(
			'parent' => 0,
			'taxonomy' => 'post_options',
		) );
		$categories[] = '[ Thuộc tính sản phẩm ]';
		foreach ( $categories3 as $v ) {
			$categories[] = $v;
		}
	}
	// chỉ lấy 1 taxonomy theo chỉ định
	else {
		$args = array(
			'parent' => 0,
		);
		
//		if ( $tax != '' ) {
			$args['taxonomy'] = $tax;
//		}
		$categories = get_categories($args);
	}
//	print_r( $categories );
	
	
	// ID của phiên làm việc hiện tại
	$animate_id = 'ebwg_' . md5( time() );
	
	
	
	//
	echo '<p>Categories: <select name="' . $select_name . '" id="' . $animate_id . '" class="widefat">
	<option value="0">[ Select category ]</option>';
	
	foreach ( $categories as $v ) {
		if ( isset( $v->term_id ) ) {
			$k = $v->term_id;
			
			echo '<option data-taxonomy="' . $v->taxonomy . '" value="' . $k . '"' . _eb_selected( $k, $select_val ) . '>' . $v->name . '</option>';
			
			// lấy nhóm con (nếu có)
			$arr_sub_cat = array(
				'parent' => $k,
			);
			$sub_cat = get_categories($arr_sub_cat);
	//		print_r( $sub_cat );
			
			foreach ( $sub_cat as $sub_v ) {
				$sl = '';
				if ( $sub_v->term_id == $select_val ) {
					$sl = ' selected="selected"';
				}
				
				echo '<option data-taxonomy="' . $v->taxonomy . '" value="' . $sub_v->term_id . '"' . $sl . '>---' . $sub_v->name . '</option>';
			}
		}
		else {
			echo '<option disabled>' . $v . '</option>';
		}
	}
	echo '</select></p>';
	
	
	// v2 -> tự động thay đổi taxonomy khi chọn nhóm
	echo '<p style="display:none;">Kiểu dữ liệu: <input type="text" class="widefat ' . $animate_id . '" name="' . $cat_type_name . '" value="' . $cat_type . '"/></p>';
	
	//
	echo '<script type="text/javascript">
	jQuery("#' . $animate_id . '").off("change").change(function () {
		var a = jQuery("#' . $animate_id . ' option:selected").attr("data-taxonomy") || "";
		if ( a == "" ) a = "category";
		console.log("Auto set taxonomy #" + a);
		jQuery(".' . $animate_id . '").val( a );
	});
	</script>';
	
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
		
		echo '<p>Title: <input type="text" class="widefat" name="' . $this->get_field_name ( 'title' ) . '" value="' . $title . '"/></p>';
		
		echo '<p>URL map: <input type="text" class="widefat" name="' . $this->get_field_name ( 'url_video' ) . '" value="' . $url_video . '"/></p>';
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




/*
* Widget tạo list video youtube
*/
class ___echbay_widget_youtube_video extends WP_Widget {
	function __construct() {
		parent::__construct ( 'echbay_youtube', 'EchBay Youtube', array (
				'description' => 'Tạo danh sách phát Video Youtube' 
		) );
	}
	
	function form($instance) {
		$default = array (
				'title' => 'EchBay Youtube',
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
		
		echo '<p>Title: <input type="text" class="widefat" name="' . $this->get_field_name ( 'title' ) . '" value="' . $title . '"/></p>';
		
		echo '<p>URL youtube: <textarea class="widefat" name="' . $this->get_field_name ( 'url_video' ) . '" placeholder="//www.youtube.com/embed/FoxruhmPLs4">' . $url_video . '</textarea></p>';
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
		_eb_echo_widget_title( $title, 'echbay-widget-youtube-title', $before_title );
		
		//
		echo '<div class="img-max-width d-none">' . $url_video . '</div>';
		
		//
		echo $after_widget;
	}
}




//
include EB_THEME_CORE . 'widget/product_small.php';
include EB_THEME_CORE . 'widget/blog.php';
include EB_THEME_CORE . 'widget/home_product.php';
include EB_THEME_CORE . 'widget/home_hot.php';
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



