<?php




/*
* Chức năng đồng bộ URL của bản 1 với bản wordpress
*/



//
/*
function WGR_get_current_slug_of_taxonomy_or_post ( $a, $a0 ) {
	
	return $new_url;
}
*/

function WGR_migrate_v1_to_wordpress_version () {
	global $wpdb;
	
	//
	$u = $_SERVER['REQUEST_URI'];
//	echo $u . '<br>' . "\n";
//	echo substr($u, 0, 2) . '<br>' . "\n";
	
	//
	$a = explode('.htm', $u);
	$a = $a[0];
//	echo $a . '<br>' . "\n";
	
	//
	$a0 = explode('-', $a);
	$a0 = $a0[ count( $a0 ) - 1 ];
//	echo $a0 . '<br>' . "\n";
	
	//
	$new_url = '';
	$taxonomy = '';
	$post_type = '';
	$b = _eb_number_only($a0);
//	echo $b . '<br>' . "\n";
	
	// có html
//	if ( strstr( $a, '.htm' ) == true ) {
//		$a0 = $a;
//		$a0 = explode( '.', $a );
//		$a0 = $a0[0];
		
		/*
		* den-quat-hien-dai-s57.html
		*/
		if ( $b > 0 && preg_match ( '/^(c|s|f|p|b|n)+([0-9])+$/i', $a0 ) ) {
			/*
		// category
		if ( substr($a0, 0, 1) == 'c' || substr($a0, 0, 1) == 's' || substr($a0, 0, 1) == 'f'
		// post
		|| substr($a0, 0, 1) == 'p'
		// blogs
		|| substr($a0, 0, 1) == 'n' ) {
			*/
			if ( substr($a0, 0, 1) == 'p' ) {
				$post_type = 'post';
			}
			else if ( substr($a0, 0, 1) == 'n' ) {
				$post_type = EB_BLOG_POST_TYPE;
//				$taxonomy = EB_BLOG_POST_LINK;
			}
			/*
			if ( substr($a0, 0, 1) == 'n' ) {
				$taxonomy = EB_BLOG_POST_LINK;
			}
			else {
				$taxonomy = 'category';
			}
			*/
			
			//
//			$new_url = WGR_get_current_slug_of_taxonomy_or_post( $a, $a0 );
//			$new_url = _eb_c_link( $b );
			$new_url = str_replace( '--', '-', $a );
//			echo $new_url . '<br>' . "\n";
			$new_url = str_replace( '-' . $a0, '', $new_url );
//			echo $new_url . '<br>' . "\n";
			
			//
			$ex = explode( '/', $new_url );
			if ( count( $ex > 1 ) ) {
				$new_url = $ex[ count( $ex ) - 1 ];
			}
		}
		else {
			$a0 = explode( '/', $a );
			
			if ( isset( $a0[1] ) ) {
				$a0 = $a0[1];
//				echo $a0 . '<br>' . "\n";
				
				//
				$b = _eb_number_only($a0);
//				echo $b . '<br>' . "\n";
				
				//
				if ( $b > 0 && preg_match ( '/^(c|s|f|p|b|n)+([0-9])+$/i', $a0 ) ) {
					$a0 = explode( '/', $a );
					if ( isset( $a0[2] ) ) {
						$new_url = $a0[2];
					}
				}
			}
		}
		/*
		* /s30/den-chum-nen.html
		*/
		/*
		// category
		else if ( substr($u, 0, 2) == '/c' || substr($u, 0, 2) == '/s' || substr($u, 0, 2) == '/f'
		// post
		|| substr($u, 0, 2) == '/p'
		// blogs
		|| substr($u, 0, 2) == '/n' ) {
			$a0 = substr($u, 2);
			echo $a0 . '<br>' . "\n";
			
			$a0 = explode( '/', $a0 );
			$a0 = $a0[0];
			echo $a0 . '<br>' . "\n";
		}
		*/
		// post
		/*
		else if ( substr($a0, 0, 1) == 'p' ) {
			$b = _eb_number_only($a0);
//			echo $b . '<br>' . "\n";
			
			if ( $b > 0 ) {
				$new_url = _eb_p_link( $b );
			}
		}
		*/
//	}
	// không có html
	// /s8/kenwood/
	// /c14-software/
	
	
	
	
	//
//	echo $new_url . '<br>' . "\n";
	
	//
	$return_url = '';
	
	// xử lý lại url trước khi chuyển đi
	if ( $new_url != '' ) {
		if ( substr( $new_url, 0, 1 ) == '/' ) {
			$new_url = substr( $new_url, 1 );
		}
		
		//
		/*
		if ( strstr( $new_url, '//' ) == false ) {
			$new_url = web_link . $new_url;
		}
		*/
//		echo $new_url . '<br>' . "\n";
		
		// post
		if ( $post_type != '' ) {
			$sql = _eb_q("SELECT ID
			FROM
				`" . $wpdb->posts . "`
			WHERE
				post_name = '" . $new_url . "'
				AND post_type = '" . $post_type . "'
			ORDER BY
				ID DESC
			LIMIT 0, 1");
//			print_r( $sql );
			if ( ! empty( $sql ) ) {
				$return_url = _eb_p_link( $sql[0]->ID );
			}
		}
		// taxonomy
		else {
			$sql = _eb_q("SELECT term_id
			FROM
				`" . $wpdb->terms . "`
			WHERE
				slug = '" . $new_url . "'
			ORDER BY
				term_id DESC");
//			print_r( $sql );
			if ( ! empty( $sql ) ) {
				foreach ( $sql as $v ) {
					$t = WGR_get_taxonomy_name( $v->term_id );
//					echo $t . '<br>' . "\n";
					
					//
					if ( $t == 'category' || $t == EB_BLOG_POST_LINK ) {
						$return_url = _eb_c_link( $v->term_id );
						break;
					}
				}
			}
		}
	}
	
	//
	return $return_url;
}

//
$redirect_301_link = WGR_migrate_v1_to_wordpress_version();

//
//echo $redirect_301_link . '<br>' . "\n"; exit();



