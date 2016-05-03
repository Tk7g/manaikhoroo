$(".reportDetailBox").css({ background: '#eee' });
var khesegs = {};

function addMarker1(region, type, image, mapVar, iconVar) {
	$.getJSON('/report.php?action=getRegionMarkers&type='+type+'&region='+region, function(point){
		if(point.coordinate.length == 0) {
			return;
		} else {
			var iconImg = {
				url: image,
   				size: new google.maps.Size(8, 8),
    			origin: new google.maps.Point(0,0),
    			anchor: new google.maps.Point(4,4),
				scaledSize: new google.maps.Size(4, 4)
			}
			for(var k = 0; k < point.coordinate.length; k++) {
				iconVar[k] = new google.maps.Marker({
    				position: new google.maps.LatLng(point.coordinate[k][0], point.coordinate[k][1]),
    				map: mapVar,
					icon: iconImg,
  				});
				iconVar[k].setMap(mapVar);
			}
		}
	});
}

function countMarkers(type, categoryName, khorooID) {
	$.getJSON('/report.php?action=getRegionMarkers&type='+type+'&region='+khorooID, function(point){
		for (var p = 0; p < point.coordinate.length; p++) {
			var latlng = new google.maps.LatLng(point.coordinate[p][0], point.coordinate[p][1]);
  		var titles = Object.keys(khesegs);
	  	for (var t = 0; t < titles.length; t++) {
		  	if (google.maps.geometry.poly.containsLocation(latlng, khesegs[titles[t]])) {
					var counter = $($('.profileKhesegs.' + categoryName + ' span')[titles[t] * 1 - 1]).text();
					$($('.profileKhesegs.' + categoryName + ' span')[titles[t] * 1 - 1]).text(counter * 1 + 1);
					break;
				}
			}
		}
	});
}

function addTorongarts(section, mapVar) {
	$.getJSON('/marker.php?page=torongartsBorder&torongarts='+section, function(point){
		if(point.coordinate.length == 0) {
			return;
		} else {
			var coord = [];
			for(var k = 0; k < point.coordinate.length; k++) {
				coord.push(new google.maps.LatLng(point.coordinate[k][0], point.coordinate[k][1]));
			}
			new google.maps.Polygon({
    		path: coord,
    		strokeColor: '#440101',
    		strokeOpacity: 1,
    		strokeWeight: 2,
    		fillColor: '#ac0707',
    		fillOpacity: 0.7,
				map: mapVar
  		});
		}
	});
}

function addRisks(section, mapVar) {
	$.getJSON('/marker.php?page=risksBorder&risks='+section, function(point){
		if(point.coordinate.length == 0) {
			return;
		} else {
		  var coord = [];
			for(var k = 0; k < point.coordinate.length; k++) {
				coord.push(new google.maps.LatLng(point.coordinate[k][0], point.coordinate[k][1]));
			}
			new google.maps.Polygon({
    		path: coord,
    		strokeColor: '#440101',
    		strokeOpacity: 1,
    		strokeWeight: 2,
    		fillColor: '#ac0707',
    		fillOpacity: 0.7,
				map: mapVar
  		});
		}
	});
}

function addRoad(plId, roadWidth, mapVar) {
	$.getJSON('/indicator.php?action=roadBorder&id='+plId, function(point){
		if(point.coordinate.length == 0) {
			return;
		} else {
			var coord = [];
			for(var k = 0; k < point.coordinate.length; k++) {
				coord.push(new google.maps.LatLng(point.coordinate[k][0], point.coordinate[k][1]));
			}
		  new google.maps.Polyline({
    		path: coord,
    		geodesic: true,
    		strokeColor: '#fbdc00',
    		strokeOpacity: 1.0,
    		strokeWeight: roadWidth,
				map: mapVar
  		});
		}
	});
}

function addMarker(region, type, image, mapVar, iconVar) {
	$.getJSON('/report.php?action=getRegionMarkers&type='+type+'&region='+region, function(point){
		if(point.coordinate.length == 0) {
			return;
		} else {
			var iconImg = {
				url: image,
   				size: new google.maps.Size(26, 26),
    			origin: new google.maps.Point(0,0),
    			anchor: new google.maps.Point(4,4),
				scaledSize: new google.maps.Size(8, 9)
			}
			for(var k = 0; k < point.coordinate.length; k++) {
				iconVar[k] = new google.maps.Marker({
    			position: new google.maps.LatLng(point.coordinate[k][0], point.coordinate[k][1]),
    			map: mapVar,
					icon: iconImg,
  			});
				iconVar[k].setMap(mapVar);
			}
		}
	});
}

