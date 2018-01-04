<?php



/*
* https://developer.wordpress.org/reference/classes/wp_widget/
*/



function _eb_echo_widget_name ( $name, $before_widget ) {
	echo '<!-- Widget name: ' . $name . ' -->' . "\n" . $before_widget;
}

function _eb_echo_widget_title ( $title, $clat = '', $before_title = '', $after_title = '' ) {
	if ( $title != '' ) {
//		echo '<div class="echbay-widget-title">' . $before_title . $title . $after_title . '</div>';
		echo '
		<div class="echbay-widget-title ' . $clat . '">
			<div class="' . $before_title . '">' . $title . '</div>
		</div>';
	}
}


function __eb_widget_load_select ( $arr, $select_name, $select_val ) {
	echo '<select name="' . $select_name . '" class="widefat">';
	
	foreach ( $arr as $k => $v ) {
		echo '<option value="' . $k . '"' . _eb_selected( $k, $select_val ) . '>' . $v . '</option>';
	}
	
	echo '</select>';
}


function __eb_widget_load_cat_select ( $select_name, $select_val, $tax = '', $get_child = false ) {
	
//	echo $select_name . '<br>' . "\n";
//	echo $select_val . '<br>' . "\n";
	
	$args = array(
		'parent' => 0,
	);
	
	if ( $tax != '' ) {
		$args['taxonomy'] = $tax;
	}
	
	$categories = get_categories($args);
//	print_r( $categories );
	
	//
	echo '<p>Categories: <select name="' . $select_name . '" class="widefat">
	<option value="0">[ Select category ]</option>';
	
	foreach ( $categories as $v ) {
		$k = $v->term_id;
		
		echo '<option value="' . $k . '"' . _eb_selected( $k, $select_val ) . '>' . $v->name . '</option>';
		
		// lấy nhóm con (nếu có)
		$arr_sub_cat = array(
			'parent' => $k,
		);
		$sub_cat = get_categories($arr_sub_cat);
//		print_r( $sub_cat );
		
		foreach ( $sub_cat as $sub_v ) {
			$sl = '';
			if ( $sub_v->term == $select_val ) {
				$sl = ' selected="selected"';
			}
			
			echo '<option value="' . $sub_v->term_id . '"' . $sl . '>---' . $sub_v->name . '</option>';
		}
	}
	echo '</select></p>';
	
}





add_filter ( 'widgets_init', '___add_echbay_widget' );
function ___add_echbay_widget() {
	register_widget ( '___echbay_widget_random_product' );
	
	register_widget ( '___echbay_widget_google_map' );
	
	register_widget ( '___echbay_widget_youtube_video' );
	
	register_widget ( '___echbay_widget_list_curent_category' );
	
	register_widget ( '___echbay_widget_random_blog' );
	
	register_widget ( '___echbay_widget_loc_san_pham_theo_gia' );
	
	register_widget ( '___echbay_widget_home_category_content' );
	
	register_widget ( '___echbay_widget_home_hot_content' );
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
		$title = esc_attr ( $instance ['title'] );
		$url_video = esc_attr ( $instance ['url_video'] );
		
		echo '<p>Title: <input type="text" class="widefat" name="' . $this->get_field_name ( 'title' ) . '" value="' . $title . '"/></p>';
		
		echo '<p>URL map: <input type="text" class="widefat" name="' . $this->get_field_name ( 'url_video' ) . '" value="' . $url_video . '"/></p>';
	}
	
	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance ['title'] = strip_tags ( $new_instance ['title'] );
		$instance ['url_video'] = strip_tags ( $new_instance ['url_video'] );
		
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
		$title = esc_attr ( $instance ['title'] );
		$url_video = esc_attr ( $instance ['url_video'] );
		
		echo '<p>Title: <input type="text" class="widefat" name="' . $this->get_field_name ( 'title' ) . '" value="' . $title . '"/></p>';
		
		echo '<p>URL youtube: <textarea class="widefat" name="' . $this->get_field_name ( 'url_video' ) . '" placeholder="//www.youtube.com/embed/FoxruhmPLs4">' . $url_video . '</textarea></p>';
	}
	
	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance ['title'] = strip_tags ( $new_instance ['title'] );
		$instance ['url_video'] = strip_tags ( $new_instance ['url_video'] );
		
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




