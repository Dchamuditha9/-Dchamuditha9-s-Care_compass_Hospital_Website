<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$database = "carecompass_hospitals";

// Connect to the database
$conn = new mysqli($servername, $username, $password, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form data is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $password = $_POST["password"];

    // Fetch the patient from the database
    $sql = "SELECT admin_id, password FROM admin WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($admin_id, $hashed_password);
    $stmt->fetch();

    // Verify password
    if ($stmt->num_rows > 0 && $password === $hashed_password) { 
        // Set session variables
        $_SESSION["admin_id"] = $admin_id;
        header("Location: admin_dashboard.php");
        exit();
    }
    $stmt->close();
      // --------- 2. CHECK DOCTOR TABLE ----------
    $sql = "SELECT doctor_id, password FROM doctors WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($doctor_id, $doctor_password);
    $stmt->fetch();

    if ($stmt->num_rows > 0 && $password === $doctor_password) { 
        // Set session & redirect to doctor dashboard
        $_SESSION["doctor_id"] = $doctor_id;
        header("Location: doc_dashboard.php");
        exit();
    }

    $stmt->close();

    
        echo "<script>alert('Invalid Email or Password'); window.location.href='doc staff admin login.html';</script>";
    }

    $stmt->close();

$conn->close();
?>
