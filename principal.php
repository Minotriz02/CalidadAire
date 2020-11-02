<?php

    session_start();
    require 'conexion.php';

    if(!isset($_SESSION['nombre'])){
        header("Location:index.php");
    }

    $sql = "SELECT * FROM registros ORDER BY FECHAHORA_REGISTRO ASC";
    $sql_G = "SELECT * FROM registros WHERE ID_PROCESADORF=1";

  

    $resultado = $mysqli->query($sql);


    $nombre = $_SESSION['nombre'];

    $arreglo = array();
/*
    while ($row = $resultado->fetch_assoc()) {
        echo  $row['PPM'];
    }
    $totalPPM=array();
    $totalfecha=array();

    $query=$mysqli->query($sql_G);
    $row=$query->fetch_array();
*/
 //edita juan diego

 $totalPPMt=array();
$totalfechat=array();

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
    
    $totalfechat=array();
    $totalPPMt=array();
    $id[]=array();
    while ($row = $resultado->fetch_assoc()){
        $totalPPMt[]=$row['PPM'];
        $totalfechat[]=$row['FECHAHORA_REGISTRO'];
        $id[]=$row['ID_PROCESADORF'];
        
 

    }

    for($i=0; $i<sizeof($totalPPMt); $i++){
       
        if($id[$i]==2){
            $dataPPMsensor2=$dataPPMsensor2.','.$totalPPMt[$i];
            echo '<script>';
            echo 'console.log('. json_encode( $id[$i].': '.$totalPPMt[$i] ) .')';
            echo '</script>';
         
        }
        if($id[$i]==3){
            $dataPPMsensor3=$dataPPMsensor3.','.$totalPPMt[$i];
            

            

        }
        if($id[$i]==4){
            $dataPPMsensor4=$dataPPMsensor4.','.$totalPPMt[$i];
            
            

        }
        if($id[$i]==1){
            $dataPPMsensor1=$dataPPMsensor1.','.$totalPPMt[$i];
           
            $datafecha=$datafecha.',"'.$totalfechat[$i].'"';

        }
    }


    //fin juan diego
    /*

    while ($row = $query->fetch_assoc()){
        $totalPPM[]=$row['PPM'];
        $totalfecha[]=$row['FECHAHORA_REGISTRO'];
    }


    $dataPPM=0;
    for ($i=0; $i<sizeof($totalPPM); $i++){
        $dataPPM=$dataPPM.','.$totalPPM[$i];
        $datafecha=$datafecha.',"'.$totalfecha[$i].'"';
    }
    */
    $resultado = $mysqli->query($sql);


?>


<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Sistema Calidad de Aire</title>
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
                        <h1 class="mt-4">Dashboard</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item active">Dashboard</li>
                        </ol>
                        
                        <div class="row">
                            <div class="col-xl-12">
                                <div class="card mb-4">
                                    <div class="card-header">
                                        <i class="fas fa-chart-area mr-1"></i>
                                        Grafico PPM
                                    </div>
                                    <div class="card-body"><canvas id="myLineChart" width="100%" height="40"></canvas></div>
                                </div>
                            </div>
                            
                        </div>
                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-table mr-1"></i>
                                Tabla de los registros
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
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
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
        <script src="assets/demo/chart-area-demo.js"></script>
        <script src="assets/demo/chart-bar-demo.js"></script>
        <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>
        <script src="assets/demo/datatables-demo.js"></script>
        
        <script>

var ctx = document.getElementById('myLineChart').getContext('2d');
            var chart = new Chart(ctx, {
                // The type of chart we want to create
                type: 'line',

                // The data for our dataset
                data: {
                    labels: [<?php echo $datafecha; ?>],
                    datasets: [{
                        label: 'Sensor #1',
                        //backgroundColor: 'rgb(255, 99, 132)',
                        borderColor: 'rgb(255, 99, 132)',
                        data: [<?php echo $dataPPMsensor1; ?>]
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

                    },
                    ]
                },

                // Configuration options go here
                options: {}
            });
        </script>
    </body>
</html>
