<?php
$current_page = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= isset($page_title) ? $page_title . ' | ' : '' ?>Byte & Bite</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="icon" href="assets/icon/favicon.ico" type="image/x-icon">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="index.php">
            <i class="fas fa-store me-2"></i>Byte & Bite
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link <?= $current_page == 'index.php' || $current_page == 'dashboard.php' ? 'active' : '' ?>" 
                       href="index.php"><i class="fas fa-home me-1"></i> Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= $current_page == 'show_investors.php' || $current_page == 'add_investor.php' || $current_page == 'edit_investor.php' ? 'active' : '' ?>" 
                       href="show_investors.php"><i class="fas fa-users me-1"></i> Investors</a>
                </li>
                <?php if (isLoggedIn()): ?>
                <li class="nav-item">
                    <a class="nav-link <?= $current_page == 'add_product.php' ? 'active' : '' ?>" 
                       href="add_product.php"><i class="fas fa-box me-1"></i> Add Product</a>
                </li>
                <?php endif; ?>
                <li class="nav-item">
                    <a class="nav-link <?= $current_page == 'add_manager.php' ? 'active' : '' ?>" 
                       href="add_manager.php"><i class="fas fa-user-tie me-1"></i> Add Manager</a>
                </li>
                <?php if (isLoggedIn()): ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown">
                            <i class="fas fa-user-circle me-1"></i> <?= htmlspecialchars(getCurrentManagerName()) ?>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="logout.php"><i class="fas fa-sign-out-alt me-2"></i>Logout</a></li>
                        </ul>
                    </li>
                <?php else: ?>
                    <li class="nav-item">
                        <a class="nav-link <?= $current_page == 'login.php' ? 'active' : '' ?>" href="login.php">
                            <i class="fas fa-sign-in-alt me-1"></i> Login
                        </a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>

<div class="container py-5">
    <?php if (isset($_GET['success'])): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>
            <?php 
                $msg = isset($_GET['msg']) ? $_GET['msg'] : '';
                switch($msg) {
                    case 'sale_updated':
                        echo 'Transaction has been updated successfully!';
                        break;
                    case 'transaction_added':
                        echo 'New transaction has been added successfully!';
                        break;
                    case 'manager_added':
                        echo 'New manager has been added successfully!';
                        break;
                    case 'login_success':
                        echo 'You have successfully logged in!';
                        break;
                    case 'logout_success':
                        echo 'You have successfully logged out!';
                        break;
                    default:
                        echo 'Operation completed successfully!';
                }
            ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>
    
    <?php if (isset($_GET['error'])): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-triangle me-2"></i>
            <?php 
                $msg = isset($_GET['msg']) ? $_GET['msg'] : '';
                switch($msg) {
                    case 'sale_not_found':
                        echo 'Transaction not found!';
                        break;
                    case 'login_required':
                        echo 'Please login to access this page!';
                        break;
                    case 'access_denied':
                        echo 'You do not have permission to access this resource!';
                        break;
                    default:
                        echo 'An error occurred.';
                }
            ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>