/*
* Widget danh mục sản phẩm hiện tại đang xem
*/
class ___echbay_widget_list_curent_category extends WP_Widget {
	function __construct() {
		parent::__construct ( 'echbay_category', 'EchBay categories', array (
			'description' => 'Tạo danh sách danh mục sản phẩm hiện tại đang xem.' 
		) );
	}
	
	function form($instance) {
		$default = array (
			'title' => 'EchBay category',
			'cat_type' => 'category',
			'show_count' => 0,
		);
		$instance = wp_parse_args ( ( array ) $instance, $default );
		$title = esc_attr ( $instance ['title'] );
		$cat_type = esc_attr ( $instance ['cat_type'] );
		$show_count = esc_attr ( $instance ['show_count'] );
		
		echo '<p>Title: <input type="text" class="widefat" name="' . $this->get_field_name ( 'title' ) . '" value="' . $title . '"/></p>';
		
		
		//
		echo '<p>Kiểu dữ liệu: ';
		
		__eb_widget_load_select(
			array (
				'category' => 'Danh mục sản phẩm',
				EB_BLOG_POST_LINK => 'Danh mục tin tức',
				'post_options' => 'Thuộc tính sản phẩm',
			),
			 $this->get_field_name ( 'cat_type' ),
			$cat_type
		);
		
		echo '</p>';
		
		
		//
		$input_name = $this->get_field_name ( 'show_count' );
//		echo $instance[ 'show_count' ];
		
		echo '<p><input type="checkbox" class="checkbox" id="' . $input_name . '" name="' . $input_name . '" ';
		checked( $instance[ 'show_count' ], 'on' );
		echo '><label for="' . $input_name . '">Hiện số bài viết</label></p>';
	}
	
	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance ['title'] = strip_tags ( $new_instance ['title'] );
		$instance ['cat_type'] = $new_instance ['cat_type'];
		$instance ['show_count'] = $new_instance ['show_count'];
		
		return $instance;
	}
	
	function widget($args, $instance) {
//		global $func;
		
		extract ( $args );
		
		$title = apply_filters ( 'widget_title', $instance ['title'] );
		$cat_type = isset( $instance ['cat_type'] ) ? $instance ['cat_type'] : 'category';
		$show_count = isset( $instance ['show_count'] ) ? $instance ['show_count'] : 'on';
		$show_count = $show_count == 'on' ? 1 : 0;
		
		//
		_eb_echo_widget_name( $this->name, $before_widget );
		
		//
		_eb_echo_widget_title( $title, 'echbay-widget-category-title', $before_title );
		
		//
		echo '<ul class="echbay-category-in-js">';

		wp_list_categories( array(
//			'echo' => false,
			'show_count' => $show_count,
			'orderby' => 'name',
//			'order' => 'DESC',
			'taxonomy' => $cat_type,
			'title_li' => ''
		) );
		
		echo '</ul>';
		
		//
		echo $after_widget;
	}
}




/*
* Widget sản phẩm ngẫu nhiên
*/
class ___echbay_widget_random_product extends WP_Widget {
	function __construct() {
		parent::__construct ( 'random_post', 'EchBay product small', array (
				'description' => 'Tạo danh sách sản phẩm dưới dạng thiết kế thu gọn' 
		) );
	}
	
