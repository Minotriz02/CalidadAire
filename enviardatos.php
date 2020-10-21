<!DOCTYPE html>
<html lang="eng">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Calidad Aire</title>
</head>
<body>
    <div id="calidadAire">
        <?php
            $id = $_POST['idProcesador'];
            $ppm = $_POST['PPM'];
            $cal = $_POST['Calidad'];

            echo "La id del dispositivo asociado es: ".$id." <br>Las PPM son: ".$ppm;

            $usuario = "root";
            $contrasena = "";
            $servidor = "localhost";
            $basededatos = "proyectocf";

            $conexion = mysqli_connect( $servidor, $usuario, "" ) or die ("No se ha podido conectar al servidor de Base de datos");
            $db = mysqli_select_db( $conexion, $basededatos ) or die ( "No se ha podido seleccionar la base de datos" );

            $consulta = "INSERT INTO registros(ID_PROCESADORF, CALIDAD_AIRE, PPM) 
                            VALUES ($id,'$cal',$ppm)";

            $resultado = mysqli_query( $conexion, $consulta );
        ?>
</body>
</html>
