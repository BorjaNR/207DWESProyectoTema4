<!DOCTYPE html>
<html>
    <head>
        <title>ejercicio02</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../webroot/css/main.css"/>
    </head>
    <body>
        <header class="text-center bg-secondary text-white" style="height: 75px">
            <h3>2. Mostrar el contenido de la tabla Departamento y el número de registros.</h3>
        </header>
        <main style="margin-bottom: 75px" class="fs-5 text-center">
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

                //Preparamos la consulta y la ejecutamos
                $consultaPreparada = $miDB->prepare("SELECT * FROM T02_Departamento");
                $consultaPreparada->execute();
                // Obtener el resultado de la consulta
                $reslutadoConsultaPreparada = $consultaPreparada->get_result();

                // Crear la tabla
                ?>
                <div class="container t-container">
                    <table class="table table-striped table-bordered" style="margin-bottom: 75px;"> 
                        <tr class="table-secondary">
                            <th>Codigo de Departamento</th>
                            <th>Descripcion de Departamento</th>
                            <th>Fecha de Creacion</th>
                            <th>Volumen de Negocio</th>
                            <th>Fecha de Baja</th>
                        </tr>
                        <?php
                        // Recorrer los resultados y mostrarlos en la tabla
                        while ($oDepartamento = $reslutadoConsultaPreparada->fetch_assoc()) {
                            echo '<tr>';
                            echo "<td>" . $oDepartamento['T02_CodDepartamento'] . "</td>";
                            echo "<td>" . $oDepartamento['T02_DescDepartamento'] . "</td>";
                            echo "<td>" . $oDepartamento['T02_FechaCreacionDepartamento'] . "</td>";
                            echo "<td>" . $oDepartamento['T02_VolumenDeNegocio'] . "</td>";
                            echo "<td>" . $oDepartamento['T02_FechaBajaDepartamento'] . "</td>";
                            echo '</tr>';
                        }
                        ?>
                        <tr>
                            <td colspan="5"><?php echo "Numero de registros en la tabla departamentos: " . $reslutadoConsultaPreparada->num_rows; ?></td>
                        </tr>
                    </table>
                </div>
                <?php
                //Si falla la conexión controlaremos la excepción con el catch y mostraremos el mensaje de error
            } catch (mysqli_sql_exception $mse) {
                echo ('<p style="color:red">ERROR DE CONEXIÓN</p>' . $mse->getMessage());
            } finally {
                unset($miDB); //Para cerrar la conexión
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

