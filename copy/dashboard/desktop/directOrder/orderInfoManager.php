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
							Гэрээний дугаар, үнэ оруулах
						</div>
						<div class="orderInfoBlockDetail">
							<form action="directOrder.php?action=agreementSubmit" method="post" enctype="multipart/form-data">
							<input type="hidden" name="id" value="<?php echo $_GET['id']; ?>" id="ID" />
							<div class="orderInfoBlockRow" style="border-bottom: none; border-top: none;">
								<div class="row">
									<div class="medium-12 columns">
										<label>Гэрээний дугаар</label>
        								<input type="text" name="agreement_id" required="required" />
        								<label>Бүтээгдэхүүний үнэ (1м<sup>3</sup>-ын үнэ ₮)</label>
        								<input type="text" name="price" id="Price" required="required"/>
        								<label>Гэрээний нийт дүн (₮)</label>
        								<input type="text" id="TotalPrice" name="total_price" required="required"/>
        								<label>Gift</label>
        								<input type="text" id="Gift" name="gift" value="0" required="required"/>
        								<label>Бартерын дүн (₮)</label>
										<input type="text" id="Barter" name="barter" value="0" />
										<label>Төлбөр төлсөн (₮)</label>
        								<input type="text" id="Payment1" name="payment1" value="0" required="required"/>
        								<label>Төлбөрийн үлдэгдэл (₮)</label>
        								<input type="text" id="Payment2" name="payment2" value="0" required="required"/>
        								<label>Гэрээ (файл)</label>
        								<input type="file" required="required" name="agreement">
        								<div class="text-center">
        									<button type="submit" name="saveOrder" class="infoFormSubmit">Гэрээний дугаар олгох</button>
        								</div>
									</div>
								</div>
							</div>
							</form>
						</div>
<script>
function calculateTotal() {
	var productPrice = $( "#Price" ).val();
	var totalPrice = productPrice * <?php echo $order['size1']; ?>;
	$("#TotalPrice").val(totalPrice);
}

function calculateRemain() {
	var paid = $( "#Payment1" ).val();
	var barter = $( "#Barter" ).val();
	var totalPayment = $( "#TotalPrice" ).val();
	var remainPayment = totalPayment - paid - barter;
	$("#Payment2").val(remainPayment);
}

$("#Payment1").change(function(){
	calculateRemain();	
});

$("#Barter").change(function(){
	calculateRemain();	
});

