
 <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

<!-- Sidebar - Brand -->
<a class="sidebar-brand d-flex align-items-center justify-content-center" href="indexgerencia.php">
    <div class="sidebar-brand-icon rotate-n-15">
        <i class="fas fa-laugh-wink"></i>
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
                            href="renalgerencia.php?asesor=<?php echo $_SESSION['asesor'] ?>"><?php echo $_SESSION['renallin']  ?></a>
                        <?php } ?>

                        <?php if( $_SESSION['asplin']  == !null ){?>
                        <a class="collapse-item"
                            href="aspgerencia.php?asesor=<?php  echo $_SESSION['asesor']  ?>"><?php echo $_SESSION['asplin']  ?></a>
                        <?php } ?>
                        <?php if( $_SESSION['cardiolin']  == !null ){?>
                        <a class="collapse-item"
                            href="cardiogerencia.php?asesor=<?php echo $_SESSION['asesor']  ?>"><?php echo $_SESSION['cardiolin']  ?></a>
                        </a>
                        <?php } ?>
                        <?php if( $_SESSION['analitica']  == !null ){?>
                        <a class="collapse-item"
                            href="dbuanaliticagerencia.php?asesor=<?php echo $_SESSION['asesor']  ?>"><?php echo $_SESSION['analitica'] ?></a>
                        <?php } ?>


                        <?php if( $_SESSION['preanalitica']  == !null ){?>
                        <a class="collapse-item"
                            href="dbupreanalitica.php?asesor=<?php echo $_SESSION['asesor']  ?>"><?php echo $_SESSION['preanalitica'] ?></a>
                        <?php } ?>

                        <?php if( $_SESSION['diabeteslin']  == !null ){?>
                        <a class="collapse-item"
                            href="diabetesgerencia.php?asesor=<?php echo $_SESSION['asesor']  ?>"><?php echo $_SESSION['diabeteslin']  ?></a>
                        <?php } ?>

                        <?php if( $_SESSION['endolin']  == !null ){?>
                        <a class="collapse-item"
                            href="endovasculargerencia.php?asesor=<?php echo $_SESSION['asesor']  ?>"><?php echo $_SESSION['endolin']  ?></a>
                        <?php } ?>

                        <?php if( $_SESSION['hosplin']  == !null ){?>
                           <a class="collapse-item"
                            href="hospitalariagerencia.php?asesor=<?php echo $_SESSION['asesor']  ?>"><?php echo $_SESSION['hosplin']  ?></a>
                     
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
            <a class="collapse-item"  href="cobros_gerencia.php?asesor=<?php  echo $_SESSION['asesor'] ?>">Cobros</a>
            <a class="collapse-item"  href="historico_cobros_gerencia.php?asesor=<?php  echo $_SESSION['asesor'] ?>">Historico Cobros</a>
          

          
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
                        <a class="collapse-item"  href="asesores.php?asesor=Itálica Saldarreaga">Itálica Saldarreaga</a>
                        <a class="collapse-item"  href="asesores.php?asesor=Lilibeth Cedeño">Llibeth Cedeño</a>
                        <a class="collapse-item"  href="asesores.php?asesor=Francisco Romero">Francisco Romero</a>
                        <a class="collapse-item"  href="asesores.php?asesor=Tatiana Jiménez">Tatiana Jiménez</a>
                        <a class="collapse-item"  href="asesores.php?asesor=Paola Alarcón">Paola Alarcón</a>
                        <a class="collapse-item"  href="asesores.php?asesor=Christian Masache">Christian Masache</a>
                        <a class="collapse-item"  href="asesores.php?asesor=Katty Mera">Katty Mera</a>
                        <a class="collapse-item"  href="asesores.php?asesor=Noemí Valeriano">Noemí Valeriano</a>
                        <a class="collapse-item"  href="asesores.php?asesor=Renán Taipe">Renán Taipe</a>
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