	function form($instance) {
		$default = array (
				'title' => 'EchBay product small',
				'sortby' => 'menu_order',
				'post_number' => 5,
				'cat_ids' => 0
		);
		$instance = wp_parse_args ( ( array ) $instance, $default );
		$title = esc_attr ( $instance ['title'] );
		$post_number = esc_attr ( $instance ['post_number'] );
		$sortby = esc_attr ( $instance ['sortby'] );
		$cat_ids = esc_attr ( $instance ['cat_ids'] );
		
		
		//
		echo '<p>Title: <input type="text" class="widefat" name="' . $this->get_field_name ( 'title' ) . '" value="' . $title . '"/></p>';
		
		
		//
		echo '<p>Number of posts to show: <input type="number" class="tiny-text" name="' . $this->get_field_name ( 'post_number' ) . '" value="' . $post_number . '" min="1" max="30" size="3" /></p>';
		
		
		//
		echo '<p>Sort by: ';
		
		__eb_widget_load_select(
			array (
				'rand' => 'Random',
				'post_title' => 'Post title',
				'menu_order' => 'Post order',
				'ID' => 'Post ID',
			),
			 $this->get_field_name ( 'sortby' ),
			$sortby
		);
		
		echo '</p>';
		
		
		//
		__eb_widget_load_cat_select ( $this->get_field_name ( 'cat_ids' ), $cat_ids );
		
	}
	
	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance ['title'] = strip_tags ( $new_instance ['title'] );
		$instance ['post_number'] = strip_tags ( $new_instance ['post_number'] );
		$instance ['sortby'] = strip_tags ( $new_instance ['sortby'] );
		$instance ['cat_ids'] = strip_tags ( $new_instance ['cat_ids'] );
		
		return $instance;
	}
	
	function widget($args, $instance) {
//		global $func;
		
		extract ( $args );
		
		$title = apply_filters ( 'widget_title', $instance ['title'] );
		$post_number = isset( $instance ['post_number'] ) ? $instance ['post_number'] : 0;
		if ( $post_number == 0 ) $post_number = 5;
		
		$sortby = isset( $instance ['sortby'] ) ? $instance ['sortby'] : '';
		$cat_ids = isset( $instance ['cat_ids'] ) ? $instance ['cat_ids'] : 0;
		
		//
		_eb_echo_widget_name( $this->name, $before_widget );
		
		//
		_eb_echo_widget_title( $title, 'echbay-widget-product-title', $before_title );
		
		//
		echo '<ul class="cf echbay-blog echbay-blog100 echbay-widget-product">';
		
		//
		$___order = 'DESC';
		if ( $sortby == '' || $sortby == 'rand' ) {
			$___order = '';
		}
		
		//
		$args = array(
			'orderby' => $sortby,
			'order' => $___order,
		);
		
		if ( $cat_ids > 0 ) {
			$args['cat'] = $cat_ids;
		}
		// tự động lấy theo nhóm hiện tại
		/*
		else {
			$category = get_queried_object();
			print_r( $category );
		}
		*/
		
		echo _eb_load_post( $post_number, $args,
//		file_get_contents( EB_THEME_PLUGIN_INDEX . 'html/thread_node.html', 1 ) );
		EBE_get_page_template( 'thread_node_small' ) );
		
		echo '</ul>';
		
		//
		echo $after_widget;
	}
}




/*
* Widget blog ngẫu nhiên
*/
class ___echbay_widget_random_blog extends WP_Widget {
	function __construct() {
		parent::__construct ( 'random_blog', 'EchBay blog', array (
				'description' => 'Tạo danh sách Blog/ Tin tức (dạng thu gọn)' 
		) );
	}
	
	function form($instance) {
		$default = array (
				'title' => 'EchBay blog',
				'sortby' => 'menu_order',
				'post_number' => 5,
				'cat_ids' => 0
		);
		$instance = wp_parse_args ( ( array ) $instance, $default );
		$title = esc_attr ( $instance ['title'] );
		$post_number = esc_attr ( $instance ['post_number'] );
		$sortby = esc_attr ( $instance ['sortby'] );
		$cat_ids = esc_attr ( $instance ['cat_ids'] );
		
		
		//
		echo '<p>Title: <input type="text" class="widefat" name="' . $this->get_field_name ( 'title' ) . '" value="' . $title . '"/></p>';
		
		
		//
		echo '<p>Number of posts to show: <input type="number" class="tiny-text" name="' . $this->get_field_name ( 'post_number' ) . '" value="' . $post_number . '" min="1" max="30" size="3" /></p>';
		
		
		//
		echo '<p>Sort by: ';
		
		__eb_widget_load_select(
			array (
				'rand' => 'Random',
				'post_title' => 'Post title',
				'menu_order' => 'Post order',
				'ID' => 'Post ID',
			),
			 $this->get_field_name ( 'sortby' ),
			$sortby
		);
		
		echo '</p>';
		
		
		//
		__eb_widget_load_cat_select ( $this->get_field_name ( 'cat_ids' ), $cat_ids, EB_BLOG_POST_LINK );
		
	}
	
	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance ['title'] = strip_tags ( $new_instance ['title'] );
		$instance ['post_number'] = strip_tags ( $new_instance ['post_number'] );
		$instance ['sortby'] = strip_tags ( $new_instance ['sortby'] );
		$instance ['cat_ids'] = esc_sql ( $new_instance ['cat_ids'] );
		
