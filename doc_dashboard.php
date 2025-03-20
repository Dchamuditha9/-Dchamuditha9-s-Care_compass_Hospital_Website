<?php
session_start();
if (!isset($_SESSION["doctor_id"])) {
    header("Location: doctor_login.php");
    exit();
}

$servername = "localhost";
$username = "root";
$password = "";
$database = "carecompass_hospitals";

$conn = new mysqli($servername, $username, $password, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$doctor_id = $_SESSION["doctor_id"];

// Fetch doctor's schedule (using prepared statement for security)
$schedule_stmt = $conn->prepare("SELECT available_time, branch FROM doctors WHERE doctor_id = ?");
$schedule_stmt->bind_param("i", $doctor_id);
$schedule_stmt->execute();
$schedule = $schedule_stmt->get_result()->fetch_assoc();
$schedule_stmt->close();

// Fetch upcoming appointments (JOIN patients to get patient name and status)
$upcoming_stmt = $conn->prepare("
    SELECT a.a_date, a.allocated_time, a.status, p.full_name
    FROM appointments a
    JOIN patients p ON a.patient_id = p.patient_id
    WHERE a.doctor_id = ? AND a.a_date >= CURDATE()
    ORDER BY a.a_date ASC
");
$upcoming_stmt->bind_param("i", $doctor_id);
$upcoming_stmt->execute();
$upcoming_appointments = $upcoming_stmt->get_result();
$upcoming_stmt->close();

// Fetch past appointment history
$history_stmt = $conn->prepare("
    SELECT a.a_date, p.full_name
    FROM appointments a
    JOIN patients p ON a.patient_id = p.patient_id
    WHERE a.doctor_id = ? AND a.a_date < CURDATE()
    ORDER BY a.a_date DESC
");
$history_stmt->bind_param("i", $doctor_id);
$history_stmt->execute();
$history_appointments = $history_stmt->get_result();
$history_stmt->close();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctor Dashboard</title>
    <link rel="stylesheet" href="doc_dashboard.css">
</head>
<body>

<header>
    <h2>Welcome, Doctor</h2>
    <a href="logout.php">Logout</a>
</header>

<section class="schedule">
    <h3>Your Schedule</h3>
    <p><strong>Available Time:</strong> <?= htmlspecialchars($schedule["available_time"]) ?></p>
    <p><strong>Branch:</strong> <?= htmlspecialchars($schedule["branch"]) ?></p>
</section>

<section class="appointments">
    <h3>Upcoming Appointments</h3>
    <?php if ($upcoming_appointments->num_rows > 0): ?>
    <table>
        <tr>
            <th>Patient Name</th>
            <th>Date</th>
            <th>Time</th>
            <th>Condition</th>
        </tr>
        <?php while ($row = $upcoming_appointments->fetch_assoc()): ?>
            <tr>
                <td><?= htmlspecialchars($row["full_name"]) ?></td>
                <td><?= htmlspecialchars($row["a_date"]) ?></td>
                <td><?= htmlspecialchars($row["allocated_time"]) ?></td>
                <td><?= htmlspecialchars($row["status"]) ?></td> <!-- Status displayed here -->
            </tr>
        <?php endwhile; ?>
    </table>
    <?php else: ?>
        <p>No upcoming appointments.</p>
    <?php endif; ?>
</section>

<section class="history">
    <h3>Appointment History</h3>
    <?php if ($history_appointments->num_rows > 0): ?>
    <table>
        <tr>
            <th>Patient Name</th>
            <th>Date</th>
            <th>Update Status</th>
        </tr>
        <?php while ($row = $history_appointments->fetch_assoc()): ?>
            <tr>
                <td><?= htmlspecialchars($row["full_name"]) ?></td>
                <td><?= htmlspecialchars($row["a_date"]) ?></td>
                <td><form action="update_status.php" method="POST">
                    <input type="text" name="new_status" placeholder="Enter new status" required>
                    <button type="submit">Update</button>
                </form></td>
            </tr>
        <?php endwhile; ?>
    </table>
    <?php else: ?>
        <p>No past appointments found.</p>
    <?php endif; ?>
</section>

</body>
</html>

<?php $conn->close(); ?>
