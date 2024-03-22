<!DOCTYPE html>
<html>
    <head>
        <title>ejercicio01</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../webroot/css/main.css"/>
    </head>
    <body>
        <header class="text-center bg-secondary text-white" style="height: 75px">
            <h3>1. Conexión a la base de datos con la cuenta usuario y tratamiento de errores.</h3>
        </header>
        <main style="margin-bottom: 75px" class="fs-5">
            <h3>Conexion con PDO exitosa</h3>
            <?php
            /**
             * @author Borja Nuñez Refoyo
             * @version 2.0 
             * @since 21/03/2024
             */
            //Incluimos el archivo de configuración de la conexión a la base de datos
            require_once '../config/confDBPDO.php';

            //Utilizamos el bloque try catch para intentar la conexión a la base de datos
            try {
                //Intentamos establecer la conexión con la base de datos
                $miDB = new PDO(DSN, USERNAME, PASSWORD);
                //Si la conexión a sido exitosa mostramos que lo ha sido con un mensaje
                echo '<p style="color:green">CONEXIÓN EXITOSA</p>';

                //Mostramos todos los atributos
                echo '<p>Atributos: </p><br>';
                echo "PDO::ATTR_AUTOCOMMIT " . $miDB->getAttribute(PDO::ATTR_AUTOCOMMIT) . "<br>";
                echo "PDO::ATTR_ERRMODE " . $miDB->getAttribute(PDO::ATTR_ERRMODE) . "<br>";
                echo "PDO::ATTR_CASE " . $miDB->getAttribute(PDO::ATTR_CASE) . "<br>";
                echo "PDO::ATTR_CLIENT_VERSION " . $miDB->getAttribute(PDO::ATTR_CLIENT_VERSION) . "<br>";
                echo "PDO::ATTR_CONNECTION_STATUS " . $miDB->getAttribute(PDO::ATTR_CONNECTION_STATUS) . "<br>";
                echo "PDO::ATTR_ORACLE_NULLS " . $miDB->getAttribute(PDO::ATTR_ORACLE_NULLS) . "<br>";
                echo "PDO::ATTR_SERVER_INFO " . $miDB->getAttribute(PDO::ATTR_SERVER_INFO) . "<br>";
                echo "PDO::ATTR_SERVER_VERSION " . $miDB->getAttribute(PDO::ATTR_SERVER_VERSION) . "<br>";
                //Si falla la conexión controlaremos la excepción con el catch y mostraremos el mensaje de error
            } catch (PDOException $pdoe) {
                echo ('<p style=color:"red">ERROR DE CONEXIÓN</p><br>' . $pdoe->getMessage());
            }
            unset($miDB); //Para cerrar la conexión
            
            echo '<h3>Conexion con PDO fallida</h3>';
            
            //Utilizamos el bloque try catch para intentar la conexión a la base de datos
            try {
                //Intentamos establecer la conexión con la base de datos
                $miDB = new PDO(DSN, USERNAME, 'l');//Aqui ponemos un dato mal
                //Si la conexión a sido exitosa mostramos que lo ha sido con un mensaje
                echo '<p style="color:green">CONEXIÓN EXITOSA</p>';
                //Si falla la conexión controlaremos la excepción con el catch y mostraremos el mensaje de error
            } catch (PDOException $pdoe) {
                echo ('<p style="color:red">ERROR DE CONEXIÓN</p>' . $pdoe->getMessage());
            }
            unset($miDB); //Para cerrar la conexión
            ?>
            ?>
        </main>
        <footer class="text-center bg-secondary fixed-bottom py-3">
            <div class="container">
                <div class="row">
                    <div class="col text-center text-white">
                        <p>&copy;2023-24 IES los Sauces. Todos los derechos reservados. <a href="../../index.html" style="color: white; text-decoration: none">Borja Nuñez Refoyo</a></p>
                    </div>
                    <div class="col text-end">
                        <a title="Inicio" href="../indexProyectoTema4.html"><img src="../webroot/images/casa.png" width="40" height="40" alt="Inicio"/></a>
                        <a title="GitHub" href="https://github.com/BorjaNR/207DWESProyectoTema4" target="blank"><img src="../webroot/images/git.png" width="40" height="40" alt="GitHub"/></a>
                    </div>
                </div>
            </div>
        </footer>
        <script src="./webroot/js/mainjs.js" ></script>
    </body>
</html>

