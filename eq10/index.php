<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Document</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.css" />
    <link rel="stylesheet" href="style.css">
</head>
<body>

<header>

    <div class="menu container">
        <img class="logo-1" src="images/logo.webp" alt="">
        <input type="checkbox" id="menu" />
        <label for="menu">
            <img src="images/menu.png" class="menu-icono" alt="">
        </label>
        <nav class="navbar">
            <div class="menu-1">
                <ul>
                    <li><a href="#">Home</a></li>
                    <li><a href="#">USA</a></li>
                    <li><a href="#">UK</a></li>
                </ul>
            </div>
            <img class="logo-2" src="images/logo.webp"  alt="">
            <div class="menu-2">
                <ul>
                    <li><a href="#">Account</a></li>
                </ul>
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
        </nav>
    </div>

    <div class="header-content container">

        <div class="swiper mySwiper-1">
            <div class="swiper-wrapper">

                <div class="swiper-slide">
                    <div class="slider">
                        <div class="slider-txt">
                            <h1>Pizza</h1>
                            <p>
                                Rica pizza.
                            </p>
                            <div class="botones">
                                <a href="#" class="btn-1">Buy</a>
                                <a href="#" class="btn-1">Menu</a>

                            </div>
                        </div>
                        <div class="slider-img">
                            <img src="images/slider1.webp" alt="">

                        </div>
                    </div>
                </div>
                <div class="swiper-slide">
                    <div class="slider">
                        <div class="slider-txt">
                            <h1>Taco</h1>
                            <p>
                                Hello
                            </p>
                            <div class="botones">
                                <a href="#" class="btn-1">Comprar</a>
                                <a href="#" class="btn-1">Menu</a>

                            </div>
                        </div>
                        <div class="slider-img">
                            <img src="images/slider2.jpg" alt="">

                        </div>
                    </div>
                </div>
                <div class="swiper-slide">
                    <div class="slider">
                        <div class="slider-txt">
                            <h1>Burger</h1>
                            <p>
                                Hola
                            </p>
                            <div class="botones">
                                <a href="#" class="btn-1">Comprar</a>
                                <a href="#" class="btn-1">Menu</a>

                            </div>
                        </div>
                        <div class="slider-img">
                            <img src="images/slider3.jpg" alt="">

                        </div>
                    </div>
                </div>

            </div>
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
            <div class="swiper-pagination"></div>
        </div>

    </div>


</header>

