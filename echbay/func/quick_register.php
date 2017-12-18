<?php



// tạo pass ảo để gọi tới chức năng đăng ký
$_POST['t_matkhau'] = substr( md5( time() ), 0, 8 );
$_POST['t_matkhau2'] = $_POST['t_matkhau'];
$_POST['for_quick_register'] = 1;


// gọi tới chức năng đăng ký như bình thường
include ECHBAY_PRI_CODE . 'func/register.php';




