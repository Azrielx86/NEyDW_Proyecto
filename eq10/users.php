<?php
require "./config.php";

function getClient($email, $password)
{
    global $server, $username, $password, $dbname;

    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        $conn = new mysqli($server, $username, $password, $dbname);
        if ($conn->connect_error) {
            return json_encode(["error" => "Cannot connect to database. " . $conn->connect_error]);
        }

        $hashed = hash('sha256', $password);

        $stmt = $conn->prepare("SELECT id FROM cliente WHERE correo = ? AND password = ?");
        $stmt->bind_param("ss", $email, $hashed);
        $stmt->execute();
        $result = $stmt->get_result();
        $client = $result->fetch_assoc();

        $conn->close();

        return json_encode($client);
    }

    return json_encode(["error" => "Incorrect Request"]);
}

define("client_email", $_GET["email"]);
define("client_password", $_GET["pwd"]);

echo getClient(client_email, client_password);