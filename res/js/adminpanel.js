var serverData;
var workerArr;
var resultsFound = false;
var currentResult = null;
var loadingInterval = null;
var selectedEmployee = null;

$(document).ready(function() {


	$("#resultsContainer").children().hide();
	$(".search-img").attr('src','/res/icon/loading-1.png');
	$(".search-img").attr('src','/res/icon/loading-2.png');
	$(".search-img").attr('src','/res/icon/loading-3.png');
	$(".search-img").attr('src','/res/icon/search-white.png');
	initServerData();

});

$(function() {

	$(".search-bar-btn").on("click",function()
	{
		hideReportResults();
		showReportResults();
	});

	$("#mapSearch").focusin(function()
	{
		hideReportResults();
	});

	$(".search-bar-btn").on("keydown.myPlugin",function(e)
	{
		if(e.which == 13)
		{
			hideReportResults();
			showReportResults();
	    }

	});

	$("#mapSearch").on("keydown.myPlugin",function(e)
	{
		if(e.which == 13)
		{
			hideReportResults();
			showReportResults();
	    }

	});

	$(document).on("keydown.myPlugin",function(e)
	{
		if(e.which == 27)
		{
			hideReportResults();
	    }

	});


	$(".close-search-results").on("click",function()
	{
		hideReportResults();
	});

	$('#showAllResults').on("click", function()
	{
		allResultsHandler();
	});

	$('#assignWorker').on('click',function()
	{
		$('#assignWorkerModal').modal();
	});

	$('#removeReport').on('click',function()
	{
		$('#removeReportModal').modal();
	});

	$('#confirmRemove').on('click',function()
	{
		$.post( "/remove/report", 
		{
			reportTicket: $("#itemReportIDLabel").text()
		}, 
		
		function(response)
		{
			if(response.ok)
			{
				showCardErrorMessage('Eliminado!');
				initServerData();
				setTimeout(function()
				{
					$('#removeReportModal').modal('hide');
					sectionManager(window, "all-all");
				},2000);
			}
			else
			{
				showCardErrorMessage('Ocurrió un error al eliminar al empleado');
			}
		}, 'json')
		.fail(function(d)
		{
			showCardErrorMessage('Ocurrió un error al eliminar al empleado');
		});
	});

	$('#confirmWorker').on('click', function()
	{
		console.log("Worker Confirmed");

		if(selectedEmployee)
		{
			var workerID = serverData.data[selectedEmployee].workerID;

			var reportTicket = $("#itemReportIDLabel").text();

			showCardErrorMessage(reportTicket);

			$.post( "/set/worker/assign", 
			{
				reportTicket: reportTicket,
				workerID: workerID
			}, 
			
			function(response)
			{
				if("OK" == response.requestStatus)
				{
					showCardErrorMessage('Asignado correctamente!');
					$("#itemWorkerName").text(serverData.data[selectedEmployee].workerName);
					$("#itemWorkerName").show();
					$('#assignWorker').text('Cambiar');
					$('#workerSearch').val('');
					selectedEmployee = null;
					initServerData();

					setTimeout(function()
					{
						$('#assignWorkerModal').modal('hide');


					},2000);
				}
				else
				{
					showCardErrorMessage('Ocurrió un error al asignar el empleado');
					selectedEmployee = null;
				}
			}, 'json')
			.fail(function(d)
			{
				selectedEmployee = null;
				showCardErrorMessage('Ocurrió un error al asignar el empleado');
			});

		}
		else
		{
			showCardErrorMessage('Selecciona un empleado');
		}

	});

	$('#confirmAddWorker').on('click', function()
	{
		var workerUserName			= $('#workerUserName').val();
		var workerName 				= $('#workerName').val();
		var workerfLastName			= $('#workerfLastName').val();
		var workersLastName			= $('#workersLastName').val();
		var workerPassword			= $('#workerPassword').val();
		var workerVerifyPassword	= $('#workerVerifyPassword').val();

		if(workerUserName && workerName && workerfLastName && workersLastName && workerPassword && workerVerifyPassword)
		{
			if(workerPassword == workerVerifyPassword)
			{
				$.post( "/set/worker", 
				{
					userName: 	workerUserName,
					password: 	workerPassword,
					name: 		workerName,
					fLastName: 	workerfLastName,
					sLastName: 	workersLastName
				},
				function(response)
				{
					if("OK" == response.requestStatus)
					{
						showCardErrorMessage('Asignado correctamente!');
						
						initServerData();

						setTimeout(function()
						{
							$('#workerUserName').val('');
							$('#workerName').val('');
							$('#workerfLastName').val('');
							$('#workersLastName').val('');
							$('#workerPassword').val('');
							$('#workerVerifyPassword').val('');

							$('#addWorkerModal').modal('hide');

							sectionManager(window, "type-worker");

						},2000);
					}
					else
					{
						showCardErrorMessage('Ocurrió un error al agregar al empleado');
					}
				}, 'json')
				.fail(function(d)
				{
					showCardErrorMessage('Ocurrió un error al agregar al empleado');
				});
			}
			else
			{
				showCardErrorMessage('Las contraseñas no coinciden!');
			}
		}
		else
		{
			showCardErrorMessage('Por favor completa los campos!');
		}

	});

	$('#userPush').on('click', function()
	{
		var message = $('#userPushMessage').val();

		if(message)
		{
			$.post( "/send/user/push_message_to_all", 
			{
				pushMessage: message
			}, 
			function(response)
			{
				if(response.ok)
				{
					showCardErrorMessage('Mensaje enviado a los usuarios!');
					$('#pushMessage').val('');
				}
				else
				{
					showCardErrorMessage('Ocurrió un error al enviar el mensaje');
				}
			}, 'json')
			.fail(function(d)
			{
				showCardErrorMessage('Ocurrió un error al enviar el mensaje');
			});
		}
		else
		{
			showCardErrorMessage('Introduce un mensaje para los usuarios!');
		}

	});

	$('#workerPush').on('click', function()
	{
		var message = $('#workerPushMessage').val();

		if(message)
		{
			$.post( "/send/worker/push_message_to_all", 
			{
				pushMessage: message
			}, 
			function(response)
			{
				if(response.ok)
				{
					showCardErrorMessage('Mensaje enviado a los empleados!');
					$('#pushMessage').val('');
				}
				else
				{
					showCardErrorMessage('Ocurrió un error al enviar el mensaje');
				}
			}, 'json')
			.fail(function(d)
			{
				showCardErrorMessage('Ocurrió un error al enviar el mensaje');
			});
		}
		else
		{
			showCardErrorMessage('Introduce un mensaje para los empleados!');
		}

	});

});

