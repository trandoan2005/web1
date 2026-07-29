Thực hành Function trong PHP
=============================

1. Mục đích của Function trong PHP
- Function giúp chia nhỏ chương trình thành các khối logic riêng biệt, dễ quản lý.
- Tái sử dụng code: viết 1 lần, gọi nhiều lần ở nhiều nơi khác nhau.
- Giúp code gọn gàng, dễ đọc, dễ bảo trì và sửa lỗi.

2. Các Function đã sử dụng trong bài thực hành
- formatPrice($price, $currency, $decimals): Định dạng tiền tệ.
- getTotalQuantity($products): Tính tổng số lượng sản phẩm.
- getTotalPrice($products): Tính tổng giá nhập.
- showProductTable($products, $tableTitle, $currency, $decimals): Hiển thị bảng sản phẩm.

3. Các loại Function trong PHP
a) Built-in Function (Hàm có sẵn): number_format(), date(), count(), round()...
b) User-defined Function (Hàm do người dùng tự định nghĩa): formatPrice(), showProductTable()...
c) Anonymous Function (Hàm ẩn danh / Closure): function() { ... }
d) Arrow Function (PHP 7.4+): fn($x) => $x * 2
e) Recursive Function (Hàm đệ quy): hàm tự gọi chính nó.

4. Các loại Function chưa được áp dụng trong bài thực hành
- Anonymous Function (Hàm ẩn danh)
- Arrow Function
- Recursive Function (Hàm đệ quy)

5. Tìm hiểu về Parameters (tham số) trong Function

a) Các dạng tham số:
- Required Parameters (Tham số bắt buộc): phải truyền giá trị khi gọi hàm.
  Ví dụ: function hello($name) { echo "Xin chào $name"; }
  
- Default Parameters (Tham số mặc định): có giá trị mặc định, không bắt buộc truyền.
  Ví dụ: function formatPrice($price, $currency = "đ") { ... }
  
- Pass by Reference (Tham chiếu): dùng dấu & trước tham số, thay đổi giá trị gốc.
  Ví dụ: function addOne(&$num) { $num++; }
  
- Variadic Parameters (Tham số biến đổi): dùng ... để nhận số lượng tham số không giới hạn.
  Ví dụ: function sum(...$numbers) { return array_sum($numbers); }
  
- Named Arguments (PHP 8.0+): truyền tham số theo tên.
  Ví dụ: formatPrice(price: 100000, currency: "VNĐ")

b) Bài thực hành đã sử dụng:
- Required Parameters: $products, $tableTitle trong showProductTable()
- Default Parameters: $currency = "đ" trong formatPrice(), $decimals = 0

c) Những dạng tham số chưa được áp dụng:
- Pass by Reference
- Variadic Parameters
- Named Arguments
