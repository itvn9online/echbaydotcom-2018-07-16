<?php




// bật/ tắt chế độ test code
//define( 'eb_code_tester', false );




// thiết lập url -> có ssl hoặc ko
$eb_web_protocol = 'http';
if ( $_SERVER['SERVER_PORT'] == 443
|| ( isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on' )
|| ( isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https' ) ) {
	$eb_web_protocol = 'https';
}
define( 'eb_web_protocol', $eb_web_protocol );

/*
if ( eb_web_protocol == 'https' ) {
	header ( 'Location: http:' . _eb_full_url (), true, 301 ); exit();
}
*/




// localhost
//echo $_SERVER ['HTTP_HOST'];
//echo $_SERVER['REQUEST_URI'];

//
$d = array(
	DB_NAME,
	DB_USER,
	DB_PASSWORD
);

//
$localhost = 0;
$dbhost = 'localhost';




// test
//echo $_SERVER ['HTTP_HOST'] . "\n";

if ( $_SERVER ['HTTP_HOST'] == 'localhost:8888' || $_SERVER ['HTTP_HOST'] == 'localhost' ) {
	$d = array(
		DB_NAME,
		DB_USER,
		DB_PASSWORD
	);
	
	//
	$localhost = 1;
}



