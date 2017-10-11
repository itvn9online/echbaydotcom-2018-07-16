<?php



function EBE_widget_categories_get_child( $term_id, $cat_type, $show_count, $widget_id ) {
	$arrs_child_cats = get_categories( array(
		'taxonomy' => $cat_type,
		'parent' => $term_id,
	) );
//	print_r($arrs_child_cats);
	
	if ( count( $arrs_child_cats ) > 0 ) {
		echo '<ul class="sub-menu">';
		
		foreach ( $arrs_child_cats as $v2 ) {
			$hien_thi_sl = '';
			if ( $show_count == 'on' ) {
				$hien_thi_sl = ' (' . $v->count . ')';
			}
			
			echo '<li class="cat-item cat-item-' . $v2->term_id . '"><a data-taxonomy="' . $cat_type . '" data-id="' . $v2->term_id . '" data-parent="' . $term_id . '" data-node-id="' . $widget_id . '" title="' . $v2->name . '" href="' . _eb_c_link( $v2->term_id ) . '" >' . $v2->name . '</a></li>';
		}
		
		echo '</ul>';
	}
}


function EBE_widget_get_parent_cat ( $id, $cat_type = 'category' ) {
	if ( $id > 0 ) {
		$a = get_term_by( 'id', $id, $cat_type );
//		print_r( $a );
		
		// nếu không có nhóm cha -> nhóm này nhất rồi
		if ( $a->parent == 0 ) {
			return $a;
		} else {
			return EBE_widget_get_parent_cat ( $a->parent, $cat_type );
		}
	}
	
	return false;
}


// tạo câu lệnh select thủ công để kiểm tra post có tồn tại không
function WGR_custom_check_post_in_multi_taxonomy_v1 ( $cat1, $cat2 ) {
	global $wpdb;
	
	//
//	$strFilter = " AND `" . $wpdb->term_taxonomy . "`.term_id IN (" . $cat1 . ',' . $cat2 . ") ";
//	$strFilter = " AND `" . $wpdb->term_relationships . "`.term_id IN (" . $cat1 . ',' . $cat2 . ") ";
	$strFilter = " AND `" . $wpdb->posts . "`.ID IN ( select object_id from `" . $wpdb->term_relationships . "` " . $cat1 . ',' . $cat2 . ") ";
	
	//
	$joinFilter = " LEFT JOIN `" . $wpdb->term_relationships . "` ON ( `" . $wpdb->posts . "`.ID = `" . $wpdb->term_relationships . "`.object_id) ";
//	$joinFilter .= " LEFT JOIN `" . $wpdb->term_taxonomy . "` ON ( `" . $wpdb->term_relationships . "`.term_taxonomy_id = `" . $wpdb->term_taxonomy . "`.term_taxonomy_id ) ";
	$joinFilter = "";
	
	//
	$sql = "SELECT ID
	FROM
		`" . $wpdb->posts . "`
		" . $joinFilter . "
	WHERE
		`" . $wpdb->posts . "`.post_type = 'post'
		AND `" . $wpdb->posts . "`.post_status = 'publish'
		" . $strFilter . "
	ORDER BY
		`" . $wpdb->posts . "`.ID DESC
	LIMIT 0, 1";
	echo $sql . '<br>' . "\n";
	$sql = _eb_q( $sql );
	print_r( $sql );
	
	//
	if ( empty( $sql ) ) {
		return 0;
	}
	echo _eb_p_link( $sql[0]->ID ) . '<br>' . "\n";
	
	//
	return 1;
}