		return $instance;
	}
	
	function widget($args, $instance) {
//		global $func;
		
		extract ( $args );
		
		$title = apply_filters ( 'widget_title', $instance ['title'] );
		$post_number = isset( $instance ['post_number'] ) ? $instance ['post_number'] : 0;
		if ( $post_number == 0 ) $post_number = 5;
		
		$sortby = isset( $instance ['sortby'] ) ? $instance ['sortby'] : '';
		$cat_ids = isset( $instance ['cat_ids'] ) ? $instance ['cat_ids'] : 0;
		
		//
		_eb_echo_widget_name( $this->name, $before_widget );
		
		//
		_eb_echo_widget_title( $title, 'echbay-widget-blogs-title', $before_title );
		
		//
		$terms_categories = array();
		
		// lấy theo nhóm tin đã được chỉ định
		if ( $cat_ids > 0 ) {
			$terms_categories[] = $cat_ids;
		}
		// lấy tất cả
		else {
			$args = array(
				'taxonomy' => EB_BLOG_POST_LINK,
			);
			$categories = get_categories($args);
//			print_r( $categories );
			
			//
			foreach ( $categories as $v ) {
				$terms_categories[] = $v->term_id;
			}
		}
		
		//
		$___order = 'DESC';
		if ( $sortby == '' || $sortby == 'rand' ) {
			$___order = '';
		}
		
		//
		echo '<ul class="cf echbay-blog echbay-blog100 echbay-widget-blogs">';
		
		//
		echo _eb_load_post( $post_number, array(
			'orderby' => $sortby,
			'order' => $___order,
			'post_type' => EB_BLOG_POST_TYPE,
			'tax_query' => array(
				array(
					'taxonomy' => EB_BLOG_POST_LINK,
					'field' => 'term_id',
					'terms' => $terms_categories,
					'operator' => 'IN',
				)
			),
//		), file_get_contents( EB_THEME_PLUGIN_INDEX . 'html/blog_node.html', 1 ) );
		), EBE_get_page_template( 'blog_node' ) );
		
		echo '</ul>';
		
		//
		echo $after_widget;
	}
}




/*
* Widget lọc sản phẩm theo khoảng giá
*/
class ___echbay_widget_loc_san_pham_theo_gia extends WP_Widget {
	function __construct() {
		parent::__construct ( 'echbay_price', 'EchBay price', array (
			'description' => 'Chức năng tạo liên kết lọc sản phẩm theo khoảng giá' 
		) );
	}
	
	function form($instance) {
		$default = array (
			'title' => 'EchBay price',
		);
		$instance = wp_parse_args ( ( array ) $instance, $default );
		$title = esc_attr ( $instance ['title'] );
		
		echo '<p>Title: <input type="text" class="widefat" name="' . $this->get_field_name ( 'title' ) . '" value="' . $title . '"/></p>';
	}
	
	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance ['title'] = strip_tags ( $new_instance ['title'] );
		
