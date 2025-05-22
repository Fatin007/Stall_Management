<?php
function isLoggedIn() {
    return isset($_SESSION['is_logged_in']) && $_SESSION['is_logged_in'] === true;
}

function requireLogin() {
    if (!isLoggedIn()) {
        header("Location: login.php?error=1&msg=login_required");
        exit;
    }
}

function getCurrentManagerId() {
    return isLoggedIn() ? $_SESSION['manager_id'] : null;
}

function getCurrentManagerName() {
    return isLoggedIn() ? $_SESSION['name'] : null;
}

function getAllProducts() {
    global $conn;
    $productQuery = $conn->query("SELECT product_id, prod_name FROM product ORDER BY prod_name");
    $products = [];
    while ($row = $productQuery->fetch_assoc()) {
        $products[] = $row;
    }
    return $products;
}

function getAllManagers() {
    global $conn;
    $managerQuery = $conn->query("SELECT manager_id, name FROM managers ORDER BY name");
    $managers = [];
    while ($row = $managerQuery->fetch_assoc()) {
        $managers[] = $row;
    }
    return $managers;
}

function getSaleById($id) {
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM sales WHERE sale_id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_assoc();
}

function getInvestorById($id) {
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM investor WHERE investor_id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_assoc();
}

function getTotalSales() {
    global $conn;
    return $conn->query("SELECT SUM(amount) AS total FROM sales")->fetch_assoc()['total'] ?: 0;
}

function getTotalInvestment() {
    global $conn;
    return $conn->query("SELECT SUM(amount) AS total FROM investor")->fetch_assoc()['total'] ?: 0;
}

function getProductCount() {
    global $conn;
    return $conn->query("SELECT COUNT(*) AS count FROM product")->fetch_assoc()['count'];
}

function getInvestorCount() {
    global $conn;
    return $conn->query("SELECT COUNT(*) AS count FROM investor")->fetch_assoc()['count'];
}

function getManagerCount() {
    global $conn;
    return $conn->query("SELECT COUNT(*) AS count FROM managers")->fetch_assoc()['count'];
}

function displayErrors($errors) {
    if (empty($errors)) return '';
    
    $html = '<div class="alert alert-danger alert-dismissible fade show" role="alert">';
    $html .= '<i class="fas fa-exclamation-triangle me-2"></i>';
    
    if (count($errors) === 1) {
        $html .= htmlspecialchars($errors[0]);
    } else {
        $html .= '<ul class="mb-0 ps-3">';
        foreach ($errors as $error) {
            $html .= '<li>' . htmlspecialchars($error) . '</li>';
        }
        $html .= '</ul>';
    }
    
    $html .= '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
    $html .= '</div>';
    
    return $html;
}