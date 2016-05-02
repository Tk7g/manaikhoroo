<?php
include(WEB_TEMPLATE."header.php");
?>
<div id="homeWrapper">
	<div class="orderPage">
		<div class="row">
			<div class="medium-9 columns orderContent">
				<?php if ( isset( $result ) ) { ?>
				<div data-alert class="infoAlert alert-box alert round">
  					<?php echo $result; ?>
  					<a href="#" class="close">&times;</a>
				</div>
				<?php } ?>
				<div class="orderPageTitle">
					<h1><?php echo $page_title; ?></h1>
				</div>
				<div class="orderPageTab">
					<ul class="button-group">
						<li><a href="order.php?action=loginOrder" class="button">Захиалга өгөх</a></li>
						<li><a href="order.php?action=companyInfo" class="button">Компаний бүртгэл</a></li>
						<li><a href="order.php?action=myOrder" class="button activeTab">Миний захиалгууд</a></li>
					</ul>
				</div>
				<div class="orderFormTitle">
					Миний захиалгууд /<?php echo $current_year; ?> он/
				</div>
				<div class="orderYearSelect">
					<form action="order.php?action=yearSelect" method="post">
						<label>Он</label>
						<select name="year" id="Year" required="required">
							<?php for($k=2014;$k<=date('Y');$k++) { ?>
							<option value="<?php echo $k; ?>" <?php if($current_year == $k){ echo 'selected'; } ?>><?php echo $k.' он'; ?></option>
							<?php } ?>
						</select>
						<button type="submit" name="selectYear" class="selectYearBtn">Хайх</button>
					</form>
				</div>
				<div class="myOrderBlock">
					<div class="myOrderHeader">
						<div class="row">
							<div class="medium-4 columns">
								Захиалгын №
							</div>
							<div class="medium-5 columns">
								Бүтээгдэхүүний төрөл
							</div>
							<div class="medium-3 columns">
								Хэмжээ
							</div>
						</div>
					</div>
					<div class="myOrderBody">
					<?php foreach($orders as $order) : ?>
						<div class="myOrderRow">
							<div class="row">
								<div class="medium-4 columns">
									<div class="topRow">
									<?php echo '№ '.$order['id']; ?>
									</div>
									<div class="addRow">
										<?php echo 'Захиалгын огноо: '.$order['order_date']; ?>
									</div>
									<div class="addRow">
										<?php echo 'Захиалг өгсөн огноо: '.substr($order['created'], 0, 10); ?>
									</div>
									<a class="myOrderMore" href="order.php?action=myOrderInfo&id=<?php echo $order['id']; ?>">Дэлгэрэнгүй</a>
								</div>
								<div class="medium-5 columns">
									<div class="topRow">
									<?php echo getProductTypeName($order['product_type_id']); ?>
									</div>
									<?php if($order['slump_type_id'] != NULL) { ?>
									<div class="addRow">
										<?php echo 'Сламп: '.getSlumpTypeName($order['slump_type_id']); ?>
									</div>
									<?php } ?>
									<?php if($order['pomp_type_id'] != NULL) { ?>
									<div class="addRow">
										<?php echo 'Помп: '.getPompName($order['pomp_type_id']); ?>
									</div>
									<?php } ?>
									<div class="addRow">
									<?php
										if($order['status'] == 1){
											echo 'Статус: Гэрээний № олгогдсон';
										} elseif($order['status'] == 2) {
											echo 'Статус: Гэрээний № олгогдсон';
										} elseif($order['status'] == 3) {
											echo 'Статус: Цуцлагдсан';
										} elseif($order['status'] == 4) {
											echo 'Статус: Үйлдвэрт шилжүүлсэн';	
										} elseif($order['status'] == 5) {
											echo 'Статус: Үйлдвэрлэж эхэлсэн';
										} elseif($order['status'] == 6) {
											echo 'Статус: Үйлдвэрлэж дууссан';
										} elseif($order['status'] == 0) {
											echo 'Статус: Илгээгдсэн';
										}
									?>
									</div>
								</div>
								<div class="medium-3 columns">
									<div class="topRow">
									<?php echo $order['size1'].' м<sup>3</sup>'; ?>
									</div>
									<?php if($order['price'] != NULL) { ?>
									<div class="addRow">
										<?php echo 'Үнэ (1м<sup>3</sup>): '.$order['price']; ?>₮
									</div>
									<?php } ?>
									<?php if($order['total_price'] != NULL) { ?>
									<div class="addRow">
										<?php echo 'Үнийн дүн: '.$order['total_price']; ?>₮
									</div>
									<?php } ?>
								</div>
							</div>
						</div>
					<?php endforeach; ?>
					</div>
				</div>
			</div>
			<div class="medium-3 columns">
				<div class="sideBlock1">
					<div class="sideCalculator">
						<div class="sideCatTitle">
							Тооцоолуур
						</div>
						<div class="sideCalcBody">
							<div class="calcRow">
								<div class="calcLabel">
									Урт (метр)
								</div>
								<div class="calcInput">
									<input id="Length" value="0" />
								</div>
							</div>
							<div class="calcRow">
								<div class="calcLabel">
									Өргөн (метр)
								</div>
								<div class="calcInput">
									<input id="Width" value="0" />
								</div>
							</div>
							<div class="calcRow">
								<div class="calcLabel">
									Зузаан (метр)
								</div>
								<div class="calcInput">
									<input id="Thickness" value="0" />
								</div>
							</div>
							<div class="calcBtn">
								<a href="#" id="calcBtn1">Тооцоолох</a>
							</div>
						</div>
						<div class="calcResult">
							<div class="calcResRow">
								<div class="calcResLabel">Хэмжээ (м<sup>3</sup>)</div>
								<div class="calcResInfo">--</div>
							</div>
						</div>
					</div>
					<div class="sideShapeCalc">
						<div class="sideCatTitle">
							Тооцоолуур
						</div>
						<div class="sideShapeCalcBody">
							<div class="calcShapeBlock">
								<div class="calcShapeRow">
									<a class="shapeBtn" id="shapeCyl"><img src="<?php echo IMG_FOLDER.'shapes/cylinder.png'; ?>" /></a>
									<div class="shapeVolCalc" id="shapeCylCalc">
										<div class="shapeVolCalcRow">
											<div class="calcLabel">r:</div>
											<div class="calcInput"><input id="CylR" value="0" /></div>
										</div>
										<div class="shapeVolCalcRow">
											<div class="calcLabel">h:</div>
											<div class="calcInput"><input id="CylH" value="0" /></div>
										</div>
										<div class="shapeVolCalcBtn">
											<a id="shapeCylCalcBtn">Тооцоолох</a>
										</div>
										<div class="shapeVolRes">
											<div class="shapeVolResLabel">Хэмжээ (м<sup>3</sup>)</div>
											<div id="shapeCylRes" class="shapeVolInfo">--</div>
										</div>
									</div>
								</div>
								<div class="calcShapeRow">
									<a class="shapeBtn" id="shapeCylHol"><img src="<?php echo IMG_FOLDER.'shapes/cylinder-hollow.png'; ?>" /></a>
									<div class="shapeVolCalc" id="shapeCylHolCalc">
										<div class="shapeVolCalcRow">
											<div class="calcLabel">r<sup>1</sup>:</div>
											<div class="calcInput"><input id="CylR1" value="0" /></div>
										</div>
										<div class="shapeVolCalcRow">
											<div class="calcLabel">r<sup>2</sup>:</div>
											<div class="calcInput"><input id="CylR2" value="0" /></div>
										</div>
										<div class="shapeVolCalcRow">
											<div class="calcLabel">h:</div>
											<div class="calcInput"><input id="CylH1" value="0" /></div>
										</div>
										<div class="shapeVolCalcBtn">
											<a id="shapeCylHolCalcBtn">Тооцоолох</a>
										</div>
										<div class="shapeVolRes">
											<div class="shapeVolResLabel">Хэмжээ (м<sup>3</sup>)</div>
											<div id="shapeCylHolRes" class="shapeVolInfo">--</div>
										</div>
									</div>
								</div>
								<div class="calcShapeRow">
									<a class="shapeBtn" id="shapeRec"><img src="<?php echo IMG_FOLDER.'shapes/rectangle.png'; ?>" /></a>
									<div class="shapeVolCalc" id="shapeRecCalc">
										<div class="shapeVolCalcRow">
											<div class="calcLabel">r<sup>1</sup>:</div>
											<div class="calcInput"><input id="CylR11" value="0" /></div>
										</div>
										<div class="shapeVolCalcRow">
											<div class="calcLabel">r<sup>2</sup>:</div>
											<div class="calcInput"><input id="CylR22" value="0" /></div>
										</div>
										<div class="shapeVolCalcRow">
											<div class="calcLabel">h:</div>
											<div class="calcInput"><input id="CylH11" value="0" /></div>
										</div>
										<div class="shapeVolCalcBtn">
											<a id="shapeRecCalcBtn">Тооцоолох</a>
										</div>
										<div class="shapeVolRes">
											<div class="shapeVolResLabel">Хэмжээ (м<sup>3</sup>)</div>
											<div id="shapeRecRes" class="shapeVolInfo">--</div>
										</div>
									</div>
								</div>
							</div>
							<div class="shapeCalcSection">
								
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<script>

