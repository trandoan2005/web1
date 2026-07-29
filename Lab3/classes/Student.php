<?php
class Student
{
    // Properties
    public string $studentId;
    public string $fullName;
    public string $gender;
    public int $birthYear;
    public float $scoreHtml;
    public float $scoreCss;
    public float $scorePhp;

    // Constructor
    public function __construct(
        string $studentId,
        string $fullName,
        string $gender,
        int $birthYear,
        float $scoreHtml,
        float $scoreCss,
        float $scorePhp
    ) {
        $this->studentId = $studentId;
        $this->fullName = $fullName;
        $this->gender = $gender;
        $this->birthYear = $birthYear;
        $this->scoreHtml = $scoreHtml;
        $this->scoreCss = $scoreCss;
        $this->scorePhp = $scorePhp;
    }

    // =======Methods======
    /**
     * Tính tổng điểm
     * @return float
     */
    public function getTotalScore(): float
    {
        return $this->scoreHtml
            + $this->scoreCss
            + $this->scorePhp;
    }

    /**
     * Trả về tuổi của sinh viên dựa trên năm sinh
     * @return int
     */
    public function getAge(): int
    {
        return date("Y") - $this->birthYear;
    }

    /**
     * Trả về điểm trung bình của 3 môn
     * @return float
     */
    public function getAverage(): float
    {
        return round($this->getTotalScore() / 3, 2);
    }

    /**
     * Trả về xếp loại của sinh viên dựa trên điểm trung bình
     * @return string
     */
    public function getRank(): string
    {
        $avg = $this->getAverage();
        if ($avg >= 9.0) return "Xuất sắc";
        if ($avg >= 8.0) return "Giỏi";
        if ($avg >= 6.5) return "Khá";
        if ($avg >= 5.0) return "Trung bình";
        return "Yếu";
    }

    /**
     * Kiểm tra sinh viên có đạt học bổng hay không
     * Điều kiện: Điểm trung bình >= 8.0 và không có môn nào dưới 7.0
     * @return string
     */
    public function getScholarship(): string
    {
        $avg = $this->getAverage();
        if ($avg >= 8.0 && $this->scoreHtml >= 7.0 && $this->scoreCss >= 7.0 && $this->scorePhp >= 7.0) {
            return "Có";
        }
        return "Không";
    }

    /**
     * Trả về class màu theo xếp loại
     * @return string
     */
    public function getRowClass(): string
    {
        $rank = $this->getRank();
        switch ($rank) {
            case "Xuất sắc": return "table-success";
            case "Giỏi": return "table-info";
            case "Khá": return "table-primary";
            case "Trung bình": return "table-warning";
            case "Yếu": return "table-danger";
            default: return "";
        }
    }

    // Hiển thị 1 dòng trong bảng
    public function showInfo(): void
    {
        echo "
            <tr class='{$this->getRowClass()}'>
                <td>{$this->studentId}</td>
                <td>{$this->fullName}</td>
                <td>{$this->gender}</td>
                <td>{$this->birthYear}</td>
                <td>{$this->scoreHtml}</td>
                <td>{$this->scoreCss}</td>
                <td>{$this->scorePhp}</td>
                <td>{$this->getTotalScore()}</td>
                <td>{$this->getAge()}</td>
                <td>{$this->getAverage()}</td>
                <td>{$this->getRank()}</td>
                <td>{$this->getScholarship()}</td>
            </tr>
        ";
    }
}
