<?php
// 1️⃣ Start the session to get user details (if needed)
session_start();

// 2️⃣ Connect to the MySQL Database
$servername = "localhost";  
$username = "root";  
$password = "";  
$database = "carecompass_hospitals";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// 3️⃣ Fetch the Latest Appointment
$sql = "SELECT * FROM appointments ORDER BY a_id DESC LIMIT 1";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $appointment = $result->fetch_assoc();
} else {
    die("No appointment found.");
}

// Close connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appointment Receipt - Care Compass Hospitals</title>
    <link rel="stylesheet" href="appoinment confirmed.css"> <!-- Link to existing CSS -->
</head>
<body>

    <!-- Header -->
    <header>
        <img src="images and media/logo image.png" alt="logo"> 
        <div class="slogan">Restoring Health, Rebuilding Lives</div>
        <nav>
            <ul>
                <li><a href="home page.html">Home</a></li>
            </ul>
        </nav>
    </header>

    <!-- Appointment Receipt Section -->
    <div class="receipt-container">
        <h2>Appointment Receipt</h2>
        <p><strong>Appointment ID:</strong> <?php echo $appointment['a_id']; ?></p>
        <p><strong>Patient ID:</strong> <?php echo $appointment['patient_id']; ?></p>
        <p><strong>Branch:</strong> <?php echo $appointment['branch']; ?></p>
        <p><strong>Appointment Time:</strong> <?php echo $appointment['allocated_time']; ?></p>
        <p><strong>Appointment Date;</strong> <?php echo $appointment['a_date']; ?></p>
        <p><strong>Doctor's ID;</storng> </php echo $appointment['doc_id']; ?</p>      
        <button onclick="window.print()">Print Receipt</button>
    </div>4

    <!-- Footer -->
    <footer>
        <p>&copy; 2025 Care Compass Hospitals. All rights reserved.</p>
    </footer>

</body>
</html>
