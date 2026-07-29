Thực hành Class & Object trong PHP
====================================

1. Khi nào nên sử dụng Function, khi nào nên sử dụng Class và Object?

- Sử dụng Function khi:
  + Cần thực hiện một tác vụ đơn lẻ, không liên quan đến trạng thái (state).
  + Xử lý dữ liệu đầu vào và trả về kết quả mà không cần lưu trữ.
  + Ví dụ: formatPrice(), getTotalQuantity() - chỉ tính toán rồi trả kết quả.

- Sử dụng Class và Object khi:
  + Cần nhóm dữ liệu (thuộc tính) và hành vi (phương thức) liên quan vào một đơn vị.
  + Đối tượng có trạng thái riêng cần lưu trữ và thao tác.
  + Ví dụ: class Student - mỗi sinh viên có mã, tên, điểm riêng và có thể tính tổng điểm, xếp loại.

2. Ý nghĩa của từ khóa $this

- $this là biến đặc biệt trong PHP, đại diện cho đối tượng hiện tại đang gọi phương thức.
- Dùng $this để truy cập thuộc tính và phương thức của chính đối tượng đó.
- Ví dụ:
  public function getTotalScore(): float {
      return $this->scoreHtml + $this->scoreCss + $this->scorePhp;
  }
  Ở đây $this->scoreHtml truy cập thuộc tính scoreHtml của đối tượng Student đang gọi.

3. Ý nghĩa của toán tử mũi tên (->)

- Toán tử -> dùng để truy cập thuộc tính hoặc gọi phương thức của một đối tượng.
- Cú pháp: $object->property hoặc $object->method()
- Ví dụ:
  $sv = new Student("SV001", "Nguyễn Văn A", "Nam", 2005, 8.5, 9.0, 7.5);
  echo $sv->fullName;        // Truy cập thuộc tính
  echo $sv->getTotalScore(); // Gọi phương thức

4. Lợi ích của việc tái sử dụng phương thức (Method Reuse)

- Giảm trùng lặp code: viết logic 1 lần trong phương thức, gọi lại nhiều nơi.
  Ví dụ: getAverage() gọi lại getTotalScore(), getRank() gọi lại getAverage().
  
- Dễ bảo trì: khi cần thay đổi cách tính, chỉ sửa ở 1 chỗ.
  Ví dụ: nếu đổi công thức tính tổng điểm, chỉ cần sửa getTotalScore().
  
- Đảm bảo tính nhất quán: cùng một phép tính luôn cho kết quả giống nhau.

- Tăng khả năng mở rộng: dễ dàng thêm phương thức mới dựa trên các phương thức đã có.
  Ví dụ: getScholarship() tái sử dụng getAverage() để kiểm tra điều kiện học bổng.
