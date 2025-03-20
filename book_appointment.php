<?php
session_start();

// Check if patient is logged in
if (!isset($_SESSION["patient_id"])) {
    header("Location: patient_login.php");
    exit();
}

// Database credentials
$servername = "localhost";
$username = "root";
$password = "";
$database = "carecompass_hospitals";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Process form data if submitted via POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve and sanitize inputs
    $branch         = trim($_POST["branch"]);
    $specialization = trim($_POST["specialization"]);
    $doctor         = trim($_POST["doctor"]); // This should be the doctor id
    $a_date         = trim($_POST["a_date"]);
    
    // Get patient ID from session
    $patient_id = $_SESSION["patient_id"];

    // Insert the appointment into the database
    $sql = "INSERT INTO appointments (patient_id, branch, specialization, doctor_id, a_date, status)
            VALUES (?, ?, ?, ?, ?, ?)";
    
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        die("Preparation failed: " . $conn->error);
    }
    
    // Assume status is 'pending'
    $status = 'pending';
    
    // Cast $doctor as integer if necessary
    $doctor_id = (int)$doctor;
    
    // Bind parameters: i (patient_id), s (branch), s (specialization), i (doctor_id), s (a_date), s (status)
    $stmt->bind_param("isssis", $patient_id, $branch, $specialization, $doctor_id, $a_date, $status);

    if ($stmt->execute()) {
        // On success, redirect to the confirmation page
        header("Location: appoinment confirmed.php");
        exit();
    } else {
        echo "Error booking appointment: " . $stmt->error;
    }
    
    $stmt->close();
}

$conn->close();
?>
