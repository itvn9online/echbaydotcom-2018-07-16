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
//		global $str_fpr_license_echbay;
//		global $year_curent;
		global $str_footer_echbay_license;
		
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
		
		$full_mobile = isset( $instance ['full_mobile'] ) ? $instance ['full_mobile'] : 'off';
		if ( $full_mobile == 'on' ) $width .= ' fullsize-if-mobile';
		
		
		//
//		_eb_echo_widget_name( $this->name, $before_widget );
		echo '<!-- ' . $this->name . ' -->';
		
		//
		echo '<div class="' . str_replace( '  ', ' ', trim( 'top-footer-css ' . $width ) ) . '">';
		
		//
//		_eb_echo_widget_title( $title, 'echbay-widget-blogs-title', $before_title );
		
		
		//
		echo '<div class="' . str_replace( '  ', ' ', trim( 'footer-site-info ' . $custom_style ) ) . '">' . $str_footer_echbay_license . '</div>';
//		echo '<div class="' . str_replace( '  ', ' ', trim( 'footer-site-info ' . $custom_style ) ) . '">' . EBE_get_lang('copyright') . ' &copy; ' . $year_curent . ' <span>' . $title . '</span> - ' . EBE_get_lang('allrights') . '. ' . $str_fpr_license_echbay . '</div>';
		
		echo '</div>';
		
		//
//		echo $after_widget;
	}
}




