CREATE DATABASE IF NOT EXISTS eq10_tienda_importados;

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
    id          INT           NOT NULL AUTO_INCREMENT,
    nombre      VARCHAR(128)  NOT NULL,
    precio      DECIMAL(10,2)       NOT NULL,
    descripcion VARCHAR(1024) NOT NULL,
    img_path    VARCHAR(512)  NOT NULL,
    id_pais     INT           NOT NULL,
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
    telefono  VARCHAR(16)  NOT NULL,
    correo    VARCHAR(64)  NOT NULL,
    direccion VARCHAR(256) NOT NULL,
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
    id           INT      NOT NULL AUTO_INCREMENT,
    cantidad     INT      NOT NULL,
    fecha        DATETIME NOT NULL,
    total        DECIMAL  NOT NULL,
    id_tipo_pago INT      NOT NULL,
    CONSTRAINT pk_compra PRIMARY KEY (id),
    CONSTRAINT fk_compra_pago FOREIGN KEY (id_tipo_pago) REFERENCES tipo_pago (id)
);

CREATE TABLE IF NOT EXISTS compra_producto
(
    id_compra   INT NOT NULL,
    id_producto INT NOT NULL,
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


/* ================================================= INSERTS ======================================================== */
/*
INSERT INTO pais (nombre)
VALUES ('China');
INSERT INTO pais (nombre)
VALUES ('India');
INSERT INTO pais (nombre)
VALUES ('Japón');
INSERT INTO pais (nombre)
VALUES ('Estados Unidos');
INSERT INTO pais (nombre)
VALUES ('Canadá');
INSERT INTO pais (nombre)
VALUES ('México');
INSERT INTO pais (nombre)
VALUES ('Brasil');
INSERT INTO pais (nombre)
VALUES ('Argentina');
INSERT INTO pais (nombre)
VALUES ('Reino Unido');
INSERT INTO pais (nombre)
VALUES ('Francia');
INSERT INTO pais (nombre)
VALUES ('Alemania');
INSERT INTO pais (nombre)
VALUES ('Italia');
INSERT INTO pais (nombre)
VALUES ('España');
INSERT INTO pais (nombre)
VALUES ('Corea del Sur');
INSERT INTO pais (nombre)
VALUES ('Vietnam');
INSERT INTO pais (nombre)
VALUES ('Tailandia');
INSERT INTO pais (nombre)
VALUES ('Filipinas');
INSERT INTO pais (nombre)
VALUES ('Indonesia');
INSERT INTO pais (nombre)
VALUES ('Colombia');
INSERT INTO pais (nombre)
VALUES ('Perú');
INSERT INTO pais (nombre)
VALUES ('Chile');
INSERT INTO pais (nombre)
VALUES ('Venezuela');
INSERT INTO pais (nombre)
VALUES ('Uruguay');
INSERT INTO pais (nombre)
VALUES ('Portugal');
INSERT INTO pais (nombre)
VALUES ('Bélgica');
INSERT INTO pais (nombre)
VALUES ('Países Bajos');
INSERT INTO pais (nombre)
VALUES ('Suiza');
INSERT INTO pais (nombre)
VALUES ('Suecia');

INSERT INTO categoria (nombre)
VALUES ('Chocolates');
INSERT INTO categoria (nombre)
VALUES ('Caramelos');
INSERT INTO categoria (nombre)
VALUES ('Gomitas');
INSERT INTO categoria (nombre)
VALUES ('Chicles');
INSERT INTO categoria (nombre)
VALUES ('Turrones');
INSERT INTO categoria (nombre)
VALUES ('Barras de cereal');
INSERT INTO categoria (nombre)
VALUES ('Paletas');
INSERT INTO categoria (nombre)
VALUES ('Galletas');
INSERT INTO categoria (nombre)
VALUES ('Ácidos');
INSERT INTO categoria (nombre)
VALUES ('Picosos');

INSERT INTO producto (nombre, precio, descripcion, img_path, id_pais)
VALUES ('Chocolate Bar', 1.99, 'Delicious chocolate bar', 'not_img.jpg', 1);
INSERT INTO producto (nombre, precio, descripcion, img_path, id_pais)
VALUES ('Gummy Bears', 2.49, 'Colorful gummy bears', 'not_img.jpg', 2);
INSERT INTO producto (nombre, precio, descripcion, img_path, id_pais)
VALUES ('Caramel Candy', 1.29, 'Sweet caramel candy', 'not_img.jpg', 3);
INSERT INTO producto (nombre, precio, descripcion, img_path, id_pais)
VALUES ('Bubble Gum', 0.99, 'Chewy bubble gum', 'not_img.jpg', 4);
INSERT INTO producto (nombre, precio, descripcion, img_path, id_pais)
VALUES ('Nougat', 2.99, 'Soft nougat', 'not_img.jpg', 5);
INSERT INTO producto (nombre, precio, descripcion, img_path, id_pais)
VALUES ('Cereal Bar', 1.49, 'Healthy cereal bar', 'not_img.jpg', 6);
INSERT INTO producto (nombre, precio, descripcion, img_path, id_pais)
VALUES ('Lollipop', 0.79, 'Sweet lollipop', 'not_img.jpg', 7);
INSERT INTO producto (nombre, precio, descripcion, img_path, id_pais)
VALUES ('Cookie', 1.99, 'Crunchy cookie', 'not_img.jpg', 8);
INSERT INTO producto (nombre, precio, descripcion, img_path, id_pais)
VALUES ('Sour Candy', 1.49, 'Tangy sour candy', 'not_img.jpg', 9);
INSERT INTO producto (nombre, precio, descripcion, img_path, id_pais)
VALUES ('Spicy Candy', 1.99, 'Hot and spicy candy', 'not_img.jpg', 10);
INSERT INTO producto (nombre, precio, descripcion, img_path, id_pais)
VALUES ('Mint Candy', 1.29, 'Refreshing mint candy', 'not_img.jpg', 11);
INSERT INTO producto (nombre, precio, descripcion, img_path, id_pais)
VALUES ('Fruit Chews', 1.99, 'Fruity chewy candy', 'not_img.jpg', 12);
INSERT INTO producto (nombre, precio, descripcion, img_path, id_pais)
VALUES ('Toffee', 2.49, 'Rich toffee', 'not_img.jpg', 13);
INSERT INTO producto (nombre, precio, descripcion, img_path, id_pais)
VALUES ('Jelly Beans', 2.99, 'Assorted jelly beans', 'not_img.jpg', 14);
INSERT INTO producto (nombre, precio, descripcion, img_path, id_pais)
VALUES ('Hard Candy', 1.49, 'Hard candy', 'not_img.jpg', 15);
INSERT INTO producto (nombre, precio, descripcion, img_path, id_pais)
VALUES ('Licorice', 1.99, 'Sweet licorice', 'not_img.jpg', 16);
INSERT INTO producto (nombre, precio, descripcion, img_path, id_pais)
VALUES ('Marshmallow', 1.29, 'Soft marshmallow', 'not_img.jpg', 17);
INSERT INTO producto (nombre, precio, descripcion, img_path, id_pais)
VALUES ('Peanut Brittle', 2.49, 'Crunchy peanut brittle', 'not_img.jpg', 18);
INSERT INTO producto (nombre, precio, descripcion, img_path, id_pais)
VALUES ('Candy Cane', 0.99, 'Festive candy cane', 'not_img.jpg', 19);
INSERT INTO producto (nombre, precio, descripcion, img_path, id_pais)
VALUES ('Chocolate Truffle', 3.99, 'Decadent chocolate truffle', 'not_img.jpg', 20);

INSERT INTO producto_categoria (id_producto, id_categoria)
VALUES (1, 1);
INSERT INTO producto_categoria (id_producto, id_categoria)
VALUES (1, 2);
INSERT INTO producto_categoria (id_producto, id_categoria)
VALUES (2, 3);
INSERT INTO producto_categoria (id_producto, id_categoria)
VALUES (2, 4);
INSERT INTO producto_categoria (id_producto, id_categoria)
VALUES (3, 2);
INSERT INTO producto_categoria (id_producto, id_categoria)
VALUES (3, 5);
INSERT INTO producto_categoria (id_producto, id_categoria)
VALUES (4, 4);
INSERT INTO producto_categoria (id_producto, id_categoria)
VALUES (4, 6);
INSERT INTO producto_categoria (id_producto, id_categoria)
VALUES (5, 5);
INSERT INTO producto_categoria (id_producto, id_categoria)
VALUES (5, 7);
INSERT INTO producto_categoria (id_producto, id_categoria)
VALUES (6, 6);
INSERT INTO producto_categoria (id_producto, id_categoria)
VALUES (6, 8);
INSERT INTO producto_categoria (id_producto, id_categoria)
VALUES (7, 7);
INSERT INTO producto_categoria (id_producto, id_categoria)
VALUES (7, 9);
INSERT INTO producto_categoria (id_producto, id_categoria)
VALUES (8, 8);
INSERT INTO producto_categoria (id_producto, id_categoria)
VALUES (8, 10);
INSERT INTO producto_categoria (id_producto, id_categoria)
VALUES (10, 1);
INSERT INTO producto_categoria (id_producto, id_categoria)
VALUES (11, 2);
INSERT INTO producto_categoria (id_producto, id_categoria)
VALUES (11, 3);
INSERT INTO producto_categoria (id_producto, id_categoria)
VALUES (12, 3);
INSERT INTO producto_categoria (id_producto, id_categoria)
VALUES (12, 4);
INSERT INTO producto_categoria (id_producto, id_categoria)
VALUES (13, 2);
INSERT INTO producto_categoria (id_producto, id_categoria)
VALUES (13, 5);
INSERT INTO producto_categoria (id_producto, id_categoria)
VALUES (14, 3);
INSERT INTO producto_categoria (id_producto, id_categoria)
VALUES (14, 6);
INSERT INTO producto_categoria (id_producto, id_categoria)
VALUES (15, 2);
INSERT INTO producto_categoria (id_producto, id_categoria)
VALUES (16, 2);
INSERT INTO producto_categoria (id_producto, id_categoria)
VALUES (16, 8);
INSERT INTO producto_categoria (id_producto, id_categoria)
VALUES (17, 3);
INSERT INTO producto_categoria (id_producto, id_categoria)
VALUES (18, 2);
INSERT INTO producto_categoria (id_producto, id_categoria)
VALUES (18, 10);
INSERT INTO producto_categoria (id_producto, id_categoria)
VALUES (19, 2);
INSERT INTO producto_categoria (id_producto, id_categoria)
VALUES (20, 1);
*/

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
VALUES (5, 'Cheetos Cheddar JalapeÃ±o Crunchy', 5.99, 'JalapeÃ±o 8.5 oz', 'cheetosJalapeno.png', 4);
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
VALUES (19, 'Teddy Grahams Chocolatey Chips', 20.99, 'Chocolate 10 oz', 'teddyGrahamsChocolatey.jpg', 2);
INSERT INTO producto_categoria (id_producto, id_categoria)
VALUES (19, 1);
INSERT INTO producto_categoria (id_producto, id_categoria)
VALUES (19, 3);

INSERT INTO producto (id, nombre, precio, descripcion, img_path, id_pais)
VALUES (20, 'Teddy Grahams Cinnamon', 20.99, 'Cinnamon 10 oz', 'teddyGrahamsCinnamon.jpg', 2);
INSERT INTO producto_categoria (id_producto, id_categoria)
VALUES (20, 1);
INSERT INTO producto_categoria (id_producto, id_categoria)
VALUES (20, 3);

INSERT INTO producto (id, nombre, precio, descripcion, img_path, id_pais)
VALUES (21, 'Teddy Grahams Cocoa', 20.99, 'Cocoa 10 oz', 'teddyGrahamsCocoa.jpg', 1);
INSERT INTO producto_categoria (id_producto, id_categoria)
VALUES (21, 1);
INSERT INTO producto_categoria (id_producto, id_categoria)
VALUES (21, 3);

INSERT INTO producto (id, nombre, precio, descripcion, img_path, id_pais)
VALUES (22, 'Teddy Grahams Honey', 20.99, 'Honey 10 oz', 'teddyGrahamsHoney.jpg', 2);
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

