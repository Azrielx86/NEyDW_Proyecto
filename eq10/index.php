<!DOCTYPE html>
<?php
/** @noinspection DuplicatedCode */
require "./config.php";
global $server, $username, $password, $dbname;
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Inicio</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.css"/>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<?php
include "header.php"
?>

<div class="header-content container">

    <div class="swiper mySwiper-1">
        <div class="swiper-wrapper">
            <?php
            $conn = new mysqli($server, $username, $password, $dbname);
            if ($conn->connect_error)
                die("Cannot connect to database. $conn->connect_error");

            $result = $conn->query("SELECT producto.nombre, producto.img_path, marca.nombre marca
                                                FROM producto
                                                INNER JOIN marca
                                                ON producto.id_marca = marca.id
                                                ORDER BY popularity DESC
                                                LIMIT 3");
            $products = $result->fetch_all(MYSQLI_ASSOC);

            foreach ($products as $product) {
                echo <<< EOF
                <div class="swiper-slide">
                    <div class="slider">
                        <div class="slider-txt">
                            <h1>$product[marca]</h1>
                            <p>
                                $product[nombre]
                            </p>
                            <div class="botones">
                                <a href="products.php" class="btn-1">Ver Más</a>
                                <a href="products.php" class="btn-1">Comprar</a>
                            </div>
                        </div>
                        <div class="slider-img">
                            <img src="$product[img_path]" alt="" onerror="this.src='images/s1.svg'">
                        </div>
                    </div>
                </div>
EOF;
            }

            ?>

        </div>
        <div class="swiper-button-next"></div>
        <div class="swiper-button-prev"></div>
        <div class="swiper-pagination"></div>
    </div>

</div>


<main class="products">
    <div class="tabs container">

        <input type="radio" name="tabs" id="tab1" checked="checked" class="tabInput" value="1">
        <label for="tab1">Lo más nuevo</label>
        <div class="tab">
            <div class="swiper mySwiper-2" id="swiper1">
                <div class="swiper-wrapper">
                    <?php

                    $conn = new mysqli($server, $username, $password, $dbname);
                    if ($conn->connect_error)
                        die("Cannot connect to database. $conn->connect_error");

                    $result = $conn->query("SELECT id, nombre, img_path, precio 
                                                    FROM producto 
                                                    WHERE fecha_agregado < NOW() 
                                                    ORDER BY fecha_agregado 
                                                    DESC LIMIT 6;");

                    /** @noinspection DuplicatedCode */
                    $products = $result->fetch_all(MYSQLI_ASSOC);

                    foreach ($products as $product) {
                        $stmt = $conn->prepare("SELECT ct.nombre FROM producto pd
                        INNER JOIN producto_categoria pdct ON pd.id = pdct.id_producto
                        INNER JOIN categoria ct ON pdct.id_categoria = ct.id
                        WHERE pd.id = ?");
                        $stmt->bind_param("i", $product["id"]);
                        $stmt->execute();
                        $categories = $stmt->get_result();
                        echo <<< EOF
                                        <div class="swiper-slide">
                                            <div class="product">
                                                <div class="product-img">
                                                    <h4>New</h4>
                                                    <img src="$product[img_path]" alt="" onerror="this.src='images/s1.svg'">
                                                </div>
                                                <div class="product-txt">
                                                    <h4>$product[nombre]</h4>
                                                    <p>
EOF;
                        foreach ($categories->fetch_all(MYSQLI_ASSOC) as $cat) {
                            echo "<span class='lbl-categoria'>" . $cat["nombre"] . "</span>";
                        }
                        echo <<< EOF
                                                    </p>
                                                    <span class="price">&#36 $product[precio]</span>
                                                </div>
                                            </div>
                                        </div>
EOF;
                    }

                    ?>
                </div>

                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>
            </div>
        </div>

        <input type="radio" name="tabs" id="tab2" checked="checked" class="tabInput" value="2">
        <label for="tab2">Proximamente</label>
        <div class="tab">
            <div class="swiper mySwiper-2" id="swiper2">
                <div class="swiper-wrapper">

                    <?php

                    $conn = new mysqli($server, $username, $password, $dbname);
                    if ($conn->connect_error)
                        die("Cannot connect to database. $conn->connect_error");

                    $result = $conn->query("SELECT id, nombre, img_path, precio 
                                                    FROM producto 
                                                    WHERE fecha_agregado > NOW() 
                                                    ORDER BY fecha_agregado 
                                                    DESC LIMIT 6;");

                    $products = $result->fetch_all(MYSQLI_ASSOC);

                    foreach ($products as $product) {
                        $stmt = $conn->prepare("SELECT ct.nombre FROM producto pd
                        INNER JOIN producto_categoria pdct ON pd.id = pdct.id_producto
                        INNER JOIN categoria ct ON pdct.id_categoria = ct.id
                        WHERE pd.id = ?");
                        $stmt->bind_param("i", $product["id"]);
                        $stmt->execute();
                        $categories = $stmt->get_result();
                        echo <<< EOF
                                        <div class="swiper-slide">
                                            <div class="product">
                                                <div class="product-img">
                                                    <h4>New</h4>
                                                    <img src="$product[img_path]" alt="" onerror="this.src='images/s1.svg'">
                                                </div>
                                                <div class="product-txt">
                                                    <h4>$product[nombre]</h4>
                                                    <p>
EOF;
                        foreach ($categories->fetch_all(MYSQLI_ASSOC) as $cat) {
                            echo "<span class='lbl-categoria'>" . $cat["nombre"] . "</span>";
                        }
                        echo <<< EOF
                                                    </p>
                                                    <span class="price">&#36 $product[precio]</span>
                                                </div>
                                            </div>
                                        </div>
EOF;
                    }

                    ?>

                </div>
                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>
            </div>
        </div>

    </div>
</main>

<section class="info container">

    <div class="info-img">
        <img src="images/kernelSeasonsRanch.png" alt="">
    </div>
    <div class="info-txt">
        <h2>Información</h2>
        <p>
            Pagina en proceso.
        </p>
        <a href="#" class="btn-2">Más Información</a>

    </div>


</section>

<section class="horario">
    <div class="horario-info container">
        <h2>Horario</h2>
        <div class="horario-txt">
            <div class="txt">
                <h4>Dirección</h4>
                <p>
                    Av. Santa Fe 1989
                </p>
                <p>
                    Santa Fe
                </p>
            </div>
            <div class="txt">
                <h4>Horario</h4>
                <p>
                    Lunes a Viernes: 11am - 7pm
                </p>
                <p>
                    Sabado y Domingo: 11am - 3pm
                </p>
            </div>
            <div class="txt">
                <h4>Telefono</h4>
                <p>
                    55 1234 5678
                </p>
                <p>
                    55 9876 5432
                </p>

            </div>
            <div class="txt">
                <h4>Redes Sociales</h4>

                <div class="socials">
                    <a href="#">
                        <div class="social">
                            <img src="images/s1.svg" alt="">
                        </div>
                    </a>

                    <a href="#">
                        <div class="social">
                            <img src="images/s2.svg" alt="">
                        </div>
                    </a>

                    <a href="#">
                        <div class="social">
                            <img src="images/s3.svg" alt="">
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>

</section>

<section>

    <iframe class="map"
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d14901.215843756023!2d-99.28043756812181!3d19.358812704417726!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x85d200c8ffc50487%3A0xcc4765164a3d6d8f!2sLomas%20de%20Santa%20Fe%2C%20Contadero%2C%2005348%20Ciudad%20de%20M%C3%A9xico%2C%20CDMX!5e0!3m2!1ses-419!2smx!4v1725858764138!5m2!1ses-419!2smx"
            width="100%" height="500" style="border:0;" allowfullscreen="" loading="lazy"
            referrerpolicy="no-referrer-when-downgrade"></iframe>

</section>

<footer class="footer container">

    <img class="logo-3" src="images/logo.webp" alt="">
    <div class="links">
        <h4>Lorem</h4>
        <ul>
            <li><a href="#">lorem</a></li>
            <li><a href="#">lorem</a></li>
            <li><a href="#">lorem</a></li>
        </ul>
    </div>
    <div class="links">
        <h4>Redes Sociales</h4>
        <div class="socials">

            <a href="#">
                <div class="social">
                    <img src="images/s3.svg" alt="">
                </div>
            </a>

            <a href="#">
                <div class="social">
                    <img src="images/s3.svg" alt="">
                </div>
            </a>

            <a href="#">
                <div class="social">
                    <img src="images/s3.svg" alt="">
                </div>
            </a>

        </div>
    </div>
    <div>
        <a href="add_products.php">Test agregado de productos</a>
    </div>
</footer>


<script src="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.js"></script>
<script src="script.js"></script>
</body>
</html>