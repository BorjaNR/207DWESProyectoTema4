<!DOCTYPE html>
<!--
    Descripción: CodigoEjercicio1PDO
    Autor: Borja Nuñez Refoyo
    Fecha de creación/modificación: 12/11/2023
-->
<html lang="es">
<head>
    <title>ejercicio03</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
            h1{
                text-align: center;
            }
            fieldset{
                margin: auto;
                width: 500px;
                padding: 20px;
                text-align: center;
                border:solid black 1px;
                border-radius: 5px;
                background: #eff3ff;
            }
            footer{
                position: absolute;
                bottom: 0;
            }
            input{
                margin-bottom: 5px;
                width: 200px;
                height: 20px;
            }
            fieldset:nth-child(1) label{
                display: inline-block;
                width: 250px;  
            }
            fieldset input:nth-of-type(1){
                background: #ffffcc;
                border: solid grey 1px;
                border-radius: 2px;
            }
            fieldset input:nth-of-type(4){
                background: #ffffcc;
                border: solid grey 1px;
                border-radius: 2px;
                height: 100px;
            }
    </style>
</head>

<body>
    <header class="text-center">
        <h1>3. Formulario para añadir un departamento a la tabla Departamento con validación de entrada y control de errores.</h1>
    </header>
    <main>
         <?php
         /**
            * @author Borja Nuñez Refoyo
            * @version 1.1 
            * @since 14/11/2023
         */
            require_once '../core/231018libreriaValidacion.php';
         
            $dsn = 'mysql:host=192.168.20.19;dbname=DB207DWESProyectoTema4';
            $username = 'user207DWESProyectoTema4';
            $password = 'paso';
            //Es un interruptor que sirve para controlar que este too bien rellenado en el formulario
            $entradaOK = true;
            //Este array almacena los valores de los inputs que se encuentran en el formulario
            $aRespuestas=[
                'codDepartamento'=>"",
                'descDepartamento'=>"",
                'fechaCreacionDepartamento'=>"now()",
                'volumenNegocio'=>"",
                'fechaBaja'=>"null"
            ];
            //Almacena de los valores que se han introducido mal en los inputs(No se añade ninguna de las fechas porque no se validan ya que tienen un valor puesto po defecto)
            $aErrores=[
                'codDepartamento'=>"",
                'descDepartamento'=>"",
                'volumenNegocio'=>""
            ];
            //Cuando el formulario se ha rellenado se valida la entrada a ver que esta mal y que bien
            if(isset($_REQUEST['enviar'])){
                //Se valida que el valor introducido en codDepartamento sea un valir alfabetico con una longitud de 3 caracteres y si no lo es se añade un mensaje de error al aErrores
                $aErrores['codDepartamento']= validacionFormularios::comprobarAlfabetico($_REQUEST['codDepartamento'],3,3,1);
                //Se comprueba que el codDepartamento no exista en la base de datos
                if($aErrores['codDepartamento']==null){
                    try{
                        //Se instancia una conexion PDO hacia la base de datos selecionada
                        $miDB = new PDO($dsn,$username,$password);
                        //Se configuran las excepciones
                        $miDB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                        //Se hace la consulta preparada que filtra los epartamentos por codigo
                        $consultaPorCodigo = $miDB->prepare('SELECT * FROM T02_Departamento WHERE T02_CodDepartamento = "'.$_REQUEST['codDepartamento'].'";');
                        //Ejecutamos la query 
                        $consultaPorCodigo->execute();
                        //Si la consulta devuelve alguna fila añadimos un error al array errores
                        if($consultaPorCodigo->rowCount()>0){
                            $aErrores['codDepartamento'] = "Ese código de departamento ya existe";
                        }
                    } catch (PDOException $miExcepcionPDO) {
                        echo $miExcepcionPDO->getCode();
                        echo $miExcepcionPDO->getMessage();
                    } finally {
                        //Mediante unset cerramos la sesion de la base de datos
                        unset($miDB);
                    }
                }
                //Se valida que el valor introducido en descDepartamento sea un valir alfabetico con una longitud de 255 caracteres y si no lo es se añade un mensaje de error al aErrores
                $aErrores['descDepartamento']= validacionFormularios::comprobarAlfabetico($_REQUEST['descDepartamento'],255,1,1);
            }
         ?>
    <footer>
        <a title="Inicio" href="../../index.html"><img src="../webroot/images/casa.png" width="40" height="40" alt="Inicio"/></a>
        <a title="GitHub" href="https://github.com/BorjaNR" target="blank"><img src="../webroot/images/git.png" width="40" height="40" alt="GitHub"/></a>
        <div>
            <a>2023-24 IES los Sauces. @Todos los derechos reservados. Borja Nuñez Refoyo</a>
        </div>
    </footer>
</body>
</html>

