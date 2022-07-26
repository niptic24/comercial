<?php session_start();


include('../bdd/conexion.php');
//asesor
$_SESSION['asesor'] =$_GET["asesor"];
$asesorlinea=$_GET["asesor"];
$asesor_semaforo = str_replace(" ", "%20", $asesorlinea);
//utlimo parametro
$urlsinparametros= explode('?', $_SERVER['REQUEST_URI'], 2);
$parametro = $urlsinparametros[1];
$parametro1 = $urlsinparametros[0];

$urlsinparametros= explode('&', $_SERVER['REQUEST_URI'], 2);
$parametro4 = $urlsinparametros[0];

//usuario
$statement = $conn->prepare("SELECT * FROM usuarios  WHERE username = ? ");
$statement->execute([ $_SESSION['nusuario']]);
$user = $statement 	-> fetchAll(PDO::FETCH_ASSOC);

foreach($user as $usuariob):
	$_SESSION['nombre_usuario']=$usuariob['nombre'];
  $_SESSION['avatar']=$usuariob['avatar'];
	endforeach;

   

//obtener linea asistente 

$statement = $conn->prepare("SELECT * FROM lineas_asesor  WHERE asesor = ? ");
$statement->execute([$_GET["asesor"]]);
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

    $stmt1 = $conn->prepare('SELECT SUM(venta) as renaltotal FROM presupuesto where asesor = ?');

    $row =  $stmt1->execute([$_SESSION['asesor']]);
    $renal =  $stmt1 	-> fetchAll(PDO::FETCH_ASSOC); 
    foreach($renal as $renalb):
    
      $_SESSION['renalt']=$renalb['renaltotal'];
      endforeach;
    //cardio
    $stmt2 = $conn->prepare('SELECT SUM(venta) as cardiototal FROM cardio where asesor = ?');
    
    $row =  $stmt2->execute([$_SESSION['asesor']]);
    $cardio =  $stmt2 	-> fetchAll(PDO::FETCH_ASSOC); 
    foreach($cardio as $cardiob):
    
      $_SESSION['cardio']=$cardiob['cardiototal'];
      endforeach;
    
      $stmt3 = $conn->prepare('SELECT SUM(venta) as diabtotal FROM diabetes where asesor = ?');
    
    $row =  $stmt3->execute([$_SESSION['asesor']]);
    $diabetes =  $stmt3 	-> fetchAll(PDO::FETCH_ASSOC); 
    foreach($diabetes as $diabetesb):
    
      $_SESSION['diabetes']=$diabetesb['diabtotal'];
      endforeach;
    //endo
    $stmt4 = $conn->prepare('SELECT SUM(venta) as endototal FROM endo where asesor = ?');
    
    $row =  $stmt4->execute([$_SESSION['asesor']]);
    $endo =  $stmt4 	-> fetchAll(PDO::FETCH_ASSOC); 
    foreach($endo as $endob):
    
      $_SESSION['endo']=$endob['endototal'];
      endforeach;
    //Hospitalaira
    $stmt5 = $conn->prepare('SELECT SUM(venta) as hosptotal FROM hosp where asesor = ?');
    
    $row =  $stmt5->execute([$_SESSION['asesor']]);
    $hosp =  $stmt5 	-> fetchAll(PDO::FETCH_ASSOC); 
    foreach($hosp as $hospb):
    
      $_SESSION['hosp']=$hospb['hosptotal'];
      endforeach;
    //asp
    $stmt6 = $conn->prepare('SELECT SUM(venta) as asptotal FROM asp where asesor = ? ');
    $row =  $stmt6->execute([$_SESSION['asesor']]);
    $asp =  $stmt6 	-> fetchAll(PDO::FETCH_ASSOC); 
    foreach($asp as $aspb):
    
      $_SESSION['asp']=$aspb['asptotal'];
      endforeach;
    
          //dbu analitica
    $stmt7 = $conn->prepare('SELECT SUM(venta) as dbuanavtotal FROM analitica where asesor = ? ');
    $row =  $stmt7->execute([$_SESSION['asesor']]);
    $anav =  $stmt7 	-> fetchAll(PDO::FETCH_ASSOC); 
    foreach($anav as $dbuanavb):
    
      $_SESSION['dbuanav']=$dbuanavb['dbuanavtotal'];
      endforeach;
