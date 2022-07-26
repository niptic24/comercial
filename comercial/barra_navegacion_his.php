<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

<!-- Sidebar - Brand -->
<a class="sidebar-brand d-flex align-items-center justify-content-center" href="indexcomercial.php">
    <div class="sidebar-brand-icon rotate-n-15">
    
        <i class="fas fa-laugh-wink"></i>
    </div>
    <div class="sidebar-brand-text mx-3"><?php echo $_SESSION['nombre_usuario'] ?></div>
</a>

<!-- Divider -->
<hr class="sidebar-divider my-0">

<!-- Nav Item - Dashboard -->
<li class="nav-item active">
    <a class="nav-link" href="indexcomercial.php">
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
        <span>Ventas</span>
    </a>
    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
        <h6 class="collapse-header">Lineas:</h6>
            <?php if( $_SESSION['renallin']  == !null ){?>
            <a class="collapse-item"
                href="renal_venta_comercial.php?asesor=<?php echo  $_SESSION['subnombre'] ?>"><?php echo $_SESSION['renallin']  ?></a>
                </a>
                <?php } ?>

            <?php if( $_SESSION['asplin']  == !null ){?>
            <a class="collapse-item"
                href="asp_venta_comercial.php?asesor=<?php echo $_SESSION['subnombre'] ?>"><?php echo $_SESSION['asplin']  ?></a>
            <?php } ?>
            <?php if( $_SESSION['cardiolin']  == !null ){?>
            <a class="collapse-item"
                href="cardio_venta_comercial.php?asesor=<?php echo $_SESSION['subnombre'] ?>"><?php echo $_SESSION['cardiolin']  ?></a>
            </a>
            <?php } ?>
            <?php if( $_SESSION['analitica']  == !null ){?>
            <a class="collapse-item"
                href="dbuanalitica_venta_comercial.php?asesor=<?php echo $_SESSION['subnombre'] ?>&?g=g"><?php echo $_SESSION['analitica']  ?></a>
            <?php } ?>


            <?php if( $_SESSION['preanalitica']  == !null ){?>
            <a class="collapse-item"
                href="dbupreanalitica_venta_comercial.php?asesor=<?php echo $_SESSION['subnombre'] ?>"><?php echo $_SESSION['preanalitica']  ?></a>
            <?php } ?>

            <?php if( $_SESSION['diabeteslin']  == !null ){?>
            <a class="collapse-item"
            href="diabetes_venta_comercial.php?asesor=<?php echo $_SESSION['subnombre'] ?>"><?php echo $_SESSION['diabeteslin']  ?></a>
            <?php } ?>

            <?php if( $_SESSION['endolin']  == !null ){?>
            <a class="collapse-item"
            href="endovascular_ventas_comercial.php?asesor=<?php echo $_SESSION['subnombre'] ?>"><?php echo $_SESSION['endolin']  ?></a>
            <?php } ?>

            <?php if( $_SESSION['hosplin']  == !null ){?>
               <a class="collapse-item"
               href="hospitalaria_ventas_comercial.php?asesor=<?php echo $_SESSION['subnombre'] ?>"><?php echo $_SESSION['hosplin']  ?></a>
               
             <?php } ?>
             <a class="collapse-item"  href="historico_ventas_comercial.php?asesor=<?php echo $_SESSION['subnombre'] ?>">Historico Ventas</a>

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
            <h6 class="collapse-header">Detalle:</h6>
            <a class="collapse-item"  href="cobros_comercial.php?asesor=<?php echo $_SESSION['subnombre'] ?>">Reporte Cobros</a>
<a class="collapse-item"  href="historico_cobros_comercial.php?asesor=<?php echo $_SESSION['subnombre'] ?>">Historico Cobros</a>

   
            
            
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
<li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages"
        aria-expanded="true" aria-controls="collapsePages">
        <i class="fas fa-fw fa-folder"></i>
        <span>Pages</span>
    </a>
    <div id="collapsePages" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Login Screens:</h6>
            <a class="collapse-item" href="login.html">Login</a>
            <a class="collapse-item" href="register.html">Register</a>
            <a class="collapse-item" href="forgot-password.html">Forgot Password</a>
            <div class="collapse-divider"></div>
            <h6 class="collapse-header">Other Pages:</h6>
            <a class="collapse-item" href="404.html">404 Page</a>
            <a class="collapse-item" href="blank.html">Blank Page</a>
        </div>
    </div>
</li>-->

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