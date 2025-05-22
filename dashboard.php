<?php
include 'db.php';
include 'includes/functions.php';

$page_title = 'Dashboard';

$salesQuery = $conn->query("SELECT s.*, m.name as manager_name 
                          FROM sales s 
                          LEFT JOIN managers m ON s.manager_id = m.manager_id 
                          ORDER BY s.sale_id DESC 
                        --   LIMIT 10
                          ");

$group_query = $conn->query("SELECT p.prod_name, SUM(s.amount) as total_amount 
                             FROM sales s 
                             JOIN product p ON s.prod_name = p.prod_name 
                             GROUP BY p.prod_name");
                          
$totalSales = getTotalSales();
$productCount = getProductCount();
$investorCount = getInvestorCount();
$totalInvestment = getTotalInvestment();
$managerCount = getManagerCount();


include 'includes/header.php';
?>

<!-- Stat Cards -->
<div class="row mb-4">
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card stats-card primary h-100">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col">
                        <div class="text-xs text-uppercase mb-1 text-primary fw-bold">Total Sales</div>
                        <div class="h4 mb-0 fw-bold text-gray-800">$<?= number_format($totalSales, 2) ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-dollar-sign fa-2x text-gray-300 stats-card-icon"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card stats-card success h-100">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col">
                        <div class="text-xs text-uppercase mb-1 text-success fw-bold">Products</div>
                        <div class="h4 mb-0 fw-bold text-gray-800"><?= $productCount ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-box fa-2x text-gray-300 stats-card-icon"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card stats-card info h-100">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col">
                        <div class="text-xs text-uppercase mb-1 text-info fw-bold">Investors</div>
                        <div class="h4 mb-0 fw-bold text-gray-800"><?= $investorCount ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-users fa-2x text-gray-300 stats-card-icon"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card stats-card warning h-100">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col">
                        <div class="text-xs text-uppercase mb-1 text-warning fw-bold">Total Investment</div>
                        <div class="h4 mb-0 fw-bold text-gray-800">$<?= number_format($totalInvestment, 2) ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-coins fa-2x text-gray-300 stats-card-icon"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Recent Sales Table -->
<div class="card mb-4">
    <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
        <h5 class="mb-0 text-primary">
            <i class="fas fa-table me-2"></i> Recent Transactions
        </h5>
        <?php if (isLoggedIn()): ?>
        <a href="transaction.php" class="btn btn-success btn-sm">
            <i class="fas fa-plus me-1"></i> Add Transaction
        </a>
        <?php else: ?>
            <span class="badge bg-secondary">Login to add transaction</span>
        <?php endif; ?>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-dark">
                    <tr>
                        <th>Product</th>
                        <th>Manager</th>
                        <th>Amount</th>
                        <?php if (isLoggedIn()): ?>
                        <th>Actions</th>
                        <?php endif; ?>
                    </tr>
                </thead>
                <tbody>
                <?php if ($salesQuery->num_rows == 0): ?>
                    <tr>
                        <td colspan="5" class="text-center py-4">No transactions found</td>
                    </tr>
                <?php else: ?>
                    <?php while ($sale = $salesQuery->fetch_assoc()): ?>
                        <tr>
                            <td>
                                <i class="fas fa-box text-primary me-2"></i>
                                <?= htmlspecialchars($sale['prod_name']) ?>
                            </td>
                            <td>
                                <i class="fas fa-user-tie text-secondary me-2"></i>
                                <?= htmlspecialchars($sale['manager_name'] ?? 'N/A') ?>
                            </td>
                            <td>
                                <span class="badge bg-success">
                                    <i class="fas fa-dollar-sign me-1"></i>
                                    <?= number_format($sale['amount'], 2) ?>
                                </span>
                            </td>
                            <?php if (isLoggedIn()): ?>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <a href="edit.php?id=<?= $sale['sale_id'] ?>" class="btn btn-warning">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="delete.php?id=<?= $sale['sale_id'] ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this transaction?');">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </div>
                            </td>
                            <?php endif; ?>
                        </tr>
                    <?php endwhile; ?>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Quick Links -->
<div class="row">
    <div class="col-lg-3 col-md-6 mb-4">
        <div class="card h-100 text-center">
            <div class="card-body">
                <i class="fas fa-plus-circle fa-3x text-primary mb-3"></i>
                <h5 class="card-title">New Transaction</h5>
                <p class="card-text small">Add a new sales transaction</p>
            </div>
            <div class="card-footer">
                <a href="transaction.php" class="btn btn-primary btn-sm w-100">
                    <i class="fas fa-arrow-right me-1"></i> Go
                </a>
            </div>
        </div>
    </div>
    
    <div class="col-lg-3 col-md-6 mb-4">
        <div class="card h-100 text-center">
            <div class="card-body">
                <i class="fas fa-box fa-3x text-success mb-3"></i>
                <h5 class="card-title">Add Product</h5>
                <p class="card-text small">Create a new product</p>
            </div>
            <div class="card-footer">
                <a href="add_product.php" class="btn btn-success btn-sm w-100">
                    <i class="fas fa-arrow-right me-1"></i> Go
                </a>
            </div>
        </div>
    </div>
    
    <div class="col-lg-3 col-md-6 mb-4">
        <div class="card h-100 text-center">
            <div class="card-body">
                <i class="fas fa-user-plus fa-3x text-info mb-3"></i>
                <h5 class="card-title">Add Investor</h5>
                <p class="card-text small">Register a new investor</p>
            </div>
            <div class="card-footer">
                <a href="add_investor.php" class="btn btn-info btn-sm w-100 text-white">
                    <i class="fas fa-arrow-right me-1"></i> Go
                </a>
            </div>
        </div>
    </div>
    
    <div class="col-lg-3 col-md-6 mb-4">
        <div class="card h-100 text-center">
            <div class="card-body">
                <i class="fas fa-user-tie fa-3x text-warning mb-3"></i>
                <h5 class="card-title">Add Manager</h5>
                <p class="card-text small">Register a new manager</p>
            </div>
            <div class="card-footer">
                <a href="add_manager.php" class="btn btn-warning btn-sm w-100 text-dark">
                    <i class="fas fa-arrow-right me-1"></i> Go
                </a>
            </div>
        </div>
    </div>
</div>

<!-- product wise total -->
<div class="card mb-4">
    <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
        <h5 class="mb-0 text-primary">
            <i class="fas fa-chart-bar me-2"></i> Product Wise Total
        </h5>
    </div>
    <div class="card-body">
        <?php if ($group_query->num_rows == 0): ?>
            <div class="text-center py-4">No data found</div>
        <?php else: ?>
            <div class="row">
                <?php while ($row = $group_query->fetch_assoc()): ?>
                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="card h-100 border-left-primary shadow-sm">
                            <div class="card-body">
                                <h5 class="card-title text-primary">
                                    <i class="fas fa-box me-2"></i>
                                    <?= htmlspecialchars($row['prod_name']) ?>
                                </h5>
                                <div class="h4 mb-0 font-weight-bold text-success">
                                    $<?= number_format($row['total_amount'], 2) ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php
include 'includes/footer.php';
?>