//dbu preanalitica
      $stmt7 = $conn->prepare('SELECT SUM(venta) as dbuprevtotal FROM preanalitica where asesor = ? ');
      $row =  $stmt7->execute([$_SESSION['asesor']]);
      $prev =  $stmt7 	-> fetchAll(PDO::FETCH_ASSOC); 
      foreach($prev as $dbupreb):
      
        $_SESSION['dbuprev']=$dbupreb['dbuprevtotal'];
        endforeach;

    $total_ventas_linea= $_SESSION['renalt']+$_SESSION['cardio']+
    $_SESSION['diabetes']+$_SESSION['diabetes']+$_SESSION['endo']+
    $_SESSION['hosp']+ $_SESSION['asp']+$_SESSION['dbuanav']+  $_SESSION['dbuprev'];
    
    //Obtener valor presupuesto global 6 linas
    //renal
    $stmt1 = $conn->prepare('SELECT SUM(presupuesto) as renaltotal FROM presupuesto where asesor = ? ');
    
    $row =  $stmt1->execute([$_SESSION['asesor']]);
    $renal =  $stmt1 	-> fetchAll(PDO::FETCH_ASSOC); 
    foreach($renal as $renalb):
    
      $_SESSION['renalt']=$renalb['renaltotal'];
      endforeach;
    //cardio
    $stmt2 = $conn->prepare('SELECT SUM(presupuesto) as cardiototal FROM cardio where asesor = ? ');
    
    $row =  $stmt2->execute([$_SESSION['asesor']]);
    $cardio =  $stmt2 	-> fetchAll(PDO::FETCH_ASSOC); 
    foreach($cardio as $cardiob):
    
      $_SESSION['cardio']=$cardiob['cardiototal'];
      endforeach;
    
      $stmt3 = $conn->prepare('SELECT SUM(presupuesto) as diabtotal FROM diabetes where asesor = ? ');
    
    $row =  $stmt3->execute([$_SESSION['asesor']]);
    $diabetes =  $stmt3 	-> fetchAll(PDO::FETCH_ASSOC); 
    foreach($diabetes as $diabetesb):
    
      $_SESSION['diabetes']=$diabetesb['diabtotal'];
      endforeach;
    //endo
    $stmt4 = $conn->prepare('SELECT SUM(presupuesto) as endototal FROM endo  where asesor = ? ');
    
    $row =  $stmt4->execute([$_SESSION['asesor']]);
    $endo =  $stmt4 	-> fetchAll(PDO::FETCH_ASSOC); 
    foreach($endo as $endob):
    
      $_SESSION['endo']=$endob['endototal'];
      endforeach;
    //Hospitalaira
    $stmt5 = $conn->prepare('SELECT SUM(presupuesto) as hosptotal FROM hosp where asesor = ?');
    
    $row =  $stmt5->execute([$_SESSION['asesor']]);
    $hosp =  $stmt5 	-> fetchAll(PDO::FETCH_ASSOC); 
    foreach($hosp as $hospb):
    
      $_SESSION['hosp']=$hospb['hosptotal'];
      endforeach;
      //asp
    $stmt6 = $conn->prepare('SELECT SUM(presupuesto) as asptotal FROM asp where asesor = ? ');
    $row =  $stmt6->execute([$_SESSION['asesor']]);
    $asp =  $stmt6 	-> fetchAll(PDO::FETCH_ASSOC); 
    foreach($asp as $aspb):
    
      $_SESSION['asp']=$aspb['asptotal'];
      endforeach;

    //dbu
    $stmt7 = $conn->prepare('SELECT SUM(presupuesto) as dbupretotal FROM analitica where asesor = ? ');
    $row =  $stmt7->execute([$_SESSION['asesor']]);
    $dbuana =  $stmt7 	-> fetchAll(PDO::FETCH_ASSOC); 
    foreach($dbuana as $dbupreb):
    
      $_SESSION['dbuana']=$dbupreb['dbupretotal'];
      endforeach;

      $stmt8 = $conn->prepare('SELECT SUM(presupuesto) as dbuanatotal FROM preanalitica where asesor = ? ');
      $row =  $stmt8->execute([$_SESSION['asesor']]);
      $dbupre =  $stmt8 	-> fetchAll(PDO::FETCH_ASSOC); 
      foreach($dbupre as $dbupreb):
      
        $_SESSION['dbupre']=$dbupreb['dbuanatotal'];
        endforeach;
    
    $total_presupuesto_linea= $_SESSION['renalt']+$_SESSION['cardio']+
    $_SESSION['diabetes']+$_SESSION['diabetes']+$_SESSION['endo']+$_SESSION['hosp']
    + $_SESSION['asp']+$_SESSION['dbupre']+ $_SESSION['dbuana'];
    
    //Obtener valor venta mensual 6 lineas
    //mes
    $mes=date("n");
    //años
    $año=date("Y");
    $stmtp1 = $conn->prepare('SELECT SUM(venta) as totalcardiov FROM cardio where  asesor = ? and mes=? and ano=?');
    $stmtp1->execute([$_SESSION['asesor'],$mes,$año]);
    $rowp1 = $stmtp1->fetch(PDO::FETCH_ASSOC);
    $cardiov   = $rowp1['totalcardiov']; 
    //asp
    $stmtp1 = $conn->prepare('SELECT SUM(venta) as totalaspv FROM asp where asesor = ? and  mes=? and ano=?');
    $stmtp1->execute([$_SESSION['asesor'],$mes,$año]);
    $rowp1 = $stmtp1->fetch(PDO::FETCH_ASSOC);
    $aspv = $rowp1['totalaspv']; 
    //analitica
    $stmtp1 = $conn->prepare('SELECT SUM(venta) as totalanav FROM analitica where asesor = ? and mes=? and ano=?');
    $stmtp1->execute([$_SESSION['asesor'],$mes,$año]);
    $rowp1 = $stmtp1->fetch(PDO::FETCH_ASSOC);
    $analiticav = $rowp1['totalanav']; 
    //preanalitica
    $stmtp1 = $conn->prepare('SELECT SUM(venta) as totalprev FROM preanalitica where asesor = ? and mes=? and ano=?');
    $stmtp1->execute([$_SESSION['asesor'],$mes,$año]);
    $rowp1 = $stmtp1->fetch(PDO::FETCH_ASSOC);
    $preanaliticav = $rowp1['totalprev']; 
    //diabetes
    $stmtp1 = $conn->prepare('SELECT SUM(venta) as totaldiabetesv FROM diabetes where asesor = ? and mes=? and ano=?');
    $stmtp1->execute([$_SESSION['asesor'],$mes,$año]);
    $rowp1 = $stmtp1->fetch(PDO::FETCH_ASSOC);
    $diabetesv = $rowp1['totaldiabetesv']; 
    //endo
    $stmtp1 = $conn->prepare('SELECT SUM(venta) as totalendov FROM endo where asesor = ? and  mes=? and ano=?');
    $stmtp1->execute([$_SESSION['asesor'],$mes,$año]);
    $rowp1 = $stmtp1->fetch(PDO::FETCH_ASSOC);
    $endov = $rowp1['totalendov']; 
    //hosp
    $stmtp1 = $conn->prepare('SELECT SUM(venta) as totalhospv FROM hosp where  asesor = ? and mes=? and ano=?');
    $stmtp1->execute([$_SESSION['asesor'],$mes,$año]);
    $rowp1 = $stmtp1->fetch(PDO::FETCH_ASSOC);
    $hospv = $rowp1['totalhospv']; 
    //renal
    $stmtp1 = $conn->prepare('SELECT SUM(venta) as totalrenalv FROM presupuesto where  asesor = ? and  mes=? and ano=?');
    $stmtp1->execute([$_SESSION['asesor'],$mes,$año]);
    $rowp1 = $stmtp1->fetch(PDO::FETCH_ASSOC);
    $renalv = $rowp1['totalrenalv']; 
    //total
    
    $total_ventas_mes_linea=$aspv+$cardiov+$diabetesv+$endov+$hospv+$renalv+$analiticav+$preanaliticav;
    //Obtener valor presupuesto mensual 6 lineas
    //cardio
    $stmtp1 = $conn->prepare('SELECT SUM(presupuesto) as totalcardiop FROM cardio where asesor = ? and mes=? and ano=?');
    $stmtp1->execute([$_SESSION['asesor'],$mes,$año]);
    $rowp1 = $stmtp1->fetch(PDO::FETCH_ASSOC);
    $cardiop = $rowp1['totalcardiop']; 
    //asp
    $stmtp1 = $conn->prepare('SELECT SUM(presupuesto) as totalaspp FROM asp where asesor = ? and  mes=? and ano=?');
    $stmtp1->execute([$_SESSION['asesor'],$mes,$año]);
    $rowp1 = $stmtp1->fetch(PDO::FETCH_ASSOC);
    $aspp = $rowp1['totalaspp']; 
     //analitica
     $stmtp1 = $conn->prepare('SELECT SUM(presupuesto) as totalanap FROM analitica where asesor = ? and mes=? and ano=?');
     $stmtp1->execute([$_SESSION['asesor'],$mes,$año]);
     $rowp1 = $stmtp1->fetch(PDO::FETCH_ASSOC);
     $analiticap = $rowp1['totalanap']; 
     //preanalitica
     $stmtp1 = $conn->prepare('SELECT SUM(presupuesto) as totalprep FROM preanalitica where asesor = ? and mes=? and ano=?');
     $stmtp1->execute([$_SESSION['asesor'],$mes,$año]);
     $rowp1 = $stmtp1->fetch(PDO::FETCH_ASSOC);
     $preanaliticap = $rowp1['totalprep']; 
    //diabetes
    $stmtp1 = $conn->prepare('SELECT SUM(presupuesto) as totaldiabetesp FROM diabetes where asesor = ? and  mes=? and ano=?');
    $stmtp1->execute([$_SESSION['asesor'],$mes,$año]);
    $rowp1 = $stmtp1->fetch(PDO::FETCH_ASSOC);
    $diabetesp = $rowp1['totaldiabetesp']; 
    //endo
    $stmtp1 = $conn->prepare('SELECT SUM(presupuesto) as totalendop FROM endo where asesor = ? and  mes=? and ano=?');
    $stmtp1->execute([$_SESSION['asesor'],$mes,$año]);
    $rowp1 = $stmtp1->fetch(PDO::FETCH_ASSOC);
    $endop = $rowp1['totalendop']; 
    //hosp
    $stmtp1 = $conn->prepare('SELECT SUM(presupuesto) as totalhospp FROM hosp where asesor = ? and mes=? and ano=?');
    $stmtp1->execute([$_SESSION['asesor'],$mes,$año]);
    $rowp1 = $stmtp1->fetch(PDO::FETCH_ASSOC);
    $hospp = $rowp1['totalhospp']; 
    //renal
    $stmtp1 = $conn->prepare('SELECT SUM(presupuesto) as totalrenalp FROM presupuesto where asesor = ? and  mes=? and ano=?');
    $stmtp1->execute([$_SESSION['asesor'],$mes,$año]);
    $rowp1 = $stmtp1->fetch(PDO::FETCH_ASSOC);
    $renalp = $rowp1['totalrenalp']; 
    //total
    
    $total_presupuesto_mes_linea=$aspp+$cardiop+$diabetesp+$endop+$hospp+$renalp+$preanaliticap+$analiticap;
    
    
    //obtener grafica venta mensual
    $statement = $conn->prepare("SELECT * FROM cardio  WHERE asesor = ? and ano = 2022 GROUP BY mes ASC; ");
    $statement->execute([ $_SESSION['nusuario']]);
    $user = $statement 	-> fetchAll(PDO::FETCH_ASSOC);
    $data1 = '';
        $data2 = '';
        $buildingName = '';
    while ($row = $user) {
    
      $data1 = $data1 . '"'. $row['venta'].'",';
      $data2 = $data2 . '"'. $row['cardio'] .'",';
      $buildingName = $buildingName . '"'. ucwords($row['building_name']) .'",';
    }
    $data1 = trim($data1,",");
        $data2 = trim($data2,",");
        $buildingName = trim($buildingName,",");
    
     //Semaforizacionón mensual

  $porcentajeventabarra = 0;
  if($total_ventas_mes_linea != 0 and $total_presupuesto_mes_linea!= 0 ){
    $porcentajeventabarra= round( $total_ventas_mes_linea / $total_presupuesto_mes_linea * 100);
  }
