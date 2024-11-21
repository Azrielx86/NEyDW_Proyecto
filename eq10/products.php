<!DOCTYPE html>
<?php
$server = "localhost";
$username = "root";
$password = "test1234";
$dbname = "eq10_tienda_importados";
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
                    <li><a href="#">Productos</a></li>
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

    <?php
    $conn = new mysqli($server, $username, $password, $dbname);
    if ($conn->connect_error)
        die("Cannot connect to database. $conn->connect_error");

    $result = $conn->query("SELECT p.id, p.nombre, p.precio, p.descripcion, p.img_path, c.nombre pais FROM producto p INNER JOIN pais c ON p.id_pais = c.id");

    $products = $result->fetch_all(MYSQLI_ASSOC);

    foreach ($products as $product) {
        $conn_cat = new mysqli($server, $username, $password, $dbname);
        if ($conn_cat->connect_error)
            die("Cannot connect to database. $conn->connect_error");

        $stmt = $conn_cat->prepare("SELECT ct.nombre FROM producto pd
                        INNER JOIN producto_categoria pdct ON pd.id = pdct.id_producto
                        INNER JOIN categoria ct ON pdct.id_categoria = ct.id
                        WHERE pd.id = ?");
        $stmt->bind_param("i", $product["id"]);
        $stmt->execute();
        $categories = $stmt->get_result();

        echo '<div class="product">';
        echo '<div class="product-img1">';
        echo '<img src="images/' . $product["img_path"] . '" alt="">';
        echo '</div>';
        echo '<div class="product-txt">';
        echo '<h4>' . $product["nombre"] . '</h4>';
        echo '<p>';
        foreach ($categories->fetch_all(MYSQLI_ASSOC) as $cat) {
            echo "<span class='lbl-categoria'>" . $cat["nombre"] . "</span>";
        }
        echo '</p>';
        echo '<span class="price">$' . $product["precio"] . '</span>';
        echo '<div class="botones1">';
        echo '<a href="#" class="btn-3">Comprar</a>';
        echo '</div>';
        echo '</div>';
        echo '</div>';

        $stmt->close();
        $conn_cat->close();
    }

    ?>
</div>

</body>
</html>