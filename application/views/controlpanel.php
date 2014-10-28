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
      src="http://maps.googleapis.com/maps/api/js?key=AIzaSyC2p5YQdcMx7CxChpTC31q4IarKUhdVfwA&sensor=FALSE">
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
                    <a href="#" tabindex="-1">
                        Profile
                    </a>
                </li>
                <li>
                    <a href="#" tabindex="-1">
                        Settings
                    </a>
                </li>
                <li>
                    <a href="#" tabindex="-1">
                        Help
                    </a>
                </li>
                <li>
                    <a href="#" tabindex="-1">
                        Exit
                    </a>
                </li>
            </ul>
        </li>
        <li>
            <a class="menu-action" data-section="mapSection" data-handler="loadMap" data-args="google">
                <i class="sidebar-icon icon-material-inbox"></i>
                Mapa
            </a>
        </li>
        <!--
<li>
        
                <div class="sidebar-icon truck svg-ic_local_shipping_24px"></div>
                <i class="sidebar-icon icon-material-road"></i>
            <a class="menu-action" data-handler="sectionManager" data-args="reports">
                <i class="sidebar-icon icon-material-star"></i>
                Reportes
            </a>
        </li>
        <li>
            <a class="menu-action" data-handler="sectionManager" data-args="workers">
                <i class="sidebar-icon icon-material-send"></i>
                Trabajadores
            </a>
        </li>
        <li>
            <a class="menu-action" data-handler="sectionManager" data-args="assign">
                <i class="sidebar-icon icon-material-drafts"></i>
                Asignar
            </a>
        </li>
