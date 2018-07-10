<?php



/*
* Widget blog ngẫu nhiên
*/
class ___echbay_widget_get_menu extends WP_Widget {
	function __construct() {
		parent::__construct ( 'get_echbay_menu', 'zEchBay Menu', array (
				'description' => 'Lấy menu tương ứng để gán vào widget' 
		) );
	}
	
	function form($instance) {
		global $arr_to_add_menu;
		
		$default = array (
			'title' => 'EchBay Menu',
			'menu' => '',
			'width' => '',
			'tag_menu' => '',
			'custom_style' => '',
			'full_mobile' => '',
			'hide_mobile' => ''
		);
		$instance = wp_parse_args ( ( array ) $instance, $default );
		foreach ( $instance as $k => $v ) {
			$$k = esc_attr ( $v );
		}
		
		//
		$arr_field_name = array();
		foreach ( $default as $k => $v ) {
			$arr_field_name[ $k ] = $this->get_field_name ( $k );
		}
		
		
		// form dùng chung cho phần top, footer
		_eb_top_footer_form_for_widget( $instance, $arr_field_name );
		
		
		//
		__eb_widget_load_select( array( '' => '[ Chọn menu hiển thị ]' ) + $arr_to_add_menu, $this->get_field_name ( 'menu' ), $menu );
		
		
		//
		_eb_widget_echo_widget_input_title( $this->get_field_name ( 'tag_menu' ), $tag_menu, 'Tag HTML:' );
		echo '<p><em>* Thường dùng cho footer. Nhập vào tag HTML để lấy cả tên menu. Ví dụ:</em><br>
		<strong>div class="footer-title upper"</strong><br>
		<em>(không bao gồm cặp dấu <strong>&lt;&gt;</strong>)</em></p>';
		
	}
	
	function update($new_instance, $old_instance) {
		$instance = _eb_widget_parse_args ( $new_instance, $old_instance );
		return $instance;
	}
	
	function widget($args, $instance) {
//		global $func;
		
		extract ( $args );
		
//		$title = apply_filters ( 'widget_title', $instance ['title'] );
		$title = isset( $instance ['title'] ) ? $instance ['title'] : '';
		$menu = isset( $instance ['menu'] ) ? $instance ['menu'] : '';
		$width = isset( $instance ['width'] ) ? $instance ['width'] : '';
		if ( $width != '' ) $width .= ' lf';
		
		$tag_menu = isset( $instance ['tag_menu'] ) ? trim( $instance ['tag_menu'] ) : '';
		$tag_end_menu = '';
		if ( $tag_menu != '' ) {
			$tag_menu = str_replace( '<', '', $tag_menu );
			$tag_menu = str_replace( '>', '', $tag_menu );
			
			//
			$tag_end_menu = explode( ' ', $tag_menu );
			$tag_end_menu = '</' . $tag_end_menu[0] . '>';
			
			$tag_menu = '<' . $tag_menu . '>';
		}
		
		$custom_style = isset( $instance ['custom_style'] ) ? $instance ['custom_style'] : '';
		
		$hide_mobile = isset( $instance ['hide_mobile'] ) ? $instance ['hide_mobile'] : 'off';
//		$hide_mobile = $hide_mobile == 'on' ? ' hide-if-mobile' : '';
		if ( $hide_mobile == 'on' ) $width .= ' hide-if-mobile';
		
		$full_mobile = isset( $instance ['full_mobile'] ) ? $instance ['full_mobile'] : 'off';
		if ( $full_mobile == 'on' ) $width .= ' fullsize-if-mobile';
		
		
		//
//		_eb_echo_widget_name( $this->name, $before_widget );
		echo '<!-- ' . $this->name . ' -->';
		
		
		//
		echo '<div class="' . $custom_style . '">';
		
		//
		echo '<div class="' . str_replace( '  ', ' ', trim( 'eb-widget-menu top-footer-css ' . $width ) ) . '">';
		
		//
//		if ( $title != '' ) {
			_eb_echo_widget_title( $title, 'echbay-widget-blogs-title', $before_title );
//		}
		
		if ( $menu != '' ) {
			echo _eb_echbay_menu( $menu, array(), 0, $tag_menu, $tag_end_menu );
		} else {
			echo 'Select menu for widget';
		}
		
		//
		echo '</div>';
		echo '</div>';
		
		//
//		echo $after_widget;
	}
}




