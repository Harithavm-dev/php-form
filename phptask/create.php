<?php
require 'connection.php';

$firstname="";
$lastname="";
$email="";
$phone="";
$hobby="";
$country="";
$state="";
$district="";
$pincode="";

$errormessage="";
$successmessage="";


if ($_SERVER['REQUEST_METHOD'] === 'POST' ) {
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $hobby = $_POST['hobby'];
    $country = $_POST['country'];
    $state = $_POST['state'];
    $district = $_POST['district'];
    $pincode = $_POST['pincode'];

   do {
    // 1. Validation
    if (empty($firstname) || empty($lastname) || empty($email) || empty($phone) || empty($hobby) || empty($country) || empty($state) || empty($district) || empty($pincode)) {
        $errormessage = "All fields are required";
        break;
    }

    // 2. Insert query
    $sql = "INSERT INTO registration_form (firstname, lastname, email, phone, hobby, country, state, district, pincode)
            VALUES ('$firstname', '$lastname', '$email', '$phone', '$hobby', '$country', '$state', '$district', '$pincode')";

    if ($conn->query($sql)) {
        header("Location: /phptask/index.php");
        exit;
    } else {
        $errormessage = "Insert failed: " . $conn->error;
        break;
    }

} while (false);

    
    
}?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <script defer>
        const data = {
            india: {
                tamilnadu: {
                    chennai: ['600001', '600002'],
                    madurai: ['625001', '625002']
                },
                kerala: {
                    kochi: ['682001', '682002'],
                    trivandrum: ['695001', '695002']
                }
            },
            usa: {
                california: {
                    la: ['90001', '90002'],
                    sf: ['94101', '94102']
                },
                texas: {
                    dallas: ['75201', '75202'],
                    houston: ['77001', '77002']
                }
            },
            canada: {
                ontario: {
                    toronto: ['M5A 1A1', 'M5B 1B1'],
                    england: ['EC1A 1BB', 'EC1A 1AA']
                },
                new_south_wales: {
                    london: ['2000', '2004'],
                    syndey: ['2500', '2003']
                }
            }
        };

        document.addEventListener('DOMContentLoaded', function () {
            const firstname = document.getElementById('firstname');
            const lastname = document.getElementById('lastname');
            const phone = document.getElementById('phone');

            firstname.addEventListener('keypress', function(e) {
                const code = e.which || e.keyCode;
                if (!((code >= 65 && code <= 90) || (code >= 97 && code <= 122) || code === 32 || code === 46)) {
                    e.preventDefault();
                }
            });

            lastname.addEventListener('keypress', function(e) {
                const code = e.which || e.keyCode;
                if (!((code >= 65 && code <= 90) || (code >= 97 && code <= 122) || code === 32 || code === 46)) {
                    e.preventDefault();
                }
            });

            phone.addEventListener('keypress', function(e) {
                const code = e.which || e.keyCode;
                if ((code < 48 || code > 57) ) {
                    e.preventDefault();
                }
            });

            phone.addEventListener('input', function() {
                if (phone.value.length > 10) {
                    phone.value = phone.value.slice(0, 10);
                }
            });

            const country = document.getElementById("country");
            const state = document.getElementById("state");
            const district = document.getElementById("district");
            const pincode = document.getElementById("pincode");

            country.addEventListener("change", () => {
                state.innerHTML = '<option value="">--Select State--</option>';
                district.innerHTML = '<option value="">--Select District--</option>';
                pincode.innerHTML = '<option value="">--Select Pincode--</option>';
                const selectedCountry = country.value;

                if (data[selectedCountry]) {
                    Object.keys(data[selectedCountry]).forEach(st => {
                        state.innerHTML += `<option value="${st}">${st}</option>`;
                    });
                }
            });

            state.addEventListener("change", () => {
                district.innerHTML = '<option value="">--Select District--</option>';
                pincode.innerHTML = '<option value="">--Select Pincode--</option>';
                const selectedCountry = country.value;
                const selectedState = state.value;

                if (data[selectedCountry]?.[selectedState]) {
                    Object.keys(data[selectedCountry][selectedState]).forEach(dist => {
                        district.innerHTML += `<option value="${dist}">${dist}</option>`;
                    });
                }
            });

            district.addEventListener("change", () => {
                pincode.innerHTML = '<option value="">--Select Pincode--</option>';
                const selectedCountry = country.value;
                const selectedState = state.value;
                const selectedDistrict = district.value;

                if (data[selectedCountry]?.[selectedState]?.[selectedDistrict]) {
                    data[selectedCountry][selectedState][selectedDistrict].forEach(pin => {
                        pincode.innerHTML += `<option value="${pin}">${pin}</option>`;
                    });
                }
            });
        });
        

    if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
    }

    </script>
</head>
<body>

    <div class="container my-5">
        
    <?php 
    if(!empty($errormessage)){
        echo "
        <div class='alert alert-warning alert-dismissable fade show' role='alert'>
        <strong>$errormessage</strong>
        <button> type='button' class='btn-close' data-bs-dismiss='alert' aria-label='close'></button>
        </div>
        ";
    }
    ?>

        <form  method="post" id="form">
            <!-- <h2>New Registration form</h2>
            <br><br> -->
            <h1>Registration Form</h1><br><br>
          
            <div class="input-group">
                <label for="firstname">Firstname:</label>
                <input type="text" id="firstname" name="firstname" placeholder="Enter your first name" required >
                <br><br>

                <label for="lastname">Lastname:</label>
                <input type="text" id="lastname" name="lastname" placeholder="Enter your last name" required >
                <br><br>

                <label for="email">Email:</label>
                <input type="email" id="email" name="email" placeholder="Enter your email" required >
                <br><br>

                <label for="phone">Phone No:</label>
                <input type="tel" id="phone" name="phone" placeholder="Enter your phone number" required >
                <br><br>

                <label for="hobby">Hobbies:</label>
                <select id="hobby" name="hobby" required >
                    <option value="">--Select Hobby--</option>
                    <option value="reading">Reading</option>
                    <option value="travelling">Travelling</option>
                    <option value="gaming">Gaming</option>
                    <option value="cooking">Cooking</option>
                    <option value="sports">Sports</option>
                </select>
                <br><br>

                <label for="country">Country:</label>
                <select id="country" name="country" required >
                    <option value="">--Select Country--</option>
                    <option value="india">India</option>
                    <option value="usa">USA</option>
                    <option value="canada">Canada</option>
                </select>
               <br><br>

                <label for="state">State:</label>
                <select id="state" name="state" required >
                    <option value="">--Select State--</option>
                </select>
               <br><br>

                <label for="district">District:</label>
                <select id="district" name="district" required >
                    <option value="">--Select District--</option>
                </select>
                <br><br>

                <label for="pincode">Pincode:</label>
                <select id="pincode" name="pincode" required >
                    <option value="">--Select Pincode--</option>
                </select>
            <?php 
            if(!empty($successmessage)){
                echo "
                <div class='alert alert-success alert-dismissable fade show' role='alert'>
                <strong>$successmessage</strong>
                <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='close'></button>
                </div>
                ";
            }
            ?>    
            <button type="submit"  id="mybtn" name="submit">Submit</button>
            <button class="btn btn-outline-primary" onclick="window.location.href='/phptask/index.php'">Cancel</button>


                <div class="error"></div>
            </div><br><br>
        </form>

        <br><br>
        
    </div>
</body>
</html>