<?php
require "./config.php";

function getClient($email, $usr, $pwd)
{
    global $server, $username, $password, $dbname;

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $conn = new mysqli($server, $username, $password, $dbname);
        if ($conn->connect_error) {
            return json_encode(["error" => "Cannot connect to database. " . $conn->connect_error]);
        }

        $stmt = $conn->prepare("INSERT INTO cliente(nombre, correo, password) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $usr, $email, $pwd);
        $stmt->execute();
        $inserted_id = $stmt->insert_id;
        $conn->close();
        return json_encode(["id" => $inserted_id]);
    }

    return json_encode(["error" => "Incorrect Request"]);
}

define("client_email", $_POST["email"]);
define("client_username", $_POST["username"]);
define("client_password", $_POST["pwd"]);

echo getClient(client_email, client_username, client_password);