$porcentaje1=$total_presupuesto_mes_linea*70/100;
$porcentaje2=$total_presupuesto_mes_linea*95/100;
$porcentaje3=$total_presupuesto_mes_linea*100/100;            
$respuesta = "";
$textom = "";  
 
if ($total_ventas_mes_linea < $porcentaje3 ) {
 $respuesta = $porcentaje3 - $total_ventas_mes_linea; 
 $textom = "<font color=\"red\">Falta $".$respuesta." para llegar al valor del presupuesto mensual.</font>";
 } else if ($total_ventas_mes_linea >= $porcentaje3) {
   $respuesta = $total_ventas_mes_linea-$porcentaje3; 
 $textom = "<font color=\"green\">Superaste por $".$respuesta." el valor del presupuesto mensual.</font>";
  }
 
  
  //Semaforizacionón global

  $porcentajeventabarrag = 0;
  if($total_ventas_linea != 0 and $total_presupuesto_linea!= 0 ){
    $porcentajeventabarrag= round( $total_ventas_linea / $total_presupuesto_linea* 100);
  }
$porcentajeg1=$total_presupuesto_linea*70/100;
$porcentajeg2=$total_presupuesto_linea*95/100;
$porcentajeg3=$total_presupuesto_linea*100/100;            
$respuestag = "";
$textog = "";  
 
