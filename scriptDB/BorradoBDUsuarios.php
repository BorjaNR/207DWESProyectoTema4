<?php
/**
 * @author Borja Nuñez Refoyos
 * @version 2.0
 * @since 04/04/2024
 * @copyright Todos los derechos reservados Borja Nuñez 
 * 
 * @Annotation Scrip de borrado de la base de datos en Explotación
 * 
 */
try {
    define('DSN', 'mysql:host=db5014806774.hosting-data.io;dbname=dbs12302437'); // Host y nombre de la base de datos
    define('USERNAME', 'dbu2279609'); // Nombre de usuario de la base de datos
    define('PASSWORD', 'daw2_Sauces'); // Contraseña de la base de datos
    // Crear conexión
    $conn = new PDO(DSN, USERNAME, PASSWORD);

    // Eliminamos la tabla T02_Departamento
    $consulta = <<<CONSULTA
            DROP TABLE  dbs12302437.T02_Departamento;
            CONSULTA;
    $consultaPreparada = $conn->prepare($consulta);
    $consultaPreparada->execute();

    echo "<span style='color:green;'>Valores borrados correctamente</span>"; // Mostramos el mensaje si la consulta se a ejecutado correctamente
} catch (PDOException $miExcepcionPDO) {
    $errorExcepcion = $miExcepcionPDO->getCode(); // Almacenamos el código del error de la excepción en la variable '$errorExcepcion'
    $mensajeExcepcion = $miExcepcionPDO->getMessage(); // Almacenamos el mensaje de la excepción en la variable '$mensajeExcepcion'

    echo "<span style='color:red;'>Error: </span>" . $mensajeExcepcion . "<br>"; // Mostramos el mensaje de la excepción
    echo "<span style='color:red;'>Código del error: </span>" . $errorExcepcion; // Mostramos el código de la excepción
    die($miExcepcionPDO);
} finally {
    // Cerrar la conexión
    if (isset($conn)) {
        $conn = null;
    }
}