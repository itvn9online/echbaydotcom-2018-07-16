=== EchBay e-Commecre Plugin for Wordpress ===
Plugin Name: EchBay e-Commecre Website
Plugin URI: https://www.facebook.com/webgiare.org
Description: Free code by itvn9online. Create e-commerce website with wordpress.
Author: Dao Quoc Dai
Author URI: https://www.facebook.com/ech.bay
Text Domain: echbayecom
Tags: e-commerce
Requires at least: 3.3
Tested up to: 4.8
Stable tag: 1.0.9
Version: 1.0.9
Contributors: itvn9online
Donate link: https://paypal.me/itvn9online/5


=== HƯỚNG DẪN CÀI ĐẶT ===
1. Download plugin chính tại địa chỉ https://github.com/itvn9online/echbaydotcom/archive/master.zip, sau đó giải nén file zip sẽ thu được thư mục `echbaydotcom` hoặc `echbaydotcom-master`, copy thư mục này vào thư mục `wp-content` của wordpress rồi đổi tên thành `echbaydotcom`.

2. Download theme mặc định (mẫu) tại địa chỉ https://github.com/itvn9online/echbaytwo/archive/master.zip, sau đó giải nén và cho vào thư mục `wp-content/themes/`

3. Trong admin của wordpress, vào phần `Giao diện` hoặc `Appearance` (bản tiếng Anh), chọn và kích hoạt theme `EchBay Two` để bắt đầu sử dụng plugin này.

4. Hình ảnh và các tệp tin khác sẽ được wordpress lưu tại thư mục `wp-content/uploads`, nếu kiểm tra thấy chưa có thư mục này thì bạn chủ động tạo và set permission 777 cho nó.

5. Sử dụng web, mọi vấn đề thắc mắc hoặc yêu cầu trợ giúp vui lòng gửi qua email: lienhe@echbay.com hoặc gửi câu hỏi tại nhóm support riêng ở đây: https://www.facebook.com/groups/wordpresseb/


