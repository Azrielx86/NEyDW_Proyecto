<?php
include "config.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    global $server, $username, $password, $dbname;

    $conn = new mysqli($server, $username, $password, $dbname);
    if ($conn->connect_error) {
        return json_encode(["error" => "Cannot connect to database. " . $conn->connect_error]);
    }

    $stmt = $conn->prepare("INSERT INTO contacto(nombre, email, mensaje) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $_POST["name"], $_POST["email"], $_POST["message"]);
    $stmt->execute();
    $inserted_id = $stmt->insert_id;
    $conn->close();

    header("Location: index.php");
    die();
}

echo json_encode(["Error" => "Invalid request!"]);