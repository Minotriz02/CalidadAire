<?php

    require "conexion.php";

    session_start();

    if($_POST){
        $cedula = $_POST['cedula'];
        $contraseña = $_POST['password'];

        $sql = "SELECT CEDULA, NOMBRE, CORREO, CONTRASEÑA FROM funcionarios WHERE CEDULA='$cedula'";
        $resultado = $mysqli->query($sql);
        $num = $resultado->num_rows;

        if($num>0){
            $row = $resultado->fetch_assoc();
            $password_bd = $row['CONTRASEÑA'];

            $pass_c = $contraseña;

            if($password_bd == $pass_c){

                $_SESSION['nombre'] = $row['NOMBRE'];
                $_SESSION['correo'] = $row['CORREO'];

                header("Location: charts.php");

            }else{
                echo "La contraseña no coincide";
            }

        }else{
            echo "No existe usuario";
        }
    }
?>


<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Ingreso</title>
        <link href="css/styles.css" rel="stylesheet" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/js/all.min.js" crossorigin="anonymous"></script>
    </head>
    <body class="bg-primary">
        <div id="layoutAuthentication">
            <div id="layoutAuthentication_content">
                <main>
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-5">
                                <div class="card shadow-lg border-0 rounded-lg mt-5">
                                    <div class="card-header"><h3 class="text-center font-weight-light my-4">Ingresar</h3></div>
                                    <div class="card-body">
                                        <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                                            <div class="form-group">
                                                <label class="small mb-1" for="inputEmailAddress">Cedula</label>
                                                <input class="form-control py-4" id="inputEmailAddress" name="cedula" type="text" placeholder="Ingrese su cedula" />
                                            </div>
                                            <div class="form-group">
                                                <label class="small mb-1" for="inputPassword">Contraseña</label>
                                                <input class="form-control py-4" id="inputPassword" name="password" type="password" placeholder="Ingrese su contraseña" />
                                            </div>
                                         
                                            <div class="form-group d-flex align-items-center justify-content-between mt-4 mb-0">
                                                <button type="submit" class="btn btn-primary">Ingresar</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
            <div id="layoutAuthentication_footer">
                <footer class="py-4 bg-light mt-auto">
                    <div class="container-fluid">
                        <div class="d-flex align-items-center justify-content-between small">
                            <div class="text-muted">Copyright &copy; Dashboard Calidad de Aire 2020</div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
        <script src="https://code.jquery.com/jquery-3.5.1.min.js" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
    </body>
</html>
