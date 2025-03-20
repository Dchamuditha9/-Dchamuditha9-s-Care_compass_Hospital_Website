<?php
session_start();
header("Cache-Control: no-store, no cache, must_revalidate, max_age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("pragma: no-cache");
if (!isset($_SESSION["patient_id"])) {
    header("Location: patient_login.php");
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

$patient_id = $_SESSION["patient_id"];

// Fetch Appointments
$appointments_sql = "SELECT * FROM appointments WHERE patient_id = $patient_id ORDER BY a_date DESC";
$appointments = $conn->query($appointments_sql);

// Fetch Medical Reports
$reports_sql = "SELECT * FROM medical_reports WHERE patient_id = $patient_id ORDER BY report_date DESC";
$reports = $conn->query($reports_sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient Dashboard</title>
    <link rel="stylesheet" href="patient_dashboard.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <header>
        <h2><strong>Welcome to Carecompass Hospital Services</h2>
        <a href="logout.php">Logout</a>
    </header>

    <section class="appointments">
        <h3>Your Appointments</h3>
        <table>
            <tr>
                <th>Doctor</th>
                <th>Specialization</th>
                <th>Date</th>
                <th>Status</th>
            </tr>
            <?php while ($row = $appointments->fetch_assoc()): ?>
                <tr>
                    <td><?= $row["doctor_id"] ?></td>
                    <td><?= $row["specialization"] ?></td>
                    <td><?= $row["a_date"] ?></td>
                    <td><?= $row["status"] ?></td>
                </tr>
            <?php endwhile; ?>
        </table>
    </section>

    <section class="book-appointment">
        <h3>Book a New Appointment</h3>
        <form action="book_appointment.php" method="POST">
            <label for="branch">Hospital Branch:</label>
            <select name="branch" id="branch" required>
                <option value="">Select Branch</option>
                <option value="Colombo">Colombo</option>
                <option value="Kandy">Kandy</option>
                <option value="Kurunegala">Kurunegala</option>
            </select>

            <label for="specialization">Specialization:</label>
            <select name="specialization" id="specialization" required>
                <option value="">Select Specialization</option>
                <option value="Cardiologist">Cardiologist</option>
                <option value="Gynecologist">Gynecologist</option>
                <option value="Physician">Physician</option>
                <option value="Pediatrician">Pediatrician</option>
            </select>

            <label>Doctor:</label>
            <select name="doctor" id="doctor" required>
                <option value="">Select Doctor</option>
            </select>

            <label>Date:</label>
            <input type="date" name="a_date" required>
            <button type="submit">Book</button>
        </form>
    </section>

    <script>
        $(document).ready(function(){
            $('#specialization, #branch').change(function(){
                var specialization = $('#specialization').val();
                var branch = $('#branch').val();
                if(specialization && branch){
                    $.ajax({
                        url: 'fetch_doctors.php',
                        type: 'POST',
                        data: {specialization: specialization, branch: branch},
                        success: function(response){
                            $('#doctor').html(response);
                        }
                    });
                }
            });
        });
    </script>

    <section class="reports">
        <h3>Medical Reports</h3>
        <form action="upload_report.php" method="POST" enctype="multipart/form-data">
            <label>Report Name:</label>
            <input type="text" name="report_name" required>
            <label>Upload Report (Image):</label>
            <input type="file" name="report_image" accept="image/*" required>
            <button type="submit">Upload</button>
        </form>
        
        <h4>Your Reports</h4>
        <?php while ($report = $reports->fetch_assoc()): ?>
            <div>
                <p><?= $report["report_name"] ?> - <?= $report["upload_date"] ?></p>
                <img src="<?= $report["report_image"] ?>" width="100">
            </div>
        <?php endwhile; ?>
    </section>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
$(document).ready(function() {
    $('#specialization, #branch').change(function() {
        var specialization = $('#specialization').val();
        var branch = $('#branch').val();

        if (specialization && branch) {
            $.ajax({
                url: 'fetch_doctors.php',
                type: 'POST',
                dataType: 'json', // expecting JSON response
                data: { specialization: specialization, branch: branch },
                success: function(response) {
                    var options = '<option value="">Select Doctor</option>';
                    $.each(response, function(index, doctor) {
                        options += '<option value="' + doctor.doctor_id + '">' + doctor.doctor_name + '</option>';
                    });
                    $('#doctor').html(options);
                },
                error: function(xhr, status, error) {
                    console.error('AJAX Error: ' + status + ' - ' + error);
                }
            });
        } else {
            $('#doctor').html('<option value="">Select Doctor</option>');
        }
    });
});
</script>


</body>
</html>

<?php $conn->close(); ?>