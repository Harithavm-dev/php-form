<?php 
if(isset($_GET['id']) && !empty($_GET['id'])) {
    
    $id = $_GET['id']; // Get the ID from the URL

    require 'connection.php'; // Include the database connection file

    // Prepare and execute the delete query
    $sql = "DELETE FROM registration_form WHERE id = $id";
    $conn->query($sql);
}
header("Location: /phptask/index.php"); // Redirect to the index page after deletion
    exit(); // Ensure no further code is executed
    
?>