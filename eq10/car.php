<!DOCTYPE html>
<?php
require "./config.php";
global $server, $username, $password, $dbname;
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Productos</title>
    <link rel="stylesheet" href="style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
</head>
<body>
<?php
include "header.php"
?>
<div class="tabs container">
    <h1>Comprar productos</h1>
    <br>
    <div>
        <?php
        $data = $_GET["purchase"];

        if ($data) {
            $b64 = base64_decode($data);
            $json = json_decode($b64);
            $total_price = 0;
            if (count($json) > 0) {

                $conn = new mysqli($server, $username, $password, $dbname);
                if ($conn->connect_error)
                    die("Cannot connect to database. $conn->connect_error");

                foreach ($json as $item) {
                    $stmt = $conn->prepare("SELECT p.id, p.nombre, p.precio, p.img_path FROM producto p WHERE p.id = ?");
                    $stmt->bind_param("i", $item->id);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    $product = $result->fetch_assoc();

                    $total_price += $product["precio"] * $item->quantity;

                    echo '<div class="product">';
                    echo '<div class="product-img1">';
                    echo '<img src="' . $product["img_path"] . '" alt="" onerror="this.src=\'icons/ItemNotFound.svg\'">';
                    echo '</div>';
                    echo '<div class="product-txt">';
                    echo '<h4>' . $product["nombre"] . '</h4>';
                    echo '<span class="price">$' . $product["precio"] . ' x ' . $item->quantity . '</span>';
                    echo '</div>';
                    echo '</div>';
                }

                echo '<div><h1>Precio total: $' . $total_price . '</h1></div>';
                echo '<button id="btn-compra" class="btn-3" onclick="placeOrder()">Realizar compra</button>';
                $conn->close();
            } else {
                echo '<h2>No hay productos por comprar</h2>';
            }
        } else {
            echo '<h2>URL Inválida</h2>';
        }
        ?>
    </div>
</div>

</body>
<script src="script.js"></script>
<script>
    const placeOrder = () => {
        const productsEncoded = "<?php echo $_GET["purchase"]?>"
        const clientId = localStorage.getItem("client_id");

        $.post(`${BASE_URL}/purchases.php`, {products: productsEncoded, client_id: clientId}, (response) => {
            console.log(JSON.parse(response));
            $("#btn-compra").prop("disabled", true);
        });
        window.location.href = `${BASE_URL}/profile.php`;
    }
</script>
</html>