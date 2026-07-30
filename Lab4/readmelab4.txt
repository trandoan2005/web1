Kết quả quan sát và So sánh GET - POST
=======================================

1. Kết quả quan sát sau khi chạy chương trình với $_GET['fullname']:
- Khi người dùng nhập "Nguyễn Văn A" vào ô Họ tên và nhấn Gửi ở trang form-get.php, thanh địa chỉ URL của trình duyệt thay đổi, thêm vào đoạn query string (ví dụ: ?fullname=Nguyễn+Văn+A&birthyear=...&gender=...&mclass=...).
- Biến $fullname nhận được giá trị "Nguyễn Văn A" và được in ra màn hình trong bảng thông tin (dưới dạng an toàn HTML nhờ hàm htmlspecialchars).

2. Sự khác nhau giữa phương thức GET và POST:

a) Cách gửi dữ liệu:
- GET: Dữ liệu được đính kèm vào cuối URL (Uniform Resource Locator) theo cặp name=value, ngăn cách nhau bởi dấu '&'.
- POST: Dữ liệu được gửi ngầm bên trong phần thân (body) của HTTP Request, không đính kèm vào URL.

b) Dữ liệu có hiển thị trên URL hay không:
- GET: CÓ hiển thị công khai trên thanh địa chỉ URL.
- POST: KHÔNG hiển thị trên URL.

c) Trường hợp nào nên sử dụng GET và POST:
- Dùng GET khi:
  + Dữ liệu gửi đi không bảo mật (ví dụ: từ khóa tìm kiếm, bộ lọc trang).
  + Muốn bookmark (đánh dấu) lại URL để gửi cho người khác hoặc lưu lại.
  + Dữ liệu gửi đi có dung lượng nhỏ (độ dài URL bị giới hạn tùy trình duyệt).
  + Thao tác lấy dữ liệu (Read) không làm thay đổi trạng thái của server.

- Dùng POST khi:
  + Dữ liệu gửi đi chứa thông tin nhạy cảm, bảo mật (như Mật khẩu, Số tài khoản, Thông tin cá nhân).
  + Dữ liệu có dung lượng lớn (ví dụ: nội dung bài viết dài, upload hình ảnh, file).
  + Thực hiện các thao tác làm thay đổi dữ liệu trên server (Create, Update, Delete) như Thêm mới, Cập nhật, Xóa bản ghi.