if ($total_ventas_linea < $porcentajeg3 ) {
  $respuestag = $porcentajeg3 - $total_ventas_linea; 
  $textog = "<font color=\"red\">Falta $".$respuestag." para llegar al valor del presupuesto global.</font>";
  } else if ($total_ventas_linea >= $porcentajeg3) {
    $respuestag = $total_ventas_linea-$porcentajeg3; 
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
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="indexgerencia.php">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fas fa-laugh-wink"></i>
                </div>
                <div class="sidebar-brand-text mx-3"><?php echo 	 $_SESSION['asesor'] ?></div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item active">
                <a class="nav-link" href="indexgerencia.php">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                Lineas Asesor
            </div>

            <!-- Nav Item - Pages Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
                    aria-expanded="true" aria-controls="collapseTwo">
                    <i class="fas fa-fw fa-cog"></i>
                    <span>Ventas</span>
                </a>
                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Lineas:</h6>
                        <?php if( $_SESSION['renallin']  == !null ){?>
                        <a class="collapse-item"
                            href="renalgerencia.php?asesor=<?php echo $asesorlinea ?>"><?php echo $_SESSION['renallin']  ?></a>
                        <?php } ?>

                        <?php if( $_SESSION['asplin']  == !null ){?>
                        <a class="collapse-item"
                            href="aspgerencia.php?asesor=<?php echo $asesorlinea ?>"><?php echo $_SESSION['asplin']  ?></a>
                        <?php } ?>
                        <?php if( $_SESSION['cardiolin']  == !null ){?>
                        <a class="collapse-item"
                            href="cardiogerencia.php?asesor=<?php echo $asesorlinea ?>"><?php echo $_SESSION['cardiolin']  ?></a>
                        </a>
                        <?php } ?>
                        <?php if( $_SESSION['analitica']  == !null ){?>
                        <a class="collapse-item"
                            href="dbuanaliticagerencia.php?asesor=<?php echo $asesorlinea ?>"><?php echo $_SESSION['analitica']  ?></a>
                        <?php } ?>


                        <?php if( $_SESSION['preanalitica']  == !null ){?>
                        <a class="collapse-item"
                            href="dbupreanalitica.php?asesor=<?php echo $asesorlinea ?>"><?php echo $_SESSION['preanalitica']  ?></a>
                        <?php } ?>

                        <?php if( $_SESSION['diabeteslin']  == !null ){?>
                        <a class="collapse-item"
                            href="diabetesgerencia.php?asesor=<?php echo $asesorlinea ?>"><?php echo $_SESSION['diabeteslin']  ?></a>
                        <?php } ?>

                        <?php if( $_SESSION['endolin']  == !null ){?>
                        <a class="collapse-item"
                            href="endovasculargerencia.php?asesor=<?php echo $asesorlinea ?>"><?php echo $_SESSION['endolin']  ?></a>
                        <?php } ?>

                        <?php if( $_SESSION['hosplin']  == !null ){?>
                           <a class="collapse-item"
                            href="hospitalariagerencia.php?asesor=<?php echo $asesorlinea ?>"><?php echo $_SESSION['hosplin']  ?></a>
                     
                         <?php } ?>

                         <a class="collapse-item"  href="historico_ventas_gerencia.php?asesor=<?php echo $asesorlinea ?>">Historico Ventas</a>
                       
                    </div>
                </div>
            </li>

            <!-- Nav Item - Utilities Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities"
                    aria-expanded="true" aria-controls="collapseUtilities">
                    <i class="fas fa-fw fa-wrench"></i>
                    <span>Cobros</span>
                </a>
                <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities"
                    data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Lineas:</h6>
                        <a class="collapse-item" href="cobros_gerencia.php?asesor=<?php echo $asesorlinea ?>">Cobros</a>
                        <a class="collapse-item" href="historico_cobros_gerencia.php?asesor=<?php echo $asesorlinea ?>">Historico Cobros</a>

                    </div>
                </div>
            </li>
            

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading 
            <div class="sidebar-heading">
                Addons
            </div>-->

            <!-- Nav Item - Pages Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages"
                    aria-expanded="true" aria-controls="collapsePages">
                    <i class="fas fa-fw fa-folder"></i>
                    <span>Asesores</span>
                </a>
                <div id="collapsePages" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Ventas & Cobros:</h6>
                        <a class="collapse-item"  href="asesores.php?asesor=Italica Saldarreaga">Itálica Saldarreaga</a>
                        <a class="collapse-item"  href="asesores.php?asesor=Lilibeth Cedeno">Llibeth Cedeño</a>
                        <a class="collapse-item"  href="asesores.php?asesor=Francisco Romero">Francisco Romero</a>
                        <a class="collapse-item"  href="asesores.php?asesor=Tatiana Jimenez">Tatiana Jiménez</a>
                        <a class="collapse-item"  href="asesores.php?asesor=Paola Alarcon">Paola Alarcón</a>
                        <a class="collapse-item"  href="asesores.php?asesor=Christian Masache">Christian Masache</a>
                        <a class="collapse-item"  href="asesores.php?asesor=Katty Mera">Katty Mera</a>
                        <a class="collapse-item"  href="asesores.php?asesor=Noemi Valeriano">Noemí Valeriano</a>
                        <a class="collapse-item"  href="asesores.php?asesor=Renan Taipe">Renán Taipe</a>
                        <a class="collapse-item"  href="asesores.php?asesor=Jenny Villavicencio">Jenny Villavicencio</a>
                    </div>
                </div>
            </li>

            <!-- Nav Item - Charts 
            <li class="nav-item">
                <a class="nav-link" href="charts.html">
                    <i class="fas fa-fw fa-chart-area"></i>
                    <span>Charts</span></a>
            </li>
-->
            <!-- Nav Item - Tables 
            <li class="nav-item">
                <a class="nav-link" href="tables.html">
                    <i class="fas fa-fw fa-table"></i>
                    <span>Tables</span></a>
            </li>-->

            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

            <!-- Sidebar Message -->

        </ul>
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
                        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
                      
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
                                                Total de ventas del mes  Ene - <?php echo date('M'), ' del ' , $año?></div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                <?php	echo "$".$total_ventas_linea ;?>
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
                                                Total de presupuesto del mesEne - <?php echo date('M'), ' del ' , $año?></div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                <?php	echo "$".$total_presupuesto_linea ;  ?></div>
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
                                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1"> Ventas
                                                del mes  <?php echo date('M'), ' del ' , $año?> </div>
                                            <div class="row no-gutters align-items-center">
                                                <div class="col-auto">
                                                    <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">
                                                        <?php 	echo "$".$total_ventas_mes_linea ?></div>
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
                                                Presupuesto del mes <?php echo date('M'), ' del ' , $año?></div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                <?php echo "$".$total_presupuesto_mes_linea ;?></div>
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
                                    <h6 class="m-0 font-weight-bold text-primary">
                                        Semaforización <?php echo date('M'), ' del ' , $año?></h6>
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
                                    <link rel="stylesheet"
                                        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
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
                                    <i class='fa fa-circle' style='color: red'></i> Te encuentras por debajo del 70%
                                    </br>
                                    <i class='fa fa-circle' style='color: yellow'></i> Te encuentras por debajo del
                                    95%</br>
                                    <i class='fa fa-circle' style='color: green'></i> Superado

                                </div>
                            </div>
                        </div>

                        <!-- Pie Chart -->
                        <div class="col-xl-4 col-lg-5">
                            <div class="card shadow mb-4">
                                <!-- Card Header - Dropdown -->
                                <div
                                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">Venta vs Presupuesto</h6>
                                    <h6 class="m-0 font-weight-bold text-primary"><?php echo date('M'), ' del ' , $año?>
                                    </h6>
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
                                    <script type="text/javascript"
                                        src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.bundle.min.js">
                                    </script>

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
      data: [<?php echo $total_ventas_mes_linea ?>,<?php echo $total_presupuesto_mes_linea?>],
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
      data: [<?php echo $total_ventas_linea ?>,<?php echo $total_presupuesto_linea ?>],
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
                        <div class="modal-body">Select "Logout" below if you are ready to end your current session.
                        </div>
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
