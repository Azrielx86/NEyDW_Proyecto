<!DOCTYPE html>
<?php
require "./config.php"
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Products</title>
</head>
<body>
<h1>Administración de Productos</h1>
<div>
    <h2>Agregar productos</h2>
    <?php

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $name = $_POST["nombre"];
        $precio = $_POST["precio"];
        $id_pais = $_POST["pais"];
        $descripcion = $_POST["descripcion"];
        $img_path = "no_img.jpg";

        $conn = new mysqli($server, $username, $password, $dbname);

        if ($conn->connect_error)
            die("Cannot connect to database. $conn->connect_error");

        $stmt = $conn->prepare("INSERT INTO producto(nombre, precio, descripcion, img_path, id_pais) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sdssi", $name, $precio, $descripcion, $img_path, $id_pais);

        if ($stmt->execute()) {
            echo "<p style='color: mediumseagreen'>Producto agregado exitosamente</p>";
        } else {
            echo "<p>Error: $stmt->error</p>";
        }
        $stmt->close();
        $conn->close();
    }
    ?>
    <form action="add_products.php" method="post">
        <label for="nombre">Name</label>
        <input type="text" name="nombre" id="nombre">
        <br>
        <label for="precio">Precio</label>
        <input type="number" step="0.01" name="precio" id="precio">
        <br>
        <label for="descripcion">Descripcion</label>
        <textarea name="descripcion" id="descripcion" maxlength="1024"></textarea>
        <br>
        <label for="pais">País de origen</label>
        <select id="pais" name="pais">
            <?php
            $conn = new mysqli($server, $username, $password, $dbname);

            if ($conn->connect_error)
                die("Cannot connect to database. $conn->connect_error");

            $result = $conn->query("SELECT id, nombre FROM pais");
            $countries = $result->fetch_all(MYSQLI_ASSOC);

            foreach ($countries as $country) {
                echo "<option value='" . $country["id"] . "'>" . $country["nombre"] . "</option>";
            }

            $conn->close();
            ?>
        </select>
        <br>
        <input type="submit" value="Add">
    </form>

    <div>
        <h2>Productos disponibles</h2>

        <table>
            <thead>
            <tr>
                <th>Nombre</th>
                <th>Precio</th>
                <th>Descripcion</th>
                <th>Pais de origen</th>
                <th>Categorías</th>
            </tr>
            </thead>
            <tbody>
            <?php
            $conn = new mysqli($server, $username, $password, $dbname);
            if ($conn->connect_error)
                die("Cannot connect to database. $conn->connect_error");

            $result = $conn->query("SELECT p.id, p.nombre, p.precio, p.descripcion, c.nombre pais FROM producto p INNER JOIN pais c ON p.id_pais = c.id");

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

                echo "<tr>";
                echo "<td>" . $product["nombre"] . "</td>";
                echo "<td>" . $product["precio"] . "</td>";
                echo "<td>" . $product["descripcion"] . "</td>";
                echo "<td>" . $product["pais"] . "</td>";
                echo "<td>";
                foreach ($categories->fetch_all(MYSQLI_ASSOC) as $cat)
                {
                    echo "<span class='lbl-categoria'>" . $cat["nombre"] . "</span>";
                }
                echo "</td>";
                echo "</tr>";

                $stmt->close();
                $conn_cat->close();
            }

            ?>
            </tbody>
        </table>
    </div>
</div>

</body>
</html>