<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

// Simulated data for demonstration
$data = array(
    "message" => "Hello from PHP backend!",
    "timestamp" => time()
);

echo json_encode($data);
?>
