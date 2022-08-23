<?php
include('../bdd/conexion.php');
//usuario
$_SESSION['asesor'] =$_GET["asesor"];
$asesorlinea=$_GET["asesor"];

$statement = $conn->prepare("SELECT * FROM usuarios  WHERE username = ? ");
$statement->execute([ $_SESSION['nusuario']]);
$user = $statement 	-> fetchAll(PDO::FETCH_ASSOC);

foreach($user as $usuariob):
	$_SESSION['nombre_usuario']=$usuariob['nombre'];
  $_SESSION['avatar']=$usuariob['avatar'];
  $_SESSION['cant_clientes']=$usuariob['cant_clientes'];
	endforeach;

    //asesor
    $statement = $conn->prepare("SELECT * FROM usuarios  WHERE nombre = ? ");
    $statement->execute([$_SESSION['asesor']]);
    $usera = $statement 	-> fetchAll(PDO::FETCH_ASSOC);
    
    foreach($usera as $usuarioba):
        $_SESSION['cli_ase']=$usuarioba['cant_clientes'];
     
    
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
$stmt = $conn->prepare('SELECT SUM(venta) as totalg FROM presupuesto where asesor =?');
$stmt->execute([$_SESSION['asesor']]);
$row = $stmt->fetch(PDO::FETCH_ASSOC);
$venta_global = $row['totalg'];

//Obtener valor presupuesto global
$stmtp = $conn->prepare('SELECT SUM(presupuesto) as totalgp FROM presupuesto where asesor =?');
$stmtp->execute([$_SESSION['asesor']]);
$rowp = $stmtp->fetch(PDO::FETCH_ASSOC);
$presupuesto_global = $rowp['totalgp'];

//Obtener valor venta mensual
//mes
$mes=date("n");
//años
$año=date("Y");
$stmt1 = $conn->prepare('SELECT SUM(venta) as totalm FROM presupuesto where asesor =? and mes=? and ano=?');
$stmt1->execute([$_SESSION['asesor'],$mes,$año]);
$row1 = $stmt1->fetch(PDO::FETCH_ASSOC);
$venta_mensual = $row1['totalm']; 

//Obtener valor presupuesto mensual

$stmtp1 = $conn->prepare('SELECT SUM(presupuesto) as totalpm FROM presupuesto where asesor =? and mes=? and ano=?');
$stmtp1->execute([$_SESSION['asesor'],$mes,$año]);
$rowp1 = $stmtp1->fetch(PDO::FETCH_ASSOC);
$presupuesto_mensual = $rowp1['totalpm']; 

//obtener grafica venta mensual
$statement = $conn->prepare("SELECT * FROM presupuesto  WHERE asesor = ? and ano = 2022 GROUP BY mes ASC; ");
$statement->execute([ $_SESSION['nusuario']]);
$user = $statement 	-> fetchAll(PDO::FETCH_ASSOC);
$data1 = '';
	$data2 = '';
	$buildingName = '';
while ($row = $user) {

  $data1 = $data1 . '"'. $row['venta'].'",';
  $data2 = $data2 . '"'. $row['presupuesto'] .'",';
  $buildingName = $buildingName . '"'. ucwords($row['building_name']) .'",';
}
$data1 = trim($data1,",");
	$data2 = trim($data2,",");
	$buildingName = trim($buildingName,",");

  //Semaforizacionón
  $porcentaje1_barg=$presupuesto_mensual*70/100;
  $porcentaje2_barg=$presupuesto_mensual*95/100;
  $porcentaje3_barg=$presupuesto_mensual*100/100;            
  $respuesta_barg = "";
  $texto_barg = "";  
        
 

  if ($venta_mensual < $porcentaje3_barg ) {
    $respuesta_barg = $porcentaje3_barg - $venta_mensual; 
    $texto_barg = "<font color=\"red\">Falta $".$respuesta_barg." para llegar al valor del presupuesto mensual.</font>";
    } else if ($venta_mensual >= $porcentaje3_barg) {
      $respuesta_barg = $venta_mensual-$porcentaje3_barg; 
    $texto = "<font color=\"green\">Superaste por $".$respuesta_barg." el valor del presupuesto mensual.</font>";
    } 

?>
 <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

<!-- Sidebar - Brand -->
<a class="sidebar-brand d-flex align-items-center justify-content-center" href="indexgerencia.php">
    <div class="sidebar-brand-icon rotate-n-15">
        <i class="fas fa-laugh-wink"></h6></i>
    </div>
    <div class="sidebar-brand-text mx-3"> <?php echo  $_SESSION['asesor']?> <sup></sup></div>
</a>

<!-- Divider -->
<hr class="sidebar-divider my-0">

<!-- Nav Item - Dashboard -->
<li class="nav-item active">
    <a class="nav-link" href="indexgerencia.php">
        <i class="fas fa-fw fa-tachometer-alt"></i>
        <span>Dashboard</span></a>
</li>
<li class="nav-item active">
    <a class="nav-link" href="#">
        <i class="fas fa-child"></i>
        <span>Cant. Clientes: <?php echo $_SESSION['cli_ase'] ?></span></a>
</li>

<!-- Divider -->
<hr class="sidebar-divider">

<!-- Heading -->
<div class="sidebar-heading">
    Interface
</div>

<!-- Nav Item - Pages Collapse Menu -->
<li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
        aria-expanded="true" aria-controls="collapseTwo">
        <i class="fas fa-fw fa-cog"></i>
        <span>Ventas </span>
    </a>
    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Lineas :</h6>
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
                            href="dbuanaliticagerencia.php?asesor=<?php echo $asesorlinea ?>"><?php echo $_SESSION['analitica'] ?></a>
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
                         <a class="collapse-item"  href="historico_ventas_gerencia.php?asesor=<?php echo   $_SESSION['asesor'] ?>">Historico Ventas</a>

                  
                      
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
            <a class="collapse-item"  href="cobros_gerencia.php?asesor=<?php echo $asesorlinea ?>">Cobros</a>
            <a class="collapse-item"  href="historico_cobros_gerencia.php?asesor=<?php echo $asesorlinea ?>">Historico Cobros</a>
           
          
          
        </div>
    </div>
</li>

<!-- Divider -->
<hr class="sidebar-divider">

<!-- Heading 
<div class="sidebar-heading">
    Addons
</div>-->

<!-- Nav Item - Pages Collapse Menu 
                        -->
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
