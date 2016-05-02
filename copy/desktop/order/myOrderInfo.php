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
					Захиалгын № <?php echo $order['id']; ?>
				</div>
				<div class="myOrderInfo">
					<div class="row">
						<div class="medium-6 columns">
							<div class="myOrderCol">
								<div class="myOrderColTitle">
									Захиалгын мэдээлэл
								</div>
								<div class="myOrderColBody">
									<div class="myOrderColRow">
										<div class="row">
											<div class="medium-6 columns">
												Бүтээгдэхүүний төрөл
											</div>
											<div class="medium-6 columns">
												<?php echo getProductTypeName($order['product_type_id']); ?>
											</div>
										</div>
									</div>
									<div class="myOrderColRow">
										<div class="row">
											<div class="medium-6 columns">
												Хэмжээ
											</div>
											<div class="medium-6 columns">
												<?php echo $order['size1'].' - '.$order['size2'].' м<sup>3</sup>'; ?>
											</div>
										</div>
									</div>
									<div class="myOrderColRow">
										<div class="row">
											<div class="medium-6 columns">
												Бетон цутгалтын төрөл
											</div>
											<div class="medium-6 columns">
											<?php 
												if($order['concrete_type_id'] == '1' || $order['concrete_type_id'] == '2' || $order['concrete_type_id'] == '3' || $order['concrete_type_id'] == '4' || $order['concrete_type_id'] == '5' || $order['concrete_type_id'] == '6' || $order['concrete_type_id'] == '7' || $order['concrete_type_id'] == '8') {
													echo getConcreteTypeName($order['concrete_type_id']);	
												} else {
													echo $order['concrete_type_id'];
												} 
											?>
											</div>
										</div>
									</div>
									<div class="myOrderColRow">
										<div class="row">
											<div class="medium-6 columns">
												Помп
											</div>
											<div class="medium-6 columns">
												<?php echo getPompName($order['pomp_type_id']); ?>
											</div>
										</div>
									</div>
									<div class="myOrderColRow">
										<div class="row">
											<div class="medium-6 columns">
												Сламп
											</div>
											<div class="medium-6 columns">
												<?php echo getSlumpTypeName($order['slump_type_id']); ?>
											</div>
										</div>
									</div>
									<div class="myOrderColRow">
										<div class="row">
											<div class="medium-6 columns">
												Захиалга гүйцэтгэх огноо
											</div>
											<div class="medium-6 columns">
												<?php echo $order['order_date'].' / '.substr($order['order_time'],0,5); ?>
											</div>
										</div>
									</div>
									<div class="myOrderColRow">
										<div class="row">
											<div class="medium-6 columns">
												Захиалга өгсөн огноо
											</div>
											<div class="medium-6 columns">
												<?php echo $order['created']; ?>
											</div>
										</div>
									</div>
									<div class="myOrderColRow">
										<div class="row">
											<div class="medium-6 columns">
												Нэмэлт тайлбар
											</div>
											<div class="medium-6 columns">
												<?php echo $order['description']; ?>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="medium-6 columns">
							<div class="myOrderCol">
								<div class="myOrderColTitle">
									Захиалгын явц
								</div>
								<div class="myOrderColBody">
									<div class="myOrderColRow">
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
									<?php if($order['status'] >= 4) { ?>
									<div class="myOrderColRow">
										<div class="progress small-12 factory-finished radius round">
  											<span class="meter" style="width: <?php echo ($order['produced']*100)/$order['size1']; ?>%">
  												<div class="factoryProgress" <?php if($order['factory_progress'] == 0 || $order['factory_progress'] == NULL) { echo 'style="color: #000;"'; } ?>>
  												<?php echo round(($order['produced']*100)/$order['size1']); ?>%
  												<?php if($order['produced'] != 0) { echo ' ('.$order['produced'].' м<sup>3</sup>)'; } ?>
  												</div>
  											</span>
										</div>
									</div>
									<?php } ?>
								</div>
								<?php if($order['price'] != NULL) { ?>
								<div class="myOrderColTitle">
									Төлбөрийн мэдээлэл
								</div>
								<div class="myOrderColBody">
									<div class="myOrderColRow">
										<div class="row">
											<div class="medium-6 columns">
												Олгосон гэрээний №
											</div>
											<div class="medium-6 columns">
												<?php echo $order['agreement_id']; ?>
											</div>
										</div>
									</div>
									<div class="myOrderColRow">
										<div class="row">
											<div class="medium-6 columns">
												Хэмжээ
											</div>
											<div class="medium-6 columns">
												<?php echo $order['size1']; ?> м<sup>3</sup>
											</div>
										</div>
									</div>
									<div class="myOrderColRow">
										<div class="row">
											<div class="medium-6 columns">
												Бүтээгдэхүүний үнэ (1м<sup>3</sup>)
											</div>
											<div class="medium-6 columns">
												<?php echo $order['price']; ?>₮
											</div>
										</div>
									</div>
									<div class="myOrderColRow">
										<div class="row">
											<div class="medium-6 columns">
												Нийт дүн
											</div>
											<div class="medium-6 columns">
												<?php echo $order['total_price']; ?>₮
											</div>
										</div>
									</div>
									<?php if($order['barter'] != 0) { ?>
									<div class="myOrderColRow">
										<div class="row">
											<div class="medium-6 columns">
												Бартер
											</div>
											<div class="medium-6 columns">
												<?php echo $order['barter']; ?>₮
											</div>
										</div>
									</div>
									<?php } ?>
									<div class="myOrderColRow">
										<div class="row">
											<div class="medium-6 columns">
												Төлсөн
											</div>
											<div class="medium-6 columns">
												<?php echo $order['payment1']; ?>₮
											</div>
										</div>
									</div>
									<div class="myOrderColRow">
										<div class="row">
											<div class="medium-6 columns">
												Төлбөрийн үлдэгдэл
											</div>
											<div class="medium-6 columns">
												<?php echo $order['payment2']; ?>₮
											</div>
										</div>
									</div>
								</div>
								<?php } ?>
								<?php if($order['quality_cert'] != NULL || $order['slump_img'] != NULL || $order['research_page'] != NULL || $order['concrete_reply7'] != NULL || $order['concrete_reply14'] != NULL || $order['concrete_reply28'] != NULL) { ?>
								<div class="myOrderColTitle">
									Нэмэлт
								</div>
								<div class="myOrderColBody">
								<?php if($order['quality_cert'] != NULL) { ?>
									<div class="myOrderColRow">
										<div class="row">
											<div class="medium-6 columns">
												Чанарын гэрчилгээ
											</div>
											<div class="medium-6 columns">
												<a href="<?php echo MAIN_FOLDER.'/quality_cert/'.$order['quality_cert']; ?>" target="_blank" class="downloadFile">Татах</a>
											</div>
										</div>
									</div>
								<?php } ?>
								<?php if($order['slump_img'] != NULL) { ?>
									<div class="myOrderColRow">
										<div class="row">
											<div class="medium-6 columns">
												Талбайн слампын зураг
											</div>
											<div class="medium-6 columns">
												<a href="<?php echo MAIN_FOLDER.'/slump_img/'.$order['slump_img']; ?>" target="_blank" class="downloadFile">Татах</a>
											</div>
										</div>
									</div>
								<?php } ?>
								<?php if($order['research_page'] != NULL) { ?>
									<div class="myOrderColRow">
										<div class="row">
											<div class="medium-6 columns">
												Судалгааны хуудас
											</div>
											<div class="medium-6 columns">
												<a href="<?php echo MAIN_FOLDER.'/research_page/'.$order['research_page']; ?>" target="_blank" class="downloadFile">Татах</a>
											</div>
										</div>
									</div>
								<?php } ?>
								<?php if($order['concrete_reply7'] != NULL) { ?>
									<div class="myOrderColRow">
										<div class="row">
											<div class="medium-6 columns">
												Бетон шооны хариу /7 хоног - дотоод/
											</div>
											<div class="medium-6 columns">
												<a href="<?php echo MAIN_FOLDER.'/concrete_reply7/'.$order['concrete_reply7']; ?>" target="_blank" class="downloadFile">Татах</a>
											</div>
										</div>
									</div>
								<?php } ?>
								<?php if($order['concrete_reply14'] != NULL) { ?>
									<div class="myOrderColRow">
										<div class="row">
											<div class="medium-6 columns">
												Бетон шооны хариу /14 хоног - дотоод/
											</div>
											<div class="medium-6 columns">
												<a href="<?php echo MAIN_FOLDER.'/concrete_reply14/'.$order['concrete_reply14']; ?>" target="_blank" class="downloadFile">Татах</a>
											</div>
										</div>
									</div>
								<?php } ?>
								<?php if($order['concrete_reply28'] != NULL) { ?>
									<div class="myOrderColRow">
										<div class="row">
											<div class="medium-6 columns">
												Бетон шооны хариу /28 хоног - БАК-ын хариу/
											</div>
											<div class="medium-6 columns">
												<a href="<?php echo MAIN_FOLDER.'/concrete_reply28/'.$order['concrete_reply28']; ?>" target="_blank" class="downloadFile">Татах</a>
											</div>
										</div>
									</div>
								<?php } ?>
								</div>
								<?php } ?>
							</div>
						</div>
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