<?php


//print_r( $_POST ); exit();



//
$noidung = trim( $_POST['t_noidung'] );
//_eb_alert($noidung);


$key = '___eld___cookie_by_domain';


delete_option ( $key );


$v = stripslashes ( stripslashes ( stripslashes ( trim( $v ) ) ) );


//
add_option( $key, $noidung, '', 'no' );




exit();



