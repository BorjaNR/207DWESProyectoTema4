<!DOCTYPE html>
<html>
    <head>
        <title>ejercicio03</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../webroot/css/main.css"/>
    </head>
    <body>
        <header class="text-center bg-secondary text-white" style="height: 75px">
            <h3>3. Formulario para añadir un departamento a la tabla Departamento con validación de entrada y control de errores.</h3>
        </header>
        <main style="margin-bottom: 75px" class="fs-5 text-center">
            <h3>Con consulta preparada</h3>
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
            $aErrores = [
                'codDepartamento' => '',
                'descDepartamento' => '',
                'volumen' => '',
                'bajaDepartamento' => ''
            ];
            //Array donde recogeremos la respuestas correctas (si $entradaOK)
            $aRespuestas = [
                'codDepartamento' => '',
                'descDepartamento' => '',
                'fechaCreacion' => '',
                'volumen' => '',
                'bajaDepartamento' => ''
            ];
            $_REQUEST['fechaCreacion'] = date('Y-m-d H:i:s'); //Inicializamos la fecha actual ya que es un campo desabilitado
            //Cargar valores por defecto en los campos del formulario
            //Para cada campo del formulario: Validar entrada y actuar en consecuencia
            if (isset($_REQUEST['enviar'])) {
                //Valido la entrada de codigo departamento
                $aErrores['codDepartamento'] = validacionFormularios::comprobarAlfabetico($_REQUEST['codDepartamento'], 3, 3, 1);
                
                // Ahora validamos que el codigo introducido no exista en la BD, haciendo una consulta 
                if ($aErrores['codDepartamento'] == null){
                    try{
                        //Intentamos establecer la conexión con la base de datos
                        $miDB = new PDO(DSN, USERNAME, PASSWORD);
                         // Configuramos las excepciones
                        $miDB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                        // En esta línea utilizo 'quote()' se utiliza para escapar y citar el valor del $_REQUEST['codDepartamento'], ayudando a prevenir la inyección de SQL.
                        $codDepartamento = $miDB->quote($_REQUEST['codDepartamento']);
                        //Preparamos la consulta y la ejecutamos
                        $consultaDepartamento = $miDB->prepare("SELECT T02_CodDepartamento FROM T02_Departamento WHERE T02_CodDepartamento = $codDepartamento");
                        $consultaDepartamento->execute();                

                        //Comprobación de que exista el departamento y su mensaje personalizado
                        if ($consultaDepartamento->fetchObject()){
                            $aErrores['codDepartamento'] = "Ya existe ese código de departamento";
                        }
                    } catch (PDOException $pdoe) {
                    echo ('<p style="color:red">EXCEPCION PDO</p>' . $pdoe->getMessage());
                    }finally{
                        unset($miDB); //Para cerrar la conexión
                    }
                }
                
                //Validar entrada
                $aErrores['descDepartamento'] = validacionFormularios::comprobarAlfaNumerico($_REQUEST['descDepartamento'], 255, 1, 1); //Valido que sea alfanumerico con un tamaño maximo de 255 y minimo de 1 y que sea obligatorio
                $aErrores['volumen'] = validacionFormularios::comprobarFloat($_REQUEST['volumen'], PHP_FLOAT_MAX, PHP_FLOAT_MIN, 1); //Valido que sea un numero real y obligatorio

                //Recorremos los errores para ver si hay alguno
                foreach ($aErrores as $campo => $error) {
                    if ($error == !null) {
                        $entradaOK = false;
                        //Limpiar campos malos
                        $_REQUEST[$campo] = '';
                    }
                }
            } else {
                $entradaOK = false;
            }

            //Tratamiento del formulario
            if ($entradaOK) {
                //Cargar la variable $aRespuestas y tratamiento de datos OK
                $aRespuestas = [
                    'codDepartamento' => $_REQUEST['codDepartamento'],
                    'descDepartamento' => $_REQUEST['descDepartamento'],
                    'fechaCreacion' => $_REQUEST['fechaCreacion'],
                    'volumen' => $_REQUEST['volumen'],
                ];

                //Recorremos las respuestas y las mostramos
                foreach ($aRespuestas as $campo => $respuesta) {
                    echo "$campo=>$respuesta<br>";
                }
            } else {
                ?>
                <form class="w-40 position-absolute top-50 start-50 translate-middle" name="fomrulario" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                    <div class="mb-3">
                        <label class="form-label">Codigo de Departamento</label>
                        <input type="text" class="form-control bg-warning" name="codDepartamento" value="<?php echo (isset($_REQUEST['codDepartamento']) ? $_REQUEST['codDepartamento'] : ''); ?>">
                        <?php echo (!empty($aErrores["codDepartamento"]) ? '<span style="color: red;">' . $aErrores["codDepartamento"] . '</span>' : ''); //Esto es para mostrar el mensaje de error en color rojo ?>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Descripcion de Departamento</label>
                        <textarea class="form-control bg-warning" rows="3" name="descDepartamento"><?php echo (isset($_REQUEST['descDepartamento']) ? $_REQUEST['descDepartamento'] : ''); ?></textarea>
                        <?php echo (!empty($aErrores["descDepartamento"]) ? '<span style="color: red;">' . $aErrores["descDepartamento"] . '</span>' : ''); //Esto es para mostrar el mensaje de error en color rojo ?>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Fecha de creacion</label>
                        <input id="fechaCreacion" type="text" class="form-control" name="fechaCreacion" placeholder="dd/mm/aaaa" value="<?php echo $_REQUEST['fechaCreacion'] ?>" disabled>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Volumen</label>
                        <input type="text" class="form-control bg-warning" name="volumen" value="<?php echo (isset($_REQUEST['volumen']) ? $_REQUEST['volumen'] : ''); ?>">
                        <?php echo (!empty($aErrores["volumen"]) ? '<span style="color: red;">' . $aErrores["volumen"] . '</span>' : ''); //Esto es para mostrar el mensaje de error en color rojo ?>
                    </div>
                    <input class="btn btn-primary" name="enviar" type="submit" value="Crear">
                </form>
                <?php
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