function processWalkCircles(point, color, radius, opacity, type, mapVar) {
	if(!point.coordinate || !point.coordinate.length) {
		return;
	}
	var reader = new jsts.io.GeoJSONReader();
	var writer = new jsts.io.GeoJSONWriter();

	var buffers = [];

	for(var k = 0; k < point.coordinate.length; k++) {
		point.coordinate[k].reverse();
		var centroid = reader.read({
			type: 'Point',
			coordinates: [point.coordinate[k][1] * 1, point.coordinate[k][0] * 1]
		});

		var smallest = 0.000012 * radius;
		if (!buffers.length) {
			buffers.push(centroid.buffer(smallest));
		} else {
			buffers[0] = buffers[0].union(centroid.buffer(smallest));
		}
	}

	function googlyPolygon(rings) {
		if (!rings) {
			return;
		}
		for (var r = 0; r < rings.length; r++) {
			rings[r].pop();
			for (var pt = 0; pt < rings[r].length; pt++) {
				rings[r][pt] = new google.maps.LatLng(rings[r][pt][0] * 1, rings[r][pt][1] * 1);
			}
		}

		new google.maps.Polygon({
			path: rings[0],
			clickable: false,
			fillColor: color,
			strokeWeight: 0,
			strokeOpacity: 0,
			fillOpacity: opacity,
			map: mapVar
		});
	}

	for (var b = 0; b < buffers.length; b++) {
		buffers[b] = writer.write(buffers[b]);
		if (buffers[b].type === 'MultiPolygon') {
			for (var p = 0; p < buffers[b].coordinates.length; p++) {
				googlyPolygon(buffers[b].coordinates[p]);
			}
		} else {
			googlyPolygon(buffers[b].coordinates);
		}
	}
}

function addWalk(region, color, radius, opacity, type, mapVar) {
	$.getJSON('/report.php?action=getRegionMarkers&type='+type+'&region='+region, function(point){
		if(point.coordinate.length == 0) {
			return;
		} else {
			processWalkCircles(point, color, radius, opacity, type, mapVar);
		}
	});
}

function addPlayground(playground, mapVar) {
	$.getJSON('/marker.php?page=playgroundBorder&playground='+playground, function(point){
		if(point.coordinate.length == 0) {
			return;
		} else {
			var coord = [];
			for(var k = 0; k < point.coordinate.length; k++) {
				coord.push(new google.maps.LatLng(point.coordinate[k][0], point.coordinate[k][1]));
			}
		  new google.maps.Polygon({
    		path: coord,
    		strokeColor: '#000000',
    		strokeOpacity: 1,
    		strokeWeight: 1,
    		fillColor: '#7cc242',
    		fillOpacity: 0.5,
				map: mapVar
  		});
		}
	});
}

function colorFor(colorVal) {
	colorVal *= 1;
	if (isNaN(colorVal)) {
		return '#fff';
	}
	var colorset = ['#ffdc9c', '#e48801', '#a84600', '#730601'];
	for (var n = 0; n < 3; n++) {
		var range = $('.color' + n).text().replace(/\s+/g, '');
  	if (colorVal <= range.split('-')[0] * 1 || colorVal <= range.split('-')[1] * 1) {
		  return colorset[0];
	  }
	}
	return colorset[3];
}

function addSection(section, colorVal, mapVar, opac, image) {
	$.getJSON('/marker.php?page=sectionBorder&section='+section, function(point){
		if(point.coordinate.length == 0) {
			return;
		} else {
			var coord = [];
			for(var k = 0; k < point.coordinate.length; k++) {
			  coord.push(new google.maps.LatLng(point.coordinate[k][0], point.coordinate[k][1]));
			}
			var kheseg = new google.maps.Polygon({
    		path: coord,
    		strokeColor: '#000000',
    		strokeOpacity: 1,
    		strokeWeight: 1,
    		fillColor: colorFor(colorVal),
    		fillOpacity: opac,
				map: mapVar
  		});
			if (image) {
	  		var iconImg = {
					url: image,
	   			size: new google.maps.Size(30, 30),
	    		origin: new google.maps.Point(0,0),
	    		anchor: new google.maps.Point(14,13),
					scaledSize: new google.maps.Size(20, 20)
				};
				var regionImage = {url: image};
				var regionImagePosition = getCenterOfPolygon(kheseg);
				var regionName = new google.maps.Marker({
	      	position: regionImagePosition,
	      	map: mapVar,
	      	icon: iconImg
	  		});
			}
		}
	});
}

