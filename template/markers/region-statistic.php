<div class="info-detailed">
	<div class="container">
		<div class="row">
			<div class="col-md-4">
				<div class="detail-infobox detail-blue">
					<div class="detail-icon">
						<img src="<?php echo MAIN_FOLDER.'/icons/info/population.png'; ?>" class="img-responsive"/>
					</div>
					<div class="detail-info">
						<div class="detail-title">
							<?php echo $results['district']['title'].' дүүргийн'; ?>
						</div>
						<div class="detail-description">
							Хүн амын тоо
						</div>
						<div class="detail-number">
							<?php echo number_format($results['district_info']['population']); ?>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-4">
				<div class="detail-infobox detail-darkgreen">
					<div class="detail-icon">
						<img src="<?php echo MAIN_FOLDER.'/icons/info/household.png'; ?>" class="img-responsive"/>
					</div>
					<div class="detail-info">
						<div class="detail-title">
							<?php echo $results['district']['title'].' дүүргийн'; ?>
						</div>
						<div class="detail-description">
							Нийт өрхийн тоо
						</div>
						<div class="detail-number">
							<?php echo number_format($results['district_info']['household']); ?>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-4">
				<div class="detail-infobox detail-green">
					<div class="detail-icon">
						<img src="<?php echo MAIN_FOLDER.'/icons/info/school.png'; ?>" class="img-responsive"/>
					</div>
					<div class="detail-info">
						<div class="detail-title">
							<?php echo $results['district']['title'].' дүүргийн'; ?>
						</div>
						<div class="detail-description">
							Сургуульд хамрагддаггүй хүүхдийн тоо
						</div>
						<div class="detail-number">
							<?php echo number_format($results['district_info']['school_num']); ?>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-4">
				<div class="detail-infobox detail-yellow">
					<div class="detail-icon">
						<img src="<?php echo MAIN_FOLDER.'/icons/info/area.png'; ?>" class="img-responsive"/>
					</div>
					<div class="detail-info">
						<div class="detail-title">
							<?php echo $results['district']['title'].' дүүргийн'; ?>
						</div>
						<div class="detail-description">
							Газар нутгийн хэмжээ
						</div>
						<div class="detail-number">
							<?php echo number_format($districtArea['area_length']); ?> га
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-4">
				<div class="detail-infobox detail-orange">
					<div class="detail-icon">
						<img src="<?php echo MAIN_FOLDER.'/icons/info/pop-density.png'; ?>" class="img-responsive"/>
					</div>
					<div class="detail-info">
						<div class="detail-title">
							<?php echo $results['district']['title'].' дүүргийн'; ?>
						</div>
						<div class="detail-description">
							Хүн амын нягтаршил
						</div>
						<div class="detail-number">
							<?php echo number_format($results['district_info']['population_density'], 2); ?> хүн/га
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-4">
				<div class="detail-infobox detail-red">
					<div class="detail-icon">
						<img src="<?php echo MAIN_FOLDER.'/icons/info/hospital.png'; ?>" class="img-responsive"/>
					</div>
					<div class="detail-info">
						<div class="detail-title">
							<?php echo $results['district']['title'].' дүүргийн'; ?>
						</div>
						<div class="detail-description">
							Өрхийн болон бусад эмнэлгийн тоо
						</div>
						<div class="detail-number">
							<?php echo $districtMarkerCount['hospital']['COUNT(*)']; ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="infopage-title">
	<?php echo $results['district']['title'].' дүүргийн мэдээлэл'; ?>
