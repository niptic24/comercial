<?php session_start();


include('../bdd/conexion.php');
//usuario
$_SESSION['asesor'] =$_GET["asesor"];
$asesorlinea=$_GET["asesor"];
$asesor_semaforo = str_replace(" ", "%20", $asesorlinea);
//utlimo parametro
$urlsinparametros= explode('?', $_SERVER['REQUEST_URI'], 2);
$parametro = $urlsinparametros[1];
$parametro1 = $urlsinparametros[0];

$urlsinparametros= explode('&', $_SERVER['REQUEST_URI'], 2);
$parametro4 = $urlsinparametros[0];

$statement = $conn->prepare("SELECT * FROM usuarios  WHERE username = ? ");
$statement->execute([ $_SESSION['nusuario']]);
$user = $statement 	-> fetchAll(PDO::FETCH_ASSOC);

foreach($user as $usuariob):
	$_SESSION['nombre_usuario']=$usuariob['nombre'];
  $_SESSION['avatar']=$usuariob['avatar'];
	endforeach;

  
//obtemer linea asistente 

$statement = $conn->prepare("SELECT * FROM lineas_asesor  WHERE asesor = ? ");
$statement->execute([$_SESSION['nombre_usuario']]);
$linea = $statement 	-> fetchAll(PDO::FETCH_ASSOC);

foreach($linea as $lineaa):
	$_SESSION['asplin']=$lineaa['asp'];
  $_SESSION['cardiolin']=$lineaa['cardio'];
  $_SESSION['analitica']=$lineaa['analitica'];
  $_SESSION['preanalitica']=$lineaa['preanalitica'];
  $_SESSION['diabeteslin']=$lineaa['diabetes'];
  $_SESSION['endolin']=$lineaa['endovascular'];
  $_SESSION['hosplin']=$lineaa['hospitalaria'];
  $_SESSION['renallin']=$lineaa['renal'];
	endforeach;

//Obtener valor venta global
$stmt = $conn->prepare('SELECT SUM(venta) as totalg FROM preanalitica where asesor =?');
$stmt->execute([$_SESSION['asesor']]);
$row = $stmt->fetch(PDO::FETCH_ASSOC);
$venta_global_preanaliticag = $row['totalg'];

//Obtener valor presupuesto global
$stmtp = $conn->prepare('SELECT SUM(presupuesto) as totalgp FROM preanalitica where asesor =?');
$stmtp->execute([$_SESSION['asesor']]);
$rowp = $stmtp->fetch(PDO::FETCH_ASSOC);
$presupuesto_global_preanaliticag = $rowp['totalgp'];

//Obtener valor venta mensual
//mes
$mes=date("n");
//años
$año=date("Y");
//restar año
$nuevafecha = strtotime ('-1 year' , strtotime($año)); //Se resta un año menos
//mes año anterior
$nuevafecha = date ('Y',$nuevafecha);
$statement = $conn->prepare("SELECT  mes,venta FROM `preanalitica` WHERE `asesor`=? and `ano` =?");
$statement->execute([$_SESSION['asesor'],$nuevafecha]);
$result = $statement 	-> fetchAll(PDO::FETCH_ASSOC);
// Hacemos un bucle con los datos obntenidos
$dataan = array();
foreach ($result as $row) {
	$dataan[] = $row;
}
// Mostramos los datos en formato JSON print json_encode($dataan);

//mes año actual
$statement1 = $conn->prepare("SELECT mes, venta FROM `preanalitica` WHERE `asesor`=? and `ano` =?");
$statement1->execute([$_SESSION['asesor'],$año]);
$result1 = $statement1 	-> fetchAll(PDO::FETCH_ASSOC);
// Hacemos un bucle con los datos obntenidos
$dataac = array();
foreach ($result1 as $row1) {
	$dataac[] = $row1;
}
// Mostramos los datos en formato JSON print json_encode($dataac);

$stmt1 = $conn->prepare('SELECT SUM(venta) as totalm FROM preanalitica where asesor =? and mes=? and ano=?');
$stmt1->execute([$_SESSION['asesor'],$mes,$año]);
$row1 = $stmt1->fetch(PDO::FETCH_ASSOC);
$venta_mensual_preanaliticag = $row1['totalm']; 
 
//Obtener valor presupuesto mensual

