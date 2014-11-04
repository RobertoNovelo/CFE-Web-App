<!DOCTYPE html>

<html>
<head>
    <title>CFE Admin Panel</title>
    <meta charset="utf-8">
    <!-- Include .css files -->
    <link type="text/css" href="/res/css/bootstrap.min.css" rel="stylesheet">
    <link type="text/css" href="/res/css/normalize.css" rel="stylesheet">
    <link type="text/css" href="/res/css/bootstrap.min.css" rel="stylesheet">
    <link type="text/css" href="/res/css/sidebar.css" rel="stylesheet">
    <link type="text/css" href="/res/css/autocomplete.css" rel="stylesheet">    
    <link type="text/css" href="/res/css/adminpanel.css" rel="stylesheet">    
    <script type="text/javascript"
      src="http://maps.googleapis.com/maps/api/js?key=AIzaSyDbRh5DhkpxMpjVGpjXQDq0sWgo-CK64k0&sensor=FALSE">
    </script>
    <!-- Include .js files-->
    
    <script>
		window.open    = function(){};
		window.print   = function(){};
		// Support hover state for mobile.
		if (false) {
			window.ontouchstart = function(){};
		}
	</script>
    <script type="text/javascript" src="/res/js/modernizr.js">
    </script>
    
</head>

<body>

<!-- Overlay for fixed sidebar -->
<div class="sidebar-overlay"></div>

<!-- Material sidebar -->
<aside id="sidebar" class="sidebar sidebar-default open" role="navigation">
    <!-- Sidebar header -->
    <div class="sidebar-header header-cover" style="background-image: url(http://2.bp.blogspot.com/-2RewSLZUzRg/U-9o6SD4M6I/AAAAAAAADIE/voax99AbRx0/s1600/14%2B-%2B1%2B%281%29.jpg);">
        <!-- Top bar -->
        <div class="top-bar"></div>
        <!-- Sidebar toggle button -->
        <button type="button" class="sidebar-toggle">
            <i class="icon-material-sidebar-arrow"></i>
        </button>
        <!-- Sidebar brand image -->
        <div class="sidebar-image">
            <img src="https://pbs.twimg.com/profile_images/473665860817547264/rH0jArBd_400x400.jpeg">
        </div>
        <!-- Sidebar brand name -->
        <a data-toggle="dropdown" class="sidebar-brand" href="#settings-dropdown">
            roberto.novelo@smartplace.mx
            <b class="caret"></b>
        </a>
    </div>

    <!-- Sidebar navigation -->
    <ul class="nav sidebar-nav">
        <li class="dropdown">
            <ul id="settings-dropdown" class="dropdown-menu">
                <li>
                    <a tabindex="-1">
                        Profile
                    </a>
                </li>
                <li>
                    <a tabindex="-1">
                        Settings
                    </a>
                </li>
                <li>
                    <a tabindex="-1">
                        Help
                    </a>
                </li>
                <li>
                    <a tabindex="-1">
                        Exit
                    </a>
                </li>
            </ul>
        </li>
        <li>
            <a class="menu-action" data-section="mapSection" data-handler="loadMap" data-args="map">
                <i class="sidebar-icon icon-material-inbox"></i>
                Mapa
            </a>
        </li>
        <li class="divider"></li>
        <li class="dropdown">
            <a class="ripple-effect dropdown-toggle" data-toggle="dropdown">
                Todos los reportes
                <b class="caret"></b>
            </a>
            <ul class="dropdown-menu">
                <li>
	                <a class="menu-action" data-section="listSection" data-handler="sectionManager" data-args="all-pending">
                        Pendientes
                        <!-- <span class="sidebar-badge badge-circle">10</span> -->
                    </a>
                </li>
                <li>
	                <a class="menu-action" data-section="listSection" data-handler="sectionManager" data-args="all-inprocess">
                        En proceso
                        <!-- <span class="sidebar-badge badge-circle">10</span> -->
                    </a>
                </li>
                <li>
	                <a class="menu-action" data-section="listSection" data-handler="sectionManager" data-args="all-resolved">
                        Resueltos
                        <!-- <span class="sidebar-badge badge-circle">10</span> -->
                    </a>
                </li>
                <li>
	                <a class="menu-action" data-section="listSection" data-handler="sectionManager" data-args="all-closed">
                        Cerrados
                        <!-- <span class="sidebar-badge badge-circle">10</span> -->
                    </a>
                </li>
                <li>
	                <a class="menu-action" data-section="listSection" data-handler="sectionManager" data-args="all-all">
                        Todos
                        <!-- <span class="sidebar-badge badge-circle">10</span> -->
                    </a>
                </li>
            </ul>
        </li>
        <li class="divider"></li>
        <li>
            <a class="menu-action" data-section="listSection" data-handler="sectionManager" data-args="type-worker">
                Trabajadores
                <!-- <span class="sidebar-badge">3</span> -->
            </a>
        </li>
    </ul>
    <!-- Sidebar divider -->
    <!-- <div class="sidebar-divider"></div> -->
    
    <!-- Sidebar text -->
    <!--  <div class="sidebar-text">Text</div> -->
