<?php



if ( ! isset( $_POST['t_type'] ) ) {
	_eb_alert('type not found!');
}
$type = trim( $_POST['t_type'] );


if ( ! isset( $_POST['t_id'] ) ) {
	_eb_alert('id not found!');
}
$id = (int)$_POST['t_id'];



//
if ( $type == 'category' ) {
	update_term_meta( $id, '_eb_category_title', trim( $_POST['_eb_category_title'] ) );
	update_term_meta( $id, '_eb_category_description', trim( $_POST['_eb_category_description'] ) );
	update_term_meta( $id, '_eb_category_content', trim( $_POST['_eb_category_content'] ) );
}
else if ( $type == 'post' ) {
	WGR_update_meta_post( $id, '_eb_product_title', trim( $_POST['_eb_product_title'] ) );
	WGR_update_meta_post( $id, '_eb_product_description', trim( $_POST['_eb_product_description'] ) );
}
else {
	_eb_alert('type "' . $type . '" not support!');
}



?>
<script>
parent.WGR_admin_quick_edit_taxonomy( 'products', '&by_taxonomy=category' );
</script>
