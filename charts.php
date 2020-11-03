<?php
    session_start();
    require 'conexion.php';

    if(!isset($_SESSION['nombre'])){
        header("Location:index.php");
    }

    $sql1 = "SELECT * FROM registros";
    $resultado = $mysqli->query($sql1);

    $nombre = $_SESSION['nombre'];
//--------------------------------------Grafica-----------------------------------//
    $arreglo = array();

    if($_POST){
        $fechamin = $_POST['min'];
        $fechamax= $_POST['max'];
        $sqllocal= "";
        $local = 0;

        if(!empty($_POST['sensor'])) {
            $step = 0;
            $local = 1;
            // Bucle para almacenar y visualizar valores activados checkbox.
            foreach($_POST['sensor'] as $seleccion) {
                if($step==0){
                    $sqllocal = $sqllocal." ID_PROCESADORF = $seleccion ";
                }else{
                    $sqllocal = $sqllocal." OR ID_PROCESADORF = $seleccion ";
                }
                $step ++;
            }
        }
        
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
        // SELECT * FROM registros WHERE ID_PROCESADORF = 1 OR ID_PROCESADORF = 2

        if(strlen($fechamin)>0 && strlen($fechamax)>0 && !$local==0){
            $sql = "SELECT * FROM registros WHERE FECHAHORA_REGISTRO BETWEEN '$fechamin' and  '$fechamax' AND".$sqllocal;
        }
        if(strlen($fechamin)>0 && strlen($fechamax)==0 && !$local==0){
            $sql = "SELECT * FROM registros WHERE FECHAHORA_REGISTRO > '$fechamin' AND".$sqllocal;
        }
        if(strlen($fechamin)==0 && strlen($fechamax)>0 && !$local==0){
            $sql = "SELECT * FROM registros WHERE FECHAHORA_REGISTRO < '$fechamax' AND".$sqllocal;
        }
        if(strlen($fechamin)==0 && strlen($fechamax)==0 && !$local==0){
            $sql = "SELECT * FROM registros WHERE ".$sqllocal;
        }
        echo $sql;
        $resultado = $mysqli->query($sql);

    }else {
        $sql = "SELECT * FROM registros";
    }

    while ($row = $resultado->fetch_assoc()) {
        $row['PPM'];
    }
    $totalPPM=array();
    $totalfecha=array();

    $query=$mysqli->query($sql);
    $row=$query->fetch_array();

    while ($row = $query->fetch_assoc()){
        $totalPPM[]=$row['PPM'];
        $totalfecha[]=$row['FECHAHORA_REGISTRO'];
        $id[]=$row['ID_PROCESADORF'];
    }
    
    $dataPPM=0;

    ///tabres
    
    
    
    $dataPPMsensor2=0;
    $dataPPMsensor3=0;
    $dataPPMsensor4=0;
    $dataPPMsensor1=0;
    
    $fechaPPMsensor2=0;
    $fechaPPMsensor3=0;
    $fechaPPMsensor4=0;
    $fechaPPMsensor1=0;
    $datafecha="";
    
        //$queryt=$mysqli->query($sql);
        //$row=$queryt->fetch_array();
        

    //

    for ($i=0; $i<sizeof($totalPPM); $i++){
        
        $dataPPM=$dataPPM.','.$totalPPM[$i];
        
        $datafecha=$datafecha.',"'.$totalfecha[$i].'"';
        if($id[$i]==2){
            $dataPPMsensor2=$dataPPMsensor2.','.$totalPPM[$i];
            echo '<script>';
            echo 'console.log('. json_encode( $id[$i].': '.$totalPPM[$i] ) .')';
            echo '</script>';
         
        }
        if($id[$i]==3){
            $dataPPMsensor3=$dataPPMsensor3.','.$totalPPM[$i];
            

            

        }
        if($id[$i]==4){
            $dataPPMsensor4=$dataPPMsensor4.','.$totalPPM[$i];
            
            

        }
        if($id[$i]==1){
            $dataPPMsensor1=$dataPPMsensor1.','.$totalPPM[$i];
           
            

        }
    }
    
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Graficas</title>
        <link href="css/styles.css" rel="stylesheet" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/js/all.min.js" crossorigin="anonymous"></script>
        
    </head>
    <body class="sb-nav-fixed" onload="CargarDatos();">
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
                        <h1 class="mt-4">Graficas</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item"><a href="principal.php">Dashboard</a></li>
                            <li class="breadcrumb-item active">Graficas</li>
                        </ol>
    
                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-chart-area mr-1"></i>
                                Grafica PPM
                                <tbody><form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                                        <tr>
                                            <th>Fecha y hora minima:</th>
                                            <th><input type="text" id="min" name="min" placeholder="y-m-d ej: 2020-12-25"></th>
                                        </tr>
                                        <tr>
                                            <th>Fecha y hora maxima:</th>
                                            <th><input type="text" id="max" name="max" placeholder="y-m-d ej: 2020-12-25"></th>
                                        </tr>
                                        <tr>
                                            <button type="submit" class="btn btn-primary">Aplicar filtro</button><br><br>
                                        </tr>
                                        <tr>    
                                            <th>
                                                ¿Que localizaciones deseas ver? 
                                                <br>
                                                <input type="checkbox" name="sensor[]" value="1"> Parada 1 (Id sensor = 1)<br>  
                                                <input type="checkbox" name="sensor[]" value="2"> Parada 2 (Id sensor = 2)<br>  
                                                <input type="checkbox" name="sensor[]" value="3"> Parada 3 (Id sensor = 3)<br>  
                                                <input type="checkbox" name="sensor[]" value="4"> Parada 4 (Id sensor = 4)<br>  
                                                <input type="checkbox" name="sensor[]" value="5"> Parada 5 (Id sensor = 5)<br>  
                                                <input type="checkbox" name="sensor[]" value="6"> Parada 6 (Id sensor = 6)<br>  
                                                <input type="checkbox" name="sensor[]" value="7"> Parada 7 (Id sensor = 7)<br>  
                                                <input type="checkbox" name="sensor[]" value="8"> Parada 8 (Id sensor = 8)<br>  
                                                <input type="checkbox" name="sensor[]" value="9"> Parada 9 (Id sensor = 9)<br>  
                                                <input type="checkbox" name="sensor[]" value="10"> Parada 10 (Id sensor = 10)<br> 
                                                <br>
                                            </th>
                                        </tr>
                                        </form>
                            </div>
                            <div class="card-body"><canvas id="myLineChart" width="100%" height="30"></canvas></div>
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
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
        <script src="assets/demo/chart-area-demo.js"></script>
        <script src="assets/demo/chart-bar-demo.js"></script>
        <script src="assets/demo/chart-pie-demo.js"></script>
        
        <script>

            var ctx = document.getElementById('myLineChart').getContext('2d');
            var chart = new Chart(ctx, {
                // The type of chart we want to create
                type: 'line',

                // The data for our dataset
                data: {
                    labels: [<?php echo $datafecha; ?>],
                    datasets: [{
                        label: 'Sensor',
                        //backgroundColor: 'rgb(255, 99, 132)',
                        borderColor: 'rgb(255, 99, 132)',
                        data: [<?php echo $dataPPM; ?>]
                    },
                    {
                        label: 'Sensor #2',
                        //backgroundColor: 'rgb(255, 99, 132)',
                        borderColor: 'rgb(10, 20, 255)',
                        data: [<?php echo $dataPPMsensor2; ?>]

                    },
                    {
                        label: 'Sensor #3',
                        //backgroundColor: 'rgb(255, 99, 132)',
                        borderColor: 'rgb(10, 255, 10)',
                        data: [<?php echo $dataPPMsensor3; ?>]

                    },
                    {
                        label: 'Sensor #4',
                        //backgroundColor: 'rgb(255, 99, 132)',
                        borderColor: 'rgb(244, 70, 17)',
                        data: [<?php echo $dataPPMsensor4; ?>]

                    },]
                },

                // Configuration options go here
                options: {}
            });
        </script>
    </body>
</html>
