<?php 
	include(ADMIN_WEB_TEMPLATE. "layout/header.php");
	include(ADMIN_TEMPLATE. "session_check.php");
?>

<div id="mainComponent">
	<div class="mainTitle">
		<?php echo $page_title; ?>
	</div>
	<div class="mainWrapper">
		<?php if ( isset( $result ) ) { ?>
		<div class="row">
			<div class="medium-8 columns">
				<div data-alert class="infoAlert alert-box alert round">
  				<?php echo $result; ?>
  				<a href="#" class="close">&times;</a>
  				</div>
			</div>
		</div>
		<?php } ?>
		<div class="orderInfoWrapper">
			<div class="yearSelectBox">
				<form action="order.php?action=selectOrderStat" method="post">
					<input type="hidden" name="id" id="ID" value="<?php echo $_GET['id']; ?>" />
					<div class="floatRow">
						<label>Он</label>
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
			<div class="row">
				<div class="medium-6 columns">
					<div class="orderInfoBlock">
						<div class="orderInfoBlockTitle">
							<?php echo $_GET['year'] ?> оны мэдээлэл
							<i class="fa fa-minus-square slideOut1"></i>
						</div>
						<div class="orderInfoBlockDetail slideBlock1">
							<div class="orderInfoBlockRow" style="border-top: none;">
								<div class="row">
									<div class="medium-6 columns">
										Нийт орлого
									</div>
									<div class="medium-6 columns text-right">
										<?php echo number_format($yearTotal).' ₮'; ?>
									</div>
								</div>
							</div>
							<div class="orderInfoBlockRow">
								<div class="row">
									<div class="medium-6 columns">
										Нийт захиалгын хэмжээ
									</div>
									<div class="medium-6 columns text-right">
										<?php echo number_format($yearTotalSize).' м<sup>3</sup>'; ?>
									</div>
								</div>
							</div>
							<div class="orderInfoBlockRow">
								<div class="row">
									<div class="medium-6 columns">
										Нийт захиалга
									</div>
									<div class="medium-6 columns text-right">
										<?php echo $totalOrder; ?> удаа
									</div>
								</div>
							</div>
							<div class="orderInfoBlockRow">
								<div class="row">
									<div class="medium-6 columns">
										Захиалга (min)
									</div>
									<div class="medium-6 columns text-right">
										<?php echo number_format($minOrder); ?> ₮
									</div>
								</div>
							</div>
							<div class="orderInfoBlockRow">
								<div class="row">
									<div class="medium-6 columns">
										Захиалга (max)
									</div>
									<div class="medium-6 columns text-right">
										<?php echo number_format($maxOrder); ?> ₮
									</div>
								</div>
							</div>
						</div>
						<div class="orderInfoBlockTitle">
							<?php echo $_GET['year'] ?> оны сар бүрийн мэдээлэл
							<i class="fa fa-minus-square slideOut2"></i>
						</div>
						<div class="orderInfoBlockDetail slideBlock2">
							<div class="orderInfoBlockRow" style="border-top: none;">
								<div class="row">
									<div class="medium-2 columns rowHeader">
										Сар
									</div>
									<div class="medium-5 columns rowHeader text-right">
										Нийт захиалсан хэмжээ м<sup>3</sup>
									</div>
									<div class="medium-5 columns rowHeader text-right">
										Нийт орлого ₮
									</div>
								</div>
							</div>
							<?php for($i=1;$i<=12;$i++) { ?>
							<div class="orderInfoBlockRow">
								<div class="row">
									<div class="medium-2 columns">
										<?php echo $i; ?>
									</div>
									<div class="medium-5 columns text-right">
										<?php echo number_format($monthTotalSize[$i]); ?> м<sup>3</sup>
									</div>
									<div class="medium-5 columns text-right">
										<?php echo number_format($monthTotal[$i]); ?> ₮
									</div>
								</div>
							</div>
							<?php } ?>
							<div class="orderInfoBlockRow" style="border-bottom: none;">
								<div class="row">
									<div class="medium-2 columns">
										Нийт
									</div>
									<div class="medium-5 columns text-right">
										<?php echo number_format($yearTotalSize); ?> м<sup>3</sup>
									</div>
									<div class="medium-5 columns text-right">
										<?php echo number_format($yearTotal); ?> ₮
									</div>
								</div>
							</div>
						</div>
						<div class="orderInfoBlockTitle">
							<?php echo $_GET['year'] ?> оны худалдан авалтын мэдээлэл
							<i class="fa fa-minus-square slideOut3"></i>
						</div>
						<div class="orderInfoBlockDetail slideBlock3">
						<?php 
							for($i=1;$i<=12;$i++) { 
						?>
							<div class="monthRow">
								<?php echo $i.'-р сар'; ?>
								<i class="fa fa-minus-square slideRow<?php echo $i; ?>"></i>
							</div>
							<?php if($monthTotal[$i] == 0) { ?>
							<div class="monthRowDetail slideRowBlock<?php echo $i; ?>">
								<div class="noDetails">Захиалгын мэдээлэл алга</div>
							</div>
							<?php } else { ?>
							<div class="monthRowDetail slideRowBlock<?php echo $i; ?>">
								<div class="monthRowHeader">
									<div class="row">
										<div class="small-3 columns text-center">
											Огноо
										</div>
										<div class="small-3 columns text-center">
											Бүтээгдэхүүн
										</div>
										<div class="small-3 columns text-right">
											Хэмжээ
										</div>
										<div class="small-3 columns text-right">
											Орлого
										</div>
									</div>
								</div>
								<?php foreach($monthOrders[$i] as $monthOrder) : ?>
								<div class="monthRowInfo">
									<div class="row">
										<div class="small-3 columns text-center">
											<?php echo date("m / d", strtotime($monthOrder['order_date'])); ?>
										</div>
										<div class="small-3 columns text-center">
											<?php echo getProductTypeName($monthOrder['product_type_id']); ?>
										</div>
										<div class="small-3 columns text-right">
											<?php echo number_format($monthOrder['size1']); ?> м<sup>3</sup>
										</div>
										<div class="small-3 columns text-right">
											<?php if($monthOrder['total_price'] == 0) { ?>
												Үнийн мэдээлэл алга
											<?php } else { ?>
												<?php echo number_format($monthOrder['total_price']); ?> ₮
											<?php } ?>
										</div>
									</div>
								</div>
								<?php endforeach; ?>
								<div class="monthRowTotal">
									<div class="row">
										<div class="small-6 columns text-center">
											Нийт
										</div>
										<div class="small-3 columns text-right">
											<?php echo number_format($monthTotalSize[$i]); ?> м<sup>3</sup>
										</div>
										<div class="small-3 columns text-right">
											<?php if($monthTotal[$i] == 0) { ?>
												0
											<?php } else { ?>
												<?php echo number_format($monthTotal[$i]); ?> ₮
											<?php } ?>
										</div>
									</div>
								</div>
							</div>
							<?php } ?>
						<?php } ?>
						</div>
					</div>
				</div>
				<div class="medium-6 columns">
					<div class="orderInfoBlock">
						<div class="orderInfoBlockTitle">
							<?php echo $_GET['year'] ?> оны график мэдээлэл (захиалгын хэмжээ - м<sup>3</sup>)
							<i class="fa fa-minus-square slideOut4"></i>
						</div>
						<div class="orderInfoBlockDetail slideBlock4">
							<div class="orderInfoBlockRow text-justify" style="border-top: none;">
								<div class="orderYearGraphSize">
									<canvas id="yearSize" style="height: 300px;"></canvas>
								</div>
							</div>
						</div>
						<div class="orderInfoBlockTitle">
							<?php echo $_GET['year'] ?> оны график мэдээлэл (захиалгын орлого - ₮)
							<i class="fa fa-minus-square slideOut5"></i>
						</div>
						<div class="orderInfoBlockDetail slideBlock5">
							<div class="orderInfoBlockRow text-justify" style="border-top: none;">
								<div class="orderYearGraph">
									<canvas id="canvas" style="height: 300px;"></canvas>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<script>

