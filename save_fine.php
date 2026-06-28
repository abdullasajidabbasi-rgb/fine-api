<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, User-Agent, Accept");
header("Content-Type: application/json");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

$host = "sql111.byethost22.com";
$dbname = "b22_42291552__fines";
$username = "b22_42291552";
$password = "UfjQ9_R8L!qFfdy";

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    echo json_encode(["status" => "error", "message" => $conn->connect_error]);
    exit();
}

$data = json_decode(file_get_contents("php://input"), true);

if (!$data) {
    echo json_encode(["status" => "error", "message" => "No data received"]);
    exit();
}

$name     = $conn->real_escape_string($data['name']);
$regNo    = $conn->real_escape_string($data['regNo']);
$fineType = $conn->real_escape_string($data['fineType']);
$amount   = $conn->real_escape_string($data['amount']);
$comments = $conn->real_escape_string($data['comments']);
$dateTime = $conn->real_escape_string($data['dateTime']);

$sql = "INSERT INTO fines 
        (student_name, reg_no, fine_type, amount, comments, date_time) 
        VALUES 
        ('$name','$regNo','$fineType','$amount','$comments','$dateTime')";

if ($conn->query($sql)) {
    echo json_encode(["status" => "success"]);
} else {
    echo json_encode(["status" => "error", "message" => $conn->error]);
}

$conn->close();
?>