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
    $sql = "SELECT patient_id, password FROM patients WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($patient_id, $hashed_password);
    $stmt->fetch();

    // Verify password
    if ($stmt->num_rows > 0 && password_verify($password, $hashed_password)) {
        // Set session variables
        $_SESSION["patient_id"] = $patient_id;
        header("Location:patient_dashboard.php");
        exit();
    } else {
        echo "<script>alert('Invalid Email or Password'); window.location.href='patient_login.html';</script>";
    }

    $stmt->close();
}
$conn->close();
?>
