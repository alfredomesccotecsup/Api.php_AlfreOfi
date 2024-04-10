-- Crear la base de datos
CREATE DATABASE IF NOT EXISTS gifdb;

-- Usar la base de datos gifdb
USE gifdb;

-- Crear la tabla gifs
CREATE TABLE IF NOT EXISTS gifs (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    url VARCHAR(255) NOT NULL
);
