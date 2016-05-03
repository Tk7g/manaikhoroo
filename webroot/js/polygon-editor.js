var SITE_URL = '/';

var windowHeight  = $(window).height();
$("#marker-map").css( "height", 0.89*windowHeight );

var map, measure, dotCount, khoroo;

function initialize() {
	var mapOptions = {
		zoom: 12,
		center: new google.maps.LatLng(47.918506, 106.917750),
    streetViewControl: false
	};
	map = new google.maps.Map(document.getElementById('marker-map'),
      mapOptions);
  loadMapData();

	measure = {
		mvcLine: new google.maps.MVCArray(),
		mvcPolygon: new google.maps.MVCArray(),
		mvcMarkers: new google.maps.MVCArray(),
		line: null,
		polygon: null
	};

	$('#reset').click(function(){
		window.location.reload();
	});

	google.maps.event.addListener(map, "click", function(evt) {
    	// When the map is clicked, pass the LatLng obect to the measureAdd function
    	measureAdd(evt.latLng);
	});
}

function measureAdd(latLng) {
	var marker = new google.maps.Marker({
      map: map,
      position: latLng,
      draggable: true,
      raiseOnDrag: false,
      title: "Drag me to change shape",
	});

	// Add this LatLng to our line and polygon MVCArrays
	// Objects added to these MVCArrays automatically update the line and polygon shapes on the map
	measure.mvcLine.push(latLng);
	measure.mvcPolygon.push(latLng);

	// Push this marker to an MVCArray
	// This way later we can loop through the array and remove them when measuring is done
	measure.mvcMarkers.push(marker);

	// Get the index position of the LatLng we just pushed into the MVCArray
	// We'll need this later to update the MVCArray if the user moves the measure vertexes
	var latLngIndex = measure.mvcLine.getLength() - 1;

	// When the measure vertex markers are dragged, update the geometry of the line and polygon by resetting the
	//     LatLng at this position
	google.maps.event.addListener(marker, "drag", function(evt) {
		measure.mvcLine.setAt(latLngIndex, evt.latLng);
		measure.mvcPolygon.setAt(latLngIndex, evt.latLng);
	});

	// When dragging has ended and there is more than one vertex, measure length, area.
	google.maps.event.addListener(marker, "dragend", function() {
		if (measure.mvcLine.getLength() > 1) {
			measureCalc();
		}
	});

	// If there is more than one vertex on the line
	if (measure.mvcLine.getLength() > 1) {

    // If the line hasn't been created yet
    if (!measure.line) {

      // Create the line (google.maps.Polyline)
      measure.line = new google.maps.Polyline({
        map: map,
        clickable: false,
        strokeColor: "#FF0000",
        strokeOpacity: 1,
        strokeWeight: 3,
        path:measure. mvcLine
      });

    }

    // If there is more than two vertexes for a polygon
    if (measure.mvcPolygon.getLength() > 2) {

      // If the polygon hasn't been created yet
      if (!measure.polygon) {

        // Create the polygon (google.maps.Polygon)
        measure.polygon = new google.maps.Polygon({
          clickable: false,
          map: map,
          fillOpacity: 0.25,
          strokeColor: "#FF0000",
          strokeOpacity: 1,
          paths: measure.mvcPolygon
        });

      }

    }
    }

      // If there's more than one vertex, measure length, area.
	if (measure.mvcLine.getLength() > 1) {
		measureCalc();
	}

}

function measureCalc() {
	dotCount = measure.mvcPolygon.getLength();
	var drawnLine = measure.line.getPath();
	var length = Math.round(google.maps.geometry.spherical.computeLength(drawnLine));
	$("#AreaLength").val(length);

	var drawnPolygon = measure.polygon.getPath();
	var area = Math.round(google.maps.geometry.spherical.computeArea(drawnPolygon));
  $("#AreaNum").val(area);

	latlngbounds = new google.maps.LatLngBounds();
  var contentString = '';
	for(var i=0; i < drawnPolygon.getLength(); i++) {
		contentString += '('+drawnPolygon.getAt(i).lat()+','+drawnPolygon.getAt(i).lng()+')';
		latlngbounds.extend(drawnPolygon.getAt(i));
	}
	$("#SectionCoordinate").val(contentString);
}

var actions = {
  crosswalk: {
    action: 'crosswalkBorder',
    color: '#b02020',
  },
  earthground: {
    action: 'earthgroundBorder',
    color: '#7cc242'
  },
  playground: {
    action: 'playgroundBorder',
    color: '#7cc242'
  },
  risks: {
    action: 'risksBorder',
    color: '#b02020'
  },
  torongarts: {
    action: 'torongartsBorder',
    color: '#7cc242'
  }
};

function parseCoordinates(point, callback) {
	if(!point.coordinate || !point.coordinate.length) {
		return;
	} else {
		var coordinates = [];
		if (typeof point.coordinate === 'string') {
			var ptlist = point.coordinate.substring(1, point.coordinate.length - 1).split(')(');
			for (var k = 0; k < ptlist.length; k++) {
				var pt = ptlist[k].split(', ');
				coordinates.push(new google.maps.LatLng(pt[0] * 1, pt[1] * 1));
			}
		} else {
  		for(var k = 0; k < point.coordinate.length; k++) {
	  		coordinates.push(new google.maps.LatLng(point.coordinate[k][0] * 1, point.coordinate[k][1] * 1));
		  }
		}
		callback(coordinates);
	}
}

function addSection(section, actionType) {
	$.getJSON(SITE_URL + 'indicator.php?action=' + actions[actionType].action + '&ids='+section, function(points){
		for (var p = 0; p < points.length; p++) {
			var point = points[p];
			parseCoordinates(point, function(coord) {
				new google.maps.Polygon({
	    		path: coord,
	    		strokeOpacity: 0,
	    		strokeWeight: 0,
	    		fillColor: actions[actionType].color,
	    		fillOpacity: 0.8,
	        map: map,
	        clickable: false
	  		});
			});
		}
	});
}

function addRegion(region, image) {
	$.getJSON(SITE_URL + 'indicator.php?action=regionBorder&region='+region, function(point){
		if(!point.coordinate || !point.coordinate.length) {
			return;
		} else {
			var coord = [];
			var khorooBounds = new google.maps.LatLngBounds();
			for(var k = 0; k < point.coordinate.length; k++) {
			  var pt = new google.maps.LatLng(point.coordinate[k][0], point.coordinate[k][1]);
				khorooBounds.extend(pt);
        coord.push(pt);
			}
			khoroo = new google.maps.Polyline({
    		path: coord,
    		geodesic: true,
    		strokeColor: '#000000',
    		strokeOpacity: 1.0,
    		strokeWeight: 3,
        map: map,
        clickable: false
  		});
      map.fitBounds(khorooBounds);
		}
	});
}