$stmtp1 = $conn->prepare('SELECT SUM(presupuesto) as totalpm FROM preanalitica where asesor =? and mes=? and ano=?');
$stmtp1->execute([$_SESSION['asesor'],$mes,$año]);
$rowp1 = $stmtp1->fetch(PDO::FETCH_ASSOC);
$presupuesto_mensual_preanaliticag = $rowp1['totalpm']; 

//obtener grafica venta mensual
$statement = $conn->prepare("SELECT * FROM preanalitica  WHERE asesor = ? and ano = 2022 GROUP BY mes ASC; ");
$statement->execute([ $_SESSION['nusuario']]);
$user = $statement 	-> fetchAll(PDO::FETCH_ASSOC);
$data1 = '';
	$data2 = '';
	$buildingName = '';
while ($row = $user) {

  $data1 = $data1 . '"'. $row['venta'].'",';
  $data2 = $data2 . '"'. $row['preanalitica'] .'",';
  $buildingName = $buildingName . '"'. ucwords($row['building_name']) .'",';
}
$data1 = trim($data1,",");
	$data2 = trim($data2,",");
	$buildingName = trim($buildingName,",");

      //Semaforizacionón mensual

  $porcentajeventabarra = 0;
  if($venta_mensual_preanaliticag != 0 and $presupuesto_mensual_preanaliticag!= 0 ){
    $porcentajeventabarra= round( $venta_mensual_preanaliticag / $presupuesto_mensual_preanaliticag * 100);
  }
$porcentaje1=$presupuesto_mensual_preanaliticag*70/100;
$porcentaje2=$presupuesto_mensual_preanaliticag*95/100;
$porcentaje3=$presupuesto_mensual_preanaliticag*100/100;            
$respuesta = "";
$textom = "";  
 
if ($venta_mensual_preanaliticag < $porcentaje3 ) {
 $respuesta = $porcentaje3 - $venta_mensual_preanaliticag; 
 $textom = "<font color=\"red\">Falta $".$respuesta." para llegar al valor del presupuesto mensual.</font>";
 } else if ($venta_mensual_preanaliticag >= $porcentaje3) {
   $respuesta = $venta_mensual_preanaliticag-$porcentaje3; 
 $textom = "<font color=\"green\">Superaste por $".$respuesta." el valor del presupuesto mensual.</font>";
  }
 
  
  //Semaforizacionón global

  $porcentajeventabarrag = 0;
  if($venta_global_preanaliticag != 0 and $presupuesto_global_preanaliticag!= 0 ){
    $porcentajeventabarrag= round( $venta_global_preanaliticag / $presupuesto_global_preanaliticag* 100);
  }
$porcentajeg1=$presupuesto_global_preanaliticag*70/100;
$porcentajeg2=$presupuesto_global_preanaliticag*95/100;
$porcentajeg3=$presupuesto_global_preanaliticag*100/100;            
$respuestag = "";
$textog = "";  
 
