<?php



//
echo '<!-- remove category base by echbay -->' . "\n";



// xóa slug của category cha khỏi đường dẫn của category con
add_filter ( 'term_link', '___eb_no_term_parents', 1000, 3 );

function ___eb_no_term_parents($url, $term, $taxonomy) {
	
	if ( $taxonomy == 'category' ) {
		$term_nicename = $term->slug;
		
		$url = trailingslashit ( web_link ) . user_trailingslashit ( $term_nicename, 'category' );
	}
	return $url;
	
}




// Add our custom product cat rewrite rules
add_filter ( 'rewrite_rules_array', '___eb_add_new_rule_for_category' );

function ___eb_add_new_rule_for_category($rules) {
	
	$new_rules = array ();
	
	$terms = get_terms ( array (
			'taxonomy' => 'category',
			'post_type' => 'post',
			'hide_empty' => false 
	) );
	
	if ( $terms && ! is_wp_error ( $terms ) ) {
		foreach ( $terms as $term ) {
			$term_slug = $term->slug;
			
			$new_rules [$term_slug . '/?$'] = 'index.php?category=' . $term_slug;
			$new_rules [$term_slug . '/page/([0-9]{1,})/?$'] = 'index.php?category=' . $term_slug . '&paged=$matches[1]';
			$new_rules [$term_slug . '/(?:feed/)?(feed|rdf|rss|rss2|atom)/?$'] = 'index.php?category=' . $term_slug . '&feed=$matches[1]';
		}
	}
	
	return $new_rules + $rules;
	
}



