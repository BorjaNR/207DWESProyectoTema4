/* 
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Other/SQLTemplate.sql to edit this template
 */
/**
 * Author:  daw2
 * Created: 12 nov 2023
 */
-- Me posiciono en la base de datos
   USE DB207DWESProyectoTema4;

-- Inserto los datos iniciales en la tabla Departamento
    INSERT INTO T02_Departamento (T02_CodDepartamento, T02_DescDepartamento, T02_FechaCreacionDepartamento, T02_VolumenDeNegocio, T02_FechaBajaDepartamento) VALUES
        ('AAA', 'Departamento de Ventas', '2023-11-13 13:06:00', 100000.50, NULL),
        ('AAB', 'Departamento de Marketing', '2023-11-13 13:06:00', 50089.50, NULL),
        ('AAC', 'Departamento de Finanzas', '2022-11-13 13:06:00', 600.50, '2023-11-13 13:06:00');