function allResultsHandler()
{
	clearMarkers();
	hideReportResults();
	for(var k in serverData.data)
	{
		if(!serverData.data[k].all)
		{
			if(currentResult.dataType == serverData.data[k].dataType)
			{
				addMarker(k);
			}
		}
	}
}

google.maps.event.addDomListener(window, 'load', initializeMap);


function initialize()
{

    var mexico=new google.maps.LatLng(22.694857,-103.035121);

	var mapProp = {
	center:mexico,
	zoom:5,
	mapTypeId:google.maps.MapTypeId.ROADMAP
	};

	map=new google.maps.Map(document.getElementById("googleMap"),mapProp);

}


function sectionManager(context,args)
{/*

	alert(args);
	$(context).slideUp();
*/
}

function showReportResults()
{

	startLoadingReportResults();
	setTimeout(function()
	{
		if(resultsFound)
		{
			$("#resultsContainer").children().hide();
			reportResultsHandler();
			$(".search-results-container").slideDown(200);
		}
		else
		{
			$("#resultsContainer").children().hide();
			$("#noResultsContainer").show();
			$(".search-results-container").slideDown(200);
		}

		stopLoadingReportResults();
	},2000);

}

function hideReportResults()
{
	$(".search-results-container").slideUp(200);
}

function startLoadingReportResults()
{
	$(".search-img").attr('src','/res/icon/loading-1.png');
    loadingInterval = setInterval(loadingResults,200);
}

