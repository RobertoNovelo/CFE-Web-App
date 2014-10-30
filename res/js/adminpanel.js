var serverData;
var resultsFound = false;
var currentResult = null;
var loadingInterval = null;

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

function showCardErrorMessage(message)
{
	$(".alert-text").html(message);							
	$(".invalidInputsReg").show('slow');
	setTimeout(function()
	{
		$(".invalidInputsReg").hide('slow');
	},2000);
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
    if ( typeof loadingResults.counter == 'undefined' ) {
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
	
		switch(currentResult.dataType)
		{
	    	case (1):
	    	{
	        	console.log("Failure selected");
	    	}
	    	break;
	    	
	    	case (2):
	    	{
	        	console.log("Issue selected");
	    	}
	    	break;
	    	
	    	case (3):
	    	{
	        	console.log("Worker selected");
	    	}
	    	break;
		}
		
		$("#resultHeader").show();
	}
}

function initServerData()
{
	$.post( "/get/admin/data", function(response)
	{	
		serverData = response;
		
	    var dataArray = $.map(serverData.data, function (value, key) { return { value: key, data: value }; });
		
		loadAllListSections();
		
		// Initialize ajax autocomplete:
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
			if((1 == serverData.data[k].dataType) || (1 == serverData.data[k].dataType))
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
	var itemsSubType	= 0;
	
	switch (arr[0])
	{
		case ("all"):
		{
			switch (arr[1])
			{
				case ("pending"):
				{
					alert(arr[1]);
				}
				break;
				case ("inprocess"):
				{
					alert(arr[1]);
				}
				break;
				case ("resolved"):
				{
					alert(arr[1]);
				}
				break;
				case ("closed"):
				{
					alert(arr[1]);
				}
				break;
				case ("all"):
				{
					alert(arr[1]);
				}
				break;
			}
		}
		break;
	}
}

function getListItem()
{
	
}























