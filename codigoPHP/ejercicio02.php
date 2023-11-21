<!DOCTYPE html>
<!--
    Descripción: CodigoEjercicio1PDO
    Autor: Borja Nuñez Refoyo
    Fecha de creación/modificación: 12/11/2023
-->
<html lang="es">
<head>
    <title>ejercicio02</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>
    <header class="text-center">
        <h1>2. Mostrar el contenido de la tabla Departamento y el número de registros.</h1>
    </header>
    <main>
         <?php
         /**
            * @author Borja Nuñez Refoyo
            * @version 1.1 
            * @since 12/11/2023
         */
            $dsn = 'mysql:host=192.168.20.19;dbname=DB207DWESProyectoTema4';
            $username = 'user207DWESProyectoTema4';
            $password = 'paso';
            
        try {
            echo '<h2>Con Query</h2>';
            //Crear una conexión PDO
            $miDB = new PDO($dsn, $username, $password);
            //Ejecutamos una query en la tabla Departamento.
            $resultadoDepartamentos = $miDB->query("select * from T02_Departamento;");
            //Cargamos los resultados mediante fetch(PDO::FETCH_OBJ).
            $oDepartamento = $resultadoDepartamentos->fetchObject();
            //Creamos una tabla para mostrar los resultados
            echo "<table border=1><tr><th>CodigoDepartamento</th><th>DescripcionDepartamento</th><th>FechaCreacionDepartamento</th><th>VolumenDeNegocio</th><th>FechaBajaDepartamento</th></tr><tbody>";
            while ($oDepartamento != null) {
                echo "<tr>";
                //Recorrido de la fila cargada
                echo "<td>$oDepartamento->T02_CodDepartamento</td>"; //Obtener los códigos.
                echo "<td>$oDepartamento->T02_DescDepartamento</td>"; //Obtener las descripciones.
                echo "<td>$oDepartamento->T02_FechaCreacionDepartamento</td>"; //Obtener la fecha de creacion.
                echo "<td>$oDepartamento->T02_VolumenDeNegocio</td>"; //Obtener el volumen de negocio. 
                echo "<td>$oDepartamento->T02_FechaBajaDepartamento</td>"; //Obtener la fecja de baja.
                echo "</tr>";
                $oDepartamento = $resultadoDepartamentos->fetchObject();
            }
            echo "</tbody></table>";
            //Mostrar el numero de registros mediante rowCount()
            printf("<h3>Número de registros: %s</h3><br>", $resultadoDepartamentos->rowCount());
            //Mediante PDOException mostramos un mensaje de error cuando salte la exception
        } catch (PDOException $excepcion) {
            echo 'Error: ' . $excepcion->getMessage() . "<br>";
            echo 'Código de error: ' . $excepcion->getCode() . "<br>";
        }
        //Mediante unset cerramos la sesion de la base de datos
        unset($miDB);
         ?>
    <footer>
        <a title="Inicio" href="../indexProyectoTema4.html"><img src="../webroot/images/casa.png" width="40" height="40" alt="Inicio"/></a>
        <a title="GitHub" href="https://github.com/BorjaNR" target="blank"><img src="../webroot/images/git.png" width="40" height="40" alt="GitHub"/></a>
        <div>
            <a>2023-24 IES los Sauces. @Todos los derechos reservados. Borja Nuñez Refoyo</a>
        </div>
    </footer>
</body>
</html>

