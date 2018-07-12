<?php


/*
print_r( $_POST );
print_r( $_GET );
exit();
*/
$_POST = EBE_stripPostServerClient ();


//
$t_matkhau = $_POST ['t_matkhau'];
if ( strlen( trim( $t_matkhau ) ) < 6 ) {
	_eb_alert( EBE_get_lang('pr_short_matkhau') );
}


//
if (mtv_id <= 0) {
	_eb_alert( EBE_get_lang('pr_no_id') );
}


//
wp_update_user(
	array(
		'user_pass' => $t_matkhau,
		'ID' => mtv_id
	)
);




//
die('<script type="text/javascript">

//
if ( top != self ) {
	parent.document.frm_canhan.reset();
}
else {
	window.opener.document.frm_canhan.reset();
}

alert("' . EBE_get_lang('pr_done') . '");

</script>');

exit();

//
//_eb_alert( EBE_get_lang('pr_done') );




