 <?php
 ini_set('session.cookie_lifetime', 0);
session_start(); //MOVED FROM LINE 12

$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "finalproject";
$port = 8889;

$conn = new mysqli($servername, $username, $password, $dbname, $port);
//$odo = new PDO($dsn,$user,$psw) ---> Another option in case mysqli doesn't work out.

 
//_POST CHANGED TO SESSION ON LINE 14.
if (!isset($_SESSION["username"])) {
  header("Location: registration_form.php");
  exit(); // Make sure to exit after a header redirect
}

$username = $_SESSION["username"];
echo "<h1 style='color: blue; font-size: 20px; font-weight: bold;'>Welcome, " . htmlspecialchars($username) . " to Andy's Home Page!</h1>";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
     $username = $_SESSION["username"];
    $newPassword = password_hash($_POST["NewPassword"], PASSWORD_BCRYPT);
    
   $sql = "UPDATE registration SET password = '$newPassword' WHERE username = '$username'"; 
   
        if ($conn->query($sql) === TRUE) {
          echo "Password Updated!"; 
          //  header("Location: home.php");
            // exit();
          } else {
              $errorMsg = "Error: " . $sql . "<br>" . $conn->error;
          }
    }
    
  $conn->close();
?> 
  
    




  <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="homeStyle.css">
</head>
<head>
<title>Welcome, <?php echo isset($_SESSION['username']) ? htmlspecialchars($_SESSION['username']) : 'Guest'; ?></title>
<style>
 .logout-button {
            position: fixed;
            bottom: 10px;
            right: 10px;
            text-decoration: none;
            padding: 10px;
            background-color: #3498db;
            color: #fff;
            border-radius: 5px;
        }
</style>

</head>
<body>
    <div class="screen">
        <div class="login-box">
            <div class="login-content">
                <img src ="doggy.png" alt="Logo" class="logo">
                <form action="home.php" method="post" autocomplete="off">
                    <div>
                        <p class="mb-1">New Password</p>
                        <input type="password" name="NewPassword" required>
                    </div>
                    
                    <div class="text-center my-4">
                        <button class="submit" type="submit" >Update Password</button>
                        <a href="login_form.php" class="logout-button">Logout</a>
                    </div>
                    <p class = "mb-1"> Different Branches of Army</p>
                    <button onclick="showDetails('Army')">Army</button>
                    <button onclick="showDetails('Navy')">Navy</button>
                    <button onclick="showDetails('AirForce')">Air Force</button>
    <div id="detailsContainer"></div>
<script>
    function showDetails(branch) {
        var detailsContainer = document.getElementById('detailsContainer');
        var details = '';

        switch (branch) {
            case 'Army':
                details = `
                    <strong>Branch:</strong> Army<br>
                    <strong>Details:</strong> The Army is the land-based military service branch.<br>
                    <strong>Units:</strong> Infantry, Armored, etc.
                `;
                break;
            case 'Navy':
                details = `
                    <strong>Branch:</strong> Navy<br>
                    <strong>Details:</strong> The Navy is the maritime service branch.<br>
                    <strong>Units:</strong> Surface, Submarine, Aviation, etc.
                `;
                break;
            case 'AirForce':
                details = `
                    <strong>Branch:</strong> Air Force<br>
                    <strong>Details:</strong> The Air Force is the aerial and space service branch.<br>
                    <strong>Units:</strong> Fighter Squadrons, Bomber Groups, etc.
                `;
                break;
            default:
                details = `<strong>Branch not found.</strong>`;
        }

        detailsContainer.innerHTML = details;
    }
</script>
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