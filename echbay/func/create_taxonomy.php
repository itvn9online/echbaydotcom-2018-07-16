<?php



// https://codex.wordpress.org/Function_Reference/wp_insert_term


//print_r( $_POST );
//print_r( $_GET );
//exit();
$_POST = EBE_stripPostServerClient ();


$a = trim( $_POST['t_multi_taxonomy'] );
$a = explode( "\n", $a );



// với 1 số taxonomy không qua đăng ký -> bỏ qua các khâu kiểm tra để tách ra khỏi lệch của wordpress
/*
$taxonomy_switcher = '';
if ( $_POST['t_taxonomy'] == 'eb_discount_code' ) {
	// gán giá trị để lát thay đổi lại taxonomy
	$taxonomy_switcher = $_POST['t_taxonomy'];
	
	// giả lập taxonomy mặc định
	$_POST['t_taxonomy'] = 'category';
}
*/
$check_term_exist = 0;



//
foreach ( $a as $v ) {
	$v = trim( $v );
	
	if ( $v != '' ) {
		$v = explode( '|', $v );
		
		$slug = '';
		if ( isset( $v[1] ) ) {
			$slug = trim( $v[1] );
		}
		else {
			$slug = _eb_non_mark_seo( trim( $v[0] ) );
		}
		$v = trim( $v[0] );
		
		//
		echo $v . '<br>' . "\n";
		
		// lệnh riêng với các taxonomy không qua đăng ký
		if ( $_POST['t_taxonomy'] == 'eb_discount_code' ) {
		}
		else {
//			$check_term_exist = term_exists( $v, $_POST['t_taxonomy'] );
			$check_term_exist = term_exists( $slug, $_POST['t_taxonomy'] );
//			print_r( $check_term_exist );
		}
		
		//
		if ( $check_term_exist !== 0 && $check_term_exist !== null ) {
			echo '<script>parent.WGR_after_create_taxonomy("' . $v . ' | ' . $slug . ' (<span class=redcolor>EXIST</span>)");</script>';
		}
		else {
			if ( $_POST['t_taxonomy'] == 'eb_discount_code' ) {
			}
			else {
				$done = wp_insert_term(
					// the term 
					$v,
					// the taxonomy
					$_POST['t_taxonomy'],
					array(
//						'description'=> 'A yummy apple.',
						'slug' => $slug,
						// get numeric term id
						'parent'=> (int) $_POST['t_ant']
					)
				);
//				print_r( $done );
				
				//
	//			if ( isset( $done['errors'] ) || isset( $done->errors ) ) {
				if ( is_wp_error( $done ) ) {
					echo '<script>parent.WGR_after_create_taxonomy("' . $v . ' (ERROR: ' . str_replace( '"', '&quot;', $done->get_error_message() ) . ')");</script>';
				}
				else {
					echo '<script>parent.WGR_after_create_taxonomy("' . $v . ' (<span class=greencolor>OK</span>)");</script>';
				}
			}
		}
	}
}






