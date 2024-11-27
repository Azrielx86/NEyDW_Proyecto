CREATE DATABASE IF NOT EXISTS eq10_tienda_importados;

drop table if exists compra_cliente cascade;

drop table if exists cliente cascade;

drop table if exists compra_producto cascade;

drop table if exists compra cascade;

drop table if exists producto_categoria cascade;

drop table if exists categoria cascade;

drop table if exists producto cascade;

drop table if exists pais cascade;

drop table if exists tipo_pago cascade;

CREATE TABLE IF NOT EXISTS pais
(
    id     INT         NOT NULL AUTO_INCREMENT,
    nombre VARCHAR(32) NOT NULL,
    CONSTRAINT pk_pais PRIMARY KEY (id),
    CONSTRAINT uq_nombre UNIQUE (nombre)
);

CREATE TABLE IF NOT EXISTS categoria
(
    id     INT         NOT NULL AUTO_INCREMENT,
    nombre VARCHAR(32) NOT NULL,
    CONSTRAINT pk_categoria PRIMARY KEY (id),
    CONSTRAINT uq_nombre UNIQUE (nombre)
);

CREATE TABLE IF NOT EXISTS producto
(
    id          INT            NOT NULL AUTO_INCREMENT,
    nombre      VARCHAR(128)   NOT NULL,
    precio      DECIMAL(10, 2) NOT NULL,
    descripcion VARCHAR(1024)  NOT NULL,
    img_path    VARCHAR(512)   NOT NULL,
    id_pais     INT            NOT NULL,
    popularity  INT(3) DEFAULT 0,
    CONSTRAINT pk_producto PRIMARY KEY (id),
    CONSTRAINT fk_pais_producto FOREIGN KEY (id_pais) REFERENCES pais (id)
);


CREATE TABLE IF NOT EXISTS producto_categoria
(
    id_producto  INT NOT NULL,
    id_categoria INT NOT NULL,
    CONSTRAINT pk_prod_cat PRIMARY KEY (id_producto, id_categoria),
    CONSTRAINT fk_producto FOREIGN KEY (id_producto) REFERENCES producto (id),
    CONSTRAINT fk_categoria FOREIGN KEY (id_categoria) REFERENCES categoria (id)
);

