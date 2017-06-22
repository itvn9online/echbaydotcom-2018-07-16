<?php




/*
* Widget danh mục sản phẩm hiện tại đang xem
*/
class ___echbay_widget_list_current_category extends WP_Widget {
	function __construct() {
		parent::__construct ( 'echbay_category', 'EchBay categories', array (
			'description' => 'Tạo danh sách danh mục sản phẩm hiện tại đang xem.' 
		) );
	}
	
	function form($instance) {
		global $arr_eb_category_status;
		
		//
		$default = array (
			'title' => 'EchBay category',
			'show_count' => '',
			'cat_ids' => 0,
			'cat_status' => 0,
			'cat_type' => 'category',
			'list_tyle' => '',
		);
		$instance = wp_parse_args ( ( array ) $instance, $default );
		foreach ( $instance as $k => $v ) {
			$$k = esc_attr ( $v );
		}
		/*
		$title = esc_attr ( $instance ['title'] );
		$cat_type = esc_attr ( $instance ['cat_type'] );
		$show_count = esc_attr ( $instance ['show_count'] );
		*/
		
		echo '<p>Title: <input type="text" class="widefat" name="' . $this->get_field_name ( 'title' ) . '" value="' . $title . '" /></p>';
		
		
		//
		$animate_id = __eb_widget_load_cat_select ( array(
			'cat_ids_name' => $this->get_field_name ( 'cat_ids' ),
			'cat_ids' => $cat_ids,
			'cat_type_name' => $this->get_field_name ( 'cat_type' ),
			'cat_type' => $cat_type,
		) );
		
		
		//
		/*
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
		*/
		
		/*
		// v2 -> tự động thay đổi taxonomy khi chọn nhóm
		echo '<p style="display:none;">Kiểu dữ liệu: <input type="text" class="widefat ' . $animate_id . '" name="' . $this->get_field_name ( 'cat_type' ) . '" value="' . $cat_type . '"/></p>';
		
		//
		echo '<script type="text/javascript">
		jQuery("#' . $animate_id . '").off("change").change(function () {
			var a = jQuery("#' . $animate_id . ' option:selected").attr("data-taxonomy") || "";
			if ( a == "" ) a = "category";
			console.log("Auto set taxonomy #" + a);
			jQuery(".' . $animate_id . '").val( a );
		});
		</script>';
		*/
		
		
		//
		echo '<p>Trạng thái danh mục: ';
		
		__eb_widget_load_select(
			$arr_eb_category_status,
			 $this->get_field_name ( 'cat_status' ),
			$cat_status
		);
		
		echo '</p>';
		
		
		//
		$input_name = $this->get_field_name ( 'show_count' );
//		echo $instance[ 'show_count' ];
		
		echo '<p><input type="checkbox" class="checkbox" id="' . $input_name . '" name="' . $input_name . '" ';
		checked( $instance[ 'show_count' ], 'on' );
		echo '><label for="' . $input_name . '">Hiện số bài viết</label></p>';
		
		
		//
		$input_name = $this->get_field_name ( 'list_tyle' );
//		echo $instance[ 'show_count' ];
		
		echo '<p><input type="checkbox" class="checkbox" id="' . $input_name . '" name="' . $input_name . '" ';
		checked( $instance[ 'list_tyle' ], 'on' );
		echo '><label for="' . $input_name . '">Hiển thị dưới dạng Select Box</label></p>';
		
	}
	
	function update($new_instance, $old_instance) {
		$instance = _eb_widget_parse_args ( $new_instance, $old_instance );
		return $instance;
	}
	
	function widget($args, $instance) {
//		global $func;
		
//		print_r( $instance );
		
		extract ( $args );
		
		$title = apply_filters ( 'widget_title', $instance ['title'] );
		$show_count = isset( $instance ['show_count'] ) ? $instance ['show_count'] : 'off';
//		echo $show_count;
		$show_count = $show_count == 'on' ? true : false;
		$cat_ids = isset( $instance ['cat_ids'] ) ? $instance ['cat_ids'] : 0;
		$cat_type = isset( $instance ['cat_type'] ) ? $instance ['cat_type'] : 'category';
		$cat_status = isset( $instance ['cat_status'] ) ? $instance ['cat_status'] : 0;
		$list_tyle = isset( $instance ['list_tyle'] ) ? $instance ['list_tyle'] : 'off';
		$list_tyle = $list_tyle == 'on' ? 'widget-category-selectbox' : '';
		
		//
		_eb_echo_widget_name( $this->name, $before_widget );
		
		//
		echo '<div class="' . $list_tyle . '">';
		
		//
		_eb_echo_widget_title( $title, 'echbay-widget-category-title', $before_title );
		
		//
		echo '<ul class="echbay-category-in-js">';
		
		//
		$arrs_cats = get_categories( array(
			'taxonomy' => $cat_type,
//			'hide_empty' => 0,
			'parent' => $cat_ids,
		) );
//		print_r($arrs_cats);
		
		// nếu hiển thị theo status được chỉ định -> dùng vòng lặp riêng
		if ( $cat_status > 0 ) {
			foreach ( $arrs_cats as $v ) {
				// lấy các nhóm có trạng thái như chỉ định
				if ( (int) _eb_get_post_meta( $v->term_id, '_eb_category_status', true, 0 ) == $cat_status ) {
					$hien_thi_sl = '';
					if ( $show_count == 'on' ) {
						$hien_thi_sl = ' (' . $v->count . ')';
					}
					
					//
					echo '<li class="cat-item cat-item-' . $v->term_id . '"><a data-taxonomy="' . $v->taxonomy . '" data-id="' . $v->term_id . '" data-parent="' . $cat_ids . '" data-node-id="' . $this->id . '" title="' . $v->name . '" href="' . _eb_c_link( $v->term_id ) . '" >' . $v->name . $hien_thi_sl . '</a></li>';
				}
			}
		}
		//
		else {
			foreach ( $arrs_cats as $v ) {
				$hien_thi_sl = '';
				if ( $show_count == 'on' ) {
					$hien_thi_sl = ' (' . $v->count . ')';
				}
				
				//
				echo '<li class="cat-item cat-item-' . $v->term_id . '"><a data-taxonomy="' . $v->taxonomy . '" data-id="' . $v->term_id . '" data-parent="' . $cat_ids . '" data-node-id="' . $this->id . '" title="' . $v->name . '" href="' . _eb_c_link( $v->term_id ) . '" >' . $v->name . $hien_thi_sl . '</a></li>';
			}
		}
		
		echo '</ul>';
		echo '</div>';
		
		//
		echo $after_widget;
	}
}