</aside>


<div class="wrapper">
    <!-- Sidebar Constructor -->
    <div id="mapSection" class="row active-section">
    	
    	<div class="issues-map-details">
    		<div class="row search-bar">
    			<div class="col-xs-10 search-bar-input">
					<input tabindex="1" id="mapSearch" type="search" autocomplete="off" class="search-input" id="input_nombre"  name="nombre" placeholder="Queja, Falla, Empleado o Todos">
				</div>
    			<div tabindex="2" class="col-xs-2 search-bar-btn">
	   				<img class="search-img" src="/res/icon/search-white.png">
				</div>
    		</div>
    	</div>
   		<div class="search-results-container" style="display:none">
	   		<div class="close-search-results">
	   			<img class="close-img" src="/res/icon/close-btn.png">
	   		</div>
	   		
	   		<div id="resultsContainer">
		   		<div id="noResultsContainer" class="row result-header center-text">
		   			<div class="col-xs-12">
	   					<p>No se encontraron coincidencias!</p>
	   				</div>
		   		</div>
		   		<div id="allResultsContainer" class="row result-header center-text">
		   			<div class="col-xs-12">
		   				<div class="row">
		   					<div class="col-xs-12">
	   							<h5>Total de <span id="totalLabel"></span>:<span id="totalNumberLabel"></span></h5>
		   					</div>
		   				</div>
		   				<div class="row">
							<div class="col-xs-12 center-text accept-btn-layout">
						        <button id="showAllResults" class="btn btn-lg accept-btn">Mostrar</button>
						    </div>
		   				</div>
	   				</div>
		   		</div>
		   		<div id="resultHeader" style="display:none" class="row result-header center-text">
	   				<div class="col-xs-3">
	   					<p>ID de reporte:</p>
	   				</div>
	   				<div class="col-xs-6">
	   					<p>Trabajador Asignado:</p>
	   				</div>
	   				<div class="col-xs-3">
	   					<p style="text-align:left">Estado:</p>
	   				</div>
	   			</div>
	   			<div id="resultItems">
	   			</div>
	   		</div>
	   		
   		</div>
    
		<div class="col-xs-12 center-text">
			<div id="googleMap" class="mapwrapper"></div>
		</div>
	</div>
    
    <div id="listSection">
    	<div id="listLoading">
    	</div>
    
    	<div id="listView">
    	</div>
    	
    	<div class="center-text" id="itemDetails" style="display:none;">
           
            <div class="row details-header">
                <div class="col-xs-7 col-xs-offset-1">
                   <img id="detailsMapPreview">
                </div>
                <div class="col-xs-3">
                    <div class="row">
                        <div class="col-xs-12 header-item-card-container">
                            <h5>ID de Reporte:</h5>
                            <h5 id="itemReportIDLabel"></h5>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 header-item-card-container">
                            <h5>Tipo de Reporte:</h5>
                            <h5 id="itemTypeLabel"></h5>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 header-item-card-container">
                            <h5>Estado de Reporte:</h5>
                            <h5 id="itemStatusLabel"></h5>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 header-item-card-container">
                            <h5>Fecha de creación:</h5>
                            <h5 id="itemCreationDateLabel"></h5>
                        </div>
                    </div>
                    <div class="details-divider"></div>
                    <div class="row">
                        <div class="col-xs-12 header-item-card-container">
                            <h5>Empleado asignado:</h5>
                            <h5 style="display:none" id="itemWorkerName"></h5>
                            <button id="assignWorker" class="btn btn-lg accept-btn">Asignar</button>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xs-12">
                            <button id="removeReport" class="btn btn-lg accept-btn">Remover</button>
                        </div>
                    </div>
                </div>
            </div>
           
            <div class="row">
               <div class="col-xs-3">
                   <h5 id="itemReportIDLabel"></h5>
               </div>
               <div class="col-xs-3">
                   <h5 id="itemTypeLabel"></h5>
               </div>
               <div class="col-xs-3">
                   <h5 id="itemStatusLabel"></h5>
               </div>
               <div class="col-xs-3">
                   <h5 id="itemCreationDateLabel"></h5>
               </div>
            </div>

    	</div>
    	
    	<div class="back-to-list-section">
			<button style="display:none" id="backToList" class="btn btn-lg accept-btn">Volver a la Lista</button>
		</div>
		
	</div>
