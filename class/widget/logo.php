<?php



/*
* Widget blog ngẫu nhiên
*/
class ___echbay_widget_logo_favicon extends WP_Widget {
	function __construct() {
		parent::__construct ( 'get_logo_favicon', 'zEchBay Logo', array (
				'description' => 'Thiết lập Logo và Favicon cho website' 
		) );
	}
	
	function form($instance) {
		global $arr_to_add_menu;
		
		$default = array (
			'title' => 'EchBay Logo',
			'logo' => '',
//			'favicon' => '',
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
		
		
		_eb_widget_echo_widget_input_title( $this->get_field_name ( 'logo' ), $logo, 'Logo:' );
		
		
//		_eb_widget_echo_widget_input_title( $this->get_field_name ( 'favicon' ), $favicon, 'Favicon:' );
		
		
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
		global $__cf_row;
		
		extract ( $args );
		
//		$title = apply_filters ( 'widget_title', $instance ['title'] );
		$title = isset( $instance ['title'] ) ? $instance ['title'] : '';
		if ( $title == '' ) $title = web_name;
		$logo = isset( $instance ['logo'] ) ? $instance ['logo'] : '';
		if ( $logo == '' ) $logo = $__cf_row['cf_logo'];
//		$favicon = isset( $instance ['favicon'] ) ? $instance ['favicon'] : '';
		$width = isset( $instance ['width'] ) ? $instance ['width'] : '';
		$custom_style = isset( $instance ['custom_style'] ) ? $instance ['custom_style'] : '';
		
		$hide_mobile = isset( $instance ['hide_mobile'] ) ? $instance ['hide_mobile'] : 'off';
		$hide_mobile = $hide_mobile == 'on' ? ' hide-if-mobile' : '';
		
		
		//
//		_eb_echo_widget_name( $this->name, $before_widget );
		echo '<!-- ' . $this->name . ' -->';
		
		//
		echo '<div class="lf top-footer-css ' . $width . $hide_mobile . '">';
		
		//
//		_eb_echo_widget_title( $title, 'echbay-widget-blogs-title', $before_title );
		
		
		//
		echo '<div class="' . $custom_style . '">';
		
		echo '<a title="' . $title . '" href="' . web_link . '" class="web-logo d-block" style="background-image:url(\'' . $logo . '\');">&nbsp;</a>';
		
		echo '</div>';
		echo '</div>';
		
		//
//		echo $after_widget;
	}
}