function loadingResults()
{
	// Check to see if the counter has been initialized
    if ( typeof loadingResults.counter == 'undefined' )
    {
        // It has not... perform the initialization
        loadingResults.counter = 0;
    }

    $(".search-img").attr('src','/res/icon/loading-'+ (++loadingResults.counter) + ".png");

    console.log(loadingResults.counter);

    if(3<= loadingResults.counter)
    {
	    loadingResults.counter=0;
    }

}

function stopLoadingReportResults()
{
	clearInterval(loadingInterval);
	$(".search-img").attr('src','/res/icon/search-white.png');
}

function reportResultsHandler()
{
	if(currentResult.all)
	{
		var total=currentResult.total;
		var label=null;
		switch(currentResult.dataType)
		{
			case(1):
			{
				label="Fallas";
			}
			break;
			case(2):
			{
				label="Quejas";
			}
			break;
			case(3):
			{
				label="Trabajadores";
			}
			break;
		}
		$("#totalLabel").html(label);
		$("#totalNumberLabel").html(total);
		$("#allResultsContainer").show();
	}
	else
	{
		var total=1;
		var label=null;

		switch(currentResult.dataType)
		{
	    	case(1):
			{
				label="Fallas";
			}
			break;
			case(2):
			{
				label="Quejas";
			}
			break;
			case(3):
			{
				label="Trabajadores";
			}
			break;
		}

		$("#totalLabel").html(label);
		$("#totalNumberLabel").html(total);
		$("#allResultsContainer").show();
	}
}

function initServerData()
{
	$.post( "/get/admin/data", function(response)
	{
		serverData = response;

		var workerData = new Object;

		workerData.data = new Object;

		for(var k in serverData.data)
		{
			if(!serverData.data[k].all)
			{
				if(3 == serverData.data[k].dataType)
				{
					workerData.data[k] = serverData.data[k];
				}
			}
		}


		workerArr = $.map(workerData.data, function (value, key) { return { value: key, data: value }; });

	    var dataArray = $.map(serverData.data, function (value, key) { return { value: key, data: value }; });

		loadAllListSections();

		//Erase previous data
		$('#mapSearch').autocomplete('clear');

		// Initialize autocomplete:
	    $('#mapSearch').autocomplete({
	        // serviceUrl: '/autosuggest/service/url',
	        lookup: dataArray,
	        groupBy: 'category',
	        lookupFilter: function(suggestion, originalQuery, queryLowerCase) {
	            var re = new RegExp('\\b' + $.Autocomplete.utils.escapeRegExChars(queryLowerCase), 'gi');
	            return re.test(suggestion.value);
	        },
	        onSelect: function(suggestion) {
	            console.log('You selected: ' + suggestion.value + ', ' + suggestion.data.dataType);

	            console.log('Results Loaded');

	            resultsFound = true;
	            currentResult = suggestion.data;

	        },
	        onHint: function (hint) {
	            console.log(hint);
	        },
	        onInvalidateSelection: function() {
	            resultsFound = false;
	            console.log('You selected: none');
	        }
	    });

	    //Erase previous data
	    $('#workerSearch').autocomplete('clear');

	    // Initialize autocomplete:
	    $('#workerSearch').autocomplete({
	        // serviceUrl: '/autosuggest/service/url',
	        lookup: workerArr,
	        groupBy: 'category',
	        lookupFilter: function(suggestion, originalQuery, queryLowerCase) {
	            var re = new RegExp('\\b' + $.Autocomplete.utils.escapeRegExChars(queryLowerCase), 'gi');
	            return re.test(suggestion.value);
	        },
	        onSelect: function(suggestion) {
	            console.log('You selected: ' + suggestion.value + ', ' + suggestion.data.dataType);

	            console.log('Results Loaded');

	            selectedEmployee = suggestion.value;

	        },
	        onHint: function (hint) {
	            console.log(hint);
	        },
	        onInvalidateSelection: function() {
	            resultsFound = false;
	            console.log('You selected: none');
	        }
	    });

	}, 'json')
	.fail(function(e)
	{
		alert('bad server json');
	});
}

