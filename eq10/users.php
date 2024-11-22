<?php
require "./config.php";

function getClient($clientMail)
{
    global $server, $username, $password, $dbname;

    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        $conn = new mysqli($server, $username, $password, $dbname);
        if ($conn->connect_error) {
            return json_encode(["error" => "Cannot connect to database. " . $conn->connect_error]);
        }

        $stmt = $conn->prepare("SELECT id FROM cliente WHERE correo = ?");
        $stmt->bind_param("s", $clientMail);
        $stmt->execute();
        $result = $stmt->get_result();
        $client = $result->fetch_assoc();

        $conn->close();

        return json_encode($client);
    }

    return json_encode(["error" => "Incorrect Request"]);
}

define("client_email", $_GET["email"]);

echo getClient(client_email);