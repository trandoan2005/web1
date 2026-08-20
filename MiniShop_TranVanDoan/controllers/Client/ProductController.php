<?php
namespace Controllers\Client;

use DAO\ProductDAO;
use DAO\CategoryDAO;
use DAO\BrandDAO;

class ProductController
{
    public function index()
    {
        $pageTitle = "Tất cả sản phẩm";

        $productDAO = new ProductDAO();
        $categoryDAO = new CategoryDAO();
        $brandDAO = new BrandDAO();

        $categories = $categoryDAO->getAll();
        $brands = $brandDAO->getAll();

        // Phân trang & Lọc
        $keyword = trim($_GET["keyword"] ?? "");
        $sort = $_GET["sort"] ?? "newest";
        
        $filters = [];
        if (isset($_GET['min_price']) && $_GET['min_price'] !== '') $filters['min_price'] = (float)$_GET['min_price'];
        if (isset($_GET['max_price']) && $_GET['max_price'] !== '') $filters['max_price'] = (float)$_GET['max_price'];
        if (isset($_GET['is_sale'])) $filters['is_sale'] = 1;
        if (isset($_GET['category_id']) && $_GET['category_id'] !== '') $filters['category_id'] = (int)$_GET['category_id'];
        if (isset($_GET['brand_id']) && $_GET['brand_id'] !== '') $filters['brand_id'] = (int)$_GET['brand_id'];

        $limit = 12;
        $page = (int)($_GET["page"] ?? 1);
        $offset = ($page - 1) * $limit;

        $totalRecords = $productDAO->countClient($keyword, $filters);
        $totalPages = ceil($totalRecords / $limit);
        if ($page > $totalPages && $totalPages > 0) {
            $page = $totalPages;
            $offset = ($page - 1) * $limit;
        }

        $products = $productDAO->getClientProducts($limit, $offset, $keyword, $sort, $filters);

        require_once __DIR__ . '/../../views/client/products.php';
    }

    public function detail()
    {
        $productDAO = new ProductDAO();
        $categoryDAO = new CategoryDAO();
        $brandDAO = new BrandDAO();

        $categories = $categoryDAO->getAll();
        $brands = $brandDAO->getAll();

        $id = (int)($_GET['id'] ?? 0);
        $product = $productDAO->findById($id);

        if (!$product) {
            header("Location: index.php?area=client&controller=home&action=index");
            exit;
        }

        $pageTitle = $product->name;
        $galleryImages = $productDAO->getImagesByProductId($id);

        // Sản phẩm liên quan (cùng danh mục)
        $relatedProducts = $productDAO->getRelatedProducts($product->categoryId, $id, 4);

        require_once __DIR__ . '/../../views/client/product_detail.php';
    }

    public function category()
    {
        $productDAO = new ProductDAO();
        $categoryDAO = new CategoryDAO();
        $brandDAO = new BrandDAO();

        $categories = $categoryDAO->getAll();
        $brands = $brandDAO->getAll();

        $catId = (int)($_GET['id'] ?? 0);
        $category = $categoryDAO->findById($catId);

        if (!$category) {
            header("Location: index.php?area=client&controller=home&action=index");
            exit;
        }

        $pageTitle = $category->name;
        $sort = $_GET["sort"] ?? "newest";
        $limit = 12;
        $page = (int)($_GET["page"] ?? 1);
        $offset = ($page - 1) * $limit;

        $totalRecords = $productDAO->countByCategory($catId);
        $totalPages = ceil($totalRecords / $limit);
        if ($page > $totalPages && $totalPages > 0) {
            $page = $totalPages;
            $offset = ($page - 1) * $limit;
        }

        $products = $productDAO->getByCategory($catId, $limit, $offset, $sort);

        require_once __DIR__ . '/../../views/client/category.php';
    }

    public function brand()
    {
        $productDAO = new ProductDAO();
        $categoryDAO = new CategoryDAO();
        $brandDAO = new BrandDAO();

        $categories = $categoryDAO->getAll();
        $brands = $brandDAO->getAll();

        $brandId = (int)($_GET['id'] ?? 0);
        $brand = $brandDAO->findById($brandId);

        if (!$brand) {
            header("Location: index.php?area=client&controller=home&action=index");
            exit;
        }

        $pageTitle = $brand->name;
        $sort = $_GET["sort"] ?? "newest";
        $limit = 12;
        $page = (int)($_GET["page"] ?? 1);
        $offset = ($page - 1) * $limit;

        $totalRecords = $productDAO->countByBrand($brandId);
        $totalPages = ceil($totalRecords / $limit);
        if ($page > $totalPages && $totalPages > 0) {
            $page = $totalPages;
            $offset = ($page - 1) * $limit;
        }

        $products = $productDAO->getByBrand($brandId, $limit, $offset, $sort);

        require_once __DIR__ . '/../../views/client/brand.php';
    }

    public function search()
    {
        $productDAO = new ProductDAO();
        $categoryDAO = new CategoryDAO();
        $brandDAO = new BrandDAO();

        $categories = $categoryDAO->getAll();
        $brands = $brandDAO->getAll();

        $keyword = trim($_GET["keyword"] ?? "");
        $pageTitle = "Tìm kiếm: " . $keyword;
        $sort = $_GET["sort"] ?? "newest";
        $limit = 12;
        $page = (int)($_GET["page"] ?? 1);
        $offset = ($page - 1) * $limit;

        $totalRecords = $productDAO->countClient($keyword);
        $totalPages = ceil($totalRecords / $limit);
        if ($page > $totalPages && $totalPages > 0) {
            $page = $totalPages;
            $offset = ($page - 1) * $limit;
        }

        $products = $productDAO->getClientProducts($limit, $offset, $keyword, $sort);

        require_once __DIR__ . '/../../views/client/search.php';
    }
}
