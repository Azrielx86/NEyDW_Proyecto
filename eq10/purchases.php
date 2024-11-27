<?php
header("Content-Type: application/json; charset=UTF-8");
require "./config.php";

function getClientShopHistory($clientId)
{
    global $server, $username, $password, $dbname;

    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        $conn = new mysqli($server, $username, $password, $dbname);
        if ($conn->connect_error) {
            return json_encode(["error" => "Cannot connect to database. " . $conn->connect_error]);
        }

        $stmt = $conn->prepare("SELECT compra.id, compra.fecha, compra.total, tipo_pago.tipo pago FROM compra
                                        INNER JOIN compra_cliente ON compra.id = compra_cliente.id_compra
                                        INNER JOIN cliente ON compra_cliente.id_cliente = cliente.id
                                        INNER JOIN tipo_pago ON compra.id_tipo_pago = tipo_pago.id
                                        WHERE cliente.id = ?
                                        LIMIT 10");
        $stmt->bind_param("i", $clientId);
        $stmt->execute();
        $result = $stmt->get_result();
        /** @noinspection PhpMethodParametersCountMismatchInspection */
        $shopping_history = $result->fetch_all(MYSQLI_ASSOC);

        $conn->close();

        return json_encode($shopping_history);
    }

    return json_encode(["error" => "Incorrect Request"]);
}

function getPurchaseInfo($purchaseId)
{
    global $server, $username, $password, $dbname;

    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        $conn = new mysqli($server, $username, $password, $dbname);
        if ($conn->connect_error) {
            return json_encode(["error" => "Cannot connect to database. " . $conn->connect_error]);
        }

        $stmt = $conn->prepare("SELECT producto.nombre, producto.precio, compra_producto.cantidad FROM compra
                                        INNER JOIN compra_producto ON compra.id = compra_producto.id_compra
                                        INNER JOIN producto ON compra_producto.id_producto = producto.id
                                        WHERE compra.id = ?");
        $stmt->bind_param("i", $purchaseId);
        $stmt->execute();
        $result = $stmt->get_result();
        /** @noinspection PhpMethodParametersCountMismatchInspection */
        $shopping_history = $result->fetch_all(MYSQLI_ASSOC);

        $conn->close();

        return json_encode($shopping_history);
    }

    return json_encode(["error" => "Incorrect Request"]);
}

function doPurchase($productsString, $userId)
{
    global $server, $username, $password, $dbname;
    if ($productsString) {
        $b64 = base64_decode($productsString);
        $json = json_decode($b64);

        $conn = new mysqli($server, $username, $password, $dbname);
        if ($conn->connect_error) {
            return json_encode(["error" => "Cannot connect to database. " . $conn->connect_error]);
        }

        $total = 0;
        foreach ($json as $product) {
            $stmt = $conn->prepare("SELECT precio FROM producto WHERE id = ?");
            $stmt->bind_param("i", $product->id);
            $stmt->execute();
            $result = $stmt->get_result();

            $row = $result->fetch_assoc();
            $total += $row['precio'];

            $stmt->close();
        }

        $stmt = $conn->prepare("INSERT INTO compra(fecha, total, id_tipo_pago) VALUES (?, ?, 1)");
        date_default_timezone_set('America/Mexico_City');
        $fecha = date('Y-m-d H:i:s');
        $stmt->bind_param("si", $fecha, $total);
        $stmt->execute();
        $id_compra = $stmt->insert_id;
        $stmt->close();

        foreach ($json as $product) {
            $stmt = $conn->prepare("INSERT INTO compra_producto(id_compra, id_producto) VALUES (?, ?)");
            $stmt->bind_param("ii", $id_compra, $product->id);
            $stmt->execute();
            $stmt->close();
        }

        $stmt = $conn->prepare("INSERT INTO compra_cliente(id_cliente, id_compra) VALUES (?, ?)");
        $stmt->bind_param("ii", $userId, $id_compra);
        $stmt->execute();
        $id_compra = $stmt->insert_id;

        $stmt->close();
        return json_encode(["done" => "Compra realizada: $id_compra"]);
    }
    return json_encode(["error" => "Incorrect Request"]);
}

switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        if (isset($_GET["client_id"])) {
            define("client_id", $_GET["client_id"]);
            echo getClientShopHistory(client_id);
        } else if (isset($_GET["purchase_id"])) {
            define("purchase_id", $_GET["purchase_id"]);
            echo getPurchaseInfo(purchase_id);
        } else {
            return json_encode(["error" => "Invalid request"]);
        }
        break;
    case 'POST':
        if (isset($_POST["products"]) && isset($_POST["client_id"])) {
            define("products", $_POST["products"]);
            define("client_id", $_POST["client_id"]);
            echo doPurchase(products, client_id);
        } else {
            return json_encode(["error" => "Invalid request"]);
        }
}

