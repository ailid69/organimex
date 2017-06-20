var map;
var marker;
var infowindow;
var messagewindow;

  
function initMap() {
	var jocotan = {lat: 20.6872101, lng: -103.4388916};
	var geocoder = new google.maps.Geocoder;
	
	map = new google.maps.Map(document.getElementById('map'), {
	  center: jocotan,
	  zoom: 13
	});
	mapTypeId: 'roadmap';

	infowindow = new google.maps.InfoWindow({
		content: document.getElementById('gmap_form')
	});	
	
	messagewindow = new google.maps.InfoWindow({
		content: document.getElementById('message')
	});
	
	google.maps.event.addListener(map, "click", function(event) {
		console.log('click on map');
		if (marker == null){
			marker = new google.maps.Marker({
				position: event.latLng,
				map: map
			});
		}
		else{
			marker.setPosition(event.latLng,);
		}	
		
		google.maps.event.addListener(marker, "click", function() {
			 geocoder.geocode({'location': marker.getPosition()}, function(results, status) {
				if (status === 'OK') {
					if (results[0]) {
              
              $('#inputAddress').val(results[1].formatted_address);

            } else {
              console.log('GeoCoder - No results found');
            }
          } else {
            console.log('Geocoder failed due to: ' + status);
          }
        });
			infowindow.open(map, marker);
			$('#gmap_form').removeAttr('hidden');
			console.log('click on marker');
		});
		google.maps.event.trigger(marker, 'click');
	});
	
}
	
function saveData() {
	var name = escape(document.getElementById("inputName").value);
	var address = escape(document.getElementById("inputAddress").value);
	var status = $('input[name="inputType"]:checked').val();
	var latlng = marker.getPosition();
	var url = "insertNewPlace.php?name=" + name + "&address=" + address +
			"&status=" + status + "&lat=" + latlng.lat() + "&lng=" + latlng.lng();

	downloadUrl(url, function(data, responseCode) {
		if (responseCode == 200 && data.length <= 1) {
			infowindow.close();
			$('message').prop( "hidden", null );
			messagewindow.open(map, marker);
			console.log ('return code is good');
		}
		else {
			console.log ('return code is shitty');
		}
	});
}

 function downloadUrl(url, callback) {
	var request = window.ActiveXObject ?
		new ActiveXObject('Microsoft.XMLHTTP') :
		new XMLHttpRequest;

	request.onreadystatechange = function() {
	  if (request.readyState == 4) {
		request.onreadystatechange = doNothing;
		callback(request, request.status);
	  }
	};

	request.open('GET', url, true);
	request.send(null);
  }

  function doNothing () {
  }
	