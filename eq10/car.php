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
</head>
<body>
<header>
    <div class="menu container">
        <nav class="navbar">
            <div class="menu-1">
                <ul>
                    <li><a href="index.php">Inicio</a></li>
                    <li><a href="products.php">Productos</a></li>
                </ul>
            </div>
            <img class="logo-2" src="images/logo.webp" alt="">
            <div class="menu-2">
                <ul>
                    <li><a href="car.php">Carrito</a></li>
                    <li><a href="login.php">Perfil</a></li>
                </ul>
            </div>
        </nav>
    </div>
</header>
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
                    echo '<img src="images/' . $product["img_path"] . '" alt="">';
                    echo '</div>';
                    echo '<div class="product-txt">';
                    echo '<h4>' . $product["nombre"] . '</h4>';
                    echo '<span class="price">$' . $product["precio"] . ' x ' . $item->quantity . '</span>';
                    echo '</div>';
                    echo '</div>';
                }

                echo '<div><h1>Precio total: $' . $total_price . '</h1></div>';
                echo '<button class="btn-3" onclick="placeOrder()">Realizar compra</button>';
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
<script>
    const placeOrder = () => {
        alert("Coming soon... :P");
    }
</script>
</html>