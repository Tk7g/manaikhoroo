var map, infoWindow;
var SITE_URL = '/';

/* khoroo filters */
var knownBounds = {};
var khoroos = {};
var currentKhoroo = null;

/* circle helpers */
var circles = [];

function processWalkCircles(point, walkid) {
	if(!point.coordinate || !point.coordinate.length) {
		return;
	}
	var reader = new jsts.io.GeoJSONReader();
	var writer = new jsts.io.GeoJSONWriter();

	var buffers = [];

	for(var k = 0; k < point.coordinate.length; k++) {
		var setmap = map;
		if (currentKhoroo && google.maps.geometry.poly.containsLocation(new google.maps.LatLng(point.coordinate[k][1] * 1, point.coordinate[k][0] * 1),
		  khoroos[currentKhoroo])) {
			setmap = null;
		}

		point.coordinate[k].reverse();
		var centroid = reader.read({
			type: 'Point',
			coordinates: [point.coordinate[k][1] * 1, point.coordinate[k][0] * 1]
		});

		var smallest = 0.001;
		if (!buffers.length) {
			buffers.push(centroid.buffer(smallest));
			buffers.push(centroid.buffer(smallest * 2));
			buffers.push(centroid.buffer(smallest * 3));
			buffers.push(centroid.buffer(smallest * 4));
		} else {
			buffers[0] = buffers[0].union(centroid.buffer(smallest));
			buffers[1] = buffers[1].union(centroid.buffer(smallest * 2));
			buffers[2] = buffers[2].union(centroid.buffer(smallest * 3));
			buffers[3] = buffers[3].union(centroid.buffer(smallest * 4));
		}
  }

	var fills = ['#013167', '#3c82d1', '#7fbbff', '#d2e7ff'];
	if (walkid === '1') {
		fills = ['#00371d', '#33bb7a', '#76f3b7', '#d7ffec'];
	}

	function googlyPolygon(rings, color) {
		if (!rings) {
			return;
		}
		for (var r = 0; r < rings.length; r++) {
			rings[r].pop();
			for (var pt = 0; pt < rings[r].length; pt++) {
				rings[r][pt] = new google.maps.LatLng(rings[r][pt][0] * 1, rings[r][pt][1] * 1);
			}
		}
		circles.push(new google.maps.Polygon({
			path: rings[0],
			clickable: false,
			fillColor: color,
			strokeWeight: 0,
			strokeOpacity: 0,
			fillOpacity: 0.1,
			map: setmap
		}));
	}

	for (var b = 0; b < buffers.length; b++) {
		buffers[b] = writer.write(buffers[b]);
		if (buffers[b].type === 'MultiPolygon') {
			for (var p = 0; p < buffers[b].coordinates.length; p++) {
				googlyPolygon(buffers[b].coordinates[p], fills[b]);
			}
		} else {
			googlyPolygon(buffers[b].coordinates, fills[b]);
		}
	}
}

function removeWalk(type, district) {
	if(type == "walk-bus") {
		var walkid = 1;
	} else {
		var walkid = 2;
	}
	for (var c = 0; c < circles.length; c++) {
		circles[c].setMap(null);
	}
}

/* kheseg boundaries */
var styleByRegion = {};
var strokeStyle = {
	fillOpacity: 0,
	opacity: 0,
	weight: 0,
	color: '#fff'
};

function addSections() {
	strokeStyle = {
		fillOpacity: strokeStyle.fillOpacity,
		opacity: 1,
		color: '#7dd303',
		weight: 2,
		clickable: false
	};
	// confirm GeoJSON borders loaded and trigger re-paint
	setRegionColor('x', null);
}

function removeSections() {
	strokeStyle = {
		fillOpacity: strokeStyle.fillOpacity,
		opacity: 0,
		weight: 0,
		color: '#fff'
	};
	// confirm GeoJSON borders loaded and trigger re-paint
	setRegionColor('x', null);
}

function removeRegionColor() {
	strokeStyle.fillOpacity = 0;
	map.data.setStyle({
		fillOpacity: strokeStyle.fillOpacity,
		strokeColor: strokeStyle.color,
		strokeOpacity: strokeStyle.opacity,
		strokeWeight: strokeStyle.weight
	});
}

