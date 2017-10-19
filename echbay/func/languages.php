<?php




//
//print_r( $_GET ); exit();

//
$text = isset( $_POST['languages_content_edit'] ) ? trim($_POST['languages_content_edit']) : '';
$key = isset( $_POST['languages_key_edit'] ) ? trim($_POST['languages_key_edit']) : '';

if ( $key == '' ) {
	_eb_alert('KEY is null');
}

//
EBE_set_lang( $key, $text );

//
//echo $text;



echo '<script>
if ( top != self ) {
	parent.done_update_languages();
}
</script>';


exit();



