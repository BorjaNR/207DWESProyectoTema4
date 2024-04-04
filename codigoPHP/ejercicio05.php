<!DOCTYPE html>
<html>
    <head>
        <title>ejercicio05</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../webroot/css/main.css"/>
    </head>
    <body>
        <header class="text-center bg-secondary text-white" style="height: 75px">
            <h3>5. Pagina web que añade tres registros a nuestra tabla Departamento utilizando tres instrucciones insert y una transacción, de tal forma que se añadan los tres registros o no se añada ninguno.</h3>
        </header>
        <main style="margin-bottom: 75px" class="fs-5 text-center">
            <?php
            /**
             * @author Borja Nuñez Refoyo
             * @version 2.0 
             * @since 01/03/2024
             */
            //Incluimos el archivo de configuración de la conexión a la base de datos
            require_once '../config/confDBPDO.php';

            try {
                //Intentamos establecer la conexión con la base de datos
                $miDB = new PDO(DSN, USERNAME, PASSWORD);
                
                //Comenzamos la transicion
                $miDB->beginTransaction(); 

                // Consultas SQL de inserción 
                $consultaPreparada1 = $miDB->prepare("INSERT INTO T02_Departamento(T02_CodDepartamento, T02_DescDepartamento, T02_FechaCreacionDepartamento, T02_VolumenDeNegocio, T02_FechaBajaDepartamento) VALUES ('AAG', 'Departamento de Cobro', now(), 300, NULL)");
                $consultaPreparada2 = $miDB->prepare("INSERT INTO T02_Departamento(T02_CodDepartamento, T02_DescDepartamento, T02_FechaCreacionDepartamento, T02_VolumenDeNegocio, T02_FechaBajaDepartamento) VALUES ('AAE', 'Departamento de Quejas', now(), 10000, NULL)");
                $consultaPreparada3 = $miDB->prepare("INSERT INTO T02_Departamento(T02_CodDepartamento, T02_DescDepartamento, T02_FechaCreacionDepartamento, T02_VolumenDeNegocio, T02_FechaBajaDepartamento) VALUES ('AAF', 'Departamento de Inmuebles', now(), 30, NULL)");

                //Ejecuto las consultas preparadas
                $consultaPreparada1->execute();
                $consultaPreparada2->execute();
                $consultaPreparada3->execute();
                        
                $miDB->commit(); // Confirma los cambios y los consolida
                echo '<p style="color:green">DATOS INSERTADOS CORRECTAMENTE</p>';
            } catch (PDOException $pdoe) {
                $miDB->rollBack();//Si salta la excepcion se cancelan los cambios actuales de la base de datos
                echo ('<p style="color:red">LOS REGISTROS NO HAN SIDO AÑADIDOS</p>');
                echo $pdoe->getMessage();
            } finally {
                unset($miDB); //Para cerrar la conexión
            }
            try{
            //Intentamos establecer la conexión con la base de datos
            $miDB = new PDO(DSN, USERNAME, PASSWORD);
            // Preparamos y ejecutamos la consulta SQL
            $consultaPreparada = $miDB->prepare("SELECT * FROM T02_Departamento");
            $consultaPreparada->execute();
            ?>
                <div class="container t-container  position-absolute top-50 start-50 translate-middle">
                    <table class="table table-striped table-bordered" style="margin-bottom: 75px;margin-top: 150px;"> 
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