</div>
<div id="mapbox-info">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="mapbox-content">
				<?php foreach($results['types'] as $marker_type) : ?>
					<div class="infobox-type<?php echo $marker_type['id']; ?>">
					</div>
				<?php endforeach; ?>
				</div>
			</div>
		</div>
	</div>
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
		<?php foreach($results['regions'] as $region) : ?>
			"<?php echo 'region'.$region['id']; ?>": {
				label: "<?php echo $region['title']; ?>",
				data: [["<?php echo $region['title']; ?>", <?php if($results['region_infos'][$region['id']]['population'] != NULL) { echo $results['region_infos'][$region['id']]['population']; } else { echo 0; } ?>]]
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
        		}
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

                	show_tooltip(item.pageX, item.pageY, "<div style='text-align: center;'>"+ x +"-р хороо<br/>Хүн амын тоо<br /><b><div style='font-size: 20px; color: #EEE;'>" + y + "</div></b></div>");
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
			url:"get_regionChart.php?type=" + type +'&district='+<?php echo $_GET['district']; ?>,
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
	<div class="rts-box">
			<div class="container">
					<div class="rts-selectbox">
						<form action="indicator.php?action=select" id="SelectRegionForm2" method="post">
						<div class="rts-input">
							<select name="region_id2" id="SelectRegion2" required="required">
								<option value="">Сонгоно уу</option>
								<?php foreach($results['districts'] as $dist) : ?>
									<option value="d<?php echo $dist['id']; ?>"><?php echo $dist['title'].' дүүрэг'; ?></option>
									<?php foreach($results[$dist['id']] as $reg) : ?>
										<option value="<?php echo $reg['id']; ?>"><?php echo $dist['title'].' дүүргийн '.$reg['title']; ?></option>
									<?php endforeach; ?>
								<?php endforeach; ?>
							</select>
						</div>
						</form>
						<div class="rts-label">
							харьцуулах
						</div>
						<form action="indicator.php?action=select" id="SelectRegionForm1" method="post">
						<div class="rts-input">
							<select name="region_id" id="SelectRegion1" required="required">
								<option value="">Сонгоно уу</option>
								<?php foreach($results['regions'] as $rg) : ?>
								<option value="<?php echo $rg['id']; ?>"><?php echo $results['district']['title'].' дүүргийн '.$rg['title'].'-р хороо'; ?></option>
								<?php endforeach; ?>
							</select>
						</div>
						</form>
						<div class="rts-label">
							Хороодоос сонголт хийж мэдээлэл харна уу
						</div>
					</div>
			</div>
	</div>

<div id="statistic-table">
	<div class="container" id="statTableBlock">
<div class="col-label">
	<div class="row-header">
	</div>
	<div class="row-rgtable row-label">
		Хүн амын тоо
	</div>
	<div class="row-rgtable row-label">
		Нийт өрхийн тоо
	</div>
	<div class="row-rgtable row-label">
		Өрхийн дундаж хэмжээ
	</div>
	<div class="row-rgtable row-label">
		Газар нутгийн хэмжээ /га/
	</div>
	<div class="row-rgtable row-label">
		Хүн амын нягтаршил (хүн/га)
	</div>
	<div class="row-rgtable row-label">
		Автобусны буудлаас 5 минут алхах зайд амьдардаг хүн амын %
	</div>
	<div class="row-rgtable row-label">
		Усны худгийн тоо
	</div>
	<div class="row-rgtable row-label">
		Усны худгаас 5 минут алхах зайд амьдардаг хүн амын %
	</div>
	<div class="row-rgtable row-label">
		1000 хүнд ноогдох усны худгийн харьцаа
	</div>
	<div class="row-rgtable row-label">
		Албан бус хогийн цэгийн тоо
	</div>
	<div class="row-rgtable row-label">
		Аюултай бүсээс 100 м зайнд амьдардаг хүн амын %
	</div>
	<div class="row-rgtable row-label">
		Өрхийн болон бусад эмнэлэгийн тоо
	</div>
	<div class="row-rgtable row-label">
		1000 хүнд ноогдох өрхийн болон бусад эмнэлэгийн харьцаа
	</div>
	<div class="row-rgtable row-label">
		2-5 насны цэцэрлэгт хамрагддаггүй хүүхдийн тоо
	</div>
	<div class="row-rgtable row-label">
		2-5 насны цэцэрлэгт хамрагддаггүй хүүхдийн %
	</div>
	<div class="row-rgtable row-label">
		6-16 насны сургуульд хамрагддаггүй хүүхдийн тоо
	</div>
	<div class="row-rgtable row-label">
		6-16 насны сургуульд хамрагддаггүй хүүхдийн %
	</div>
</div>