$("#Price").change(function() {
  calculateTotal();
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
								<span class="orderInfoFullStatusIcon" style="background: <?php echo getStatusColor($order['status']); ?>;"></span> - Захиалгад гэрээний дугаар олгон, бүтээгдэхүүний үнийг тооцон, гэрээг хавсарган тань руу илгээсэн байна. Одоогоор таны зөвшөөрлийг хүлээж байна.
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
										Олгосон гэрээний №
									</div>
									<div class="medium-6 columns text-right">
										<?php echo $order['agreement_id']; ?>
									</div>
								</div>
							</div>
							<div class="orderInfoBlockRow">
								<div class="row">
									<div class="medium-6 columns">
										Хэмжээ
									</div>
									<div class="medium-6 columns text-right">
										<?php echo $order['size1'].' м'; ?><sup>3</sup>
									</div>
								</div>
							</div>
							<div class="orderInfoBlockRow">
								<div class="row">
									<div class="medium-6 columns">
										Бүтээгдэхүүний үнэ (1м<sup>3</sup>)
									</div>
									<div class="medium-6 columns text-right">
										<?php echo $order['price']; ?> ₮
									</div>
								</div>
							</div>
							<div class="orderInfoBlockRow">
								<div class="row">
									<div class="medium-6 columns">
										Гэрээний нийт дүн (₮)
									</div>
									<div class="medium-6 columns text-right">
										<?php echo $order['total_price']; ?> ₮
									</div>
								</div>
							</div>
							<div class="orderInfoBlockRow">
								<div class="row">
									<div class="medium-6 columns">
										Гэрээний файл
									</div>
									<div class="medium-6 columns text-right">
										<a href="<?php echo MAIN_FOLDER.'/agreements/'.$order['agreement']; ?>" target="_blank" class="fileDownload">Татах</a>
									</div>
								</div>
							</div>
						</div>
						<div class="orderInfoBlockTitle">
							Төлбөрийн мэдээлэл
						</div>
						<div class="orderInfoBlockDetail">
							<div class="orderInfoBlockRow" style="border-top: none;">
								<div class="row">
									<div class="medium-6 columns">
										Gift
									</div>
									<div class="medium-6 columns text-right">
										<?php echo $order['gift']; ?> ₮
									</div>
								</div>
							</div>
							<?php if($order['barter'] != 0) { ?>
							<div class="orderInfoBlockRow">
								<div class="row">
									<div class="medium-6 columns">
										Бартер
									</div>
									<div class="medium-6 columns text-right">
										<?php echo $order['barter']; ?> ₮
									</div>
								</div>
							</div>
							<?php } ?>
							<div class="orderInfoBlockRow">
								<div class="row">
									<div class="medium-6 columns">
										Төлбөр төлсөн (₮)
									</div>
									<div class="medium-6 columns text-right">
										<?php echo $order['payment1']; ?> ₮
									</div>
								</div>
							</div>
							<div class="orderInfoBlockRow">
								<div class="row">
									<div class="medium-6 columns">
										Төлбөрийн үлдэгдэл (₮)
									</div>
									<div class="medium-6 columns text-right">
										<?php echo $order['payment2']; ?> ₮
									</div>
								</div>
							</div>
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
								<span class="orderInfoFullStatusIcon" style="background: <?php echo getStatusColor($order['status']); ?>;"></span> - Захиалгын гэрээг зөвшөөрсөн тул ахлах менежер рүү шилжсэн байна. Тухайн компанитай гэрээ байгуулж, төлбөрийг хүлээн авч, үйлдвэр рүү шилжүүлэхийг хүлээж байна.
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
										Олгосон гэрээний №
									</div>
									<div class="medium-6 columns text-right">
										<?php echo $order['agreement_id']; ?>
									</div>
								</div>
							</div>
							<div class="orderInfoBlockRow">
								<div class="row">
									<div class="medium-6 columns">
										Хэмжээ
									</div>
									<div class="medium-6 columns text-right">
										<?php echo $order['size1'].' м'; ?><sup>3</sup>
									</div>
								</div>
							</div>
							<div class="orderInfoBlockRow">
								<div class="row">
									<div class="medium-6 columns">
										Бүтээгдэхүүний үнэ (1м<sup>3</sup>)
									</div>
									<div class="medium-6 columns text-right">
										<?php echo $order['price']; ?> ₮
									</div>
								</div>
							</div>
							<div class="orderInfoBlockRow">
								<div class="row">
									<div class="medium-6 columns">
										Гэрээний нийт дүн (₮)
									</div>
									<div class="medium-6 columns text-right">
										<?php echo $order['total_price']; ?> ₮
									</div>
								</div>
							</div>
							<div class="orderInfoBlockRow">
								<div class="row">
									<div class="medium-6 columns">
										Гэрээний файл
									</div>
									<div class="medium-6 columns text-right">
										<a href="<?php echo MAIN_FOLDER.'/agreements/'.$order['agreement']; ?>" target="_blank" class="fileDownload">Татах</a>
									</div>
								</div>
							</div>
						</div>
						<div class="orderInfoBlockTitle">
							Төлбөрийн мэдээлэл
						</div>
						<div class="orderInfoBlockDetail">
							<div class="orderInfoBlockRow" style="border-top: none;">
								<div class="row">
									<div class="medium-6 columns">
										Gift
									</div>
									<div class="medium-6 columns text-right">
										<?php echo $order['gift']; ?> ₮
									</div>
								</div>
							</div>
							<?php if($order['barter'] != 0) { ?>
							<div class="orderInfoBlockRow">
								<div class="row">
									<div class="medium-6 columns">
										Бартер
									</div>
									<div class="medium-6 columns text-right">
										<?php echo $order['barter']; ?> ₮
									</div>
								</div>
							</div>
							<?php } ?>
							<div class="orderInfoBlockRow">
								<div class="row">
									<div class="medium-6 columns">
										Төлбөр төлсөн (₮)
									</div>
									<div class="medium-6 columns text-right">
										<?php echo $order['payment1']; ?> ₮
									</div>
								</div>
							</div>
							<div class="orderInfoBlockRow">
								<div class="row">
									<div class="medium-6 columns">
										Төлбөрийн үлдэгдэл (₮)
									</div>
									<div class="medium-6 columns text-right">
										<?php echo $order['payment2']; ?> ₮
									</div>
								</div>
							</div>
						</div>
						<div class="orderInfoBlockTitle">
							Үйлдвэр рүү шилжүүлэх
						</div>
						<div class="orderInfoBlockDetail">
							<form action="directOrder.php?action=paymentSubmit" method="post" enctype="multipart/form-data">
							<input type="hidden" name="id" value="<?php echo $_GET['id']; ?>" id="ID" />
							<div class="orderInfoBlockRow" style="border-bottom: none; border-top: none;">
								<div class="row">
									<div class="medium-12 columns">
										<label>Гэрээний нийт дүн (₮)</label>
        								<input type="text" id="TotalPrice" value="<?php echo $order['total_price']; ?>" name="total_price" required="required" disabled="disabled" />
        								<label>Бартер (₮)</label>
        								<input type="text" id="Barter" name="barter" value="<?php echo $order['barter']; ?>" required="required"/>
        								<label>Төлбөр төлсөн (₮)</label>
        								<input type="text" id="Payment1" name="payment1" value="<?php echo $order['payment1']; ?>" required="required"/>
        								<label>Төлбөрийн үлдэгдэл (₮)</label>
        								<input type="text" id="Payment2" name="payment2" value="<?php echo $order['payment2']; ?>" required="required"/>
        								<div class="text-center">
        									<button type="submit" name="saveOrder" class="infoFormSubmit">Үйлдвэр рүү шилжүүлэх</button>
        								</div>
									</div>
								</div>
							</div>
							</form>
						</div>
<script>
function calculateRemain() {
	var paid = $( "#Payment1" ).val();
	var totalPayment = $( "#TotalPrice" ).val();
	var barter = $("#Barter").val();
	var remainPayment = totalPayment - paid - barter;
	$("#Payment2").val(remainPayment);
}
$("#Barter").change(function() {
  calculateRemain();
});
$("#Payment1").change(function() {
  calculateRemain();
});
</script>
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
										Олгосон гэрээний №
									</div>
									<div class="medium-6 columns text-right">
										<?php echo $order['agreement_id']; ?>
									</div>
								</div>
							</div>
							<div class="orderInfoBlockRow">
								<div class="row">
									<div class="medium-6 columns">
										Хэмжээ
									</div>
									<div class="medium-6 columns text-right">
										<?php echo $order['size1'].' м'; ?><sup>3</sup>
									</div>
								</div>
							</div>
							<div class="orderInfoBlockRow">
								<div class="row">
									<div class="medium-6 columns">
										Бүтээгдэхүүний үнэ (1м<sup>3</sup>)
									</div>
									<div class="medium-6 columns text-right">
										<?php echo $order['price']; ?> ₮
									</div>
								</div>
							</div>
							<div class="orderInfoBlockRow">
								<div class="row">
									<div class="medium-6 columns">
										Гэрээний нийт дүн (₮)
									</div>
									<div class="medium-6 columns text-right">
										<?php echo $order['total_price']; ?> ₮
									</div>
								</div>
							</div>
							<div class="orderInfoBlockRow">
								<div class="row">
									<div class="medium-6 columns">
										Гэрээний файл
									</div>
									<div class="medium-6 columns text-right">
										<a href="<?php echo MAIN_FOLDER.'/agreements/'.$order['agreement']; ?>" target="_blank" class="fileDownload">Татах</a>
									</div>
								</div>
							</div>
						</div>
						<div class="orderInfoBlockTitle">
							Төлбөрийн мэдээлэл
						</div>
						<div class="orderInfoBlockDetail">
							<div class="orderInfoBlockRow" style="border-top: none;">
								<div class="row">
									<div class="medium-6 columns">
										Gift
									</div>
									<div class="medium-6 columns text-right">
										<?php echo $order['gift']; ?> ₮
									</div>
								</div>
							</div>
							<?php if($order['barter'] != 0) { ?>
							<div class="orderInfoBlockRow">
								<div class="row">
									<div class="medium-6 columns">
										Бартер
									</div>
									<div class="medium-6 columns text-right">
										<?php echo $order['barter']; ?> ₮
									</div>
								</div>
							</div>
							<?php } ?>
							<div class="orderInfoBlockRow">
								<div class="row">
									<div class="medium-6 columns">
										Төлбөр төлсөн (₮)
									</div>
									<div class="medium-6 columns text-right">
										<?php echo $order['payment1']; ?> ₮
									</div>
								</div>
							</div>
							<div class="orderInfoBlockRow">
								<div class="row">
									<div class="medium-6 columns">
										Төлбөрийн үлдэгдэл (₮)
									</div>
									<div class="medium-6 columns text-right">
										<?php echo $order['payment2']; ?> ₮
									</div>
								</div>
							</div>
						</div>
						<div class="orderInfoBlockTitle">
							Төлбөрийн мэдээлэл оруулах
						</div>
						<div class="orderInfoBlockDetail">
							<form action="directOrder.php?action=paymentChange" method="post" enctype="multipart/form-data">
							<input type="hidden" name="id" value="<?php echo $_GET['id']; ?>" id="ID" />
							<div class="orderInfoBlockRow" style="border-bottom: none; border-top: none;">
								<div class="row">
									<div class="medium-12 columns">
										<label>Гэрээний нийт дүн (₮)</label>
        								<input type="text" id="TotalPrice" value="<?php echo $order['total_price']; ?>" name="total_price" required="required" disabled="disabled" />
        								<label>Бартер (₮)</label>
        								<input type="text" id="Barter" name="barter" value="<?php echo $order['barter']; ?>" required="required"/>
        								<label>Төлбөр төлсөн (₮)</label>
        								<input type="text" id="Payment1" name="payment1" value="<?php echo $order['payment1']; ?>" required="required"/>
        								<label>Төлбөрийн үлдэгдэл (₮)</label>
        								<input type="text" id="Payment2" name="payment2" value="<?php echo $order['payment2']; ?>" required="required"/>
        								<div class="text-center">
        									<button type="submit" name="saveOrder" class="infoFormSubmit">Хадгалах</button>
        								</div>
									</div>
								</div>
							</div>
							</form>
						</div>
<script>
function calculateRemain() {
	var paid = $( "#Payment1" ).val();
	var totalPayment = $( "#TotalPrice" ).val();
	var barter = $("#Barter").val();
	var remainPayment = totalPayment - paid - barter;
	$("#Payment2").val(remainPayment);
}
$("#Barter").change(function() {
  calculateRemain();
});
$("#Payment1").change(function() {
  calculateRemain();
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
										Олгосон гэрээний №
									</div>
									<div class="medium-6 columns text-right">
										<?php echo $order['agreement_id']; ?>
									</div>
								</div>
							</div>
							<div class="orderInfoBlockRow">
								<div class="row">
									<div class="medium-6 columns">
										Хэмжээ
									</div>
									<div class="medium-6 columns text-right">
										<?php echo $order['size1'].' м'; ?><sup>3</sup>
									</div>
								</div>
							</div>
							<div class="orderInfoBlockRow">
								<div class="row">
									<div class="medium-6 columns">
										Бүтээгдэхүүний үнэ (1м<sup>3</sup>)
									</div>
									<div class="medium-6 columns text-right">
										<?php echo $order['price']; ?> ₮
									</div>
								</div>
							</div>
							<div class="orderInfoBlockRow">
								<div class="row">
									<div class="medium-6 columns">
										Гэрээний нийт дүн (₮)
									</div>
									<div class="medium-6 columns text-right">
										<?php echo $order['total_price']; ?> ₮
									</div>
								</div>
							</div>
							<div class="orderInfoBlockRow">
								<div class="row">
									<div class="medium-6 columns">
										Гэрээний файл
									</div>
									<div class="medium-6 columns text-right">
										<a href="<?php echo MAIN_FOLDER.'/agreements/'.$order['agreement']; ?>" target="_blank" class="fileDownload">Татах</a>
									</div>
								</div>
							</div>
						</div>
						<div class="orderInfoBlockTitle">
							Төлбөрийн мэдээлэл
						</div>
						<div class="orderInfoBlockDetail">
							<div class="orderInfoBlockRow" style="border-top: none;">
								<div class="row">
									<div class="medium-6 columns">
										Gift
									</div>
									<div class="medium-6 columns text-right">
										<?php echo $order['gift']; ?> ₮
									</div>
								</div>
							</div>
							<?php if($order['barter'] != 0) { ?>
							<div class="orderInfoBlockRow">
								<div class="row">
									<div class="medium-6 columns">
										Бартер
									</div>
									<div class="medium-6 columns text-right">
										<?php echo $order['barter']; ?> ₮
									</div>
								</div>
							</div>
							<?php } ?>
							<div class="orderInfoBlockRow">
								<div class="row">
									<div class="medium-6 columns">
										Төлбөр төлсөн (₮)
									</div>
									<div class="medium-6 columns text-right">
										<?php echo $order['payment1']; ?> ₮
									</div>
								</div>
							</div>
							<div class="orderInfoBlockRow">
								<div class="row">
									<div class="medium-6 columns">
										Төлбөрийн үлдэгдэл (₮)
									</div>
									<div class="medium-6 columns text-right">
										<?php echo $order['payment2']; ?> ₮
									</div>
								</div>
							</div>
						</div>
						<div class="orderInfoBlockTitle">
							Төлбөрийн мэдээлэл оруулах
						</div>
						<div class="orderInfoBlockDetail">
							<form action="directOrder.php?action=paymentChange" method="post" enctype="multipart/form-data">
							<input type="hidden" name="id" value="<?php echo $_GET['id']; ?>" id="ID" />
							<div class="orderInfoBlockRow" style="border-bottom: none; border-top: none;">
								<div class="row">
									<div class="medium-12 columns">
										<label>Гэрээний нийт дүн (₮)</label>
        								<input type="text" id="TotalPrice" value="<?php echo $order['total_price']; ?>" name="total_price" required="required" disabled="disabled" />
        								<label>Бартер (₮)</label>
        								<input type="text" id="Barter" name="barter" value="<?php echo $order['barter']; ?>" required="required"/>
        								<label>Төлбөр төлсөн (₮)</label>
        								<input type="text" id="Payment1" name="payment1" value="<?php echo $order['payment1']; ?>" required="required"/>
        								<label>Төлбөрийн үлдэгдэл (₮)</label>
        								<input type="text" id="Payment2" name="payment2" value="<?php echo $order['payment2']; ?>" required="required"/>
        								<div class="text-center">
        									<button type="submit" name="saveOrder" class="infoFormSubmit">Хадгалах</button>
        								</div>
									</div>
								</div>
							</div>
							</form>
						</div>
<script>
function calculateRemain() {
	var paid = $( "#Payment1" ).val();
	var totalPayment = $( "#TotalPrice" ).val();
	var barter = $("#Barter").val();
	var remainPayment = totalPayment - paid - barter;
	$("#Payment2").val(remainPayment);
}
$("#Barter").change(function() {
  calculateRemain();
});
$("#Payment1").change(function() {
  calculateRemain();
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
										Олгосон гэрээний №
									</div>
									<div class="medium-6 columns text-right">
										<?php echo $order['agreement_id']; ?>
									</div>
								</div>
							</div>
							<div class="orderInfoBlockRow">
								<div class="row">
									<div class="medium-6 columns">
										Хэмжээ
									</div>
									<div class="medium-6 columns text-right">
										<?php echo $order['size1'].' м'; ?><sup>3</sup>
									</div>
								</div>
							</div>
							<div class="orderInfoBlockRow">
								<div class="row">
									<div class="medium-6 columns">
										Бүтээгдэхүүний үнэ (1м<sup>3</sup>)
									</div>
									<div class="medium-6 columns text-right">
										<?php echo $order['price']; ?> ₮
									</div>
								</div>
							</div>
							<div class="orderInfoBlockRow">
								<div class="row">
									<div class="medium-6 columns">
										Гэрээний нийт дүн (₮)
									</div>
									<div class="medium-6 columns text-right">
										<?php echo $order['total_price']; ?> ₮
									</div>
								</div>
							</div>
							<div class="orderInfoBlockRow">
								<div class="row">
									<div class="medium-6 columns">
										Гэрээний файл
									</div>
									<div class="medium-6 columns text-right">
										<a href="<?php echo MAIN_FOLDER.'/agreements/'.$order['agreement']; ?>" target="_blank" class="fileDownload">Татах</a>
									</div>
								</div>
							</div>
						</div>
						<div class="orderInfoBlockTitle">
							Төлбөрийн мэдээлэл
						</div>
						<div class="orderInfoBlockDetail">
							<div class="orderInfoBlockRow" style="border-top: none;">
								<div class="row">
									<div class="medium-6 columns">
										Gift
									</div>
									<div class="medium-6 columns text-right">
										<?php echo $order['gift']; ?> ₮
									</div>
								</div>
							</div>
							<?php if($order['barter'] != 0) { ?>
							<div class="orderInfoBlockRow">
								<div class="row">
									<div class="medium-6 columns">
										Бартер
									</div>
									<div class="medium-6 columns text-right">
										<?php echo $order['barter']; ?> ₮
									</div>
								</div>
							</div>
							<?php } ?>
							<div class="orderInfoBlockRow">
								<div class="row">
									<div class="medium-6 columns">
										Төлбөр төлсөн (₮)
									</div>
									<div class="medium-6 columns text-right">
										<?php echo $order['payment1']; ?> ₮
									</div>
								</div>
							</div>
							<div class="orderInfoBlockRow">
								<div class="row">
									<div class="medium-6 columns">
										Төлбөрийн үлдэгдэл (₮)
									</div>
									<div class="medium-6 columns text-right">
										<?php echo $order['payment2']; ?> ₮
									</div>
								</div>
							</div>
						</div>
						<div class="orderInfoBlockTitle">
							Төлбөрийн мэдээлэл оруулах
						</div>
						<div class="orderInfoBlockDetail">
							<form action="directOrder.php?action=paymentChange" method="post" enctype="multipart/form-data">
							<input type="hidden" name="id" value="<?php echo $_GET['id']; ?>" id="ID" />
							<div class="orderInfoBlockRow" style="border-bottom: none; border-top: none;">
								<div class="row">
									<div class="medium-12 columns">
										<label>Гэрээний нийт дүн (₮)</label>
        								<input type="text" id="TotalPrice" value="<?php echo $order['total_price']; ?>" name="total_price" required="required" disabled="disabled" />
        								<label>Бартер (₮)</label>
        								<input type="text" id="Barter" name="barter" value="<?php echo $order['barter']; ?>" required="required"/>
        								<label>Төлбөр төлсөн (₮)</label>
        								<input type="text" id="Payment1" name="payment1" value="<?php echo $order['payment1']; ?>" required="required"/>
        								<label>Төлбөрийн үлдэгдэл (₮)</label>
        								<input type="text" id="Payment2" name="payment2" value="<?php echo $order['payment2']; ?>" required="required"/>
        								<div class="text-center">
        									<button type="submit" name="saveOrder" class="infoFormSubmit">Хадгалах</button>
        								</div>
									</div>
								</div>
							</div>
							</form>
						</div>
<script>
function calculateRemain() {
	var paid = $( "#Payment1" ).val();
	var totalPayment = $( "#TotalPrice" ).val();
	var barter = $("#Barter").val();
	var remainPayment = totalPayment - paid - barter;
	$("#Payment2").val(remainPayment);
}
$("#Barter").change(function() {
  calculateRemain();
});
$("#Payment1").change(function() {
  calculateRemain();
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
										Олгосон гэрээний №
									</div>
									<div class="medium-6 columns text-right">
										<?php echo $order['agreement_id']; ?>
									</div>
								</div>
							</div>
							<div class="orderInfoBlockRow">
								<div class="row">
									<div class="medium-6 columns">
										Хэмжээ
									</div>
									<div class="medium-6 columns text-right">
										<?php echo $order['size1'].' м'; ?><sup>3</sup>
									</div>
								</div>
							</div>
							<div class="orderInfoBlockRow">
								<div class="row">
									<div class="medium-6 columns">
										Бүтээгдэхүүний үнэ (1м<sup>3</sup>)
									</div>
									<div class="medium-6 columns text-right">
										<?php echo $order['price']; ?> ₮
									</div>
								</div>
							</div>
							<div class="orderInfoBlockRow">
								<div class="row">
									<div class="medium-6 columns">
										Гэрээний нийт дүн (₮)
									</div>
									<div class="medium-6 columns text-right">
										<?php echo $order['total_price']; ?> ₮
									</div>
								</div>
							</div>
							<div class="orderInfoBlockRow">
								<div class="row">
									<div class="medium-6 columns">
										Гэрээний файл
									</div>
									<div class="medium-6 columns text-right">
										<a href="<?php echo MAIN_FOLDER.'/agreements/'.$order['agreement']; ?>" target="_blank" class="fileDownload">Татах</a>
									</div>
								</div>
							</div>
						</div>
						<div class="orderInfoBlockTitle">
							Төлбөрийн мэдээлэл
						</div>
						<div class="orderInfoBlockDetail">
							<div class="orderInfoBlockRow" style="border-top: none;">
								<div class="row">
									<div class="medium-6 columns">
										Gift
									</div>
									<div class="medium-6 columns text-right">
										<?php echo $order['gift']; ?> ₮
									</div>
								</div>
							</div>
							<?php if($order['barter'] != 0) { ?>
							<div class="orderInfoBlockRow">
								<div class="row">
									<div class="medium-6 columns">
										Бартер
									</div>
									<div class="medium-6 columns text-right">
										<?php echo $order['barter']; ?> ₮
									</div>
								</div>
							</div>
							<?php } ?>
							<div class="orderInfoBlockRow">
								<div class="row">
									<div class="medium-6 columns">
										Төлбөр төлсөн (₮)
									</div>
									<div class="medium-6 columns text-right">
										<?php echo $order['payment1']; ?> ₮
									</div>
								</div>
							</div>
							<div class="orderInfoBlockRow">
								<div class="row">
									<div class="medium-6 columns">
										Төлбөрийн үлдэгдэл (₮)
									</div>
									<div class="medium-6 columns text-right">
										<?php echo $order['payment2']; ?> ₮
									</div>
								</div>
							</div>
						</div>
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
						<div class="orderInfoBlockTitle">
							Төлбөрийн мэдээлэл оруулах
						</div>
						<div class="orderInfoBlockDetail">
							<form action="directOrder.php?action=paymentChange" method="post" enctype="multipart/form-data">
							<input type="hidden" name="id" value="<?php echo $_GET['id']; ?>" id="ID" />
							<div class="orderInfoBlockRow" style="border-bottom: none; border-top: none;">
								<div class="row">
									<div class="medium-12 columns">
										<label>Гэрээний нийт дүн (₮)</label>
        								<input type="text" id="TotalPrice" value="<?php echo $order['total_price']; ?>" name="total_price" required="required" disabled="disabled" />
        								<label>Бартер (₮)</label>
        								<input type="text" id="Barter" name="barter" value="<?php echo $order['barter']; ?>" required="required"/>
        								<label>Төлбөр төлсөн (₮)</label>
        								<input type="text" id="Payment1" name="payment1" value="<?php echo $order['payment1']; ?>" required="required"/>
        								<label>Төлбөрийн үлдэгдэл (₮)</label>
        								<input type="text" id="Payment2" name="payment2" value="<?php echo $order['payment2']; ?>" required="required"/>
        								<div class="text-center">
        									<button type="submit" name="saveOrder" class="infoFormSubmit">Хадгалах</button>
        								</div>
									</div>
								</div>
							</div>
							</form>
						</div>
<script>
function calculateRemain() {
	var paid = $( "#Payment1" ).val();
	var totalPayment = $( "#TotalPrice" ).val();
	var barter = $("#Barter").val();
	var remainPayment = totalPayment - paid - barter;
	$("#Payment2").val(remainPayment);
}
$("#Barter").change(function() {
  calculateRemain();
});
$("#Payment1").change(function() {
  calculateRemain();
});
</script>
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