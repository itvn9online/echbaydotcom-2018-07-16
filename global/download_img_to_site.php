<?php



//print_r( $_GET );
if ( ! isset( $_GET['img'] ) ) {
	die('img not found!');
}

if ( ! isset( $_GET['file_name'] ) ) {
	die('file_name not found!');
}

//
$file_source = $_GET['img'];


// thư mục download
$save_to = ABSPATH . 'ebarchive/';
//echo $save_to . '<br>' . "\n";

// tạo thư mục để download ảnh về
EBE_create_dir( $save_to, 1, 0777 );

// file download
$file_name = $_GET['file_name'];
$save_to .= $file_name;
//echo $save_to . '<br>' . "\n";
if ( ! file_exists( $save_to ) ) {
	//
//	set_time_limit(0);
	
	if( copy( $file_source, $save_to ) ) {
		chmod($save_to, 0777) or die('ERROR chmod file: ' . $save_to);
	} else {
		die('ERROR copy file');
	}
}
else {
	echo 'file exist!';
}

//
$save_to = str_replace( ABSPATH, web_link, $save_to );
//echo $save_to . '<br>' . "\n";


//
if ( isset( $_GET['show_url_img'] ) ) {
	die( $save_to );
}


//
echo '<script>
if ( top != self ) {
	parent.finish_download_img_other_domain_of_content("' . $save_to . '");
}
</script>';




exit();



