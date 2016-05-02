<?php include(ADMIN_TEMPLATE. "template/header_chart.php"); ?>
<?php include(ADMIN_TEMPLATE. "session_check.php"); ?>

<div id="orderInfoTab">
	<div class="row">
		<div class="small-12 columns">
			<ul class="tabs" data-tab role="tablist">
  				<li class="tab-title active" role="presentational" ><a href="#panel2-1" role="tab" tabindex="0" aria-selected="true" controls="panel2-1">Статистик</a></li>
  				<li class="tab-title" role="presentational" ><a href="#panel2-2" role="tab" tabindex="0"aria-selected="false" controls="panel2-2">Худалдан авалт</a></li>
			</ul>	
		</div>
	</div>
</div>

<div id="orderInfoFull">
	<div class="tabs-content">
		<section role="tabpanel" aria-hidden="false" class="content active" id="panel2-1">
			<div class="orderInfoFullBody">
				<div class="yearSelectBox">
					<form action="order.php?action=selectOrderStat" method="post">
						<input type="hidden" name="id" id="ID" value="<?php echo $_GET['id']; ?>" />
						<div class="floatRow" style="width: 35%;">
							<select name="year" id="Year" required="required">
								<?php for($k=2014; $k<=date('Y'); $k++) { ?>
								<option value="<?php echo $k; ?>" <?php if($_GET['year'] == $k){ echo 'selected'; } ?>><?php echo $k; ?></option>
								<?php } ?>
							</select>
						</div>
						<div class="floatRow">
							<button type="submit" name="selectYear" class="yearSelectBtn">Он сонгох</button>
						</div>
					</form>
				</div>
				<ul class="accordion" data-accordion>
					<li class="accordion-navigation">
						<a href="#panel1a" class="orderInfoFullTitle"><?php echo $_GET['year'] ?> оны мэдээлэл</a>
						<div id="panel1a" class="content active">					
				<div class="orderYearInfoBlock">
				<div class="row">
					<div class="small-5 columns">
						<div class="totalYearLabel">
							Нийт орлого
						</div>
						<div class="totalYearInfo">
							<?php echo number_format($yearTotal).' ₮'; ?>
						</div>
					</div>
					<div class="small-7 columns">
						<div class="orderYearInfos">
							<div class="orderYearRow">
								<div class="row">
									<div class="small-6 columns text-left">
										<div class="orderYearInfoTitle">
											Нийт захиалга
										</div>
									</div>
									<div class="small-6 columns text-right">
										<div class="orderYearInfo">
											<?php echo $totalOrder; ?> удаа
										</div>
									</div>
								</div>
							</div>
							<div class="orderYearRow">
								<div class="row">
									<div class="small-6 columns text-left">
										<div class="orderYearInfoTitle">
											Захиалга (min)
										</div>
									</div>
									<div class="small-6 columns text-right">
										<div class="orderYearInfo">
											<?php echo number_format($minOrder); ?> ₮
										</div>
									</div>
								</div>
							</div>
							<div class="orderYearRow">
								<div class="row">
									<div class="small-6 columns text-left">
										<div class="orderYearInfoTitle">
											Захиалга (max)
										</div>
									</div>
									<div class="small-6 columns text-right">
										<div class="orderYearInfo">
											<?php echo number_format($maxOrder); ?> ₮
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				</div>
						</div>
					</li>
				</ul>
			</div>
			<div id="companyStatBlock">
				<ul class="accordion" data-accordion>
					<li class="accordion-navigation">
						<a href="#panel2a" class="orderInfoFullTitle"><?php echo $_GET['year'] ?> оны график мэдээлэл</a>
						<div id="panel2a" class="content active">
				<div class="orderYearGraph">
					<div class="row">
						<div class="small-11 columns">
							<canvas id="canvas" style="height: 150px;"></canvas>
						</div>
					</div>
				</div>
						</div>
					</li>
				</ul>
			</div>
			<div id="companyStatTable">
				<ul class="accordion" data-accordion>
					<li class="accordion-navigation">
						<a href="#panel3a" class="orderInfoFullTitle"><?php echo $_GET['year'] ?> оны мэдээлэл /хүснэгт/</a>
						<div id="panel3a" class="content active">
				<div class="orderYearTable">
					<div class="orderYearTableHeaderRow">
						<div class="row">
							<div class="small-3 columns text-center">
								Сар
							</div>
							<div class="small-4 columns text-right">
								Нийт хэмжээ
							</div>
							<div class="small-5 columns text-right">
								Нийт орлого
							</div>
						</div>
					</div>
				<?php
					$k = 0; 
					for($i=1;$i<=12;$i++) { 
					$k = 1 - $k;
				?>
					<div class="orderYearTableRow <?php if($k == 0) { echo 'evenRow'; } ?>">
						<div class="row">
							<div class="small-3 columns text-center">
								<?php echo $i.' сар'; ?>
							</div>
							<div class="small-4 columns text-center">
								<?php echo number_format($monthTotalSize[$i]); ?> м<sup>3</sup>
							</div>
							<div class="small-5 columns text-right">
								<?php echo number_format($monthTotal[$i]); ?> ₮
							</div>
						</div>
					</div>
				<?php } ?>
				</div>
						</div>
					</li>
				</ul>
			</div>
		</section>
		<section role="tabpanel" aria-hidden="true" class="content" id="panel2-2">
			<div class="orderInfoFullBody">
				<ul class="accordion" data-accordion>
					<li class="accordion-navigation">
						<a href="#panel4a" class="orderInfoFullTitle"><?php echo $_GET['year'] ?> оны захиалгын дэлгэрэнгүй</a>
						<div id="panel4a" class="content active">
				<div class="companyOrderInfoTable">
				<?php 
					for($i=1;$i<=12;$i++) { 
				?>
					<div class="companyOrderInfoHeader">
						<?php echo $i.'-р сар'; ?>
						<i class="fa fa-minus-square slideRow<?php echo $i; ?>"></i>
					</div>
					<?php if($monthTotal[$i] == 0) { ?>
						<div class="companyOrderInfoRowHeader slideRowBlock<?php echo $i; ?>">
							<div class="row">
								<div class="small-12 columns" style="color: #f04124; padding: 8px 15px;">
									Захиалгын мэдээлэл алга
								</div>
							</div>
						</div>
					<?php } else { ?>
					<div class="companyOrderInfoBody slideRowBlock<?php echo $i; ?>">
						<div class="companyOrderInfoRowHeader">
							<div class="row">
								<div class="small-3 columns text-center">
									Огноо
								</div>
								<div class="small-4 columns text-right">
									Хэмжээ
								</div>
								<div class="small-5 columns text-right">
									Орлого
								</div>
							</div>
						</div>
					<?php foreach($monthOrders[$i] as $monthOrder) : ?>
						<div class="companyOrderInfoRow">
							<div class="row">
								<div class="small-3 columns text-center">
									<?php echo date("m / d", strtotime($monthOrder['order_date'])); ?>
								</div>
								<div class="small-4 columns text-right">
									<?php echo number_format($monthOrder['size1']); ?> м<sup>3</sup>
								</div>
								<div class="small-5 columns text-right">
									<?php echo number_format($monthOrder['total_price']); ?> ₮
								</div>
							</div>
						</div>
					<?php endforeach; ?>
						<div class="companyOrderInfoRow totalRow">
							<div class="row">
								<div class="small-3 columns text-center">
									Нийт
								</div>
								<div class="small-4 columns text-left">
									<?php echo number_format($monthTotalSize[$i]); ?> м<sup>3</sup>
								</div>
								<div class="small-5 columns text-right">
									<?php echo number_format($monthTotal[$i]); ?> ₮
								</div>
							</div>
						</div>
					</div>
					<?php } ?>
				<?php } ?>
				</div>
						</div>
					</li>
				</ul>
			</div>
		</section>
	</div>
