<?php

$arr_includes_footer_file[] = EB_THEME_PLUGIN_INDEX . 'footer_widget.php';

$arr_includes_footer_file[] = EB_THEME_PLUGIN_INDEX . 'themes/footer/echbaytwo-footer1.php';

$arr_includes_footer_file[] = EB_THEME_PLUGIN_INDEX . 'themes/footer/echbaytwo-footer2.php';

$arr_includes_footer_file[] = EB_THEME_PLUGIN_INDEX . 'themes/footer/copyright-footer3.php';



//
foreach ( $arr_includes_footer_file as $v ) {
//	$arr_for_add_css[ EBE_get_css_for_config_design( basename( $v ) ) ] = 1;
	$arr_for_add_css[ WGR_check_add_add_css_themes_or_plugin( basename( $v ) ) ] = 1;
//	$arr_for_add_theme_css[ WGR_check_add_add_css_themes_or_plugin( basename( $v ) ) ] = 1;
}



