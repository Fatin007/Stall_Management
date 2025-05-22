<?php 
include 'db.php';
include 'includes/functions.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $prod_name = $_POST['prod_name'];

    $stmt = $conn->prepare("INSERT INTO product (prod_name) VALUES (?)");
    $stmt->bind_param("s", $prod_name);
    
    if ($stmt->execute()) {
        header("Location: index.php?success=1");
        exit;
    } else {
        $error = $stmt->error;
    }
}

$page_title = 'Add Product';

include 'includes/header.php';
?>

<div class="row justify-content-center">
    <?php if (isLoggedIn()): ?>
    <div class="col-12 col-md-8 col-lg-6">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0"><i class="fas fa-box-open me-2"></i>Add Product</h4>
            </div>
            <div class="card-body p-4">
                <?php if (isset($error)): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-triangle me-2"></i><?= htmlspecialchars($error) ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>
                
                <form method="POST">
                    <div class="mb-4">
                        <label for="prod_name" class="form-label"><i class="fas fa-tag me-2"></i>Product Name</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light"><i class="fas fa-box-open"></i></span>
                            <input type="text" class="form-control" id="prod_name" name="prod_name" placeholder="Enter product name" required>
                        </div>
                    </div>
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <a href="index.php" class="btn btn-outline-secondary">
                            <i class="fas fa-times me-1"></i> Cancel
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-1"></i> Add Product
                        </button>
                    </div>
                </form>
            </div>
        </div>
        <div class="text-center mt-4">
            <a href="index.php" class="text-decoration-none">
                <i class="fas fa-arrow-left me-1"></i> Back to Home
            </a>
        </div>
    </div>
    <?php else: ?>
        <?php header("Location: login.php"); ?>
    <?php endif; ?>
</div>

<?php
include 'includes/footer.php';
?>