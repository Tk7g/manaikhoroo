<?php
require_once(realpath(dirname(__FILE__))."/classes/Info.class.php");
require_once(realpath(dirname(__FILE__))."/classes/Region.class.php");
require_once(realpath(dirname(__FILE__))."/classes/District.class.php");
if(isset($_POST['year1']) && !empty($_POST['year1']) && isset($_POST['year2']) && !empty($_POST['year2']) && isset($_POST['region']) && !empty($_POST['region'])) {
	$result1 = Info::RegionInfo($_POST['region'], $_POST['year1']);
	$result2 = Info::RegionInfo($_POST['region'], $_POST['year2']);
	$current_region = Region::getRegion($_POST['region']);
	$current_district = District::getDistrict($current_region['district_id']);
	$indicators = array('population', 'household', 'household_average', 'area_length', 'population_density', 'bus_density', 'well_num', 'well_density', 'well_ratio', 'trash_num', 'risk_ratio', 'hospital_ratio', 'kin_num', 'kin_ratio', 'school_num', 'school_ratio');
	$indicator_title = array('Хүн амын тоо', 'Нийт өрхийн тоо', 'Өрхийн дундаж хэмжээ', 'Газар нутгийн хэмжээ (га)', 'Хүн амын нягтаршил (хүн/га)', 'Автобусны буудлаас 5 минут алхах зайд амьдардаг хүн амын %', 'Усны худгийн тоо', 'Усны худгаас 5 минут алхах зайд амьдардаг хүн амын %', '1000 хүнд ноогдох усны худгийн харьцаа', 'Албан бус хогийн цэгийн тоо', 'Аюултай бүсээс 100м зайнд амьдардаг хүн амын %', 'Өрхийн болон бусад эмнэлэгийн харьцаа', '2-5 насны цэцэрлэгэт хамрагддаггүй хүүхдийн тоо', '2-5 насны цэцэрлэгэт хамрагддаггүй хүүхдийн %', '6-16 насны сургуульд хамрагддаггүй хүүхдийн тоо', '6-16 насны сургуульд хамрагддаггүй хүүхдийн %');
?>
<div class="YearStatBoxTitle">
	<?php echo $current_district['title'].' дүүргийн '.$current_region['title'].'-р хорооны</br>'.$indicator_title[$_POST['indicator_id']].''; ?>
</div>
<div class="row">
	<div class="col-md-5">
		<div class="yearStatTable">
			<table width="100%">
				<tr>
					<th width="30%">Он</th>
					<th width="70%"><?php echo $indicator_title[$_POST['indicator_id']]; ?></th>
				</tr>
				<tr>
					<td><?php echo $_POST['year1']; ?></td>
					<td><?php if($result1[$indicators[$_POST['indicator_id']]] != NULL) { echo $result1[$indicators[$_POST['indicator_id']]]; } else { echo 0; } ?></td>
				</tr>
				<tr>
					<td><?php echo $_POST['year2']; ?></td>
					<td><?php if($result2[$indicators[$_POST['indicator_id']]] != NULL) { echo $result2[$indicators[$_POST['indicator_id']]]; } else { echo 0; } ?></td>
				</tr>
			</table>
		</div>
	</div>
	<div class="col-md-7">
		<div id="yearStatChart" style="width: 100%; height: 250px;"></div>
	</div>
</div>
<script>
 //******* 2012 Average Temperature - BAR CHART
        var data = [[0, <?php if($result1[$indicators[$_POST['indicator_id']]] != NULL) { echo $result1[$indicators[$_POST['indicator_id']]]; } else { echo 0; } ?>],[1, <?php if($result2[$indicators[$_POST['indicator_id']]] != NULL) { echo $result2[$indicators[$_POST['indicator_id']]]; } else { echo 0; } ?>]]
        var dataset = [{ label: "<?php echo $indicator_title[$_POST['indicator_id']]; ?>", data: data, color: "#00a5d3" }];
        var ticks = [[0, "<?php echo $_POST['year1']; ?>"], [1, "<?php echo $_POST['year2']; ?>"]];
 
        var options = {
            series: {
                bars: {
                    show: true
                }
            },
            bars: {
                align: "center",
                barWidth: 0.8
            },
            xaxis: {
                axisLabel: "Он",
                axisLabelUseCanvas: true,
                axisLabelFontSizePixels: 12,
                axisLabelFontFamily: 'Verdana, Arial',
                axisLabelPadding: 10,
                ticks: ticks
            },
            yaxis: {
                axisLabel: "<?php echo $indicator_title[$_POST['indicator_id']]; ?>",
                axisLabelUseCanvas: true,
                axisLabelFontSizePixels: 12,
                axisLabelFontFamily: 'Verdana, Arial',
                axisLabelPadding: 3,
                tickFormatter: function (v, axis) {
                    return v;
                }
            },
            legend: {
                noColumns: 0,
                labelBoxBorderColor: "#000000",
                position: "nw"
            },
            grid: {
                hoverable: true,
                borderWidth: 2,
                backgroundColor: { colors: ["#ffffff", "#EDF5FF"] }
            }
        };
 
        $(document).ready(function () {
            $.plot($("#yearStatChart"), dataset, options);
        });
</script>
<?php
	}
?>