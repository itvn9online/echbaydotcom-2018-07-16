<?php


//
//print_r( $_GET );


if ( ! isset( $_GET['type'] ) ) {
	die('type not found!');
}
$type = trim( $_GET['type'] );


if ( ! isset( $_GET['id'] ) ) {
	die('id not found!');
}
$id = (int)$_GET['id'];



//
$show_title = '';
if ( $type == 'category' || $type == 'blogs' ) {
	$title = _eb_get_cat_object( $id, '_eb_category_title' );
	$description = _eb_get_cat_object( $id, '_eb_category_description' );
	$content = _eb_get_cat_object( $id, '_eb_category_content' );
	
	$a = get_term( $id, $type );
//	print_r( $a );
	$show_title = $a->name;
}
else if ( $type == 'post' || $type == 'blog' ) {
	$title = _eb_get_post_object( $id, '_eb_product_title' );
	$description = _eb_get_post_object( $id, '_eb_product_description' );
	$content = '';
	
	$show_title = get_the_title( $id );
}
else {
	die('type <strong>' . $type . '</strong> not support!');
}


?>

<h2><?php echo $type; ?>: <?php echo $show_title; ?></h2>
<br>
<form name="frm_config" method="post" action="<?php echo web_link; ?>process/?set_module=products_seo" target="target_eb_iframe">
	<div class="d-none">
		<input type="text" name="t_id" value="<?php echo $id; ?>" />
		<input type="text" name="t_type" value="<?php echo $type; ?>" />
	</div>
	<table border="0" cellpadding="0" cellspacing="0" class="eb-public-table eb-support-table">
		<tr>
			<td class="t">Title</td>
			<td class="i"><input type="text" name="_eb_category_title" value="<?php echo $title; ?>" class="l" /></td>
		</tr>
		<tr>
			<td class="t">Description</td>
			<td class="i"><input type="text" name="_eb_category_description" value="<?php echo $description; ?>" class="l" /></td>
		</tr>
		<tr>
			<td class="t">Content</td>
			<td class="i"><textarea name="_eb_category_content" style="width:95%;height:300px;"><?php echo $content; ?></textarea></td>
		</tr>
		<tr>
			<td class="t">&nbsp;</td>
			<td class="i"><input type="submit" value="Cập nhật" class="eb-admin-wp-submit" /></td>
		</tr>
	</table>
</form>
