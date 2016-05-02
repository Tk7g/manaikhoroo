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
			<div class="row">
				<div class="medium-4 columns">
				<?php 
				switch ( $order['status'] ) {
					case 0:
				?>
					<div class="orderInfoBlock">
						<div class="orderInfoBlockTitle">
							Захиалгын явц
						</div>
						<div class="orderInfoBlockDetail">
							<div class="orderInfoBlockRow text-justify" style="border-top: none;">
								<span class="orderInfoFullStatusIcon" style="background: <?php echo getStatusColor($order['status']); ?>;"></span> - Захиалга шинээр орж ирлээ. Одоогоор ахлах менежерийн гэрээний дугаар олголт болон үнийн тооцооллыг хүлээж байна.
							</div>
						</div>
						<div class="orderInfoBlockTitle">
							Гэрээний мэдээлэл
						</div>
						<div class="orderInfoBlockDetail">
							<form action="order.php?action=agreementSubmit" method="post" enctype="multipart/form-data">
							<input type="hidden" name="id" value="<?php echo $_GET['id']; ?>" id="ID" />
							<div class="orderInfoBlockRow" style="border-bottom: none; border-top: none;">
								<div class="row">
									<div class="medium-12 columns">
										<input type="hidden" name="company_id" value="<?php echo $order['company_id'];  ?>" />
										<label>Гэрээний дугаар</label>
        								<input type="text" name="agreement_id" required="required" />
        								<label>Гэрээний нийт дүн (м<sup>3</sup>)</label>
        								<input type="text" name="total_size" id="TotalSize" value="0" required="required"/>
        								<label>Бүтээгдэхүүний үнэ (1м<sup>3</sup>-ын үнэ ₮)</label>
        								<input type="text" name="unit_price" id="UnitPrice" value="0" required="required"/>
        								<label>Нийт төлбөр (₮. бэлнээр)</label>
        								<input type="text" id="TotalPrice" name="total_price" value="0" required="required"/>
        								<label>Бартерын дүн (₮)</label>
										<input type="text" id="Barter" name="barter" value="0" />
        								<label>Gift</label>
        								<input type="text" id="Gift" name="gift" value="0" required="required"/>
        								<label>Гэрээ (файл)</label>
        								<input type="file" required="required" name="agreement_file">
        								<div class="text-center">
        									<button type="submit" name="saveOrder" class="infoFormSubmit">Гэрээний дугаар олгох</button>
        								</div>
									</div>
								</div>
							</div>
							</form>
						</div>

<script>
function calTotalPrice() {
	var totalSize = $( "#TotalSize" ).val();
	var unitPrice = $("#UnitPrice").val();
	var totalPrice = totalSize * unitPrice;
	$("#TotalPrice").val(totalPrice);
}

function calRemain() {
	var totalPrice = $( "#TotalPrice" ).val();
	var barter = $( "#Barter" ).val();
	var remainPayment = totalPrice - barter;
	$("#TotalPrice").val(remainPayment);
}

$("#Barter").change(function(){
	calTotalPrice();
	calRemain();
});

$("#UnitPrice").change(function() {
  calTotalPrice();
  calRemain();
});

$("#TotalSize").change(function() {
  calTotalPrice();
  calRemain();
});

</script>
					</div>
				<?php
					break;
					case 7:
				?>
					<div class="orderInfoBlock">
						<div class="orderInfoBlockTitle">
							Захиалгын явц
						</div>
						<div class="orderInfoBlockDetail">
							<div class="orderInfoBlockRow text-justify" style="border-top: none;">
								<span class="orderInfoFullStatusIcon" style="background: <?php echo getStatusColor($order['status']); ?>;"></span> - Захиалгын төлбөрийн мэдээллийг оруулан захирал руу илгээхийг хүлээж байна.
							</div>
						</div>
						<div class="orderInfoBlockTitle">
							Гэрээний мэдээлэл
						</div>
						<div class="orderInfoBlockDetail">
							<div class="orderInfoBlockRow" style="border-top: none;">
								<div class="row">
									<div class="medium-6 columns">
										Гэрээний дугаар
									</div>
									<div class="medium-6 columns text-right">
										<?php echo $agreementInfo['title']; ?>
									</div>
								</div>
							</div>
							<div class="orderInfoBlockRow">
								<div class="row">
									<div class="medium-6 columns">
										Гэрээний нийт дүн (м<sup>3</sup>)
									</div>
									<div class="medium-6 columns text-right">
										<?php echo $agreementInfo['total_size'].' м'; ?><sup>3</sup>
									</div>
								</div>
							</div>
							<div class="orderInfoBlockRow">
								<div class="progress small-12 factory radius round">
  									<span class="meter" style="width: <?php echo ($totalProducedSize*100)/$agreementInfo['total_size']; ?>%">
  										<div class="factoryProgress" <?php if($totalProducedSize == 0 || $totalProducedSize == NULL) { echo 'style="color: #000;"'; } ?>>
  											<?php echo round(($totalProducedSize*100)/$agreementInfo['total_size']); ?>%
  											<?php if($totalProducedSize != 0) { echo ' ('.$totalProducedSize.' м<sup>3</sup>)'; } ?>
  										</div>
  									</span>
								</div>
							</div>
							<div class="orderInfoBlockRow">
								<div class="row">
									<div class="medium-6 columns">
										Бүтээгдэхүүний үнэ (1м<sup>3</sup>-ын үнэ ₮)
									</div>
									<div class="medium-6 columns text-right">
										<?php echo $agreementInfo['unit_price']; ?> ₮
									</div>
								</div>
							</div>
							<div class="orderInfoBlockRow">
								<div class="row">
									<div class="medium-6 columns">
										Гэрээний нийт дүн (₮)
									</div>
									<div class="medium-6 columns text-right">
										<?php echo $agreementInfo['total_price']+$agreementInfo['barter']; ?> ₮
									</div>
								</div>
							</div>
							<div class="orderInfoBlockRow">
								<div class="row">
									<div class="medium-6 columns">
										Төлбөр (₮. бэлнээр)
									</div>
									<div class="medium-6 columns text-right">
										<?php echo $agreementInfo['total_price']; ?> ₮
									</div>
								</div>
							</div>
							<div class="orderInfoBlockRow">
								<div class="row">
									<div class="medium-6 columns">
										Бартерын дүн (₮)
									</div>
									<div class="medium-6 columns text-right">
										<?php echo $agreementInfo['barter']; ?> ₮
									</div>
								</div>
							</div>
							<div class="orderInfoBlockRow">
								<div class="row">
									<div class="medium-6 columns">
										Gift
									</div>
									<div class="medium-6 columns text-right">
										<?php echo $agreementInfo['gift']; ?> ₮
									</div>
								</div>
							</div>
							<div class="orderInfoBlockRow">
								<div class="row">
									<div class="medium-6 columns">
										Гэрээний файл
									</div>
									<div class="medium-6 columns text-right">
										<a href="<?php echo MAIN_FOLDER.'/agreements/'.$agreementInfo['file']; ?>" target="_blank" class="fileDownload">Татах</a>
									</div>
								</div>
							</div>
						</div>
						<div class="orderInfoBlockTitle">
							Төлбөрийн мэдээлэл
						</div>
						<div class="orderInfoBlockDetail">
							<form action="order.php?action=paymentSubmit" method="post">
							<input type="hidden" name="id" value="<?php echo $_GET['id']; ?>" id="ID" />
							<div class="orderInfoBlockRow" style="border-bottom: none; border-top: none;">
								<div class="row">
									<div class="medium-12 columns">
										<label>1м<sup>3</sup>-ын үнэ</label>
        								<input type="text" name="price" id="Price" required="required" value="<?php echo $agreementInfo['unit_price']; ?>" />
        								<label>Захиалгын нийт дүн (₮)</label>
        								<input type="text" name="total_price" id="TotalPrice" value="<?php echo $agreementInfo['unit_price']*$order['size1']; ?>" required="required"/>
        								<label>Төлсөн (₮)</label>
        								<input type="text" name="payment1" id="Payment1" value="0" required="required"/>
        								<label>Төлбөрийн үлдэгдэл (₮)</label>
        								<input type="text" name="payment2" id="Payment2" value="<?php echo $agreementInfo['unit_price']*$order['size1']; ?>" required="required"/>
        								<label>Бартерын дүн (₮)</label>
										<input type="text" id="Barter" name="barter" value="0" />
        								<div class="text-center">
        									<button type="submit" name="saveOrder" class="infoFormSubmit">Төлбөрийн мэдээлэл хадгалах</button>
        								</div>
									</div>
								</div>
							</div>
							</form>
						</div>

<script>
function calTotalPrice() {
	var totalSize = <?php echo $order['size1']; ?>;
	var unitPrice = $("#Price").val();
	var barter = $( "#Barter" ).val();
	var paid = $("#Payment1").val();
	var remain = $("#Payment2").val();
	var totalPrice = totalSize * unitPrice;
	var totalRemain = totalPrice - paid - barter;
	$("#TotalPrice").val(totalPrice);
	$("#Payment2").val(totalRemain);
}


$("#Price").change(function(){
	calTotalPrice();
});
$("#TotalPrice").change(function() {
  calTotalPrice();
});
$("#Payment1").change(function() {
  calTotalPrice();
});
$("#Payment2").change(function() {
  calTotalPrice();
});
$("#Barter").change(function() {
  calTotalPrice();
});

</script>
					</div>
				<?php
					break;
					case 1:
				?>
					<div class="orderInfoBlock">
						<div class="orderInfoBlockTitle">
							Захиалгын явц
						</div>
						<div class="orderInfoBlockDetail">
							<div class="orderInfoBlockRow text-justify" style="border-top: none;">
								<span class="orderInfoFullStatusIcon" style="background: <?php echo getStatusColor($order['status']); ?>;"></span> - Захиалгад гэрээний дугаар, бүтээгдэхүүний үнийг шалган, гэрээг хавсарган захирал руу илгээсэн байна. Одоогоор захирлын зөвшөөрлийг хүлээж байна.
							</div>
							<div class="orderInfoBlockRow" style="border-top: none;">
								<div class="row">
									<div class="medium-6 columns">
										Нэмэлт тайлбар
									</div>
									<div class="medium-6 columns text-right">
										<?php echo $order['director_desc']; ?>
									</div>
								</div>
							</div>
						</div>
						<div class="orderInfoBlockTitle">
							Гэрээний мэдээлэл
						</div>
						<div class="orderInfoBlockDetail">
							<div class="orderInfoBlockRow" style="border-top: none;">
								<div class="row">
									<div class="medium-6 columns">
										Гэрээний дугаар
									</div>
									<div class="medium-6 columns text-right">
										<?php echo $agreementInfo['title']; ?>
									</div>
								</div>
							</div>
							<div class="orderInfoBlockRow">
								<div class="row">
									<div class="medium-6 columns">
										Гэрээний нийт дүн (м<sup>3</sup>)
									</div>
									<div class="medium-6 columns text-right">
										<?php echo $agreementInfo['total_size'].' м'; ?><sup>3</sup>
									</div>
								</div>
							</div>
							<div class="orderInfoBlockRow">
								<div class="progress small-12 factory radius round">
  									<span class="meter" style="width: <?php echo ($totalProducedSize*100)/$agreementInfo['total_size']; ?>%">
  										<div class="factoryProgress" <?php if($totalProducedSize == 0 || $totalProducedSize == NULL) { echo 'style="color: #000;"'; } ?>>
  											<?php echo round(($totalProducedSize*100)/$agreementInfo['total_size']); ?>%
  											<?php if($totalProducedSize != 0) { echo ' ('.$totalProducedSize.' м<sup>3</sup>)'; } ?>
  										</div>
  									</span>
								</div>
							</div>
							<div class="orderInfoBlockRow">
								<div class="row">
									<div class="medium-6 columns">
										Бүтээгдэхүүний үнэ (1м<sup>3</sup>-ын үнэ ₮)
									</div>
									<div class="medium-6 columns text-right">
										<?php echo $agreementInfo['unit_price']; ?> ₮
									</div>
								</div>
							</div>
							<div class="orderInfoBlockRow">
								<div class="row">
									<div class="medium-6 columns">
										Гэрээний нийт дүн (₮)
									</div>
									<div class="medium-6 columns text-right">
										<?php echo $agreementInfo['total_price']+$agreementInfo['barter']; ?> ₮
									</div>
								</div>
							</div>
							<div class="orderInfoBlockRow">
								<div class="row">
									<div class="medium-6 columns">
										Төлбөр (₮. бэлнээр)
									</div>
									<div class="medium-6 columns text-right">
										<?php echo $agreementInfo['total_price']; ?> ₮
									</div>
								</div>
							</div>
							<div class="orderInfoBlockRow">
								<div class="row">
									<div class="medium-6 columns">
										Бартерын дүн (₮)
									</div>
									<div class="medium-6 columns text-right">
										<?php echo $agreementInfo['barter']; ?> ₮
									</div>
								</div>
							</div>
							<div class="orderInfoBlockRow">
								<div class="row">
									<div class="medium-6 columns">
										Gift
									</div>
									<div class="medium-6 columns text-right">
										<?php echo $agreementInfo['gift']; ?> ₮
									</div>
								</div>
							</div>
							<div class="orderInfoBlockRow">
								<div class="row">
									<div class="medium-6 columns">
										Гэрээний файл
									</div>
									<div class="medium-6 columns text-right">
										<a href="<?php echo MAIN_FOLDER.'/agreements/'.$agreementInfo['file']; ?>" target="_blank" class="fileDownload">Татах</a>
									</div>
								</div>
							</div>
						</div>
						<div class="orderInfoBlockTitle">
							Төлбөрийн мэдээлэл
						</div>
						<div class="orderInfoBlockDetail">
							<form action="order.php?action=paymentChange" method="post">
							<input type="hidden" name="id" value="<?php echo $_GET['id']; ?>" id="ID" />
							<div class="orderInfoBlockRow" style="border-bottom: none; border-top: none;">
								<div class="row">
									<div class="medium-12 columns">
										<label>1м<sup>3</sup>-ын үнэ</label>
        								<input type="text" name="price" id="Price" required="required" value="<?php echo $order['price']; ?>" />
        								<label>Захиалгын нийт дүн (₮)</label>
        								<input type="text" name="total_price" id="TotalPrice" value="<?php echo $order['total_price']; ?>" required="required"/>
        								<label>Төлсөн (₮)</label>
        								<input type="text" name="payment1" id="Payment1" value="<?php echo $order['payment1']; ?>" required="required"/>
        								<label>Төлбөрийн үлдэгдэл (₮)</label>
        								<input type="text" name="payment2" id="Payment2" value="<?php echo $order['payment2']; ?>" required="required"/>
        								<label>Бартерын дүн (₮)</label>
										<input type="text" id="Barter" name="barter" value="<?php echo $order['barter']; ?>" />
        								<div class="text-center">
        									<button type="submit" name="saveOrder" class="infoFormSubmit">Төлбөрийн мэдээлэл хадгалах</button>
        								</div>
									</div>
								</div>
							</div>
							</form>
						</div>
					</div>
				<?php
					break;
					case 2:
				?>
					<div class="orderInfoBlock">
						<div class="orderInfoBlockTitle">
							Захиалгын явц
						</div>
						<div class="orderInfoBlockDetail">
							<div class="orderInfoBlockRow text-justify" style="border-top: none;">
								<span class="orderInfoFullStatusIcon" style="background: <?php echo getStatusColor($order['status']); ?>;"></span> - Захиалгын гэрээг зөвшөөрсөн байна. Төлбөрийг хүлээн авч, үйлдвэр рүү шилжүүлэхийг хүлээж байна.
							</div>
							<div class="orderInfoBlockRow" style="border-top: none;">
								<div class="row">
									<div class="medium-6 columns">
										Нэмэлт тайлбар
									</div>
									<div class="medium-6 columns text-right">
										<?php echo $order['director_desc']; ?>
									</div>
								</div>
							</div>
						</div>
						<div class="orderInfoBlockTitle">
							Гэрээний мэдээлэл
						</div>
						<div class="orderInfoBlockDetail">
							<div class="orderInfoBlockRow" style="border-top: none;">
								<div class="row">
									<div class="medium-6 columns">
										Гэрээний дугаар
									</div>
									<div class="medium-6 columns text-right">
										<?php echo $agreementInfo['title']; ?>
									</div>
								</div>
							</div>
							<div class="orderInfoBlockRow">
								<div class="row">
									<div class="medium-6 columns">
										Гэрээний нийт дүн (м<sup>3</sup>)
									</div>
									<div class="medium-6 columns text-right">
										<?php echo $agreementInfo['total_size'].' м'; ?><sup>3</sup>
									</div>
								</div>
							</div>
							<div class="orderInfoBlockRow">
								<div class="progress small-12 factory radius round">
  									<span class="meter" style="width: <?php echo ($totalProducedSize*100)/$agreementInfo['total_size']; ?>%">
  										<div class="factoryProgress" <?php if($totalProducedSize == 0 || $totalProducedSize == NULL) { echo 'style="color: #000;"'; } ?>>
  											<?php echo round(($totalProducedSize*100)/$agreementInfo['total_size']); ?>%
  											<?php if($totalProducedSize != 0) { echo ' ('.$totalProducedSize.' м<sup>3</sup>)'; } ?>
  										</div>
  									</span>
								</div>
							</div>
							<div class="orderInfoBlockRow">
								<div class="row">
									<div class="medium-6 columns">
										Бүтээгдэхүүний үнэ (1м<sup>3</sup>-ын үнэ ₮)
									</div>
									<div class="medium-6 columns text-right">
										<?php echo $agreementInfo['unit_price']; ?> ₮
									</div>
								</div>
							</div>
							<div class="orderInfoBlockRow">
								<div class="row">
									<div class="medium-6 columns">
										Гэрээний нийт дүн (₮)
									</div>
									<div class="medium-6 columns text-right">
										<?php echo $agreementInfo['total_price']+$agreementInfo['barter']; ?> ₮
									</div>
								</div>
							</div>
							<div class="orderInfoBlockRow">
								<div class="row">
									<div class="medium-6 columns">
										Төлбөр (₮. бэлнээр)
									</div>
									<div class="medium-6 columns text-right">
										<?php echo $agreementInfo['total_price']; ?> ₮
									</div>
								</div>
							</div>
							<div class="orderInfoBlockRow">
								<div class="row">
									<div class="medium-6 columns">
										Бартерын дүн (₮)
									</div>
									<div class="medium-6 columns text-right">
										<?php echo $agreementInfo['barter']; ?> ₮
									</div>
								</div>
							</div>
							<div class="orderInfoBlockRow">
								<div class="row">
									<div class="medium-6 columns">
										Gift
									</div>
									<div class="medium-6 columns text-right">
										<?php echo $agreementInfo['gift']; ?> ₮
									</div>
								</div>
							</div>
							<div class="orderInfoBlockRow">
								<div class="row">
									<div class="medium-6 columns">
										Гэрээний файл
									</div>
									<div class="medium-6 columns text-right">
										<a href="<?php echo MAIN_FOLDER.'/agreements/'.$agreementInfo['file']; ?>" target="_blank" class="fileDownload">Татах</a>
									</div>
								</div>
							</div>
						</div>
						<div class="orderInfoBlockTitle">
							Төлбөрийн мэдээлэл
						</div>
						<div class="orderInfoBlockDetail">
							<form action="order.php?action=paymentChange" method="post">
							<input type="hidden" name="id" value="<?php echo $_GET['id']; ?>" id="ID" />
							<div class="orderInfoBlockRow" style="border-bottom: none; border-top: none;">
								<div class="row">
									<div class="medium-12 columns">
										<label>1м<sup>3</sup>-ын үнэ</label>
        								<input type="text" name="price" id="Price" required="required" value="<?php echo $order['price']; ?>" />
        								<label>Захиалгын нийт дүн (₮)</label>
        								<input type="text" name="total_price" id="TotalPrice" value="<?php echo $order['total_price']; ?>" required="required"/>
        								<label>Төлсөн (₮)</label>
        								<input type="text" name="payment1" id="Payment1" value="<?php echo $order['payment1']; ?>" required="required"/>
        								<label>Төлбөрийн үлдэгдэл (₮)</label>
        								<input type="text" name="payment2" id="Payment2" value="<?php echo $order['payment2']; ?>" required="required"/>
        								<label>Бартерын дүн (₮)</label>
										<input type="text" id="Barter" name="barter" value="<?php echo $order['barter']; ?>" />
        								<div class="text-center">
        									<button type="submit" name="saveOrder" class="infoFormSubmit">Төлбөрийн мэдээлэл хадгалах</button>
        								</div>
									</div>
								</div>
							</div>
							</form>
						</div>
<script>
function calTotalPrice() {
	var totalSize = <?php echo $order['size1']; ?>;
	var unitPrice = $("#Price").val();
	var barter = $( "#Barter" ).val();
	var paid = $("#Payment1").val();
	var remain = $("#Payment2").val();
	var totalPrice = totalSize * unitPrice;
	var totalRemain = totalPrice - paid - barter;
	$("#TotalPrice").val(totalPrice);
	$("#Payment2").val(totalRemain);
}


$("#Price").change(function(){
	calTotalPrice();
});
$("#TotalPrice").change(function() {
  calTotalPrice();
});
$("#Payment1").change(function() {
  calTotalPrice();
});
$("#Payment2").change(function() {
  calTotalPrice();
});
$("#Barter").change(function() {
  calTotalPrice();
});

</script>
						<div class="orderInfoBlockTitle">
							Үйлдвэр рүү шилжүүлэх
						</div>
						<div class="orderInfoBlockDetail">
							<div class="orderInfoBlockRow" style="border-top: none; border-bottom: none;">
								<div class="row">
									<div class="medium-6 medium-centered columns">
										<a href="order.php?action=sendToFactory&id=<?php echo $order['id']; ?>" class="button tiny expand yellowBtn" onclick="return confirm('Захиалгыг үйлдвэр рүү шилжүүлэх үү?');">Үйлдвэр рүү шилжүүлэх</a>
									</div>
								</div>
							</div>
						</div>
					</div>
				<?php
					break;
					case 3:
				?>
					<div class="orderInfoBlock">
						<div class="orderInfoBlockTitle">
							Захиалгын явц
						</div>
						<div class="orderInfoBlockDetail">
							<div class="orderInfoBlockRow text-justify" style="border-top: none;">
								<span class="orderInfoFullStatusIcon" style="background: <?php echo getStatusColor($order['status']); ?>;"></span> - Захиалгаас татгалзсан байна.
							</div>
							<div class="orderInfoBlockRow" style="border-top: none;">
								<div class="row">
									<div class="medium-6 columns">
										Нэмэлт тайлбар
									</div>
									<div class="medium-6 columns text-right">
										<?php echo $order['director_desc']; ?>
									</div>
								</div>
							</div>
						</div>
						<div class="orderInfoBlockTitle">
							Гэрээний мэдээлэл
						</div>
						<div class="orderInfoBlockDetail">
							<div class="orderInfoBlockRow" style="border-top: none;">
								<div class="row">
									<div class="medium-6 columns">
										Гэрээний дугаар
									</div>
									<div class="medium-6 columns text-right">
										<?php echo $agreementInfo['title']; ?>
									</div>
								</div>
							</div>
							<div class="orderInfoBlockRow">
								<div class="row">
									<div class="medium-6 columns">
										Гэрээний нийт дүн (м<sup>3</sup>)
									</div>
									<div class="medium-6 columns text-right">
										<?php echo $agreementInfo['total_size'].' м'; ?><sup>3</sup>
									</div>
								</div>
							</div>
							<div class="orderInfoBlockRow">
								<div class="progress small-12 factory radius round">
  									<span class="meter" style="width: <?php echo ($totalProducedSize*100)/$agreementInfo['total_size']; ?>%">
  										<div class="factoryProgress" <?php if($totalProducedSize == 0 || $totalProducedSize == NULL) { echo 'style="color: #000;"'; } ?>>
  											<?php echo round(($totalProducedSize*100)/$agreementInfo['total_size']); ?>%
  											<?php if($totalProducedSize != 0) { echo ' ('.$totalProducedSize.' м<sup>3</sup>)'; } ?>
  										</div>
  									</span>
								</div>
							</div>
							<div class="orderInfoBlockRow">
								<div class="row">
									<div class="medium-6 columns">
										Бүтээгдэхүүний үнэ (1м<sup>3</sup>-ын үнэ ₮)
									</div>
									<div class="medium-6 columns text-right">
										<?php echo $agreementInfo['unit_price']; ?> ₮
									</div>
								</div>
							</div>
							<div class="orderInfoBlockRow">
								<div class="row">
									<div class="medium-6 columns">
										Гэрээний нийт дүн (₮)
									</div>
									<div class="medium-6 columns text-right">
										<?php echo $agreementInfo['total_price']+$agreementInfo['barter']; ?> ₮
									</div>
								</div>
							</div>
							<div class="orderInfoBlockRow">
								<div class="row">
									<div class="medium-6 columns">
										Төлбөр (₮. бэлнээр)
									</div>
									<div class="medium-6 columns text-right">
										<?php echo $agreementInfo['total_price']; ?> ₮
									</div>
								</div>
							</div>
							<div class="orderInfoBlockRow">
								<div class="row">
									<div class="medium-6 columns">
										Бартерын дүн (₮)
									</div>
									<div class="medium-6 columns text-right">
										<?php echo $agreementInfo['barter']; ?> ₮
									</div>
								</div>
							</div>
							<div class="orderInfoBlockRow">
								<div class="row">
									<div class="medium-6 columns">
										Gift
									</div>
									<div class="medium-6 columns text-right">
										<?php echo $agreementInfo['gift']; ?> ₮
									</div>
								</div>
							</div>
							<div class="orderInfoBlockRow">
								<div class="row">
									<div class="medium-6 columns">
										Гэрээний файл
									</div>
									<div class="medium-6 columns text-right">
										<a href="<?php echo MAIN_FOLDER.'/agreements/'.$agreementInfo['file']; ?>" target="_blank" class="fileDownload">Татах</a>
									</div>
								</div>
							</div>
						</div>
						<div class="orderInfoBlockTitle">
							Төлбөрийн мэдээлэл
						</div>
						<div class="orderInfoBlockDetail">
							<form action="order.php?action=paymentChange" method="post">
							<input type="hidden" name="id" value="<?php echo $_GET['id']; ?>" id="ID" />
							<div class="orderInfoBlockRow" style="border-bottom: none; border-top: none;">
								<div class="row">
									<div class="medium-12 columns">
										<label>1м<sup>3</sup>-ын үнэ</label>
        								<input type="text" name="price" id="Price" required="required" value="<?php echo $order['price']; ?>" />
        								<label>Захиалгын нийт дүн (₮)</label>
        								<input type="text" name="total_price" id="TotalPrice" value="<?php echo $order['total_price']; ?>" required="required"/>
        								<label>Төлсөн (₮)</label>
        								<input type="text" name="payment1" id="Payment1" value="<?php echo $order['payment1']; ?>" required="required"/>
        								<label>Төлбөрийн үлдэгдэл (₮)</label>
        								<input type="text" name="payment2" id="Payment2" value="<?php echo $order['payment2']; ?>" required="required"/>
        								<label>Бартерын дүн (₮)</label>
										<input type="text" id="Barter" name="barter" value="<?php echo $order['barter']; ?>" />
        								<div class="text-center">
        									<button type="submit" name="saveOrder" class="infoFormSubmit">Төлбөрийн мэдээлэл хадгалах</button>
        								</div>
									</div>
								</div>
							</div>
							</form>
						</div>
<script>
function calTotalPrice() {
	var totalSize = <?php echo $order['size1']; ?>;
	var unitPrice = $("#Price").val();
	var barter = $( "#Barter" ).val();
	var paid = $("#Payment1").val();
	var remain = $("#Payment2").val();
	var totalPrice = totalSize * unitPrice;
	var totalRemain = totalPrice - paid - barter;
	$("#TotalPrice").val(totalPrice);
	$("#Payment2").val(totalRemain);
}


$("#Price").change(function(){
	calTotalPrice();
});
$("#TotalPrice").change(function() {
  calTotalPrice();
});
$("#Payment1").change(function() {
  calTotalPrice();
});
$("#Payment2").change(function() {
  calTotalPrice();
});
$("#Barter").change(function() {
  calTotalPrice();
});

</script>
					</div>
				<?php
					break;
					case 4:
				?>
					<div class="orderInfoBlock">
						<div class="orderInfoBlockTitle">
							Захиалгын явц
						</div>
						<div class="orderInfoBlockDetail">
							<div class="orderInfoBlockRow text-justify" style="border-top: none;">
								<span class="orderInfoFullStatusIcon" style="background: <?php echo getStatusColor($order['status']); ?>;"></span> - Компанитай гэрээ байгуулж, төлбөрийг хүлээн аван үйлдвэр рүү шилжүүлсэн байна. Үйлдвэрийн менежер дээр захиалга очсон байна.
							</div>
							<div class="orderInfoBlockRow" style="border-top: none;">
								<div class="row">
									<div class="medium-6 columns">
										Нэмэлт тайлбар
									</div>
									<div class="medium-6 columns text-right">
										<?php echo $order['director_desc']; ?>
									</div>
								</div>
							</div>
						</div>
						<div class="orderInfoBlockTitle">
							Гэрээний мэдээлэл
						</div>
						<div class="orderInfoBlockDetail">
							<div class="orderInfoBlockRow" style="border-top: none;">
								<div class="row">
									<div class="medium-6 columns">
										Гэрээний дугаар
									</div>
									<div class="medium-6 columns text-right">
										<?php echo $agreementInfo['title']; ?>
									</div>
								</div>
							</div>
							<div class="orderInfoBlockRow">
								<div class="row">
									<div class="medium-6 columns">
										Гэрээний нийт дүн (м<sup>3</sup>)
									</div>
									<div class="medium-6 columns text-right">
										<?php echo $agreementInfo['total_size'].' м'; ?><sup>3</sup>
									</div>
								</div>
							</div>
							<div class="orderInfoBlockRow">
								<div class="progress small-12 factory radius round">
  									<span class="meter" style="width: <?php echo ($totalProducedSize*100)/$agreementInfo['total_size']; ?>%">
  										<div class="factoryProgress" <?php if($totalProducedSize == 0 || $totalProducedSize == NULL) { echo 'style="color: #000;"'; } ?>>
  											<?php echo round(($totalProducedSize*100)/$agreementInfo['total_size']); ?>%
  											<?php if($totalProducedSize != 0) { echo ' ('.$totalProducedSize.' м<sup>3</sup>)'; } ?>
  										</div>
  									</span>
								</div>
							</div>
							<div class="orderInfoBlockRow">
								<div class="row">
									<div class="medium-6 columns">
										Бүтээгдэхүүний үнэ (1м<sup>3</sup>-ын үнэ ₮)
									</div>
									<div class="medium-6 columns text-right">
										<?php echo $agreementInfo['unit_price']; ?> ₮
									</div>
								</div>
							</div>
							<div class="orderInfoBlockRow">
								<div class="row">
									<div class="medium-6 columns">
										Гэрээний нийт дүн (₮)
									</div>
									<div class="medium-6 columns text-right">
										<?php echo $agreementInfo['total_price']+$agreementInfo['barter']; ?> ₮
									</div>
								</div>
							</div>
							<div class="orderInfoBlockRow">
								<div class="row">
									<div class="medium-6 columns">
										Төлбөр (₮. бэлнээр)
									</div>
									<div class="medium-6 columns text-right">
										<?php echo $agreementInfo['total_price']; ?> ₮
									</div>
								</div>
							</div>
							<div class="orderInfoBlockRow">
								<div class="row">
									<div class="medium-6 columns">
										Бартерын дүн (₮)
									</div>
									<div class="medium-6 columns text-right">
										<?php echo $agreementInfo['barter']; ?> ₮
									</div>
								</div>
							</div>
							<div class="orderInfoBlockRow">
								<div class="row">
									<div class="medium-6 columns">
										Gift
									</div>
									<div class="medium-6 columns text-right">
										<?php echo $agreementInfo['gift']; ?> ₮
									</div>
								</div>
							</div>
							<div class="orderInfoBlockRow">
								<div class="row">
									<div class="medium-6 columns">
										Гэрээний файл
									</div>
									<div class="medium-6 columns text-right">
										<a href="<?php echo MAIN_FOLDER.'/agreements/'.$agreementInfo['file']; ?>" target="_blank" class="fileDownload">Татах</a>
									</div>
								</div>
							</div>
						</div>
						<div class="orderInfoBlockTitle">
							Төлбөрийн мэдээлэл
						</div>
						<div class="orderInfoBlockDetail">
							<form action="order.php?action=paymentChange" method="post">
							<input type="hidden" name="id" value="<?php echo $_GET['id']; ?>" id="ID" />
							<div class="orderInfoBlockRow" style="border-bottom: none; border-top: none;">
								<div class="row">
									<div class="medium-12 columns">
										<label>1м<sup>3</sup>-ын үнэ</label>
        								<input type="text" name="price" id="Price" required="required" value="<?php echo $order['price']; ?>" />
        								<label>Захиалгын нийт дүн (₮)</label>
        								<input type="text" name="total_price" id="TotalPrice" value="<?php echo $order['total_price']; ?>" required="required"/>
        								<label>Төлсөн (₮)</label>
        								<input type="text" name="payment1" id="Payment1" value="<?php echo $order['payment1']; ?>" required="required"/>
        								<label>Төлбөрийн үлдэгдэл (₮)</label>
        								<input type="text" name="payment2" id="Payment2" value="<?php echo $order['payment2']; ?>" required="required"/>
        								<label>Бартерын дүн (₮)</label>
										<input type="text" id="Barter" name="barter" value="<?php echo $order['barter']; ?>" />
        								<div class="text-center">
        									<button type="submit" name="saveOrder" class="infoFormSubmit">Төлбөрийн мэдээлэл хадгалах</button>
        								</div>
									</div>
								</div>
							</div>
							</form>
						</div>
<script>
function calTotalPrice() {
	var totalSize = <?php echo $order['size1']; ?>;
	var unitPrice = $("#Price").val();
	var barter = $( "#Barter" ).val();
	var paid = $("#Payment1").val();
	var remain = $("#Payment2").val();
	var totalPrice = totalSize * unitPrice;
	var totalRemain = totalPrice - paid - barter;
	$("#TotalPrice").val(totalPrice);
	$("#Payment2").val(totalRemain);
}


$("#Price").change(function(){
	calTotalPrice();
});
$("#TotalPrice").change(function() {
  calTotalPrice();
});
$("#Payment1").change(function() {
  calTotalPrice();
});
$("#Payment2").change(function() {
  calTotalPrice();
});
$("#Barter").change(function() {
  calTotalPrice();
});

</script>
					</div>
				<?php
					break;
					case 5:
				?>
					<div class="orderInfoBlock">
						<div class="orderInfoBlockTitle">
							Захиалгын явц
						</div>
						<div class="orderInfoBlockDetail">
							<div class="orderInfoBlockRow text-justify" style="border-top: none;">
								<span class="orderInfoFullStatusIcon" style="background: <?php echo getStatusColor($order['status']); ?>;"></span> - Захиалгыг үйлдвэрлэж байна.
							</div>
							<div class="orderInfoBlockRow" style="border-bottom: none;">
								<div class="progress small-12 factory radius round">
  									<span class="meter" style="width: <?php echo ($order['produced']*100)/$order['size1']; ?>%">
  										<div class="factoryProgress" <?php if($order['factory_progress'] == 0 || $order['factory_progress'] == NULL) { echo 'style="color: #000;"'; } ?>>
  											<?php echo round(($order['produced']*100)/$order['size1']); ?>%
  											<?php if($order['produced'] != 0) { echo ' ('.$order['produced'].' м<sup>3</sup>)'; } ?>
  										</div>
  									</span>
								</div>
								<?php if($order['factory_desc'] != NULL) { ?>
								<div class="orderInfoFullProcedure">
								<?php echo 'Тайлбар: '.$order['factory_desc']; ?>
								</div>
								<?php } ?>
							</div>
							<div class="orderInfoBlockRow" style="border-top: none;">
								<div class="row">
									<div class="medium-5 columns">
										Захирлын тайлбар
									</div>
									<div class="medium-7 columns text-right">
										<?php echo $order['director_desc']; ?>
									</div>
								</div>
							</div>
						</div>
						<div class="orderInfoBlockTitle">
							Гэрээний мэдээлэл
						</div>
						<div class="orderInfoBlockDetail">
							<div class="orderInfoBlockRow" style="border-top: none;">
								<div class="row">
									<div class="medium-6 columns">
										Гэрээний дугаар
									</div>
									<div class="medium-6 columns text-right">
										<?php echo $agreementInfo['title']; ?>
									</div>
								</div>
							</div>
							<div class="orderInfoBlockRow">
								<div class="row">
									<div class="medium-6 columns">
										Гэрээний нийт дүн (м<sup>3</sup>)
									</div>
									<div class="medium-6 columns text-right">
										<?php echo $agreementInfo['total_size'].' м'; ?><sup>3</sup>
									</div>
								</div>
							</div>
							<div class="orderInfoBlockRow">
								<div class="progress small-12 factory radius round">
  									<span class="meter" style="width: <?php echo ($totalProducedSize*100)/$agreementInfo['total_size']; ?>%">
  										<div class="factoryProgress" <?php if($totalProducedSize == 0 || $totalProducedSize == NULL) { echo 'style="color: #000;"'; } ?>>
  											<?php echo round(($totalProducedSize*100)/$agreementInfo['total_size']); ?>%
  											<?php if($totalProducedSize != 0) { echo ' ('.$totalProducedSize.' м<sup>3</sup>)'; } ?>
  										</div>
  									</span>
								</div>
							</div>
							<div class="orderInfoBlockRow">
								<div class="row">
									<div class="medium-6 columns">
										Бүтээгдэхүүний үнэ (1м<sup>3</sup>-ын үнэ ₮)
									</div>
									<div class="medium-6 columns text-right">
										<?php echo $agreementInfo['unit_price']; ?> ₮
									</div>
								</div>
							</div>
							<div class="orderInfoBlockRow">
								<div class="row">
									<div class="medium-6 columns">
										Гэрээний нийт дүн (₮)
									</div>
									<div class="medium-6 columns text-right">
										<?php echo $agreementInfo['total_price']+$agreementInfo['barter']; ?> ₮
									</div>
								</div>
							</div>
							<div class="orderInfoBlockRow">
								<div class="row">
									<div class="medium-6 columns">
										Төлбөр (₮. бэлнээр)
									</div>
									<div class="medium-6 columns text-right">
										<?php echo $agreementInfo['total_price']; ?> ₮
									</div>
								</div>
							</div>
							<div class="orderInfoBlockRow">
								<div class="row">
									<div class="medium-6 columns">
										Бартерын дүн (₮)
									</div>
									<div class="medium-6 columns text-right">
										<?php echo $agreementInfo['barter']; ?> ₮
									</div>
								</div>
							</div>
							<div class="orderInfoBlockRow">
								<div class="row">
									<div class="medium-6 columns">
										Gift
									</div>
									<div class="medium-6 columns text-right">
										<?php echo $agreementInfo['gift']; ?> ₮
									</div>
								</div>
							</div>
							<div class="orderInfoBlockRow">
								<div class="row">
									<div class="medium-6 columns">
										Гэрээний файл
									</div>
									<div class="medium-6 columns text-right">
										<a href="<?php echo MAIN_FOLDER.'/agreements/'.$agreementInfo['file']; ?>" target="_blank" class="fileDownload">Татах</a>
									</div>
								</div>
							</div>
						</div>
						<div class="orderInfoBlockTitle">
							Төлбөрийн мэдээлэл
						</div>
						<div class="orderInfoBlockDetail">
							<form action="order.php?action=paymentChange" method="post">
							<input type="hidden" name="id" value="<?php echo $_GET['id']; ?>" id="ID" />
							<div class="orderInfoBlockRow" style="border-bottom: none; border-top: none;">
								<div class="row">
									<div class="medium-12 columns">
										<label>1м<sup>3</sup>-ын үнэ</label>
        								<input type="text" name="price" id="Price" required="required" value="<?php echo $order['price']; ?>" />
        								<label>Захиалгын нийт дүн (₮)</label>
        								<input type="text" name="total_price" id="TotalPrice" value="<?php echo $order['total_price']; ?>" required="required"/>
        								<label>Төлсөн (₮)</label>
        								<input type="text" name="payment1" id="Payment1" value="<?php echo $order['payment1']; ?>" required="required"/>
        								<label>Төлбөрийн үлдэгдэл (₮)</label>
        								<input type="text" name="payment2" id="Payment2" value="<?php echo $order['payment2']; ?>" required="required"/>
        								<label>Бартерын дүн (₮)</label>
										<input type="text" id="Barter" name="barter" value="<?php echo $order['barter']; ?>" />
        								<div class="text-center">
        									<button type="submit" name="saveOrder" class="infoFormSubmit">Төлбөрийн мэдээлэл хадгалах</button>
        								</div>
									</div>
								</div>
							</div>
							</form>
						</div>
<script>
function calTotalPrice() {
	var totalSize = <?php echo $order['size1']; ?>;
	var unitPrice = $("#Price").val();
	var barter = $( "#Barter" ).val();
	var paid = $("#Payment1").val();
	var remain = $("#Payment2").val();
	var totalPrice = totalSize * unitPrice;
	var totalRemain = totalPrice - paid - barter;
	$("#TotalPrice").val(totalPrice);
	$("#Payment2").val(totalRemain);
}


$("#Price").change(function(){
	calTotalPrice();
});
$("#TotalPrice").change(function() {
  calTotalPrice();
});
$("#Payment1").change(function() {
  calTotalPrice();
});
$("#Payment2").change(function() {
  calTotalPrice();
});
$("#Barter").change(function() {
  calTotalPrice();
});

</script>
					</div>
				<?php
					break;
					case 6:
				?>
					<div class="orderInfoBlock">
						<div class="orderInfoBlockTitle">
							Захиалгын явц
						</div>
						<div class="orderInfoBlockDetail">
							<div class="orderInfoBlockRow text-justify" style="border-top: none;">
								<span class="orderInfoFullStatusIcon" style="background: <?php echo getStatusColor($order['status']); ?>;"></span> - Захиалгыг үйлдвэрлэж байна.
							</div>
							<div class="orderInfoBlockRow" style="border-bottom: none;">
								<div class="progress small-12 factory-finished radius round">
  									<span class="meter" style="width: <?php echo ($order['produced']*100)/$order['size1']; ?>%">
  										<div class="factoryProgress" <?php if($order['factory_progress'] == 0 || $order['factory_progress'] == NULL) { echo 'style="color: #000;"'; } ?>>
  											<?php echo round(($order['produced']*100)/$order['size1']); ?>%
  											<?php if($order['produced'] != 0) { echo ' ('.$order['produced'].' м<sup>3</sup>)'; } ?>
  										</div>
  									</span>
								</div>
								<?php if($order['factory_desc'] != NULL) { ?>
								<div class="orderInfoFullProcedure">
								<?php echo 'Тайлбар: '.$order['factory_desc']; ?>
								</div>
								<?php } ?>
							</div>
							<div class="orderInfoBlockRow" style="border-top: none;">
								<div class="row">
									<div class="medium-5 columns">
										Захирлын тайлбар
									</div>
									<div class="medium-7 columns text-right">
										<?php echo $order['director_desc']; ?>
									</div>
								</div>
							</div>
							<div class="orderInfoBlockRow">
								<div class="row">
									<div class="medium-6 columns">
										Захиалгын хэмжээ
									</div>
									<div class="medium-6 columns text-right">
										<?php echo $order['size1'].' - '.$order['size2']; ?> м<sup>3</sup>
									</div>
								</div>
							</div>
							<div class="orderInfoBlockRow" style="border-bottom: none;">
								<div class="row">
									<div class="medium-6 columns">
										Үйлдвэрлэсэн хэмжээ
									</div>
									<div class="medium-6 columns text-right">
										<?php echo $order['produced'] ?> м<sup>3</sup>
									</div>
								</div>
							</div>
						</div>
						<div class="orderInfoBlockTitle">
							Гэрээний мэдээлэл
						</div>
						<div class="orderInfoBlockDetail">
							<div class="orderInfoBlockRow" style="border-top: none;">
								<div class="row">
									<div class="medium-6 columns">
										Гэрээний дугаар
									</div>
									<div class="medium-6 columns text-right">
										<?php echo $agreementInfo['title']; ?>
									</div>
								</div>
							</div>
							<div class="orderInfoBlockRow">
								<div class="row">
									<div class="medium-6 columns">
										Гэрээний нийт дүн (м<sup>3</sup>)
									</div>
									<div class="medium-6 columns text-right">
										<?php echo $agreementInfo['total_size'].' м'; ?><sup>3</sup>
									</div>
								</div>
							</div>
							<div class="orderInfoBlockRow">
								<div class="progress small-12 factory radius round">
  									<span class="meter" style="width: <?php echo ($totalProducedSize*100)/$agreementInfo['total_size']; ?>%">
  										<div class="factoryProgress" <?php if($totalProducedSize == 0 || $totalProducedSize == NULL) { echo 'style="color: #000;"'; } ?>>
  											<?php echo round(($totalProducedSize*100)/$agreementInfo['total_size']); ?>%
  											<?php if($totalProducedSize != 0) { echo ' ('.$totalProducedSize.' м<sup>3</sup>)'; } ?>
  										</div>
  									</span>
								</div>
							</div>
							<div class="orderInfoBlockRow">
								<div class="row">
									<div class="medium-6 columns">
										Бүтээгдэхүүний үнэ (1м<sup>3</sup>-ын үнэ ₮)
									</div>
									<div class="medium-6 columns text-right">
										<?php echo $agreementInfo['unit_price']; ?> ₮
									</div>
								</div>
							</div>
							<div class="orderInfoBlockRow">
								<div class="row">
									<div class="medium-6 columns">
										Гэрээний нийт дүн (₮)
									</div>
									<div class="medium-6 columns text-right">
										<?php echo $agreementInfo['total_price']+$agreementInfo['barter']; ?> ₮
									</div>
								</div>
							</div>
							<div class="orderInfoBlockRow">
								<div class="row">
									<div class="medium-6 columns">
										Төлбөр (₮. бэлнээр)
									</div>
									<div class="medium-6 columns text-right">
										<?php echo $agreementInfo['total_price']; ?> ₮
									</div>
								</div>
							</div>
							<div class="orderInfoBlockRow">
								<div class="row">
									<div class="medium-6 columns">
										Бартерын дүн (₮)
									</div>
									<div class="medium-6 columns text-right">
										<?php echo $agreementInfo['barter']; ?> ₮
									</div>
								</div>
							</div>
							<div class="orderInfoBlockRow">
								<div class="row">
									<div class="medium-6 columns">
										Gift
									</div>
									<div class="medium-6 columns text-right">
										<?php echo $agreementInfo['gift']; ?> ₮
									</div>
								</div>
							</div>
							<div class="orderInfoBlockRow">
								<div class="row">
									<div class="medium-6 columns">
										Гэрээний файл
									</div>
									<div class="medium-6 columns text-right">
										<a href="<?php echo MAIN_FOLDER.'/agreements/'.$agreementInfo['file']; ?>" target="_blank" class="fileDownload">Татах</a>
									</div>
								</div>
							</div>
						</div>
						<div class="orderInfoBlockTitle">
							Төлбөрийн мэдээлэл
						</div>
						<div class="orderInfoBlockDetail">
							<form action="order.php?action=paymentChange" method="post">
							<input type="hidden" name="id" value="<?php echo $_GET['id']; ?>" id="ID" />
							<div class="orderInfoBlockRow" style="border-bottom: none; border-top: none;">
								<div class="row">
									<div class="medium-12 columns">
										<label>1м<sup>3</sup>-ын үнэ</label>
        								<input type="text" name="price" id="Price" required="required" value="<?php echo $order['price']; ?>" />
        								<label>Захиалгын нийт дүн (₮)</label>
        								<input type="text" name="total_price" id="TotalPrice" value="<?php echo $order['total_price']; ?>" required="required"/>
        								<label>Төлсөн (₮)</label>
        								<input type="text" name="payment1" id="Payment1" value="<?php echo $order['payment1']; ?>" required="required"/>
        								<label>Төлбөрийн үлдэгдэл (₮)</label>
        								<input type="text" name="payment2" id="Payment2" value="<?php echo $order['payment2']; ?>" required="required"/>
        								<label>Бартерын дүн (₮)</label>
										<input type="text" id="Barter" name="barter" value="<?php echo $order['barter']; ?>" />
        								<div class="text-center">
        									<button type="submit" name="saveOrder" class="infoFormSubmit">Төлбөрийн мэдээлэл хадгалах</button>
        								</div>
									</div>
								</div>
							</div>
							</form>
						</div>
<script>
function calTotalPrice() {
	var totalSize = <?php echo $order['size1']; ?>;
	var unitPrice = $("#Price").val();
	var barter = $( "#Barter" ).val();
	var paid = $("#Payment1").val();
	var remain = $("#Payment2").val();
	var totalPrice = totalSize * unitPrice;
	var totalRemain = totalPrice - paid - barter;
	$("#TotalPrice").val(totalPrice);
	$("#Payment2").val(totalRemain);
}


$("#Price").change(function(){
	calTotalPrice();
});
$("#TotalPrice").change(function() {
  calTotalPrice();
});
$("#Payment1").change(function() {
  calTotalPrice();
});
$("#Payment2").change(function() {
  calTotalPrice();
});
$("#Barter").change(function() {
  calTotalPrice();
});

</script>
						<div class="orderInfoBlockTitle">
							Нэмэлт файлууд
						</div>
						<div class="orderInfoBlockDetail">
										<?php if($order['quality_cert'] == NULL) { ?>
										<label>Чанарын гэрчилгээ (файл)</label>
        								<input type="file" required="required" name="quality_cert">
										<?php } else { ?>
										<div class="orderInfoBlockRow" style="border-top: none;">
											<div class="row">
												<div class="medium-6 columns">
												Чанарын гэрчилгээ
												</div>
												<div class="medium-6 columns text-right">
												<a href="<?php echo MAIN_FOLDER.'/quality_cert/'.$order['quality_cert']; ?>" target="_blank" class="fileDownload"">Татах</a>
												</div>
											</div>
										</div>
										<?php } ?>
										<?php if($order['slump_img'] == NULL) { ?>
										<label>Талбайн слампын зураг (файл)</label>
        								<input type="file" required="required" name="slump_img">
										<?php } else { ?>
										<div class="orderInfoBlockRow">
											<div class="row">
												<div class="medium-6 columns">
												Талбайн слампын зураг (файл)
												</div>
												<div class="medium-6 columns text-right">
												<a href="<?php echo MAIN_FOLDER.'/slump_img/'.$order['slump_img']; ?>" target="_blank" class="fileDownload"">Татах</a>
												</div>
											</div>
										</div>
										<?php } ?>
										<?php if($order['research_page'] == NULL) { ?>
										<label>Судалгааны хуудас (файл)</label>
        								<input type="file" required="required" name="research_page">
										<?php } else { ?>
										<div class="orderInfoBlockRow">
											<div class="row">
												<div class="medium-6 columns">
												Судалгааны хуудас (файл)
												</div>
												<div class="medium-6 columns text-right">
												<a href="<?php echo MAIN_FOLDER.'/research_page/'.$order['research_page']; ?>" target="_blank" class="fileDownload"">Татах</a>
												</div>
											</div>
										</div>
										<?php } ?>
										<?php if($order['concrete_reply7'] == NULL) { ?>
										<label>Бетон шооны хариу /7 хоног - дотоод/ (файл)</label>
        								<input type="file" required="required" name="concrete_reply7">
										<?php } else { ?>
										<div class="orderInfoBlockRow">
											<div class="row">
												<div class="medium-6 columns">
												Бетон шооны хариу /7 хоног - дотоод/ (файл)
												</div>
												<div class="medium-6 columns text-right">
												<a href="<?php echo MAIN_FOLDER.'/concrete_reply7/'.$order['concrete_reply7']; ?>" target="_blank" class="fileDownload"">Татах</a>
												</div>
											</div>
										</div>
										<?php } ?>
										<?php if($order['concrete_reply14'] == NULL) { ?>
										<label>Бетон шооны хариу /14 хоног - дотоод/ (файл)</label>
        								<input type="file" required="required" name="concrete_reply14">
										<?php } else { ?>
										<div class="orderInfoBlockRow">
											<div class="row">
												<div class="medium-6 columns">
												Бетон шооны хариу /14 хоног - дотоод/ (файл)
												</div>
												<div class="medium-6 columns text-right">
												<a href="<?php echo MAIN_FOLDER.'/concrete_reply14/'.$order['concrete_reply14']; ?>" target="_blank" class="fileDownload"">Татах</a>
												</div>
											</div>
										</div>
										<?php } ?>
										<?php if($order['concrete_reply28'] == NULL) { ?>
										<label>Бетон шооны хариу /28 хоног - БАК-ын хариу/ (файл)</label>
        								<input type="file" required="required" name="concrete_reply28">
										<?php } else { ?>
										<div class="orderInfoBlockRow" style="border-bottom: none;">
											<div class="row">
												<div class="medium-6 columns">
												Бетон шооны хариу /28 хоног - БАК-ын хариу/ (файл)
												</div>
												<div class="medium-6 columns text-right">
												<a href="<?php echo MAIN_FOLDER.'/concrete_reply28/'.$order['concrete_reply28']; ?>" target="_blank" class="fileDownload"">Татах</a>
												</div>
											</div>
										</div>
										<?php } ?>
						</div>
					</div>
				<?php
					break;
				}
				?>
				</div>
				<div class="medium-4 columns">
					<div class="orderInfoBlock">
						<div class="orderInfoBlockTitle">
							Захиалгын мэдээлэл
						</div>
						<div class="orderInfoBlockDetail">
							<div class="orderInfoBlockRow" style="border-top: none;">
								<div class="row">
									<div class="medium-6 columns">
										Бүтээгдэхүүний төрөл
									</div>
									<div class="medium-6 columns">
										<?php echo getProductTypeName($order['product_type_id']); ?>
									</div>
								</div>
							</div>
							<div class="orderInfoBlockRow">
								<div class="row">
									<div class="medium-6 columns">
										Хэмжээ
									</div>
									<div class="medium-6 columns">
										<?php echo $order['size1'].' - '.$order['size2']; ?> м<sup>3</sup>
									</div>
								</div>
							</div>
							<div class="orderInfoBlockRow">
								<div class="row">
									<div class="medium-6 columns">
										Помп хэрэглэх
									</div>
									<div class="medium-6 columns">
										<?php echo getPompName($order['pomp_type_id']); ?>
									</div>
								</div>
							</div>
							<div class="orderInfoBlockRow">
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
							<div class="orderInfoBlockRow">
								<div class="row">
									<div class="medium-6 columns">
										Сламп
									</div>
									<div class="medium-6 columns">
										<?php echo getSlumpTypeName($order['slump_type_id']); ?>
									</div>
								</div>
							</div>
							<div class="orderInfoBlockRow">
								<div class="row">
									<div class="medium-6 columns">
										Захиалга гүйцэтгэх огноо, цаг
									</div>
									<div class="medium-6 columns">
										<?php echo $order['order_date'].' / '.substr($order['order_time'],0,5); ?>
									</div>
								</div>
							</div>
							<div class="orderInfoBlockRow">
								<div class="row">
									<div class="medium-6 columns">
										Нэмэлт тайлбар
									</div>
									<div class="medium-6 columns">
										<?php echo $order['description']; ?>
									</div>
								</div>
							</div>
							<div class="orderInfoBlockRow" style="border-bottom: none;">
							</div>
						</div>
					</div>
				</div>
				<div class="medium-4 columns">
					<div class="orderInfoBlock">
						<div class="orderInfoBlockTitle">
							Захиалагчийн мэдээлэл
						</div>
						<div class="orderInfoBlockDetail">
							<div class="orderInfoBlockRow" style="border-top: none;">
								<div class="row">
									<div class="medium-6 columns">
										Компаний нэр:
									</div>
									<div class="medium-6 columns">
										<?php echo $order['company_name']; ?>
									</div>
								</div>
							</div>
							<div class="orderInfoBlockRow">
								<div class="row">
									<div class="medium-6 columns">
										Захиалагчийн нэр:
									</div>
									<div class="medium-6 columns">
										<?php echo $order['client_name']; ?>
									</div>
								</div>
							</div>
							<div class="orderInfoBlockRow">
								<div class="row">
									<div class="medium-6 columns">
										Албан тушаал:
									</div>
									<div class="medium-6 columns">
										<?php echo getPositionName($order['position_id']); ?>
									</div>
								</div>
							</div>
							<div class="orderInfoBlockRow">
								<div class="row">
									<div class="medium-6 columns">
										Утас:
									</div>
									<div class="medium-6 columns">
										<?php echo $order['phone']; ?>
									</div>
								</div>
							</div>
							<div class="orderInfoBlockRow">
								<div class="row">
									<div class="medium-6 columns">
										И-мэйл:
									</div>
									<div class="medium-6 columns">
										<?php echo $order['email']; ?>
									</div>
								</div>
							</div>
							<div class="orderInfoBlockRow">
								<div class="row">
									<div class="medium-6 columns">
										Оффисын хаяг:
									</div>
									<div class="medium-6 columns">
										<?php echo $order['address']; ?>
									</div>
								</div>
							</div>
							<div class="orderInfoBlockRow" style="border-bottom: none;">
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php 
	include(ADMIN_WEB_TEMPLATE. "layout/footer.php");
?>