<?php
require_once(realpath(dirname(__FILE__))."/classes/Marker.class.php");

$results = Marker::getRegionMarkerInfo($_POST['type'], $_POST['district']);

?>
<div class="typechart">
<h2 class="title"><?php echo $results['type']['title']; ?></h2>
<div id="<?php echo 'chart'.$results['type']['id']; ?>" style="width: 100%; height: 300px;">
</div>
</div>

<script type="text/javascript">

	$(function() {
		var data = [ 
		<?php foreach($results['districts'] as $district) : ?>
			["<?php echo $district['title']; ?>", <?php echo $results[$district['id']]['count']['COUNT(*)']; ?>],
		<?php endforeach; ?>
		];
		$.plot("#<?php echo 'chart'.$results['type']['id']; ?>", [ data ], {
			series: {
				bars: {
					show: true,
					barWidth: 0.8,
					align: "center",
					fillColor: {
						colors: [
							{opacity: 1},
							{opacity: 0.9}
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
					duration: 1000
				}
			},
			xaxis: {
				mode: "categories",
				tickLength: 0
			},
			grid: {
            	hoverable: true,
            	borderWidth: 0
        	},
			colors: ["<?php echo $results['type']['color']; ?>"]
		});
		
		function show_tooltip(x, y, contents) {
       		$('<div id="<?php echo 'tooltip'.$results['type']['id']; ?>">' + contents + '</div>').css({
				'font-size': '13px',
				'display': 'none',
				'top': y - 100,
				'left': x - 55,
				'position': 'absolute',
				'background': '#CCCCCC',
				'border': '2px solid #DDDDDD',
				'color': '#666',
				'padding': '5px 10px',
				'z-index': '100000'
        	}).appendTo("body").fadeIn();
    	}

		var previous_point = null;
    	var previous_label = null;
 		
    	$("#<?php echo 'chart'.$results['type']['id']; ?>").on("plothover", function (event, pos, item) {
        	if (item) {
            	if ((previous_point != item.dataIndex) || (previous_label != item.series.label)) {
                	previous_point = item.dataIndex;
                	previous_label = item.series.label;
 					$("#bar_tooltip").remove();
                	var x = item.datapoint[0],
                    	y = item.datapoint[1];
 
                	show_tooltip(item.pageX, item.pageY, "<div style='text-align: center;'><?php echo $results['type']['title']; ?><br /><b><div style='font-size: 18px; color: #000;'>" + y + "</div></b></div>");
            	}
        	} else {
				$("#<?php echo 'tooltip'.$results['type']['id']; ?>").remove();
            	previous_point = null;
            	previous_label = null;
        	}
    	});
		
	});

</script>