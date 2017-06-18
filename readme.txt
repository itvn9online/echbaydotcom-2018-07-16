=== EchBay e-Commecre Plugin for Wordpress ===
Plugin Name: EchBay Facebook Messenger
Plugin URI: https://www.facebook.com/webgiare.org
Description: Free code by itvn9online. Create e-commerce website with wordpress.
Author: Dao Quoc Dai
Author URI: https://www.facebook.com/ech.bay
Text Domain: echbayecom
Tags: e-commerce
Requires at least: 3.3
Tested up to: 4.8
Stable tag: 1.0.0
Version: 1.0.0
Contributors: itvn9online
Donate link: https://paypal.me/itvn9online/5


=== Hướng dẫn cài đặt ===
1. Download plugin chính tại địa chỉ https://github.com/itvn9online/echbaydotcom/archive/master.zip, sau đó giải nén file zip sẽ thu được thư mục `echbaydotcom` hoặc `echbaydotcom-master`, copy thư mục này vào thư mục `wp-content` của wordpress rồi đổi tên thành `echbaydotcom`.
2. Download theme mặc định (mẫu) tại địa chỉ https://github.com/itvn9online/echbaytwo/archive/master.zip, sau đó giải nén và cho vào thư mục `wp-content/themes/`
3. Trong admin của wordpress, vào phần `Giao diện` hoặc `Appearance` (bản tiếng Anh), chọn và kích hoạt theme `EchBay Two` để bắt đầu sử dụng plugin này.


=== Hướng dẫn sử dụng ===
I - Thiết lập cài đặt cho website (lưu ý, thay webgiare.org bằng tên miền chính của bạn):
	1. Menu chính: http://www.webgiare.org/wp-admin/admin.php?page=eb-order: đây là hệ thống quản trị đơn hàng trên website.
	2. Cấu hình website:
		a. Cài đặt chung https://www.webgiare.org/wp-admin/admin.php?page=eb-config&tab=meta-home:
			- Chế độ kiểm thử: là chế độ khi website trong quá trình test, các file tĩnh sẽ được in ra dưới dạng kiểm thử để code kiểm tra lỗi dễ dàng hơn.
			- Nội dung thẻ META mặc định: là bộ thẻ TITLE, KEYWORDS, DESCRIPTION... mặc định cho website khi sử dụng plugin SEO của EchBay.
			- Google plugin: khi nhập liệu vào các trường tương ứng thì module tương ứng của google sẽ được kích hoạt.
			- URL trang chính: tên miền chính của bạn là gì thì hãy nhập đầy đủ vào đây, phân định giữa https và http, www và không có www. Nếu chưa rõ cách nhập, có thể xóa trắng đi để hệ thống tự tạo theo mẫu tối ưu nhất.
		b. Nâng cao https://www.webgiare.org/wp-admin/admin.php?page=eb-config&tab=advanced:
			- Logo: thay đổi Logo và Favicon cho website bằng cách nhập url vào ô nhập liệu.
			- Màu cơ bản: nếu theme đi kèm plugin EchBay được viết theo đúng tiêu cấu hình chung thì bạn có thể sử dụng module này để thay đổi màu sắc cho website một cách dễ dàng.
			- Kích thước tiêu chuẩn hình ảnh/ clip: bao gồm các thiết lập liên quan để tỷ lệ ảnh cho weebsite như: ảnh sản phẩm, ảnh bài viết, chất lượng ảnh trên các phiên bản Desktop, Table, Mobile...
		c. Phân trang https://www.webgiare.org/wp-admin/admin.php?page=eb-config&tab=part-page:
			- Phân trang cho Trang chủ: một số module riêng sẽ sử dụng các con số ở đây để phân trang, còn thông thường sẽ sử dụng luôn cài đặt riêng của widget: https://www.webgiare.org/wp-admin/widgets.php
			- Phân trang cho Trang chi tiết Sản phẩm: đây là số bài viết đi kèm, bài viết liên quan trong mục Chi tiết sản phẩm hoặc Chi tiết bài viết (blog).
		d. Dữ liệu và Đồng bộ https://www.webgiare.org/wp-admin/admin.php?page=eb-config&tab=cache:
			- Thời gian lưu cache: cache là chế độ tạo file tĩnh, giúp website chạy mượt mà hơn nhiều lần. Trong trường hợp cần kiểm thử lỗi, hãy chọn `Không sử dụng` để tắt tạm thời tính năng này đi. Hoặc khi đăng nhập bằng tài khoản quản trị, tính năng cache cũng bị bỏ qua.

