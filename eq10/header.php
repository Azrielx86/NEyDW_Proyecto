<?php

echo <<< EOF
<header>
    <div class="menu">
        <img class="logo-1" src="icons/logo.webp" alt="">
        <input type="checkbox" id="menu">
        <label for="menu">
            <img src="icons/menu.png" class="menu-icono" alt="">
        </label>
        <nav class="navbar">
            <div class="menu-1">
                <ul>
                    <li><a href="index.php">Inicio</a></li>
                    <li><a href="products.php">Productos</a></li>
                </ul>
            </div>
            <img class="logo-2" src="icons/logo.webp" alt="">
            <div class="menu-2">
                <ul>
<!--                    <li><a href="car.php">Carrito</a></li>-->
                    <li><a href="login.php">Perfil</a></li>
                </ul>
            </div>
        </nav>
    </div>
</header>

<div class="team-info-card">
    <p>Equipo 10 - Integrantes</p>
    <div class="team-members">
        <p>Martínez Ortiz Julio Alberto</p>
        <p>Moreno Chalico Edgar Ulises</p>
        <p>Ramirez Medina Daniel</p>
    </div>
</div>
EOF;
