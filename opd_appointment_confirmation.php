<?php
// 1️⃣ Connect to the MySQL Database
$servername = "localhost";  // XAMPP default
$username = "root";         // XAMPP default user
$password = "";             // Default password (empty)
$database = "carecompass_hospitals";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// 2️⃣ Process Form Data when Form is Submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect form data and sanitize inputs
    $full_name = trim($_POST["name"]);
    $age = trim($_POST["age"]);
    $branch = trim($_POST["branch"]);
    $appointment_time = trim($_POST["time"]);
    $date = trim($_POST["date"]);

    // Check for empty fields
    if (empty($full_name) || empty($age) || empty($branch) || empty($appointment_time) || empty($date)) {
        die("Error: All fields are required.");
    }

    // Use a prepared statement to insert data safely
    $sql = "INSERT INTO appointments_opd (full_name, age, branch, appointment_time, date) 
            VALUES (?, ?, ?, ?, ?)";
    
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        die("Error preparing statement: " . $conn->error);
    }

    // Bind parameters (s = string, i = integer)
    $stmt->bind_param("sisss", $full_name, $age, $branch, $appointment_time, $date);

    // Execute the query
    if ($stmt->execute()) {
        echo "<script>alert('Appointment booked successfully!'); window.location.href ='appointment_confirmed.php';</script>";
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the statement and connection
    $stmt->close();
}

// Close database connection
$conn->close();
?>
