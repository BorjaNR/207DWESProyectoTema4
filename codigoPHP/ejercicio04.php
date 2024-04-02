<!DOCTYPE html>
<html>
    <head>
        <title>ejercicio04</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../webroot/css/main.css"/>
    </head>
    <body>
        <header class="text-center bg-secondary text-white" style="height: 75px">
            <h3>4. Formulario de búsqueda de departamentos por descripción (por una parte del campo DescDepartamento, si el usuario no pone nada deben aparecer todos los departamentos).</h3>
        </header>
        <main style="margin-bottom: 75px" class="fs-5 text-center">
            <?php
            /**
             * @author Borja Nuñez Refoyo
             * @version 2.0 
             * @since 21/03/2024
             */
            //Incluimos el archivo de configuración de la conexión a la base de datos
            require_once '../config/confDBPDO.php';
            //Incluimos la libreria de validación de formularios
            require_once '../core/231018libreriaValidacion.php';

            //Creamos e inicializamos las variables imprescindibles para este ejercicio
            $entradaOK = true; //Variable que nos indica que todo va bien
            //Array donde recogemos los mensajes de error
            $aErrores = ['descDepartamento' => ''];
            //Array donde recogeremos la respuestas correctas (si $entradaOK)
            $aRespuestas = ['descDepartamento' => ''];
            //Cargar valores por defecto en los campos del formulario
            //Para cada campo del formulario: Validar entrada y actuar en consecuencia
            if (isset($_REQUEST['enviar'])) {
                //Valido la entrada de descripcion departamento
                $aErrores = [
                    'descDepartamento' => validacionFormularios::comprobarAlfabetico($_REQUEST['descDepartamento'], 255, 1, 0),
                ];
                //Recorremos los errores para ver si hay alguno
                foreach ($aErrores as $campo => $error) {
                    if ($error == !null) {
                        $entradaOK = false;
                        //Limpiar campos malos
                        $_REQUEST[$campo] = '';
                        
                    //Si ha dado un error la respuesta pasa a valer el valor que ha introducido el usuario
                    } else {
                        $aRespuestas['descDepartamento'] = $_REQUEST['descDepartamento'];
                    }
                }
            } else {
                $entradaOK = false;
            }

            //Usamos bloque trycatch
            try {
                //Intentamos establecer la conexión con la base de datos
                $miDB = new PDO(DSN, USERNAME, PASSWORD);
                //Preparamos la consulta        
                $consultaPreparada = $miDB->prepare("SELECT * FROM T02_Departamento WHERE T02_DescDepartamento like'%$aRespuestas[descDepartamento]%';");
                $consultaPreparada->execute();

                //Si no hay ningun departamento con esa descripción mostramos un código de error personalizado usando el array errores
                if ($consultaPreparada->rowCount() == 0) {
                    $aErrores['DescDepartamento'] = "No existen departamentos con esa descripcion";
                }
                //Creamos la tabla
                ?>
                <div class="container t-container  position-absolute top-50 start-50 translate-middle">
                    <table class="table table-striped table-bordered" style="margin-bottom: 75px;"> 
                        <tr class="table-secondary">
                            <th>Codigo de Departamento</th>
                            <th>Descripcion de Departamento</th>
                            <th>Fecha de Creacion</th>
                            <th>Volumen de Negocio</th>
                            <th>Fecha de Baja</th>
                        </tr>
                        <?php
                        /* Aqui recorremos todos los valores de la tabla, columna por columna, usando el parametro 'PDO::FETCH_ASSOC' , 
                         * el cual nos indica que los resultados deben ser devueltos como un array asociativo, donde los nombres de las columnas de 
                         * la tabla se utilizan como claves (keys) en el array. */
                        while ($oDepartamento = $consultaPreparada->fetchObject()) {
                            echo '<tr>';
                            echo "<td>" . $oDepartamento->T02_CodDepartamento . "</td>";
                            echo "<td>" . $oDepartamento->T02_DescDepartamento . "</td>";
                            echo "<td>" . $oDepartamento->T02_FechaCreacionDepartamento . "</td>";
                            echo "<td>" . $oDepartamento->T02_VolumenDeNegocio . "</td>";
                            echo "<td>" . $oDepartamento->T02_FechaBajaDepartamento . "</td>";
                            echo '</tr>';
                        }
                        ?>
                        <tr>
                            <td colspan="5"><?php echo "Numero de registros en la tabla departamentos: " . $consultaPreparada->rowCount(); ?></td>
                        </tr>
                    </table>
                </div>
                <?php
            } catch (PDOException $pdoe) {
                echo ('<p style="color:red">EXCEPCION PDO</p>' . $pdoe->getMessage());
            } finally {
                unset($miDB); //Para cerrar la conexión
            }
            //Tratamiento del formulario
            if ($entradaOK) {

                $aRespuestas = [
                    'descDepartamento' => $_REQUEST['descDepartamento'],
                ];
                //Usamos bloque trycatch
                try {
                    //Intentamos establecer la conexión con la base de datos
                    $miDB = new PDO(DSN, USERNAME, PASSWORD);
                    //Preparamos la consulta        
                    $consultaPreparada = $miDB->prepare("SELECT * FROM T02_Departamento WHERE T02_DescDepartamento like'%$aRespuestas[descDepartamento]%';");
                    $consultaPreparada->execute();

                    //Si no hay ningun departamento con esa descripción mostramos un código de error personalizado usando el array errores
                    if ($consultaPreparada->rowCount() == 0) {
                        $aErrores['DescDepartamento'] = "No existen departamentos con esa descripcion";
                    }
                    //Creamos la tabla
                    ?>
                    <div class="container t-container  position-absolute top-50 start-50 translate-middle">
                        <table class="table table-striped table-bordered" style="margin-bottom: 75px;"> 
                            <tr class="table-secondary">
                                <th>Codigo de Departamento</th>
                                <th>Descripcion de Departamento</th>
                                <th>Fecha de Creacion</th>
                                <th>Volumen de Negocio</th>
                                <th>Fecha de Baja</th>
                            </tr>
                            <?php
                            /* Aqui recorremos todos los valores de la tabla, columna por columna, usando el parametro 'PDO::FETCH_ASSOC' , 
                             * el cual nos indica que los resultados deben ser devueltos como un array asociativo, donde los nombres de las columnas de 
                             * la tabla se utilizan como claves (keys) en el array. */
                            while ($oDepartamento = $consultaPreparada->fetchObject()) {
                                echo '<tr>';
                                echo "<td>" . $oDepartamento->T02_CodDepartamento . "</td>";
                                echo "<td>" . $oDepartamento->T02_DescDepartamento . "</td>";
                                echo "<td>" . $oDepartamento->T02_FechaCreacionDepartamento . "</td>";
                                echo "<td>" . $oDepartamento->T02_VolumenDeNegocio . "</td>";
                                echo "<td>" . $oDepartamento->T02_FechaBajaDepartamento . "</td>";
                                echo '</tr>';
                            }
                            ?>
                            <tr>
                                <td colspan="5"><?php echo "Numero de registros en la tabla departamentos: " . $consultaPreparada->rowCount(); ?></td>
                            </tr>
                        </table>
                    </div>
                    <?php
                } catch (PDOException $pdoe) {
                    echo ('<p style="color:red">EXCEPCION PDO</p>' . $pdoe->getMessage());
                } finally {
                    unset($miDB); //Para cerrar la conexión
                }
            }
            ?>
            <form class="w-10 fixed-top" style="margin:150px" name="fomrulario" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                <div class="container t-container  position-absolute top-50 start-50 translate-middle">
                    <table class="table table-striped"> 
                        <tr>
                            <td colspan="3"><label class="form-label">Descripcion de Departamento</label></td>
                            <td colspan="3"><textarea class="form-control" rows="1" name="descDepartamento"><?php echo (isset($_REQUEST['descDepartamento']) ? $_REQUEST['descDepartamento'] : ''); ?></textarea></td>
                            <td colspan="3"><?php echo (!empty($aErrores["descDepartamento"]) ? '<span style="color: red;">' . $aErrores["descDepartamento"] . '</span>' : ''); //Esto es para mostrar el mensaje de error en color rojo   ?></td>
                            <td colspan="3"><input class="btn btn-primary" rows="1" name="enviar" type="submit" value=Buscar></td>
                        </tr>
                    </table>
                </div>
            </form>
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