<?php




/*
* LƯU Ý: các thay đổi liên quan đến 
*/



//
//echo '<!-- remove category base by echbay -->' . "\n";
//echo 1;
// xóa slug của category cha khỏi đường dẫn của category con
function WGR_remove_category_parents ($url, $term, $taxonomy) {
	
//	echo $url . '<br>' . "\n";
	
	if ( $taxonomy == 'category' ) {
		$url = trailingslashit ( web_link ) . user_trailingslashit ( $term->slug, $taxonomy );
	}
//	echo $url . '<br>' . "\n";
	
	return $url;
	
}


// Add our custom product cat rewrite rules
function eb_get_and_add_new_array_rule ( $arr, $taxonomy_key = 'category', $post_type = 'post' ) {
	
//	echo $set_for_tax;
	
	$terms = get_terms ( array (
		'taxonomy' => $taxonomy_key,
		'post_type' => $post_type,
		'hide_empty' => false 
	) );
//	print_r( $terms );
	
	//
	$taxonomy_name = $taxonomy_key;
	if ( $taxonomy_key == 'category' ) {
		$taxonomy_name = 'category_name';
	}
	
//	if ( $terms && ! is_wp_error ( $terms ) ) {
		foreach ( $terms as $v ) {
			$taxonomy_slug = $v->slug;
			
			$arr[$taxonomy_slug . '/feed/(feed|rdf|rss|rss2|atom)/?$'] = 'index.php?' . $taxonomy_name . '=' . $taxonomy_slug . '&feed=$matches[1]';
			
			$arr[$taxonomy_slug . '/(feed|rdf|rss|rss2|atom)/?$'] = 'index.php?' . $taxonomy_name . '=' . $taxonomy_slug . '&feed=$matches[1]';
			
			$arr[$taxonomy_slug . '/embed/?$'] = 'index.php?' . $taxonomy_name . '=' . $taxonomy_slug . '&embed=true';
			
			$arr[$taxonomy_slug . '/page/?([0-9]{1,})/?$'] = 'index.php?' . $taxonomy_name . '=' . $taxonomy_slug . '&paged=$matches[1]';
			
			$arr[$taxonomy_slug . '/?$'] = 'index.php?' . $taxonomy_name . '=' . $taxonomy_slug;
			
		}
//	}
	print_r( $arr );
	
	return $arr;
	
}


function ___eb_modife_wp_rule_taxonomy($rules) {
	
//	print_r( $rules );
	
	$rules = eb_get_and_add_new_array_rule ( $rules );
	
	return $rules;
	
}


function eb_add_rewrite_rule_structure ( $taxonomy_key = 'category', $post_type = 'post' ) {
	
//	echo $set_for_tax;
	
	$terms = get_terms ( array (
		'taxonomy' => $taxonomy_key,
		'post_type' => $post_type,
		'hide_empty' => false 
	) );
//	print_r( $terms );
	
	//
	$taxonomy_name = $taxonomy_key;
	if ( $taxonomy_key == 'category' ) {
		$taxonomy_name = 'category_name';
	}
	
	//
	$arr = array();
//	if ( $terms && ! is_wp_error ( $terms ) ) {
		foreach ( $terms as $v ) {
			
			$taxonomy_slug = $v->slug;
			
			//
			$arr[$taxonomy_slug . '/feed/(feed|rdf|rss|rss2|atom)/?$'] = 'index.php?' . $taxonomy_name . '=' . $taxonomy_slug . '&feed=$matches[1]';
			
			$arr[$taxonomy_slug . '/(feed|rdf|rss|rss2|atom)/?$'] = 'index.php?' . $taxonomy_name . '=' . $taxonomy_slug . '&feed=$matches[1]';
			
			$arr[$taxonomy_slug . '/embed/?$'] = 'index.php?' . $taxonomy_name . '=' . $taxonomy_slug . '&embed=true';
			
			$arr[$taxonomy_slug . '/page/?([0-9]{1,})/?$'] = 'index.php?' . $taxonomy_name . '=' . $taxonomy_slug . '&paged=$matches[1]';
			
			$arr[$taxonomy_slug . '/?$'] = 'index.php?' . $taxonomy_name . '=' . $taxonomy_slug;
			
		}
//	}
//	print_r( $arr );
	
	//
	foreach ( $arr as $regex => $redirect ) {
		add_rewrite_rule( $regex, $redirect, 'top' );
	}
	
}


function WGR_register_category_taxonomy_rules () {
	eb_add_rewrite_rule_structure();
}



// for category
if ( $__cf_row['cf_remove_category_base'] == 1 ) {
	add_filter ( 'term_link', 'WGR_remove_category_parents', 1000, 3 );
//	add_filter ( 'rewrite_rules_array', '___eb_modife_wp_rule_taxonomy' );
	add_filter('init', 'WGR_register_category_taxonomy_rules');
}



