<?php


/*
* In ra thời gian cập nhật code lần cuối, theo múi giờ cố định
*/
date_default_timezone_set ( 'Asia/Ho_Chi_Minh' );



$t = filemtime ( './index.php' );


//
//echo date( 'r', $time_file );
echo date( 'Y.md.H', $t );



