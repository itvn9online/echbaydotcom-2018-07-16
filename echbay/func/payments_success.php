<?php

if ( ! isset ( $_GET ['ApiUser'] ) || ! isset ( $_GET ['ApiKey'] ) || ! isset ( $_GET ['ApiCode'] ) ) {
	$m_error = 'Billing error parameter not found';
	$func->log_user ( $m_error );
	die ( '<h2>' . $m_error . '</h2>' );
}




$tv_id = ( int ) $_GET ['ApiUser'];
$ApiKey = trim ( $_GET ['ApiKey'] );
$hd_mahoadon = trim ( $_GET ['ApiCode'] );




// so sánh ID user -> không bảo mật
//if ( $func->mdnam ( $tv_id ) != $ApiKey ) {
// so sánh mã đơn, bảo mật hơn
if ( $func->mdnam ( $hd_mahoadon ) != $ApiKey ) {
	$m_error = 'Billing error token failed';
	$func->log_user ( $m_error );
	die ( '<h2>' . $m_error . '</h2>' );
}



// kiểm tra mã hóa đơn này có tồn tại không
$sql = $func->q ( "SELECT *
	FROM
		tbl_in_con_voi
	WHERE
		hd_mahoadon = '" . $hd_mahoadon . "'
		AND tv_id = " . $tv_id . "
	ORDER BY
		hd_id
	LIMIT 0, 1" );
// nếu có -> kiểm tra tiếp và nạp tiền cho thành viên
if ( mysqli_num_rows ( $sql ) > 0 ) {
	$row = mysqli_fetch_assoc ( $sql );
	$hd_id = ( int ) $row ['hd_id'];
	$hd_trangthai = ( int ) $row ['hd_trangthai'];
	$hd_gia = ( int ) $row ['hd_gia'];
//	$tv_id = ( int ) $row ['tv_id'];
	
	
	//  chỉ nạp khi trạng thái đơn là 0
	if ( $hd_trangthai == 0 ) {
		$pending_status = 8;
		
		
		// kiểm tra xem trong 24 giờ qua có đơn nào tương tự không, vì chỉ ứng trước cho thành viên 1 lần/ ngày
		/*
		$sql = $func->q ( "SELECT hd_id
		FROM
			tbl_in_con_voi
		WHERE
			hd_trangthai = " . $hd_trangthai . "
			AND hd_ngaythanhtoan > " . ($date_time - 24 * 3600) . "
			AND tv_id = " . $tv_id . "
		LIMIT 0, 1" );
		
		
		// nếu có ròi -> bỏ qua
		if (mysqli_num_rows ( $sql ) > 0) {
			$pending_status = 1;
		}
		// nếu chưa có -> ứng trước cho thành viên để có thể sử dụng dịch vụ ngay lập tức
		else {
			*/
			$func->q ( "UPDATE tbl_thanhvien
			SET
				tv_money = tv_money + " . $hd_gia . "
			WHERE
				tv_id = " . $tv_id );
//		}
		
		
		
		// cập nhật trạng thái đơn mới
		$func->q ( "UPDATE tbl_in_con_voi
		SET
			hd_ngaythanhtoan = " . $date_time . ",
			hd_trangthai = " . $pending_status . "
		WHERE
			hd_id = " . $hd_id . "
			AND hd_mahoadon = '" . $hd_mahoadon . "'
			AND tv_id = " . $tv_id );
	}
} else {
	$func->log_user( 'Payment success, but info not found' );
}




//
include $dir_index . 'includes/billing.php';



