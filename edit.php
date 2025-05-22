<?php
include('db.php');
include('includes/functions.php');

requireLogin();

$id = intval($_GET['id']);

$products = getAllProducts();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $prod_name = trim($_POST['prod_name']);
    $amount = intval($_POST['amount']);

    $stmt = $conn->prepare("UPDATE sales SET prod_name=?, amount=? WHERE sale_id=?");
    $stmt->bind_param("sii", $prod_name, $amount, $id);
    if ($stmt->execute()) {
        header('Location: index.php?success=1&msg=sale_updated');
        exit;
    } else {
        $error = $stmt->error;
    }
}

$sale = getSaleById($id);

if (!$sale) {
    header('Location: index.php?error=1&msg=sale_not_found');
    exit;
}

$page_title = 'Edit Transaction';

include('includes/header.php');
?>

<div class="row justify-content-center">
    <div class="col-12 col-md-8 col-lg-6">
        <div class="card">
            <div class="card-header bg-warning text-dark">
                <h4 class="mb-0"><i class="fas fa-edit me-2"></i>Edit Transaction</h4>
            </div>
            <div class="card-body p-4">
                <?php if (isset($error)): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-triangle me-2"></i><?= htmlspecialchars($error) ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>

                <form method="POST">
                    <div class="mb-3">
                        <label for="prod_name" class="form-label"><i class="fas fa-box me-2"></i>Product</label>
                        <div class="input-group mb-3">
                            <span class="input-group-text bg-light"><i class="fas fa-tag"></i></span>
                            <select name="prod_name" class="form-select" id="prod_name" required>
                                <option value="">Select Product</option>
                                <?php foreach ($products as $product): ?>
                                    <option value="<?= htmlspecialchars($product['prod_name']) ?>" <?= $sale['prod_name'] == $product['prod_name'] ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($product['prod_name']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="mb-4">
                        <label for="amount" class="form-label"><i class="fas fa-dollar-sign me-2"></i>Amount</label>
                        <div class="input-group mb-3">
                            <span class="input-group-text bg-light"><i class="fas fa-coins"></i></span>
                            <input type="number" class="form-control" id="amount" name="amount" value="<?= htmlspecialchars($sale['amount']); ?>" required>
                            <span class="input-group-text bg-light">$</span>
                        </div>
                    </div>
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <a href="index.php" class="btn btn-secondary">
                            <i class="fas fa-times me-1"></i> Cancel
                        </a>
                        <button type="submit" class="btn btn-warning">
                            <i class="fas fa-save me-1"></i> Update
                        </button>
                    </div>
                </form>
            </div>
        </div>
        <div class="text-center mt-4">
            <a href="index.php" class="text-decoration-none">
                <i class="fas fa-arrow-left me-1"></i> Back to Dashboard
            </a>
        </div>
    </div>
</div>

<?php
include('includes/footer.php');
?>