/* single point markers */
var markers = {};

function loadMarkers(point, typeid) {
  if (!point) {
    // no new data
    return;
  }
  var markmaker = point.marker || point.coordinate;
  if (!markmaker || !markmaker.length) {
    return;
  }

  var iconImg;
  var zoomlevel = map.getZoom();
  if(typeid != 7) {
    var levelmultiplier = zoomlevel-9;
    iconImg = {
      url: point.image.image,
      size: new google.maps.Size(levelmultiplier*4, levelmultiplier*4),
      origin: new google.maps.Point(0,0),
      anchor: new google.maps.Point(levelmultiplier*4/2,levelmultiplier*4),
      scaledSize: new google.maps.Size(levelmultiplier*4, levelmultiplier*4)
    };
  } else {
    if(zoomlevel < 14) {
      var subtract = zoomlevel - 1;
    } else {
      var subtract = 11;
    }
    var levelmultiplier = zoomlevel - subtract;
    iconImg = {
      url: point.image.image,
      size: new google.maps.Size(levelmultiplier, levelmultiplier),
      origin: new google.maps.Point(0,0),
      anchor: new google.maps.Point(levelmultiplier,levelmultiplier),
      scaledSize: new google.maps.Size(levelmultiplier, levelmultiplier)
    };
  }
  if (!markers[typeid]) {
    markers[typeid] = [];
  }
  for(var k = 0; k < markmaker.length; k++) {
    markers[typeid].push(new google.maps.Marker({
      position: new google.maps.LatLng(markmaker[k][0], markmaker[k][1]),
      map: map,
      icon: iconImg
    }));
  }
}

function removeMarker(typeid) {
	if (!markers[typeid] || !markers[typeid].length) {
		return console.log('did not find any markers with type: ' + typeid);
	}
	for (var m = 0; m < markers[typeid].length; m++) {
		markers[typeid][m].setMap(null);
	}
}

/* polygon area markers */
var floods = [];
var playgrounds = [];
var roads = [];

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

function addPlaygrounds() {
	if (playgrounds.length) {
		for (var p = 0; p < playgrounds.length; p++) {
			playgrounds[p].setMap(map);
		}
		return;
	}
	$.getJSON(SITE_URL + 'indicator.php?action=playgroundBorder&ids='+pgids.join(','), function(pgs){
		for (var p = 0; p < pgs.length; p++) {
			var point = pgs[p];
			parseCoordinates(point, function(coordinates) {
				playgrounds.push(new google.maps.Polygon({
    			 path: coordinates,
    			 strokeColor: '#4a9e32',
    			 strokeOpacity: 1,
    			 strokeWeight: 2,
    			 fillColor: '#a7d392',
    			 fillOpacity: 0.6,
					 map: map
  			}));
			});
		}
	});
}

function addRoads() {
	if (roads.length) {
		for (var p = 0; p < roads.length; p++) {
			roads[p].setMap(map);
		}
		return;
	}
	$.getJSON(SITE_URL + 'indicator.php?action=roadBorder&ids='+rdids.join(','), function(rds){
		for (var r = 0; r < rds.length; r++) {
			var point = rds[r];
			parseCoordinates(point, function(coordinates) {
				roads.push(new google.maps.Polyline({
    			 path: coordinates,
    			 geodesic: true,
    			 strokeColor: '#fbdc00',
    			 strokeOpacity: 1.0,
    			 strokeWeight: 2,
					 map: map
  			}));
			});
		}
	});
}


function addFloods() {
	if (floods.length) {
		for (var p = 0; p < floods.length; p++) {
			floods[p].setMap(map);
		}
		return;
	}
	$.getJSON(SITE_URL + 'indicator.php?action=risksBorder&ids='+flids.join(','), function(fls){
		for (var f = 0; f < fls.length; f++) {
			var point = fls[f];
			parseCoordinates(point, function (coordinates) {
				floods.push(new google.maps.Polygon({
    			 path: coordinates,
    			 strokeColor: '#900202',
    			 strokeOpacity: 1,
    			 strokeWeight: 2,
    			 fillColor: '#d40202',
    			 fillOpacity: 0.6,
					 map: map
  			}));
			});
		}
	});
}

