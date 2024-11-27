<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log in</title>
    <link rel="stylesheet" href="styleli.css">
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
                </ul>
            </div>
            <img class="logo-2" src="images/logo.webp" alt="">
            <div class="menu-2">
                <ul>
                    <li><a href="car.php">Carrito</a></li>
                    <li><a href="#">Perfil</a></li>
                </ul>
            </div>
        </nav>
    </div>
</header>

<div class="login">
    <div class="login-screen">
        <div class="app-title">
            <!--            <h1>Chalico's Store</h1>-->
        </div>

        <div class="login-form">
            <div style="display: none" id="input-nombre" class="control-group">
                <input type="text" class="login-field" value="" placeholder="Nombre de usuario" id="username">
                <label class="login-field-icon fui-user" for="username"></label>
            </div>

            <div class="control-group">
                <input type="text" class="login-field" value="" placeholder="Email" id="email">
                <label class="login-field-icon fui-user" for="email"></label>
            </div>

            <div class="control-group">
                <input type="password" class="login-field" value="" placeholder="Contraseña" id="login-pass">
                <label class="login-field-icon fui-lock" for="login-pass"></label>
            </div>

            <button id="btn-login" class="btn btn-primary btn-large btn-block">Iniciar sesión</button>
            <a class="login-link" href="#">¿Olvidaste tu contraseña?</a>
            <button
                    id="btn-mode"
                    style="border: none; margin: 0.5rem auto; padding: 0.5rem"
                    onclick="changeView()">Regístrate
            </button>
            <div id="error-report"></div>
        </div>
    </div>
</div>
</body>
<script src="script.js"></script>
<script>
    $(document).ready(() => {
        let id = localStorage.getItem("client_id");
        if (id) {
            window.location.href = `${BASE_URL}/profile.php`
        }

        $("#btn-login").on("click", login);
    });

    const login = async () => {
        // let email = document.getElementById("email").value;
        //
        // let pwd = document.getElementById("login-pass").value;
        //
        // if (!pwd || pwd.trim() === "")
        //     console.log("Igual no requiere contraseña... en cualquier otra cosa sería fácil implementarlo, aquí... me ahorro mis comentarios.");

        let email = $("#email").val().trim();
        let password = $("#login-pass").val().trim();

        if (email && password) {
            let response = await fetch(`${BASE_URL}/users.php?email=${email}&pwd=${password}`);
            let json = await response.json();

            if (json !== null && json.id) {
                console.log("Client exists");
                localStorage.setItem("client_id", json.id);
                window.location.href = `${BASE_URL}/profile.php`
            } else {
                console.error("Client does not exists");
                let errorReport = document.getElementById("error-report");
                errorReport.innerHTML = `<div><p>This user does not exist.</p></div>`;
            }
        } else {
            let errorReport = document.getElementById("error-report");
            errorReport.innerHTML = `<div><p>Email required.</p></div>`;
        }
    }

    const register = () => {
        let username = $("#username").val().trim();
        let email = $("#email").val().trim();
        let pwd = $("#login-pass").val().trim();

        if (!username || !email || !pwd) {
            console.error("Invalid values in the form");
        }

        $.post(`${BASE_URL}/users.php`, {email, username, pwd}, (response) => {
            let json = JSON.parse(response);
            if (json.error) {
                console.error(json.error);
                let errorReport = document.getElementById("error-report");
                errorReport.innerHTML = `<div><p>${json.error}</p></div>`;
            } else {
                console.log("Client registered successfully");
                localStorage.setItem("client_id", json.id);
                window.location.href = `${BASE_URL}/profile.php`;
            }
        });
    }

    const changeView = () => {
        $("#input-nombre").css("display", "block");
        $("#btn-mode").css("display", "none");
        $("#btn-login")
            .html("Registrarte")
            .unbind("click")
            .on("click", register);
    }
</script>
</html>            