</div>

    <!-- Assign Worker Modal -->
    <div class="modal fade" id="assignWorkerModal" tabindex="-1" role="dialog" aria-labelledby="assignWorkerModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title" id="assignWorkerModalLabel">Asignar Empleado...</h4>
                </div>
                <div class="modal-body center-text">
                    <input tabindex="1" class="form-control center-text" id="workerSearch" type="search" autocomplete="off"  placeholder="Nombre ó Número de Empleado">
                    <div class="invalidInputsReg" style="display: none;">
                        <div class="alert-text alert alert-danger center-text" role="alert">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <button type="button" id="confirmWorker" class="btn btn-primary">Asignar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Assign Worker Modal -->
    <div class="modal fade" id="addWorkerModal" tabindex="-1" role="dialog" aria-labelledby="addWorkerModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title" id="addWorkerModalLabel">Agregar Empleado...</h4>
                </div>
                <div class="modal-body center-text">
                    <h5>Nombre de Usuario</h5>
                    <input tabindex="1" class="form-control center-text" id="workerUserName" type="text" autocomplete="off" >
                    <h5>Nombre</h5>
                    <input tabindex="1" class="form-control center-text" id="workerName" type="text" autocomplete="off" >
                    <h5>Apellido Paterno</h5>
                    <input tabindex="1" class="form-control center-text" id="workerfLastName" type="text" autocomplete="off" >
                    <h5>Apellido Materno</h5>
                    <input tabindex="1" class="form-control center-text" id="workersLastName" type="text" autocomplete="off" >
                    <h5>Contraseña</h5>
                    <input tabindex="1" class="form-control center-text" id="workerPassword" type="password" autocomplete="off" >
                    <h5>Verifica la Contraseña</h5>
                    <input tabindex="1" class="form-control center-text" id="workerVerifyPassword" type="password" autocomplete="off" >
                    <div class="invalidInputsReg" style="display: none;">
                        <div class="alert-text alert alert-danger center-text" role="alert">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <button type="button" id="confirmAddWorker" class="btn btn-primary">Agregar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Assign Worker Modal -->
    <div class="modal fade" id="removeReportModal" tabindex="-1" role="dialog" aria-labelledby="removeReportModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title" id="removeReportModalLabel">Remover Reporte...</h4>
                </div>
                <div class="modal-body center-text">
                    <h5>¿Seguro?</h5>
                    <div class="invalidInputsReg" style="display: none;">
                        <div class="alert-text alert alert-danger center-text" role="alert">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <button type="button" id="confirmRemove" class="btn btn-primary">Eliminar</button>
                </div>
            </div>
        </div>
    </div>

	
    <script type="text/javascript" src="/res/js/jquery-2.1.1.min.js"></script>
    <script type="text/javascript" src="/res/js/bootstrap.min.js"></script>
    

	<script type="text/javascript" src="/res/js/localstorage.js"></script>
	<script type="text/javascript" src="/res/js/rememberscroll.js"></script>
	
    <script type="text/javascript" src="/res/js/lib/jquery.autocomplete.js"></script>
    <script type="text/javascript" src="/res/js/sidebar.js"></script>
    <script type="text/javascript" src="/res/js/cfemap.js"></script>
    <script type="text/javascript" src="/res/js/adminpanel.js"></script>


</body>
</html>
