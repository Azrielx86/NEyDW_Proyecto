# Página Web Sweet Swift - Equipo 10

```
Semestre 2025-1
Facultad de Ingeniería UNAM
```
Integrantes del equipo
- Martínez Ortiz Julio Alberto
- Moreno Chalico Edgar Ulises
- Ramirez Medina Daniel

# NOTAS IMPORTANTES

## Archivo de configuración

1. Antes de utilizar la página, es __necesario__ cambiar los datos de acceso a
la base de datos en el archivo `config.php`

```php

<?php
$server = "localhost";
$username = "<Su usuario>";
$password = "<Su contraseña>";
$dbname = "eq10_tienda_importados";

```

## Archivo script.js

Este archivo en el entregable ya se encuentra con los cambios necesarios
para funcionar sin la estructura que usamos, ya que hacer los cambios directo
y mandarlos por Google Drive es ineficiente, obviamente.

Por ello, es recomendable verificar que en `script.js` la primera línea este
de esta manera:

```diff
+ const BASE_URL = 'http://localhost/eq10'
- const BASE_URL = 'http://localhost/NEyDW_Proyecto/eq10'
```

Y no como está en el repositorio.

## Repositorio

Los avances y cambios de este proyecto pueden revisarse en el siguiente enlace:

[Repositorio de GitHub](https://github.com/Azrielx86/NEyDW_Proyecto)

## Imágenes

Debido a que se especifica que no debe haber más de 10 imágenes, todas las
imágenes del sitio se subieron al servicio __Postimage__ y puede consultarse
en [este enlace](https://postimg.cc/gallery/PCvrWRm).
Si alguna desaparece (por cuestiones de derecho de autor o demás) es
error de los requerimientos.

Las únicas _imágenes_ que se dejaron fue una de ejemplo y los íconos `.svg`.
