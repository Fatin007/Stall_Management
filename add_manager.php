<?php 
include 'db.php';
include 'includes/functions.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $password = $_POST['password'];

    $hashed_password = password_hash($password, PASSWORD_DEFAULT); // Hash pass

    $stmt = $conn->prepare('INSERT INTO managers (name, password) VALUES (?, ?)');
    $stmt->bind_param('ss', $name, $hashed_password);
    
    if ($stmt->execute()) {
        header("Location: index.php?success=1&msg=manager_added");
        exit;
    } else {
        $error = $stmt->error;
    }
}

$page_title = 'Add Manager';

include 'includes/header.php';
?>

<div class="row justify-content-center">
    <div class="col-12 col-md-8 col-lg-6">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0"><i class="fas fa-user-plus me-2"></i>Add Manager</h4>
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
                        <label for="name" class="form-label"><i class="fas fa-user-tie me-2"></i>Manager Name</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light"><i class="fas fa-user"></i></span>
                            <input type="text" class="form-control" id="name" name="name" placeholder="Enter manager name" required>
                        </div>
                    </div>
                    <div class="mb-4">
                        <label for="password" class="form-label"><i class="fas fa-lock me-2"></i>Password</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light"><i class="fas fa-key"></i></span>
                            <input type="password" class="form-control" id="password" name="password" placeholder="Enter password" required>
                        </div>
                    </div>
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <a href="index.php" class="btn btn-outline-secondary">
                            <i class="fas fa-times me-1"></i> Cancel
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-1"></i> Add Manager
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
</div>

<?php
include 'includes/footer.php';
?>
