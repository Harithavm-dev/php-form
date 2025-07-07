<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Table</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container my-5">
        <h2>List of clients</h2>
        <a class="btn btn-primary" href="/phptask/create.php" role="button">New Registration Form</a>
        <br><br>
    <table class="table">
            <thead>
                <tr>
                    <th>id</th>
                    <th>Firstname</th>
                    <th>Lastname</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Hobby</th>
                    <th>Country</th>
                    <th>State</th>
                    <th>District</th>
                    <th>Pincode</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                require 'connection.php'; // Make sure $conn is included
                // Check if the connection was successful
                if($conn->connect_error){
                    die("Connection failed: ".$conn->connect_error);
                }

            $sql = "SELECT * FROM registration_form"; // Use the correct SELECT query
            $result = $conn->query($sql);
            // Check if the query was successful  (error handling)
            if (!$result) {
                die("Invalid query: " .$conn->error);
            }

            while($row = $result->fetch_assoc()) { 
                
                // Display each row of data in the table

                echo "
                <tr>
                    <td>$row[id] </td>
                    <td>$row[firstname] </td>
                    <td>$row[lastname] </td>
                    <td>$row[email] </td>
                    <td>$row[phone] </td>
                    <td>$row[hobby] </td>
                    <td>$row[country] </td>
                    <td>$row[state] </td>
                    <td>$row[district] </td>
                    <td>$row[pincode] </td>
                    <td>
                        <a class='btn btn-primary btn-sm' href='/phptask/edit.php?id=$row[id]'>Edit</a>
                        <a class='btn btn-danger btn-sm' href='/phptask/delete.php?id=$row[id]'>Delete</a>
                </tr>
                ";
                 }
           
                ?>
            </tbody>
        </table>
</body>
</html>
