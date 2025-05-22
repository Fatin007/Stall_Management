<?php
include 'db.php';
include 'includes/functions.php';

$investors = $conn->query("SELECT * FROM investor");
$totalAmount = getTotalInvestment();

$page_title = 'Investors';

include 'includes/header.php';
?>

<div class="card mb-4">
    <div class="card-header bg-white d-flex flex-column flex-md-row justify-content-between align-items-md-center py-3">
        <h4 class="mb-2 mb-md-0 text-primary">
            <i class="fas fa-users me-2"></i> Investors
        </h4>
        <div class="mt-2 mt-md-0">
            <?php if (isLoggedIn()): ?>
                <a href="add_investor.php" class="btn btn-success mb-2 mb-md-0">
                    <i class="fas fa-plus me-1"></i> Add Investor
                </a>
            <?php endif; ?>
            <a href="index.php" class="btn btn-secondary ms-md-2">
                <i class="fas fa-chart-line me-1"></i> Sales Dashboard
            </a>
        </div>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-dark">
                    <tr>
                        <th class="d-none d-md-table-cell">#</th>
                        <th>Investor Name</th>
                        <th>Amount</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                <?php $i = 1; while ($investor = $investors->fetch_assoc()): ?>
                    <tr>
                        <td class="d-none d-md-table-cell"><?= $i++; ?></td>
                        <td>
                            <i class="fas fa-user-circle text-primary me-2"></i>
                            <?= htmlspecialchars($investor['name']); ?>
                        </td>
                        <td>
                            <span class="badge bg-success">
                                <i class="fas fa-dollar-sign me-1"></i>
                                <?= number_format($investor['amount'], 2); ?>
                            </span>
                        </td>
                        <td>
                            <?php if (isLoggedIn()): ?>
                                <a href="edit_investor.php?id=<?= $investor['investor_id']; ?>" class="btn btn-warning btn-sm">
                                    <i class="fas fa-edit me-1"></i>
                                </a>
                            <?php else: ?>
                                <span class="badge bg-secondary">Login to edit</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endwhile; ?>
                </tbody>
                <tfoot class="table-light">
                    <tr class="fw-bold">
                        <td colspan="<?= isLoggedIn() ? '2' : '1' ?>" class="text-end d-none d-md-table-cell">Total Investment:</td>
                        <td class="text-start d-md-none">Total Investment:</td>
                        <td colspan="<?= isLoggedIn() ? '2' : '1' ?>" class="<?= isLoggedIn() ? '' : 'text-end' ?>">
                            <span class="badge bg-primary" style="font-size: 1.1rem;">
                                <i class="fas fa-dollar-sign me-1"></i>
                                <?= number_format($totalAmount ?: 0, 2); ?>
                            </span>
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>

<div class="text-center">
    <a href="index.php" class="text-decoration-none">
        <i class="fas fa-arrow-left me-1"></i> Back to Dashboard
    </a>
</div>

<?php
include 'includes/footer.php';
?>