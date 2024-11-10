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
    precio      DECIMAL       NOT NULL,
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

INSERT INTO producto (nombre, precio, descripcion, img_path, id_pais) VALUES ('Chocolate Bar', 1.99, 'Delicious chocolate bar', 'not_img.jpg', 1);
INSERT INTO producto (nombre, precio, descripcion, img_path, id_pais) VALUES ('Gummy Bears', 2.49, 'Colorful gummy bears', 'not_img.jpg', 2);
INSERT INTO producto (nombre, precio, descripcion, img_path, id_pais) VALUES ('Caramel Candy', 1.29, 'Sweet caramel candy', 'not_img.jpg', 3);
INSERT INTO producto (nombre, precio, descripcion, img_path, id_pais) VALUES ('Bubble Gum', 0.99, 'Chewy bubble gum', 'not_img.jpg', 4);
INSERT INTO producto (nombre, precio, descripcion, img_path, id_pais) VALUES ('Nougat', 2.99, 'Soft nougat', 'not_img.jpg', 5);
INSERT INTO producto (nombre, precio, descripcion, img_path, id_pais) VALUES ('Cereal Bar', 1.49, 'Healthy cereal bar', 'not_img.jpg', 6);
INSERT INTO producto (nombre, precio, descripcion, img_path, id_pais) VALUES ('Lollipop', 0.79, 'Sweet lollipop', 'not_img.jpg', 7);
INSERT INTO producto (nombre, precio, descripcion, img_path, id_pais) VALUES ('Cookie', 1.99, 'Crunchy cookie', 'not_img.jpg', 8);
INSERT INTO producto (nombre, precio, descripcion, img_path, id_pais) VALUES ('Sour Candy', 1.49, 'Tangy sour candy', 'not_img.jpg', 9);
INSERT INTO producto (nombre, precio, descripcion, img_path, id_pais) VALUES ('Spicy Candy', 1.99, 'Hot and spicy candy', 'not_img.jpg', 10);
INSERT INTO producto (nombre, precio, descripcion, img_path, id_pais) VALUES ('Mint Candy', 1.29, 'Refreshing mint candy', 'not_img.jpg', 11);
INSERT INTO producto (nombre, precio, descripcion, img_path, id_pais) VALUES ('Fruit Chews', 1.99, 'Fruity chewy candy', 'not_img.jpg', 12);
INSERT INTO producto (nombre, precio, descripcion, img_path, id_pais) VALUES ('Toffee', 2.49, 'Rich toffee', 'not_img.jpg', 13);
INSERT INTO producto (nombre, precio, descripcion, img_path, id_pais) VALUES ('Jelly Beans', 2.99, 'Assorted jelly beans', 'not_img.jpg', 14);
INSERT INTO producto (nombre, precio, descripcion, img_path, id_pais) VALUES ('Hard Candy', 1.49, 'Hard candy', 'not_img.jpg', 15);
INSERT INTO producto (nombre, precio, descripcion, img_path, id_pais) VALUES ('Licorice', 1.99, 'Sweet licorice', 'not_img.jpg', 16);
INSERT INTO producto (nombre, precio, descripcion, img_path, id_pais) VALUES ('Marshmallow', 1.29, 'Soft marshmallow', 'not_img.jpg', 17);
INSERT INTO producto (nombre, precio, descripcion, img_path, id_pais) VALUES ('Peanut Brittle', 2.49, 'Crunchy peanut brittle', 'not_img.jpg', 18);
INSERT INTO producto (nombre, precio, descripcion, img_path, id_pais) VALUES ('Candy Cane', 0.99, 'Festive candy cane', 'not_img.jpg', 19);
INSERT INTO producto (nombre, precio, descripcion, img_path, id_pais) VALUES ('Chocolate Truffle', 3.99, 'Decadent chocolate truffle', 'not_img.jpg', 20);