function calcSize1() {
	var length = $("#Length").val();
	var width = $("#Width").val();
	var thickness = $("#Thickness").val();
	var concSize = length * width * thickness;
	$(".calcResInfo").html(concSize+' м<sup>3</sup>');
}

$("#calcBtn1").click(function(){
	calcSize1();
});

function calcCyl() {
	var radius = $("#CylR").val();
	var height = $("#CylH").val();
	var concSize = 3.14159 * radius * radius * height;
	$("#shapeCylRes").html(concSize+' м<sup>3</sup>');
}

$("#shapeCyl").click(function(){
	$.each($('.calcShapeRow'), function(index){
		$(this).find('.shapeVolCalc').fadeOut();
	});
	$("#shapeCylCalc").fadeIn();
});

$("#shapeCylCalcBtn").click(function(){
	calcCyl();
});

function calcHolCyl() {
	var radius1 = $("#CylR1").val();
	var radius2 = $("#CylR2").val();
	var height1 = $("#CylH1").val();
	var concSize1 = 3.14159 * height1 *((radius1 * radius1) - (radius2 * radius2));
	$("#shapeCylHolRes").html(concSize1+' м<sup>3</sup>');
}

$("#shapeCylHol").click(function(){
	$.each($('.calcShapeRow'), function(index){
		$(this).find('.shapeVolCalc').fadeOut();
	});
	$("#shapeCylHolCalc").fadeIn();
});

$("#shapeCylHolCalcBtn").click(function(){
	calcHolCyl();	
});

function calcRec() {
	var radius11 = $("#CylR11").val();
	var radius22 = $("#CylR22").val();
	var height11 = $("#CylH11").val();
	var concSize11 = height11 * radius11 * radius22;
	$("#shapeRecRes").html(concSize11+' м<sup>3</sup>');
}

$("#shapeRec").click(function(){
	$.each($('.calcShapeRow'), function(index){
		$(this).find('.shapeVolCalc').fadeOut();
	});
	$("#shapeRecCalc").fadeIn();
});

$("#shapeRecCalcBtn").click(function(){
	calcRec();
});
	
  $(function() {
    $( "#OrderDate" ).datepicker({
    	dateFormat: "yy-mm-dd"
    });
  });
  
  $(document).ready(function(){
  	$('#OrderTime').change(function() {
  		var selectedName = $("#OrderTime option:selected").text();
  		var selectedTime = $("#OrderTime option:selected").attr('id');
    	$("#OrderTime option:selected").text(selectedName + '-' + selectedTime + ':00');
	});
  });
</script>

<?php
include(WEB_TEMPLATE."footer.php");
?>