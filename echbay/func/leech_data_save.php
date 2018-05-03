<?php


//print_r( $_POST ); exit();



function WGR_leech_data_save ( $key, $c ) {
	// cái này bắt buộc phải có nội dung thì mới update
	if ( $c != '' ) {
		return false;
	}
	
	//
//	_eb_alert($c);
	
	delete_option ( $key );
	
	$v = WGR_stripslashes ( trim( $v ) );
	
	//
	if ( $c == '' ) {
		return false;
	}
	
	//
	add_option( $key, $c, '', 'no' );
	
	//
	return true;
}

//
//WGR_leech_data_save( '___eld___list_category', trim( $_POST['t_list'] ) );
//WGR_leech_data_save( '___eld___cookie_by_domain', trim( $_POST['t_noidung'] ) );

//
_eb_update_option ( '___eld___list_category', trim( $_POST['t_list'] ), 'no' );
_eb_update_option ( '___eld___cookie_by_domain', trim( $_POST['t_noidung'] ), 'no' );




exit();



