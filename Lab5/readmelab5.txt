Lab 5 - Readme
==============

1. Phân biệt MySQL và phpMyAdmin:
- MySQL: Là hệ quản trị cơ sở dữ liệu quan hệ (RDBMS), dùng để lưu trữ, truy vấn và quản lý dữ liệu bằng ngôn ngữ SQL.
- phpMyAdmin: Là công cụ quản lý MySQL qua giao diện web, cho phép tạo database, bảng, thêm/sửa/xóa dữ liệu mà không cần gõ lệnh SQL trực tiếp.

2. Phân biệt các cách kết nối cơ sở dữ liệu trong PHP:
- MySQLi thủ tục (Procedural): Sử dụng các hàm như mysqli_connect(), mysqli_query(). Viết theo kiểu hàm, không dùng class.
- MySQLi hướng đối tượng (Object-Oriented): Sử dụng đối tượng new mysqli(). Viết theo kiểu OOP với các phương thức của đối tượng.
- PDO (PHP Data Objects): Hỗ trợ nhiều loại cơ sở dữ liệu khác nhau (MySQL, PostgreSQL, SQLite,...), linh hoạt hơn MySQLi.
=> Lab này sử dụng MySQLi hướng đối tượng (Object-Oriented).

3. Phân biệt Database, Table, Record và Field:
- Database: Là tập hợp các bảng dữ liệu có liên quan. VD: tranvandoan_mydb1.
- Table: Là bảng chứa dữ liệu theo cấu trúc cột và dòng. VD: bảng students.
- Record (Bản ghi): Là một dòng dữ liệu trong bảng. VD: một sinh viên cụ thể.
- Field (Trường): Là một cột trong bảng. VD: fullname, phone.

4. AUTO_INCREMENT và PRIMARY KEY:
- PRIMARY KEY: Là khóa chính, dùng để xác định duy nhất mỗi bản ghi trong bảng. Mỗi bảng chỉ có một PRIMARY KEY.
- AUTO_INCREMENT: Tự động tăng giá trị mỗi khi thêm bản ghi mới, thường đi kèm với PRIMARY KEY để tạo ID tự tăng.

5. Phân biệt GET và POST:
- GET: Dữ liệu gửi qua URL (query string), hiển thị trên thanh địa chỉ. Phù hợp cho tìm kiếm, lọc dữ liệu.
- POST: Dữ liệu gửi trong body của HTTP request, không hiển thị trên URL. Phù hợp cho thêm, sửa dữ liệu, form đăng nhập.

6. Tại sao cần Validate dữ liệu trước khi lưu vào CSDL?
- Đảm bảo dữ liệu đúng định dạng và hợp lệ trước khi lưu.
- Tránh lỗi khi thực thi câu lệnh SQL.
- Ngăn chặn dữ liệu rác, dữ liệu trống hoặc dữ liệu không mong muốn.
- Bảo vệ ứng dụng khỏi các cuộc tấn công (SQL Injection, XSS).

7. SQL Injection là gì? Vì sao nên dùng Prepared Statement?
- SQL Injection: Là kỹ thuật tấn công bằng cách chèn mã SQL độc hại vào dữ liệu đầu vào (input) để thao túng câu lệnh SQL.
  VD: Nhập vào ô username: ' OR 1=1 -- sẽ bypass điều kiện đăng nhập.
- Prepared Statement: Tách biệt câu lệnh SQL và dữ liệu. Dữ liệu được truyền qua tham số (placeholder ?) nên không thể bị chèn mã SQL.
  => Đây là cách phòng chống SQL Injection hiệu quả nhất.

8. Tại sao UPDATE hoặc DELETE cần có WHERE?
- Nếu không có WHERE, câu lệnh sẽ cập nhật hoặc xóa TẤT CẢ bản ghi trong bảng.
- WHERE giúp chỉ định chính xác bản ghi cần thao tác, tránh mất dữ liệu.

9. Export, Import và Backup CSDL dùng để làm gì?
- Export (Xuất): Tạo file .sql chứa toàn bộ cấu trúc và dữ liệu để sao lưu hoặc di chuyển sang máy khác.
- Import (Nhập): Phục hồi dữ liệu từ file .sql đã xuất trước đó vào một database mới.
- Backup (Sao lưu): Tạo bản sao dự phòng để phòng trường hợp mất dữ liệu do sự cố.
