<?php



/*
* Tạo các bảng riêng cho plugin của echbay
*/

$strCacheFilter = 'admin-create-echbay-table-v2';
$check_Cleanup_cache = _eb_get_static_html ( $strCacheFilter, '', '', 6 * 3600 );
if ($check_Cleanup_cache == false) {
	
	// tạo bảng hóa đơn nếu chưa có
	EBE_tao_bang_hoa_don_cho_echbay_wp();
	
	// tạo bảng lưu trữ các bài viết sẽ xóa vĩnh viễn
	$arr_post_xml = array(
		'bpx_id' => array(
			'type' => 'bigint(20)',
			'null' => 'no',
			'key' => 'pri',
			'default' => '',
			'extra' => 'auto_increment',
		),
		// Nội dung file xml
		'bpx_content' => array(
			'type' => 'longtext',
			'null' => 'no',
			'key' => '',
			'default' => '',
			'extra' => '',
		),
		'bpx_agent' => array(
			'type' => 'varchar(255)',
			'null' => 'no',
			'key' => '',
			'default' => '',
			'extra' => '',
		),
		'bpx_ip' => array(
			'type' => 'varchar(191)',
			'null' => 'no',
			'key' => 'mul',
			'default' => '',
			'extra' => '',
		),
		'bpx_time' => array(
			'type' => 'bigint(20)',
			'null' => 'no',
			'key' => '',
			'default' => '',
			'extra' => '',
		),
		'bpx_date' => array(
			'type' => 'bigint(20)',
			'null' => 'no',
			'key' => 'mul',
			'default' => '',
			'extra' => '',
		),
		'post_id' => array(
			'type' => 'bigint(20)',
			'null' => 'no',
			'key' => 'mul',
			'default' => '',
			'extra' => '',
		),
		'tv_id' => array(
			'type' => 'bigint(20)',
			'null' => 'no',
			'key' => 'mul',
			'default' => '',
			'extra' => '',
		)
	);
	
	// bảng lưu trữ post trước khi xóa
	EBE_create_in_con_voi_table( 'eb_backup_post_xml', 'bpx_id', $arr_post_xml );
	
	// bảng post dưới dạng XML (max post -> không xóa)
	EBE_create_in_con_voi_table( 'eb_post_xml', 'bpx_id', $arr_post_xml );
	
	
	
	// Bảng lưu tất cả các thể loại log
	EBE_create_in_con_voi_table( 'eb_wgr_log', 'l_id', array(
		'l_id' => array(
			'type' => 'bigint(20)',
			'null' => 'no',
			'key' => 'pri',
			'default' => '',
			'extra' => 'auto_increment',
		),
		// Nội dung log
		'l_noidung' => array(
			'type' => 'text',
			'null' => 'no',
			'key' => '',
			'default' => '',
			'extra' => '',
		),
		'l_agent' => array(
			'type' => 'varchar(255)',
			'null' => 'no',
			'key' => '',
			'default' => '',
			'extra' => '',
		),
		'l_ip' => array(
			'type' => 'varchar(191)',
			'null' => 'no',
			'key' => 'mul',
			'default' => '',
			'extra' => '',
		),
		'l_ngay' => array(
			'type' => 'bigint(20)',
			'null' => 'no',
			'key' => '',
			'default' => '',
			'extra' => '',
		),
		'l_type' => array(
			'type' => 'bigint(20)',
			'null' => 'no',
			'key' => 'mul',
			'default' => '',
			'extra' => '',
		),
		'hd_id' => array(
			'type' => 'bigint(20)',
			'null' => 'no',
			'key' => 'mul',
			'default' => '',
			'extra' => '',
		),
		'post_id' => array(
			'type' => 'bigint(20)',
			'null' => 'no',
			'key' => 'mul',
			'default' => '',
			'extra' => '',
		),
		'tv_id' => array(
			'type' => 'bigint(20)',
			'null' => 'no',
			'key' => 'mul',
			'default' => '',
			'extra' => '',
		)
	) );
	
	
	
	// ép lưu cache
	_eb_get_static_html ( $strCacheFilter, date( 'r', date_time ), '', 60 );
	
}




