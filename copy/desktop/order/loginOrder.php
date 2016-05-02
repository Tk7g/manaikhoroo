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
						<li><a href="order.php?action=loginOrder" class="button activeTab">Захиалга өгөх</a></li>
						<li><a href="order.php?action=companyInfo" class="button">Компаний бүртгэл</a></li>
						<li><a href="order.php?action=myOrder" class="button">Миний захиалгууд</a></li>
					</ul>
				</div>
				<div class="orderFormTitle">
					Шууд захиалга
				</div>
				<div class="orderForm">
					<form action="order.php?action=loginOrder" method="post" autocomplete="off">
						<div class="row">
							<div class="medium-6 columns">
								<div class="orderFormRow" style="border-top: none;">	
									<label>Бүтээгдэхүүний төрөл</label>
									<select name="product_type_id" id="ProductTypeID" required="required">
        								<option>Сонгоно уу</option>
        								<?php foreach($parentProTypes as $parentPT) : ?>
        								<?php if($childProType[$parentPT['id']] != NULL) { ?>
        								<optgroup label="<?php echo $parentPT['title']; ?>">
        								<?php foreach($childProType[$parentPT['id']] as $childPT) : ?>
        								<option value="<?php echo $childPT['id']; ?>"><?php echo $childPT['title']; ?></option>
        								<?php endforeach; ?>
        								</optgroup>
        								<?php } else { ?>
        								<option value="<?php echo $parentPT['id']; ?>"><?php echo $parentPT['title']; ?></option>
        								<?php } ?>
        								<?php endforeach; ?>
        							</select>	
								</div>
								<div class="orderFormRow inputFloatleft">
									<label>Захиалгын хэмжээ м<sup>3</sup></label>
									<input name="size1" type="text" id="Size1" required="required" placeholder="" style="margin-right: 10%;" />
									<input name="size2" type="text" id="Size2" required="required" placeholder="" />
								</div>
								<div class="orderFormRow">
									<label>Сламп</label>
									<select name="slump_type_id" id="SlumpTypeId" required="required">
        								<option value="">Сонгоно уу</option>
        								<?php foreach($slumps as $slump) : ?>
        								<option value="<?php echo $slump['id']; ?>"><?php echo $slump['title']; ?></option>
        								<?php endforeach; ?>
        							</select>	
								</div>
								<div class="orderFormRow">
									<label>Төлбөрийн төлөв</label>
        							<select name="payment_status" id="PaymentStatus" required="required">
        								<option value="">Сонгоно уу</option>
        								<option value="1">Бэлнээр</option>
        								<option value="2">Гэрээний дагуу</option>
        							</select>
								</div>
								<div class="orderFormRow">
									<label>Захиалгын огноо</label>
        							<input name="order_date" type="text" id="OrderDate" required="required" placeholder="Захиалгын огноо" />
								</div>
								<div class="orderFormRow">
									<label>Захиалгын цаг</label>
        							<select name="order_time" id="OrderTime" required="required">
        								<option value="">Сонгоно уу</option>
        								<?php for($i=0; $i<=24; $i++) { ?>
        								<option id="<?php echo $i+2; ?>" value="<?php echo $i.':00'; ?>"><?php echo $i.':00'; ?></option>
        								<?php } ?>
        							</select>
								</div>
								<div class="orderFormRow">
						 			<label>Помп хэрэглэх</label>
        							<select name="pomp_type_id" id="PompID">
        								<option value="">Сонгоно уу</option>
        								<?php foreach($pomps as $pomp) : ?>
        								<option value="<?php echo $pomp['id']; ?>"><?php echo $pomp['title']; ?></option>
        								<?php endforeach; ?>
        							</select>
								</div>
								<div class="orderFormRow">
									<label>Бетон цутгалтын төрөл</label>
        							<select name="concrete_type_id" id="ConcreteTypeId" required="required">
        								<option value="">Сонгоно уу</option>
        								<?php foreach($concretes as $concrete) : ?>
        								<option value="<?php echo $concrete['id']; ?>"><?php echo $concrete['title']; ?></option>
        								<?php endforeach; ?>
        							</select>
								</div>
								<div class="orderFormRow" style="border-bottom: none;">
									<label>Нэмэлт тайлбар</label>
        							<input name="description" type="text" id="Description" placeholder="Нэмэлт тайлбар"/>
								</div>
								<div class="orderFormBtn">
									<button type="submit" name="orderSubmit" class="sendOrder">Батлах</button>
        							<a class="cancelOrder" href="order.php?action=loginOrder">Цуцлах</a>	
        						</div>
        						
							</div>
							<div class="medium-6 columns">
								<div class="infoBlockTitle">
									Захиалагчийн мэдээлэл
								</div>
								<div class="orderFormRow" style="border-top: none;">
									<div class="row">
										<div class="medium-6 columns text-left">
											<div class="infoLabel">Гэрээний дугаар</div>
										</div>
										<div class="medium-6 columns text-right">
											<div class="infoText"><?php echo $company['agreement_id']; ?></div>
										</div>
									</div>
								</div>
								<div class="orderFormRow">
									<div class="row">
										<div class="medium-6 columns text-left">
											<div class="infoLabel">Компаний нэр</div>
										</div>
										<div class="medium-6 columns text-right">
											<div class="infoText"><?php echo $company['name']; ?></div>
										</div>
									</div>
								</div>
								<div class="orderFormRow">
									<div class="row">
										<div class="medium-6 columns text-left">
											<div class="infoLabel">Захиалагчийн нэр</div>
										</div>
										<div class="medium-6 columns text-right">
											<div class="infoText"><?php echo $company['client_name']; ?></div>
										</div>
									</div>
								</div>
								<div class="orderFormRow">
									<div class="row">
										<div class="medium-6 columns text-left">
											<div class="infoLabel">Албан тушаал</div>
										</div>
										<div class="medium-6 columns text-right">
											<div class="infoText"><?php echo getPositionName($company['position_id']); ?></div>
										</div>
									</div>
								</div>
								<div class="orderFormRow">
									<div class="row">
										<div class="medium-6 columns text-left">
											<div class="infoLabel">Утас</div>
										</div>
										<div class="medium-6 columns text-right">
											<div class="infoText"><?php echo $company['phone']; ?></div>
										</div>
									</div>
								</div>
								<div class="orderFormRow" style="border-bottom: none;">
									<div class="row">
										<div class="medium-6 columns text-left">
											<div class="infoLabel">И-мэйл</div>
										</div>
										<div class="medium-6 columns text-right">
											<div class="infoText"><?php echo $company['email']; ?></div>
										</div>
									</div>
								</div>
								<div class="orderFormRow" style="border-bottom: none;">
									<div class="row">
										<div class="medium-8 medium-centered columns">
											<a class="logOutBtn" href="order.php?action=logout">Системээс гарах</a>
										</div>
									</div>
								</div>
							</div>
						</div>
					</form>
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