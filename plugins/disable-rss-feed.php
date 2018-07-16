<?php


function itsme_disable_feed() {
	wp_die( __( 'No feed available, please visit the <a href="'. esc_url( home_url( '/' ) ) .'">homepage</a>!' ) );
}

add_filter('do_feed', 'itsme_disable_feed', 1);
add_filter('do_feed_rdf', 'itsme_disable_feed', 1);
add_filter('do_feed_rss', 'itsme_disable_feed', 1);
add_filter('do_feed_rss2', 'itsme_disable_feed', 1);
add_filter('do_feed_atom', 'itsme_disable_feed', 1);
add_filter('do_feed_rss2_comments', 'itsme_disable_feed', 1);
add_filter('do_feed_atom_comments', 'itsme_disable_feed', 1);



/*
remove_action( 'wp_head', 'feed_links_extra', 3 );
remove_action( 'wp_head', 'feed_links', 2 );
*/


