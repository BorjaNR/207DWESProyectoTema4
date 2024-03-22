--Eliminar base de datos en caso de que exista
DROP DATABASE IF EXISTS DB207DWESProyectoTema4;

DROP USER IF EXISTS 'user207DWESProyectoTema4'@'%';

--Crear la base de datos
CREATE DATABASE DB207DWESProyectoTema4;

--Utilizar la base de datos recién creada
USE DB207DWESProyectoTema4;

 --Crear la tabla Departamento
CREATE TABLE T02_Departamento (
    T02_CodDepartamento CHAR(3) PRIMARY KEY,
    T02_DescDepartamento VARCHAR(255),
    T02_FechaCreacionDepartamento DATETIME,
    T02_VolumenDeNegocio FLOAT,
    T02_FechaBajaDepartamento DATETIME
)ENGINE=INNODB;

--Creación del usuario de la base de datos
CREATE USER 'user207DWESProyectoTema4'@'%' IDENTIFIED BY 'paso';

--Otorgar permisos al usuario para acceder a la base de datos
GRANT ALL PRIVILEGES ON DB207DWESProyectoTema4.* TO 'user207DWESProyectoTema4'@'%';
                        