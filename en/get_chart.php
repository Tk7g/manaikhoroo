<?php 

require(realpath(dirname(__FILE__))."/config/settings.php");
require_once(realpath(dirname(__FILE__))."/classes/Marker.class.php");

$results = Marker::districtView();

switch ( $_GET['type'] ) {
	case 1:
		$info_title = 'Total population';
		$info_field = 'population';
		break;
	case 2:
		$info_title = 'Total household';
		$info_field = 'household';
		break;
	case 3:
		$info_title = 'Total area';
		$info_field = 'area_length';
		break;
	case 4:
		$info_title = 'Population Density';
		$info_field = 'population_density';
		break;
	case 5:
		$info_title = 'Number of health clinics';
		$info_field = 'hospital_num';
		break;
	case 6:
		$info_title = 'Number of water kiosks';
		$info_field = 'well_num';
		break;
	case 7:
		$info_title = 'Illegal trash dump sites';
		$info_field = 'trash_num';
		break;
}

?>

<h2 class="title"><?php echo $info_title; ?></h2>
<div id="infoChart" style="width: 100%; height: 300px;">
</div>

<script>
$(document).ready(function() {
	var datasets = {
		<?php foreach($results['districts'] as $district) : ?>
			"<?php echo 'district'.$district['id']; ?>": {
				label: "<?php echo $district['title']; ?>",
				data: [["<?php echo $district['title']; ?>", <?php if($results[$district['id']]['info'] != NULL) { echo $results[$district['id']]['info'][$info_field]; } else { echo 0; } ?>]]	
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
			choiceContainer.append("<br/><input type='checkbox' name='" + key +
				"' checked='checked' id='id" + key + "'></input>" +
				"<label for='id" + key + "'>"
				+ val.label + "</label>");
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
 
                	show_tooltip(item.pageX, item.pageY, "<div style='text-align: center;'>"+ x +" district<br/><?php echo $info_title; ?><br /><b><div style='font-size: 20px; color: #EEE;'>" + y + "</div></b></div>");
            	}
        	} else {
				$("#chartTooltip").remove();
            	previous_point = null;
            	previous_label = null;
        	}
    	});
	});
</script>