<div class="col-city">
	<div class="row-header text-center">
		Нийслэл
	</div>
	<div class="row-rgtable row-value">
		<?php echo $results['city']['population']; ?>
	</div>
	<div class="row-rgtable row-value">
		<?php echo $results['city']['household']; ?>
	</div>
	<div class="row-rgtable row-value">
		<?php echo round($results['city']['household_average'], 2); ?>
	</div>
	<div class="row-rgtable row-value">
		<?php echo round($results['city']['area_length']); ?>
	</div>
	<div class="row-rgtable row-value">
		<?php echo round($results['city']['population_density'], 2); ?>
	</div>
	<div class="row-rgtable row-value">
		<?php echo round($results['city']['bus_density'], 2).'%'; ?>
	</div>
	<div class="row-rgtable row-value">
		<?php echo $cityMarkerCount['well']['COUNT(*)']; ?>
	</div>
	<div class="row-rgtable row-value">
		<?php echo round($results['city']['well_density'], 2).'%'; ?>
	</div>
	<div class="row-rgtable row-value">
		<?php echo round($results['city']['well_ratio'], 2); ?>
	</div>
	<div class="row-rgtable row-value">
		<?php echo $cityMarkerCount['trash']['COUNT(*)']; ?>
	</div>
	<div class="row-rgtable row-value">
		<?php echo round($results['city']['risk_ratio'], 2).'%'; ?>
	</div>
	<div class="row-rgtable row-value">
		<?php echo $cityMarkerCount['hospital']['COUNT(*)']; ?>
	</div>
	<div class="row-rgtable row-value">
		<?php echo round($results['city']['hospital_ratio'], 2); ?>
	</div>
	<div class="row-rgtable row-value">
		<?php echo $results['city']['kin_num']; ?>
	</div>
	<div class="row-rgtable row-value">
		<?php echo round($results['city']['kin_ratio'], 2).'%'; ?>
	</div>
	<div class="row-rgtable row-value">
		<?php echo $results['city']['school_num']; ?>
	</div>
	<div class="row-rgtable row-value">
		<?php echo round($results['city']['school_ratio'], 2).'%'; ?>
	</div>
</div>

<div class="col-district">
	<div class="row-header text-center">
		<?php echo $results['district']['title']; ?>
	</div>
	<div class="row-rgtable row-value">
		<?php
			if($results['district_info'] != NULL) {
				echo $results['district_info']['population'];
			}
		?>
	</div>
	<div class="row-rgtable row-value">
		<?php
			if($results['district_info'] != NULL) {
				echo $results['district_info']['household'];
			}
		?>
	</div>
	<div class="row-rgtable row-value">
		<?php
			if($results['district_info'] != NULL) {
				echo round($results['district_info']['household_average'], 2);
			}
		?>
	</div>
	<div class="row-rgtable row-value">
		<?php
			if($results['district_info'] != NULL) {
				echo round($results['district_info']['area_length']);
			}
		?>
	</div>
	<div class="row-rgtable row-value">
		<?php
			if($results['district_info'] != NULL) {
				echo round($results['district_info']['population_density'], 2);
			}
		?>
	</div>
	<div class="row-rgtable row-value">
		<?php
		if($results['district_info'] != NULL) {
			echo round($results['district_info']['bus_density'], 2).'%';
		}
		?>
	</div>
	<div class="row-rgtable row-value">
		<?php
		if($results['district_info'] != NULL) {
			echo $districtMarkerCount['well']['COUNT(*)'];
		}
		?>
	</div>
	<div class="row-rgtable row-value">
		<?php
			if($results['district_info'] != NULL) {
				echo round($results['district_info']['well_density'], 2).'%';
			}
		?>
	</div>
	<div class="row-rgtable row-value">
		<?php
			if($results['district_info'] != NULL) {
				echo round($results['district_info']['well_ratio'], 2);
			}
		?>
	</div>
	<div class="row-rgtable row-value">
		<?php
			if($results['district_info'] != NULL) {
				echo $districtMarkerCount['trash']['COUNT(*)'];
			}
		?>
	</div>
	<div class="row-rgtable row-value">
		<?php
			if($results['district_info'] != NULL) {
				echo round($results['district_info']['risk_ratio'], 2).'%';
			}
		?>
	</div>
	<div class="row-rgtable row-value">
		<?php
		if($results['district_info'] != NULL) {
			echo $districtMarkerCount['hospital']['COUNT(*)'];
		}
		?>
	</div>
	<div class="row-rgtable row-value">
		<?php
		if($results['district_info'] != NULL) {
			echo round($results['district_info']['hospital_ratio'], 2);
		}
		?>
	</div>
	<div class="row-rgtable row-value">
		<?php
		if($results['district_info'] != NULL) {
			echo $results['district_info']['kin_num'];
		}
		?>
	</div>
	<div class="row-rgtable row-value">
		<?php
		if($results['district_info'] != NULL) {
			echo round($results['district_info']['kin_ratio'], 2).'%';
		}
		?>
	</div>
	<div class="row-rgtable row-value">
		<?php
		if($results['district_info'] != NULL) {
			echo $results['district_info']['school_num'];
		}
		?>
	</div>
	<div class="row-rgtable row-value">
		<?php
		if($results['district_info'] != NULL) {
			echo round($results['district_info']['school_ratio'], 2).'%';
		}
		?>
	</div>
