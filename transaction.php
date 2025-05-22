<?php
include('db.php');
include('includes/functions.php');

$managers = getAllManagers();
$products = getAllProducts();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $prod_name = trim($_POST['prod_name']);
    $amount = intval($_POST['amount']);
    $manager_id = intval($_POST['manager_id']);

    $productCheck = $conn->prepare("SELECT product_id FROM product WHERE prod_name=?");
    $productCheck->bind_param("s", $prod_name);
    $productCheck->execute();
    $productCheck->store_result();

    if ($productCheck->num_rows == 0) {
        $error = "Product does not exist.";
    } else if ($amount <= 0) {
        $error = "Amount must be greater than zero.";
    } else {
        $stmt = $conn->prepare("INSERT INTO sales (prod_name, manager_id, amount) VALUES (?, ?, ?)");
        $stmt->bind_param("sii", $prod_name, $manager_id, $amount);
        
        if ($stmt->execute()) {
            $success = "Transaction added successfully.";
        } else {
            $error = $stmt->error;
        }
    }
}

$page_title = 'Add Transaction';

include('includes/header.php');
?>

<div class="row justify-content-center">
    <?php if (isLoggedIn()): ?>
    <div class="col-12 col-md-8 col-lg-6">
        <div class="card">
            <div class="card-header bg-success text-white">
                <h4 class="mb-0"><i class="fas fa-cash-register me-2"></i>Add Transaction</h4>
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
                            <select name="prod_name" id="prod_name" class="form-select" required>
                                <option value="">Select Product</option>
                                <?php foreach ($products as $product): ?>
                                    <option value="<?= htmlspecialchars($product['prod_name']) ?>"><?= htmlspecialchars($product['prod_name']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="manager_id" class="form-label"><i class="fas fa-user-tie me-2"></i>Manager</label>
                        <div class="input-group mb-3">
                            <span class="input-group-text bg-light"><i class="fas fa-user-shield"></i></span>
                            <select name="manager_id" id="manager_id" class="form-select" required>
                                <option value="">Select Manager</option>
                                <?php foreach ($managers as $manager): ?>
                                    <option value="<?= $manager['manager_id'] ?>"><?= htmlspecialchars($manager['name']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="mb-4">
                        <label for="amount" class="form-label"><i class="fas fa-dollar-sign me-2"></i>Amount</label>
                        <div class="input-group mb-3">
                            <span class="input-group-text bg-light"><i class="fas fa-coins"></i></span>
                            <input type="number" class="form-control" id="amount" name="amount" placeholder="Enter transaction amount" required>
                            <span class="input-group-text bg-light">$</span>
                        </div>
                    </div>
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <a href="index.php" class="btn btn-secondary">
                            <i class="fas fa-times me-1"></i> Cancel
                        </a>
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-save me-1"></i> Add Transaction
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
    <?php else: ?>
        <?php header("Location: login.php"); ?>
    <?php endif; ?>
</div>

<?php
include('includes/footer.php');
?>