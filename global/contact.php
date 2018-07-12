<?php

$__cf_row ['cf_title'] = EBE_get_lang('lh_lienhe');
$group_go_to[] = ' <li><a href="' . _eb_full_url() . '" rel="nofollow">' . $__cf_row ['cf_title'] . '</a></li>';


//
$__cf_row ['cf_title'] .= ': ' . web_name . ' - ' . $__cf_row ['cf_abstract'];
$__cf_row ['cf_keywords'] = $__cf_row ['cf_title'];
$__cf_row ['cf_description'] = $__cf_row ['cf_title'];




// kiểm tra nếu có file html riêng -> sử dụng html riêng
/*
$check_html_rieng = EB_THEME_HTML . 'contact.html';
$thu_muc_for_html = EB_THEME_HTML;
if ( ! file_exists($check_html_rieng) ) {
	$thu_muc_for_html = EB_THEME_PLUGIN_INDEX . 'html/';
}

//
$main_content = EBE_str_template ( 'contact.html', array (
	'tmp.cf_diachi' => nl2br( $__cf_row['cf_diachi'] ),
	'tmp.cf_email' => $__cf_row['cf_email'],
), $thu_muc_for_html );
*/

//
$main_content = EBE_html_template( EBE_get_page_template( $act ), array(
	'tmp.cf_diachi' => nl2br( $__cf_row['cf_diachi'] ),
	'tmp.cf_email' => $__cf_row['cf_email'],
	
	// lang
	'tmp.lh_lienhe' => EBE_get_lang('lh_lienhe'),
	'tmp.lh_luuy' => EBE_get_lang('lh_luuy'),
	'tmp.lh_hoten' => EBE_get_lang('lh_hoten'),
	'tmp.lh_diachi' => EBE_get_lang('lh_diachi'),
	'tmp.lh_dienthoai' => EBE_get_lang('lh_dienthoai'),
	'tmp.lh_noidung' => EBE_get_lang('lh_noidung'),
	'tmp.lh_submit' => EBE_get_lang('lh_submit'),
	'tmp.lh_note' => EBE_get_lang('lh_note'),
	'tmp.cart_hotline' => EBE_get_lang('cart_hotline'),
) );