if ($venta_global_preanaliticag < $porcentajeg3 ) {
  $respuestag = $porcentajeg3 - $venta_global_preanaliticag; 
  $textog = "<font color=\"red\">Falta $".$respuestag." para llegar al valor del presupuesto global.</font>";
  } else if ($venta_global_preanaliticag >= $porcentajeg3) {
    $respuestag = $venta_global_preanaliticag-$porcentajeg3; 
  $textog = "<font color=\"green\">Superaste por $".$respuestag." el valor del presupuesto global.</font>";
  } 


   
    ?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>comercial</title>

    <!-- Custom fonts for this template-->
    <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="../css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <?php include 'barra_gerencia.php' ?>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <?php include 'nav_gerencia.php' ?>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Linea DBU Preanalítica</h1>
                       
                    </div>

                    <!-- Content Row -->
                    <div class="row">

                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                            Total de ventas</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                            <?php	echo "$".$venta_global_preanaliticag ;?>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-success shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                            Total de presupuesto</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php	echo "$".$presupuesto_global_preanaliticag ;  ?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-info shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1"> Ventas del mes                                        </div>
                                            <div class="row no-gutters align-items-center">
                                                <div class="col-auto">
                                                    <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800"><?php 	echo "$".$venta_mensual_preanaliticag ?></div>
                                                </div>
                                              
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Pending Requests Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-warning shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                            Presupuesto del mes</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"> <?php echo "$".$presupuesto_mensual_preanaliticag ;?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Content Row -->

                    <div class="row">

                        <!-- Area Chart -->
                        <div class="col-xl-8 col-lg-7">
                            <div class="card shadow mb-4">
                                <!-- Card Header - Dropdown -->
                                <div
                                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">Semaforización</h6>
                                    <div class="dropdown no-arrow">
                                         <!--a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                                        </a>
                                      
                                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                                            aria-labelledby="dropdownMenuLink">
                                            <div class="dropdown-header">Opciones:</div>
                                            <a class="dropdown-item" href="?gv=$total_ventas_linea&gp=$total_presupuesto_linea">Global</a>
                                            <a class="dropdown-item" href="#">Mensual</a>
                                            <div class="dropdown-divider"></div>
                                            <a class="dropdown-item" href="#">Something else here</a>
                                        </div-->
                                    </div>
                                </div>
                                <!-- Card Body -->
                                <div class="card-body">
                                   <!-- <div class="chart-area">
                                        <canvas id="myAreaChart"></canvas>
                                    </div>-->
                                    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
               <!-- <canvas id="speedChart" width="400" height="100"></canvas>-->
        
               El rango de cumplimiento es: <br>
                                
                                <!--Global-->  
                                <?php if( $parametro == 'asesor='.$asesor_semaforo.'&?g=g' and $porcentajeventabarrag >= 95){ 
                      
                      ?>
                    <div class="progress">
                     <div class= "progress-bar progress-bar-striped bg-success progress-bar-animated " role="progressbar" 
                      style="width: <?php echo $porcentajeventabarrag ?>%;" aria-valuenow=" <?php echo $porcentajeventabarrag ?>" 
                      aria-valuemin="0" 
                      aria-valuemax="100"> <?php echo $porcentajeventabarrag."%" ?></div>
                     </div>
                     <?php 
                 echo "<hr />";
                 echo $textog;
                 ?>
                     
                     <?php 
                      }
                        
                      elseif ( $parametro == 'asesor='.$asesor_semaforo.'&?g=g' and $porcentajeventabarrag >70 & $porcentajeventabarrag<95) {
                          ?>     
                          <div class="progress">
                     <div class= "progress-bar progress-bar-striped bg-warning progress-bar-animated" role="progressbar" 
                      style="width: <?php echo $porcentajeventabarrag ?>%;" aria-valuenow=" <?php echo $porcentajeventabarrag ?>" 
                      aria-valuemin="0" 
                      aria-valuemax="100"> <?php echo $porcentajeventabarrag."%" ?></div>
                     </div>   
                     <?php 
                 echo "<hr />";
                 echo $textog;
                 ?>
                                
                       <?php  }elseif($parametro == 'asesor='.$asesor_semaforo.'&?g=g' and $porcentajeventabarrag<=70){
                           ?>
                          <div class="progress">
                     <div class= "progress-bar progress-bar-striped bg-danger progress-bar-animated" role="progressbar" 
                      style="width: <?php echo $porcentajeventabarrag ?>%;" aria-valuenow=" <?php echo $porcentajeventabarrag ?>" 
                      aria-valuemin="0" 
                      aria-valuemax="100"> <?php echo $porcentajeventabarrag."%" ?></div>
                     </div> 
                     <?php 
                 echo "<hr />";
                 echo $textog;
                 ?>   
                        <?php }
                         ?>
               
                 <!--Menaual-->              
                 <?php if( $parametro == 'asesor='.$asesor_semaforo.'&?m=m' and $porcentajeventabarra >= 95){ 
                      
                      ?>
                    <div class="progress">
                     <div class= "progress-bar progress-bar-striped bg-success progress-bar-animated " role="progressbar" 
                      style="width: <?php echo $porcentajeventabarra ?>%;" aria-valuenow=" <?php echo $porcentajeventabarra ?>" 
                      aria-valuemin="0" 
                      aria-valuemax="100"> <?php echo $porcentajeventabarra."%" ?></div>
                     </div>
                     <?php 
                 echo "<hr />";
                 echo $textom;
                 
                 ?>
                     <?php 
                      }
                        
                      elseif ( $parametro == 'asesor='.$asesor_semaforo.'&?m=m' and $porcentajeventabarra >70 & $porcentajeventabarra<95) {
                          ?>     
                          <div class="progress">
                     <div class= "progress-bar progress-bar-striped bg-warning progress-bar-animated" role="progressbar" 
                      style="width: <?php echo $porcentajeventabarra ?>%;" aria-valuenow=" <?php echo $porcentajeventabarra ?>" 
                      aria-valuemin="0" 
                      aria-valuemax="100"> <?php echo $porcentajeventabarra."%" ?></div>
                     </div>  
                     <?php 
                 echo "<hr />";
                 echo $textom;
                 
                 ?> 
                                
                       <?php  }elseif($parametro == 'asesor='.$asesor_semaforo.'&?m=m' and $porcentajeventabarra<=70){
                           ?>
                          <div class="progress">
                     <div class= "progress-bar progress-bar-striped bg-danger progress-bar-animated" role="progressbar" 
                      style="width: <?php echo $porcentajeventabarra ?>%;" aria-valuenow=" <?php echo $porcentajeventabarra ?>" 
                      aria-valuemin="0" 
                      aria-valuemax="100"> <?php echo $porcentajeventabarra."%" ?></div>
                     </div>   
                     <?php 
                 echo "<hr />";
                 echo $textom;
                 
                 ?>
                        <?php }
                         ?>
               
                <br>
                 <i class='fa fa-circle' style='color: red'></i> Te encuentras por debajo del 70% </br>
                  <i class='fa fa-circle' style='color: yellow'></i> Te encuentras por debajo del 95%</br>
                  <i class='fa fa-circle' style='color: green'></i> Superado
              
                                </div>
                                 <!-- Area Chart -->