		return $instance;
	}
	
	function widget($args, $instance) {
//		global $wpdb;
//		global $func;
		
		extract ( $args );
		
		$title = apply_filters ( 'widget_title', $instance ['title'] );
		
		//
		_eb_echo_widget_name( $this->name, $before_widget );
		
		//
		_eb_echo_widget_title( $title, 'echbay-widget-price-title', $before_title );
		
		//
		echo '<ul class="echbay-product-price-between">';
		
		// lấy khoảng giá
		$sql = _eb_q("SELECT *
		FROM
			`" . wp_termmeta . "`
		WHERE
			meta_key = '_eb_category_status'
			AND meta_value = 8");
			/*
		$sql = _eb_q("SELECT *
		FROM
			`" . wp_postmeta . "`
		WHERE
			meta_key = '_eb_category_status'
			AND meta_value = 8");
			*/
//		print_r($sql);
		foreach ( $sql as $v ) {
//			print_r($v);
			
			//
//			$term_id = $v->post_id;
			$term_id = $v->term_id;
			$taxonomy_name = 'post_options';
			$termchildren = get_term_children( $term_id, $taxonomy_name );
//			print_r($termchildren);
			
			foreach ( $termchildren as $child ) {
				$term = get_term_by( 'id', $child, $taxonomy_name );
//				print_r($term);
				
				echo '<li><a data-href="' . $term->slug . '" href="#">' . $term->name . '</a></li>';
			}
		}
		
		echo '</ul>';
		
		//
		echo $after_widget;
	}
}




/*
* Widget lấy sản phẩm theo từng phân nhóm (thường dùng ở các trang chủ)
*/
$echbay_widget_i_set_home_product_bg = 0;

class ___echbay_widget_home_category_content extends WP_Widget {
	function __construct() {
		parent::__construct ( 'random_home_post', 'EchBay home product', array (
				'description' => 'Danh sách sản phẩm theo từng phân nhóm ở trang chủ' 
		) );
	}
	
	function form($instance) {
		$default = array (
//				'title' => 'EchBay home product',
				'title' => '',
				'num_line' => '',
				'sortby' => 'menu_order',
				'post_number' => 5,
				'cat_ids' => 0
		);
		$instance = wp_parse_args ( ( array ) $instance, $default );
		$title = esc_attr ( $instance ['title'] );
		$num_line = esc_attr ( $instance ['num_line'] );
		$post_number = esc_attr ( $instance ['post_number'] );
		$sortby = esc_attr ( $instance ['sortby'] );
		$cat_ids = esc_attr ( $instance ['cat_ids'] );
		
		
		//
		__eb_widget_load_cat_select ( $this->get_field_name ( 'cat_ids' ), $cat_ids, '', true );
		
		
		//
		echo '<p>Title: <input type="text" class="widefat" name="' . $this->get_field_name ( 'title' ) . '" value="' . $title . '" placeholder="Default show this cat name" /></p>';
		
		
		//
		echo '<p>Number of posts to show: <input type="number" class="tiny-text" name="' . $this->get_field_name ( 'post_number' ) . '" value="' . $post_number . '" min="1" max="30" size="3" /></p>';
		
		
		//
		echo '<p>Number of posts inline: ';
		
		__eb_widget_load_select(
			array(
				'' => 'Mặc định',
				'thread-list100' => 'Một',
				'thread-list50' => 'Hai',
				'thread-list33' => 'Ba',
				'thread-list25' => 'Bốn',
				'thread-list20' => 'Năm',
			),
			 $this->get_field_name ( 'num_line' ),
			$num_line
		);
		
		echo '</p>';
		
		
		//
		echo '<p>Sort by: ';
		
		__eb_widget_load_select(
			array (
				'rand' => 'Random',
				'post_title' => 'Post title',
				'menu_order' => 'Post order',
				'ID' => 'Post ID',
			),
			 $this->get_field_name ( 'sortby' ),
			$sortby
		);
		
		echo '</p>';
		
	}
	
	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance ['title'] = strip_tags ( $new_instance ['title'] );
		$instance ['post_number'] = strip_tags ( $new_instance ['post_number'] );
		$instance ['sortby'] = strip_tags ( $new_instance ['sortby'] );
		$instance ['cat_ids'] = strip_tags ( $new_instance ['cat_ids'] );
		$instance ['num_line'] = strip_tags ( $new_instance ['num_line'] );
		
