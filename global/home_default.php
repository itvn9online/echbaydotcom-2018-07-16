<?php



// home hot
$arr_includes_home_file[] = EB_THEME_PLUGIN_INDEX . 'themes/home/echbaytwo-home1.php';

// home new
$arr_includes_home_file[] = EB_THEME_PLUGIN_INDEX . 'themes/home/echbaytwo-home2.php';

// home list
$arr_includes_home_file[] = EB_THEME_PLUGIN_INDEX . 'themes/home/echbaytwo-home3.php';

// home h1
$arr_includes_home_file[] = EB_THEME_PLUGIN_INDEX . 'themes/home/echbaytwo-home4.php';

// home widget
$arr_includes_home_file[] = EB_THEME_PLUGIN_INDEX . 'themes/home/echbaytwo-home5.php';

// logo đối tác
//$arr_includes_home_file[] = EB_THEME_PLUGIN_INDEX . 'themes/home/echbaytwo-home6.php';




// load css cho home default
//$arr_for_add_theme_css[ EB_THEME_PLUGIN_INDEX . 'css/home_default.css' ] = 1;
$arr_for_add_css[ EB_THEME_PLUGIN_INDEX . 'css/home_default.css' ] = 1;

//
foreach ( $arr_includes_home_file as $v ) {
//	$arr_for_add_css[ EBE_get_css_for_config_design( basename( $v ) ) ] = 1;
	$arr_for_add_css[ WGR_check_add_add_css_themes_or_plugin( basename( $v ) ) ] = 1;
//	$arr_for_add_theme_css[ WGR_check_add_add_css_themes_or_plugin( basename( $v ) ) ] = 1;
}



