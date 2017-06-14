<?php



//
//echo '<!-- remove category base by echbay -->' . "\n";



// xóa slug của category cha khỏi đường dẫn của category con
add_filter ( 'term_link', '___eb_no_term_parents', 1000, 3 );

function ___eb_no_term_parents($url, $term, $taxonomy) {
	
	if ( $taxonomy == 'category' ) {
		$url = trailingslashit ( web_link ) . user_trailingslashit ( $term->slug, $taxonomy );
	}
	return $url;
	
}




// Add our custom product cat rewrite rules
add_filter ( 'rewrite_rules_array', '___eb_add_new_rule_for_category' );

function ___eb_add_new_rule_for_category($rules) {
	
	$new_rules = array ();
	$set_for_tax = 'category';
	echo $set_for_tax;
	
	$terms = get_terms ( array (
		'taxonomy' => $set_for_tax,
		'post_type' => 'post',
		'hide_empty' => false 
	) );
	print_r( $terms );
	
	if ( $terms && ! is_wp_error ( $terms ) ) {
		foreach ( $terms as $term ) {
			$new_rules [$term->slug . '/?$'] = 'index.php?category=' . $term->slug;
			$new_rules [$term->slug . '/page/([0-9]{1,})/?$'] = 'index.php?category=' . $term->slug . '&paged=$matches[1]';
			$new_rules [$term->slug . '/(?:feed/)?(feed|rdf|rss|rss2|atom)/?$'] = 'index.php?category=' . $term->slug . '&feed=$matches[1]';
		}
	}
//	$new_rules = ___eb_add_rule_by_taxonomy( $new_rules );
	
	return $new_rules + $rules;
	
}


function ___eb_add_rule_by_taxonomy ( $new_rules = array(), $tax = 'category' ) {
	
	$terms = get_terms ( array (
		'taxonomy' => $tax,
		'post_type' => 'post',
		'hide_empty' => false 
	) );
//	print_r( $terms );
	
//	if ( $terms && ! is_wp_error ( $terms ) ) {
		foreach ( $terms as $term ) {
			$new_rules [$term->slug . '/?$'] = 'index.php?category=' . $term->slug;
			$new_rules [$term->slug . '/page/([0-9]{1,})/?$'] = 'index.php?category=' . $term->slug . '&paged=$matches[1]';
			$new_rules [$term->slug . '/(?:feed/)?(feed|rdf|rss|rss2|atom)/?$'] = 'index.php?category=' . $term->slug . '&feed=$matches[1]';
		}
//	}
	
	return $new_rules;
	
}



