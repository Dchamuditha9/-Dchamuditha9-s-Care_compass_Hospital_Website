<?php
// 1️⃣ Connect to Database
$servername = "localhost";
$username = "root";
$password = "";
$database = "carecompass_hospitals";

$conn = new mysqli($servername, $username, $password, $database);

// Check Connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// 2️⃣ Handle Form Submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $full_name = trim(htmlspecialchars($_POST["full_name"]));
    $email = filter_var($_POST["email"], FILTER_SANITIZE_EMAIL);
    $password = password_hash($_POST["password"], PASSWORD_BCRYPT); // Hash Password
    $age = filter_var($_POST["age"], FILTER_SANITIZE_NUMBER_INT);
    $phone = filter_var($_POST["phone"], FILTER_SANITIZE_STRING);

    //validate Inputs
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<script>alert('Invalid email format!'); window.location.href='patient_register.php';</script>";
        exit(); // Optionally stop further execution
    }

    // Check if email already exists
    $check_email = $conn->query("SELECT * FROM patients WHERE email='$email'");
    if ($check_email->num_rows > 0) {
        echo "<script>alert('Email already exists! Try another.'); window.location.href='patient_register.php';</script>";
    } else {
        // Insert into Database
        $sql = "INSERT INTO patients (full_name, email, password, age, phone) 
                VALUES ('$full_name', '$email', '$password', '$age', '$phone')";

        if ($conn->query($sql) === TRUE) {
            echo "<script>alert('Registration successful!'); window.location.href='patient_login.html';</script>";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}

// Close Connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient Registration - Care Compass Hospitals</title>
    <link rel="stylesheet" href="patient_register.css"> <!-- Link to external CSS -->
</head>
<body>

    <header>
        <img src="images and media/logo image.png" alt="logo">
        <div class="slogan">Restoring Health, Rebuilding Lives</div>
        <nav>
            <ul>
                <li><a href="home page.html">Home</a></li>
            </ul>
        </nav>
    </header>

    <!-- Registration Form -->
    <div class="register-container">
        <h2>Patient Registration</h2>
        <form action="patient_register.php" method="POST">
            <label for="full_name">Full Name:</label>
            <input type="text" id="full_name" name="full_name" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>

            <label for="age">Age:</label>
            <input type="number" id="age" name="age" required>

            <label for="phone">Phone:</label>
            <input type="text" id="phone" name="phone" required>

            <button type="submit">Register</button>
        </form>
        <p>Already have an account? <a href="patient_login.html">Login here</a></p>
    </div>

    <footer>
        <p>&copy; 2025 Care Compass Hospitals. All rights reserved.</p>
    </footer>

</body>
</html>
