<?php



/*
* Widget blog ngẫu nhiên
*/
class ___echbay_widget_set_adsense_code extends WP_Widget {
	function __construct() {
		parent::__construct ( 'echbay_set_adsense_code', 'zEchBay GAdsense', array (
				'description' => 'Nhúng mã Google Adsense vào website' 
		) );
	}
	
	function form($instance) {
		global $arr_to_add_menu;
		
		$default = array (
			'title' => 'Note',
//			'code' => ''
			'hide_quick_view' => ''
		);
		$instance = wp_parse_args ( ( array ) $instance, $default );
		foreach ( $instance as $k => $v ) {
			$$k = esc_attr ( $v );
		}
		
		
		//
		_eb_widget_echo_widget_input_title( $this->get_field_name('title'), $title );
		
		//
//		echo '<p><strong>Mã nhúng</strong>: <textarea class="widefat" name="' . $this->get_field_name('code') . '">' . $code . '</textarea></p>';
		
		//
		_eb_widget_echo_widget_input_checkbox( $this->get_field_name('hide_quick_view'), $hide_quick_view, 'Ẩn trong quick view', 'Một số mã không chạy trong iframe hoặc khi thẻ DIV tại đó bị ẩn thì, lúc này cần kích hoạt chức năng ẩn trong quick view để tính năng này tạm dừng' );
		
	}
	
	function update($new_instance, $old_instance) {
		$instance = _eb_widget_parse_args ( $new_instance, $old_instance );
		return $instance;
	}
	
	function widget($args, $instance) {
		global $__cf_row;
		global $act;
		global $arr_active_for_404_page;
		
		extract ( $args );
		
		// không hiển thị mã google adsense trong các trang 404
		if ( $act == '404' || isset( $arr_active_for_404_page[ $act ] ) ) {
			// phải thì thoát luôn
			echo '<!-- Google adsense disable in 404 -->';
			return false;
		}
		else {
			$hide_quick_view = isset( $instance ['hide_quick_view'] ) ? $instance ['hide_quick_view'] : 'off';
			// nếu tính năng ẩn trong quick view được kích hoạt
			if ( $hide_quick_view == 'on'
			// kiểm tra xem có phải đang xem trong quick view không
			&& isset( $_GET['set_module'] ) && $_GET['set_module'] == 'quick_view' ) {
				// phải thì thoát luôn
				echo '<!-- Google adsense disable in Quick view -->';
				return false;
			}
		}
		
//		$title = apply_filters ( 'widget_title', $instance ['title'] );
		$title = isset( $instance ['title'] ) ? $instance ['title'] : '';
		
//		$code = isset( $instance ['code'] ) ? $instance ['code'] : '';
		$code = trim( $__cf_row['cf_js_gadsense'] );
		
		// nếu không có mã cho phần này
		if ( $code == '' ) {
			// thử xem có ID không -> có thì gán luôn
			if ( $__cf_row['cf_gadsense_client_amp'] != '' && $__cf_row['cf_gadsense_slot_amp'] != '' ) {
				$code = '<br>
<div class="w99">
<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<ins class="adsbygoogle"
     style="display:block"
     data-ad-client="ca-pub-' . $__cf_row['cf_gadsense_client_amp'] . '"
     data-ad-slot="' . $__cf_row['cf_gadsense_slot_amp'] . '"
     data-ad-format="auto"></ins>
<script>
(adsbygoogle = window.adsbygoogle || []).push({});
</script>
</div>
<br>';
			}
			// không thì trả về lỗi
			else {
				echo '<!-- ' . $this->name . ' (cf_js_gadsense is NULL) -->';
				return false;
			}
		}
		
		
		//
//		_eb_echo_widget_name( $this->name, $before_widget );
		echo '<!-- ' . $this->name . ' (' . $title . ') -->';
		
		//
		echo $code;
	}
}




