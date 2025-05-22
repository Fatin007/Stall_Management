<?php
include 'db.php';
include 'includes/functions.php';

requireLogin();

$id = intval($_GET['id']);

$investor = getInvestorById($id);

if (!$investor) {
    header("Location: show_investors.php?error=1");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $amount = $_POST['amount'];

    $updateStmt = $conn->prepare("UPDATE investor SET name = ?, amount = ? WHERE investor_id = ?");
    $updateStmt->bind_param("sdi", $name, $amount, $id);
    
    if ($updateStmt->execute()) {
        header("Location: show_investors.php?success=1");
        exit;
    } else {
        $error = $updateStmt->error;
    }
}

$page_title = 'Edit Investor';

include 'includes/header.php';
?>

<div class="row justify-content-center">
    <div class="col-12 col-md-8 col-lg-6">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0"><i class="fas fa-edit me-2"></i>Edit Investor</h4>
            </div>
            <div class="card-body p-4">
                <?php if (isset($error)): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-triangle me-2"></i><?= htmlspecialchars($error) ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>
                <?php if (isset($_GET['success'])): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle me-2"></i>Investor updated successfully!
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>
                
                <form method="POST">
                    <div class="mb-3">
                        <label for="name" class="form-label"><i class="fas fa-user me-2"></i>Investor Name</label>
                        <div class="input-group mb-3">
                            <span class="input-group-text bg-light"><i class="fas fa-user"></i></span>
                            <input type="text" class="form-control" id="name" name="name" value="<?= htmlspecialchars($investor['name']) ?>" required>
                        </div>
                    </div>
                    <div class="mb-4">
                        <label for="amount" class="form-label"><i class="fas fa-dollar-sign me-2"></i>Amount</label>
                        <div class="input-group mb-3">
                            <span class="input-group-text bg-light"><i class="fas fa-coins"></i></span>
                            <input type="number" step="0.01" class="form-control" id="amount" name="amount" value="<?= htmlspecialchars($investor['amount']) ?>" required>
                            <span class="input-group-text bg-light">$</span>
                        </div>
                    </div>
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <a href="show_investors.php" class="btn btn-outline-secondary">
                            <i class="fas fa-times me-1"></i> Cancel
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-1"></i> Update Investor
                        </button>
                    </div>
                </form>
            </div>
        </div>
        <div class="text-center mt-4">
            <a href="show_investors.php" class="text-decoration-none">
                <i class="fas fa-arrow-left me-1"></i> Back to Investors
            </a>
        </div>
    </div>
</div>

<?php
include 'includes/footer.php';
?>