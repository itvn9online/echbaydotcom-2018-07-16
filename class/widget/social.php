<?php



/*
* Widget blog ngẫu nhiên
*/
class ___echbay_widget_set_social_menu extends WP_Widget {
	function __construct() {
		parent::__construct ( 'echbay_set_social_menu', 'zEchBay Social', array (
				'description' => 'Tạo khối icon mạng xã hội' 
		) );
	}
	
	function form($instance) {
		global $arr_to_add_menu;
		
		$default = array (
			'title' => 'EchBay Social',
			'hide_mobile' => ''
		);
		$instance = wp_parse_args ( ( array ) $instance, $default );
		foreach ( $instance as $k => $v ) {
			$$k = esc_attr ( $v );
		}
		
		
		
		//
		_eb_widget_echo_widget_input_title( $this->get_field_name ( 'title' ), $title, 'Ghi chú:' );
		
		
		_eb_widget_echo_widget_hide_mobile( $this->get_field_name ( 'hide_mobile' ), $hide_mobile );
		
	}
	
	function update($new_instance, $old_instance) {
		$instance = _eb_widget_parse_args ( $new_instance, $old_instance );
		return $instance;
	}
	
	function widget($args, $instance) {
		
		extract ( $args );
		
//		$title = apply_filters ( 'widget_title', $instance ['title'] );
		$title = isset( $instance ['title'] ) ? $instance ['title'] : '';
		
		$hide_mobile = isset( $instance ['hide_mobile'] ) ? $instance ['hide_mobile'] : 'off';
		$hide_mobile = $hide_mobile == 'on' ? ' hide-if-mobile' : '';
		
		
		//
//		_eb_echo_widget_name( $this->name, $before_widget );
		echo '<!-- ' . $this->name . ' (' . $title . ') -->';
		
		//
		if ( $title != '' ) {
			echo '<div class="footer-social-title">' . $title . '</div>';
		}
		
		//
		echo '
		<ul class="footer-social text-center cf">
			<li class="footer-social-fb"><a href="javascript:;" class="ahref-to-facebook" target="_blank" rel="nofollow"><i class="fa fa-facebook"></i></a></li>
			<li class="footer-social-tw"><a href="javascript:;" class="each-to-twitter-page" target="_blank" rel="nofollow"><i class="fa fa-twitter"></i></a></li>
			<li class="footer-social-yt"><a href="javascript:;" class="each-to-youtube-chanel" target="_blank" rel="nofollow"><i class="fa fa-youtube"></i></a></li>
			<li class="footer-social-gg"><a href="javascript:;" class="ahref-to-gooplus" target="_blank" rel="nofollow"><i class="fa fa-google-plus"></i></a></li>
		</ul>';
		
		//
//		echo $after_widget;
	}
}




