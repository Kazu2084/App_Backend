<?php
$host = "localhost";
$username = "root";
$password = "";
$database = "fyp";

// Establish connection
$con = mysqli_connect($host, $username, $password, $database);

if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

// Fetch username from the request
$username = $_GET['username'];

// Query to select fee details for the user with the given username
$query = "SELECT fee_voucher, student_fee.roll_no, first_name, middle_name, last_name, course_code, amount, DATE(posting_date) AS posting_date, status 
          FROM student_fee 
          INNER JOIN student_info ON student_fee.roll_no = student_info.roll_no 
          WHERE student_info.email = '$username'";

$result = mysqli_query($con, $query);

if (!$result) {
    die("Query failed: " . mysqli_error($con));
}

$feesData = array();

while ($row = mysqli_fetch_assoc($result)) {
    $feesData[] = $row;
}

// Set response header and send JSON encoded data
header('Content-Type: application/json');
echo json_encode($feesData);

// Close connection
mysqli_close($con);
?>
