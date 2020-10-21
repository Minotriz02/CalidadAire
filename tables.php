<?php
    session_start();
    require 'conexion.php';

    if(!isset($_SESSION['nombre'])){
        header("Location:index.php");
    }

    

    $nombre = $_SESSION['nombre'];
    
    $sql = "SELECT * FROM registros";
    $resultado = $mysqli->query($sql);

    if($_POST){
        $fechamin = $_POST['min'];
        $fechamax= $_POST['max'];
        $local = $_POST['sensor'];
        
        if(strlen($fechamin)>0 && strlen($fechamax)>0 && $local==0){
            $sql = "SELECT * FROM registros WHERE FECHAHORA_REGISTRO BETWEEN '$fechamin' and  '$fechamax'";
        }
        if(strlen($fechamin)>0 && strlen($fechamax)==0 && $local==0){
            $sql = "SELECT * FROM registros WHERE FECHAHORA_REGISTRO > '$fechamin'";
        }
        if(strlen($fechamin)==0 && strlen($fechamax)>0 && $local==0){
            $sql = "SELECT * FROM registros WHERE FECHAHORA_REGISTRO < '$fechamax'";
        }
        if(strlen($fechamin)==0 && strlen($fechamax)==0 && $local==0){
            $sql = "SELECT * FROM registros";
        }
        

        if(strlen($fechamin)>0 && strlen($fechamax)>0 && !$local==0){
            $sql = "SELECT * FROM registros WHERE FECHAHORA_REGISTRO BETWEEN '$fechamin' and  '$fechamax' AND ID_PROCESADORF ='$local'";
        }
        if(strlen($fechamin)>0 && strlen($fechamax)==0 && !$local==0){
            $sql = "SELECT * FROM registros WHERE FECHAHORA_REGISTRO > '$fechamin' AND ID_PROCESADORF ='$local'";
        }
        if(strlen($fechamin)==0 && strlen($fechamax)>0 && !$local==0){
            $sql = "SELECT * FROM registros WHERE FECHAHORA_REGISTRO < '$fechamax' AND ID_PROCESADORF ='$local'";
        }
        if(strlen($fechamin)==0 && strlen($fechamax)==0 && !$local==0){
            $sql = "SELECT * FROM registros WHERE ID_PROCESADORF ='$local'";
        }
    
        $resultado = $mysqli->query($sql);

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
        <title>Tablas</title>
        <link href="css/styles.css" rel="stylesheet" />
        <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/js/all.min.js" crossorigin="anonymous"></script>
    </head>
    <body class="sb-nav-fixed">
        <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
            <a class="navbar-brand" href="principal.php">Sistema Calidad de Aire</a>
            <button class="btn btn-link btn-sm order-1 order-lg-0" id="sidebarToggle" href="#"><i class="fas fa-bars"></i></button>
            
            <!-- Navbar-->
            <ul class="navbar-nav ml-auto mr-0 mr-md-3 my-2 my-md-0">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="userDropdown" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?php echo $nombre; ?><i class="fas fa-user fa-fw"></i></a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                        <a class="dropdown-item" href="logout.php">Salir</a>
                    </div>
                </li>
            </ul>
        </nav>
        <div id="layoutSidenav">
            <div id="layoutSidenav_nav">
                <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                    <div class="sb-sidenav-menu">
                        <div class="nav">
                            <a class="nav-link" href="principal.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Dashboard
                            </a>
                            <div class="sb-sidenav-menu-heading">Visualizaciones</div>
                            <a class="nav-link" href="charts.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-chart-area"></i></div>
                                Graficas
                            </a>
                            <a class="nav-link" href="tables.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                                Tablas
                            </a>
                        </div>
                    </div>
                    <div class="sb-sidenav-footer">
                        <div class="small">Iniciado como:</div>
                        <?php echo $nombre; ?>
                    </div>
                </nav>
            </div>
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid">
                        <h1 class="mt-4">Tabla</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item"><a href="principal.php">Dashboard</a></li>
                            <li class="breadcrumb-item active">Tables</li>
                        </ol>

                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-table mr-1"></i>
                                Registros
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table  cellspacing="5" cellpadding="5">
                                        <tbody><form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                                        <tr>
                                            <td>Fecha y hora minima:</td>
                                            <td><input type="text" id="min" name="min" placeholder="y-m-d ej: 2020-12-25"></td>
                                            <td>Escoge una localización:
                                            <select id="sensor" name="sensor">
                                                <option value="0" selected >Todas</option>
                                                <option value="1">Parada 1 (Id sensor = 1)</option>
                                                <option value="2">Parada 2 (Id sensor = 2)</option>
                                                <option value="3">Parada 3 (Id sensor = 3)</option>
                                                <option value="4">Parada 4 (Id sensor = 4)</option>
                                                <option value="5">Parada 5 (Id sensor = 5)</option>
                                                <option value="6">Parada 6 (Id sensor = 6)</option>
                                                <option value="7">Parada 7 (Id sensor = 7)</option>
                                                <option value="8">Parada 8 (Id sensor = 8)</option>
                                                <option value="9">Parada 9 (Id sensor = 9)</option>
                                                <option value="10">Parada 10 (Id sensor = 10)</option>
                                            </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Fecha y hora maxima:</td>
                                            <td><input type="text" id="max" name="max" placeholder="y-m-d ej: 2020-12-25"></td>
                                        </tr>
                                        <tr>
                                            
                                            <button type="submit" class="btn btn-primary">Aplicar filtro</button>
                                            
                                        </tr>
                                        </form>
                                    </tbody></table>
                                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>ID Registro</th>
                                                <th>ID Sensor</th>
                                                <th>Calidad del aire</th>
                                                <th>Fecha del registro</th>
                                                <th>PPM</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                <th>ID Registro</th>
                                                <th>ID Sensor</th>
                                                <th>Calidad del aire</th>
                                                <th>Fecha del registro</th>
                                                <th>PPM</th>
                                            </tr>
                                        </tfoot>
                                        <tbody>
                                            <?php while ($row = $resultado->fetch_assoc()) {    ?>
                                                <tr>
                                                    <td><?php  echo $row['ID_REGISTRO'] ?></td>
                                                    <td><?php  echo $row['ID_PROCESADORF'] ?></td>
                                                    <td><?php  echo $row['CALIDAD_AIRE'] ?></td>
                                                    <td><?php  echo $row['FECHAHORA_REGISTRO'] ?></td>
                                                    <td><?php  echo $row['PPM'] ?></td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
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
        <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>
        <script src="assets/demo/datatables-demo.js"></script>
    </body>
</html>