		return $instance;
	}
	
	function widget($args, $instance) {
//		global $func;
		global $echbay_widget_i_set_home_product_bg;
		
		extract ( $args );
		
//		$title = apply_filters ( 'widget_title', $instance ['title'] );
		$title = isset( $instance ['title'] ) ? $instance ['title'] : '';
		$post_number = isset( $instance ['post_number'] ) ? $instance ['post_number'] : 0;
		if ( $post_number == 0 ) $post_number = 5;
		
		$sortby = isset( $instance ['sortby'] ) ? $instance ['sortby'] : '';
		$cat_ids = isset( $instance ['cat_ids'] ) ? $instance ['cat_ids'] : 0;
		$num_line = isset( $instance ['num_line'] ) ? $instance ['num_line'] : '';
		
		//
		_eb_echo_widget_name( $this->name, $before_widget );
		
		//
//		_eb_echo_widget_title( $title, 'echbay-widget-home-cats-title', $before_title );
		
		//
		$___order = 'DESC';
		if ( $sortby == '' || $sortby == 'rand' ) {
			$___order = '';
		}
		
		//
		$args = array(
			'orderby' => $sortby,
			'order' => $___order,
		);
		
		
		//
		$cat_name = $title;
		$cat_link = '';
		$cat_count = 0;
		
		$home_node_cat = '';
		$home_ads_by_cat = '';
		$str_sub_cat = '';
		
		// nếu có phân nhóm -> lấy theo phân nhóm
		if ( $cat_ids > 0 ) {
			$args['cat'] = $cat_ids;
			
			// lấy thông tin phân nhóm luôn
//			$categories = get_categories($cat_ids);
//			$categories = get_the_category_by_ID($cat_ids);
//			$categories = get_term($cat_ids, 'category');
			$categories = get_term_by('id', $cat_ids, 'category');
//			print_r( $categories );
			
			//
			$cat_link = _eb_c_link( $cat_ids );
			
			// wp nó trả ra cái objec hơi dị -> foreach lấy cho dễ
			$cat_count = $categories->count;
			$cat_name = $categories->name;
			
			
			
			//
			if ( $cat_count > 0 ) {
				// danh sách nhóm cấp 2
				$arr_sub_cat = array(
					'parent' => $cat_ids,
				);
				$sub_cat = get_categories($arr_sub_cat);
	//			print_r( $sub_cat );
				
				foreach ( $sub_cat as $sub_v ) {
					$str_sub_cat .= ' <a href="' . _eb_c_link( $sub_v->term_id ) . '">' . $sub_v->name . ' <span class="home-count-subcat">(' . $sub_v->count . ')</span></a>';
				}
				
				
				
				// banner quảng cáo theo từng danh mục (cấp 1)
				$home_ads_by_cat = _eb_load_ads( 9, 1, '', array(
					'cat' => $cat_ids,
				), 0, EBE_get_page_template( 'home_ads_by_cat' ) );
				
				
				//
//				$home_node_cat = _eb_load_post( $post_number, $args );
			}
		}
//		else {
			$home_node_cat = _eb_load_post( $post_number, $args );
//		}
		
		
		//
		if ( $home_node_cat == '' ) {
			$home_node_cat = '<li class="text-center"><em>post not found</em></li>';
		}
		
		
		
		//
		if ( $echbay_widget_i_set_home_product_bg % 2 == 0 ) {
			$class_for_chanle = 'home-node-chan';
		}
		else {
			$class_for_chanle = 'home-node-le';
		}
		$echbay_widget_i_set_home_product_bg++;
		
		
		
		//
		echo EBE_html_template( EBE_get_page_template( 'home_node' ), array(
			'tmp.cat_id' => $cat_ids,
			'tmp.cat_link' => $cat_link ? $cat_link : 'javascript:;',
			'tmp.cat_name' => $title != '' ? $title : ( $cat_name != '' ? $cat_name : 'Sản phẩm' ),
//			'tmp.cat_name' => $cat_name,
			'tmp.cat_count' => $cat_count,
			
			// danh sách nhóm cấp 2
			'tmp.str_sub_cat' => $str_sub_cat,
			
			// danh sách sản phẩm
			'tmp.home_node_cat' => $home_node_cat,
			
			// quảng cáo theo nhóm cấp 1
			'tmp.home_ads_by_cat' => $home_ads_by_cat,
			
			// bg chẵn lẻ
			'tmp.class_for_chanle' => $class_for_chanle,
//			'tmp.class_for_chanle' => 'each-to-bg-chanle',
			'tmp.num_post_line' => $num_line,
		) );
		
		
		//
		echo $after_widget;
	}
}




