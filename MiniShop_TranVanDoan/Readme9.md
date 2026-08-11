# Lập trình Web 1 - PHP & MySQL - Lab 9
**Họ và tên:** Trần Văn Đoàn
**Câu F. TỔNG HỢP CÁC CÂU HỎI CẦN TRẢ LỜI**

**1. `$limit`, `$page`, `$offset` dùng để làm gì?**
- `$limit`: Số lượng bản ghi (sản phẩm) muốn hiển thị trên một trang.
- `$page`: Trang hiện tại mà người dùng đang đứng (ví dụ trang 1, 2, 3...).
- `$offset`: Vị trí bản ghi bắt đầu lấy trong cơ sở dữ liệu. Được tính bằng công thức `$offset = ($page - 1) * $limit`.

**2. Vì sao cần `ceil()` khi tính `$totalPages`?**
- `ceil()` dùng để làm tròn lên. Nếu tổng số bản ghi là 25 và hiển thị 10 bản ghi/trang, thì `25 / 10 = 2.5`. Dùng `ceil(2.5)` sẽ ra 3 trang. Trang cuối sẽ chứa 5 bản ghi còn lại. Nếu không làm tròn lên, trang cuối sẽ bị mất.

**3. `LIMIT` và `OFFSET` trong SQL có tác dụng gì?**
- `LIMIT`: Giới hạn số lượng kết quả trả về từ câu truy vấn (tương ứng với `$limit`).
- `OFFSET`: Bỏ qua một số lượng bản ghi nhất định từ trên xuống rồi mới bắt đầu lấy dữ liệu (tương ứng với `$offset`).

**4. Vì sao khi chuyển trang phải giữ `limit` trên URL?**
- Để ghi nhớ lựa chọn số lượng bản ghi hiển thị của người dùng (ví dụ họ chọn hiển thị 20 sản phẩm/trang). Nếu không truyền lên URL, khi bấm sang trang khác, hệ thống sẽ reset về giá trị mặc định (10 sản phẩm/trang).

**5. Vì sao khi tìm kiếm phải giữ `keyword` khi chuyển trang?**
- Để biết rằng người dùng đang trong ngữ cảnh tìm kiếm từ khóa đó ở trang tiếp theo. Nếu mất `keyword`, hệ thống sẽ trả về trang 2 của toàn bộ sản phẩm chứ không phải trang 2 của kết quả tìm kiếm.

**6. `count()` dùng để làm gì trong chức năng phân trang?**
- Dùng để đếm tổng số bản ghi thỏa mãn điều kiện truy vấn (có hoặc không có từ khóa tìm kiếm). Dựa vào con số này mới có thể tính toán ra tổng số trang `$totalPages` để vẽ các nút phân trang.

**7. Vì sao nên tái sử dụng `getPage()` thay vì tạo `getPageByKeyword()` riêng?**
- Giúp giảm thiểu code trùng lặp (DRY). Thay vì viết 2 hàm gần như giống hệt nhau, ta truyền thêm tham số `$keyword` (mặc định rỗng `""`) vào `getPage()`. Nếu rỗng thì lấy hết, có thì thêm câu lệnh `WHERE ... LIKE`.

**8. Khi tìm kiếm không có kết quả thì `$totalPages` có giá trị bao nhiêu?**
- Khi không có kết quả, `count()` trả về 0 (`$totalRecords = 0`). Do đó, `$totalPages = ceil(0 / $limit) = 0`. Tuy nhiên trong code xử lý phân trang thường để logic nhỏ nhất `page` là 1 nếu trang rỗng.

**9. `sort` dùng để làm gì?**
- Là tham số định nghĩa tiêu chí sắp xếp kết quả (ví dụ: Tên A-Z, Giá giảm dần...). Giúp truyền điều kiện order vào câu SQL (chuyển đổi thành `ORDER BY` thích hợp).

**10. Khi kết hợp tìm kiếm + sắp xếp + phân trang, những tham số nào cần được giữ trên URL?**
- Cả 4 tham số: `keyword` (Từ khóa tìm kiếm), `sort` (Kiểu sắp xếp), `limit` (Số bản ghi/trang) và `page` (Trang hiện tại). Khi thay đổi 1 tham số, 3 tham số còn lại phải được giữ nguyên bằng input hidden hoặc nối chuỗi vào href `<a>`.