function WGR_custom_check_post_in_multi_taxonomy ( $cat1, $cat2 ) {
	global $wpdb;
	
	// lấy và chạy vòng lặp để so dữ liệu
	$sql = "SELECT object_id
	FROM
		`" . $wpdb->term_relationships . "`
	WHERE
		term_taxonomy_id IN (" . $cat1 . ',' . $cat2 . ")
	ORDER BY
		object_id DESC
	LIMIT 0, 5000";
//	echo $sql . '<br>' . "\n";
	$sql = _eb_q( $sql );
//	print_r( $sql );
	
	$num = 0;
	foreach ( $sql as $v ) {
		// dùng chính object_id để order -> chạy vòng lặp sẽ phát hiện ra sản phẩm trùng nhau luôn
		if ( $v->object_id == $num ) {
//			echo _eb_p_link( $v->object_id ) . '<br>' . "\n";
			return 1;
		}
		$num = $v->object_id;
	}
	
	//
	return 0;
	
	
	
	
	//
//	$strFilter = " AND `" . $wpdb->term_taxonomy . "`.term_id IN (" . $cat1 . ',' . $cat2 . ") ";
//	$strFilter = " AND `" . $wpdb->term_relationships . "`.term_id IN (" . $cat1 . ',' . $cat2 . ") ";
	$strFilter = " AND ID IN ( select object_id from `" . $wpdb->term_relationships . "` where term_taxonomy_id in (" . $cat1 . ',' . $cat2 . ") ) ";
	
	//
//	$joinFilter = " LEFT JOIN `" . $wpdb->term_relationships . "` ON ( `" . $wpdb->posts . "`.ID = `" . $wpdb->term_relationships . "`.object_id) ";
//	$joinFilter .= " LEFT JOIN `" . $wpdb->term_taxonomy . "` ON ( `" . $wpdb->term_relationships . "`.term_taxonomy_id = `" . $wpdb->term_taxonomy . "`.term_taxonomy_id ) ";
	$joinFilter = "";
	
	//
	$sql = "SELECT ID
	FROM
		`" . $wpdb->posts . "`
		" . $joinFilter . "
	WHERE
		post_type = 'post'
		AND post_status = 'publish'
		" . $strFilter . "
	ORDER BY
		ID DESC
	LIMIT 0, 1";
	echo $sql . '<br>' . "\n";
	$sql = _eb_q( $sql );
	print_r( $sql );
	
	//
	if ( empty( $sql ) ) {
		return 0;
	}
	echo _eb_p_link( $sql[0]->ID ) . '<br>' . "\n";
	
	//
	return 1;
}

function WGR_check_post_in_multi_taxonomy ( $a ) {

	print_r( $a );
	
	$sql_check = _eb_load_post_obj( 1, $a );
	print_r( $sql_check );
	echo count( $sql_check->posts ) . '<br>' . "\n";
	
	return count( $sql_check->posts );
//	wp_reset_postdata();
	
}



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
			'get_child' => '',
			'get_parent' => '',
			'show_for_search_advanced' => '',
			'dynamic_tag' => 'h2',
			'custom_style' => ''
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
		
//		echo '<p>Title: <input type="text" class="widefat" name="' . $this->get_field_name ( 'title' ) . '" value="' . $title . '" /></p>';
		_eb_widget_echo_widget_input_title( $this->get_field_name ( 'title' ), $title );
		
		
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
		
		_eb_widget_echo_widget_input_checkbox( $input_name, $instance[ 'show_count' ], 'Hiện số bài viết' );
		
		
		//
		$input_name = $this->get_field_name ( 'list_tyle' );
//		echo $instance[ 'list_tyle' ];
		
		_eb_widget_echo_widget_input_checkbox( $input_name, $instance[ 'list_tyle' ], 'Hiển thị dưới dạng Select Box' );
		
		
		//
		$input_name = $this->get_field_name ( 'get_child' );
//		echo $instance[ 'get_child' ];
		
		_eb_widget_echo_widget_input_checkbox( $input_name, $instance[ 'get_child' ], 'Lấy danh sách nhóm con' );
		
		
		
		//
		$input_name = $this->get_field_name ( 'get_parent' );
//		echo $instance[ 'get_child' ];
		
		_eb_widget_echo_widget_input_checkbox( $input_name, $instance[ 'get_parent' ], 'Tự tìm các nhóm cùng cha' );
		
		
		$input_name = $this->get_field_name ( 'show_for_search_advanced' );