</div>
<div class="col-region" id="colRegion1">
</div>
<div class="col-region" id="colRegion2">
</div>
	</div>
</div>
<div class="yearStatTitle">
	<?php echo $results['district']['title'].' дүүргийн '; ?> оны харьцуулалт
</div>
<div class="year-statistics">
	<div class="container">
		<div class="row">
			<div class="yearstat-selection">
				<form action="indicator.php?action=yearSelect" id="YearStatForm" method="post">
					<div class="yearstat-input">
						<label>Он</label>
						<select name="year1" id="YearInfo1" required="required">
							<option value>Он сонгоно уу</option>
							<?php foreach($years as $yr) : ?>
								<option value="<?php echo $yr['year']; ?>"><?php echo $yr['year']; ?></option>
							<?php endforeach; ?>
						</select>
					</div>
					<div class="yearstat-input">
						<label>Харьцуулах он</label>
						<select name="year2" id="YearInfo2" required="required">
							<option value>Он сонгоно уу</option>
							<?php foreach($years as $yr) : ?>
								<option value="<?php echo $yr['year']; ?>"><?php echo $yr['year']; ?></option>
							<?php endforeach; ?>
						</select>
					</div>
					<div class="yearstat-input">
						<label>Үзүүлэлт</label>
						<select name="indicator_id" id="IndicatorInfo" required="required" style="width: 220px;">
							<option value>Сонгоно уу</option>
							<?php
								$n = 0;
								foreach($indicators as $k=>$v) :
								$n = $n + 1;
							?>
								<option value="<?php echo $k; ?>"><?php echo $n.'. '.$v; ?></option>
							<?php endforeach; ?>
						</select>
					</div>
					<div class="yearstat-input">
						<label>Хороо</label>
						<select name="region" id="RegionInfo" required="required" style="width: 220px;">
							<option value="">Сонгоно уу</option>
							<?php foreach($results['regions'] as $rg) : ?>
							<option value="<?php echo $rg['id']; ?>"><?php echo $results['district']['title'].' '.$rg['title'].'-р хороо'; ?></option>
							<?php endforeach; ?>
						</select>
					</div>
					<div class="yearstat-input">
						<div id="yearstat-btn">Харьцуулах</div>
					</div>
				</form>
			</div>
			<div id="YearStatInfoBox">

			</div>
		</div>
	</div>
</div>
<script>
$(document).ready(function () {
	$("#SelectRegion1").bind("change", function (event) {$.ajax({async:true, data:$("#SelectRegionForm1").serialize(), dataType:"html", success:function (data, textStatus) {$("#colRegion1").html(data);}, type:"post", url:"getRegion1.php"});
	return false;});
	$("#SelectRegion2").bind("change", function (event) {$.ajax({async:true, data:$("#SelectRegionForm2").serialize(), dataType:"html", success:function (data, textStatus) {$("#colRegion2").html(data);}, type:"post", url:"getRegion2.php"});
	return false;});
	$("#yearstat-btn").bind("click", function (event) {$.ajax({async:true, data:$("#YearStatForm").serialize(), dataType:"html", success:function (data, textStatus) {$("#YearStatInfoBox").html(data);}, type:"post", url:"getYearStat.php"});
	return false;});
});
</script>
<script type="text/javascript" src="<?php echo ROOT_FOLDER; ?>/js/chart/jquery.flot.js"></script>
<script type="text/javascript" src="<?php echo ROOT_FOLDER; ?>/js/chart/jquery.flot.categories.js"></script>
<script type="text/javascript" src="<?php echo ROOT_FOLDER; ?>/js/chart/jquery.flot.resize.js"></script>
<script type="text/javascript" src="<?php echo ROOT_FOLDER; ?>/js/chart/jquery.flot.valuelabels.js"></script>
<script type="text/javascript" src="<?php echo ROOT_FOLDER; ?>/js/chart/jquery.flot.growraf.js"></script>
