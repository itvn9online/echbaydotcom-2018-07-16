<?php


//
$current_search_key = trim( get_search_query() );

// cho vào log
if ( $current_search_key != '' ) {
	include EB_THEME_PLUGIN_INDEX . 'global/search_show.php';
}



