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
<header style="margin-bottom: 8rem">
    <div class="menu container">
        <nav class="navbar">
            <div class="menu-1">
                <ul>
                    <li><a href="index.php">Inicio</a></li>
                    <li><a href="products.php">Productos</a></li>
                    <!--                    <li><a href="#">Perfil</a></li>-->
                </ul>
            </div>
            <img class="logo-2" src="icons/logo.svg" alt="Logo de la tienda">
            <div class="menu-2">
                <ul>
                    <!--                    <li><a href="car.php">Carrito</a></li>-->
                    <li>
                        <button style="font-size: 18px;padding: 20px;color: #3C7A80;display: block; background: none; border: none"
                                onclick="logout()">Logout
                        </button>
                    </li>
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

<div class="container1">
    <div class="profile-container">

        <aside class="profile-sidebar">
            <div class="profile-picture">
                <img src="icons/UserIcon.svg" alt="" class="avatar">
                <input type="file" name="profile-picture" id="profile-picture">
            </div>

            <div class="activity">
                <h4>Actividad</h4>
                <ul>
                    <li>Compras: <span id="compras_count">0</span></li>
                    <!--                    <li>Pendientes: <span>4</span></li>-->
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
                        <label for="direccion">Dirección</label>
                        <textarea style="resize: none" id="direccion" name="direccion" rows="5"
                                  placeholder="Dirección"></textarea>
                    </div>
                </div>
                <!--                <div class="form-row">-->
                <!--                    <div class="form-group">-->
                <!--                        <label for="contrasena">Contraseña</label>-->
                <!--                        <input type="password" id="contrasena" name="contrasena" placeholder="contraseña">-->
                <!--                    </div>-->
                <!--                    <div class="form-group">-->
                <!--                        <label for="verifica-contrasena">Verifica la contraseña</label>-->
                <!--                        <input type="password" id="verifica-contrasena" name="verifica-contrasena"-->
                <!--                               placeholder="contraseña">-->
                <!--                    </div>-->
                <!--                </div>-->
                <div class="form-actions">
                    <!--                    <button type="submit" class="btn btn-success">Guardar</button>-->
                    <!--                    <button type="reset" class="btn btn-danger">Limpiar</button>-->
                </div>
            </form>
            <button onclick="updateInfo()" class="btn btn-success">Guardar</button>
        </section>
    </div>
</div>
<div class="container2">
    <h4>Compras recientes</h4>
    <div id="purchase-list">
        Obteniendo compras...
    </div>
</div>
</body>
<script src="script.js"></script>
<script>
    $(document).ready(async () => {
        let id = localStorage.getItem("client_id");
        if (!id) {
            window.location.href = `${BASE_URL}`
            console.log("User is logged in.");
        }

        let client_request = await fetch(`${BASE_URL}/users.php?id=${id}`);
        let client = await client_request.json();

        let purchases_request = await fetch(`${BASE_URL}/purchases.php?client_id=${id}`);
        let purchases = await purchases_request.json();

        $("#nombre").val(client.nombre);
        $("#apellidos").val(client.apellidos);
        $("#email").val(client.correo);
        $("#movil").val(client.telefono);
        $("#direccion").val(client.direccion)
        $("#compras_count").html(purchases.length);

        if (purchases.length > 0) {
            $("#purchase-list").html(await Promise.all(purchases.map(async (purchase) => {
                const products_request = await fetch(`${BASE_URL}/purchases.php?purchase_id=${purchase.id}`);
                const products = await products_request.json();
                return `
                <div class="purchase-item">
                    <p class="purchase-item-date">${purchase.fecha}</p>
                    <div class="purchase-items-list">
                        <div class="purchase-items-table">
                            <table>
                                <thead>
                                    <tr style="border: none">
                                        <th style="border: none" >Producto</th>
                                        <th style="border: none" >Precio Unitario</th>
                                        <th style="border: none" >Cantidad</th>
                                    </tr>
                                </thead>
                                <tbody>
                                ${products.map(product => `
                                    <tr>
                                        <td>${product.nombre}</td>
                                        <td>$${product.precio}</td>
                                        <td>${product.cantidad}</td>
                                    </tr>
                                `).join('')}
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="purchase-item-info">
                        <p class="purchase-item-payment">Tipo de Pago: ${purchase.pago}</p>
                        <p class="purchase-item-total">Total: $${purchase.total}</p>
                    </div>
                </div>`;
            })).then(html => html.join("")));
        } else {
            $("#purchase-list").html("No hay compras registradas");
        }
    });

    const logout = () => {
        localStorage.removeItem("client_id");
        window.location.href = `${BASE_URL}`
    }

    const updateInfo = () => {
        const id = localStorage.getItem("client_id");
        const nombre = $("#nombre").val();
        const apellidos = $("#apellidos").val();
        const correo = $("#email").val();
        const telefono = $("#movil").val();
        const direccion = $("#direccion").val();

        $.post(`${BASE_URL}/users.php`, {
            userinfo: JSON.stringify({
                id: id,
                username: nombre,
                lastname: apellidos,
                email: correo,
                phone: telefono,
                dir: direccion
            })
        }, () => {
            location.reload();
        });
    }
</script>
</html>