function removeFloods() {
	for (var p = 0; p < floods.length; p++) {
		floods[p].setMap(null);
	}
}

function removePlaygrounds() {
	for (var p = 0; p < playgrounds.length; p++) {
		playgrounds[p].setMap(null);
	}
}

function removeRoads() {
  for (var r = 0; r < roads.length; r++) {
		roads[r].setMap(null);
	}
}

/* KMZ network data */
var kmzMobinet, kmzGmobile, kmzTopnet, kmzUnivision, kmzMagicnet, kmzNiislel, kmzZhut;

function addMobinet() {
	kmzMobinet = new google.maps.KmlLayer('//manaikhoroo.ub.gov.mn/webroot/mobinet.kmz', {
		preserveViewport: true,
		map: map
	});
}

function removeMobinet() {
	kmzMobinet.setMap(null);
}

function addGmobile() {
	kmzGmobile = new google.maps.KmlLayer('//manaikhoroo.ub.gov.mn/webroot/gmobile.kmz', {
		preserveViewport: true,
		map: map
	});
}

function removeGmobile() {
	kmzGmobile.setMap(null);
}

function addTopnet() {
	kmzTopnet = new google.maps.KmlLayer('//manaikhoroo.ub.gov.mn/webroot/topnet.kmz', {
		preserveViewport: true,
		map: map
	});
}

function removeTopnet() {
	kmzTopnet.setMap(null);
}

function addUnivision() {
	kmzUnivision = new google.maps.KmlLayer('//manaikhoroo.ub.gov.mn/webroot/univision.kmz', {
		preserveViewport: true,
		map: map
	});
}

function removeUnivision() {
	kmzUnivision.setMap(null);
}

function addMagicnet() {
	kmzMagicnet = new google.maps.KmlLayer('//manaikhoroo.ub.gov.mn/webroot/magicnet.kmz', {
		preserveViewport: true,
		map: map
	});
}

function removeMagicnet() {
	kmzMagicnet.setMap(null);
}

function addNiislel() {
	kmzNiislel = new google.maps.KmlLayer('//manaikhoroo.ub.gov.mn/webroot/niislel.kmz', {
		preserveViewport: true,
		map: map
	});
}

function removeNiislel() {
	kmzNiislel.setMap(null);
}

function addZhut() {
	kmzZhut = new google.maps.KmlLayer('//manaikhoroo.ub.gov.mn/webroot/zhut.kmz', {
		preserveViewport: true,
		map: map
	});
}

function removeZhut() {
	kmzZhut.setMap(null);
}

/* Google Maps and UI */
$("#terrainSelect").click(function(){
	map.setOptions({mapTypeId: google.maps.MapTypeId.TERRAIN});
});
$("#roadMapSelect").click(function(){
	map.setOptions({mapTypeId: google.maps.MapTypeId.ROADMAP, styles: styles1});
});
$("#hybridSelect").click(function(){
	map.setOptions({mapTypeId: google.maps.MapTypeId.HYBRID});
});
$("#osmSelect").click(function(){
	map.setOptions({mapTypeId: 'OSM'});
});

/* Google Maps road styles */

var roadStylesRemove = [
  {
    featureType: 'road.arterial',
    elementType: 'geometry.fill'
  },{
    featureType: 'road.highway',
    elementType: 'geometry.fill'
  }
];

var roadStyles = [
  {
    featureType: 'road.arterial',
    elementType: 'geometry.fill',
    stylers: [
      { color: '#ffde00' }
    ]
  },{
    featureType: 'road.highway',
    elementType: 'geometry.fill',
    stylers: [
      { color: '#ffde00' }
    ]
  }
];

var styles1 = [
  {
    featureType: 'landscape',
    elementType: 'geometry.fill',
  },{
    featureType: 'poi',
    elementType: 'geometry.fill',
  }
];