-->
        <li class="divider"></li>
        <li class="dropdown">
            <a class="ripple-effect dropdown-toggle" href="#" data-toggle="dropdown">
                Todos los reportes
                <b class="caret"></b>
            </a>
            <ul class="dropdown-menu">
                <li>
	                <a class="menu-action" data-handler="sectionManager" data-args="pending">
                        Pendientes
                        <span class="sidebar-badge badge-circle">10</span>
                    </a>
                </li>
                <li>
	                <a class="menu-action" data-handler="sectionManager" data-args="inProcess">
                        En proceso
                        <span class="sidebar-badge badge-circle">10</span>
                    </a>
                </li>
                <li>
	                <a class="menu-action" data-handler="sectionManager" data-args="resolved">
                        Resueltos
                        <span class="sidebar-badge badge-circle">10</span>
                    </a>
                </li>
                <li>
	                <a class="menu-action" data-handler="sectionManager" data-args="closed">
                        Cerrados
                        <span class="sidebar-badge badge-circle">10</span>
                    </a>
                </li>
                <li>
	                <a class="menu-action" data-handler="sectionManager" data-args="closed">
                        Todos
                        <span class="sidebar-badge badge-circle">10</span>
                    </a>
                </li>
            </ul>
        </li>
        
        <li class="dropdown">
            <a class="ripple-effect dropdown-toggle" href="#" data-toggle="dropdown">
                Fallas
                <b class="caret"></b>
            </a>
            <ul class="dropdown-menu">
                <li>
	                <a class="menu-action" data-handler="sectionManager" data-args="pending">
                        Pendientes
                        <span class="sidebar-badge badge-circle">10</span>
                    </a>
                </li>
                <li>
	                <a class="menu-action" data-handler="sectionManager" data-args="inProcess">
                        En proceso
                        <span class="sidebar-badge badge-circle">10</span>
                    </a>
                </li>
                <li>
	                <a class="menu-action" data-handler="sectionManager" data-args="resolved">
                        Resueltos
                        <span class="sidebar-badge badge-circle">10</span>
                    </a>
                </li>
                <li>
	                <a class="menu-action" data-handler="sectionManager" data-args="closed">
                        Cerrados
                        <span class="sidebar-badge badge-circle">10</span>
                    </a>
                </li>
                <li>
	                <a class="menu-action" data-section="failureSection" data-handler="sectionManager" data-args="closed">
                        Todos
                        <span class="sidebar-badge badge-circle">10</span>
                    </a>
                </li>
            </ul>
        </li>
        <li class="dropdown">
            <a class="ripple-effect dropdown-toggle" href="#" data-toggle="dropdown">
                Quejas
                <b class="caret"></b>
            </a>
            <ul class="dropdown-menu">
                <li>
	                <a class="menu-action" data-handler="sectionManager" data-args="pending">
                        Pendientes
                        <span class="sidebar-badge badge-circle">10</span>
                    </a>
                </li>
                <li>
	                <a class="menu-action" data-handler="sectionManager" data-args="inProcess">
                        En proceso
                        <span class="sidebar-badge badge-circle">10</span>
                    </a>
                </li>
                <li>
	                <a class="menu-action" data-handler="sectionManager" data-args="resolved">
                        Resueltos
                        <span class="sidebar-badge badge-circle">10</span>
                    </a>
                </li>
                <li>
	                <a class="menu-action" data-handler="sectionManager" data-args="closed">
                        Cerrados
                        <span class="sidebar-badge badge-circle">10</span>
                    </a>
                </li>
                <li>
	                <a class="menu-action" data-section="issueSection" data-handler="sectionManager">
                        Todos
                        <span class="sidebar-badge badge-circle">10</span>
                    </a>
                </li>
            </ul>
        </li>
        
        <li>
            <a class="menu-action" data-section="workerSection">
                Trabajadores
                <span class="sidebar-badge">3</span>
            </a>
        </li>
        <li>
            <a class="menu-action">
                Sucursales
                <span class="sidebar-badge badge-circle">456</span>
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
    
    <div id="failureSection">
    	
    	<div id="fLoading">
    	</div>
    
    	<div id="failureList">
    	</div>
    	
    	<div id="failureDetails">
    		
    		<div class="report-details center-text">
    			<div class="row">
    				<div class="col-xs-12">
    					<h2>Novelo</h2>
    				</div>
    			</div>
    			<div class="row">
    			
    				<div class="col-xs-12">
    					<h2>Novelo</h2>
    				</div>
    			
    			</div>
    			<div class="row">
    			
    				<div class="col-xs-12">
    					<h2>Novelo</h2>
    				</div>
    			
    			</div>
    			<div class="row">
    			
    				<div class="col-xs-12">
    					<h2>Novelo</h2>
    				</div>
    			
    			</div>
    			<div class="row">
    				<div class="col-xs-12">
    					<h2>Novelo</h2>
    				</div>
    			
    			</div>
    			<div class="row">
    			
    				<div class="col-xs-12">
    					<h2>Novelo</h2>
    				</div>
    			
    			</div>
    			<div class="row">
    			
    				<div class="col-xs-12">
    					<h2>Novelo</h2>
    				</div>
    			
    			</div>
    			<div class="row">
    			
    				<div class="col-xs-12">
    					<h2>Novelo</h2>
    				</div>
    			
    			</div>
    			<div class="row">
    			
    				<div class="col-xs-12">
    					<h2>Novelo</h2>
    				</div>
    			
    			</div>
    			
    		</div>
    		
    	
    		<div class="report-details-map">
    		</div>
    		<div class="back-to-list-section">
    			<button id="fBackToList" class="btn btn-lg accept-btn">Volver a la Lista</button>
    		</div>
    	</div>
    
	</div>
    
    <div id="issueSection">
    
    	<div id="sLoading">
    	</div>
    	
    	<div id="issueList">
    	</div>
    	
    	<div id="issueDetails">
    		
    	</div>
    
	</div>
    
    
    <div id="workerSection">
    
    	<div id="wLoading">
    	</div>
    	
    	<div id="workerList">
    	</div>
    	
    	<div id="workerDetails">
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
