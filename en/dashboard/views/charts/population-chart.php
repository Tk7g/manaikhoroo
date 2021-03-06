<script type="text/javascript" src="<?php echo ROOT_FOLDER; ?>/js/chart/jquery.flot.js"></script>
<script type="text/javascript" src="<?php echo ROOT_FOLDER; ?>/js/chart/jquery.flot.categories.js"></script>
<script type="text/javascript" src="<?php echo ROOT_FOLDER; ?>/js/chart/jquery.flot.resize.js"></script>
<script type="text/javascript" src="<?php echo ROOT_FOLDER; ?>/js/chart/jquery.flot.valuelabels.js"></script>
<script type="text/javascript" src="<?php echo ROOT_FOLDER; ?>/js/chart/jquery.flot.growraf.js"></script>
<div class="row-fluid sortable">
	<div class="box span11">
		<div class="box-header" data-original-title>
			<h2>
			<?php if($_SESSION['login'] == 2) { 
				$district_title = $results['district_data']['title'];
			} else { 
				$district_title = $results['data']['district_title'];		
			} ?>
			<i class="halflings-icon user"></i><span class="break"></span><?php echo $results['year'].' оны '.$district_title.' дүүргийн хүн амын тоо'; ?>
			</h2>
			<div class="box-icon">
				<a href="#" class="btn-minimize"><i class="halflings-icon chevron-up"></i></a>
			</div>
		</div>
		<div class="box-content">
			<div id="chartPopulation" style="width: 100%; height: 200px;"></div>
		</div>
	</div><!--/span-->
</div>

<script type="text/javascript">

	$(function() {
		var data = [ 
		<?php foreach($results['regions'] as $region) : ?>
			["<?php echo $region['title']; ?>", <?php if($results['region_data'][$region['id']] != NULL) { echo $results['region_data'][$region['id']]['population']; } else { echo 0; } ?>],
		<?php endforeach; ?>
		];
		$.plot("#chartPopulation", [ data ], {
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
			colors: ["#2d89ef"]
		});
		
		function show_tooltip(x, y, contents) {
       		$('<div id="bar_tooltip">' + contents + '</div>').css({
				'font-size': '13px',
				'display': 'none',
				'top': y - 100,
				'left': x - 70,
				'position': 'absolute',
				'background': '#2d89ef',
				'border': '2px solid #CCCCCC',
				'color': '#FFF',
				'padding': '5px 10px',
				'z-index': '100000'
        	}).appendTo("body").fadeIn();
    	}

		var previous_point = null;
    	var previous_label = null;
 		
    	$("#chartPopulation").on("plothover", function (event, pos, item) {
        	if (item) {
            	if ((previous_point != item.dataIndex) || (previous_label != item.series.label)) {
                	previous_point = item.dataIndex;
                	previous_label = item.series.label;
 					$("#bar_tooltip").remove();
                	var x = item.datapoint[0],
                    	y = item.datapoint[1];
 
                	show_tooltip(item.pageX, item.pageY, "<div style='text-align: center;'><?php echo $district_title.' дүүрэг'; ?><br/>" + (x+1) + "-р хорооны<br/>Хүн амын тоо<br /><b><div style='font-size: 18px; color: #000;'>" + y + "</div></b></div>");
            	}
        	} else {
				$("#bar_tooltip").remove();
            	previous_point = null;
            	previous_label = null;
        	}
    	});
		
	});

</script>