<!DOCTYPE html>
<html>
    <head>
        <title>ejercicio08</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../webroot/css/main.css"/>
    </head>
    <body>
        <header class="text-center bg-secondary text-white" style="height: 75px">
            <h3>8. Página web que toma datos de la tabla T02_Departamento y guarda en un fichero departamento.json. El fichero exportado se encuentra en el directorio .../tmp/ del 
                servidor.</h3>
        </header>
        <main style="margin-bottom: 75px" class="fs-5 text-center">
            <?php
            /**
             * @author Borja Nuñez Refoyo
             * @version 2.0 
             * @since 04/04/2024
             */
            //Incluimos el archivo de configuración de la conexión a la base de datos
            require_once '../config/confDBPDO.php';

            try {
                // CONEXION CON LA BD
                /**
                 * Establecemos la conexión por medio de PDO
                 * DSN -> IP del servidor y Nombre de la base de datos
                 * USER -> Usuario con el que se conecta a la base de datos
                 * PASSWORD -> Contraseña del usuario
                 * */
                $miDB = new PDO(DSN, USERNAME, PASSWORD);

                //Preparamos la consulta que previamente vamos a ejecutar
                $resultadoConsulta = $miDB->prepare('SELECT * FROM T02_Departamento');

                //Ejecutamos la consulta
                $resultadoConsulta->execute();

                //Mostramos el numero de registros que hemos seleccionado el metodo rowCount() devuelve el numero de filas que tiene la consulta

                $numRegistros = $resultadoConsulta->rowCount();

                //Mediante echo mostranmos la variable que almacena el numero de registros
                echo ('Numero de registros: ' . $numRegistros);

                //Guardo el primer registro como un objeto
                $oResultado = $resultadoConsulta->fetchObject();

                // Inicializamos un array vacío para almacenar todos los departamentos
                $aDepartamentos = [];

                //Inicializamos el contador
                $numeroDepartamento = 0;
                /**
                 * Recorro los registros que devuelve la consulta y obtengo por cada valor su resultado
                 */
                while ($oResultado) {
                    //Guardamos los valores en un array asociativo
                    $aDepartamento = [
                        'codDepartamento' => $oResultado->T02_CodDepartamento,
                        'descDepartamento' => $oResultado->T02_DescDepartamento,
                        'fechaCreacionDepartamento' => $oResultado->T02_FechaCreacionDepartamento,
                        'volumenNegocio' => $oResultado->T02_VolumenDeNegocio,
                        'fechaBajaDepartamento' => $oResultado->T02_FechaBajaDepartamento
                    ];

                    // Añadimos el array $aDepartamento al array $aDepartamentos
                    $aDepartamentos[] = $aDepartamento;

                    //Incremento el contador de departamentos para almacenar informacion el la siguiente posicion        
                    $numeroDepartamento++;

                    //Guardo el registro actual y avanzo el puntero al siguiente registro que obtengo de la consulta
                    $oResultado = $resultadoConsulta->fetchObject();
                }


                /**
                 * La funcion json_encode devuelve un string con la representacion JSON
                 * Le pasamos el array aDepartamentos y utilizanos el atributo JSON_PRRETY_PRINT para que use espacios en blanco para formatear los datos devueltos.
                 */
                $json = json_encode($aDepartamentos, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

                /**
                 * Mediante la funcion file_put_contents() podremos escribir informacion en un fichero
                 * Pasandole como parametros la ruta donde queresmos que se guarde y el que queremos sobrescribir
                 * JSON_UNESCAPED_UNICODE: Codifica caracteres Unicode multibyte literalmente
                 */
                // Ruta del archivo JSON
                $rutaArchivoJSON = "../tmp/departamentos.json";

                // Verifica si el directorio existe, si no, créalo
                if (!file_exists("../tmp/")) {
                    mkdir("../tmp/", 0777, true);
                }

                // Intenta escribir en el archivo
                if (file_put_contents($rutaArchivoJSON, $json) !== false) {
                    echo "<br><span style='color: green'>Exportado correctamente</span>";
                } else {
                    echo "<br><span style='color: red'>Error al exportar el archivo</span>";
                }
                //Controlamos las excepciones mediante la clase PDOException
            } catch (PDOException $pdoe) {
                $miDB->rollBack();
                echo ('<p style="color:red">EXCEPCION PDO</p>' . $pdoe->getMessage());
            } finally {
                // El metodo unset sirve para cerrar la sesion con la base de datos
                unset($miDB);
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
