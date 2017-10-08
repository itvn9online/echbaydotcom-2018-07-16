<?php

if ( have_posts() ) {
//	echo '<!-- TEST -->' . "\n";
//	print_r( $post );
	
	if ( $post->post_type == 'post' || $post->post_type == EB_BLOG_POST_TYPE ) {
		if ( defined('EB_CHILD_THEME_URL') && file_exists( EB_CHILD_THEME_URL . 'php/content.php' ) ) {
//			echo '<!-- ' . EB_CHILD_THEME_URL . ' -->' . "\n";
			include EB_CHILD_THEME_URL . 'php/content.php';
		}
		else {
			include EB_THEME_PHP . 'content.php';
		}
	}
	else {
		if ( defined('EB_CHILD_THEME_URL') && file_exists( EB_CHILD_THEME_URL . 'php/404.php' ) ) {
			include EB_CHILD_THEME_URL . 'php/404.php';
		}
		else {
			include EB_THEME_PHP . '404.php';
		}
	}
}
else {
	include EB_THEME_PLUGIN_INDEX . 'global/content-none.php';
}