CREATE TABLE IF NOT EXISTS cliente
(
    id        INT          NOT NULL AUTO_INCREMENT,
    nombre    VARCHAR(128) NOT NULL,
    apellidos VARCHAR(128) NOT NULL,
    telefono  VARCHAR(16)  NOT NULL DEFAULT '',
    correo    VARCHAR(64)  NOT NULL,
    password  CHAR(64)     NOT NULL,
    direccion VARCHAR(256) NOT NULL DEFAULT '',
    CONSTRAINT pk_id PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS tipo_pago
(
    id   INT         NOT NULL AUTO_INCREMENT,
    tipo VARCHAR(16) NOT NULL,
    CONSTRAINT pk_tipo_pago PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS compra
(
    id           INT            NOT NULL AUTO_INCREMENT,
    fecha        DATETIME       NOT NULL,
    total        DECIMAL(10, 2) NOT NULL,
    id_tipo_pago INT            NOT NULL,
    CONSTRAINT pk_compra PRIMARY KEY (id),
    CONSTRAINT fk_compra_pago FOREIGN KEY (id_tipo_pago) REFERENCES tipo_pago (id)
);

CREATE TABLE IF NOT EXISTS compra_producto
(
    id_compra   INT NOT NULL,
    id_producto INT NOT NULL,
    cantidad    INT NOT NULL DEFAULT 1,
    CONSTRAINT pk_compra_producto PRIMARY KEY (id_compra, id_producto),
    CONSTRAINT fk_comp_prod_compra FOREIGN KEY (id_compra) REFERENCES compra (id),
    CONSTRAINT fk_comp_prod_producto FOREIGN KEY (id_producto) REFERENCES producto (id)
);

# One to Many
CREATE TABLE IF NOT EXISTS compra_cliente
(
    id         INT AUTO_INCREMENT,
    id_cliente INT NOT NULL,
    id_compra  INT NOT NULL,
    CONSTRAINT pk_compra_usuario PRIMARY KEY (id),
    CONSTRAINT fk_cu_compra FOREIGN KEY (id_compra) REFERENCES compra (id),
    CONSTRAINT fk_cu_usuario FOREIGN KEY (id_cliente) REFERENCES cliente (id)
);

DROP PROCEDURE IF EXISTS hash_password;
DROP TRIGGER IF EXISTS before_insert_cliente;

DELIMITER //
CREATE PROCEDURE hash_password(IN raw_password VARCHAR(64), OUT hashed_password CHAR(64))
BEGIN
    SET hashed_password = SHA2(raw_password, 256);
END;
//
DELIMITER ;

DELIMITER //
CREATE TRIGGER before_insert_cliente
    BEFORE INSERT
    ON cliente
    FOR EACH ROW
BEGIN
    DECLARE hashed_pwd CHAR(64);
    IF NEW.nombre = '' THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Nombre cannot be empty';
    END IF;
    IF NEW.password = '' THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Password cannot be empty';
    END IF;
    IF NEW.correo = '' THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Correo cannot be empty';
    END IF;
    CALL hash_password(NEW.password, hashed_pwd);
    SET NEW.password = hashed_pwd;
END;
//
DELIMITER ;

/* ================================================= INSERTS ======================================================== */
INSERT INTO pais (nombre)
VALUES ('China');
INSERT INTO pais (nombre)
VALUES ('USA');
INSERT INTO pais (nombre)
VALUES ('Japón');
INSERT INTO pais (nombre)
VALUES ('Corea del sur');

INSERT INTO categoria (id, nombre)
VALUES (1, 'Snack');
INSERT INTO categoria (id, nombre)
VALUES (2, 'Popcorn');
INSERT INTO categoria (id, nombre)
VALUES (3, 'Cookie');
INSERT INTO categoria (id, nombre)
VALUES (4, 'Soda');
INSERT INTO categoria (nombre)
VALUES ('Chocolate');

INSERT INTO producto (id, nombre, precio, descripcion, img_path, id_pais)
VALUES (1, 'Cheetos Crunchy', 5.99, 'Cheese 8.5 oz', 'cheetosCrunchy.png', 4);
INSERT INTO producto_categoria (id_producto, id_categoria)
VALUES (1, 1);

INSERT INTO producto (id, nombre, precio, descripcion, img_path, id_pais)
VALUES (2, 'Cheetos Flamin'' Hot Crunchy', 5.99, 'Flamin'' Hot 8.5 oz', 'cheetosFlaminHot.png', 1);
INSERT INTO producto_categoria (id_producto, id_categoria)
VALUES (2, 1);

INSERT INTO producto (id, nombre, precio, descripcion, img_path, id_pais)
VALUES (3, 'Cheetos Flamin'' Hot Limon Crunchy', 5.99, 'Flamin'' Hot Limon 8.5 oz', 'cheetosFlaminHotLimon.png', 2);
INSERT INTO producto_categoria (id_producto, id_categoria)
VALUES (3, 1);

INSERT INTO producto (id, nombre, precio, descripcion, img_path, id_pais)
VALUES (4, 'Cheetos Xxtra Flamin'' Hot Crunchy', 5.99, 'Xxtra Flamin'' Hot 8.5 oz', 'cheetosXxtraFlaminHot.png', 3);
INSERT INTO producto_categoria (id_producto, id_categoria)
VALUES (4, 1);

INSERT INTO producto (id, nombre, precio, descripcion, img_path, id_pais)
VALUES (5, 'Cheetos Cheddar Jalapeño Crunchy', 5.99, 'Jalapeño 8.5 oz', 'cheetosJalapeno.png', 4);
INSERT INTO producto_categoria (id_producto, id_categoria)
VALUES (5, 1);

INSERT INTO producto (id, nombre, precio, descripcion, img_path, id_pais)
VALUES (6, 'Cheetos Mexican Street Corn', 5.99, 'Mexican Street Corn 8.5 oz', 'cheetosMexican.png', 3);
INSERT INTO producto_categoria (id_producto, id_categoria)
VALUES (6, 1);

INSERT INTO producto (id, nombre, precio, descripcion, img_path, id_pais)
VALUES (7, 'Doritos Spicy Sweet Chili', 6.99, 'Spicy Sweet Chili 8.5 oz', 'doritosSpicySweetChili.png', 2);
INSERT INTO producto_categoria (id_producto, id_categoria)
VALUES (7, 1);

INSERT INTO producto (id, nombre, precio, descripcion, img_path, id_pais)
VALUES (8, 'Doritos Cool Ranch', 6.99, 'Ranch 8.5 oz', 'doritosCoolRanch.png', 4);
INSERT INTO producto_categoria (id_producto, id_categoria)
VALUES (8, 1);

INSERT INTO producto (id, nombre, precio, descripcion, img_path, id_pais)
VALUES (9, 'Doritos Spicy Nacho', 6.99, 'Spicy Nacho 8.5 oz', 'doritosSpicyNacho.png', 1);
INSERT INTO producto_categoria (id_producto, id_categoria)
VALUES (9, 1);

INSERT INTO producto (id, nombre, precio, descripcion, img_path, id_pais)
VALUES (10, 'Doritos Flamin'' Hot Nacho', 6.99, 'Flamin'' Hot Nacho 8.5 oz', 'doritosFlaminHot.png', 2);
INSERT INTO producto_categoria (id_producto, id_categoria)
VALUES (10, 1);

INSERT INTO producto (id, nombre, precio, descripcion, img_path, id_pais)
VALUES (11, 'Doritos Flamin'' Hot Limon', 6.99, 'Flamin'' Hot Limon 8.5 oz', 'doritosFlaminHotLimon.png', 1);
INSERT INTO producto_categoria (id_producto, id_categoria)
VALUES (11, 1);

INSERT INTO producto (id, nombre, precio, descripcion, img_path, id_pais)
VALUES (12, 'Doritos Sweet & Tangy BBQ', 6.99, 'Sweet & Tangy BBQ 8.5 oz', 'doritosBBQ.png', 4);
INSERT INTO producto_categoria (id_producto, id_categoria)
VALUES (12, 1);

INSERT INTO producto (id, nombre, precio, descripcion, img_path, id_pais)
VALUES (13, 'Kernel Season''s Butter Popcorn Seasoning', 4.99, 'Butter Popcorn 2.85 oz', 'kernelSeasonsButter.png', 2);
INSERT INTO producto_categoria (id_producto, id_categoria)
VALUES (13, 1);
INSERT INTO producto_categoria (id_producto, id_categoria)
VALUES (13, 2);

INSERT INTO producto (id, nombre, precio, descripcion, img_path, id_pais)
VALUES (14, 'Kernel Season''s Caramel Corn Popcorn Seasoning', 4.99, 'Caramel Corn Popcorn 2.85 oz',
        'kernelSeasonsCheesyCaramelCorn.png', 4);
INSERT INTO producto_categoria (id_producto, id_categoria)
VALUES (14, 1);
INSERT INTO producto_categoria (id_producto, id_categoria)
VALUES (14, 2);

INSERT INTO producto (id, nombre, precio, descripcion, img_path, id_pais)
VALUES (15, 'Kernel Season''s Cheesy JalapeÃ±o Popcorn Seasoning', 4.99, 'Cheesy JalapeÃ±o Popcorn 2.85 oz',
        'kernelSeasonsCheesyJalapeno.png', 1);
INSERT INTO producto_categoria (id_producto, id_categoria)
VALUES (15, 1);
INSERT INTO producto_categoria (id_producto, id_categoria)
VALUES (15, 2);

INSERT INTO producto (id, nombre, precio, descripcion, img_path, id_pais)
VALUES (16, 'Kernel Season''s Chile Limon Popcorn Seasoning', 4.99, 'Chile Limon Popcorn 2.85 oz',
        'kernelSeasonsChileLimon.png', 3);
INSERT INTO producto_categoria (id_producto, id_categoria)
VALUES (16, 1);
INSERT INTO producto_categoria (id_producto, id_categoria)
VALUES (16, 2);

INSERT INTO producto (id, nombre, precio, descripcion, img_path, id_pais)
VALUES (17, 'Kernel Season''s Nacho Cheddar Popcorn Seasoning', 4.99, 'Nacho Cheddar Popcorn 2.85 oz',
        'kernelSeasonsNachoCheddar.png', 4);
INSERT INTO producto_categoria (id_producto, id_categoria)
VALUES (17, 1);
INSERT INTO producto_categoria (id_producto, id_categoria)
VALUES (17, 2);

INSERT INTO producto (id, nombre, precio, descripcion, img_path, id_pais)
VALUES (18, 'Kernel Season''s Ranch Popcorn Seasoning', 4.99, 'Ranch Popcorn 2.85 oz', 'kernelSeasonsRanch.png', 4);
INSERT INTO producto_categoria (id_producto, id_categoria)
VALUES (18, 1);
INSERT INTO producto_categoria (id_producto, id_categoria)
VALUES (18, 2);

INSERT INTO producto (id, nombre, precio, descripcion, img_path, id_pais)
VALUES (19, 'Teddy Grahams Chocolatey Chips', 20.99, 'Chocolate 10 oz', 'teddyGrahamsChocolatey.png', 2);
INSERT INTO producto_categoria (id_producto, id_categoria)
VALUES (19, 1);
INSERT INTO producto_categoria (id_producto, id_categoria)
VALUES (19, 3);

INSERT INTO producto (id, nombre, precio, descripcion, img_path, id_pais)
VALUES (20, 'Teddy Grahams Cinnamon', 20.99, 'Cinnamon 10 oz', 'teddyGrahamsCinnamon.png', 2);
INSERT INTO producto_categoria (id_producto, id_categoria)
VALUES (20, 1);
INSERT INTO producto_categoria (id_producto, id_categoria)
VALUES (20, 3);

INSERT INTO producto (id, nombre, precio, descripcion, img_path, id_pais)
VALUES (21, 'Teddy Grahams Cocoa', 20.99, 'Cocoa 10 oz', 'teddyGrahamsCocoa.png', 1);
INSERT INTO producto_categoria (id_producto, id_categoria)
VALUES (21, 1);
INSERT INTO producto_categoria (id_producto, id_categoria)
VALUES (21, 3);

INSERT INTO producto (id, nombre, precio, descripcion, img_path, id_pais)
VALUES (22, 'Teddy Grahams Honey', 20.99, 'Honey 10 oz', 'teddyGrahamsHoney.png', 2);
INSERT INTO producto_categoria (id_producto, id_categoria)
VALUES (22, 1);
INSERT INTO producto_categoria (id_producto, id_categoria)
VALUES (22, 3);

INSERT INTO producto (id, nombre, precio, descripcion, img_path, id_pais)
VALUES (23, 'Caffeine-Free Coca-Cola', 1.49, 'Caffeine Free 12 oz', 'cocaColaCaffeineFree.png', 2);
INSERT INTO producto_categoria (id_producto, id_categoria)
VALUES (23, 4);

INSERT INTO producto (id, nombre, precio, descripcion, img_path, id_pais)
VALUES (24, 'Caffeine-Free Diet Coca-Cola', 1.49, 'Caffeine Free Diet 12 oz', 'cocaColaCaffeineFreeDiet.png', 4);
INSERT INTO producto_categoria (id_producto, id_categoria)
VALUES (24, 4);

INSERT INTO producto (id, nombre, precio, descripcion, img_path, id_pais)
VALUES (25, 'Coca-Cola Cherry', 1.49, 'Cherry 12 oz', 'cocaColaCherry.png', 2);
INSERT INTO producto_categoria (id_producto, id_categoria)
VALUES (25, 4);

INSERT INTO producto (id, nombre, precio, descripcion, img_path, id_pais)
VALUES (26, 'Coca-Cola Zero Cherry', 1.49, 'Zero Cherry 12 oz', 'cocaColaCherryZero.png', 3);
INSERT INTO producto_categoria (id_producto, id_categoria)
VALUES (26, 4);

INSERT INTO producto (id, nombre, precio, descripcion, img_path, id_pais)
VALUES (27, 'Coca-Cola Vanilla', 1.49, 'Vanilla 12 oz', 'cocaColaVanilla.png', 1);
INSERT INTO producto_categoria (id_producto, id_categoria)
VALUES (27, 4);

INSERT INTO producto (id, nombre, precio, descripcion, img_path, id_pais)
VALUES (28, 'Coca-Cola Vanilla Zero', 1.49, 'Vanilla Zero 12 oz', 'cocaColaCherryZero.png', 4);
INSERT INTO producto_categoria (id_producto, id_categoria)
VALUES (28, 4);

INSERT INTO producto (id, nombre, precio, descripcion, img_path, id_pais)
VALUES (29, 'Fanta', 2.99, 'Orange 20 oz', 'fanta.png', 1);
INSERT INTO producto_categoria (id_producto, id_categoria)
VALUES (29, 4);

INSERT INTO producto (id, nombre, precio, descripcion, img_path, id_pais)
VALUES (30, 'Fanta Zero', 2.99, 'Orange Zero 20 oz', 'fantaZero.png', 2);
INSERT INTO producto_categoria (id_producto, id_categoria)
VALUES (30, 4);

INSERT INTO producto (id, nombre, precio, descripcion, img_path, id_pais)
VALUES (31, 'Fanta Grape', 2.99, 'Grape 20 oz', 'fantaGrape.png', 1);
INSERT INTO producto_categoria (id_producto, id_categoria)
VALUES (31, 4);

INSERT INTO producto (id, nombre, precio, descripcion, img_path, id_pais)
VALUES (32, 'Fanta Pineapple', 2.99, 'Pineapple 20 oz', 'fantaPineapple.png', 2);
INSERT INTO producto_categoria (id_producto, id_categoria)
VALUES (32, 4);

INSERT INTO producto (id, nombre, precio, descripcion, img_path, id_pais)
VALUES (33, 'Fanta Strawberry', 2.99, 'Strawberry 20 oz', 'fantaStrawberry.png', 4);
INSERT INTO producto_categoria (id_producto, id_categoria)
VALUES (33, 4);

# Usuarios

INSERT INTO cliente (id, nombre, apellidos, telefono, correo, password, direccion)
VALUES (1, 'Edgar', 'Chalico', '+52 55 1677 1012', 'edgarch@mail.com', 'test1234', 'SMX Tlalnepantla EDOMEX');

# Compras
INSERT INTO tipo_pago (tipo)
VALUES ('Debito');

INSERT INTO tipo_pago (tipo)
VALUES ('Crédito');

/*
 * Prueba 1: Compra de dos productos
 */
INSERT INTO compra (fecha, total, id_tipo_pago)
VALUES ('2021-10-01 12:00:00', 7.97, 1);

INSERT INTO compra_producto (id_compra, id_producto)
VALUES (1, 26);

INSERT INTO compra_producto (id_compra, id_producto)
VALUES (1, 27);

INSERT INTO compra_producto (id_compra, id_producto)
VALUES (1, 17);

INSERT INTO compra_cliente (id_cliente, id_compra)
VALUES (1, 1);

/*
 * Prueba 2: Compra de tres productos
 */
INSERT INTO compra (fecha, total, id_tipo_pago)
VALUES ('2021-10-02 12:00:00', 8.97, 2);

INSERT INTO compra_producto (id_compra, id_producto, cantidad)
VALUES (2, 29, 2);

INSERT INTO compra_producto (id_compra, id_producto)
VALUES (2, 30);

INSERT INTO compra_cliente (id_cliente, id_compra)
VALUES (1, 2);

/*
 * Ejemplos de uso.
 *
 * Obtener compras.
 * SELECT cliente.nombre, compra.fecha, compra.total FROM compra
 * INNER JOIN compra_cliente ON compra.id = compra_cliente.id_compra
 * INNER JOIN cliente ON compra_cliente.id_cliente = cliente.id;
 *
 * Obtener productos de una compra.
 * SELECT producto.nombre, producto.precio, compra_producto.cantidad FROM compra
 * INNER JOIN compra_producto ON compra.id = compra_producto.id_compra
 * INNER JOIN producto ON compra_producto.id_producto = producto.id
 * WHERE compra.id = 2;
 */