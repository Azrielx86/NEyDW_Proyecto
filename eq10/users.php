<?php
header("Content-Type: application/json; charset=UTF-8");
require "./config.php";

function getClient($email, $pwd)
{
    global $server, $username, $password, $dbname;

    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        $conn = new mysqli($server, $username, $password, $dbname);
        if ($conn->connect_error) {
            return json_encode(["error" => "Cannot connect to database. " . $conn->connect_error]);
        }

        $hashed = hash('sha256', $pwd);

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

function getClientInfo($client_id)
{
    global $server, $username, $password, $dbname;
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        $conn = new mysqli($server, $username, $password, $dbname);
        if ($conn->connect_error) {
            return json_encode(["error" => "Cannot connect to database. " . $conn->connect_error]);
        }

        $stmt = $conn->prepare("SELECT nombre, apellidos, telefono, correo, direccion FROM cliente WHERE id = ?");
        $stmt->bind_param("i", $client_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $client = $result->fetch_assoc();

        $conn->close();

        return json_encode($client);
    }

    return json_encode(["error" => "Incorrect Request"]);
}

function registerUser($email, $usr, $usr_lastname, $pwd)
{
    global $server, $username, $password, $dbname;

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $conn = new mysqli($server, $username, $password, $dbname);
        if ($conn->connect_error) {
            return json_encode(["error" => "Cannot connect to database. " . $conn->connect_error]);
        }

        $stmt = $conn->prepare("INSERT INTO cliente(nombre, apellidos, correo, password) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $usr, $usr_lastname, $email, $pwd);
        $stmt->execute();
        $inserted_id = $stmt->insert_id;
        $conn->close();
        return json_encode(["id" => $inserted_id]);
    }

    return json_encode(["error" => "Incorrect Request"]);
}

function updateUserInfo($userinfo)
{
    global $server, $username, $password, $dbname;

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $json = json_decode($userinfo);

        $conn = new mysqli($server, $username, $password, $dbname);
        if ($conn->connect_error) {
            return json_encode(["error" => "Cannot connect to database. " . $conn->connect_error]);
        }

        $stmt = $conn->prepare("UPDATE cliente
                                    SET nombre = ?, apellidos = ?, correo = ?, telefono = ?, direccion = ?
                                    WHERE id = ?");
        $stmt->bind_param("sssssi", $json->username, $json->lastname, $json->email, $json->phone, $json->dir, $json->id);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            return json_encode(["success" => "Update successful"]);
        } else {
            return json_encode(["error" => "Incorrect Request"]);
        }
    }
    return json_encode(["error" => "Incorrect Request"]);
}

switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        if (isset($_GET["email"]) && $_GET["email"]) {

            define("client_email", $_GET["email"]);
            define("client_password", $_GET["pwd"]);
            echo getClient(client_email, client_password);
        } else if (isset($_GET["id"])) {
            define("client_id", $_GET["id"]);
            echo getClientInfo(client_id);
        } else {
            echo json_encode(["Error" => "Invalid GET request"]);
        }
        break;
    case 'POST':
        if (isset($_POST["userinfo"])) {
            define("userinfo", $_POST["userinfo"]);
            echo updateUserInfo(userinfo);
        } else {
            define("client_email", $_POST["email"]);
            define("client_username", $_POST["username"]);
            define("client_lastname", $_POST["lastname"]);
            define("client_password", $_POST["pwd"]);

            echo registerUser(client_email, client_username, client_lastname, client_password);
        }
        break;
}
