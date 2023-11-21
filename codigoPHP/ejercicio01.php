<!DOCTYPE html>
<!--
    Descripción: CodigoEjercicio1PDO
    Autor: Borja Nuñez Refoyo
    Fecha de creación/modificación: 12/11/2023
-->
<html lang="es">
<head>
    <title>ejercicio01</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>
    <header class="text-center">
        <h1>1. Conexión a la base de datos con la cuenta usuario y tratamiento de errores:</h1>
    </header>
    <main>
        <h2>CONEXION POR MEDIO DE PDO:</h2>
         <?php
            /**
            * @author Borja Nuñez Refoyo
            * @version 1.1 
            * @since 12/11/2023
            */
            define('HOST','192.168.20.19'); // Nombre del servidor de la base de datos
            define('DBNAME','DB207DWESProyectoTema4'); // Nombre de la base de datos
            define('USERNAME','user207DWESProyectoTema4'); // Nombre de usuario de la base de datos
            define('PASSWORD','paso'); // Contraseña de la base de datos
            // La variable $attributes almacena los artibutos que se pueden mostrar de una base de datos
            // No se incluyen "PERSISTENT", "PREFETCH" y "TIMEOUT" 
            $attributesPDO = ["AUTOCOMMIT", 
                "ERRMODE", 
                "CASE", 
                "CLIENT_VERSION", 
                "CONNECTION_STATUS",
                "ORACLE_NULLS", 
                "SERVER_INFO", 
                "SERVER_VERSION"];
            // Utilizamos el bloque 'try'
                try {
                // Establecemos la conexión por medio de PDO
                    $miDB = new PDO('mysql:host='.HOST.';'.DBNAME,USERNAME,PASSWORD);
                    echo ("<div class='fs-4 text'>CONEXIÓN EXITOSA POR PDO</div><br>"); // Mensaje si la conexión es exitosa
                    echo ("<div class='fs-4 text'>ATRIBUTOS PDO:</div><br>");
                    foreach ($attributesPDO as $valor) {
                        echo('PDO::<u>ATTR_'.$valor.'</u> => <b>'.$miDB->getAttribute(constant("PDO::ATTR_$valor"))."</b><br>");
                    }
                } catch (PDOException $pdoEx) { // Si falla el 'try' , msotramos el mensaje seguido del error correspondiente
                    echo ("<div class='fs-4 text'>ERROR DE CONEXIÓN</div> ".$pdoEx->getMessage());
                } 
                unset($miDB); //Para cerrar la conexión
                ?>
                <br><br>
                <h2>CONEXION POR MEDIO DE PDO (FALLIDA):</h2>
                <?php
                    /* Si quisieramos hacer que salte el 'PDOException' , deberemos de poner algún dato erroneo al crear el objeto.
                     * Para ello duplicamos el bloque de código anterior, pero añadiendo un dato erroneo, en este caso podremos mal
                     * el '$host' .
                     */ 
                    // Utilizamos el bloque 'try'
                    try {
                        // Establecemos la conexión por medio de PDO
                        $miDB = new PDO('mysql:host='.HOST.';'.DBNAME,USERNAME,'paso1'); // Aqui ponemos mal la contraseña para buscar el mensaje de error
                        echo ("<div class='fs-4 text'>CONEXIÓN EXITOSA POR PDO</div><br>"); // Mensaje si la conexión es exitosa
                        foreach ($attributesPDO as $valor) {
                            echo('PDO::<u>ATTR_'.$valor.'</u> => <b>'.$miDB->getAttribute(constant("PDO::ATTR_$valor"))."</b><br>");
                        }
                    } catch (PDOException $pdoEx) { // Si falla el 'try' , msotramos el mensaje seguido del error correspondiente
                        echo ("<div class='fs-4 text'>ERROR DE CONEXIÓN</div> ".$pdoEx->getMessage());
                    }
                    unset($miDB); //Para cerrar la conexión
                    ?>
    </main>
    <footer>
        <a title="Inicio" href="../indexProyectoTema4.html"><img src="../webroot/images/casa.png" width="40" height="40" alt="Inicio"/></a>
        <a title="GitHub" href="https://github.com/BorjaNR" target="blank"><img src="../webroot/images/git.png" width="40" height="40" alt="GitHub"/></a>
        <div>
            <a>2023-24 IES los Sauces. @Todos los derechos reservados. Borja Nuñez Refoyo</a>
        </div>
    </footer>
</body>

</html>

