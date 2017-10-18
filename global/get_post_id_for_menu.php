<?php



//print_r( $_GET );
$post_id = (int) $_GET['by_id'];
$post_type = $_GET['by_post_type'];



echo '<script>
parent.WGR_finish_search_and_add_menu(' . $post_id . ', "' . $post_type . '", "' . _eb_p_link( $post_id ) . '");
</script>';




exit();