/*
* Widget lấy sản phẩm MỚI/ HOT (thường dùng ở các trang chủ)
*/
function _eb_product_form_for_widget ( $instance, $field_name = array() ) {
	
	global $arr_eb_product_status;
	
	//
//	print_r( $instance );
	foreach ( $instance as $k => $v ) {
		$$k = esc_attr ( $v );
	}
	/*
	$title = esc_attr ( $instance ['title'] );
	$sortby = esc_attr ( $instance ['sortby'] );
	$num_line = esc_attr ( $instance ['num_line'] );
	$post_number = esc_attr ( $instance ['post_number'] );
	$cat_ids = esc_attr ( $instance ['cat_ids'] );
	$post_eb_status = esc_attr ( $instance ['post_eb_status'] );
	*/
	
	
	//
	__eb_widget_load_cat_select ( $field_name['cat_ids'], $cat_ids, '', true );
	
	
	//
	echo '<p>Title: <input type="text" class="widefat" name="' . $field_name['title'] . '" value="' . $title . '" placeholder="Default show this cat name" /></p>';
	
	
	//
	echo '<p>Number of posts to show: <input type="number" class="tiny-text" name="' . $field_name['post_number'] . '" value="' . $post_number . '" min="1" max="30" size="3" /></p>';
	
	
	//
	echo '<p>Number of posts inline: ';
	
	__eb_widget_load_select(
		array(
			'' => 'Mặc định',
			'thread-list100' => 'Một',
			'thread-list50' => 'Hai',
			'thread-list33' => 'Ba',
			'thread-list25' => 'Bốn',
			'thread-list20' => 'Năm',
		),
		$field_name['num_line'],
		$num_line
	);
	
	echo '</p>';
	
	
	//
	echo '<p>Status by: ';
	
	__eb_widget_load_select(
		$arr_eb_product_status,
		$field_name['post_eb_status'],
		$post_eb_status
	);
	
	echo '</p>';
	
	
	//
	echo '<p>Sort by: ';
	
	__eb_widget_load_select(
		array (
			'rand' => 'Random',
			'post_title' => 'Post title',
			'menu_order' => 'Post order',
			'ID' => 'Post ID',
		),
		$field_name['sortby'],
		$sortby
	);
	
	echo '</p>';
	
}

class ___echbay_widget_home_hot_content extends WP_Widget {
	function __construct() {
		parent::__construct ( 'eb_random_home_hot', 'EchBay home HOT', array (
				'description' => 'Tạo danh sách sản phẩm MỚI/ HOT cho trang chủ' 
		) );
	}
	
