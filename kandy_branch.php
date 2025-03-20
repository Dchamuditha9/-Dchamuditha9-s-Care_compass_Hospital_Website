<?php
// Database connection parameters
$servername = "localhost";
$username = "root";
$password = "";
$database = "carecompass_hospitals";

// Create a new database connection
$conn = new mysqli($servername, $username, $password, $database);

// Check for connection errors
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// SQL query to fetch available doctors
$branch = "Kandy"; // Changed branch to Kandy
$sql = "SELECT doctor_name, specialization, available_time FROM doctors WHERE branch = ?";
$stmt = $conn->prepare($sql); // Prepare the SQL query
$stmt->bind_param("s", $branch); // Bind the parameter
$stmt->execute(); // Execute the query
$result = $stmt->get_result(); // Get the result set
$stmt->close(); // Close the prepared statement

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctor Details - Kandy Branch - CareCompass Hospitals</title>
    <link rel="stylesheet" href="kandy_branch.css">
</head>
<body>

<header>
    <img src="images and media\logo image.png" alt="CareCompass Hospitals Logo">
    <div class="slogan">Your Health, Our Priority</div>
</header>

<section class="doctor-details">
    <h2>Available Doctors</h2>
    <?php if ($result->num_rows > 0): ?>
        <table>
            <tr>
                <th>Doctor Name</th>
                <th>Specialization</th>
                <th>Available Time</th>
            </tr>
            <?php while($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($row["doctor_name"]) ?></td>
                    <td><?= htmlspecialchars($row["specialization"]) ?></td>
                    <td><?= htmlspecialchars($row["available_time"]) ?></td>
                </tr>
            <?php endwhile; ?>
        </table>
    <?php else: ?>
        <p>No doctors are available at the moment.</p>
    <?php endif; ?>
</section>

<section class="location">
    <h2>Our Location</h2>
    <div id="map"></div>
</section>

<footer>
    <p>Contact Us</p>
    <p>Email: info@carecompasshospitals.com</p>
    <p>Phone: +94 123 456 789</p>
</footer>

<script>
    function initMap() {
        var hospitalLocation = { lat: 7.2906, lng: 80.6337 }; // Kandy coordinates
        var map = new google.maps.Map(document.getElementById('map'), {
            zoom: 15,
            center: hospitalLocation
        });
        var marker = new google.maps.Marker({
            position: hospitalLocation,
            map: map
        });
    }
</script>
<script async defer src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&callback=initMap"></script>

</body>
</html>
<?php
// Close the database connection
$conn->close();
?>