function loadMap()
{
	console.log('Map section selected');
}

function loadNotifications()
{
	console.log('Notifications section selected');
}


function openReportDetails(identifier)
{
	var reportType = serverData.data[identifier].dataType;

	if(1 == reportType)
	{

	}
	else
	{

	}

}

function loadingDetails(section)
{

}


function openWorkerDetails(identifier)
{
	var reportType = serverData.data[identifier].dataType;
}


function loadAllListSections()
{
	console.log('Sections loaded successfully');
}

function getAllReportsList()
{
	var html = '';

	for(var k in serverData.data)
	{
		if(!serverData.data[k].all)
		{
			if((1 == serverData.data[k].dataType) || (2 == serverData.data[k].dataType))
			{
				addMarker(k);
			}
		}
	}

}

function sectionManager(context,args)
{
	var arr = args.split('-');

	var itemsDataType	= 0;
	var status			= 0;
	var type			= 0;
	var itemsSubType	= 0;
	var selectBy		= "type";

	switch (arr[0])
	{
		case ("all"):
		{

			selectBy = "status";

			switch (arr[1])
			{
				case ("pending"):
				{
					status = 1;
				}
				break;
				case ("inprocess"):
				{
					status = 2;
				}
				break;
				case ("resolved"):
				{
					status = 3;
				}
				break;
				case ("closed"):
				{
					status = 4;
				}
				break;
				case ("all"):
				{
					status = 5;
				}
				break;
			}

			buildList(selectBy,status);

		}
		break;

		case ("type"):
		{

			selectBy = "type";

			switch (arr[1])
			{
				case ("failure"):
				{
					type = 1;
				}
				break;
				case ("issue"):
				{
					type = 2;
				}
				break;
				case ("worker"):
				{
					type = 3;
				}
				break;			
			}

			buildList(selectBy,type);

		}
		break;


	}
}

function buildList(selector,subselector)
{
	$("#listView").slideUp('slow');
	$("#itemDetails").slideUp('slow');

	setTimeout( function()
	{

		$("#listView").empty();

		var htmlChild = null;

		for(var k in serverData.data)
		{
			if(!serverData.data[k].all)
			{	
				if("status" == selector)
				{
					if((1 == serverData.data[k].dataType) || (2 == serverData.data[k].dataType))
					{
						//All items
						if(5 == subselector)
						{
							htmlChild = '<div class="row card-container list-item"><div class="col-xs-3"><img class="map-preview" src="http://maps.googleapis.com/maps/api/staticmap?center=' + serverData.data[k].lat + ','+ serverData.data[k].lng +'&zoom=15&size=150x150&maptype=terrain&markers=color:blue%7C'+ serverData.data[k].lat +','+ serverData.data[k].lng +'&sensor=false"></div><div class="col-xs-6"><div class="row"><div class="col-xs-12"><h5>ID: '+ serverData.data[k].reportTicket +'</h5></div></div><div class="row"><div class="col-xs-12"><h5>Creation Date: '+ serverData.data[k].creationDate +'</h5></div></div></div><div class="col-xs-3"><button data-listreportidentifier="'+ k + '" class="btn btn-lg accept-btn listReportDetails">Detalles</button></div></div>';
		
		            		addListChild(htmlChild);
						}
						else if(subselector == serverData.data[k].status)
						{
							htmlChild = '<div class="row card-container list-item"><div class="col-xs-3"><img class="map-preview" src="http://maps.googleapis.com/maps/api/staticmap?center=' + serverData.data[k].lat + ','+ serverData.data[k].lng +'&zoom=15&size=150x150&maptype=terrain&markers=color:blue%7C'+ serverData.data[k].lat +','+ serverData.data[k].lng +'&sensor=false"></div><div class="col-xs-6"><div class="row"><div class="col-xs-12"><h5>ID: '+ serverData.data[k].reportTicket +'</h5></div></div><div class="row"><div class="col-xs-12"><h5>Creation Date: '+ serverData.data[k].creationDate +'</h5></div></div></div><div class="col-xs-3"><button data-listreportidentifier="'+ k + '" class="btn btn-lg accept-btn listReportDetails">Detalles</button></div></div>';
		
		            		addListChild(htmlChild);
						}
					}
				}
				else if("type" == selector)
				{
					//Select type
					if(subselector == serverData.data[k].dataType)
					{
						htmlChild = '<div class="row card-container list-item"> <div class="col-xs-4"> <div class="row"> <div class="col-xs-12"> <h5>Nombre:</h5> <h5>'+ serverData.data[k].workerName +'</h5> </div></div></div><div class="col-xs-4"> <div class="row"> <div class="col-xs-12"> <h5>Reportes Asignados:</h5> <h5>0</h5> </div></div></div><div class="col-xs-4"> </div></div>';
						
						//worker details button
						//<button data-listworkeridentifier="' + k + '" class="btn btn-lg accept-btn listWorkerDetails">Detalles</button>

	            		addListChild(htmlChild);

	            		console.log(serverData.data[k].dataType);

					}
				}
			}
		}

		if("type" == selector)
		{
			if( 3 == subselector)
			{
				addListChild('<div class="row list-item center-text"> <div class="col-xs-12"> <button class="btn btn-lg accept-btn addWorker">Agregar Empleado</button> </div></div>');
			}
		}

		$(document).on("click",'.listReportDetails', function()
		{
			showReportDetails($(this).data('listreportidentifier'));
		});

		$(document).on("click",'.listWorkerDetails', function()
		{
			console.log('worker details');
		});

		$(document).on("click",'.addWorker', function()
		{
			$('#addWorkerModal').modal();
		});


		$("#listView").slideDown('slow');
	},1000);

}