	function form($instance) {
		
		$default = array (
				'title' => 'EchBay home HOT',
				'sortby' => 'menu_order',
				'num_line' => '',
				'post_number' => 5,
				'cat_ids' => 0,
				'post_eb_status' => 0
		);
		$instance = wp_parse_args ( ( array ) $instance, $default );
		
		
		//
		$arr_field_name = array();
		foreach ( $default as $k => $v ) {
			$arr_field_name[ $k ] = $this->get_field_name ( $k );
		}
		
		_eb_product_form_for_widget( $instance, $arr_field_name );
		
		
		//
//		__eb_widget_load_cat_select ( $this->get_field_name ( 'cat_ids' ), $cat_ids, '', true );
		
		
		//
//		echo '<p>Title: <input type="text" class="widefat" name="' . $this->get_field_name ( 'title' ) . '" value="' . $title . '" placeholder="Default show this cat name" /></p>';
		
		
		//
//		echo '<p>Number of posts to show: <input type="number" class="tiny-text" name="' . $this->get_field_name ( 'post_number' ) . '" value="' . $post_number . '" min="1" max="30" size="3" /></p>';
		
		
		//
		/*
		echo '<p>Number of posts inline: ';
		
		__eb_widget_load_select(
			array(
				'' => 'Mặc định',
				'thread-list100' => 'Một',
				'thread-list50' => 'Hai',
				'thread-list33' => 'Ba',
				'thread-list25' => 'Bốn',
				'thread-list20' => 'Năm',
			),
			 $this->get_field_name ( 'num_line' ),
			$num_line
		);
		
		echo '</p>';
		*/
		
		
		//
		/*
		echo '<p>Status by: ';
		
		__eb_widget_load_select(
			$arr_eb_product_status,
			$this->get_field_name ( 'post_eb_status' ),
			$post_eb_status
		);
		
		echo '</p>';
		*/
		
		
		//
		/*
		echo '<p>Sort by: ';
		
		__eb_widget_load_select(
			array (
				'rand' => 'Random',
				'post_title' => 'Post title',
				'menu_order' => 'Post order',
				'ID' => 'Post ID',
			),
			 $this->get_field_name ( 'sortby' ),
			$sortby
		);
		
		echo '</p>';
		*/
		
	}
	
	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance ['title'] = strip_tags ( $new_instance ['title'] );
		$instance ['post_number'] = strip_tags ( $new_instance ['post_number'] );
		$instance ['sortby'] = strip_tags ( $new_instance ['sortby'] );
		$instance ['num_line'] = strip_tags ( $new_instance ['num_line'] );
		$instance ['cat_ids'] = strip_tags ( $new_instance ['cat_ids'] );
		$instance ['post_eb_status'] = strip_tags ( $new_instance ['post_eb_status'] );
		
		return $instance;
	}
	
	function widget($args, $instance) {
//		global $func;
		global $echbay_widget_i_set_home_product_bg;
		
		extract ( $args );
		
//		$title = apply_filters ( 'widget_title', $instance ['title'] );
		$title = isset( $instance ['title'] ) ? $instance ['title'] : '';
		$post_number = isset( $instance ['post_number'] ) ? $instance ['post_number'] : 0;
		if ( $post_number == 0 ) $post_number = 5;
		
		$sortby = isset( $instance ['sortby'] ) ? $instance ['sortby'] : '';
		$num_line = isset( $instance ['num_line'] ) ? $instance ['num_line'] : '';
		$cat_ids = isset( $instance ['cat_ids'] ) ? $instance ['cat_ids'] : 0;
		$post_eb_status = isset( $instance ['post_eb_status'] ) ? $instance ['post_eb_status'] : 0;
		
		//
		_eb_echo_widget_name( $this->name, $before_widget );
		
		//
		$___order = 'DESC';
		if ( $sortby == '' || $sortby == 'rand' ) {
			$___order = '';
		}
		
		//
		$args = array(
			'orderby' => $sortby,
			'order' => $___order,
		);
		
		
		//
		$str_home_hot = '';
		
		// nếu có phân nhóm -> lấy theo phân nhóm
		if ( $cat_ids > 0 ) {
			$args['cat'] = $cat_ids;
			
			// lấy thông tin phân nhóm luôn
			$categories = get_term_by('id', $cat_ids, 'category');
//			print_r( $categories );
		}
		
		// tìm theo trạng thái
		if ( $post_eb_status > 0 ) {
			$args['meta_key'] = '_eb_product_status';
			$args['meta_value'] = $post_eb_status;
		}
		
		//
		$str_home_hot = _eb_load_post( $post_number, $args );
		
		
		//
		if ( $str_home_hot == '' ) {
			$str_home_hot = '<li class="text-center"><em>post not found</em></li>';
		}
		
		
		
		//
		echo EBE_html_template( EBE_get_page_template( 'home_hot' ), array(
			'tmp.num_post_line' => $num_line,
			'tmp.home_hot_title' => $title,
			'tmp.home_hot' => $str_home_hot,
		) );
		
		
		//
		echo $after_widget;
	}
}