<div class="col-xl-12 col-lg-7">
    <div class="card shadow mb-4">
        <!-- Card Header - Dropdown -->
        <div
            class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">
            Comparativa Venta Bianual</h6>
            <div class="dropdown no-arrow">
          
             </div>
        </div>
        <!-- Card Body -->
        <div class="card-body">
            
        <script type="text/javascript"
                                        src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.bundle.min.js">
                                    </script>

                                        <canvas id="comparativa"></canvas>
<script>
 var desde=<?php echo json_encode($dataan);?>;
 var labels = []; 
var data = []; 

desde.forEach(function(element) {
  //console.log(element);
  labels.push(element.mes)
  data.push(element.venta)
});
console.log(data)
console.log(labels)

var hasta=<?php echo json_encode($dataac);?>;
var mesv = []; 
var ventaa = []; 

hasta.forEach(function(element1) {
  //console.log(element);
  mesv.push(element1.mes)
  ventaa.push(element1.venta)
});
console.log(mesv)
console.log(ventaa)

const $grafica = document.querySelector("#comparativa");
// Las etiquetas son las que van en el eje X. 

// Podemos tener varios conjuntos de datos
const datosVentas2020 = {
    label: "Ventas por mes - <?php echo $nuevafecha ?>",
    data: data, // La data es un arreglo que debe tener la misma cantidad de valores que la cantidad de etiquetas
    backgroundColor: 'rgba(54, 162, 235, 0.2)', // Color de fondo
    borderColor: 'rgba(54, 162, 235, 1)', // Color del borde
    borderWidth: 1,// Ancho del borde
};
const datosVentas2021 = {
    label: "Ventas por mes -  <?php echo $año ?>",
    data: ventaa, // La data es un arreglo que debe tener la misma cantidad de valores que la cantidad de etiquetas
    backgroundColor: 'rgba(255, 159, 64, 0.2)',// Color de fondo
    borderColor: 'rgba(255, 159, 64, 1)',// Color del borde
    borderWidth: 1,// Ancho del borde
};

new Chart($grafica, {
    type: 'line',// Tipo de gráfica
    data: {
        labels: mesv,
        datasets: [
            datosVentas2020,
            datosVentas2021,
            // Aquí más datos...
        ]
    },
    options: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero: true
                }
            }],
        },
    }
});
</script>
          

        </div>
    </div>
