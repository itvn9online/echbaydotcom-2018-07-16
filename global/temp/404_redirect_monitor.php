<?php




//
//print_r( $_GET );


//echo $wpdb->termmeta; exit();


//
$meta_value = isset( $_GET['url'] ) ? trim($_GET['url']) : '';
$meta_id = isset( $_GET['meta_id'] ) ? (int)$_GET['meta_id'] : 0;

//
if ( $meta_id > 0 ) {
	if ( $meta_value == '' ) {
		$meta_value = 1;
	}
	
	//
	_eb_q("UPDATE `" . $wpdb->termmeta . "`
	SET
		meta_value = '" . $meta_value . "'
	WHERE
		meta_id = " . $meta_id);
	
	/*
	_eb_q("UPDATE `" . wp_postmeta . "`
	SET
		meta_value = '" . $meta_value . "'
	WHERE
		meta_id = " . $meta_id);
		*/
	
	//
	echo $meta_value;
}
else {
	echo 'ID is zero';
}



exit();



