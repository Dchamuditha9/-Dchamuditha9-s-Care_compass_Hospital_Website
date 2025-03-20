<?php
session_start();
if (!isset($_SESSION["admin_id"])) {
    header("Location: admin_login.php");
    exit();
}
header("Cache-Control: no-store, no cache, must_revalidate, max_age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("pragma: no-cache");

// Remove duplicate session check by not including admin_login_process.php here if it's only needed for login.
// include('admin_login_process.php'); 

$servername = "localhost";
$username = "root";
$password = "";
$database = "carecompass_hospitals";

// Connect to database
$conn = new mysqli($servername, $username, $password, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch data from database
$appointments = mysqli_query($conn, "SELECT * FROM appointments");
$appointments_opd = mysqli_query($conn, "SELECT * FROM appointments_opd");
$doctors = mysqli_query($conn, "SELECT * FROM doctors");
$patients = mysqli_query($conn, "SELECT * FROM patients"); // Note: Adjust table name if necessary.
$medical_reports = mysqli_query($conn, "SELECT * FROM medical_reports");

// Handle doctor addition
if (isset($_POST['add_doctor'])) {
    $name = $_POST['name'];
    $specialty = $_POST['speciality'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $sql = "INSERT INTO doctors (doctor_name, specialization, email, phone) VALUES ('$name', '$speciality', '$email', '$phone')";
    mysqli_query($conn, $sql);
    header('Location: admin_dashboard.php');
    exit();
}

// Handle doctor deletion
if (isset($_POST['delete_doctor'])) {
    $doctor_id = $_POST['doctor_id'];
    mysqli_query($conn, "DELETE FROM doctors WHERE doctor_id = $doctor_id");
    header('Location: admin_dashboard.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="admin_dashboard.css"> <!-- Include your CSS file -->
</head>
<body>
<header>
    <h2>Admin Dashboard</h2>
    <a href="logout.php">Logout</a>
</header>

<section>
    <h3>Manage Doctors</h3>
    <table>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Specialty</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Action</th>
        </tr>
        <?php while ($row = mysqli_fetch_assoc($doctors)) { ?>
            <tr>
                <!-- Adjust field names to match your database -->
                <td><?php echo isset($row['doctor_id']) ? $row['doctor_id'] : $row['id']; ?></td>
                <td><?php echo isset($row['doctor_name']) ? $row['doctor_name'] : $row['name']; ?></td>
                <td><?php echo isset($row['specialization']) ? $row['specialization'] : $row['specialty']; ?></td>
                <td><?php echo $row['email']; ?></td>
                <td><?php echo $row['phone']; ?></td>
                <td>
                    <form method="POST">
                        <input type="hidden" name="doctor_id" value="<?php echo isset($row['doctor_id']) ? $row['doctor_id'] : $row['id']; ?>">
                        <button type="submit" name="delete_doctor">Remove</button>
                    </form>
                </td>
            </tr>
        <?php } ?>
    </table>
    <h3>Add Doctor</h3>
    <form method="POST">
        <input type="text" name="name" placeholder="Doctor Name" required>
        <input type="text" name="specialty" placeholder="Specialty" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="text" name="phone" placeholder="Phone Number" required>
        <button type="submit" name="add_doctor">Add Doctor</button>
    </form>
</section>

<section>
    <h3>Appointments</h3>
    <table>
        <tr>
            <th>ID</th>
            <th>Patient</th>
            <th>Doctor</th>
            <th>Date</th>
            <th>Status</th>
        </tr>
        <?php while ($row = mysqli_fetch_assoc($appointments)) { ?>
            <tr>
                <!-- Adjust the keys below as per your appointments table structure -->
                <td><?php echo $row['doctor_id']; ?></td>
                <td><?php echo $row['patient_id']; ?></td>
                <td><?php echo $row['doctor_id']; ?></td>
                <td><?php echo $row['a_date']; ?></td>
                <td><?php echo $row['status']; ?></td>
            </tr>
        <?php } ?>
    </table>
</section>

<!-- New Section: Patient Details -->
<section>
    <h3>Patient Details</h3>
    <table>
        <tr>
            <th>Patient ID</th>
            <th>Full Name</th>
            <th>Email</th>
            <th>Age</th>
            <th>Phone</th>
            <th>Created At</th>
        </tr>
        <?php while ($row = mysqli_fetch_assoc($patients)) { ?>
            <tr>
                <td><?php echo $row['patient_id']; ?></td>
                <td><?php echo $row['full_name']; ?></td>
                <td><?php echo $row['email']; ?></td>
                <td><?php echo $row['age']; ?></td>
                <td><?php echo $row['phone']; ?></td>
                <td><?php echo $row['created_at']; ?></td>
            </tr>
        <?php } ?>
    </table>
</section>

<!-- New Section: Appointment OPD Details -->
<section>
    <h3>Appointment OPD Details</h3>
    <table>
        <tr>
            <th>Appointment ID</th>
            <th>Full Name</th>
            <th>Age</th>
            <th>Branch</th>
            <th>Appointment Time</th>
            <th>Date</th>
        </tr>
        <?php while ($row = mysqli_fetch_assoc($appointments_opd)) { ?>
            <tr>
                <td><?php echo $row['appointment_id']; ?></td>
                <td><?php echo $row['full_name']; ?></td>
                <td><?php echo $row['age']; ?></td>
                <td><?php echo $row['branch']; ?></td>
                <td><?php echo $row['appointment_time']; ?></td>
                <td><?php echo $row['date']; ?></td>
            </tr>
        <?php } ?>
    </table>
</section>
</body>
</html>
