<!DOCTYPE html>
<html>
    <head>
        <title>ejercicio08.1</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../webroot/css/main.css"/>
    </head>
    <body>
        <header class="text-center bg-secondary text-white" style="height: 75px">
            <h3>8.1. Página web que toma datos de la tabla T02_Departamento y guarda en un fichero departamento.xml. El fichero exportado se encuentra en el directorio .../tmp/ del 
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

                /**
                 * Declaracion de la consulta SQL 
                 * En este caso hacemos un select de la tabla Departamanetos
                 */
                $sql1 = 'SELECT * FROM T02_Departamento';

                //Preparamos la consulta que previamente vamos a ejecutar
                $resultadoConsulta = $miDB->prepare($sql1);

                //Ejecutamos la consulta
                $resultadoConsulta->execute();

                /*                 * +
                 * Mostramos el numero de registros que hemos seleccionado
                 * el metodo rowCount() devuelve el numero de filas que tiene la consulta
                 */
                $numRegistros = $resultadoConsulta->rowCount();

                //Mediante echo mostranmos la variable que almacena el numero de registros
                echo ('Numero de registros: ' . $numRegistros);

                /**
                 * Instanciamos el nuevo documento usando el objeto DOMDocument
                 * Le asignamos dos parametros -> Version, Codificacion XML
                 */
                $archivoXML = new DOMDocument("1.0", "utf-8");

                //Le decimos que queremos formatear el codigo poniendo a true la propiedad formatOutput
                $archivoXML->formatOutput = true;

                /*                 * Creo el nodo raiz departamentos del de dependeran los demas
                 * createElement() -> Crea un nuevo nodo elemento
                 * En este caso le pasamos como parametro el nombre del elemento
                 * */
                $nDepartamentos = $archivoXML->createElement('Departamentos');

                /*                 * Introduzco el nodo raiz en el archivo
                 * appenChild() -> Añade un nuevo hijo al final de los hijos
                 */
                $root = $archivoXML->appendChild($nDepartamentos);

                //Guardo el primer registro como un objeto
                $oResultado = $resultadoConsulta->fetchObject();

                /**
                 * Recorro los registros que devuelve la consulta y obtengo por cada valor su resultado
                 */
                while ($oResultado) {
                    //Guardamos los valores en un array asociativo
                    //Creo el nodo departamento para cada uno de ellos
                    $nDepartamento = $root->appendChild($archivoXML->createElement('Departamento'));

                    //Creo el elemento con el nombre CodDepartamento y despues el valor obtenido de la consulta
                    $nDepartamento->appendChild($archivoXML->createElement('CodDepartamento', $oResultado->T02_CodDepartamento));

                    //Creo el elemento con el nombre DescDepartamento y despues el valor obtenido de la consulta
                    $nDepartamento->appendChild($archivoXML->createElement('DescDepartamento', $oResultado->T02_DescDepartamento));

                    //Creo el elemento con el nombre FechaCreacion Departamento y despues el valor obtenido de la consulta
                    $nDepartamento->appendChild($archivoXML->createElement('FechaCreacionDepartamento', $oResultado->T02_FechaCreacionDepartamento));

                    //Creo el elemento con el nombre VolumenNegocio y despues el valor obtenido de la consulta          
                    $nDepartamento->appendChild($archivoXML->createElement('VolumenDeNegocio', $oResultado->T02_VolumenDeNegocio));

                    /**
                     * A la fechaBaja no le soy valor porque por defecto es null.
                     */
                    $nDepartamento->appendChild($archivoXML->createElement('FechaBajaDepartamento'));

                    //Guardo el registro actual y avanzo el puntero al siguiente registro que obtengo de la consulta
                    $oResultado = $resultadoConsulta->fetchObject();
                }

                /**
                 * Guardamos el archivo en la ruta indicada
                 * save() -> Copia el árbol XML interno a un archivo
                 */
                // Verifica si el directorio existe, si no, créalo
                if (!file_exists("../tmp/")) {
                    mkdir("../tmp/", 0777, true);
                }

                // Intenta escribir en el archivo
                if ($archivoXML->save('../tmp/departamentos.xml') !== false) {
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
