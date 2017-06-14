<?php

if ( have_posts() ) {
	if ( $post->post_type == 'post' || $post->post_type == 'blog' ) {
		include EB_THEME_PHP . 'content.php';
	} else {
		include EB_THEME_PHP . '404.php';
	}
} else {
	include EB_THEME_PLUGIN_INDEX . 'global/content-none.php';
}
