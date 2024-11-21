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
        $stmt = $conn->prepare("SELECT ct.nombre FROM producto pd
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
        <p class="products-list-title">Productos por agregar</p>
    </div>
    <a href="#" class="btn-3">Ir al carrito</a>
</div>

</body>
<script src="script.js"></script>
<script>
    let products = []

    const addProduct = (product_id) => {
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
                                newDiv.innerHTML = `<img src="images/${product.product.img_path}" alt="">
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
</script>
</html>