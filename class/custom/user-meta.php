<?php


/*
* Chức năng thêm custom filed cho user
*/


add_filter( 'show_user_profile', 'eb_show_extra_profile_fields' );
add_filter( 'edit_user_profile', 'eb_show_extra_profile_fields' );
function eb_show_extra_profile_fields( $user ) {
	?>

<br>
<h3>Thông tin bổ sung</h3>
<table class="form-table">
	<tr>
		<th><label for="address">Địa chỉ</label></th>
		<td><input type="text" name="address" id="address" value="<?php echo esc_attr( get_the_author_meta( 'address', $user->ID ) ); ?>" class="large-text" /></td>
	</tr>
	<tr>
		<th><label for="phone">Điện thoại</label></th>
		<td><input type="text" name="phone" id="phone" value="<?php echo esc_attr( get_the_author_meta( 'phone', $user->ID ) ); ?>" class="regular-text" /></td>
	</tr>
</table>
<?php

}




add_filter( 'personal_options_update', 'eb_save_extra_profile_fields' );
add_filter( 'edit_user_profile_update', 'eb_save_extra_profile_fields' );
function eb_save_extra_profile_fields( $user_id ) {
	if ( ! current_user_can( 'edit_user', $user_id ) ) {
		return false;
	}
	
	update_user_meta( $user_id, 'address', $_POST['address'] );
	update_user_meta( $user_id, 'phone', $_POST['phone'] );
} 






// thêm role mới dùng cho đăng ký nhận tin
function WGR_add_new_roles() {
	global $wp_roles;
	
	if (!isset($wp_roles)) {
		$wp_roles = new WP_Roles();
	}
//	print_r( $wp_roles );
	
	$copy_roles = $wp_roles->get_role('subscriber');
//	print_r( $copy_roles );
	
	$wp_roles->add_role( 'quickregister', 'Đăng ký nhận tin', $copy_roles->capabilities );
}
add_filter('init', 'WGR_add_new_roles');



