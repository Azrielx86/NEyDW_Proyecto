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

if (isset($_GET["client_id"])) {
    define("client_id", $_GET["client_id"]);
    echo getClientShopHistory(client_id);
} else if (isset($_GET["purchase_id"])) {
    define("purchase_id", $_GET["purchase_id"]);
    echo getPurchaseInfo(purchase_id);
} else {
    return json_encode(["error" => "Invalid request"]);
}
