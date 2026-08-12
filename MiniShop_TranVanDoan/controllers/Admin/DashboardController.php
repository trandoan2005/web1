<?php
namespace Controllers\Admin;

use DAO\ProductDAO;
use DAO\CategoryDAO;
use DAO\BrandDAO;
use DAO\CustomerDAO;
use DAO\OrderDAO;

class DashboardController
{
    public function index()
    {
        $pageTitle = "Dashboard";
        
        $productDAO = new ProductDAO();
        $categoryDAO = new CategoryDAO();
        $brandDAO = new BrandDAO();
        $customerDAO = new CustomerDAO();
        $orderDAO = new OrderDAO();
        
        $totalProducts = $productDAO->count();
        $totalCategories = $categoryDAO->count();
        $totalBrands = $brandDAO->count();
        $totalCustomers = $customerDAO->count();
        $totalOrders = $orderDAO->count();
        
        $latestProducts = $productDAO->getLatest(5);
        $latestOrders = $orderDAO->getLatest(5);

        require_once __DIR__ . '/../../views/admin/dashboard.php';
    }
}
