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
$roll_no = "aakash@gmail.com";
$results = array();

$query="select * from class_result cr inner join course_subjects cs on cr.subject_code=cs.subject_code inner join student_info si on si.course_code=cs.course_code where si.roll_no='215037' and cr.roll_no=si.roll_no";
$run = mysqli_query($con, $query);
while ($row = mysqli_fetch_assoc($run)) {
    $result = array(
        'courseCode' => $row['course_code'],
        'semester' => $row['semester'],
        'subjectCode' => $row['subject_code'],
        'creditHours' => $row['credit_hours'],
        'totalMarks' => $row['total_marks'],
        'obtainMarks' => $row['obtain_marks'],
        'grade' => calculateGrade($row['obtain_marks']),
        'cgpa' => calculateCGPA($row['credit_hours'], $row['obtain_marks'])
    );
    $results[] = $result;
}

echo json_encode(['results' => $results]);

function calculateGrade($obtainMarks) {
    if ($obtainMarks > 85) {
        return 'A+';
    } elseif ($obtainMarks > 80) {
        return 'A';
    } elseif ($obtainMarks > 75) {
        return 'B+';
    } elseif ($obtainMarks > 70) {
        return 'B';
    } elseif ($obtainMarks > 65) {
        return 'C+';
    } elseif ($obtainMarks > 60) {
        return 'C';
    } elseif ($obtainMarks > 55) {
        return 'D+';
    } elseif ($obtainMarks > 50) {
        return 'D';
    } else {
        return 'F';
    }
}

function calculateCGPA($creditHours, $obtainMarks) {
    $gradePoints = 0;
    if ($obtainMarks > 85) {
        $gradePoints = 4.0;
    } elseif ($obtainMarks > 80) {
        $gradePoints = 4.0;
    } elseif ($obtainMarks > 75) {
        $gradePoints = 3.7;
    } elseif ($obtainMarks > 70) {
        $gradePoints = 3.3;
    } elseif ($obtainMarks > 65) {
        $gradePoints = 3.0;
    } elseif ($obtainMarks > 60) {
        $gradePoints = 2.7;
    } elseif ($obtainMarks > 55) {
        $gradePoints = 2.5;
    } elseif ($obtainMarks > 50) {
        $gradePoints = 2.0;
    } else {
        $gradePoints = 0.0;
    }

    return round($gradePoints * $creditHours, 2);
}
?>
