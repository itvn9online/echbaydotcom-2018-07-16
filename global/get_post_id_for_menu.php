<?php



//print_r( $_GET );
$post_id = (int) $_GET['by_id'];
$post_type = $_GET['by_post_type'];
$by_item_type = isset( $_GET['by_item_type'] ) ? $_GET['by_item_type'] : '';

$return_link = '';
if ( $by_item_type == 'taxonomy' ) {
	$return_link = _eb_c_link( $post_id, $post_type );
}
else {
	$return_link = _eb_p_link( $post_id );
}


echo '<script>
if ( top != self ) {
	parent.WGR_finish_search_and_add_menu(' . $post_id . ', "' . $post_type . '", "' . $return_link . '", "' . $by_item_type . '");
}
</script>';




exit();