</div>
                                <!--aqui-->
                            </div>
                        </div>

                        <!-- Pie Chart -->
                        <div class="col-xl-4 col-lg-5">
                            <div class="card shadow mb-4">
                                <!-- Card Header - Dropdown -->
                                <div
                                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">Venta vs Presupuesto</h6>
                                    <h6 class="m-0 font-weight-bold text-primary"><?php echo date('M'), ' del ' , $año?></h6>
                                    <div class="dropdown no-arrow">
                                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                                            aria-labelledby="dropdownMenuLink">
                                            <div class="dropdown-header">Opciones:</div>
                                            <?php  


                                                echo "<a class='dropdown-item'href='$parametro4&?g=g'>Global</a>";

                                                echo "<a class='dropdown-item'href='$parametro4&?m=m'>Mensual</a>";

                                            ?>
                                           
                                            <div class="dropdown-divider"></div>
                                            <!--<a class="dropdown-item" href="#">Something else here</a>-->
                                        </div>
                                    </div>
                                </div>
                                <!-- Card Body -->
  
                                <div class="card-body">
                                <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.bundle.min.js"></script>
	
                                <div class="chart-pie pt-4 pb-2">
                                        <canvas id="myPieChart"></canvas>
                                      <?php  
                                    
                                      if($parametro == 'asesor='.$asesor_semaforo.'&?m=m') {
                                       ?>
                                       <h5> <?php echo date('M'), ' del ' , $año?></h5>

                                       <script>// Set new default font family and font color to mimic Bootstrap's default styling
 
Chart.defaults.global.defaultFontFamily = 'Nunito', '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
Chart.defaults.global.defaultFontColor = '#858796';

// Pie Chart Example

var ctx = document.getElementById("myPieChart");
var myPieChart = new Chart(ctx, {
  type: 'bar',
  data: {
    labels: ["Venta", "Presupuesto"],
    datasets: [{
      data: [<?php echo $venta_mensual_preanaliticag ?>,<?php echo $presupuesto_mensual_preanaliticag?>],
      backgroundColor: ['#4e73df', '#1cc88a', '#36b9cc'],
      hoverBackgroundColor: ['#2e59d9', '#17a673', '#2c9faf'],
      hoverBorderColor: "rgba(234, 236, 244, 1)",
    }],
  },
  options: {
    maintainAspectRatio: false,
    tooltips: {
      backgroundColor: "rgb(255,255,255)",
      bodyFontColor: "#858796",
      borderColor: '#dddfeb',
      borderWidth: 1,
      xPadding: 15,
      yPadding: 15,
      displayColors: false,
      caretPadding: 10,
    },
    legend: {
      display: false
    },
    cutoutPercentage: 80,
  },
});</script> 
 <?php } 
 else {
     ?>
     <h5>Ene - <?php echo date('M'), ' del ' , $año?></h5>
   <script>// Set new default font family and font color to mimic Bootstrap's default styling
Chart.defaults.global.defaultFontFamily = 'Nunito', '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
Chart.defaults.global.defaultFontColor = '#858796';

// Pie Chart Example

var ctx = document.getElementById("myPieChart");
var myPieChart = new Chart(ctx, {
  type: 'bar',
  data: {
    labels: ["Venta", "Presupuesto"],
    datasets: [{
      data: [<?php echo $venta_global_preanaliticag ?>,<?php echo $presupuesto_global_preanaliticag ?>],
      backgroundColor: ['#4e73df', '#1cc88a', '#36b9cc'],
      hoverBackgroundColor: ['#2e59d9', '#17a673', '#2c9faf'],
      hoverBorderColor: "rgba(234, 236, 244, 1)",
    }],
  },
  options: {
    maintainAspectRatio: false,
    tooltips: {
      backgroundColor: "rgb(255,255,255)",
      bodyFontColor: "#858796",
      borderColor: '#dddfeb',
      borderWidth: 1,
      xPadding: 15,
      yPadding: 15,
      displayColors: false,
      caretPadding: 10,
    },
    legend: {
      display: false
    },
    cutoutPercentage: 80,
  },
});</script> 
 <?php } ?> 
                                    </div>
                                    <div class="mt-4 text-center small">
                                        
                                        <span class="mr-2">
                                            <i class="fas fa-circle text-success"></i> Presupuesto
                                        </span>
                                        <span class="mr-2">
                                            <i class="fas fa-circle text-info"></i> Venta
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Content Row 
                    <div class="row">-->

                        <!-- Content Column 
                        <div class="col-lg-6 mb-4">-->

                            <!-- Project Card Example 
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Projects</h6>
                                </div>
                                <div class="card-body">
                                    <h4 class="small font-weight-bold">Server Migration <span
                                            class="float-right">20%</span></h4>
                                    <div class="progress mb-4">
                                        <div class="progress-bar bg-danger" role="progressbar" style="width: 20%"
                                            aria-valuenow="20" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <h4 class="small font-weight-bold">Sales Tracking <span
                                            class="float-right">40%</span></h4>
                                    <div class="progress mb-4">
                                        <div class="progress-bar bg-warning" role="progressbar" style="width: 40%"
                                            aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <h4 class="small font-weight-bold">Customer Database <span
                                            class="float-right">60%</span></h4>
                                    <div class="progress mb-4">
                                        <div class="progress-bar" role="progressbar" style="width: 60%"
                                            aria-valuenow="60" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <h4 class="small font-weight-bold">Payout Details <span
                                            class="float-right">80%</span></h4>
                                    <div class="progress mb-4">
                                        <div class="progress-bar bg-info" role="progressbar" style="width: 80%"
                                            aria-valuenow="80" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <h4 class="small font-weight-bold">Account Setup <span
                                            class="float-right">Complete!</span></h4>
                                    <div class="progress">
                                        <div class="progress-bar bg-success" role="progressbar" style="width: 100%"
                                            aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div>-->

                            <!-- Color System 
                            <div class="row">
                                <div class="col-lg-6 mb-4">
                                    <div class="card bg-primary text-white shadow">
                                        <div class="card-body">
                                            Primary
                                            <div class="text-white-50 small">#4e73df</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 mb-4">
                                    <div class="card bg-success text-white shadow">
                                        <div class="card-body">
                                            Success
                                            <div class="text-white-50 small">#1cc88a</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 mb-4">
                                    <div class="card bg-info text-white shadow">
                                        <div class="card-body">
                                            Info
                                            <div class="text-white-50 small">#36b9cc</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 mb-4">
                                    <div class="card bg-warning text-white shadow">
                                        <div class="card-body">
                                            Warning
                                            <div class="text-white-50 small">#f6c23e</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 mb-4">
                                    <div class="card bg-danger text-white shadow">
                                        <div class="card-body">
                                            Danger
                                            <div class="text-white-50 small">#e74a3b</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 mb-4">
                                    <div class="card bg-secondary text-white shadow">
                                        <div class="card-body">
                                            Secondary
                                            <div class="text-white-50 small">#858796</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 mb-4">
                                    <div class="card bg-light text-black shadow">
                                        <div class="card-body">
                                            Light
                                            <div class="text-black-50 small">#f8f9fc</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 mb-4">
                                    <div class="card bg-dark text-white shadow">
                                        <div class="card-body">
                                            Dark
                                            <div class="text-white-50 small">#5a5c69</div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="col-lg-6 mb-4">-->

                            <!-- Illustrations 
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Illustrations</h6>
                                </div>
                                <div class="card-body">
                                    <div class="text-center">
                                        <img class="img-fluid px-3 px-sm-4 mt-3 mb-4" style="width: 25rem;"
                                            src="img/undraw_posting_photo.svg" alt="...">
                                    </div>
                                    <p>Add some quality, svg illustrations to your project courtesy of <a
                                            target="_blank" rel="nofollow" href="https://undraw.co/">unDraw</a>, a
                                        constantly updated collection of beautiful svg images that you can use
                                        completely free and without attribution!</p>
                                    <a target="_blank" rel="nofollow" href="https://undraw.co/">Browse Illustrations on
                                        unDraw &rarr;</a>
                                </div>
                            </div>-->

                            <!-- Approach 
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Development Approach</h6>
                                </div>
                                <div class="card-body">
                                    <p>SB Admin 2 makes extensive use of Bootstrap 4 utility classes in order to reduce
                                        CSS bloat and poor page performance. Custom CSS classes are used to create
                                        custom components and custom utility classes.</p>
                                    <p class="mb-0">Before working with this theme, you should become familiar with the
                                        Bootstrap framework, especially the utility classes.</p>
                                </div>
                            </div>

                        </div>
                    </div>

                </div>-->
                <!-- /.container-fluid 

            </div>-->
            <!-- End of Main Content -->

            <!-- Footer -->
            
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; NIPRO-TICs 2022</span>
                    </div>
                </div>
            
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="../logout.php">Logout</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="../vendor/jquery/jquery.min.js"></script>
    <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="../vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="../js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="../vendor/chart.js/Chart.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="../js/demo/chart-area-demo.js"></script>
    <script src="../js/demo/chart-pie-demo.js"></script>

</body>

</html>