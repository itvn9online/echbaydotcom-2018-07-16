<?php




$arr_includes_home_file[] = EB_THEME_PLUGIN_INDEX . 'themes/home/echbaytwo-home1.php';

$arr_includes_home_file[] = EB_THEME_PLUGIN_INDEX . 'themes/home/echbaytwo-home2.php';

$arr_includes_home_file[] = EB_THEME_PLUGIN_INDEX . 'themes/home/echbaytwo-home3.php';

$arr_includes_home_file[] = EB_THEME_PLUGIN_INDEX . 'themes/home/echbaytwo-home4.php';




// load css cho home default
$arr_for_add_theme_css[ EB_THEME_PLUGIN_INDEX . 'css/home_default.css' ] = 1;
//$arr_for_add_css[ EB_THEME_PLUGIN_INDEX . 'css/home_default.css' ] = 1;

//
foreach ( $arr_includes_home_file as $v ) {
//	$arr_for_add_css[ EBE_get_css_for_config_design( basename( $v ) ) ] = 1;
	$arr_for_add_css[ WGR_check_add_add_css_themes_or_plugin( basename( $v ) ) ] = 1;
}



