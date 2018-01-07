<?php



// https://codex.wordpress.org/Function_Reference/wp_insert_term


//print_r( $_POST );
//print_r( $_GET );
//exit();
$_POST = EBE_stripPostServerClient ();


$a = trim( $_POST['t_multi_taxonomy'] );
$a = explode( "\n", $a );

//
foreach ( $a as $v ) {
	$v = trim( $v );
	
	if ( $v != '' ) {
		echo $v . '<br>' . "\n";
		
		//
		$check_term_exist = term_exists( $v, $_POST['t_taxonomy'] );
//		print_r( $check_term_exist );
		if ( $check_term_exist !== 0 && $check_term_exist !== null ) {
			echo '<script>parent.WGR_after_create_taxonomy("' . $v . ' (<span class=redcolor>EXIST</span>)");</script>';
		}
		else {
			$done = wp_insert_term(
				$v, // the term 
				$_POST['t_taxonomy'], // the taxonomy
				array(
//					'description'=> 'A yummy apple.',
//					'slug' => 'apple',
					'parent'=> (int) $_POST['t_ant']  // get numeric term id
				)
			);
			
			//
//			print_r( $done );
			if ( isset( $done['errors'] ) || isset( $done->errors ) ) {
				echo '<script>parent.WGR_after_create_taxonomy("' . $v . ' (ERROR)");</script>';
			}
			else {
				echo '<script>parent.WGR_after_create_taxonomy("' . $v . ' (<span class=greencolor>OK</span>)");</script>';
			}
		}
	}
}






