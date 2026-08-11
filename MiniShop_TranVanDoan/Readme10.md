# Lập trình Web 1 - PHP & MySQL - Lab 10
**Họ và tên:** Trần Văn Đoàn
**Câu H. TỔNG HỢP CÁC CÂU HỎI CẦN TRẢ LỜI**

### 1. Middleware
**a. AuthMiddleware:** Dùng để kiểm tra xem người dùng đã đăng nhập chưa. Nếu chưa đăng nhập (Session `user` không tồn tại), hệ thống sẽ chuyển hướng người dùng về trang Đăng nhập (`login.php`), ngăn chặn việc truy cập trái phép vào các trang quản trị.
**b. GuestMiddleware:** Dùng để kiểm tra nếu người dùng đã đăng nhập rồi thì không cho phép họ vào lại trang Đăng nhập hoặc Đăng ký nữa, thay vào đó tự động chuyển hướng họ vào thẳng trang Quản trị (`dashboard.php`).
**c. CsrfMiddleware:** Chịu trách nhiệm tạo ngẫu nhiên một chuỗi CSRF Token lưu vào Session và nhúng vào các Form. Khi Form được gửi đi (POST), Middleware này sẽ kiểm tra xem Token gửi lên có khớp với Token trong Session hay không để chống tấn công giả mạo yêu cầu.

### 2. Session và Cookie
**a. Phân biệt Session và Cookie:**
- **Cookie:** Lưu trữ dữ liệu ở phía máy khách (Trình duyệt của người dùng). Dữ liệu này được gửi kèm lên Server trong mỗi Request. Dễ bị đánh cắp nếu không bảo mật tốt. Có thời hạn sống tự định nghĩa (ví dụ 30 ngày).
- **Session:** Lưu trữ dữ liệu ở phía máy chủ (Server). An toàn hơn Cookie vì dữ liệu thực sự không truyền qua mạng. Trình duyệt chỉ giữ một mã định danh (Session ID) trong Cookie để Server nhận diện. Khi đóng trình duyệt, Session thường bị hủy.

**b. `$_SESSION["user"]` dùng để làm gì?**
Dùng để lưu trữ toàn bộ thông tin của người dùng (như ID, họ tên, vai trò) sau khi họ đăng nhập thành công. Các trang khác (như Dashboard, Header) sẽ lấy thông tin từ biến này để hiển thị lời chào và kiểm tra quyền hạn.

**c. GET/POST truyền dữ liệu khác gì với Session?**
- `GET/POST` chỉ truyền dữ liệu được trong một Request duy nhất (từ trang này sang trang kia một lần). Nếu sang trang thứ 3, dữ liệu sẽ mất trừ khi tiếp tục truyền.
- `Session` lưu trữ dữ liệu xuyên suốt toàn bộ phiên làm việc. Dữ liệu có thể được truy xuất ở bất kỳ trang nào, bất kỳ lúc nào mà không cần gửi lại.

**d. Trình bày quá trình Session hoạt động:**
- Khi gọi `session_start()` lần đầu, PHP tạo ra một Session ID ngẫu nhiên trên Server và gửi ID này về trình duyệt dưới dạng một Cookie (thường tên là `PHPSESSID`).
- Khi người dùng sang trang khác (gửi Request mới), trình duyệt tự động gửi kèm Cookie chứa `PHPSESSID` lên Server.
- PHP nhận được `PHPSESSID`, đối chiếu với dữ liệu trên Server và phục hồi lại toàn bộ biến `$_SESSION` cho trang hiện tại.

### 3. Đăng nhập, bảo mật và phân quyền
**a. `password_verify()` dùng để làm gì?**
Hàm này dùng để kiểm tra xem một mật khẩu dạng văn bản thô (người dùng nhập) có khớp với chuỗi mật khẩu đã được băm (hash) lưu trong Database hay không.

**b. Bcrypt là gì?**
- **Bcrypt** là một thuật toán băm (hashing) mật khẩu một chiều. Nó tự động thêm "muối" (salt) ngẫu nhiên và cố tình làm chậm quá trình băm để chống lại các cuộc tấn công dò mật khẩu (Brute-force).
- **Vì sao cần dùng:** Nếu lưu mật khẩu dưới dạng văn bản thô (plain text), khi hacker chiếm được Database, họ sẽ biết toàn bộ mật khẩu. Việc dùng Bcrypt giúp dù có lộ Database, hacker cũng không thể dịch ngược ra mật khẩu thật.
- **Các thuật toán khác:** Argon2, MD5 (không còn an toàn), SHA-1, SHA-256.

**c. Vì sao cần kiểm tra Session trước khi cho phép truy cập Admin?**
Giao diện Admin chứa các chức năng nhạy cảm (Thêm/Sửa/Xóa dữ liệu hệ thống). Cần kiểm tra Session để đảm bảo chỉ những người có danh tính hợp lệ (đã đăng nhập thành công) mới được phép sử dụng các chức năng này. Tránh việc người lạ biết URL là có thể truy cập thẳng vào thao tác.

**d. Khi đăng xuất, cần thực hiện thao tác nào với Session?**
1. Khởi động lại session bằng `session_start()`.
2. Xóa sạch các biến trong session bằng `session_unset()`.
3. Hủy bỏ hoàn toàn session trên Server bằng `session_destroy()`.

**e. CSRF Token dùng để làm gì?**
Được dùng để phân biệt xem một Request (như Xóa sản phẩm) có thực sự xuất phát từ Form của hệ thống (do người dùng chủ động nhấn), hay là một đường link giả mạo do hacker lừa người dùng nhấp vào từ một trang web khác.

**f. Điều gì xảy ra khi CSRF Token không hợp lệ?**
Nếu CSRF Token bị thiếu hoặc không khớp với Session, Request đó sẽ bị chặn lại (Middleware có thể dùng lệnh `die()` hoặc chuyển hướng ra lỗi 403) và từ chối thực hiện thao tác thay đổi dữ liệu để bảo vệ hệ thống.

**g. Phân biệt Authentication và Authorization:**
- **Authentication (Xác thực - Đăng nhập):** Quá trình xác minh "Bạn là ai?". Hệ thống MiniShop dùng nó khi người dùng nhập Username/Password ở trang `login.php`.
- **Authorization (Phân quyền):** Quá trình xác minh "Bạn được phép làm gì?". Trong MiniShop, sau khi Authentication thành công, hệ thống tiếp tục kiểm tra xem người dùng đó có Role là `admin` không mới cho phép truy cập vào trang Quản lý Nhân viên. Nhân viên bình thường sẽ bị chặn (Authorization fail).
