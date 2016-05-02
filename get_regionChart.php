<?php 

require(realpath(dirname(__FILE__))."/config/settings.php");
require_once(realpath(dirname(__FILE__))."/classes/Marker.class.php");
require_once(realpath(dirname(__FILE__))."/classes/Year.class.php");

$results = Marker::regionView($_GET['district']);
$default_year = Year::getDefaultYear();

switch ( $_GET['type'] ) {
	case 1:
		$info_title = 'Хүн амын тоо';
		$info_field = 'population';
		break;
	case 2:
		$info_title = 'Нийт өрхийн тоо';
		$info_field = 'household';
		break;
	case 3:
		$info_title = 'Газар нутгийн хэмжээ';
		$info_field = 'area_length';
		break;
	case 4:
		$info_title = 'Хүн амын нягтаршил';
		$info_field = 'population_density';
		break;
	case 5:
		$info_title = 'Өрхийн болон бусад эмнэлгийн тоо';
		$info_field = 'hospital_num';
		break;
	case 6:
		$info_title = 'Усны худгийн тоо';
		$info_field = 'well_num';
		break;
	case 7:
		$info_title = 'Албан бус хогийн цэгийн тоо';
		$info_field = 'trash_num';
		break;
}

?>

<h2 class="title"><?php echo $info_title; ?></h2>
<div id="infoChart" style="width: 100%; height: 300px;">
</div>
<?php if($info_field == 'area_length') { ?>
<script>
$(document).ready(function() {
	var datasets = {
		<?php 
		foreach($results['regions'] as $region) : 
			$regionArea = Marker::getRegionAreaLength($region['id'], $default_year['year']);
			if($regionArea == NULL) {
				$regionArea = Marker::getRegionAreaLength($region['id'], $default_year['year']-1);
				if($regionArea == NULL) {
					$regionArea = Marker::getRegionAreaLength($region['id'], $default_year['year']-2);
				}
			}
		?>
			"<?php echo 'region'.$region['id']; ?>": {
				label: "<?php echo $region['title']; ?>",
				data: [["<?php echo $region['title']; ?>", <?php echo $regionArea['area_length']; ?>]]	
			},
		<?php endforeach; ?>
	};
	
	var i = 0;
		$.each(datasets, function(key, val) {
			val.color = i;
			++i;
	});
	
	var choiceContainer = $("#district-choices");
		$.each(datasets, function(key, val) {
			choiceContainer.append("<div class='region-choice-row'><input type='checkbox' name='" + key +
				"' checked='checked' id='id" + key + "'></input>" +
				"<label for='id" + key + "'>"
				+ val.label + "</label></div>");
	});
	
	choiceContainer.find("input").click(plotAccordingToChoices);
	
	function plotAccordingToChoices() {
		var data = [];
		choiceContainer.find("input:checked").each(function () {
			var key = $(this).attr("name");
			if (key && datasets[key]) {
				data.push(datasets[key]);
			}
		});
		if (data.length > 0) {
			$.plot("#infoChart", data , {
				series: {
					bars: {
						show: true,
						barWidth: 0.6,
						align: "center",
						fillColor: {
							colors: [
								{opacity: 1},
								{opacity: 1}
							]
						}
					},
					valueLabels: {
						show: true,
						align: 'center',
						font: "9pt 'Arial'"
					},
					grow: { 
						active: true,
						duration: 150
					}
				},
				xaxis: {
					mode: "categories",
					tickLength: 0,
					reserveSpace: true
				},
				legend: {
					show: false
				},
				grid: {
            		hoverable: true,
            		borderWidth: 0
        		},
				colors: [
					<?php foreach($results['districts'] as $district) : ?>
						"<?php echo $district['color']; ?>",
					<?php endforeach; ?>
				]
			});
		}
	}
	
	plotAccordingToChoices();
	
	function show_tooltip(x, y, contents) {
       		$('<div id="chartTooltip">' + contents + '</div>').css({
				'font-size': '13px',
				'display': 'none',
				'top': y - 100,
				'left': x - 70,
				'position': 'absolute',
				'background': '#475577',
				'border': '2px solid #28324e',
				'color': '#FFF',
				'padding': '5px 10px',
				'z-index': '100000'
        	}).appendTo("body").fadeIn();
    	}

		var previous_point = null;
    	var previous_label = null;
 		
    	$("#infoChart").on("plothover", function (event, pos, item) {
        	if (item) {
            	if ((previous_point != item.dataIndex) || (previous_label != item.series.label)) {
                	previous_point = item.dataIndex;
                	previous_label = item.series.label;
 					$("#population_tooltip").remove();
                	var y = item.datapoint[1];
                	var x = item.series.label;
 
                	show_tooltip(item.pageX, item.pageY, "<div style='text-align: center;'>"+ x +"-р хороо<br/><?php echo $info_title; ?><br /><b><div style='font-size: 20px; color: #EEE;'>" + y + "</div></b></div>");
            	}
        	} else {
				$("#chartTooltip").remove();
            	previous_point = null;
            	previous_label = null;
        	}
    	});
	});
</script>
<?php } elseif($info_field == 'trash_num') { ?>
<script>
$(document).ready(function() {
	var datasets = {
		<?php 
		foreach($results['regions'] as $region) : 
			$regionTrash = Marker::regionCountYearMarkers($region['id'], $default_year['year'], 10);
		?>
			"<?php echo 'region'.$region['id']; ?>": {
				label: "<?php echo $region['title']; ?>",
				data: [["<?php echo $region['title']; ?>", <?php echo $regionTrash['COUNT(*)']; ?>]]	
			},
		<?php endforeach; ?>
	};
	
	var i = 0;
		$.each(datasets, function(key, val) {
			val.color = i;
			++i;
	});
	
	var choiceContainer = $("#district-choices");
		$.each(datasets, function(key, val) {
			choiceContainer.append("<div class='region-choice-row'><input type='checkbox' name='" + key +
				"' checked='checked' id='id" + key + "'></input>" +
				"<label for='id" + key + "'>"
				+ val.label + "</label></div>");
	});
	
	choiceContainer.find("input").click(plotAccordingToChoices);
	
	function plotAccordingToChoices() {
		var data = [];
		choiceContainer.find("input:checked").each(function () {
			var key = $(this).attr("name");
			if (key && datasets[key]) {
				data.push(datasets[key]);
			}
		});
		if (data.length > 0) {
			$.plot("#infoChart", data , {
				series: {
					bars: {
						show: true,
						barWidth: 0.6,
						align: "center",
						fillColor: {
							colors: [
								{opacity: 1},
								{opacity: 1}
							]
						}
					},
					valueLabels: {
						show: true,
						align: 'center',
						font: "9pt 'Arial'"
					},
					grow: { 
						active: true,
						duration: 150
					}
				},
				xaxis: {
					mode: "categories",
					tickLength: 0,
					reserveSpace: true
				},
				legend: {
					show: false
				},
				grid: {
            		hoverable: true,
            		borderWidth: 0
        		},
				colors: [
					<?php foreach($results['districts'] as $district) : ?>
						"<?php echo $district['color']; ?>",
					<?php endforeach; ?>
				]
			});
		}
	}
	
	plotAccordingToChoices();
	
	function show_tooltip(x, y, contents) {
       		$('<div id="chartTooltip">' + contents + '</div>').css({
				'font-size': '13px',
				'display': 'none',
				'top': y - 100,
				'left': x - 70,
				'position': 'absolute',
				'background': '#475577',
				'border': '2px solid #28324e',
				'color': '#FFF',
				'padding': '5px 10px',
				'z-index': '100000'
        	}).appendTo("body").fadeIn();
    	}

		var previous_point = null;
    	var previous_label = null;
 		
    	$("#infoChart").on("plothover", function (event, pos, item) {
        	if (item) {
            	if ((previous_point != item.dataIndex) || (previous_label != item.series.label)) {
                	previous_point = item.dataIndex;
                	previous_label = item.series.label;
 					$("#population_tooltip").remove();
                	var y = item.datapoint[1];
                	var x = item.series.label;
 
                	show_tooltip(item.pageX, item.pageY, "<div style='text-align: center;'>"+ x +"-р хороо<br/><?php echo $info_title; ?><br /><b><div style='font-size: 20px; color: #EEE;'>" + y + "</div></b></div>");
            	}
        	} else {
				$("#chartTooltip").remove();
            	previous_point = null;
            	previous_label = null;
        	}
    	});
	});
</script>
<?php } elseif($info_field == 'well_num') { ?>
<script>
$(document).ready(function() {
	var datasets = {
		<?php 
		foreach($results['regions'] as $region) : 
			$regionWell = Marker::regionCountYearMarkers($region['id'], $default_year['year'], 2);
		?>
			"<?php echo 'region'.$region['id']; ?>": {
				label: "<?php echo $region['title']; ?>",
				data: [["<?php echo $region['title']; ?>", <?php echo $regionWell['COUNT(*)']; ?>]]	
			},
		<?php endforeach; ?>
	};
	
	var i = 0;
		$.each(datasets, function(key, val) {
			val.color = i;
			++i;
	});
	
	var choiceContainer = $("#district-choices");
		$.each(datasets, function(key, val) {
			choiceContainer.append("<div class='region-choice-row'><input type='checkbox' name='" + key +
				"' checked='checked' id='id" + key + "'></input>" +
				"<label for='id" + key + "'>"
				+ val.label + "</label></div>");
	});
	
	choiceContainer.find("input").click(plotAccordingToChoices);
	
	function plotAccordingToChoices() {
		var data = [];
		choiceContainer.find("input:checked").each(function () {
			var key = $(this).attr("name");
			if (key && datasets[key]) {
				data.push(datasets[key]);
			}
		});
		if (data.length > 0) {
			$.plot("#infoChart", data , {
				series: {
					bars: {
						show: true,
						barWidth: 0.6,
						align: "center",
						fillColor: {
							colors: [
								{opacity: 1},
								{opacity: 1}
							]
						}
					},
					valueLabels: {
						show: true,
						align: 'center',
						font: "9pt 'Arial'"
					},
					grow: { 
						active: true,
						duration: 150
					}
				},
				xaxis: {
					mode: "categories",
					tickLength: 0,
					reserveSpace: true
				},
				legend: {
					show: false
				},
				grid: {
            		hoverable: true,
            		borderWidth: 0
        		},
				colors: [
					<?php foreach($results['districts'] as $district) : ?>
						"<?php echo $district['color']; ?>",
					<?php endforeach; ?>
				]
			});
		}
	}
	
	plotAccordingToChoices();
	
	function show_tooltip(x, y, contents) {
       		$('<div id="chartTooltip">' + contents + '</div>').css({
				'font-size': '13px',
				'display': 'none',
				'top': y - 100,
				'left': x - 70,
				'position': 'absolute',
				'background': '#475577',
				'border': '2px solid #28324e',
				'color': '#FFF',
				'padding': '5px 10px',
				'z-index': '100000'
        	}).appendTo("body").fadeIn();
    	}

		var previous_point = null;
    	var previous_label = null;
 		
    	$("#infoChart").on("plothover", function (event, pos, item) {
        	if (item) {
            	if ((previous_point != item.dataIndex) || (previous_label != item.series.label)) {
                	previous_point = item.dataIndex;
                	previous_label = item.series.label;
 					$("#population_tooltip").remove();
                	var y = item.datapoint[1];
                	var x = item.series.label;
 
                	show_tooltip(item.pageX, item.pageY, "<div style='text-align: center;'>"+ x +"-р хороо<br/><?php echo $info_title; ?><br /><b><div style='font-size: 20px; color: #EEE;'>" + y + "</div></b></div>");
            	}
        	} else {
				$("#chartTooltip").remove();
            	previous_point = null;
            	previous_label = null;
        	}
    	});
	});
</script>
<?php } elseif($info_field == 'hospital_num') { ?>
<script>
$(document).ready(function() {
	var datasets = {
		<?php 
		foreach($results['regions'] as $region) : 
			$regionHospital = Marker::regionCountYearMarkers($region['id'], $default_year['year'], 9);
		?>
			"<?php echo 'region'.$region['id']; ?>": {
				label: "<?php echo $region['title']; ?>",
				data: [["<?php echo $region['title']; ?>", <?php echo $regionHospital['COUNT(*)']; ?>]]	
			},
		<?php endforeach; ?>
	};
	
	var i = 0;
		$.each(datasets, function(key, val) {
			val.color = i;
			++i;
	});
	
	var choiceContainer = $("#district-choices");
		$.each(datasets, function(key, val) {
			choiceContainer.append("<div class='region-choice-row'><input type='checkbox' name='" + key +
				"' checked='checked' id='id" + key + "'></input>" +
				"<label for='id" + key + "'>"
				+ val.label + "</label></div>");
	});
	
	choiceContainer.find("input").click(plotAccordingToChoices);
	
	function plotAccordingToChoices() {
		var data = [];
		choiceContainer.find("input:checked").each(function () {
			var key = $(this).attr("name");
			if (key && datasets[key]) {
				data.push(datasets[key]);
			}
		});
		if (data.length > 0) {
			$.plot("#infoChart", data , {
				series: {
					bars: {
						show: true,
						barWidth: 0.6,
						align: "center",
						fillColor: {
							colors: [
								{opacity: 1},
								{opacity: 1}
							]
						}
					},
					valueLabels: {
						show: true,
						align: 'center',
						font: "9pt 'Arial'"
					},
					grow: { 
						active: true,
						duration: 150
					}
				},
				xaxis: {
					mode: "categories",
					tickLength: 0,
					reserveSpace: true
				},
				legend: {
					show: false
				},
				grid: {
            		hoverable: true,
            		borderWidth: 0
        		},
				colors: [
					<?php foreach($results['districts'] as $district) : ?>
						"<?php echo $district['color']; ?>",
					<?php endforeach; ?>
				]
			});
		}
	}
	
	plotAccordingToChoices();
	
	function show_tooltip(x, y, contents) {
       		$('<div id="chartTooltip">' + contents + '</div>').css({
				'font-size': '13px',
				'display': 'none',
				'top': y - 100,
				'left': x - 70,
				'position': 'absolute',
				'background': '#475577',
				'border': '2px solid #28324e',
				'color': '#FFF',
				'padding': '5px 10px',
				'z-index': '100000'
        	}).appendTo("body").fadeIn();
    	}

		var previous_point = null;
    	var previous_label = null;
 		
    	$("#infoChart").on("plothover", function (event, pos, item) {
        	if (item) {
            	if ((previous_point != item.dataIndex) || (previous_label != item.series.label)) {
                	previous_point = item.dataIndex;
                	previous_label = item.series.label;
 					$("#population_tooltip").remove();
                	var y = item.datapoint[1];
                	var x = item.series.label;
 
                	show_tooltip(item.pageX, item.pageY, "<div style='text-align: center;'>"+ x +"-р хороо<br/><?php echo $info_title; ?><br /><b><div style='font-size: 20px; color: #EEE;'>" + y + "</div></b></div>");
            	}
        	} else {
				$("#chartTooltip").remove();
            	previous_point = null;
            	previous_label = null;
        	}
    	});
	});
</script>
<?php } else { ?>
<script>
$(document).ready(function() {
	var datasets = {
		<?php foreach($results['regions'] as $region) : ?>
			"<?php echo 'region'.$region['id']; ?>": {
				label: "<?php echo $region['title']; ?>",
				data: [["<?php echo $region['title']; ?>", <?php if($results['region_infos'][$region['id']] != NULL) { echo $results['region_infos'][$region['id']][$info_field]; } else { echo 0; } ?>]]	
			},
		<?php endforeach; ?>
	};
	
	var i = 0;
		$.each(datasets, function(key, val) {
			val.color = i;
			++i;
	});
	
	var choiceContainer = $("#district-choices");
		$.each(datasets, function(key, val) {
			choiceContainer.append("<div class='region-choice-row'><input type='checkbox' name='" + key +
				"' checked='checked' id='id" + key + "'></input>" +
				"<label for='id" + key + "'>"
				+ val.label + "</label></div>");
	});
	
	choiceContainer.find("input").click(plotAccordingToChoices);
	
	function plotAccordingToChoices() {
		var data = [];
		choiceContainer.find("input:checked").each(function () {
			var key = $(this).attr("name");
			if (key && datasets[key]) {
				data.push(datasets[key]);
			}
		});
		if (data.length > 0) {
			$.plot("#infoChart", data , {
				series: {
					bars: {
						show: true,
						barWidth: 0.6,
						align: "center",
						fillColor: {
							colors: [
								{opacity: 1},
								{opacity: 1}
							]
						}
					},
					valueLabels: {
						show: true,
						align: 'center',
						font: "9pt 'Arial'"
					},
					grow: { 
						active: true,
						duration: 150
					}
				},
				xaxis: {
					mode: "categories",
					tickLength: 0,
					reserveSpace: true
				},
				legend: {
					show: false
				},
				grid: {
            		hoverable: true,
            		borderWidth: 0
        		},
				colors: [
					<?php foreach($results['districts'] as $district) : ?>
						"<?php echo $district['color']; ?>",
					<?php endforeach; ?>
				]
			});
		}
	}
	
	plotAccordingToChoices();
	
	function show_tooltip(x, y, contents) {
       		$('<div id="chartTooltip">' + contents + '</div>').css({
				'font-size': '13px',
				'display': 'none',
				'top': y - 100,
				'left': x - 70,
				'position': 'absolute',
				'background': '#475577',
				'border': '2px solid #28324e',
				'color': '#FFF',
				'padding': '5px 10px',
				'z-index': '100000'
        	}).appendTo("body").fadeIn();
    	}

		var previous_point = null;
    	var previous_label = null;
 		
    	$("#infoChart").on("plothover", function (event, pos, item) {
        	if (item) {
            	if ((previous_point != item.dataIndex) || (previous_label != item.series.label)) {
                	previous_point = item.dataIndex;
                	previous_label = item.series.label;
 					$("#population_tooltip").remove();
                	var y = item.datapoint[1];
                	var x = item.series.label;
 
                	show_tooltip(item.pageX, item.pageY, "<div style='text-align: center;'>"+ x +"-р хороо<br/><?php echo $info_title; ?><br /><b><div style='font-size: 20px; color: #EEE;'>" + y + "</div></b></div>");
            	}
        	} else {
				$("#chartTooltip").remove();
            	previous_point = null;
            	previous_label = null;
        	}
    	});
	});
</script>
<?php } ?>