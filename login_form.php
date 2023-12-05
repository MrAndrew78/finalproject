<?php

 $servername = "localhost";
 $username = "root";
 $password = "root";
 $dbname = "finalproject";
 $port = 8889;

$conn = new mysqli($servername, $username, $password, $dbname, $port);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
//echo $username; 
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Retrieve user input from the form
    $loginUSER = $_POST["username"];
    //$password = $_POST["password"];
    $loginPassword = $_POST["password"];
    // Validate the login credentials
    $sql = "SELECT * FROM registration WHERE username = '$loginUSER'";
    $result = $conn->query($sql);
    
     
    if ($result->num_rows > 0) {
       
        // User is registered, check password
        $row = $result->fetch_assoc();
        $hashedPassword = $row["password"];
         
        if (password_verify($loginPassword, $hashedPassword)) {
            // Password is correct, set a session variable and redirect
            ini_set('session.cookie_lifetime', 0);
            session_start();
            $_POST['username'] = $loginUSER;
            $_SESSION['username'] = $loginUSER;
            $_SESSION['user_id'] = $row['id']; // Set the user_id in the session
           header("Location: home.php");
           
            //exit();    
            //UNDO IF NOT FIXED...12/4/2023 8:27pm
        } else {
            // Password is incorrect, display error message
           // header("Location: registration_form.php");
            $errorMsg = "Invalid password. Please try again.";
        }
    }
     else {
        // User is not registered, display error message
        $errorMsg = "Invalid username. Please try again or register.";
    }
    //Check -> password_verify. Check -> Procedure for comparing hashedpassword with input-psw
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="stylesheet.css">
</head>
<body>
    <div class="screen">
        <div class="login-box">
            <div class="login-content">
                <p class="welcome-text">Welcome Class</p>
                <form method="post" autocomplete="off">
                    <div>
                        <p class="mb-1">Username</p>
                        <input type="text" name="username" autocomplete="new-password">
                    </div>
                    <div>
                        <p class="mb-1">Password</p>
                        <input type="password" name="password" autocomplete="new-password">
                    </div>
                    <div class="text-center my-4">
                        <a class="register" href="registration_form.php">Not registered?</a>
                    </div>
                    <div class="text-center my-4">
                        <button class="button" type="submit" href="registration_form.php">OK</button>
                    </div>

                    <?php
                    // Display the error message if it is set
                    if (isset($errorMsg)) {
                        echo '<p class="error-message">' . $errorMsg . '</p>';
                    }
                    ?>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
