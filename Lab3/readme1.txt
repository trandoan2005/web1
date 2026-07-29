Phân biệt include, require, include_once, require_once
=====================================================

1. include
- Nhúng file vào trang hiện tại.
- Nếu file không tồn tại, PHP sẽ đưa ra cảnh báo (Warning) nhưng chương trình vẫn tiếp tục chạy.
- Ví dụ: include "header.php";

2. require
- Nhúng file vào trang hiện tại.
- Nếu file không tồn tại, PHP sẽ đưa ra lỗi nghiêm trọng (Fatal Error) và dừng chương trình ngay lập tức.
- Ví dụ: require "header.php";

3. include_once
- Giống include nhưng chỉ nhúng file 1 lần duy nhất.
- Nếu file đã được nhúng trước đó, lệnh sẽ bị bỏ qua, tránh lỗi khai báo trùng lặp.
- Ví dụ: include_once "functions.php";

4. require_once
- Giống require nhưng chỉ nhúng file 1 lần duy nhất.
- Nếu file đã được nhúng trước đó, lệnh sẽ bị bỏ qua.
- Nếu file không tồn tại, dừng chương trình (Fatal Error).
- Ví dụ: require_once "Student.php";

So sánh:
- include vs require: include chỉ cảnh báo khi lỗi, require dừng chương trình.
- _once: đảm bảo file chỉ được nhúng 1 lần, tránh lỗi khai báo hàm/class trùng lặp.

Kết quả test:
- Test include file không tồn tại: Warning nhưng trang vẫn hiển thị phần còn lại.
- Test require file không tồn tại: Fatal Error, trang dừng hoàn toàn.
- Test include_once 2 lần cùng file: file chỉ được nhúng 1 lần, không lỗi trùng.
- Test require_once 2 lần cùng file: file chỉ được nhúng 1 lần, không lỗi trùng.

(Hình ảnh minh chứng nằm trong thư mục assets/images)