function addSections(sectionids, colorVals, mapVar, opac, titles) {
	$.post('/marker.php?page=sectionBorderMega', { ids: sectionids }, function(sections){
		for (var s = 0; s < sections.length; s++) {
			var point = sections[s];
			var colorVal = colorVals[s];
			var title = titles[s];
			if(point.coordinate.length == 0) {
				return;
			} else {
				var coord = [];
				for(var k = 0; k < point.coordinate.length; k++) {
				  coord.push(new google.maps.LatLng(point.coordinate[k][0], point.coordinate[k][1]));
				}
				khesegs[title] = new google.maps.Polygon({
	    		path: coord,
	    		strokeColor: '#000000',
	    		strokeOpacity: 1,
	    		strokeWeight: 1,
	    		fillColor: colorFor(colorVal),
	    		fillOpacity: opac,
					map: mapVar
	  		});
	  		var iconImg = {
					url: '/webroot/img/section/' + title + '.png',
	   			size: new google.maps.Size(30, 30),
	    		origin: new google.maps.Point(0,0),
	    		anchor: new google.maps.Point(14,13),
					scaledSize: new google.maps.Size(20, 20)
				};
				var regionImagePosition = getCenterOfPolygon(khesegs[title]);
				var regionName = new google.maps.Marker({
	      	position: regionImagePosition,
	      	map: mapVar,
	      	icon: iconImg
	  		});
			}
		}

		function gup(name, url) {
		  name = name.replace(/[\[]/, '\\\[').replace(/[\]]/, '\\\]');
		  var results = new RegExp('[\\?&]'+name+'=?([^&#]*)').exec(url || window.location.href);
		  return results == null ? null : results[1];
		}
		countMarkers(1, 'buses', gup('region'));
	});
}

// LatLngBounds bnds -> height and width as a Point
function getSizeInPixels(projection, bounds) {
    var sw = projection.fromLatLngToContainerPixel(bounds.getSouthWest());
    var ne = projection.fromLatLngToContainerPixel(bounds.getNorthEast());
    return new google.maps.Point(Math.abs(sw.y - ne.y), Math.abs(sw.x - ne.x));
}

function addRegion(district, region, zoomTo) {
	$.getJSON('/indicator.php?action=regionBorder&region='+region, function(point){
		if(point.coordinate.length == 0) {
			return;
		} else {
			var regionCoord = [];
			var bounds = new google.maps.LatLngBounds();
			for(var k = 0; k < point.coordinate.length; k++) {
				var pt = new google.maps.LatLng(point.coordinate[k][0], point.coordinate[k][1]);
				bounds.extend(pt);
				regionCoord.push(pt);
			}
			var khoroo = new google.maps.Polygon({
				paths: regionCoord,
				strokeColor: '#000',
				strokeOpacity: 1,
				strokeWeight: 2,
				fillColor: '#f7c567',
				fillOpacity: 1,
				map: map
			});
			if (zoomTo) {
				map.fitBounds(bounds);
				if (typeof zoomTo === 'function') {
  				zoomTo(bounds);
				}
			}
		}
	});
}

function getCenterOfPolygon(polygon){
	var PI=22/7
	var X=0;
	var Y=0;
	var Z=0;
	polygon.getPath().forEach(function (vertex, inex) {
		lat1=vertex.lat();
		lon1=vertex.lng();
		lat1 = lat1 * PI/180
		lon1 = lon1 * PI/180
		X += Math.cos(lat1) * Math.cos(lon1)
		Y += Math.cos(lat1) * Math.sin(lon1)
		Z += Math.sin(lat1)
	})
	Lon = Math.atan2(Y, X)
	Hyp = Math.sqrt(X * X + Y * Y)
	Lat = Math.atan2(Z, Hyp)
	Lat = Lat * 180/PI
	Lon = Lon * 180/PI
	return new google.maps.LatLng(Lat,Lon);
}
