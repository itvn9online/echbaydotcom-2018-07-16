<?php




global $wpdb;




$type = isset( $_GET['t'] ) ? trim( $_GET['t'] ) : '';


//
if ( isset( $_GET['by_taxonomy'] ) ) {
	include EB_THEME_PLUGIN_INDEX . 'global/temp/products_taxonomy.php';
}
else {
	include EB_THEME_PLUGIN_INDEX . 'global/temp/products_post.php';
}


//
include ECHBAY_PRI_CODE . 'products.php';



