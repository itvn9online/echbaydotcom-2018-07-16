<?php



/*
* Widget blog ngẫu nhiên
*/
class ___echbay_widget_set_copyright extends WP_Widget {
	function __construct() {
		parent::__construct ( 'echbay_set_copyright', 'zEchBay Copyright', array (
				'description' => 'Nhúng menu copyright (Cung cấp bởi ***) vào website' 
		) );
	}
	
	function form($instance) {
		$default = array (
			'title' => 'EchBay.com',
			'width' => '',
			'custom_style' => '',
			'hide_mobile' => ''
		);
		$instance = wp_parse_args ( ( array ) $instance, $default );
		foreach ( $instance as $k => $v ) {
			$$k = esc_attr ( $v );
		}
		
		
		
		//
		_eb_widget_echo_widget_input_title( $this->get_field_name ( 'title' ), $title );
		
		
		//
		_eb_menu_width_form_for_widget( $this->get_field_name ( 'width' ), $width );
		
		
		//
		_eb_widget_echo_widget_input_title( $this->get_field_name ( 'custom_style' ), $custom_style, 'Custom CSS:' );
		
		
		_eb_widget_echo_widget_hide_mobile( $this->get_field_name ( 'hide_mobile' ), $hide_mobile );
		
	}
	
	function update($new_instance, $old_instance) {
		$instance = _eb_widget_parse_args ( $new_instance, $old_instance );
		return $instance;
	}
	
	function widget($args, $instance) {
		global $str_fpr_license_echbay;
		global $year_curent;
		
		extract ( $args );
		
//		$title = apply_filters ( 'widget_title', $instance ['title'] );
		$title = isset( $instance ['title'] ) ? $instance ['title'] : '';
		if ( $title == '' ) $title = web_name;
		
		$width = isset( $instance ['width'] ) ? $instance ['width'] : '';
		if ( $width != '' ) $width .= ' lf';
		
		$custom_style = isset( $instance ['custom_style'] ) ? $instance ['custom_style'] : '';
		
		$hide_mobile = isset( $instance ['hide_mobile'] ) ? $instance ['hide_mobile'] : 'off';
//		$hide_mobile = $hide_mobile == 'on' ? ' hide-if-mobile' : '';
		if ( $hide_mobile == 'on' ) $width .= ' hide-if-mobile';
		
		
		//
//		_eb_echo_widget_name( $this->name, $before_widget );
		echo '<!-- ' . $this->name . ' -->';
		
		//
		echo '<div class="top-footer-css ' . $width . '">';
		
		//
//		_eb_echo_widget_title( $title, 'echbay-widget-blogs-title', $before_title );
		
		
		//
		echo '<div class="footer-site-info ' . $custom_style . '">Bản quyền &copy; ' . $year_curent . ' <span>' . $title . '</span> - Toàn bộ phiên bản. ' . $str_fpr_license_echbay . '</div>';
		
		echo '</div>';
		
		//
//		echo $after_widget;
	}
}




