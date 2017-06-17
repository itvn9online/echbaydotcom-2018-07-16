<?php




$noidung = trim( $_POST['t_noidung'] );


if ( $noidung == '' ) {
	$noidung = 'User-agent: *';
}


$dir_robots_txt = ABSPATH . 'robots.txt';



_eb_create_file( $dir_robots_txt, $noidung );




_eb_alert( 'Cập nhật robots.txt thành công' );




