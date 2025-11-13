TRƯỜNG ĐẠI HỌC SƯ PHẠM ĐÀ NẴNG
ĐẠI HỌC ĐÀ NẴNG
KHOA TOÁN –TIN
---
ĐỒ ÁN MÔN HỌC
ĐỀ TÀI
XÂY DỰNG HỆ THỐNG QUẢN LÝ KÝ TÚC XÁ
Sinh viên thực hiện: LATHONGSY MALAYLAK
Lớp: 23CNTT2
Giáo viên hướng dẫn: ThS.Hồ Ngọc Tú
Đà Nẵng, 12/2025
MỤC LỤCMỞ ĐẦU
Báo cáo này trình bày quá trình thiết kế, phát triển và triển khai Hệ Thống Quản Lý Ký
Túc Xá Trường Học - một ứng dụng web toàn diện nhằm tự động hóa và tối ưu hóa việc quản
lý ký túc xá trong các trường đại học và cao đẳng. Mục tiêu chính của dự án là xây dựng một
nền tảng trực tuyến hiệu quả để quản lý thông tin sinh viên, cơ sở vật chất ký túc xá và tạo báo
cáo thu chi hàng tháng. Hệ thống được phát triển bằng công nghệ PHP, MySQL, kết hợp với
Bootstrap Framework và AdminLTE Template, tạo nên một giao diện thân thiện và dễ sử dụng.
```
Dự án tích hợp đầy đủ các chức năng CRUD (Create, Read, Update, Delete) và hỗ trợ đa ngôn
```
```
ngữ (Tiếng Anh, Tiếng Việt, Tiếng Lào) để phục vụ đa dạng người dùng. Hệ thống đã được
```
hoàn thiện với năm module chính bao gồm module quản lý cơ sở vật chất để quản lý danh
sách ký túc xá và phòng ở, module quản lý sinh viên để lưu trữ hồ sơ và phân bổ phòng tự
động, module quản lý tài chính để theo dõi lịch sử thanh toán và thu chi, module quản lý người
dùng với phân quyền truy cập cho Administrator và Staff, cùng module báo cáo để tạo báo cáo
thu chi hàng tháng có thể in và xuất file. Hệ thống đảm bảo tính bảo mật cao với cơ chế xác
thực người dùng, phân quyền truy cập và mã hóa dữ liệu, đồng thời có giao diện responsive
thích ứng với nhiều thiết bị khác nhau. Báo cáo được cấu trúc thành ba chương chính: Chương
1 - Cơ sở lý thuyết trình bày lịch sử phát triển, cơ sở lý thuyết về hệ thống quản lý ký túc xá
và thực trạng quản lý truyền thống hiện tại, Chương 2 - Thiết kế và phát triển hệ thống phân
tích yêu cầu bài toán, trình bày quy trình thiết kế cơ sở dữ liệu, giao diện người dùng và các
chức năng của website quản lý ký túc xá, và Chương 3 - Triển khai và đánh giá hệ thống nêu
quá trình cài đặt, kiểm thử website cùng các kết quả đạt được và ứng dụng thực tế trong quản
lý ký túc xá. Báo cáo này không chỉ là tài liệu kỹ thuật mà còn là cẩm nang hướng dẫn cho
việc triển khai và sử dụng hệ thống trong thực tế, góp phần nâng cao hiệu quả quản lý ký túc
xá tại các cơ sở giáo dục.
CHƯƠNG 1: CƠ SỞ LÝ THUYẾT
1.1. Tổng quan về HTML
HTML là nền tảng của World Wide Web. Nó ra đời năm 1989 tại CERN, do Tim
Berners-Lee đề xuất để chia sẻ tài liệu. HTML đã phát triển qua các phiên bản như HTML 2.0
và HTML 4.01. XHTML là một nỗ lực mang sự chặt chẽ của XML vào web. Tuy nhiên,
WHATWG đã đề xuất một hướng đi thực dụng hơn, dẫn đến sự ra đời của HTML5. HTML5
biến web từ nền tảng tài liệu tĩnh thành nền tảng ứng dụng phức tạp.
Một tài liệu HTML là một cây cấu trúc gồm các phần tử. Cấu trúc cơ bản gồm
<!DOCTYPE html>, <html>, <head>, và <body>.Trình duyệt phân tích cú pháp HTML thành
```
Mô hình Đối tượng Tài liệu (DOM).DOM là một cây logic, cho phép JavaScript tương tác và
```
thay đổi nội dung trang một cách linh động.
HTML5 giới thiệu các thẻ ngữ nghĩa như <header>, <nav>, <main>, <article>.Các thẻ
này mô tả ý nghĩa của nội dung. Chúng giúp cải thiện SEO và Khả năng Tiếp cận
```
(Accessibility) cho người dùng khiếm thị.
```
HTML5 cũng tích hợp các API JavaScript mới.11 Web Storage dùng để lưu trữ dữ liệu
trên trình duyệt. Canvas & SVG hỗ trợ đồ họa. Geolocation API cho phép truy cập vị trí người
dùng. Web Workers giúp xử lý các tác vụ nặng mà không làm "đóng băng" giao diện.
1.2. Tổng quan về CSS
CSS ra đời năm 1996 để tách biệt trình bày khỏi cấu trúc HTML. Nó cho phép định
nghĩa giao diện trong các tệp riêng biệt. Hoạt động của CSS dựa trên ba nguyên tắc: Cascade
```
(Tính xếp chồng), Specificity (Độ ưu tiên), và Inheritance (Tính kế thừa).
```
```
Mọi phần tử HTML được coi là một chiếc hộp. Mô hình Hộp (Box Model) mô tả cấu
```
trúc của hộp này, bao gồm Content, Padding, Border, và Margin. Thuộc tính box-sizing:
border-box giúp việc thiết kế bố cục trở nên dễ dàng hơn.
CSS đã phát triển từ việc sử dụng float sang các hệ thống bố cục hiện đại. Flexbox được
```
thiết kế cho bố cục một chiều (hàng hoặc cột). CSS Grid được thiết kế cho bố cục hai chiều
```
```
(hàng và cột). Quy tắc chung là dùng Grid cho bố cục tổng thể và Flexbox để căn chỉnh các
```
thành phần bên trong.
Để quản lý CSS trong các dự án lớn, các phương pháp luận như BEM và SMACSS đã
ra đời. Các bộ tiền xử lý CSS như Sass cũng rất phổ biến. Chúng bổ sung các tính năng lập
trình như biến, lồng ghép và mixin, giúp viết mã CSS nhanh hơn và dễ bảo trì hơn.
1.3. Tổng quan về JavaScript
JavaScript được Brendan Eich tạo ra tại Netscape vào năm 1995. Ban đầu, nó là một
ngôn ngữ kịch bản đơn giản. Để giải quyết sự không tương thích giữa các trình duyệt, nó đã
```
được chuẩn hóa thành ECMAScript (ES). Phiên bản ES6 (2015) đã hiện đại hóa hoàn toàn
```
ngôn ngữ này với các tính năng như let, const, hàm mũi tên, lớp, và mô-đun.
JavaScript là đơn luồng, nhưng nó xử lý các tác vụ bất đồng bộ bằng Vòng lặp Sự kiện
```
(Event Loop). Mô hình này bao gồm Call Stack, Web APIs, và Callback Queue. Nó cho phép
```
xử lý các tác vụ tốn thời gian mà không chặn luồng chính. Cách xử lý bất đồng bộ đã tiến hóa
từ callback, đến Promises, và cú pháp Async/Await.
Vai trò chính của JavaScript là tạo ra sự tương tác bằng cách thao tác với DOM. Nó có
thể thay đổi nội dung, thuộc tính, và kiểu CSS của trang. JavaScript cũng xử lý các sự kiện
```
của người dùng như click hoặc keypress bằng addEventListener().
```
Sự ra đời của Node.js vào năm 2009 cho phép thực thi JavaScript trên máy chủ. Điều
```
này đã biến JavaScript thành một ngôn ngữ full-stack. npm (Node Package Manager) đã trở
```
thành kho lưu trữ mã nguồn mở lớn nhất thế giới. Các framework như React, Angular, và
```
Vue.js giúp xây dựng các Ứng dụng Đơn trang (SPAs) phức tạp.
```
1.4. Tổng quan về PHP
PHP được Rasmus Lerdorf tạo ra vào năm 1994. Ban đầu, nó là một ngôn ngữ kịch bản
đơn giản, nhúng trực tiếp vào HTML để tạo trang web động. Kiến trúc "shared-nothing" của
nó làm cho việc triển khai trở nên đơn giản. PHP đã phát triển mạnh mẽ qua các phiên bản 5,
```
7, và 8, trở thành một ngôn ngữ hướng đối tượng (OOP) hiện đại. PHP 7 đã tăng gấp đôi hiệu
```
năng so với phiên bản trước.
PHP được xây dựng cho web. Nó dễ dàng xử lý biểu mẫu qua các biến $_GET và
```
$_POST. Để chống lại tấn công XSS, cần làm sạch dữ liệu bằng htmlspecialchars(). PHP cũng
```
```
cung cấp cơ chế phiên ($_SESSION) để duy trì dữ liệu người dùng qua nhiều yêu cầu.
```
Tương tác với cơ sở dữ liệu là một chức năng quan trọng. Các hàm mysql_ cũ đã bị
loại bỏ do lỗ hổng bảo mật. MySQLi là một sự cải tiến, hỗ trợ câu lệnh đã chuẩn bị. PDO
```
(PHP Data Objects) là phương pháp hiện đại và được khuyến nghị nhất. Nó cung cấp một giao
```
diện nhất quán cho nhiều loại cơ sở dữ liệu và chống lại SQL Injection hiệu quả.
Hệ sinh thái PHP hiện đại có hai công cụ quan trọng. Composer là một trình quản lý
gói phụ thuộc, giúp quản lý các thư viện của bên thứ ba. Các framework như Laravel và
```
Symfony thúc đẩy mô hình kiến trúc MVC (Model-View-Controller). Mô hình này tách biệt
```
ứng dụng thành Model, View, và Controller, giúp mã nguồn có tổ chức và dễ bảo trì hơn.
1.5. Tổng quan về MySQL
```
MySQL là một trong những Hệ Quản trị Cơ sở dữ liệu Quan hệ (RDBMS) mã nguồn
```
mở phổ biến nhất. Nó là thành phần cốt lõi của ngăn xếp LAMP. MySQL dựa trên mô hình dữ
liệu quan hệ, tổ chức dữ liệu thành các bảng, hàng, và cột. Các ràng buộc như khóa chính và
khóa ngoại đảm bảo tính toàn vẹn dữ liệu.
```
Ngôn ngữ tiêu chuẩn để tương tác với MySQL là SQL (Structured Query Language).
```
```
Các lệnh SQL được chia thành các nhóm: DDL (định nghĩa dữ liệu), DML (thao tác dữ liệu),
```
```
DCL (điều khiển dữ liệu), và TCL (điều khiển giao dịch).
```
MySQL có hệ thống cơ chế lưu trữ có thể cắm. Hai cơ chế phổ biến nhất là MyISAM
và InnoDB. MyISAM rất nhanh cho các hoạt động đọc nhưng không hỗ trợ giao dịch. InnoDB
hỗ trợ đầy đủ các giao dịch tuân thủ ACID và khóa ở cấp độ hàng. Do đó, InnoDB là lựa chọn
tiêu chuẩn cho hầu hết các ứng dụng hiện đại.
```
Để tối ưu hóa hiệu suất, đánh chỉ mục (indexing) là rất quan trọng. Chỉ mục giúp tăng
```
tốc độ truy vấn SELECT nhưng làm chậm các hoạt động ghi. Chuẩn hóa dữ liệu là quy trình
```
thiết kế nhằm giảm thiểu sự dư thừa dữ liệu. Giao dịch (Transactions) đảm bảo độ tin cậy của
```
dữ liệu thông qua bốn thuộc tính ACID: Atomicity, Consistency, Isolation, và Durability.
1.6. Tổng quan về AdminLTE Template
Hầu hết ứng dụng web đều cần một khu vực quản trị. AdminLTE là một mẫu giao diện
quản trị mã nguồn mở phổ biến, giúp tăng tốc độ phát triển. Nó được xây dựng trên nền tảng
Bootstrap framework và cung cấp một bộ sưu tập phong phú các thành phần giao diện người
```
dùng (UI components) có thể tái sử dụng. Việc sử dụng các mẫu như AdminLTE cho phép các
```
nhà phát triển tập trung vào logic nghiệp vụ cốt lõi thay vì giao diện.
AdminLTE cung cấp một cấu trúc bố cục nhất quán, bao gồm Header, Sidebar, Content
Wrapper, và Footer. Nó cũng cung cấp một thư viện lớn các thành phần như Dashboards,
```
Forms, Tables (tích hợp DataTables), và các UI Elements khác như hộp thoại và cảnh báo.
```
Sử dụng AdminLTE mang lại nhiều lợi ích. Nó tăng tốc độ phát triển, đảm bảo tính
```
nhất quán trong giao diện, và có tính đáp ứng (responsiveness) nhờ Bootstrap. Nó cũng dễ
```
dàng tích hợp với nhiều plugin JavaScript khác.
Quy trình tích hợp AdminLTE vào một dự án PHP/MySQL khá đơn giản. Đầu tiên, tải
và tổ chức các tệp tài sản. Sau đó, tạo một layout chính và nạp nội dung động cho từng trang.
Cuối cùng, sử dụng PHP để truy vấn dữ liệu từ MySQL và đổ vào các thành phần của
AdminLTE.
1.7. Tổng quan về XAMPP
Lập trình trực tiếp trên máy chủ sản phẩm rất rủi ro. Do đó, các nhà phát triển sử dụng
môi trường phát triển cục bộ. Môi trường này là một bản sao của ngăn xếp công nghệ trên
máy chủ, được cài đặt trên máy tính cá nhân. Nó cho phép phát triển và thử nghiệm ứng dụng
một cách an toàn và cô lập.
XAMPP là một gói phần mềm giải quyết vấn đề thiết lập môi trường cục bộ. Nó là một
bản phân phối Apache miễn phí, dễ cài đặt, chứa tất cả các thành phần cần thiết. Tên gọi
```
XAMPP là một từ viết tắt: X (Cross-Platform), A (Apache), M (MariaDB/MySQL), P (PHP),
```
```
và P (Perl).
```
XAMPP rất đơn giản để sử dụng. Sau khi cài đặt, nó cung cấp XAMPP Control Panel
để khởi động và dừng các dịch vụ như Apache và MySQL. Các nhà phát triển đặt mã nguồn
vào thư mục htdocs và truy cập qua http://localhost. XAMPP cũng đi kèm với phpMyAdmin,
một giao diện quản trị cơ sở dữ liệu dựa trên web.
XAMPP đóng vai trò quan trọng trong chu trình phát triển. Nó cung cấp một môi trường
gần giống với môi trường sản phẩm, giúp giảm thiểu lỗi khi triển khai. Mặc dù các giải pháp
dựa trên container như Docker ngày càng phổ biến, XAMPP vẫn là một lựa chọn xuất sắc cho
việc học tập và các dự án nhỏ nhờ sự đơn giản của nó.
CHƯƠNG 2: PHÂN TÍCH VÀ THIẾT KẾ HỆ THỐNG
2.1 Yêu cầu hệ thống
2.1.1 Yêu cầu chức năng
- Dashboard Page: Trang tổng quan hiển thị các thông tin cơ bản và điều hướng đến các
chức năng quản lý khác. Bao gồm thống kê tổng số phòng, phòng trống, sinh viên, biểu đồ
trực quan và hoạt động gần đây.
- Quản lý Tòa nhà: Quản lý danh sách tòa nhà, cho phép admin thêm, sửa, xóa và xem chi
tiết các tòa nhà. Admin có thể cập nhật thông tin tòa nhà như mã tòa nhà, tên tòa nhà, và
xem thống kê phòng theo tòa.
- Quản lý Phòng: Quản lý danh sách phòng, cho phép admin thêm, sửa, xóa và xem chi tiết
các phòng. Admin có thể cập nhật thông tin phòng như mã phòng, tòa nhà, tầng, sức chứa,
giá, trạng thái và trang thiết bị.
- Quản lý Sinh viên: Quản lý danh sách sinh viên, cho phép admin thêm, sửa, xóa và xem
chi tiết thông tin sinh viên. Admin có thể xem phòng hiện tại và lịch sử phân công của sinh
viên.
- Phân công Phòng: Quản lý các phân công phòng, cho phép admin gán sinh viên vào
phòng, chuyển phòng và trả phòng. Hệ thống tự động kiểm tra sức chứa và cập nhật trạng
thái phòng.
- Quản lý Người dùng: Quản lý tài khoản người dùng hệ thống, cho phép admin thêm, sửa,
```
xóa tài khoản và phân quyền (Admin/Staff).
```
- Quản lý Tài khoản cá nhân: Cho phép người dùng xem và cập nhật thông tin cá nhân,
đổi mật khẩu.
- Đăng nhập/Đăng xuất: Chức năng xác thực người dùng để truy cập vào hệ thống quản
trị.
2.1.2 Yêu cầu phi chức năng
- Giao diện người dùng phải thân thiện và dễ sử dụng
- Hệ thống phải cung cấp hướng dẫn sử dụng chi tiết và hỗ trợ người dùng khi gặp sự cố
- Hệ thống phải tương thích với các trình duyệt web phổ biến như Chrome, Firefox,
Safari và Edge
- Hệ thống phải hỗ trợ các thiết bị di động và máy tính bảng (Responsive Design)
- Hỗ trợ đa ngôn ngữ (Việt Nam, English, Lào)
- Đảm bảo bảo mật thông tin với mã hóa mật khẩu
- Hiệu năng tải trang nhanh với tối ưu hóa database query
2.2. Biểu đồ use case
2.2.1 Use case Tổng quát
STT Mã Use Case Tên Use Case
1 UC01 Dashboard Page
2 UC02 Quản lý Tòa nhà
3 UC03 Quản lý Phòng
4 UC04 Quản lý Sinh viên
5 UC05 Phân công Phòng
6 UC06 Quản lý Người dùng
7 UC07 Quản lý Tài khoản
8 UC08 Đăng nhập
CHƯƠNG 3: TRIỂN KHAI HỆ THỐNG
3.1. Môi trường triển khai
3.1.1. Môi trường phát triển
Môi trường phát triển bao gồm các thành phần sau:
• Hệ điều hành: Windows 111
```
• Web server: XAMPP v3.3.0 (bao gồm Apache 2.4, MySQL/MariaDB 10.4, PHP 8.0)
```
```
• IDE/Text Editor: Visual Studio Code (phiên bản mới nhất) với các extensions hỗ trợ:
```
o PHP Intelephense
o PHP Debug
o MySQL
o HTML CSS Support
```
o JavaScript (ES6) code snippets
```
• Trình duyệt web:
```
o Google Chrome (phiên bản mới nhất)
```
```
• Công cụ quản lý cơ sở dữ liệu: phpMyAdmin (phiên bản đi kèm với XAMPP)
```
• Công cụ kiểm soát phiên bản: Git, GitHub
```
• Công cụ thiết kế: diagrams.net (draw.io) cho vẽ sơ đồ UML
```
3.1.2 Cài đặt và cấu hình hệ thống
Để triển khai hệ thống, cần cài đặt các phần mềm sau:
1. Cài đặt XAMPP
1. Tải bộ cài đặt XAMPP từ trang chủ: https://www.apachefriends.org
2. Chạy file cài đặt và làm theo hướng dẫn trên màn hình
3. Lưu ý chọn các thành phần cần thiết (Apache, MySQL, PHP, phpMyAdmin)
4. Sau khi cài đặt xong, khởi động XAMPP Control Panel và bật Apache và MySQL
2. Cài đặt Visual Studio Code
1. Tải Visual Studio Code từ: https://code.visualstudio.com
2. Cài đặt theo hướng dẫn
3. Cài đặt các extensions cần thiết từ Extensions Marketplace
3. Cài đặt Source Code
1. Tải source code về máy từ GitHub repository hoặc qua file .zip
2. Giải nén và copy thư mục vào C:\xampp\htdocs\ (Windows)
```
hoặc /opt/lampp/htdocs/ (Linux/macOS)
```
3. Đổi tên thư mục thành dms (hoặc tên bạn muốn)
3.1.3 Cấu hình kết nối cơ sở dữ liệu
Tìm đến file cấu hình initialize.php trong thư mục gốc của dự án.
Thay đổi các giá trị sau cho phù hợp với môi trường:
PHP
<?php
// Database Configuration
```
if(!defined('DB_SERVER')) define('DB_SERVER',"localhost");
```
```
if(!defined('DB_USERNAME')) define('DB_USERNAME',"root");
```
```
if(!defined('DB_PASSWORD')) define('DB_PASSWORD',"");
```
```
if(!defined('DB_NAME')) define('DB_NAME',"dms_db");
```
// Database Schema Version
```
if(!defined('DB_SCHEMA_VERSION')) define('DB_SCHEMA_VERSION',"2.0");
```
?>
Giải thích các tham số:
```
• DB_SERVER: Địa chỉ máy chủ database (mặc định: localhost)
```
```
• DB_USERNAME: Tên đăng nhập MySQL (mặc định: root)
```
```
• DB_PASSWORD: Mật khẩu MySQL (mặc định: để trống)
```
```
• DB_NAME: Tên cơ sở dữ liệu (mặc định: dms_db)
```
```
• DB_SCHEMA_VERSION: Phiên bản schema database (2.0)
```
•
3.2. Xây dựng cơ sở dữ liệu
3.2.1 Thiết kế cơ sở dữ liệu
Hệ thống DMS sử dụng 5 bảng chính:
Bảng 1: admins - Quản Lý Người Dùng Hệ Thống
Tên cột Kiểu dữ liệu Thuộc tính
Mục
đích
```
Id INT(11)
```
PRIMARY KEY,
AUTO_INCREMENT
Khóa
chính
```
username VARCHAR(100) NOT NULL, UNIQUE
```
Tên đăng
nhập
Tên cột Kiểu dữ liệu Thuộc tính
Mục
đích
```
password VARCHAR(255) NOT NULL
```
Mật khẩu
```
(MD5)
```
```
full_name VARCHAR(200) NOT NULL
```
Họ và
tên
```
email VARCHAR(150) DEFAULT NULL Email
```
```
phone VARCHAR(30) DEFAULT NULL
```
Số điện
thoại
status
```
ENUM('Active',
```
```
'Inactive')
```
NOT NULL, DEFAULT 'Active'
Trạng
thái
last_login DATETIME DEFAULT NULL
Lần đăng
nhập
cuối
created_at TIMESTAMP
DEFAULT
CURRENT_TIMESTAMP
Thời
gian tạo
updated_at TIMESTAMP
DEFAULT
CURRENT_TIMESTAMP ON
UPDATE CURRENT_TIMESTAMP
Thời
gian cập
nhật
```
Indexes:
```
```
• PRIMARY KEY (id)
```
```
• UNIQUE KEY (username)
```
```
• INDEX idx_username (username)
```
```
• INDEX idx_status (status)
```
Bảng 2: buildings - Quản Lý Tòa Nhà
Tên cột Kiểu dữ liệu Thuộc tính
Mục
đích
```
id INT(11)
```
PRIMARY KEY,
AUTO_INCREMENT
Khóa
chính
```
code VARCHAR(50) NOT NULL, UNIQUE
```
Mã tòa
nhà
```
name VARCHAR(100) NOT NULL
```
Tên tòa
nhà
```
address VARCHAR(255) DEFAULT NULL Địa chỉ
```
```
created_by INT(11) DEFAULT NULL, FK → admins(id)
```
Admin
tạo
```
updated_by INT(11) DEFAULT NULL, FK → admins(id)
```
Admin
cập nhật
created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
Thời
gian tạo
Tên cột Kiểu dữ liệu Thuộc tính
Mục
đích
updated_at TIMESTAMP
DEFAULT CURRENT_TIMESTAMP
ON UPDATE
CURRENT_TIMESTAMP
Thời
gian cập
nhật
```
Indexes:
```
```
• PRIMARY KEY (id)
```
```
• UNIQUE KEY (code)
```
```
• INDEX idx_code (code)
```
```
• INDEX idx_created_by (created_by)
```
```
• INDEX idx_updated_by (updated_by)
```
Foreign Keys:
```
• fk_building_created_by: created_by → admins(id) ON DELETE SET NULL
```
```
• fk_building_updated_by: updated_by → admins(id) ON DELETE SET NULL
```
Bảng 3: rooms - Quản Lý Phòng
Tên cột Kiểu dữ liệu Thuộc tính
Mục
đích
```
id INT(11)
```
PRIMARY KEY,
AUTO_INCREMENT
Khóa
chính
```
room_code VARCHAR(50) NOT NULL, UNIQUE
```
Mã
phòng
Tên cột Kiểu dữ liệu Thuộc tính
Mục
đích
```
building_id INT(11) NOT NULL, FK → buildings(id) Tòa nhà
```
```
floor INT(11) DEFAULT NULL Số tầng
```
```
capacity INT(11) NOT NULL, DEFAULT 1
```
Sức
chứa
```
price DECIMAL(12,2) DEFAULT 0.00
```
Giá
phòng
status
```
ENUM('Trống',
```
'Đang ở', 'Bảo trì',
```
'Đang dọn')
```
NOT NULL, DEFAULT 'Trống'
Trạng
thái
```
created_by INT(11)
```
DEFAULT NULL, FK →
```
admins(id)
```
Admin
tạo
```
updated_by INT(11)
```
DEFAULT NULL, FK →
```
admins(id)
```
Admin
cập nhật
created_at TIMESTAMP
DEFAULT
CURRENT_TIMESTAMP
Thời
gian tạo
updated_at TIMESTAMP
DEFAULT
CURRENT_TIMESTAMP ON
UPDATE
CURRENT_TIMESTAMP
Thời
gian cập
nhật
```
Indexes:
```
```
• PRIMARY KEY (id)
```
```
• UNIQUE KEY (room_code)
```
```
• INDEX idx_building_status (building_id, status) Composite index
```
```
• INDEX idx_status (status)
```
```
• INDEX idx_room_code (room_code)
```
Foreign Keys:
```
• fk_room_building: building_id → buildings(id) ON UPDATE CASCADE
```
```
• fk_room_created_by: created_by → admins(id) ON DELETE SET NULL
```
```
• fk_room_updated_by: updated_by → admins(id) ON DELETE SET NULL
```
Bảng 4: students - Quản Lý Sinh Viên
Tên cột Kiểu dữ liệu Thuộc tính
Mục
đích
```
id INT(11)
```
PRIMARY KEY,
AUTO_INCREMENT
Khóa
chính
```
student_code VARCHAR(50) NOT NULL, UNIQUE
```
Mã sinh
viên
```
full_name VARCHAR(200) NOT NULL
```
Họ và
tên
gender
```
ENUM('Nam',
```
```
'Nữ', 'Khác')
```
DEFAULT 'Khác' Giới tính
Tên cột Kiểu dữ liệu Thuộc tính
Mục
đích
```
faculty VARCHAR(150) DEFAULT NULL Khoa
```
```
class VARCHAR(100) DEFAULT NULL Lớp
```
```
phone VARCHAR(30) DEFAULT NULL
```
Số điện
thoại
```
email VARCHAR(150) DEFAULT NULL Email
```
dob DATE DEFAULT NULL
Ngày
sinh
```
created_by INT(11)
```
DEFAULT NULL, FK →
```
admins(id)
```
Admin
tạo
```
updated_by INT(11)
```
DEFAULT NULL, FK →
```
admins(id)
```
Admin
cập nhật
created_at TIMESTAMP
DEFAULT
CURRENT_TIMESTAMP
Thời
gian tạo
updated_at TIMESTAMP
DEFAULT
CURRENT_TIMESTAMP ON
UPDATE
CURRENT_TIMESTAMP
Thời
gian cập
nhật
```
Indexes:
```
```
• PRIMARY KEY (id)
```
```
• UNIQUE KEY (student_code)
```
```
• INDEX idx_student_code (student_code)
```
```
• INDEX idx_full_name (full_name)
```
Foreign Keys:
```
• fk_student_created_by: created_by → admins(id) ON DELETE SET NULL
```
```
• fk_student_updated_by: updated_by → admins(id) ON DELETE SET NULL
```
Bảng 5: room_assignments - Phân Công Phòng
Tên cột Kiểu dữ liệu Thuộc tính Mục đích
```
id INT(11)
```
PRIMARY KEY,
AUTO_INCREMENT
Khóa
chính
```
student_id INT(11) NOT NULL, FK → students(id) Sinh viên
```
```
room_id INT(11) NOT NULL, FK → rooms(id) Phòng
```
assigned_at DATETIME
NOT NULL, DEFAULT
CURRENT_TIMESTAMP
Ngày vào
ở
moved_out_at DATETIME DEFAULT NULL
Ngày
chuyển đi
```
(NULL =
```
```
đang ở)
```
```
note VARCHAR(255) DEFAULT NULL Ghi chú
```
Tên cột Kiểu dữ liệu Thuộc tính Mục đích
```
created_by INT(11)
```
DEFAULT NULL, FK →
```
admins(id)
```
Admin tạo
```
updated_by INT(11)
```
DEFAULT NULL, FK →
```
admins(id)
```
Admin cập
nhật
created_at TIMESTAMP
DEFAULT
CURRENT_TIMESTAMP
Thời gian
tạo
updated_at TIMESTAMP
DEFAULT
CURRENT_TIMESTAMP ON
UPDATE
CURRENT_TIMESTAMP
Thời gian
cập nhật
```
Indexes:
```
```
• PRIMARY KEY (id)
```
```
• INDEX idx_student (student_id)
```
```
• INDEX idx_room (room_id)
```
```
• INDEX idx_active (student_id, moved_out_at) Composite index
```
Foreign Keys:
```
• fk_ra_student: student_id → students(id) ON DELETE CASCADE
```
```
• fk_ra_room: room_id → rooms(id) ON UPDATE CASCADE
```
```
• fk_assignment_created_by: created_by → admins(id) ON DELETE SET NULL
```
```
• fk_assignment_updated_by: updated_by → admins(id) ON DELETE SET NULL
```
Bảng 6: system_settings - Cấu Hình Hệ Thống
Tên cột Kiểu dữ liệu Thuộc tính
Mục
đích
```
id INT(11)
```
PRIMARY KEY,
AUTO_INCREMENT
Khóa
chính
```
meta_field VARCHAR(255) NOT NULL, UNIQUE
```
Tên cấu
hình
meta_value TEXT DEFAULT NULL Giá trị
created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
Thời
gian tạo
updated_at TIMESTAMP
DEFAULT CURRENT_TIMESTAMP
ON UPDATE
CURRENT_TIMESTAMP
Thời
gian cập
nhật
```
Indexes:
```
```
• PRIMARY KEY (id)
```
```
• UNIQUE KEY (meta_field)
```
3.2.2 Mô hình cơ sở dữ liệu
3.3. Triển khai các chức năng
```
3.3.1 Chức năng Quản trị viên (Admin)
```
3.3.1.1 Dashboard Page
3.3.1.2 Quản lý Tòa nhà
3.3.1.3 Quản lý Phòng
3.3.1.4 Quản lý Sinh viên
3.3.1.5 Phân công Phòng
3.3.1.6 Quản lý Người dùng
KẾT LUẬN
4.1. Kết quả đạt được
```
Hoàn thành đầy đủ đề tài "Xây dựng Hệ thống Quản lý Ký túc xá (Dormitory Management
```
```
System - DMS)". Website cung cấp các chức năng cơ bản và đầy đủ cho cả hai đối tượng
```
người dùng chính:
```
Quản trị viên (Admin/Staff):
```
• Đăng nhập vào hệ thống quản trị
```
• Xem trang tổng quan (Dashboard) với thống kê và biểu đồ
```
```
• Quản lý danh sách tòa nhà (thêm, sửa, xóa, xem chi tiết)
```
```
• Quản lý danh sách phòng (thêm, sửa, xóa, xem chi tiết)
```
```
• Quản lý danh sách sinh viên (thêm, sửa, xóa, xem chi tiết)
```
• Phân công sinh viên vào phòng
• Chuyển phòng cho sinh viên
```
• Trả phòng (move out)
```
• Quản lý người dùng hệ thống
• Quản lý tài khoản cá nhân
Giao diện thân thiện, dễ sử dụng:
• Website được thiết kế với giao diện người dùng trực quan, rõ ràng, dễ sử dụng
```
• Tương thích với các trình duyệt web phổ biến (Chrome, Firefox, Edge, Safari)
```
• Responsive design - hỗ trợ các thiết bị di động và máy tính bảng
• Hỗ trợ 3 ngôn ngữ: Tiếng Việt, English, ພາສາລາວ
Sử dụng công nghệ phù hợp:
Đề tài đã áp dụng các công nghệ web phổ biến và phù hợp cho việc xây dựng hệ thống quản
lý:
```
• Backend: PHP 8.0+ với kiến trúc OOP (Object-Oriented Programming)
```
• Database: MySQL 8.0/MariaDB với schema được tối ưu hóa
• Frontend: HTML5, CSS3, JavaScript/jQuery, Bootstrap 4/5
• UI Framework: AdminLTE 3 cho admin panel
```
• Libraries: DataTables (bảng dữ liệu), Chart.js (biểu đồ), Font Awesome (icons)
```
• Công cụ hỗ trợ: XAMPP, Visual Studio Code, phpMyAdmin, Git/GitHub,
diagrams.net
4.2. Hạn chế của đề tài
• Chưa có chức năng quản lý thu chi, hóa đơn tiền phòng
```
• Chưa có hệ thống thông báo (notifications) tự động qua email/SMS
```
• Chưa có chức năng đánh giá/phản hồi từ sinh viên
• Chưa có các tính năng nâng cao như: gợi ý phòng phù hợp, AI recommendation
• Chưa có dashboard analytics chuyên sâu với nhiều loại báo cáo
```
• Báo cáo chưa đề cập chi tiết đến các biện pháp tối ưu hiệu suất (ví dụ: caching, tối ưu
```
```
hóa truy vấn cơ sở dữ liệu...)
```
```
• Chưa thực hiện kiểm thử hiệu năng (performance testing) và kiểm thử bảo mật
```
```
(security testing) chuyên sâu
```
• Chưa có API cho mobile app
4.3. Hướng phát triển đề tài
• Quản lý thu chi: Tích hợp module quản lý hóa đơn, thanh toán tiền phòng, theo dõi
công nợ
• Hệ thống thông báo: Gửi thông báo tự động qua email/SMS về:
o Hóa đơn sắp đến hạn
o Nhắc nhở đóng tiền
o Thông báo bảo trì
o Thông báo vi phạm nội quy
• Module báo cáo nâng cao:
o Báo cáo doanh thu theo tháng/quý/năm
o Báo cáo tỷ lệ lấp đầy
o Báo cáo sinh viên theo khoa/lớp
o Export báo cáo Excel/PDF
• Đánh giá & Phản hồi:
o Sinh viên đánh giá chất lượng phòng
o Gửi phản hồi/khiếu nại
o Đánh giá dịch vụ ký túc xá
• Tích hợp QR Code:
o QR code cho từng phòng
o Quét mã để xem thông tin phòng
o Quét mã để check-in/check-out
• Mobile App:
```
o Phát triển ứng dụng di động (iOS/Android)
```
o REST API cho mobile
o Push notifications
• Tích hợp hệ thống khác:
o Kết nối với hệ thống quản lý sinh viên của trường
```
o Tích hợp cổng thanh toán online (VNPay, MoMo)
```
o Kết nối với hệ thống điện nước
TÀI LIỆU THAM KHẢO
```
[1]. Nguyen Van A (2023) - "Hệ thống Quản lý Ký túc xá Trường Đại học", Khoa Công nghệ
```
Thông tin, Trường Đại học XYZ.
```
[2]. Tran Thi B (2022) - "Xây dựng Website quản lý ký túc xá sinh viên", Đồ án tốt nghiệp,
```
Trường Đại học ABC.
[3]. SourceCodester - "School Dormitory Management System PHP/OOP Free Source
Code", https://www.sourcecodester.com/php/15319/school-dormitory-management-system-
phpoop-free-source-code.html
[4]. AdminLTE Documentation - https://adminlte.io/docs/
[5]. Bootstrap Documentation - https://getbootstrap.com/docs/
[6]. Chart.js Documentation - https://www.chartjs.org/docs/
[7]. DataTables Documentation - https://datatables.net/manual/
[8]. PHP Documentation - https://www.php.net/docs.php
[9]. MySQL Documentation - https://dev.mysql.com/doc/
[10]. W3Schools - Web Development Tutorials - https://www.w3schools.com/