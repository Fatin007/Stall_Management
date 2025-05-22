<?php
include 'db.php';
include 'includes/functions.php';

requireLogin();

if(isset($_GET['id'])) {
    $id = $_GET['id'];
    
    $id = mysqli_real_escape_string($conn, $id);
    
    $sql = "DELETE FROM sales WHERE sale_id = $id";
    
    if(mysqli_query($conn, $sql)) {
        $_SESSION['message'] = "Sale record deleted successfully";
        $_SESSION['msg_type'] = "danger";
    } 
    else {
        $_SESSION['message'] = "Error deleting record: " . mysqli_error($conn);
        $_SESSION['msg_type'] = "warning";
    }
    
    mysqli_close($conn);
    
    header("Location: dashboard.php");
    exit();
} else {
    $_SESSION['message'] = "No record specified for deletion";
    $_SESSION['msg_type'] = "warning";
    header("Location: dashboard.php");
    exit();
}
?>