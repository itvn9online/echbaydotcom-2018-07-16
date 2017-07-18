<?php




//
//print_r( $_GET ); exit();

//
$text = isset( $_GET['text'] ) ? trim($_GET['text']) : '';
$key = isset( $_GET['key'] ) ? trim($_GET['key']) : '';

if ( $key == '' ) {
	die('KEY is null');
}

//
EBE_set_lang( $key, $text );

//
echo $text;



exit();



