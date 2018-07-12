<?php


/*
print_r( $_POST );
print_r( $_GET );
exit();
*/
$_POST = EBE_stripPostServerClient ();


//
$t_hoten = trim ( $_POST ['t_hoten'] );
$t_dienthoai = trim ( $_POST ['t_dienthoai'] );
$t_diachi = trim ( $_POST ['t_diachi'] );


//
if (mtv_id <= 0) {
	_eb_alert( EBE_get_lang('pr_no_id') );
}


//
wp_update_user(
	array(
		'first_name' => $t_hoten,
		'ID' => mtv_id
	)
);
update_user_meta( mtv_id, 'address', $t_diachi );
update_user_meta( mtv_id, 'phone', $t_dienthoai );




//
_eb_alert( EBE_get_lang('pr_done') );




