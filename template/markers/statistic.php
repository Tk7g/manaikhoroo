<div class="infopage-title">
	Улаанбаатар хотын мэдээлэл
</div>


<div id="statistic-chart">
	<div class="container">
		<div class="row">
			<div class="col-md-2">
<div class="chart-choice-box">
	<div class="choice-btn" data="1">
		Хүн амын тоо
	</div>
	<div class="choice-btn" data="2">
		Нийт өрхийн тоо
	</div>
	<div class="choice-btn" data="3">
		Газар нутгийн хэмжээ
	</div>
	<div class="choice-btn" data="4">
		Хүн амын нягтаршил
	</div>
	<div class="choice-btn" data="5">
		Өрхийн болон бусад эмнэлгийн тоо
	</div>
	<div class="choice-btn" data="6">
		Усны худгийн тоо
	</div>
	<div class="choice-btn" data="7">
		Албан бус хогийн цэгийн тоо
	</div>
</div>
	</div>
	<div class="col-md-8">
		<div id="chart-component">
<h2 class="title">Хүн амын тоо</h2>
<div id="population-chart" style="width: 100%; height: 300px;">
</div>

<script>
$(document).ready(function() {
	var datasets = {
		<?php foreach($results['districts'] as $district) : ?>
			"<?php echo 'district'.$district['id']; ?>": {
				label: "<?php echo $district['title']; ?>",
				data: [["<?php echo $district['title']; ?>", <?php if($results[$district['id']]['info'] != NULL) { echo $results[$district['id']]['info']['population']; } else { echo 0; } ?>]]
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
			$.plot("#population-chart", data , {
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
       		$('<div id="population_tooltip">' + contents + '</div>').css({
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

    	$("#population-chart").on("plothover", function (event, pos, item) {
        	if (item) {
            	if ((previous_point != item.dataIndex) || (previous_label != item.series.label)) {
                	previous_point = item.dataIndex;
                	previous_label = item.series.label;
 					$("#population_tooltip").remove();
                	var y = item.datapoint[1];
                	var x = item.series.label;

                	show_tooltip(item.pageX, item.pageY, "<div style='text-align: center;'>"+ x +" дүүрэг<br/>Хүн амын тоо<br /><b><div style='font-size: 20px; color: #EEE;'>" + y + "</div></b></div>");
            	}
        	} else {
				$("#population_tooltip").remove();
            	previous_point = null;
            	previous_label = null;
        	}
    	});
	});
</script>
		</div>
	</div>
	<div class="col-md-2">
		<div id="district-choices"></div>
	</div>
</div>

<script>

$(document).ready(function () {
	$(".choice-btn").click(function() {
		var type = $(this).attr("data");
		$("#district-choices").empty();
		$.ajax({
			type: "post",
			url:"get_chart.php?type=" + type,
			success:function (result) {
				$("#chart-component").html(result);
			}
		});
		return false;
	});
});

</script>
	</div>
</div>
<div class="stat-table-title">
		Тоон мэдээлэл
</div>
<div id="statistic-table">
	<div class="container">
		<table class="table table-striped">
			<thead>
				<tr>
					<th width="20%"></th>
					<th class="text-center">Улаанбаатар хот</th>
					<?php foreach($results['districts'] as $district) : ?>
						<th class="text-center"><?php echo $district['title']; ?></th>
					<?php endforeach; ?>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>Хүн амын тоо</td>
					<td class="text-center"><?php echo $results['city']['population']; ?></td>
					<?php foreach($results['districts'] as $district) : ?>
						<td class="text-center">
						<?php
							if($results[$district['id']]['info'] != NULL) {
								echo $results[$district['id']]['info']['population'];
							}
						?>
						</td>
					<?php endforeach; ?>
				</tr>
				<tr>
					<td>Нийт өрхийн тоо</td>
					<td class="text-center"><?php echo $results['city']['household']; ?></td>
						<?php foreach($results['districts'] as $district) : ?>
						<td class="text-center">
						<?php
							if($results[$district['id']]['info'] != NULL) {
								echo $results[$district['id']]['info']['household'];
							}
						?>
						</td>
					<?php endforeach; ?>
				</tr>
				<tr>
					<td>Өрхийн дундаж хэмжээ</td>
					<td class="text-center"><?php echo round($results['city']['household_average'], 2); ?></td>
					<?php foreach($results['districts'] as $district) : ?>
						<td class="text-center">
						<?php
							if($results[$district['id']]['info'] != NULL) {
								echo round($results[$district['id']]['info']['household_average'], 2);
							}
						?>
						</td>
					<?php endforeach; ?>
				</tr>
				<tr>
					<td>Газар нутгийн хэмжээ (га)</td>
					<td class="text-center"><?php echo round($results['city']['area_length']); ?></td>
					<?php foreach($results['districts'] as $district) : ?>
						<td class="text-center">
						<?php
							if($results[$district['id']]['info'] != NULL) {
								echo round($results[$district['id']]['info']['area_length']);
							}
						?>
						</td>
					<?php endforeach; ?>
				</tr>
				<tr>
					<td>Хүн амын нягтаршил (хүн/га)</td>
					<td class="text-center"><?php echo round($results['city']['population_density'], 2); ?></td>
					<?php foreach($results['districts'] as $district) : ?>
						<td class="text-center">
						<?php
							if($results[$district['id']]['info'] != NULL) {
								echo round($results[$district['id']]['info']['population_density'], 2);
							}
						?>
						</td>
					<?php endforeach; ?>
				</tr>
				<tr>
					<td>Автобусны буудлаас 5 минут алхах зайд амьдардаг хүн амын %</td>
					<td class="text-center"><?php echo round($results['city']['bus_density'], 2); ?></td>
					<?php foreach($results['districts'] as $district) : ?>
						<td class="text-center">
						<?php
							if($results[$district['id']]['info'] != NULL) {
								echo round($results[$district['id']]['info']['bus_density'], 2);
							}
						?>
						</td>
					<?php endforeach; ?>
				</tr>
				<tr>
					<td>Усны худгийн тоо</td>
					<td class="text-center"><?php echo $results['city']['bus_density']; ?></td>
					<?php foreach($results['districts'] as $district) : ?>
						<td class="text-center">
						<?php
							if($results[$district['id']]['info'] != NULL) {
								echo $results[$district['id']]['info']['well_num'];
							}
						?>
						</td>
					<?php endforeach; ?>
				</tr>
				<tr>
					<td>Усны худгаас 5 минут алхах зайд амьдардаг хүн амын %</td>
					<td class="text-center"><?php echo round($results['city']['well_density'], 2); ?></td>
					<?php foreach($results['districts'] as $district) : ?>
						<td class="text-center">
						<?php
							if($results[$district['id']]['info'] != NULL) {
								echo round($results[$district['id']]['info']['well_density'], 2);
							}
						?>
						</td>
					<?php endforeach; ?>
				</tr>
				<tr>
					<td>1000 хүнд ноогдох усны худгийн харьцаа</td>
					<td class="text-center"><?php echo round($results['city']['well_ratio'], 2); ?></td>
					<?php foreach($results['districts'] as $district) : ?>
						<td class="text-center">
						<?php
							if($results[$district['id']]['info'] != NULL) {
								echo round($results[$district['id']]['info']['well_ratio'], 2);
							}
						?>
						</td>
					<?php endforeach; ?>
				</tr>
				<tr>
					<td>Албан бус хогийн цэгийн тоо</td>
					<td class="text-center"><?php echo $results['city']['trash_num']; ?></td>
					<?php foreach($results['districts'] as $district) : ?>
						<td class="text-center">
						<?php
							if($results[$district['id']]['info'] != NULL) {
								echo $results[$district['id']]['info']['trash_num'];
							}
						?>
						</td>
					<?php endforeach; ?>
				</tr>
				<tr>
					<td>Аюултай бүсээс 100 м зайнд амьдардаг хүн амын %</td>
					<td class="text-center"><?php echo round($results['city']['risk_ratio'], 2); ?></td>
					<?php foreach($results['districts'] as $district) : ?>
						<td class="text-center">
						<?php
							if($results[$district['id']]['info'] != NULL) {
								echo round($results[$district['id']]['info']['risk_ratio'], 2);
							}
						?>
						</td>
					<?php endforeach; ?>
				</tr>
				<tr>
					<td>Өрхийн болон бусад эмнэлэгийн тоо</td>
					<td class="text-center"><?php echo $results['city']['hospital_num']; ?></td>
					<?php foreach($results['districts'] as $district) : ?>
						<td class="text-center">
						<?php
							if($results[$district['id']]['info'] != NULL) {
								echo $results[$district['id']]['info']['hospital_num'];
							}
						?>
						</td>
					<?php endforeach; ?>
				</tr>
				<tr>
					<td>1000 хүнд ноогдох өрхийн болон бусад эмнэлэгийн харьцаа</td>
					<td class="text-center"><?php echo round($results['city']['hospital_ratio'], 2); ?></td>
					<?php foreach($results['districts'] as $district) : ?>
						<td class="text-center">
						<?php
							if($results[$district['id']]['info'] != NULL) {
								echo round($results[$district['id']]['info']['hospital_ratio'], 2);
							}
						?>
						</td>
					<?php endforeach; ?>
				</tr>
				<tr>
					<td>2-5 насны цэцэрлэгт хамрагддаггүй хүүхдийн тоо</td>
					<td class="text-center"><?php echo $results['city']['kin_num']; ?></td>
					<?php foreach($results['districts'] as $district) : ?>
						<td class="text-center">
						<?php
							if($results[$district['id']]['info'] != NULL) {
								echo $results[$district['id']]['info']['kin_num'];
							}
						?>
						</td>
					<?php endforeach; ?>
				</tr>
				<tr>
					<td>2-5 насны цэцэрлэгт хамрагддаггүй хүүхдийн %</td>
					<td class="text-center"><?php echo round($results['city']['kin_ratio'], 2); ?></td>
					<?php foreach($results['districts'] as $district) : ?>
						<td class="text-center">
						<?php
							if($results[$district['id']]['info'] != NULL) {
								echo round($results[$district['id']]['info']['kin_ratio'], 2);
							}
						?>
						</td>
					<?php endforeach; ?>
				</tr>
				<tr>
					<td>6-16 насны сургуульд хамрагддаггүй хүүхдийн тоо</td>
					<td class="text-center"><?php echo $results['city']['school_num']; ?></td>
					<?php foreach($results['districts'] as $district) : ?>
						<td class="text-center">
						<?php
							if($results[$district['id']]['info'] != NULL) {
								echo $results[$district['id']]['info']['school_num'];
							}
						?>
						</td>
					<?php endforeach; ?>
				</tr>
				<tr>
					<td>6-16 насны сургуульд хамрагддаггүй хүүхдийн %</td>
					<td class="text-center"><?php echo round($results['city']['school_ratio'], 2); ?></td>
					<?php foreach($results['districts'] as $district) : ?>
						<td class="text-center">
						<?php
							if($results[$district['id']]['info'] != NULL) {
								echo round($results[$district['id']]['info']['school_ratio'], 2);
							}
						?>
						</td>
					<?php endforeach; ?>
				</tr>
			</tbody>
		</table>
	</div>
</div>
<script type="text/javascript" src="<?php echo ROOT_FOLDER; ?>/js/chart/jquery.flot.js"></script>
<script type="text/javascript" src="<?php echo ROOT_FOLDER; ?>/js/chart/jquery.flot.categories.js"></script>
<script type="text/javascript" src="<?php echo ROOT_FOLDER; ?>/js/chart/jquery.flot.resize.js"></script>
<script type="text/javascript" src="<?php echo ROOT_FOLDER; ?>/js/chart/jquery.flot.valuelabels.js"></script>
<script type="text/javascript" src="<?php echo ROOT_FOLDER; ?>/js/chart/jquery.flot.growraf.js"></script>