</div>

<script>

		var lineChartData = {
			labels : ["1 сар","2 сар","3 сар","4 сар","5 сар","6 сар","7 сар","8 сар", "9 сар","10 сар","11 сар","12 сар"],
			datasets : [
				{
					label: "My First dataset",
					fillColor : "#1e681d",
					strokeColor : "#0d9406",
					pointColor : "rgba(220,220,220,1)",
					pointStrokeColor : "#fff",
					pointHighlightFill : "#fff",
					pointHighlightStroke : "#1e681d",
					data : [<?php echo $monthTotal[1]; ?>, <?php echo $monthTotal[2]; ?>, <?php echo $monthTotal[3]; ?>, <?php echo $monthTotal[4]; ?>, <?php echo $monthTotal[5]; ?>, <?php echo $monthTotal[6]; ?>, <?php echo $monthTotal[7]; ?>, <?php echo $monthTotal[8]; ?>, <?php echo $monthTotal[9]; ?>, <?php echo $monthTotal[10]; ?>, <?php echo $monthTotal[11]; ?>, <?php echo $monthTotal[12]; ?>]
				}
			]

		}

	window.onload = function(){
		var ctx = document.getElementById("canvas").getContext("2d");
		window.myLine = new Chart(ctx).Line(lineChartData, {
			responsive: true,
			scaleLineColor: "#313131",
			scaleFontColor: "e9e9e9"
		});
	}


</script>

<?php include(ADMIN_TEMPLATE. "template/footer.php"); ?>