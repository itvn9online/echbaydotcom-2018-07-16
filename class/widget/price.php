<?php



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
			'min_price' => '0',
			'max_price' => '1000000',
			'line_price' => 5,
			'custom_price' => '',
			'show_for_search_advanced' => '',
			'list_tyle' => '',
		);
		$instance = wp_parse_args ( ( array ) $instance, $default );
		foreach ( $instance as $k => $v ) {
			$$k = esc_attr ( $v );
		}
		
		echo '<p>Title: <input type="text" class="widefat" name="' . $this->get_field_name ( 'title' ) . '" value="' . $title . '" /></p>';
		
		echo '<hr>';
		
		echo '<p>Min price: <input type="number" class="widefat" name="' . $this->get_field_name ( 'min_price' ) . '" value="' . $min_price . '" placeholder="0" /></p>';
		
		echo '<p>Max price: <input type="number" class="widefat" name="' . $this->get_field_name ( 'max_price' ) . '" value="' . $max_price . '" placeholder="1000000" /></p>';
		
		echo '<p>Number of line: <input type="number" class="widefat" name="' . $this->get_field_name ( 'line_price' ) . '" value="' . $line_price . '" placeholder="5" />
		<span class="small">Nhập vào giá trị nhỏ nhất (mặc định là 0) và giá trị lớn nhất, hệ thống sẽ tự tính toán các bước giá theo hệ số tiền: 10, 20, 50 và hiển thị tương ứng.</span></p>';
		
		echo '<hr>';
		
		//
		echo '<p>Custom price: <textarea class="widefat" name="' . $this->get_field_name ( 'custom_price' ) . '" placeholder="Can enter multiple price, each price separated by a newline (press Enter)." style="height: 110px;">' . $custom_price . '</textarea>
		<span class="small">Để chủ động trong việc tạo khoảng giá, có thể tự nhập các khoảng ở đây, mỗi khoảng cách nhau bởi dấu xuống dòng. VD:<br>
		1000000<br>
		2000000<br>
		3000000</span></p>';
		
		
		//
		$input_name = $this->get_field_name ( 'list_tyle' );
//		echo $instance[ 'list_tyle' ];
		
		_eb_widget_echo_widget_input_checkbox( $input_name, $instance[ 'list_tyle' ], 'Hiển thị dưới dạng Select Box' );
		
		
		$input_name = $this->get_field_name ( 'show_for_search_advanced' );