function addListChild(html)
{
	$("#listView").append(html);
}

function showReportDetails(itemID)
{
	var itemTicket			= serverData.data[itemID].reportTicket;
	var itemType			= serverData.data[itemID].dataType;
	var itemSubType			= serverData.data[itemID].subType;
	var itemDescription		= serverData.data[itemID].desc;
	var itemLat				= serverData.data[itemID].lat;
	var itemLng				= serverData.data[itemID].lng;
	var itemPublicCom		= serverData.data[itemID].publicComments;
	var itemPrivateCom		= serverData.data[itemID].privateComments;
	var itemStatus 			= serverData.data[itemID].status;
	var itemCreationDate	= serverData.data[itemID].creationDate;
	var itemLastUpdate		= serverData.data[itemID].lastUpdate;
	var itemWorkerName		= serverData.data[itemID].workerName;

	$("#detailsMapPreview").attr({
		src: 'http://maps.googleapis.com/maps/api/staticmap?center=' + itemLat + ','+ itemLng +'&zoom=15&size=640x640&maptype=terrain&markers=color:blue%7C' + itemLat + ','+ itemLng + '&sensor=false'
	});
	
	$("#itemReportIDLabel").text(itemTicket);
	$("#itemTypeLabel").text(itemType);
	$("#itemStatusLabel").text(itemStatus);
	$("#itemCreationDateLabel").text(itemCreationDate);

	if(itemWorkerName)
	{
		$("#itemWorkerName").text(itemWorkerName);
		$("#itemWorkerName").show();
		$('#assignWorker').text('Cambiar');
	}
	else
	{
		$("#itemWorkerName").hide();
		$('#assignWorker').text('Asignar');
	}

	$("#listView").slideUp('slow', function()
	{
		//Details animation is seen until list slideUp Animation is completed
		$("#itemDetails").slideDown('slow');
	});

	console.log(workerArr);

}

function showCardErrorMessage(message)
{
	$(".alert-text").html(message);							
	$(".invalidInputsReg").show('slow');
	setTimeout(function()
	{
		$(".invalidInputsReg").hide('slow');
	},2000);
}


















