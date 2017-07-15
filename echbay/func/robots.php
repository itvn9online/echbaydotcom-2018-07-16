<?php




$noidung = trim( $_POST['t_noidung'] );
//_eb_alert( $noidung );


if ( $noidung == '' ) {
	$noidung = 'User-agent: *';
}


$dir_robots_txt = ABSPATH . 'robots.txt';



if ( _eb_create_file( $dir_robots_txt, $noidung ) == false ) {
	_eb_alert( 'LỖI! robots.txt thất bại' );
}
else {
	_eb_alert( 'Cập nhật robots.txt thành công' );
}




