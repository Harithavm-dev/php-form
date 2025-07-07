<?php 

//create
require 'connection.php'; // Include the database connection file

$id = $firstname = $lastname = $email = $phone = $hobby = $country = $state = $district = $pincode = "";
$errormessage = $successmessage = "";

if( $_SERVER['REQUEST_METHOD'] == 'GET'){
    //GET method: show the data of the client
    if( !isset($_GET["id"])){
        header("Location: /phptask/index.php");
        exit;
    }
$id = $_GET["id"];

// read the row of the selected client from database table
$sql = "SELECT * FROM registration_form WHERE id = $id";
$result = $conn->query($sql);
// Check if the query was successful
if($result && $result->num_rows > 0){
    $row = $result->fetch_assoc();

    $firstname = $row["firstname"];
    $lastname = $row["lastname"];
    $email = $row["email"];
    $phone = $row["phone"];
    $hobby = $row["hobby"];
    $country = $row["country"];
    $state = $row["state"]; 
    $district = $row["district"];
    $pincode = $row["pincode"];
}
}
else{
    //POST method: update the data of the clients

    $id = $_POST["id"];
    $firstname = $_POST["firstname"];
    $lastname = $_POST["lastname"];
    $email = $_POST["email"];
    $phone = $_POST["phone"];
    $hobby = $_POST["hobby"];
    $country = $_POST["country"];
    $state = $_POST["state"];
    $district = $_POST["district"];
    $pincode = $_POST["pincode"];

    do{
        if( empty($id) || empty($firstname) || empty($lastname) || empty($email) || empty($phone) || empty($hobby) || empty($country) || empty($state) || empty($district) || empty($pincode)){
            $errormessage = "All the fields are required";
            break;
        }

        // update the data of the client in database table
        $sql = "UPDATE registration_form SET firstname = '$firstname', lastname = '$lastname', email = '$email', phone = '$phone', hobby = '$hobby', country = '$country', state = '$state', district = '$district', pincode = '$pincode' WHERE id = $id";
        $result = $conn->query($sql);

        if(!$result){
            $errormessage = "Invalid query: " . $conn->error;
            break;
        }

        $successmessage = "Client updated successfully";

        header("Location: /phptask/index.php");
        exit;
    }while (false);
}
?>

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
                console.log(`You released key: ${e.key}`);
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
                console.log(`You released key: ${e.key}`)
                const code = e.which || e.keyCode;
                if ((code < 48 || code > 57) || phone.value.length >= 10) {
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
            
                            // Prefill logic for edit
                const editCountry = "<?php echo $country; ?>";
                const editState = "<?php echo $state; ?>";
                const editDistrict = "<?php echo $district; ?>";
                const editPincode = "<?php echo $pincode; ?>";

                // Prefill State
                if (data[editCountry]) {
                    Object.keys(data[editCountry]).forEach(st => {
                        const opt = new Option(st, st);
                        if (st === editState) opt.selected = true;
                        state.appendChild(opt);
                    });
                }

                // Prefill District
                if (data[editCountry]?.[editState]) {
                    Object.keys(data[editCountry][editState]).forEach(dist => {
                        const opt = new Option(dist, dist);
                        if (dist === editDistrict) opt.selected = true;
                        district.appendChild(opt);
                    });
                }

                // Prefill Pincode
                if (data[editCountry]?.[editState]?.[editDistrict]) {
                    data[editCountry][editState][editDistrict].forEach(pin => {
                        const opt = new Option(pin, pin);
                        if (pin === editPincode) opt.selected = true;
                        pincode.appendChild(opt);
                    });
                }
                    });

    </script>
</head>
<body>

    <div class="container my-5">
    <h1>Registration Form</h1><br><br>    
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

        <form method="post" id="form">
            <input type="hidden" name="id" value="<?php echo $id; ?>">   
          
            <div class="input-group">
                <label for="firstname">Firstname:</label>
                <input type="text" id="firstname" name="firstname" placeholder="Enter your first name" required value="<?php echo $firstname; ?>">
                <br><br>

                <label for="lastname">Lastname:</label>
                <input type="text" id="lastname" name="lastname" placeholder="Enter your last name" required value="<?php echo $lastname; ?>">
                <br><br>

                <label for="email">Email:</label>
                <input type="email" id="email" name="email" placeholder="Enter your email" required value="<?php echo $email; ?>">
                <br><br>

                <label for="phone">Phone No:</label>
                <input type="tel" id="phone" name="phone" placeholder="Enter your phone number" required value="<?php echo $phone; ?>">
                <br><br>

                <label for="hobby">Hobbies:</label>
                <select id="hobby" name="hobby" required >
                    <option value="<?php echo $hobby; ?>" ><?php echo $hobby; ?></option>
                    <?php
                    $allHobbies = ["reading", "music", "gaming", "travel"];
                    foreach($allHobbies as $h){
                        if($h != $hobby){
                            echo "<option value='$h'>$h</option>";
                        }
                    }
                    ?>
                </select>
                <br><br>

                                <!-- Country Dropdown -->
                <label for="country">Country:</label>
                <select id="country" name="country" required>
                    <option value="<?php echo $country; ?>"><?php echo ucfirst($country); ?></option>
                    <?php
                    $allcountries = ["india", "usa", "canada"];
                    foreach($allcountries as $c){
                        if($c != $country){
                            echo "<option value='$c'>$c</option>";
                        }
                    }
                    ?>
                </select>
                <br><br>

                <!-- State Dropdown -->
                <label for="state">State:</label>
                <select id="state" name="state" required>
                    <option value="<?php echo $state; ?>"> <?php echo ucfirst($state); ?></option>
                    <?php
                    $allstates = ["tamilnadu", "kerala", "california", "texas", "ontario", "new_south_wales"];
                    foreach($allstates as $s){
                        if($s != $state){
                            echo "<option value='$s'>$s</option>";
                        }
                    }
                    ?>
                </select>
                <br><br>

                <!-- District Dropdown -->
                <label for="district">District:</label>
                <select id="district" name="district" required>
                    <option value="" disabled selected>Select District</option>
                </select>
                <br><br>

                <!-- Pincode Dropdown -->
                <label for="pincode">Pincode:</label>
                <select id="pincode" name="pincode" required>
                    <option value="" disabled selected>Select Pincode</option>
                </select>
                <br><br>

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