//		echo $instance[ 'show_for_search_advanced' ];
		
		_eb_widget_echo_widget_input_checkbox( $input_name, $instance[ 'show_for_search_advanced' ], 'Chỉ hiện thị nhóm có sản phẩm (tìm kiếm nâng cao)' );
		
		
		//
		echo '<p>HTML tag cho tiêu đề: ';
		
		__eb_widget_load_select(
			array(
				'' => '[ Trống ]',
				'div' => 'DIV',
				'p' => 'P',
				'li' => 'LI',
				'h2' => 'H2',
				'h3' => 'H3',
				'h4' => 'H4',
				'h5' => 'H5',
				'h6' => 'H6'
			),
			 $this->get_field_name ( 'dynamic_tag' ),
			$dynamic_tag
		);
		
		echo '</p>';
		
		
		//
		echo '<p>Custom style: <input type="text" class="widefat" name="' . $this->get_field_name ( 'custom_style' ) . '" value="' . $custom_style . '" /></p>';
		
		
		//
		WGR_show_widget_name_by_title();
		
	}
	
	function update($new_instance, $old_instance) {
		$instance = _eb_widget_parse_args ( $new_instance, $old_instance );
		return $instance;
	}
	
	function widget($args, $instance) {
		global $cid;
//		global $eb_wp_taxonomy;
		
//		print_r( $instance );
		
		extract ( $args );
		
		$title = apply_filters ( 'widget_title', $instance ['title'] );
		
		$show_count = isset( $instance ['show_count'] ) ? $instance ['show_count'] : 'off';
//		echo $show_count;
		$show_count = ( $show_count == 'on' ) ? true : false;
		
		$cat_ids = isset( $instance ['cat_ids'] ) ? $instance ['cat_ids'] : 0;
		$cat_type = isset( $instance ['cat_type'] ) ? $instance ['cat_type'] : 'category';
		$cat_status = isset( $instance ['cat_status'] ) ? $instance ['cat_status'] : 0;
		
		$list_tyle = isset( $instance ['list_tyle'] ) ? $instance ['list_tyle'] : 'off';
		$list_tyle = ( $list_tyle == 'on' ) ? 'widget-category-selectbox' : '';
		$list_tyle .= ' widget-category-padding';
		
		$get_child = isset( $instance ['get_child'] ) ? $instance ['get_child'] : 'off';
		$get_child = ( $get_child == 'on' ) ? true : false;
		
		$get_parent = isset( $instance ['get_parent'] ) ? $instance ['get_parent'] : 'off';
		$get_parent = ( $get_parent == 'on' ) ? true : false;
		
		$show_for_search_advanced = isset( $instance ['show_for_search_advanced'] ) ? $instance ['show_for_search_advanced'] : 'off';
		$show_for_search_advanced = ( $show_for_search_advanced == 'on' ) ? true : false;
		
		$dynamic_tag = isset( $instance ['dynamic_tag'] ) ? $instance ['dynamic_tag'] : '';
		$dynamic_tag_begin = '';
		$dynamic_tag_end = '';
		if ( $dynamic_tag != '' ) {
			$dynamic_tag_begin = '<' . $dynamic_tag . '>';
			$dynamic_tag_end = '</' . $dynamic_tag . '>';
		}
		
		$custom_style = isset( $instance ['custom_style'] ) ? $instance ['custom_style'] : '';
		
		
		//
		$cats_info = NULL;
		
		// tự động lấy danh mục cùng nhóm
		// nếu không có nhóm được chỉ định
		// thuộc tính tự động tìm nhóm được thiết lập
		if ( $cat_ids == 0 && $get_parent == true ) {
//			global $cid;
			
			$cats_info = EBE_widget_get_parent_cat( $cid, $cat_type );
//			print_r( $cats_info );
			
			if ( ! empty ( $cats_info ) ) {
				$cat_ids = $cats_info->term_id;
			}
//			echo $cat_ids;
		} else if ( $cat_ids > 0 ) {
			$cats_info = EBE_widget_get_parent_cat( $cat_ids, $cat_type );
		}
		
		
		// lấy danh sách nhóm chính
		$arrs_cats = get_categories( array(
			'taxonomy' => $cat_type,
//			'hide_empty' => 0,
			'parent' => $cat_ids,
		) );
		
		// nếu có lệnh kiểm tra sản phẩm tồn tại -> kiểm tra theo CID
//		if ( mtv_id == 1 ) {
//		print_r($arrs_cats);
		
		if ( $show_for_search_advanced == true && $cid > 0 ) {
//			$get_taxonomy_name = get_term_by( 'id', $cid, $eb_wp_taxonomy );
//			print_r( $get_taxonomy_name );
			
			//
			foreach ( $arrs_cats as $k => $v ) {
				if ( WGR_custom_check_post_in_multi_taxonomy( $cid, $v->term_id ) == 0 ) {
					$arrs_cats[$k] = NULL;
				}
			}
			
			
			/*
			//
			$arr_check_post = array();
//			$arr_check_post['orderby'] = 'ID';
			
			// nếu nhóm hiện tại là category -> nạp mặc định
			if ( $eb_wp_taxonomy == 'category' ) {
				if ( $cat_type == 'category' ) {
					foreach ( $arrs_cats as $k => $v ) {
						$arr_check_post['category__in'] = array( $cid, $v->term_id );
						
						if ( WGR_check_post_in_multi_taxonomy( $arr_check_post ) == 0 ) {
							$arrs_cats[$k] = NULL;
						}
					}
				}
				else {
					$arr_check_post['cat'] = $cid;
					foreach ( $arrs_cats as $k => $v ) {
						$arr_check_post['tax_query'] = array( array(
							'taxonomy' => $cat_type,
							'field' => 'term_id',
							'terms' => $v->term_id,
							'operator' => 'IN'
						) );
						
						if ( WGR_check_post_in_multi_taxonomy( $arr_check_post ) == 0 ) {
							$arrs_cats[$k] = NULL;
						}
					}
				}
			}
			else {
				if ( $cat_type == 'category' ) {
				}
				else {
				}
			}
			*/
//			print_r( $arr_check_post );
			
//			echo 'bbbbbbbbbbb';
//			print_r($arrs_cats);
		}
		
//		}
		
		
		
		//
		if ( $cats_info != NULL && $title == '' ) {
			$title = $cats_info->name;
		}
		
		
		
		//
		_eb_echo_widget_name( $this->name, $before_widget );
		
		//
		echo '<div class="' . trim( $list_tyle . ' ' . $custom_style ) . '">';
		
		//
		_eb_echo_widget_title( $title, 'echbay-widget-category-title', $before_title );
		
		//
		echo '<ul class="echbay-category-in-js">';
		
		
		
		// nếu hiển thị theo status được chỉ định -> dùng vòng lặp riêng
		if ( $cat_status > 0 ) {
			foreach ( $arrs_cats as $v ) {
				// lấy các nhóm có trạng thái như chỉ định
				if ( $v != NULL && (int) _eb_get_post_meta( $v->term_id, '_eb_category_status', true, 0 ) == $cat_status ) {
					$hien_thi_sl = '';
					if ( $show_count == 'on' ) {
						$hien_thi_sl = ' (' . $v->count . ')';
					}
					
					//
					echo '<li class="cat-item cat-item-' . $v->term_id . '">' . $dynamic_tag_begin . '<a data-taxonomy="' . $v->taxonomy . '" data-id="' . $v->term_id . '" data-parent="' . $cat_ids . '" data-node-id="' . $this->id . '" title="' . $v->name . '" href="' . _eb_c_link( $v->term_id ) . '" >' . $v->name . $hien_thi_sl . '</a>' . $dynamic_tag_end;
					
					//
					if ( $get_child == true ) {
						EBE_widget_categories_get_child( $v->term_id, $cat_type, $show_count, $this->id );
					}
					
					echo '</li>';
				}
			}
		}
		//
		else {
			foreach ( $arrs_cats as $v ) {
				if ( $v != NULL ) {
					$hien_thi_sl = '';
					if ( $show_count == 'on' ) {
						$hien_thi_sl = ' (' . $v->count . ')';
					}
					
					//
					echo '<li class="cat-item cat-item-' . $v->term_id . '">' . $dynamic_tag_begin . '<a data-taxonomy="' . $cat_type . '" data-id="' . $v->term_id . '" data-parent="' . $cat_ids . '" data-node-id="' . $this->id . '" title="' . $v->name . '" href="' . _eb_c_link( $v->term_id ) . '" >' . $v->name . $hien_thi_sl . '</a>' . $dynamic_tag_end;
					
					//
					if ( $get_child == true ) {
						EBE_widget_categories_get_child( $v->term_id, $cat_type, $show_count, $this->id );
					}
					
					echo '</li>';
				}
			}
		}
		
		echo '</ul>';
		echo '</div>';
		
		//
		echo $after_widget;
	}
}




