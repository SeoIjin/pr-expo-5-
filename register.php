<?php
session_start();

$host = "localhost";
$user = "root";
$password = "";
$db = "account";

// Create a connection to the database
$conn = mysqli_connect($host, $user, $password, $db);
if ($conn === false) {
    die("Connection error");
}

$notification = ""; // Initialize an empty notification

if (isset($_POST["submit"])) {
    // Accessing 'email' instead of 'username'
    $email = $_POST["email"];
    $password = $_POST["password"];
    $confirm_password = $_POST["confirm_password"];

    $errors = array();

    // Validate fields
    if (empty($email)) {
        $errors[] = "Email is required.";
    }
    if (empty($password)) {
        $errors[] = "Password is required.";
    }
    if ($password !== $confirm_password) {
        $errors[] = "Passwords do not match.";
    }
    // Check if email already exists
    $sql = "SELECT * FROM useraccount WHERE email = ?"; // Correct table
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    if (mysqli_num_rows($result) > 0) {
        $errors[] = "This email is already registered.";
    }
    // If no errors, proceed with registration
    if (count($errors) == 0) {
        $passwordHash = password_hash($password, PASSWORD_DEFAULT); // Hash the password
        // Prepare and execute the SQL insert statement
        $sql = "INSERT INTO useraccount (email, password) VALUES (?, ?)"; // Correct table
        $stmt = mysqli_stmt_init($conn);
        if (mysqli_stmt_prepare($stmt, $sql)) {
            // Bind parameters (email, hashed password)
            mysqli_stmt_bind_param($stmt, "ss", $email, $passwordHash);
            if (mysqli_stmt_execute($stmt)) {
                $notification = "<div class='alert alert-success'>You have successfully registered! You can now <a href='login.php'>login</a>.</div>";
            } else {
                $notification = "<div class='alert alert-danger'>Something went wrong. Please try again later.</div>";
            }
        } else {
            $notification = "<div class='alert alert-danger'>Failed to prepare SQL statement.</div>";
        }
        // Close the prepared statement
        mysqli_stmt_close($stmt);
    } else {
        // Display errors
        $error_messages = "";
        foreach ($errors as $error) {
            $error_messages .= "<div class='alert alert-danger'>{$error}</div>";
        }
        $notification = $error_messages;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create an Account</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="CSS/style.css">
    <script src="JS/function.js"></script>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-color: #f0f0f0;
        }
        h4 {
            margin-bottom: 10px;
            color: #333;
            font-family:'Trebuchet MS', 'Lucida Sans Unicode', 'Lucida Grande', 'Lucida Sans', Arial, sans-serif;
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
        input[type="email"],
        input[type="password"] {
            width: 200px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 10px;
            font-size: 16px;
        }
        input[type="email"]:focus,
        input[type="password"]:focus {
            border-color:#007bff;
            outline: none;
        }
        .container {
            margin-left: 165px;
            transition: transform 0.5s, box-shadow 0.3s;
        }
        .login-form {
            background-color: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        .login {
            margin-bottom: 15px;
        }
        .login button[type="submit"] {
            background-color: green;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }
        .login button[type="submit"]:hover {
            background-color: darkgreen;
        }
        .alert {
            padding: 10px;
            margin-bottom: 10px;
            border-radius: 5px;
            text-align: left;
        }
        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
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

    <form action="register.php" method="POST">
        <div class="login-form">
            <?php echo $notification; // Display the notification here, inside the border ?>
            <div class="login">
                <h4>Create an Account</h4>
                <input type="email" name="email" placeholder="Email" required>
            </div>
            <div class="login">
                <input type="password" name="password" placeholder="Password" required>
            </div>
            <div class="login">
                <input type="password" name="confirm_password" placeholder="Confirm Password" required>
            </div>
            <div class="login">
                <button type="submit" name="submit">Submit</button>
            </div>
        </div>
    </form>
</body>
</html>