//		echo $instance[ 'show_for_search_advanced' ];
		
		_eb_widget_echo_widget_input_checkbox( $input_name, $instance[ 'show_for_search_advanced' ], 'Tự động lấy khoảng giá tối đa (tìm kiếm nâng cao) <span class="redcolor small d-block">* Tính năng này có thể làm chậm website của bạn!</span>' );
		
	}
	
	function update($new_instance, $old_instance) {
		$instance = _eb_widget_parse_args ( $new_instance, $old_instance );
		return $instance;
	}
	
	function widget($args, $instance) {
		global $cid;
		global $wpdb;
		
		extract ( $args );
		
		$title = apply_filters ( 'widget_title', $instance ['title'] );
		$min_price = isset( $instance ['min_price'] ) ? $instance ['min_price'] : 0;
		$max_price = isset( $instance ['max_price'] ) ? $instance ['max_price'] : 1000000;
		$line_price = isset( $instance ['line_price'] ) ? $instance ['line_price'] : 5;
		$custom_price = isset( $instance ['custom_price'] ) ? $instance ['custom_price'] : '';
//		echo $custom_price;
		
		$list_tyle = isset( $instance ['list_tyle'] ) ? $instance ['list_tyle'] : 'off';
		$list_tyle = ( $list_tyle == 'on' ) ? 'widget-category-selectbox' : '';
		$list_tyle .= ' widget-category-padding';
		
		$show_for_search_advanced = isset( $instance ['show_for_search_advanced'] ) ? $instance ['show_for_search_advanced'] : 'off';
		$show_for_search_advanced = ( $show_for_search_advanced == 'on' ) ? true : false;
		
		//
		_eb_echo_widget_name( $this->name, $before_widget );
//		echo $custom_price;
		
		
		
		
		// lấy giá lớn nhất theo mỗi nhóm
		$max_price_by_category = 0;
//		if ( mtv_id == 1 ) {
		
		if ( $show_for_search_advanced == true && $cid > 0 ) {
			// lấy giá lớn nhất của sản phẩm -> phải convert meta_value sang number mới lấy được
			// https://stackoverflow.com/questions/5417381/mysql-sort-string-number
			$sql = "SELECT post_id, meta_value
			FROM
				`" . $wpdb->postmeta . "`
			WHERE
				meta_key = '_eb_product_price'
				AND post_id IN ( select ID
								from
									`" . wp_posts . "`
								where
									post_type = 'post'
									and post_status = 'publish'
									and ID in ( select object_id
												from
													`" . $wpdb->term_relationships . "`
												where
													term_taxonomy_id = " . $cid . " )
								)
			ORDER BY
				meta_value * 1 DESC
			LIMIT 0, 1";
//			echo $sql . '<br>' . "\n";
			$sql = _eb_q( $sql );
//			print_r( $sql );
			
			if ( ! empty( $sql ) ) {
//				echo _eb_p_link( $sql[0]->post_id ) . '<br>' . "\n";
				
				$max_price_by_category = $sql[0]->meta_value;
			}
		}
//		echo number_format( $max_price_by_category ) . '<br>' . "\n";
		
//		}
		
		
		
		
		//
		echo '<div class="' . trim( $list_tyle ) . '">';
		
		//
		_eb_echo_widget_title( $title, 'echbay-widget-price-title', $before_title );
//		echo $custom_price;
		
		//
		echo '<ul class="echbay-product-price-between">';
		
		//
		echo '<li><a href="#" data-price="">Tất cả khoảng giá</a></li>';
		
		
		
		// giá tối đa tự động
		if ( $max_price_by_category > 0 && $max_price > $max_price_by_category ) {
			$max_price = $max_price_by_category;
		}
		
		// lấy khoảng giá
		$trung_binh = $max_price/ $line_price;
		$first_price = 0;
		
		
		//
		$j = 0;
//		echo $custom_price;
		
		// Tạo giá thủ công
		if ( $custom_price != '' ) {
			$custom_price = explode( "\n", $custom_price );
//			print_r($custom_price);
			
			foreach ( $custom_price as $v ) {
				$v = _eb_number_only( $v );
				
				// nếu gặp khoảng giá tối đa rồi thì bỏ qua luôn
				if ( $max_price_by_category > 0 && $v > $max_price_by_category ) {
					break;
				}
				
				//
				if ( $v > 0 ) {
					// Bắt đầu
					if ( $j == 0 ) {
						echo '<li><a href="#" data-price="' . $v . '">Dưới <span class="ebe-currency">' . number_format( $v )  . '</span></a></li>';
						
						$first_price = $v;
					}
					// trong khoảng
//					else if ( $v < $max_price ) {
					else {
						echo '<li><a href="#" data-price="' . $first_price . '-' . $v . '"><span class="ebe-currency">' . number_format( $first_price ) . '</span> - <span class="ebe-currency">' . number_format( $v ) . '</span></a></li>';
						
						$first_price = $v;
					}
					$j++;
					/*
				} else {
					echo $v . "<br>";
					*/
				}
			}
			
			// bonus thêm giá cuối
			echo '<li><a href="#" data-price="-' . $first_price . '">Trên <span class="ebe-currency">' . number_format( $first_price )  . '</span></a></li>';
			
		}
		// Tạo giá tự động
		else {
			
			//
			$arr_list_price = array(
				10,
				20,
//				30,
//				40,
				50
			);
			for ( $i = 0; $i < 25; $i++ ) {
				$a = $arr_list_price[$i] * 10;
				if ( $a > $max_price ) {
					break;
				}
				
				$arr_list_price[] = $a;
			}
//			print_r( $arr_list_price );
//			echo number_format( $trung_binh ) . '<br>' . "\n";
			
			//
			foreach ( $arr_list_price as $k => $v ) {
				if ( $v >= $trung_binh ) {
					// Bắt đầu
					if ( $j == 0 ) {
						echo '<li><a href="#" data-price="' . $v . '">Dưới <span class="ebe-currency">' . number_format( $v )  . '</span></a></li>';
						
						$first_price = $v;
					}
					// trong khoảng
					else if ( $v < $max_price ) {
						echo '<li><a href="#" data-price="' . $first_price . '-' . $v . '"><span class="ebe-currency">' . number_format( $first_price ) . '</span> - <span class="ebe-currency">' . number_format( $v ) . '</span></a></li>';
						
						$first_price = $v;
					}
					// kết thúc
					/*
					else {
						// chuẩn bị kết thúc
						echo '<li><a href="#" data-price="' . $first_price . '-' . $max_price . '"><span class="ebe-currency">' . number_format( $first_price ) . '</span> - <span class="ebe-currency">' . number_format( $max_price ) . '</span></a></li>';
						
						// bonus thêm giá cuối
						echo '<li><a href="#" data-price="-' . $max_price . '">Trên <span class="ebe-currency">' . number_format( $max_price )  . '</span></a></li>';
						
						// thoát
						break;
					}
					*/
					
					$j++;
				}
			}
			
			// bonus thêm giá cuối
			echo '<li><a href="#" data-price="-' . $first_price . '">Trên <span class="ebe-currency">' . number_format( $first_price )  . '</span></a></li>';
			
		}
		
		
		//
		echo '</ul>';
		echo '</div>';
		
		//
		echo $after_widget;
	}
}




