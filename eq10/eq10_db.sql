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

INSERT INTO categoria (nombre)
VALUES ('Frutas');
INSERT INTO categoria (nombre)
VALUES ('Verduras');
INSERT INTO categoria (nombre)
VALUES ('Carnes');
INSERT INTO categoria (nombre)
VALUES ('Pescados');
INSERT INTO categoria (nombre)
VALUES ('Cereales');
INSERT INTO categoria (nombre)
VALUES ('Frutos secos');
INSERT INTO categoria (nombre)
VALUES ('Aceites');
INSERT INTO categoria (nombre)
VALUES ('Bebidas');
INSERT INTO categoria (nombre)
VALUES ('Especias');
INSERT INTO categoria (nombre)
VALUES ('Salsas');
INSERT INTO categoria (nombre)
VALUES ('Conservas');
INSERT INTO categoria (nombre)
VALUES ('Congelados');
INSERT INTO categoria (nombre)
VALUES ('Snacks');
INSERT INTO categoria (nombre)
VALUES ('Comida rápida');

INSERT INTO producto (nombre, precio, descripcion, id_pais)
VALUES ('Manzana', 1.20, 'Manzana roja fresca', 1);
INSERT INTO producto (nombre, precio, descripcion, id_pais)
VALUES ('Plátano', 0.80, 'Plátano maduro', 2);
INSERT INTO producto (nombre, precio, descripcion, id_pais)
VALUES ('Carne de res', 10.50, 'Carne de res de alta calidad', 3);
INSERT INTO producto (nombre, precio, descripcion, id_pais)
VALUES ('Salmón', 15.00, 'Salmón fresco', 4);
INSERT INTO producto (nombre, precio, descripcion, id_pais)
VALUES ('Arroz', 2.00, 'Arroz blanco', 5);
INSERT INTO producto (nombre, precio, descripcion, id_pais)
VALUES ('Almendras', 12.00, 'Almendras crudas', 6);
INSERT INTO producto (nombre, precio, descripcion, id_pais)
VALUES ('Aceite de oliva', 8.00, 'Aceite de oliva extra virgen', 7);
INSERT INTO producto (nombre, precio, descripcion, id_pais)
VALUES ('Vino tinto', 20.00, 'Vino tinto de alta calidad', 8);
INSERT INTO producto (nombre, precio, descripcion, id_pais)
VALUES ('Pimienta', 3.00, 'Pimienta negra molida', 9);
INSERT INTO producto (nombre, precio, descripcion, id_pais)
VALUES ('Salsa de tomate', 2.50, 'Salsa de tomate casera', 10);
INSERT INTO producto (nombre, precio, descripcion, id_pais)
VALUES ('Atún enlatado', 1.50, 'Atún enlatado en aceite', 11);
INSERT INTO producto (nombre, precio, descripcion, id_pais)
VALUES ('Helado de vainilla', 5.00, 'Helado de vainilla cremoso', 12);
INSERT INTO producto (nombre, precio, descripcion, id_pais)
VALUES ('Patatas fritas', 1.00, 'Patatas fritas crujientes', 13);
INSERT INTO producto (nombre, precio, descripcion, id_pais)
VALUES ('Pizza', 8.00, 'Pizza de pepperoni', 1);
INSERT INTO producto (nombre, precio, descripcion, id_pais)
VALUES ('Cerveza', 2.00, 'Cerveza artesanal', 5);

INSERT INTO producto_categoria (id_producto, id_categoria)
VALUES (1, 1);
INSERT INTO producto_categoria (id_producto, id_categoria)
VALUES (1, 2);
INSERT INTO producto_categoria (id_producto, id_categoria)
VALUES (2, 1);
INSERT INTO producto_categoria (id_producto, id_categoria)
VALUES (3, 3);
INSERT INTO producto_categoria (id_producto, id_categoria)
VALUES (4, 4);
INSERT INTO producto_categoria (id_producto, id_categoria)
VALUES (5, 5);
INSERT INTO producto_categoria (id_producto, id_categoria)
VALUES (6, 6);
INSERT INTO producto_categoria (id_producto, id_categoria)
VALUES (7, 7);
INSERT INTO producto_categoria (id_producto, id_categoria)
VALUES (8, 9);
INSERT INTO producto_categoria (id_producto, id_categoria)
VALUES (9, 10);
INSERT INTO producto_categoria (id_producto, id_categoria)
VALUES (10, 11);
INSERT INTO producto_categoria (id_producto, id_categoria)
VALUES (11, 12);
INSERT INTO producto_categoria (id_producto, id_categoria)
VALUES (12, 13);
INSERT INTO producto_categoria (id_producto, id_categoria)
VALUES (13, 14);