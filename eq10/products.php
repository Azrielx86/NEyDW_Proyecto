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
<div style="margin-top: 6rem" class="products-container">
    <?php
    $conn = new mysqli($server, $username, $password, $dbname);
    if ($conn->connect_error)
        die("Cannot connect to database. $conn->connect_error");

    $result = $conn->query("SELECT p.id, p.nombre, p.precio, p.descripcion, p.img_path, c.nombre pais FROM producto p INNER JOIN pais c ON p.id_pais = c.id");

    $products = $result->fetch_all(MYSQLI_ASSOC);

    foreach ($products as $product) {
        $stmt = $conn->prepare("SELECT ct.nombre FROM producto pd
                        INNER JOIN producto_categoria pdct ON pd.id = pdct.id_producto
                        INNER JOIN categoria ct ON pdct.id_categoria = ct.id
                        WHERE pd.id = ?");
        $stmt->bind_param("i", $product["id"]);
        $stmt->execute();
        $categories = $stmt->get_result();

        echo '<div class="product">';
        echo '<div class="product-img1">';
        echo '<img src="' . $product["img_path"] . '" alt="" onerror="this.src=\'icons/ItemNotFound.svg\'">';
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
        echo sprintf("<button onclick='addProduct(%d)' class=\"btn-3\">Comprar</button>", $product["id"]);
        echo '</div>';
        echo '</div>';
        echo '</div>';

        $stmt->close();
    }

    ?>
</div>

<div class="products-list-container">
    <div id="products-list">
        <p id="car-title" class="products-list-title">Productos por agregar</p>
    </div>
    <button id="btn-goto-car" onclick="goToPurchase()" class="btn-3">Ir al carrito</button>
</div>

</body>
<script src="script.js"></script>
<script>
    let products = []

    $(document).ready(() => {
        let id = localStorage.getItem("client_id");
        if (!id) {
            console.log("User is not logged in.");
            $("#car-title").html("Necesitas iniciar sesión para comprar");
            $("#btn-goto-car").hide();
        }
    });

    const addProduct = (product_id) => {
        let id = localStorage.getItem("client_id");
        if (!id) return;

        console.log(`Finding product ${product_id}`);

        fetch(`${BASE_URL}/get_product.php?id=${product_id}`)
            .then(result => {
                result
                    .json()
                    .then(json => {
                            let product = products.find(p => p.product.id === json.id);

                            if (product) {
                                product.quantity++;
                                let existing_div = document
                                    .getElementById(`q_${product.product.nombre}`)
                                    .getElementsByClassName("products-list-info");
                                existing_div[0].textContent = `${product.product.nombre}: ${product.quantity}`;
                            } else {
                                product = {
                                    product: json,
                                    quantity: 1
                                }
                                products.push(product);

                                let products_list = document.getElementById("products-list");
                                let newDiv = document.createElement("div");
                                newDiv.id = `q_${product.product.nombre}`
                                newDiv.classList.add("products-list-item");
                                newDiv.innerHTML = `<img src="${product.product.img_path}" onerror="this.src='icons/ItemNotFound.svg'" alt="">
                                                    <div>
                                                        <p class="products-list-info">${product.product.nombre}: ${product.quantity}</p>
                                                        <button class="btn-remove" onclick="removeProduct(${product.product.id})">
                                                            Eliminar
                                                        </button>
                                                    </div>`;
                                products_list.appendChild(newDiv);

                                products_list.appendChild(newDiv);
                            }

                            console.log(products);
                        }
                    ).catch(error => console.error(error));
            }).catch(error => console.error(error));
    }

    const removeProduct = (productId) => {
        let product = products.find(p => p.product.id === productId);

        if (product) {
            products = products.filter(p => p.product.id !== productId);
            document.getElementById(`q_${product.product.nombre}`).remove();
        } else {
            console.warn("This product is not in the list.");
        }
    }

    const goToPurchase = () => {
        const data = products.map(p => {
                return {
                    id: p.product.id,
                    quantity: p.quantity
                }
            }
        );
        const json = JSON.stringify(data);
        window.location.href = `${BASE_URL}/car.php?purchase=${btoa(json)}`;
    }
</script>
</html>