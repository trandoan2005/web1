<?php
namespace Controllers\Client;

use DAO\ProductDAO;
use DAO\CategoryDAO;
use DAO\BrandDAO;

class HomeController
{
    public function index()
    {
        $pageTitle = "Trang chủ";

        $productDAO = new ProductDAO();
        $categoryDAO = new CategoryDAO();
        $brandDAO = new BrandDAO();

        // Lấy danh mục & thương hiệu cho header
        $categories = $categoryDAO->getAll();
        $brands = $brandDAO->getAll();

        // Sản phẩm mới nhất (8 sp)
        $latestProducts = $productDAO->getClientProducts(8, 0, "", "newest");

        // Sản phẩm giảm giá (có old_price > sale_price)
        $saleProducts = $productDAO->getSaleProducts(4);

        require_once __DIR__ . '/../../views/client/home.php';
    }
}
