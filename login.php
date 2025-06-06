<?php
session_start(); // Start the session to manage user state

$host = "localhost";
$user = "root";
$password = "";
$db = "account";

// Create a connection to the database
$data = mysqli_connect($host, $user, $password, $db);
if ($data === false) {
    die("Connection error");
}

$login_success = false;
$redirect_url = '';
$login_error = ''; // Variable to hold login error message

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $password = $_POST["password"];
    // First, check if the email exists in the database
    $sql = "SELECT * FROM useraccount WHERE email = ?";
    $stmt = mysqli_prepare($data, $sql);
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_array($result);
    // If no user found with the given email
    if (!$row) {
        $login_error = "Email is not valid";   // Email doesn't exist
    } else {
        // If user is found, check if the password matches the hash
        if (password_verify($password, $row['password'])) {
            // Store user data in session variables
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['email'] = $row['email'];   // Assuming you have an 'email' field
            $_SESSION['usertype'] = $row['usertype'];
            // Check user type and set redirect URL
            if ($row["usertype"] == "") {
                $login_success = true;
                $redirect_url = "profile.php";   // Redirect to profile page for regular users
            } elseif ($row["usertype"] == "admin") {
                $login_success = true;
                $redirect_url = "adminprofile.php";   // Redirect to dashboard for admins
            }
        } else {
            // Password doesn't match
            $login_error = "Password is incorrect";
        }
    }
    // Redirect if login is successful
    if ($login_success) {
        header("Location: " . $redirect_url);   // Redirect to the correct page
        exit();   // Always call exit after header to stop further script execution
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <title>Login your Account</title>
    <link rel="stylesheet" href="CSS/style.css">
    <script src="JS/function.js"></script>
    <style>
    body {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        margin: 0;
        background-color: #f0f0f0;
        font-family: 'Poppins', sans-serif;
    }
    h4 {
        margin-bottom: 10px;
        color: #333;
        font-size: 30px;
    }
    /* Navbar styling */
    nav {
        position: fixed;
        top: 0;
        width: 100%;
        background-color: white;
        border-bottom: 0px solid #444;
        border-radius: 5px;
        z-index: 1000;
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 10px 30px;
        box-shadow: 0px 2px 10px #888888;
    }
    nav li a {
        margin-left: 40px;
    }
    nav li a:hover {
        color: #ff6347;
    }
    .error {
        color: red;
        margin-top: 10px;
    }
    input[type="email"],
    input[type="password"] {
        width: 200px;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 10px;
        font-size: 16px;
    }
    input[type="email"]:focus, input[type="password"]:focus {
        border-color: #007bff;
        outline: none;
    }
    .container {
        margin-left: 165px;
        transition: transform 0.5s, box-shadow 0.3s;
    }
    </style>
</head>
<body class="form1">
    <nav>
        <div class="nav-left">

            <li><a style="text-decoration: none;" href="homepage.php">Home</a></li>
            <li><a style="text-decoration: none;" href="aboutus.php">About Us</a></li>
            <li><a style="text-decoration: none;" href="services.php">Our Services</a></li>
            <li><a style="text-decoration: none;" href="booking.php">Book Now</a></li>
            <a href="#" onclick="location.reload()"><img src="IMAGES/logo.jpg" alt="logo" style="height: 40px;"></a>
        </div>
        <div class="container">
        <?php if (!isset($_SESSION['user_id'])): ?> <button class="btn" onclick="showLogin()">Login</button>
                <button class="btn" onclick="showRegister()">Register</button>
            <?php else: ?> <span>Welcome, <?php echo htmlspecialchars($_SESSION['email']); ?></span>
                <a href="logout.php">Logout</a> <?php endif; ?>
        </div>
    </nav>
    <form action="#" id="loginForm" method="POST">
        <div class="login-form">
            <div class="login">
                <h4>Login your account</h4>
                <input type="email" name="email" placeholder="Enter your email" required>
            </div>
            <div class="login">
                <input type="password" name="password" placeholder="Enter your password" required>
            </div>
            <div class="login">
                <button type="submit" name="submit">Log In</button>
                <a href="register.php">No Account?</a>
            </div>
            <?php if (isset($login_error) && $login_error != ''): ?>
                <div class="error"><?php echo $login_error; ?></div>
            <?php endif; ?>
        </div>
    </form>
</body>
</html>