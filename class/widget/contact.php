<?php



/*
* Widget blog ngẫu nhiên
*/
class ___echbay_widget_set_contact_menu extends WP_Widget {
	function __construct() {
		parent::__construct ( 'echbay_set_contact_menu', 'zEchBay Footer Contact', array (
				'description' => 'Tạo khối thông tin liên hệ cho chân trang' 
		) );
	}
	
	function form($instance) {
		global $arr_to_add_menu;
		
		$default = array (
			'title' => 'EchBay Footer Contact',
			'width' => '',
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
		
	}
	
	function update($new_instance, $old_instance) {
		$instance = _eb_widget_parse_args ( $new_instance, $old_instance );
		return $instance;
	}
	
	function widget($args, $instance) {
		
		global $__cf_row;
		
		extract ( $args );
		
//		$title = apply_filters ( 'widget_title', $instance ['title'] );
		$title = isset( $instance ['title'] ) ? $instance ['title'] : '';
		
		$width = isset( $instance ['width'] ) ? $instance ['width'] : '';
		if ( $width != '' ) $width .= ' lf';
		
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
		echo '<div class="' . str_replace( '  ', ' ', trim( 'top-footer-css ' . $width ) ) . '">';
		
		//
		echo '<div class="' . str_replace( '  ', ' ', trim( 'footer-contact ' . $custom_style ) ) . '">';
		
		//
		echo EBE_get_html_address();
		
		/*
		echo '
		<div class="footer-contact-title">' . $__cf_row['cf_ten_cty'] . '</div>
		<ul class="footer-contact-content">
			<li><strong>Địa chỉ:</strong> <i class="fa fa-map-marker"></i> ' . nl2br( $__cf_row['cf_diachi'] ) . '</li>
			<li><strong>Điện thoại:</strong> <i class="fa fa-phone"></i> ' . $__cf_row['cf_call_hotline'] . ' - <span class="phone-numbers-inline">' . $__cf_row['cf_call_dienthoai'] . '</span></li>
			<li><strong>Email:</strong> <i class="fa fa-envelope-o"></i> <a href="mailto:' . $__cf_row['cf_email'] . '" rel="nofollow" target="_blank">' . $__cf_row['cf_email'] . '</a></li>
		</ul>';
		*/
		
		//
		echo '</div>';
		
		echo '</div>';
		
		//
//		echo $after_widget;
	}
}




