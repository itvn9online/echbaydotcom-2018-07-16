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
		);
		$instance = wp_parse_args ( ( array ) $instance, $default );
		foreach ( $instance as $k => $v ) {
			$$k = esc_attr ( $v );
		}
		
		echo '<p>Title: <input type="text" class="widefat" name="' . $this->get_field_name ( 'title' ) . '" value="' . $title . '" /></p>';
		
		echo '<p>Min price: <input type="number" class="widefat" name="' . $this->get_field_name ( 'min_price' ) . '" value="' . $min_price . '" placeholder="0" /></p>';
		
		echo '<p>Max price: <input type="number" class="widefat" name="' . $this->get_field_name ( 'max_price' ) . '" value="' . $max_price . '" placeholder="1000000" /></p>';
		
		echo '<p>Number of line: <input type="number" class="widefat" name="' . $this->get_field_name ( 'line_price' ) . '" value="' . $line_price . '" placeholder="5" />
		Nhập vào giá trị nhỏ nhất (mặc định là 0) và giá trị lớn nhất, hệ thống sẽ tự tính toán các bước giá theo hệ số tiền: 10, 20, 50 và hiển thị tương ứng.</p>';
		
		//
		echo '<p>Custom price: <textarea class="widefat" name="' . $this->get_field_name ( 'custom_price' ) . '" placeholder="Can enter multiple price, each price separated by a newline (press Enter)." style="height: 150px;">' . $custom_price . '</textarea>
		Để chủ động trong việc tạo khoảng giá, có thể tự nhập các khoảng ở đây, mỗi khoảng cách nhau bởi dấu xuống dòng. VD:<br>
		1000000<br>
		2000000<br>
		3000000<br>
		5000000<br>
		10000000</p>';
	}
	
	function update($new_instance, $old_instance) {
		$instance = _eb_widget_parse_args ( $new_instance, $old_instance );
		return $instance;
	}
	
	function widget($args, $instance) {
//		global $func;
		
		extract ( $args );
		
		$title = apply_filters ( 'widget_title', $instance ['title'] );
		$min_price = isset( $instance ['min_price'] ) ? $instance ['min_price'] : 0;
		$max_price = isset( $instance ['max_price'] ) ? $instance ['max_price'] : 1000000;
		$line_price = isset( $instance ['line_price'] ) ? $instance ['line_price'] : 5;
		$custom_price = isset( $instance ['custom_price'] ) ? $instance ['custom_price'] : '';
//		echo $custom_price;
		
		//
		_eb_echo_widget_name( $this->name, $before_widget );
//		echo $custom_price;
		
		//
		_eb_echo_widget_title( $title, 'echbay-widget-price-title', $before_title );
//		echo $custom_price;
		
		//
		echo '<ul class="echbay-product-price-between">';
		
		//
		echo '<li><a href="#" data-price="">Tất cả khoảng giá</a></li>';
		
		
		// lấy khoảng giá
		$trung_binh = $max_price/ $line_price;
		$first_price = 0;
		
		//
		$arr_list_price = array(
			10,
			20,
			50
		);
		for ( $i = 0; $i < 25; $i++ ) {
			$arr_list_price[] = $arr_list_price[$i] * 10;
		}
//		print_r( $arr_list_price );
		
		//
		$j = 0;
//		echo $custom_price;
		
		// Tạo giá thủ công
		if ( $custom_price != '' ) {
			$custom_price = explode( "\n", $custom_price );
//			print_r($custom_price);
			
			foreach ( $custom_price as $v ) {
				$v = _eb_number_only( $v );
				
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
					else {
						// chuẩn bị kết thúc
						echo '<li><a href="#" data-price="' . $first_price . '-' . $max_price . '"><span class="ebe-currency">' . number_format( $first_price ) . '</span> - <span class="ebe-currency">' . number_format( $max_price ) . '</span></a></li>';
						
						// bonus thêm giá cuối
						echo '<li><a href="#" data-price="-' . $max_price . '">Trên <span class="ebe-currency">' . number_format( $max_price )  . '</span></a></li>';
						
						// thoát
						break;
					}
					
					$j++;
				}
			}
		}
		
		
		//
		echo '</ul>';
		
		//
		echo $after_widget;
	}
}




