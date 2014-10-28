var berlin = new google.maps.LatLng(52.520816, 13.410186);

var neighborhoods = [
  new google.maps.LatLng(52.511467, 13.447179),
  new google.maps.LatLng(52.549061, 13.422975),
  new google.maps.LatLng(52.497622, 13.396110),
  new google.maps.LatLng(52.517683, 13.394393)
];

var markers = [];
var iterator = 0;

var map;

function initializeMap() {

	var mexico=new google.maps.LatLng(22.694857,-103.035121);
	
	var mapProp = {
	center:mexico,
	zoom:5,
	mapTypeId:google.maps.MapTypeId.ROADMAP
	};
	
	map=new google.maps.Map(document.getElementById("googleMap"),mapProp); 
   
}



// Removes the markers from the map, but keeps them in the array.
function clearMarkers() {
  setAllMap(null);
  iterator=0;
}

// Sets the map on all markers in the array.
function setAllMap(map) 
{
	for (var i = 0; i < markers.length; i++) 
	{
		markers[i].setMap(map);
	}
}


function addMarker(identifier) 
{
	var lat = serverData.data[identifier].lat;
	var lng = serverData.data[identifier].lng;
	var dataType = serverData.data[identifier].dataType;
	var img = null;
	var subType = null;
	var markerImg = null;
	
	switch(dataType)
	{
		case(1):
		{
			img = '/res/icon/workermarker.png';
			subType = serverData.data[identifier].subType;
			var creationDate = serverData.data[identifier].creationDate;
			setTimeout(function() 
			{
				dropReport(lat,lng,img,identifier,creationDate);
			}, iterator * 200);
		}
		break;
		case(2):
		{
			img = '/res/icon/workermarker.png';
			subType = serverData.data[identifier].subType;
			var creationDate = serverData.data[identifier].creationDate;
			setTimeout(function() 
			{
				dropReport(lat,lng,img,identifier,creationDate);
			}, iterator * 200);
		}
		break;
		case(3):
		{
			img = '/res/icon/workermarker.png';
			label="Trabajadores";
			var workerID = serverData.data[identifier].workerID;
			setTimeout(function() 
			{
				dropWorker(lat,lng,img,identifier,workerID);
			}, iterator * 200);
		}
		break;
	}
	
	iterator++;
}


function dropReport(lat,lng,img,identifier,creationDate)
{
	markersIndex = markers.push(new google.maps.Marker(
	{
		position: new google.maps.LatLng(lat, lng),
		map: map,
		icon: img,
		draggable: false,
		animation: google.maps.Animation.DROP
	}));
	
	markers[markersIndex-1].info = new google.maps.InfoWindow(
	{
		content: '<h5>' + identifier +'</h5><h5>Creado:<br>' + creationDate + '</h5><br><button class="btn btn-lg accept-btn reportMapDetails" data-reportidentifier="' + identifier + '" >Ver Detalles</button><br><br>'
	});
					   
	addReportInfoWindow(markers[markersIndex-1],map);
	
	markers[markersIndex-1].setMap(map);
}


function addReportInfoWindow(marker,map)
{

	google.maps.event.addListener(marker, 'click', function() {
		marker.info.open(map, marker);
		
		$(".reportMapDetails").on("click", function()
		{	
			openMapDetails($(this).data("reportidentifier"));	
		});
	});

}


function dropWorker(lat,lng,img,identifier,workerID)
{
	markersIndex = markers.push(new google.maps.Marker(
	{
		position: new google.maps.LatLng(lat, lng),
		map: map,
		icon: img,
		draggable: false,
		animation: google.maps.Animation.DROP
	}));
	
	markers[markersIndex-1].info = new google.maps.InfoWindow(
	{
		content: '<h5>' + identifier +'</h5><h5>Identificador: ' + workerID + '</h5><br><button class="btn btn-lg accept-btn workerMapDetails" data-workeridentifier="' + identifier + '" >Ver Detalles</button><br><br>'
	});
					   
	addWorkerInfoWindow(markers[markersIndex-1],map);
	
	markers[markersIndex-1].setMap(map);
}



function addWorkerInfoWindow(marker,map)
{
	google.maps.event.addListener(marker, 'click', function() 
	{
		marker.info.open(map, marker);
		
		$(".workerMapDetails").on("click", function()
		{	
			openMapDetails($(this).data("workeridentifier"));	
		});
	});
}


function openMapDetails(identifier)
{
	var type = serverData.data[identifier].dataType;
	
	switch(type)
	{
    	case (1):
    	{
        	console.log(identifier + " selected");
        	
        	$(".wrapper").children().slideUp('slow');
	
        	$("#mapSection").removeClass('active-section');
        	
        	$("#failureSection").addClass('active-section');
        	
        	$("#failureSection").slideDown('slow');
        	
        	openReportDetails(identifier);
        	
    	}
    	break;
    	
    	case (2):
    	{
        	console.log(identifier + " selected");
        	
        	$(".wrapper").children().slideUp('slow');
	
        	$("#mapSection").removeClass('active-section');
        	
        	$("#issueSection").addClass('active-section');
        	
        	$("#issueSection").slideDown('slow');
        	
        	openReportDetails(identifier);
    	}
    	break;
    	
    	case (3):
    	{
        	console.log(identifier + " selected");
        	
        	$(".wrapper").children().slideUp('slow');
	
        	$("#mapSection").removeClass('active-section');
        	
        	$("#workerSection").addClass('active-section');
        	
        	$("#workerSection").slideDown('slow');
        	
        	openWorkerDetails(identifier);
    	}
    	break;
	}
}













