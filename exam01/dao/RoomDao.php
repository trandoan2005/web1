<?php
require_once "models/Room.php";

class RoomDao {
    private $rooms = [];

    public function __construct() {
        // Initialize 15 sample rooms
        $this->rooms = [
            new Room(1, "101", "Phòng Đơn Tiêu Chuẩn", "Standard", 500000, 1, 1, "Còn trống", "https://images.unsplash.com/photo-1611892440504-42a792e24d32?w=500", "Phòng đơn tiêu chuẩn, đầy đủ tiện nghi cơ bản."),
            new Room(2, "102", "Phòng Đôi Tiêu Chuẩn", "Standard", 800000, 2, 1, "Đã đặt", "https://images.unsplash.com/photo-1590490359683-658d3d23f972?w=500", "Phòng đôi rộng rãi với cửa sổ lớn."),
            new Room(3, "103", "Phòng Gia Đình Tiêu Chuẩn", "Standard", 1200000, 4, 1, "Còn trống", "https://images.unsplash.com/photo-1566665797739-1674de7a421a?w=500", "Phòng gia đình có 2 giường lớn."),
            new Room(4, "201", "Phòng Đơn Cao Cấp", "Superior", 800000, 1, 2, "Bảo trì", "https://images.unsplash.com/photo-1596394516093-501ba68a0ba6?w=500", "Phòng cao cấp đang được bảo trì."),
            new Room(5, "202", "Phòng Đôi Cao Cấp", "Superior", 1200000, 2, 2, "Còn trống", "https://images.unsplash.com/photo-1582719478250-c89cae4dc85b?w=500", "Phòng đôi view đẹp, nội thất sang trọng."),
            new Room(6, "203", "Phòng Vip Đơn", "VIP", 1500000, 1, 2, "Đã đặt", "https://images.unsplash.com/photo-1631049307264-da0ec9d70304?w=500", "Phòng VIP đơn đầy đủ dịch vụ hạng sang."),
            new Room(7, "301", "Phòng Vip Đôi", "VIP", 2500000, 2, 3, "Còn trống", "https://images.unsplash.com/photo-1578683010236-d716f9a3f461?w=500", "Phòng VIP đôi có ban công riêng."),
            new Room(8, "302", "Phòng Tổng Thống", "President", 5000000, 4, 3, "Còn trống", "https://images.unsplash.com/photo-1564013799919-ab600027ffc6?w=500", "Phòng lớn nhất khách sạn, siêu sang trọng."),
            new Room(9, "401", "Phòng Đơn Tiêu Chuẩn", "Standard", 500000, 1, 4, "Đã đặt", "https://images.unsplash.com/photo-1611892440504-42a792e24d32?w=500", "Phòng tiêu chuẩn tầng 4."),
            new Room(10, "402", "Phòng Đôi Tiêu Chuẩn", "Standard", 800000, 2, 4, "Bảo trì", "https://images.unsplash.com/photo-1590490359683-658d3d23f972?w=500", "Bảo trì định kỳ."),
            new Room(11, "403", "Phòng Đôi Cao Cấp", "Superior", 1200000, 2, 4, "Còn trống", "https://images.unsplash.com/photo-1582719478250-c89cae4dc85b?w=500", "Phòng Superior view biển."),
            new Room(12, "501", "Phòng Gia Đình VIP", "VIP", 3000000, 4, 5, "Còn trống", "https://images.unsplash.com/photo-1566665797739-1674de7a421a?w=500", "Gia đình tận hưởng không gian đẳng cấp."),
            new Room(13, "502", "Phòng Đôi Superior", "Superior", 1250000, 2, 5, "Đã đặt", "https://images.unsplash.com/photo-1596394516093-501ba68a0ba6?w=500", "Đã có người đặt trước qua hệ thống."),
            new Room(14, "601", "Phòng Đôi Cửa Sổ", "Standard", 850000, 2, 6, "Còn trống", "https://images.unsplash.com/photo-1578683010236-d716f9a3f461?w=500", "Phòng tiêu chuẩn view thành phố."),
            new Room(15, "602", "Phòng Đơn Tiện Tích", "Standard", 550000, 1, 6, "Còn trống", "https://images.unsplash.com/photo-1611892440504-42a792e24d32?w=500", "Phù hợp cho chuyến đi công tác ngắn ngày.")
        ];
    }

    public function getAll() {
        return $this->rooms;
    }

    public function findById($id) {
        foreach ($this->rooms as $room) {
            if ($room->id == $id) {
                return $room;
            }
        }
        return null;
    }

    public function search($keyword, $type, $status, $minPrice, $maxPrice) {
        $results = [];
        foreach ($this->rooms as $room) {
            $match = true;

            // Lọc theo tên phòng
            if (!empty($keyword) && mb_stripos($room->roomName, $keyword) === false) {
                $match = false;
            }
            // Lọc theo loại phòng
            if (!empty($type) && $room->roomType != $type) {
                $match = false;
            }
            // Lọc theo trạng thái
            if (!empty($status) && $room->status != $status) {
                $match = false;
            }
            // Lọc theo khoảng giá
            if (!empty($minPrice) && $room->price < $minPrice) {
                $match = false;
            }
            if (!empty($maxPrice) && $room->price > $maxPrice) {
                $match = false;
            }

            if ($match) {
                $results[] = $room;
            }
        }
        return $results;
    }

    public function sortPriceASC($data) {
        usort($data, function($a, $b) {
            return $a->price <=> $b->price;
        });
        return $data;
    }

    public function sortPriceDESC($data) {
        usort($data, function($a, $b) {
            return $b->price <=> $a->price;
        });
        return $data;
    }

    public function paging($data, $page, $pageSize) {
        $offset = ($page - 1) * $pageSize;
        return array_slice($data, $offset, $pageSize);
    }

    public function getStats() {
        $total = count($this->rooms);
        $available = 0;
        $booked = 0;
        $maintenance = 0;

        foreach ($this->rooms as $room) {
            if ($room->status == 'Còn trống') $available++;
            if ($room->status == 'Đã đặt') $booked++;
            if ($room->status == 'Bảo trì') $maintenance++;
        }

        return [
            'total' => $total,
            'available' => $available,
            'booked' => $booked,
            'maintenance' => $maintenance
        ];
    }
}
?>