$(document).ready( function() {
	$('.slideOut1').click(function(){
    	$('.slideBlock1').slideToggle();  	
	});
	$('.slideOut2').click(function(){
    	$('.slideBlock2').slideToggle();  	
	});
	$('.slideOut3').click(function(){
    	$('.slideBlock3').slideToggle();  	
	});
	$('.slideOut4').click(function(){
    	$('.slideBlock4').slideToggle();  	
	});
	$('.slideOut5').click(function(){
    	$('.slideBlock5').slideToggle();  	
	});
<?php for($i=1;$i<=12;$i++) { ?>
	$('.slideRow<?php echo $i; ?>').click(function(){
		$('.slideRowBlock<?php echo $i; ?>').slideToggle();	
	});
<?php } ?>
});	
	
	var lineChartData = {
		labels : ["1 сар","2 сар","3 сар","4 сар","5 сар","6 сар","7 сар","8 сар", "9 сар","10 сар","11 сар","12 сар"],
		datasets : [
			{
				label: "My First dataset",
				fillColor : "#FEDE00",
				strokeColor : "#EEEEEE",
				pointColor : "rgba(220,220,220,1)",
				pointStrokeColor : "#fff",
				pointHighlightFill : "#fff",
				pointHighlightStroke : "#1e681d",
				data : [<?php echo $monthTotal[1]; ?>, <?php echo $monthTotal[2]; ?>, <?php echo $monthTotal[3]; ?>, <?php echo $monthTotal[4]; ?>, <?php echo $monthTotal[5]; ?>, <?php echo $monthTotal[6]; ?>, <?php echo $monthTotal[7]; ?>, <?php echo $monthTotal[8]; ?>, <?php echo $monthTotal[9]; ?>, <?php echo $monthTotal[10]; ?>, <?php echo $monthTotal[11]; ?>, <?php echo $monthTotal[12]; ?>]
			}
		]
	}
	
	var lineChartData2 = {
		labels : ["1 сар","2 сар","3 сар","4 сар","5 сар","6 сар","7 сар","8 сар", "9 сар","10 сар","11 сар","12 сар"],
		datasets : [
			{
				label: "My First dataset",
				fillColor : "#FEDE00",
				strokeColor : "#EEEEEE",
				pointColor : "rgba(220,220,220,1)",
				pointStrokeColor : "#fff",
				pointHighlightFill : "#fff",
				pointHighlightStroke : "#1e681d",
				data : [<?php echo $monthTotalSize[1]; ?>, <?php echo $monthTotalSize[2]; ?>, <?php echo $monthTotalSize[3]; ?>, <?php echo $monthTotalSize[4]; ?>, <?php echo $monthTotalSize[5]; ?>, <?php echo $monthTotalSize[6]; ?>, <?php echo $monthTotalSize[7]; ?>, <?php echo $monthTotalSize[8]; ?>, <?php echo $monthTotalSize[9]; ?>, <?php echo $monthTotalSize[10]; ?>, <?php echo $monthTotalSize[11]; ?>, <?php echo $monthTotalSize[12]; ?>]
			}
		]
	}

	window.onload = function(){
		var ctx = document.getElementById("canvas").getContext("2d");
		window.myLine = new Chart(ctx).Line(lineChartData, {
			responsive: true,
			scaleLineColor: "#EEEEEE",
			scaleFontColor: "e9e9e9"
		});
		var ctx2 = document.getElementById("yearSize").getContext("2d");
		window.myLine = new Chart(ctx2).Line(lineChartData2, {
			responsive: true,
			scaleLineColor: "#EEEEEE",
			scaleFontColor: "e9e9e9"
		});
	}

</script>

<?php 
	include(ADMIN_WEB_TEMPLATE. "layout/footer.php");
?>