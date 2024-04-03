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
            <h3>Conexion con MySQLi exitosa</h3>
            <?php
            /**
             * @author Borja Nuñez Refoyo
             * @version 2.0 
             * @since 21/03/2024
             */
            //Incluimos el archivo de configuración de la conexión a la base de datos
            require_once '../config/confDBMYSQLI.php';

            //Utilizamos el bloque try catch para intentar la conexión a la base de datos
            try {
                //Intentamos establecer la conexión con la base de datos
                $miDB = new mysqli(DSN, USERNAME, PASSWORD, DBNAME);
                //Si la conexión a sido exitosa mostramos que lo ha sido con un mensaje
                echo '<p style="color:green">CONEXIÓN EXITOSA</p>';
                //Ahora mostraremos la informacion del host
                echo '<p>' . $miDB->host_info . '</p>';
                //Si falla la conexión controlaremos la excepción con el catch y mostraremos el mensaje de error
            } catch (mysqli_sql_exception $mse) {
                echo ('<p style=color:"red">ERROR DE CONEXIÓN</p><br>' . $mse->getMessage());
            } finally {
                if ($miDB && $miDB->connect_errno === 0) {
                    $miDB->close(); // Cerramos la conexión
                }
            }
            
            echo '<h3>Conexion con MySQLi fallida</h3>';
            
            //Utilizamos el bloque try catch para intentar la conexión a la base de datos
            try {
                //Intentamos establecer la conexión con la base de datos
                $miDB = new mysqli(DSN, USERNAME, '1', DBNAME);//Aqui ponemos un dato mal
                //Si la conexión a sido exitosa mostramos que lo ha sido con un mensaje
                echo '<p style="color:green">CONEXIÓN EXITOSA</p>';
                //Si falla la conexión controlaremos la excepción con el catch y mostraremos el mensaje de error
            } catch (mysqli_sql_exception $mse) {
                echo ('<p style="color:red">ERROR DE CONEXIÓN</p>' . $mse->getMessage());
            } finally {
                // Comprobamos si no hay ningun error de conexión con la BD
                if ($miDB && $miDB->connect_errno === 0) {
                    $miDB->close(); // Cerramos la conexión
                }
            }
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

