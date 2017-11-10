<p>* Chức năng này sẽ tạo thử một file thông qua hàm của php, file được tạo sẽ nằm trong thư mục gốc của code. Nếu file tạo thành công nghĩa là host này có thể nhúng và thêm mới bất kỳ file nào từ code, điều này làm tăng khả năng mất an toàn cho website mà thi thoảng có những website bị dính link bẩn.</p>
<br>
<?php




//
$file_test = ABSPATH . 'test_local_attack.txt';



//
if ( file_exists( $file_test ) ) {
//	unlink($file_test) or die('Không xóa được file test cũ, vui lòng xóa đi rồi thử lại');
	_eb_remove_file($file_test);
}


//
_eb_create_file( $file_test, date_time, '', 0 );



// kiểm tra xem file có tạo thành công không
// thành công -> host này có thể hack bằng local attack được
if ( file_exists( $file_test ) ) {
	echo '<h2 style="color:#f00;">Host không an toàn! có nguy cơ bị local attack</h2>';
}
// không nghĩa là khó hack hơn
else {
	echo '<h2 style="color:#00f;">Host an toàn! đã hạn chế local attack</h2>';
}