<main class="products">
    <div class="tabs container">

        <input type="radio" name="tabs" id="tab1" checked="checked" class="tabInput" value="1">
        <label for="tab1">Colors</label>
        <div class="tab">
            <div class="swiper mySwiper-2" id="swiper1">
                <div class="swiper-wrapper">

                    <div class="swiper-slide">
                        <div class="product">
                            <div class="product-img">
                                <h4>New</h4>
                                <img src="images/blue.webp" alt="">
                            </div>
                            <div class="product-txt">
                                <h4>Blue</h4>
                                <p>Color</p>
                                <span class="price">$4.99</span>
                            </div>
                        </div>
                    </div>

                    <div class="swiper-slide">
                        <div class="product">
                            <div class="product-img">
                                <h4>New</h4>
                                <img src="images/black.webp" alt="">
                            </div>
                            <div class="product-txt">
                                <h4>Black</h4>
                                <p>Color</p>
                                <span class="price">$4.99</span>
                            </div>
                        </div>
                    </div>

                    <div class="swiper-slide">
                        <div class="product">
                            <div class="product-img">
                                <h4>New</h4>
                                <img src="images/white.webp" alt="">
                            </div>
                            <div class="product-txt">
                                <h4>White</h4>
                                <p>Color</p>
                                <span class="price">$4.99</span>
                            </div>
                        </div>
                    </div>

                    <div class="swiper-slide">
                        <div class="product">
                            <div class="product-img">
                                <h4>New</h4>
                                <img src="images/orange.webp" alt="">
                            </div>
                            <div class="product-txt">
                                <h4>Orange</h4>
                                <p>Color</p>
                                <span class="price">$4.99</span>
                            </div>
                        </div>
                    </div>

                    <div class="swiper-slide">
                        <div class="product">
                            <div class="product-img">
                                <h4>New</h4>
                                <img src="images/purple.webp" alt="">
                            </div>
                            <div class="product-txt">
                                <h4>Purple</h4>
                                <p>Color</p>
                                <span class="price">$4.99</span>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>
            </div>
        </div>

        <input type="radio" name="tabs" id="tab2" checked="checked" class="tabInput" value="2">
        <label for="tab2">Burger</label>
        <div class="tab">
            <div class="swiper mySwiper-2" id="swiper2">
                <div class="swiper-wrapper">

                    <div class="swiper-slide">
                        <div class="product">
                            <div class="product-img">
                                <h4>New</h4>
                                <img src="images/burger.webp" alt="">
                            </div>
                            <div class="product-txt">
                                <h4>Burger</h4>
                                <p>Fish</p>
                                <span class="price">$22.99</span>
                            </div>
                        </div>
                    </div>

                    <div class="swiper-slide">
                        <div class="product">
                            <div class="product-img">
                                <h4>New</h4>
                                <img src="images/tacos.webp" alt="">
                            </div>
                            <div class="product-txt">
                                <h4>Tacos</h4>
                                <p>3 order</p>
                                <span class="price">$13.99</span>
                            </div>
                        </div>
                    </div>

                    <div class="swiper-slide">
                        <div class="product">
                            <div class="product-img">
                                <h4>New</h4>
                                <img src="images/tacos.webp" alt="">
                            </div>
                            <div class="product-txt">
                                <h4>Tacos</h4>
                                <p>3 order</p>
                                <span class="price">$13.99</span>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>
            </div>
        </div>

        <input type="radio" name="tabs" id="tab3" checked="checked" class="tabInput" value="3">
        <label for="tab3">Popcorn</label>
        <div class="tab">
            <div class="swiper mySwiper-2" id="swiper3">
                <div class="swiper-wrapper">

                    <div class="swiper-slide">
                        <div class="product">
                            <div class="product-img">
                                <h4>New</h4>
                                <img src="images/popcorn.webp" alt="">
                            </div>
                            <div class="product-txt">
                                <h4>Popcorn</h4>
                                <p>Butter</p>
                                <span class="price">$8.99</span>
                            </div>
                        </div>
                    </div>

                    <div class="swiper-slide">
                        <div class="product">
                            <div class="product-img">
                                <h4>New</h4>
                                <img src="images/tacos.webp" alt="">
                            </div>
                            <div class="product-txt">
                                <h4>Tacos</h4>
                                <p>3 order</p>
                                <span class="price">$13.99</span>
                            </div>
                        </div>
                    </div>

                    <div class="swiper-slide">
                        <div class="product">
                            <div class="product-img">
                                <h4>New</h4>
                                <img src="images/tacos.webp" alt="">
                            </div>
                            <div class="product-txt">
                                <h4>Tacos</h4>
                                <p>3 order</p>
                                <span class="price">$13.99</span>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>
            </div>
        </div>

    </div>
</main>

<section class="info container">

    <div class="info-img">
        <img src="images/info.jpg" alt="">
    </div>
    <div class="info-txt">
        <h2>Informacion</h2>
        <p>
            Pagina en proceso.
        </p>
        <a href="#" class="btn-2">More info</a>

    </div>


</section>

<section class="horario">
    <div class="horario-info container">
        <h2>Horario</h2>
        <div class="horario-txt">
            <div class="txt">
                <h4>Direccion</h4>
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

    <iframe class="map" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d14901.215843756023!2d-99.28043756812181!3d19.358812704417726!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x85d200c8ffc50487%3A0xcc4765164a3d6d8f!2sLomas%20de%20Santa%20Fe%2C%20Contadero%2C%2005348%20Ciudad%20de%20M%C3%A9xico%2C%20CDMX!5e0!3m2!1ses-419!2smx!4v1725858764138!5m2!1ses-419!2smx" width="100%" height="500" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>

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
        <h4>Lorem</h4>
        <ul>
            <li><a href="#">lorem</a></li>
            <li><a href="#">lorem</a></li>
            <li><a href="#">lorem</a></li>
        </ul>
    </div>
    <div class="links">
        <h4>Lorem</h4>
        <ul>
            <li><a href="#">lorem</a></li>
            <li><a href="#">lorem</a></li>
            <li><a href="#">lorem</a></li>
        </ul>
    </div>
    <div class="links">
        <h4>Lorem</h4>
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
    <div>
        <a href="add_product_page.php">Test agregado de productos</a>
    </div>
</footer>


<script src="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.js"></script>
<script src="script.js"></script>
</body>
</html>