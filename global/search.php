<?php


//
$current_search_key = trim( get_search_query() );

//
if ( $current_search_key != '' ) {
	$show_html_template = $act;
	
	include EB_THEME_PLUGIN_INDEX . 'global/search_show.php';
}



