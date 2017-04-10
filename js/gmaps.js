var map;
var marker;
var infowindow;
var messagewindow;
var icons;

var customLabel = {
  opened: {
    label: 'A',
	icon: 'img/map-marker-green.png'
  },
  closed: {
    label: 'C',
	icon: 'img/map-marker-red.png'
  },
   project: {
    label: 'P',
	icon: 'img/map-marker-blue.png'
  },
     demo: {
    label: 'D',
	icon: 'img/map-marker-default.png'
  }
};
  
  
function initMap() {
	var jocotan = {lat: 20.6872101, lng: -103.4388916};

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
	
	/*google.maps.event.addListener(map, "click", function(event) {
		marker = new google.maps.Marker({
			position: event.latLng,
			map: map
		});
		console.log('click on map');
		google.maps.event.addListener(marker, "click", function() {
			infowindow.open(map, marker);
			$('newPlaceForm').prop( "hidden", null );
			console.log('click on marker');
		});
	});*/
	
	
	loadMarkers('dbmarkers2xml.php');

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
		}
	});
}
function loadMarkers(XMLFile) {
  console.log('XML File : ' + XMLFile);
  downloadUrl(XMLFile, function(data) {
  console.log('data : ' + data);
  var xml = data.responseXML;
  console.log('XML : ' + xml);
  var markers = xml.documentElement.getElementsByTagName('marker');
  Array.prototype.forEach.call(markers, function(markerElem) {
    var name = markerElem.getAttribute('name');
    var address = markerElem.getAttribute('address');
    var status = markerElem.getAttribute('status');
    var point = new google.maps.LatLng(
        parseFloat(markerElem.getAttribute('lat')),
        parseFloat(markerElem.getAttribute('lng')));

    var infowincontent = document.createElement('div');
    var strong = document.createElement('strong');
    strong.textContent = name
    infowincontent.appendChild(strong);
    infowincontent.appendChild(document.createElement('br'));

    var text = document.createElement('text');
    text.textContent = address
    infowincontent.appendChild(text);
    var icon = customLabel[status] || {};
    var marker = new google.maps.Marker({
      map: map,
      position: point,
      icon: icon.icon,
	  label: icon.label
    });
	marker.addListener('click', function() {
		infowindow.setContent(infowincontent);
		infowindow.open(map, marker);
		console.log('click on Marker');
	});
  });	
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
	