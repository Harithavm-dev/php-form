<?php
require 'connection.php';

if(isset($_POST["submit"])){
    $name = $_POST["name"];
    $age  = $_POST["age"];
    $country  = $_POST["country"];
    $gender  = $_POST["gender"];
    $languages  = $_POST["languages"];
    $language ="";
    foreach($languages as $row){
        $language .= $row . ",";
    }

    $query = "INSERT INTO registration_form (name, age, country, gender, languages) VALUES('$name', '$age', '$country', '$gender', '$language')";
    mysqli_query($conn, $query);
    echo
    "
    <script>
     alert('Data Inserted'); 
     </script>
    ";
}
    $sql = "SELECT name, age, country, gender, languages FROM registration_form";
    $result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insert Data</title>
</head>
<style media="screen">
     label {
            display: block;
            margin-top: 10px;
        }
        table, th, td {
            border: 1px solid black;
            border-collapse: collapse;
            padding: 5px;
            margin-top: 20px;
        }
    </style>
<body>
    <form class=""  action="" method="post" autocomplete="off">
        <label for="">Name</label>
        <input type="text" name="name" required value="">
        <label  for="">age</label>
        <input type="number" name="age" required value="">
        <label for="">country</label>
        <select class="" name="country" required>
            <option value="" selected hidden>Select Country</option>
            <option value="USA">USA</option>
            <option value="UK">UK</option>
            <option value="INDIA">INDIA</option>
        </select>
        <label for="">Gender</label>
        <input type="radio" name="gender" value="male" required>Male
        <input type="radio" name="gender" value="female" >Female
        <label for="">Language</label>
        <input type="checkbox" name="languages[]" value="english" >english
        <input type="checkbox" name="languages[]" value="tamil" >tamil
        <input type="checkbox" name="languages[]" value="kanada" >kanada
        <input type="checkbox" name="languages[]" value="telugu" >telugu
        <br>
        <button type="submit" name="submit">Submit</button>
    </form>

    <table>
    <tr>
    <td>name</td>
    <td>age</td>
    <td>country</td>
    <td>gender</td>
    <td>languages</td>
</tr>
<?php
while ($row = mysqli_fetch_assoc($result)){
    echo "<tr>
    <td>".$row['name']."</td>
    <td>".$row['age']."</td>
    <td>".$row['country']."</td>
    <td>".$row['gender']."</td>
    <td>".$row['languages']."</td>
    </tr>";
}
?>
</body>
</html>