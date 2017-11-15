<?php



// https://www.wpoptimus.com/626/7-ways-disable-update-wordpress-notifications/
// https://wordpress.org/plugins/disable-wordpress-updates/



// tắt các chức năng liên quan đến kiểm tra cập nhật khi, chỉ 1 số trang mới kích hoạt chức năng này
if ( strstr( $_SERVER['REQUEST_URI'], '/update-core.php' ) == false ) {
	
	
	/*
	* Disable All Automatic Updates
	* 3.7+
	*
	* @author	sLa NGjI's @ slangji.wordpress.com
	*/
	add_filter( 'auto_update_translation', '__return_false' );
	add_filter( 'automatic_updater_disabled', '__return_true' );
	add_filter( 'allow_minor_auto_core_updates', '__return_false' );
	add_filter( 'allow_major_auto_core_updates', '__return_false' );
	add_filter( 'allow_dev_auto_core_updates', '__return_false' );
	add_filter( 'auto_update_core', '__return_false' );
	add_filter( 'wp_auto_update_core', '__return_false' );
	add_filter( 'auto_core_update_send_email', '__return_false' );
	add_filter( 'send_core_update_notification_email', '__return_false' );
	add_filter( 'auto_update_plugin', '__return_false' );
	add_filter( 'auto_update_theme', '__return_false' );
	add_filter( 'automatic_updates_send_debug_email', '__return_false' );
	add_filter( 'automatic_updates_is_vcs_checkout', '__return_true' );
	
	
	add_filter( 'automatic_updates_send_debug_email ', '__return_false', 1 );
	
	//
//	if( !defined( 'AUTOMATIC_UPDATER_DISABLED' ) ) define( 'AUTOMATIC_UPDATER_DISABLED', true );
//	if( !defined( 'WP_AUTO_UPDATE_CORE') ) define( 'WP_AUTO_UPDATE_CORE', false );
	
	
	
	// Disable Theme Updates
	remove_action( 'load-update-core.php', 'wp_update_themes' );
	wp_clear_scheduled_hook( 'wp_update_themes' );
	
	// Disable Plugin Updates
	remove_action( 'load-update-core.php', 'wp_update_plugins' );
	wp_clear_scheduled_hook( 'wp_update_plugins' );
	
	// Disable Core Updates
	wp_clear_scheduled_hook( 'wp_version_check' );
	remove_action( 'wp_maybe_auto_update', 'wp_maybe_auto_update' );
	remove_action( 'admin_init', 'wp_maybe_auto_update' );
	remove_action( 'admin_init', 'wp_auto_update_core' );
	wp_clear_scheduled_hook( 'wp_maybe_auto_update' );
	
}




