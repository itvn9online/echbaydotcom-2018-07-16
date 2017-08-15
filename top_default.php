<?php

$arr_includes_top_file[] = EB_THEME_PLUGIN_INDEX . 'themes/top/echbaytwo-top1.php';

$arr_includes_top_file[] = EB_THEME_PLUGIN_INDEX . 'themes/top/echbaytwo-top2.php';

$arr_includes_top_file[] = EB_THEME_PLUGIN_INDEX . 'themes/top/echbaytwo-top3.php';

$arr_includes_top_file[] = EB_THEME_PLUGIN_INDEX . 'themes/top/breadcrumb-top1.php';

$arr_includes_top_file[] = EB_THEME_PLUGIN_INDEX . 'top_widget.php';




//
foreach ( $arr_includes_top_file as $v ) {
//	$arr_for_add_css[ EBE_get_css_for_config_design( basename( $v ) ) ] = 0;
	$arr_for_add_css[ WGR_check_add_add_css_themes_or_plugin( basename( $v ) ) ] = 0;
}


