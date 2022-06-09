<?php   @session_start(); ?>
<!DOCTYPE html>
<html>

<head>

   <meta charset="utf-8">

    <!-- <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests"> -->
    
    <!-- <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests"> -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Custom fonts for this template-->
    <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
     <!-- Custom styles for this template-->
    <link href="../css/sb-admin-2.min.css" rel="stylesheet">

    <!-- js externos-->
	<script src="../js/jquery-3.6.0.min.js"></script>
    <script src="../js/sweetalert2.js"></script>    
	<script src="../js/inicio.js"></script>	 
    <link href="../css/select2.min.css" rel="stylesheet">

    <script type="text/javascript">
    	$(document).ready(function () {
    			validar_session();
    	});
			    	
	function validar_session() 
	{
		const usuario = '<?php echo isset($_SESSION["INICIO"]["USUARIO"]); ?>';
		const id_usuario = '<?php echo isset($_SESSION["INICIO"]["ID_USUARIO"]); ?>';	
		if(id_usuario==null || id_usuario=='')
		{
			window.location.href = 'login.php';
		}
	}

	function eliminar_session()
	{
	    $.ajax({
	        // data:  {parametros:parametros},
	        url:   '../controlador/funcionesSistema.php?cerrar_session=true',           
	        type:  'post',
	        dataType: 'json',
	        success:  function (response) { 
	           if(response==1)
	           {
	           	 window.location.href='home.php';
	           }
	        }
	      });

	}


    </script>
   </head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">
        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="home.php">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fas fa-laugh-wink"></i>
                </div>
                <div class="sidebar-brand-text mx-3">RECO <sup>Desecho</sup></div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item">
                <a class="nav-link" href="home.php">
                    <i class="fas fa-fw fa-home"></i>
                    <span>Home</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                Administrativo
            </div>
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#articulos"
                    aria-expanded="true" aria-controls="articulos">
                    <i class="fas fa-fw fa-box"></i>
                    <span>Contenedores</span>
                </a>
                <div id="articulos" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <!-- <h6 class="collapse-header">Custom Components:</h6> -->
                        <?php 
                         if($_SESSION['INICIO']['TIPO_U']==1)
                         {
                          echo '<a class="collapse-item" href="nuevo_contenedor.php">
                            <i class="fas fa-fw fa-plus"></i>  Nuevo Contenedor</a>';
                          }
                        ?>

                        <a class="collapse-item" href="contenedores.php">
                            <i class="fas fa-fw fa-map-marker"></i>  Ubicaciones</a>
                        <a class="collapse-item" href="rutas.php">
                            <i class="fas fa-fw fa-location-arrow"></i>  Rutas</a>
                    </div>
                </div>
            </li>
            <li class="nav-item">
                <?php 
                if($_SESSION['INICIO']['TIPO_U']==1)
                {
                    echo '<a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#usuarios"
                        aria-expanded="true" aria-controls="articulos">
                        <i class="fas fa-fw fa-building"></i>
                        <span>Administrativo</span>
                    </a>';
                }
                ?>
                <div id="usuarios" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <!-- <h6 class="collapse-header">Custom Components:</h6> -->
                        <a class="collapse-item" href="usuario.php">
                            <i class="fas fa-fw fa-user-plus"></i>  Nuevo Usuario</a>
                        <a class="collapse-item" href="tipo.php">
                            <i class="fas fa-fw fa-users"></i>  Tipo usuario</a>
                        
                    </div>
                </div>
            </li>
            <!-- Nav Item - Pages Collapse Menu -->

            <!-- Nav Item - Utilities Collapse Menu -->
            
            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>
                   
                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">                      

                        <!-- Nav Item - Alerts -->
                        <li class="nav-item dropdown no-arrow mx-1" id>
                            <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-bell fa-fw"></i>
                                <!-- Counter - Alerts -->
                                <span class="badge badge-danger badge-counter" id="num_noti"></span>
                            </a>
                            <!-- Dropdown - Alerts -->
                            <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="alertsDropdown" id="pnl_aletas">
                                
                            </div>
                        </li>

                        <div class="topbar-divider d-none d-sm-block"></div>

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?php echo $_SESSION['INICIO']['NOMBRE']; ?></span>
                                <img class="img-profile rounded-circle"
                                    src="../img/sistema/user.png">
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">
                                <!-- <a class="dropdown-item" href="#">
                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Perfil
                                </a>  -->    
                                <!-- <div class="dropdown-divider"></div> -->
                                <button class="dropdown-item" onclick="eliminar_session()">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                   Salir
                                </button>
                            </div>
                        </li>

                    </ul>

                </nav>
                <!-- End of Topbar -->
