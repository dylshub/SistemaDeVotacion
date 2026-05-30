CREATE DATABASE votacion2028;
USE votacion2028;

CREATE TABLE usuarios(
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100),
    correo VARCHAR(100) UNIQUE,
    password VARCHAR(255),
    rol ENUM('admin','votante') DEFAULT 'votante'
);

CREATE TABLE tipos_votacion(
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100)
);

CREATE TABLE partidos(
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100),
    siglas VARCHAR(20),
    logo VARCHAR(255)
);

CREATE TABLE candidatos(
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100),
    foto VARCHAR(255),
    partido_id INT,
    tipo_id INT,
    votos INT DEFAULT 0,
    FOREIGN KEY(partido_id) REFERENCES partidos(id),
    FOREIGN KEY(tipo_id) REFERENCES tipos_votacion(id)
);

CREATE TABLE mesas(
    id INT AUTO_INCREMENT PRIMARY KEY,
    numero_mesa VARCHAR(50),
    ubicacion VARCHAR(255)
);

CREATE TABLE votos(
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT,
    candidato_id INT,
    tipo_id INT,
    fecha TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY(usuario_id) REFERENCES usuarios(id),
    FOREIGN KEY(candidato_id) REFERENCES candidatos(id),
    FOREIGN KEY(tipo_id) REFERENCES tipos_votacion(id)
);

CREATE TABLE auditoria(
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario VARCHAR(100),
    accion TEXT,
    fecha TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO usuarios(nombre,correo,password,rol)
VALUES
('Administrador','admin@votacion.com',MD5('admin123'),'admin'),
('Juan Perez','juan@gmail.com',MD5('1234'),'votante');

INSERT INTO tipos_votacion(nombre)
VALUES
('Presidente'),
('Diputado'),
('Alcalde');

INSERT INTO partidos(nombre,siglas,logo)
VALUES
('Partido Azul','PA',''),
('Partido Verde','PV','');

INSERT INTO candidatos(nombre,foto,partido_id,tipo_id)
VALUES
('Carlos Lopez','',1,1),
('Maria Gonzalez','',2,1),
('Jose Ramirez','',1,2),
('Ana Morales','',2,3);
//diseño de base de datos prueba uno 