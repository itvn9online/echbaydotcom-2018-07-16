<?php


function WGR_disable_rss_feed() {
	wp_die( __( 'No feed available, please visit the <a href="'. esc_url( home_url( '/' ) ) .'">homepage</a>!' ) );
}

add_filter('do_feed', 'WGR_disable_rss_feed', 1);
add_filter('do_feed_rdf', 'WGR_disable_rss_feed', 1);
add_filter('do_feed_rss', 'WGR_disable_rss_feed', 1);
add_filter('do_feed_rss2', 'WGR_disable_rss_feed', 1);
add_filter('do_feed_atom', 'WGR_disable_rss_feed', 1);
add_filter('do_feed_rss2_comments', 'WGR_disable_rss_feed', 1);
add_filter('do_feed_atom_comments', 'WGR_disable_rss_feed', 1);



/*
remove_action( 'wp_head', 'feed_links_extra', 3 );
remove_action( 'wp_head', 'feed_links', 2 );
*/


