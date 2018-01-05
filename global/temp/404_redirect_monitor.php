<?php




//
//print_r( $_GET );


//echo wp_termmeta; exit();


//
$meta_value = isset( $_GET['url'] ) ? trim($_GET['url']) : '';
$meta_id = isset( $_GET['meta_id'] ) ? (int)$_GET['meta_id'] : 0;

//
if ( $meta_id > 0 ) {
	if ( $meta_value == '' ) {
		$meta_value = 1;
	}
	
	//
	_eb_q("UPDATE `" . wp_termmeta . "`
	SET
		meta_value = '" . $meta_value . "'
	WHERE
		meta_id = " . $meta_id, 0);
	
	/*
	_eb_q("UPDATE `" . wp_postmeta . "`
	SET
		meta_value = '" . $meta_value . "'
	WHERE
		meta_id = " . $meta_id, 0);
		*/
	
	//
	echo $meta_value;
}
else {
	echo 'ID is zero';
}



exit();



