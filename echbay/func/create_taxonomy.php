<?php



// https://codex.wordpress.org/Function_Reference/wp_insert_term


//print_r( $_POST );
//print_r( $_GET );
//exit();
EBE_stripPostServerClient ();


$a = trim( $_POST['t_multi_taxonomy'] );
$a = explode( "\n", $a );

//
foreach ( $a as $v ) {
	$v = trim( $v );
	
	if ( $v != '' ) {
		$done = wp_insert_term(
			$v, // the term 
			$_POST['t_taxonomy'], // the taxonomy
			array(
//				'description'=> 'A yummy apple.',
//				'slug' => 'apple',
				'parent'=> (int) $_POST['t_ant']  // get numeric term id
			)
		);
		
		//
		if ( isset( $done['errors'] ) ) {
//			print_r( $done );
			
			echo '<script>parent.WGR_after_create_taxonomy("' . $v . ' (ERROR)");</script>';
		}
		else {
			echo '<script>parent.WGR_after_create_taxonomy("' . $v . ' (OK)");</script>';
		}
	}
}






