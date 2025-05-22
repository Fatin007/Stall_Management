<?php
include 'db.php';
include 'includes/functions.php';

if (isLoggedIn()) {
    header("Location: dashboard.php");
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = trim($_POST['name']);
    $password = $_POST['password'];

    if (empty($name) || empty($password)) {
        $error = "Username and password are required.";
    } else {
        $stmt = $conn->prepare("SELECT manager_id, name, password FROM managers WHERE name = ?");
        $stmt->bind_param('s', $name);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();
            
            if (password_verify($password, $user['password'])) {
                $_SESSION['manager_id'] = $user['manager_id'];
                $_SESSION['name'] = $user['name'];
                $_SESSION['is_logged_in'] = true;
                
                header("Location: dashboard.php?success=1&msg=login_success");
                exit;
            } else {
                $error = "Invalid password. Please try again.";
            }
        } else {
            $error = "User not found. Please check your username.";
        }
    }
}

$page_title = 'Login';

include 'includes/header.php';
?>

<div class="row justify-content-center">
    <div class="col-12 col-md-6 col-lg-5">
        <div class="card mb-4">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0"><i class="fas fa-sign-in-alt me-2"></i>Login</h4>
            </div>
            <div class="card-body p-4">
                <?php if (!empty($error)): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-circle me-2"></i><?= htmlspecialchars($error) ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>
                
                <form method="POST">
                    <div class="mb-3">
                        <label for="name" class="form-label"><i class="fas fa-user me-2"></i>Username</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light"><i class="fas fa-user-tie"></i></span>
                            <input type="text" class="form-control" id="name" name="name" placeholder="Enter your username" required>
                        </div>
                    </div>
                    <div class="mb-4">
                        <label for="password" class="form-label"><i class="fas fa-lock me-2"></i>Password</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light"><i class="fas fa-key"></i></span>
                            <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password" required>
                        </div>
                    </div>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="fas fa-sign-in-alt me-2"></i> Login
                        </button>
                    </div>
                </form>
            </div>
        </div>
        
        <div class="text-center">
            <a href="index.php" class="text-decoration-none">
                <i class="fas fa-arrow-left me-1"></i> Back to Home
            </a>
        </div>
    </div>
</div>

<?php
include 'includes/footer.php';
?>