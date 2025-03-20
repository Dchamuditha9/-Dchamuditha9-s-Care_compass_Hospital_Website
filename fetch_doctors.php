<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "carecompass_hospitals";

$conn = new mysqli($servername, $username, $password, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST['branch']) && isset($_POST['specialization'])) {
    $branch = $_POST['branch'];
    $specialization = $_POST['specialization'];

    $query = "SELECT doctor_id, doctor_name FROM doctors WHERE branch = ? AND specialization = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ss", $branch, $specialization);
    $stmt->execute();
    $result = $stmt->get_result();

    $doctors = [];
    while ($row = $result->fetch_assoc()) {
        $doctors[] = $row;
    }
    
    echo json_encode($doctors);
}

$conn->close();
?>