=== HƯỚNG DẪN SỬ DỤNG ===
I - Thiết lập cài đặt cho website (lưu ý, thay www.webgiare.org bằng tên miền chính của bạn):
	1. Menu chính: http://www.webgiare.org/wp-admin/admin.php?page=eb-order: đây là hệ thống quản trị đơn hàng trên website.
	
	2. Cấu hình website:
		a. Cài đặt chung http://www.webgiare.org/wp-admin/admin.php?page=eb-config&tab=meta-home:
			- Chế độ kiểm thử: là chế độ khi website trong quá trình test, các file tĩnh sẽ được in ra dưới dạng kiểm thử để code kiểm tra lỗi dễ dàng hơn.
			- Nội dung thẻ META mặc định: là bộ thẻ TITLE, KEYWORDS, DESCRIPTION... mặc định cho website khi sử dụng plugin SEO của EchBay.
			- Google plugin: khi nhập liệu vào các trường tương ứng thì module tương ứng của google sẽ được kích hoạt.
			- URL trang chính: tên miền chính của bạn là gì thì hãy nhập đầy đủ vào đây, phân định giữa https và http, www và không có www. Nếu chưa rõ cách nhập, có thể xóa trắng đi để hệ thống tự tạo theo mẫu tối ưu nhất.
		b. Nâng cao http://www.webgiare.org/wp-admin/admin.php?page=eb-config&tab=advanced:
			- Logo: thay đổi Logo và Favicon cho website bằng cách nhập url vào ô nhập liệu.
			- Màu cơ bản: nếu theme đi kèm plugin EchBay được viết theo đúng tiêu chuẩn cấu hình chung thì bạn có thể sử dụng module này để thay đổi màu sắc cho website một cách dễ dàng.
			- Kích thước tiêu chuẩn hình ảnh/ clip: bao gồm các thiết lập liên quan để tỷ lệ ảnh cho weebsite như: ảnh sản phẩm, ảnh bài viết, chất lượng ảnh trên các phiên bản Desktop, Table, Mobile...
		c. Phân trang http://www.webgiare.org/wp-admin/admin.php?page=eb-config&tab=part-page:
			- Phân trang cho Trang chủ: một số module riêng sẽ sử dụng các con số ở đây để phân trang, còn thông thường sẽ sử dụng luôn cài đặt riêng của widget: http://www.webgiare.org/wp-admin/widgets.php
			- Phân trang cho Trang chi tiết Sản phẩm: đây là số bài viết đi kèm, bài viết liên quan trong mục Chi tiết sản phẩm hoặc Chi tiết bài viết (blog).
		d. Dữ liệu và Đồng bộ http://www.webgiare.org/wp-admin/admin.php?page=eb-config&tab=cache:
			- Thời gian lưu cache: cache là chế độ tạo file tĩnh, giúp website chạy mượt mà hơn nhiều lần. Trong trường hợp cần kiểm thử lỗi, hãy chọn `Không sử dụng` để tắt tạm thời tính năng này đi. Hoặc khi đăng nhập bằng tài khoản quản trị, tính năng cache cũng bị bỏ qua.
			- Dọn sạch bộ nhớ đệm: trong một số trường hợp, bộ nhớ đệm bị lỗi hoặc bạn muốn dọn sạch bộ nhớ đệm, hãy sử dụng chức năng này.
			- DNS prefetch: nếu bạn có hệ thống CDN riêng, hãy nhập URL của CDN để sử dụng cho các tệp trong mục Media của website.
		e. Thông tin liên hệ http://www.webgiare.org/wp-admin/admin.php?page=eb-config&tab=contact:
			- Là các thông tin riêng về đơn vị chủ quản của website, phục vụ cho việc trình bày giao diện website.
		f. Thiết lập gửi mail http://www.webgiare.org/wp-admin/admin.php?page=eb-config&tab=smtp:
			- EchBay.com free e-mail: tính năng dành riêng cho khách hàng sử dụng hosting cung cấp bởi Ếch Bay, email được cung cấp bởi các nhà cung cấp dịch vụ Email hàng đầu nên chất lượng email cũng tốt hơn.
			- Email nhận thông báo: mặc định, email thông báo sẽ được gửi thông qua email liên hệ (trong phần: http://www.webgiare.org/wp-admin/admin.php?page=eb-config&tab=contact), trường hợp muốn thông báo gửi về email khác, hãy nhập email mới vào đây.
			- Các trường dữ liệu khác: là thông tin tài khoản SMTP để hệ thống sử dụng và gửi email thông qua trình PHPMailler.
		g. Mạng xã hội http://www.webgiare.org/wp-admin/admin.php?page=eb-config&tab=social:
			- Bao gồm các thiết lập liên quan đến Fanpage Facebook, Google+, Youtube... dùng để hiển thị các trang, liên kết mạng xã hội lên website của bạn.
		h. Mã nhúng ngoài http://www.webgiare.org/wp-admin/admin.php?page=eb-config&tab=outsource:
			- Thông thường trong mỗi website, ngoài các mã chính thì còn bao gồm cả các mã nhúng khác như Re-marketing, widget chat... bạn có thể nhập mã đó vào đây để sử dụng. Tùy theo yêu cầu, mã nào quan trọng thì nhúng vào phần HEAD, mã nào không quan trọng thì nhúng vào phần BODY.
			* Module này bị giới hạn bởi độ linh động, nên chúng tôi phát triển riêng một plugin khác cho việc gắn mã nhúng, bạn có thể download tại đây: https://wordpress.org/plugins/echbay-tag-manager/, sau khi cài đặt xong, việc điều khiển mã nhúng sẽ diễn ra tại liên kết này: http://www.webgiare.org/wp-admin/admin.php?page=echbay-tag-manager
		i. Vị trí địa lý http://www.webgiare.org/wp-admin/admin.php?page=eb-config&tab=map:
			- Chức năng dành cho việc SEO localtion, áp dụng cho trường hợp sử dụng Plugin SEO by EchBay. Mặc định, khi sử dụng các trình duyệt đời mới thì có thể nhấn nút `Tự động định vị` để hệ thống tự làm, còn không, bạn hãy tự điền thủ công.
		j. Tính năng khác http://www.webgiare.org/wp-admin/admin.php?page=eb-config&tab=permalinks:
			- Chia sẻ dữ liệu qua JSON: tính năng này sẽ hữu dụng khi bạn có hệ thống website vệ tinh phục vụ SEO. Trường hợp bạn chỉ có một website thì có thể tắt nó đi hoặc để nguyên cũng không ảnh hưởng gì.
			- Xóa URL phân nhóm cha: mặc định, URL category sẽ xuất hiện, điều này được wordpress khuyên dùng vì nó tốt cho SEO, nếu bạn thấy vướng víu, có thể sử dụng module này để loại bỏ nó đi.
			- EchBay SEO plugin: là plugin SEO được viết riêng cho theme của EchBay, tuy nhiên, về độ mở rộng thì chưa ăn được các plugin SEO chuyên biệt khác như Yoast SEO, SEO Ultimate... trường hợp bạn muốn sử dụng plugin SEO khác, hãy tắt plugin SEO by EchBay đi để tránh xung đột.
			- Cung cấp bởi Ếch Bay: mọi theme viết bởi EchBay đều có chữ `Cung cấp bởi Ếch Bay` ở cuối trang, sử dụng chức năng này để ẩn hiện dòng chữ đó.
			- AMP cho danh mục sản phẩm, AMP cho danh mục blogs, AMP cho chi tiết blog: tính năng AMP có thể bật tắt tùy theo nhu cầu riêng của mỗi khách hàng.

	3. Kỹ thuật http://www.webgiare.org/wp-admin/admin.php?page=eb-coder:
		a. Ngôn ngữ http://www.webgiare.org/wp-admin/admin.php?page=eb-coder&tab=languages:
			- Tính năng chưa hoàn thiện.
		b. 404 Monitor http://www.webgiare.org/wp-admin/admin.php?page=eb-coder&tab=404_monitor:
			- Dùng để theo dõi các URL bị 404 trên website, phục vụ cho việc SEO được dễ dàng hơn.
		c. Sitemap http://www.webgiare.org/wp-admin/admin.php?page=eb-coder&tab=sitemap:
			- Chức năng tự động tạo sitemap cho website, tự động cập nhật mỗi 6 tiếng một lần.
		d. Robots http://www.webgiare.org/wp-admin/admin.php?page=eb-coder&tab=robots:
			- Chức năng tạo và cập nhật nội dung cho file robots.txt
	
	4. Cài đặt giao diện http://www.webgiare.org/wp-admin/admin.php?page=eb-config_theme&tab=theme-chung:
		a. Chung http://www.webgiare.org/wp-admin/admin.php?page=eb-config_theme&tab=theme-chung:
			- Thiết lập chiều rộng mặc định cho website, các module không được liệt kê trong danh sách tiếp theo sẽ sử dụng chiều rộng được thiết lập ở đây.
		b. Trang chủ (Home) http://www.webgiare.org/wp-admin/admin.php?page=eb-config_theme&tab=theme-home:
			- Thiết lệp chiều rộng và bố cục website ở `Trang chủ`.
		c. Danh sách sản phẩm (Category) http://www.webgiare.org/wp-admin/admin.php?page=eb-config_theme&tab=theme-list:
			- Thiết lệp chiều rộng và bố cục website ở trang `Danh sách sản phẩm`.
		d. Chi tiết sản phẩm (Post) http://www.webgiare.org/wp-admin/admin.php?page=eb-config_theme&tab=theme-details:
			- Thiết lệp chiều rộng và bố cục website ở trang `Chi tiết sản phẩm`.
		e. Blog/ Tin tức http://www.webgiare.org/wp-admin/admin.php?page=eb-config_theme&tab=theme-blog:
			- Thiết lệp chiều rộng và bố cục website ở trang `Blog/ Tin tức`.
		f. Chi tiết Blog/ Tin tức http://www.webgiare.org/wp-admin/admin.php?page=eb-config_theme&tab=theme-blog-detais:
			- Thiết lệp chiều rộng và bố cục website ở trang `Chi tiết Blog/ Tin tức`.
		g. Trang tĩnh (Page) http://www.webgiare.org/wp-admin/admin.php?page=eb-config_theme&tab=theme-page:
			- Thiết lệp chiều rộng và bố cục website ở trang `Trang tĩnh`.


=== BẢN QUYỀN ===
1. Nếu không có gì bất cập, vui lòng không xóa các link liên quan đến tác giả và website của tác giả. Các link này (nếu có), tác giả đã cố gắng đặt các thuộc tính như rel="nofollow", target="_blank" để tránh ảnh hưởng đến website của khách hàng.

2. Mã nguồn của các bên thứ ba được sử dụng chung chủ yếu là các mã nguồn nổi tiếng và đảm bảo bởi một tổ chức uy tín như GitHub (PHPMailler), Google (jQuery, Font Awesome). Các mã nguồn này sẽ được đặt trong thư mục có tên là outsource để khách hàng tiện kiểm tra, đối chiếu hoặc tự cập nhật mã nguồn lên phiên bản mới hơn nếu cần thiết.

3. Khách hàng có thể nhân bản web lên thành nhiều bản, tuy nhiên, chỉ các bản trả phí trực tiếp cho tác giả mới nhận được hỗ trợ và bảo hành, các bản khác khách hàng chủ động quản lý và cập nhật theo.


=== CẬP NHẬT MÃ NGUỒN ===
- Plugin: mã nguồn có hỗ trợ cập nhật miễn phí thông qua chức năng cập nhật core: http://www.webgiare.org/wp-admin/admin.php?page=eb-coder&tab=echbay_update_core, bạn có thể cập nhật hoặc cài đặt lại bất cứ khi nào bạn muốn.

- Theme: mặc định, theme không được hỗ trợ cập nhật tự động hoặc thông qua module riêng, chỉ có thể cập nhật thủ công bởi code.


=== CÁC PLUGINS KHUYÊN DÙNG ===
- Thông thường, các tính năng được chúng tôi viết dưới dạng plugin nhằm mục đích phục vụ cả các website không sử dụng theme của EchBay, các plugins này được liệt kê tại đây https://wordpress.org/plugins/search/dao+quoc+dai/.
Nếu bạn sử dụng theme được viết bởi EchBay thì các plugin này gần như là cần thiết hết. Bạn yên tâm là các plugin được viết dưới dạng short code nên rất nhẹ, ngoài ra còn hệ thống cache đi kèm nên không có sự ảnh hưởng nào tới độ trễ webiste của bạn.



=== CÁC THAY ĐỔI QUAN TRỌNG ===
= Version 1.0.5 =
* Thêm chức năng phân trang cho sitemap.xml tăng giới hạn sitemap lên 99,000 bản ghi. Hỗ trợ thêm sitemap image theo chuẩn google. Xem thêm: https://www.facebook.com/groups/wordpresseb/permalink/500753096956466/

= Version 1.0.4 =
* Chuyển các thư mục của theme ra ngoài thư mục gốc.
* Thêm tính năng chỉnh sửa nhanh bài viết, nhóm...

= Version 1.0.3 =
* Cập nhật chức năng tìm kiếm theme theo tên.

= Version 1.0.2 =
* Tối ưu lại hệ thống quảng cáo (ads post_type).
* Tinh chỉnh lại các rule, xóa các rewrite không cần thiết.
* Cập nhật lại sitemap: thời gian update site map thành 3 tiếng, thêm CSS cho sitemap, thêm ngày cập nhật cuối cho phần bài viết.

= Version 1.0.1 =
* Thêm các chức năng lắp ghép giao diện, tự tạo giao diện riêng từ kho có sẵn.

= Version 1.0.0 =
* None



* BY EchBay.com - Webgiare.org
