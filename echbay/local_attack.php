<p>* Chức năng này sẽ tạo thử một file thông qua hàm của php, file được tạo sẽ nằm trong thư mục gốc của code. Nếu file tạo thành công nghĩa là host này có thể nhúng và thêm mới bất kỳ file nào từ code, điều này làm tăng khả năng mất an toàn cho website mà thi thoảng có những website bị dính link bẩn.</p>
<br>
<?php




//
$file_check = 'wp-config.php';
$file_test = 'test_local_attack.txt';


// tìm thư mục gốc của code để kiểm tra xem thêm mới file có cần set 777 hay không
for ( $i = 0; $i < 20; $i++ ) {
	$file_check = '../' . $file_check;
	$file_test = '../' . $file_test;
	
	
	// tìm thấy file config -> thư mục gốc -> test
	if ( file_exists( $file_check ) ) {
//		echo $file_check . '<br>';
		
		//
		$file_ = $file_test;
		$content_ = 'Test local attack: ' . date( 'r', time() );
		
		// có rồi thì xóa đi tạo lại
		if ( file_exists($file_) ) {
			unlink($file_) or die('Không xóa được file test cũ, vui lòng xóa đi rồi thử lại');
		}
		
		// tạo mới
		$fh = fopen($file_, 'x+') or die('<h2 style="color:#00f;">Không tạo được file test. Host an toàn!</h2>');
		
		// chmod 777 để sau còn sửa được
		chmod($file_, 0777);
		
		// thêm nội dung test
		fwrite($fh, $content_);
		
		// kết thúc
		fclose($fh);


		
		// kiểm tra xem file có tạo thành công không
		// thành công -> host này có thể hack bằng local attack được
		if ( file_exists( $file_test ) ) {
			echo '<h2 style="color:#f00;">Host không an toàn! có nguy cơ bị local attack</h2>';
			
			// test xong cứ để file test ở đó thôi, khách hàng nhìn thấy thì coi như cảnh báo họ
		}
		// không nghĩa là khó hack hơn
		else {
			echo '<h2 style="color:#00f;">Host an toàn! đã hạn chế local attack</h2>';
		}
		
		// xong thì thoát thôi
		break;
	}
}



