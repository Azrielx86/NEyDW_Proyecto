<?php
require "./config.php";

function getProduct($productId) {
    global $server, $username, $password, $dbname;

    $conn = new mysqli($server, $username, $password, $dbname);
    if ($conn->connect_error) {
        return json_encode(["error" => "Cannot connect to database. " . $conn->connect_error]);
    }

    $stmt = $conn->prepare("SELECT p.id, p.nombre, p.precio, p.descripcion, p.img_path FROM producto p WHERE p.id = ?");
    $stmt->bind_param("i", $productId);
    $stmt->execute();
    $result = $stmt->get_result();
    $product = $result->fetch_assoc();

    $conn->close();

    return json_encode($product);
}

define("product_id", $_GET["id"]);

echo getProduct(product_id);