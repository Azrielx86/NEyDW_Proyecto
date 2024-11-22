<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil de Usuario</title>
    <link rel="stylesheet" href="style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
</head>
<body>
<header>
    <div class="menu container">
        <nav class="navbar">
            <div class="menu-1">
                <ul>
                    <li><a href="index.php">Inicio</a></li>
                    <li><a href="products.php">Productos</a></li>
                    <li><a href="#">Perfil</a></li>
                </ul>
            </div>
            <img class="logo-2" src="images/logo.webp" alt="Logo de la tienda">
            <div class="menu-2">
                <ul>
                    <li><a href="car.php">Carrito</a></li>
                    <li>
                        <button onclick="logout()">Logout</button>
                    </li>
                </ul>
            </div>
        </nav>
    </div>
</header>

<div class="container1">
    <div class="profile-container">

        <aside class="profile-sidebar">
            <div class="profile-picture">
                <img src="" alt="" class="avatar">
                <input type="file" name="profile-picture" id="profile-picture">
            </div>

            <div class="activity">
                <h4>Actividad</h4>
                <ul>
                    <li>Compras: <span>2</span></li>
                    <li>Pendientes: <span>4</span></li>

                </ul>
            </div>
        </aside>

        <section class="profile-form">
            <h3>Perfil</h3>
            <form action="#" method="POST">
                <div class="form-row">
                    <div class="form-group">
                        <label for="nombre">Nombre</label>
                        <input type="text" id="nombre" name="nombre" placeholder="nombre">
                    </div>
                    <div class="form-group">
                        <label for="apellidos">Apellidos</label>
                        <input type="text" id="apellidos" name="apellidos" placeholder="apellidos">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label for="movil">Móvil</label>
                        <input type="text" id="movil" name="movil" placeholder="introduce tu móvil">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" placeholder="you@email.com">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label for="email">Calle y Número</label>
                        <input type="text" id="calle" name="calle" placeholder="calle">
                    </div>
                    <div class="form-group">
                        <label for="ciudad">Código Postal</label>
                        <input type="text" id="cp" name="cp" placeholder="código postal">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label for="email">Estado</label>
                        <input type="text" id="estado" name="estado" placeholder="estado">
                    </div>
                    <div class="form-group">
                        <label for="ciudad">Ciudad</label>
                        <input type="text" id="ciudad" name="ciudad" placeholder="ciudad">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label for="contrasena">Contraseña</label>
                        <input type="password" id="contrasena" name="contrasena" placeholder="contraseña">
                    </div>
                    <div class="form-group">
                        <label for="verifica-contrasena">Verifica la contraseña</label>
                        <input type="password" id="verifica-contrasena" name="verifica-contrasena"
                               placeholder="contraseña">
                    </div>
                </div>
                <div class="form-actions">
                    <button type="submit" class="btn btn-success">Guardar</button>
                    <button type="reset" class="btn btn-danger">Limpiar</button>
                </div>
            </form>
        </section>
    </div>
</div>
</body>
<script src="script.js"></script>
<script>
    $(document).ready(() => {
        let id = localStorage.getItem("client_id");
        if (id) {
            console.log("User is logged in.");
        } else {
            window.location.href = `${BASE_URL}`
        }
    });

    const logout = () => {
        localStorage.removeItem("client_id");
        window.location.href = `${BASE_URL}`
    }
</script>
</html>
