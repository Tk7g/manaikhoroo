<?php include(ADMIN_TEMPLATE. "template/header.php"); ?>
<?php include(ADMIN_TEMPLATE. "session_check.php"); ?>

<div id="orderInfoTab">
	<div class="row">
		<div class="small-12 columns">
			<ul class="tabs" data-tab role="tablist">
  				<li class="tab-title active" role="presentational" ><a href="#panel2-1" role="tab" tabindex="0" aria-selected="true" controls="panel2-1">Дэлгэрэнгүй</a></li>
  				<li class="tab-title" role="presentational" ><a href="#panel2-2" role="tab" tabindex="0"aria-selected="false" controls="panel2-2"><?php echo $command_title; ?></a></li>
			</ul>	
		</div>
	</div>
</div>
<div id="orderInfoFull">
	<div class="tabs-content">
		<section role="tabpanel" aria-hidden="false" class="content active" id="panel2-1">
			<div class="orderInfoFullHeading">
				<div><?php echo $order['company_name']; ?></div>
				<div class="orderInfoFullProdType"><?php echo getProductTypeName($order['product_type_id']); ?></div>
			</div>
			<div class="orderInfoFullBody">
				<ul class="accordion" data-accordion>
					<li class="accordion-navigation">
						<a href="#panel1a" class="orderInfoFullTitle">Захиалгын мэдээлэл</a>
						<div id="panel1a" class="content active">
							<div class="row">
								<div class="small-12 columns">
									<div class="orderInfoFullRow">
										<div class="row">
											<div class="small-6 columns orderInfoFullLabel">
											Бүтээгдэхүүний төрөл:
											</div>
											<div class="small-6 columns text-right orderInfoFullInfo">
											<?php echo getProductTypeName($order['product_type_id']); ?>
											</div>
										</div>
									</div>
									<div class="orderInfoFullRow">
										<div class="row">
											<div class="small-6 columns orderInfoFullLabel">
											Помп хэрэглэх:
											</div>
											<div class="small-6 columns text-right orderInfoFullInfo">
											<?php echo getPompName($order['pomp_type_id']); ?>
											</div>
										</div>
									</div>
									<div class="orderInfoFullRow">
										<div class="row">
											<div class="small-6 columns orderInfoFullLabel">
											Хэмжээ:
											</div>
											<div class="small-6 columns text-right orderInfoFullInfo">
											<?php echo $order['size1'].' - '.$order['size2']; ?>
											</div>
										</div>
									</div>
									<div class="orderInfoFullRow">
										<div class="row">
											<div class="small-6 columns orderInfoFullLabel">
											Бетон цутгалтын төрөл:
											</div>
											<div class="small-6 columns text-right orderInfoFullInfo">
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
									<div class="orderInfoFullRow">
										<div class="row">
											<div class="small-6 columns orderInfoFullLabel">
											Сламп
											</div>
											<div class="small-6 columns text-right orderInfoFullInfo">
											<?php echo getSlumpTypeName($order['slump_type_id']); ?>
											</div>
										</div>
									</div>
									<div class="orderInfoFullRow">
										<div class="row">
											<div class="small-6 columns orderInfoFullLabel">
											Захиалга гүйцэтгэх огноо, цаг
											</div>
											<div class="small-6 columns text-right orderInfoFullInfo">
											<?php echo $order['order_date'].' / '.substr($order['order_time'],0,5); ?>
											</div>
										</div>
									</div>
									<div class="orderInfoFullRow">
										<div class="row">
											<div class="small-6 columns orderInfoFullLabel">
											Нэмэлт тайлбар
											</div>
											<div class="small-6 columns text-right orderInfoFullInfo">
											<?php echo $order['description']; ?>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</li>
					<li class="accordion-navigation">
						<a href="#panel2a" class="orderInfoFullTitle">Захиалагчийн мэдээлэл</a>
						<div id="panel2a" class="content">
      						<div class="row">
								<div class="small-12 columns">
									<div class="orderInfoFullRow">
										<div class="row">
											<div class="small-6 columns orderInfoFullLabel">
											Компаний нэр:
											</div>
											<div class="small-6 columns text-right orderInfoFullInfo">
												<?php echo $order['company_name']; ?>
											</div>
										</div>
									</div>
									<div class="orderInfoFullRow">
										<div class="row">
											<div class="small-6 columns orderInfoFullLabel">
											Захиалагчийн нэр:
											</div>
											<div class="small-6 columns text-right orderInfoFullInfo">
												<?php echo $order['client_name']; ?>
											</div>
										</div>
									</div>
									<div class="orderInfoFullRow">
										<div class="row">
											<div class="small-6 columns orderInfoFullLabel">
											Албан тушаал:
											</div>
											<div class="small-6 columns text-right orderInfoFullInfo">
												<?php echo getPositionName($order['position_id']); ?>
											</div>
										</div>
									</div>
									<div class="orderInfoFullRow">
										<div class="row">
											<div class="small-6 columns orderInfoFullLabel">
											Утас:
											</div>
											<div class="small-6 columns text-right orderInfoFullInfo">
												<?php echo $order['phone']; ?>
											</div>
										</div>
									</div>
									<div class="orderInfoFullRow">
										<div class="row">
											<div class="small-6 columns orderInfoFullLabel">
											И-мэйл:
											</div>
											<div class="small-6 columns text-right orderInfoFullInfo">
												<?php echo $order['email']; ?>
											</div>
										</div>
									</div>
									<div class="orderInfoFullRow last_row">
										<div class="row">
											<div class="small-6 columns orderInfoFullLabel">
											Оффисын хаяг:
											</div>
											<div class="small-6 columns text-right orderInfoFullInfo">
												<?php echo $order['address']; ?>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</li>
				</ul>	
			</div>
		</section>
		<section role="tabpanel" aria-hidden="true" class="content" id="panel2-2">
		<?php 
			switch ( $order['status'] ) {
				case 0:
		?>
			<div class="orderInfoFullHeading">
				<div style="color: <?php echo getStatusColor($order['status']); ?>;"><?php echo $order['company_name']; ?></div>
				<div class="orderInfoFullProdType"><?php echo getProductTypeName($order['product_type_id']); ?></div>
			</div>
			<div class="orderInfoFullBody">
				<ul class="accordion" data-accordion>
					<li class="accordion-navigation">
						<a href="#panel1a" class="orderInfoFullTitle">Захиалгын явцын мэдээ</a>
						<div id="panel1a" class="content active">
							<div class="orderInfoFullProcedure">
								<div class="row">
									<div class="small-12 columns">
										<span class="orderInfoFullStatusIcon" style="background: <?php echo getStatusColor($order['status']); ?>;"></span> - Захиалга шинээр орж ирлээ. Одоогоор ахлах менежерийн гэрээний дугаар олголт болон үнийн тооцооллыг хүлээж байна.
									</div>
								</div>
							</div>
						</div>
					</li>
					<li class="accordion-navigation">
						<a href="#panel2a" class="orderInfoFullTitle">Гэрээний дугаар олгох</a>
						<div id="panel2a" class="content active">
							<div class="row">
								<div class="small-12 columns">
						<form action="order.php?action=agreementSubmit" method="post" enctype="multipart/form-data">
							<input type="hidden" name="id" value="<?php echo $order['id']; ?>" />
							<div class="orderInfoFormRow">
								<div class="row">
									<div class="small-12 columns">
										<label>Гэрээний дугаар
        									<input type="text" name="agreement_id" required="required" />
      									</label>
									</div>
								</div>
							</div>
							<div class="orderInfoFormRow">
								<div class="row">
									<div class="small-12 columns">
										<label>Бүтээгдэхүүний үнэ (1м<sup>3</sup>-ын үнэ ₮)
        									<input type="text" name="price" id="Price" required="required"/>
      									</label>
									</div>
								</div>
							</div>
							<div class="orderInfoFormRow">
								<div class="row">
									<div class="small-12 columns">
										<label><?php echo 'Хэмжээ '.$order['size1'].' - '.$order['size2'].' м'; ?><sup>3</sup>
      									</label>
									</div>
								</div>
							</div>
							<div class="orderInfoFormRow">
								<div class="row">
									<div class="small-12 columns">
										<label>Гэрээний нийт дүн (₮)
        									<input type="text" id="TotalPrice" name="total_price" required="required"/>
      									</label>
									</div>
								</div>
							</div>
							<div class="orderInfoFormRow">
								<div class="row">
									<div class="small-12 columns">
										<label>Gift
        									<input type="text" id="Gift" name="gift" value="0" required="required"/>
      									</label>
									</div>
								</div>
							</div>
							<div class="orderInfoFormRow">
								<div class="row">
									<div class="small-12 columns">
										<label>Бартерын дүн (₮)
											<input type="text" id="Barter" name="barter" value="0" />
										</label>
									</div>
								</div>
							</div>
							<div class="orderInfoFormRow">
								<div class="row">
									<div class="small-12 columns">
										<label>Төлбөр төлсөн (₮)
        									<input type="text" id="Payment1" name="payment1" value="0" required="required"/>
      									</label>
									</div>
								</div>
							</div>
							<div class="orderInfoFormRow">
								<div class="row">
									<div class="small-12 columns">
										<label>Төлбөрийн үлдэгдэл (₮)
        									<input type="text" id="Payment2" name="payment2" value="0" required="required"/>
      									</label>
									</div>
								</div>
							</div>
							<div class="orderInfoFormRow">
								<div class="row">
									<div class="small-12 columns">
										<label>Гэрээ (файл)
        									<input type="file" required="required" name="agreement">
      									</label>
									</div>
								</div>
							</div>
							<div class="row">
    							<div class="large-12 columns text-center">
    								<button type="submit" name="saveOrder" class="infoFormSubmit">Хадгалах</button>
    							</div>
    						</div>
						</form>
								</div>
							</div>
						</div>
					</li>
				</ul>
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
		<?php
			break;
			case 1:
		?>
			<div class="orderInfoFullHeading">
				<div style="color: <?php echo getStatusColor($order['status']); ?>;"><?php echo $order['company_name']; ?></div>
				<div class="orderInfoFullProdType"><?php echo getProductTypeName($order['product_type_id']); ?></div>
			</div>
			<div class="orderInfoFullBody">
				<ul class="accordion" data-accordion>
					<li class="accordion-navigation">
						<a href="#panel1a" class="orderInfoFullTitle">Захиалгын явцын мэдээ</a>
						<div id="panel1a" class="content active">
							<div class="orderInfoFullProcedure">
								<div class="row">
									<div class="small-12 columns">
										<span class="orderInfoFullStatusIcon" style="background: <?php echo getStatusColor($order['status']); ?>;"></span> - Захиалгад гэрээний дугаар олгон, бүтээгдэхүүний үнийг тооцон, гэрээг хавсарган тань руу илгээсэн байна. Одоогоор таны зөвшөөрлийг хүлээж байна.
									</div>
								</div>
							</div>
						</div>
					</li>
					<li class="accordion-navigation">
						<a href="#panel2a" class="orderInfoFullTitle">Гэрээний мэдээлэл</a>
						<div id="panel2a" class="content">
							<div class="orderInfoFullRow">
								<div class="row">
									<div class="small-6 columns orderInfoFullLabel">
									Олгосон гэрээний №
									</div>
									<div class="small-6 columns text-right orderInfoFullInfo">
									<?php echo $order['agreement_id']; ?>
									</div>
								</div>
							</div>
							<div class="orderInfoFullRow">
								<div class="row">
									<div class="small-6 columns orderInfoFullLabel">
										Хэмжээ
									</div>
									<div class="small-6 columns text-right orderInfoFullInfo">
										<?php echo $order['size1'].' - '.$order['size2'].' м'; ?><sup>3</sup>
									</div>
								</div>
							</div>
							<div class="orderInfoFullRow">
								<div class="row">
									<div class="small-6 columns orderInfoFullLabel">
									Бүтээгдэхүүний үнэ
									</div>
									<div class="small-6 columns text-right orderInfoFullInfo">
									<?php echo $order['price']; ?> ₮
									</div>
								</div>
							</div>
							<div class="orderInfoFullRow">
								<div class="row">
									<div class="small-6 columns orderInfoFullLabel">
									Гэрээний нийт дүн (₮)
									</div>
									<div class="small-6 columns text-right orderInfoFullInfo">
									<?php echo $order['total_price']; ?> ₮
									</div>
								</div>
							</div>
							<div class="orderInfoFullRow">
								<div class="row">
									<div class="small-6 columns orderInfoFullLabel">
										Gift
									</div>
									<div class="small-6 columns text-right orderInfoFullInfo">
										<?php echo $order['gift']; ?> ₮
									</div>
								</div>
							</div>
							<div class="orderInfoFullRow">
								<div class="row">
									<div class="small-6 columns orderInfoFullLabel">
										Төлбөр төлсөн (₮)
									</div>
									<div class="small-6 columns text-right orderInfoFullInfo">
										<?php echo $order['payment1']; ?> ₮
									</div>
								</div>
							</div>
							<div class="orderInfoFullRow">
								<div class="row">
									<div class="small-6 columns orderInfoFullLabel">
										Төлбөрийн үлдэгдэл (₮)
									</div>
									<div class="small-6 columns text-right orderInfoFullInfo">
										<?php echo $order['payment2']; ?> ₮
									</div>
								</div>
							</div>
							<div class="orderInfoFullRow">
								<div class="row">
									<div class="small-6 columns orderInfoFullLabel">
									Гэрээний файл
									</div>
									<div class="small-6 columns text-right orderInfoFullInfo">
									<a href="<?php echo MAIN_FOLDER.'/agreements/'.$order['agreement']; ?>" target="_blank" class="button tiny">Татах</a>
									</div>
								</div>
							</div>
						</div>
					</li>
					<li class="accordion-navigation">
						<a href="#panel3a" class="orderInfoFullTitle">Захиалгыг зөвшөөрөх эсэх</a>
						<div id="panel3a" class="content">
							<div class="row orderApproveRow">
								<div class="small-6 columns">
									<a href="order.php?action=approveOrder&id=<?php echo $order['id']; ?>" class="button tiny expand" onclick="return confirm('Захиалгыг зөвшөөрөх үү?');">Зөвшөөрөх</a>
								</div>
								<div class="small-6 columns">
									<a href="order.php?action=cancelOrder&id=<?php echo $order['id']; ?>" class="button tiny alert expand" onclick="return confirm('Захиалгыг татгалзах уу?');">Татгалзах</a>
								</div>
							</div>
						</div>
					</li>
					<li class="accordion-navigation">
						<a href="#panel4a" class="orderInfoFullTitle">Нэмэлт тайлбар</a>
						<div id="panel4a" class="content">
							<div class="row">
								<div class="small-12 columns">
									<form action="order.php?action=descSubmit" method="post">
										<input type="hidden" name="id" value="<?php echo $order['id']; ?>" />
										<div class="orderInfoFormRow">
											<div class="row">
												<div class="small-12 columns">
													<label>Нэмэлт тайлбар
        												<textarea name="director_desc" placeholder="Нэмэлт тайлбарыг энд бичнэ үү"><?php if($order['director_desc'] != NULL) { echo $order['director_desc']; } ?></textarea>
      												</label>
												</div>
											</div>
										</div>
										<div class="row">
    										<div class="large-12 columns text-center">
    											<button type="submit" name="saveOrder" class="infoFormSubmit">Тайлбар илгээх</button>
    										</div>
    									</div>
									</form>
								</div>
							</div>
						</div>
					</li>
				</ul>
			</div>
		<?php
			break;
			case 2:
		?>
			<div class="orderInfoFullHeading">
				<div><?php echo $order['company_name']; ?></div>
				<div class="orderInfoFullProdType"><?php echo getProductTypeName($order['product_type_id']); ?></div>
			</div>
			<div class="orderInfoFullBody">
				<ul class="accordion" data-accordion>
					<li class="accordion-navigation">
						<a href="#panel1a" class="orderInfoFullTitle">Захиалгын явцын мэдээ</a>
						<div id="panel1a" class="content active">
							<div class="orderInfoFullProcedure">
								<div class="row">
									<div class="small-12 columns">
										<span class="orderInfoFullStatusIcon" style="background: <?php echo getStatusColor($order['status']); ?>;"></span> - Захиалгын гэрээг зөвшөөрсөн тул ахлах менежер рүү шилжсэн байна. Тухайн компанитай гэрээ байгуулж, төлбөрийг хүлээн авч, үйлдвэр рүү шилжүүлэхийг хүлээж байна.
									</div>
								</div>
							</div>
						</div>
					</li>
					<li class="accordion-navigation">
						<a href="#panel2a" class="orderInfoFullTitle">Гэрээний мэдээлэл</a>
						<div id="panel2a" class="content">
							<div class="orderInfoFullRow">
								<div class="row">
									<div class="small-6 columns orderInfoFullLabel">
									Олгосон гэрээний №
									</div>
									<div class="small-6 columns text-right orderInfoFullInfo">
									<?php echo $order['agreement_id']; ?>
									</div>
								</div>
							</div>
							<div class="orderInfoFullRow">
								<div class="row">
									<div class="small-6 columns orderInfoFullLabel">
										Хэмжээ
									</div>
									<div class="small-6 columns text-right orderInfoFullInfo">
										<?php echo $order['size1'].' - '.$order['size2'].' м'; ?><sup>3</sup>
									</div>
								</div>
							</div>
							<div class="orderInfoFullRow">
								<div class="row">
									<div class="small-6 columns orderInfoFullLabel">
									Бүтээгдэхүүний үнэ
									</div>
									<div class="small-6 columns text-right orderInfoFullInfo">
									<?php echo $order['price']; ?> ₮
									</div>
								</div>
							</div>
							<div class="orderInfoFullRow">
								<div class="row">
									<div class="small-6 columns orderInfoFullLabel">
									Гэрээний нийт дүн (₮)
									</div>
									<div class="small-6 columns text-right orderInfoFullInfo">
									<?php echo $order['total_price']; ?> ₮
									</div>
								</div>
							</div>
							<div class="orderInfoFullRow">
								<div class="row">
									<div class="small-6 columns orderInfoFullLabel">
										Gift
									</div>
									<div class="small-6 columns text-right orderInfoFullInfo">
										<?php echo $order['gift']; ?> ₮
									</div>
								</div>
							</div>
							<div class="orderInfoFullRow">
								<div class="row">
									<div class="small-6 columns orderInfoFullLabel">
										Төлбөр төлсөн (₮)
									</div>
									<div class="small-6 columns text-right orderInfoFullInfo">
										<?php echo $order['payment1']; ?> ₮
									</div>
								</div>
							</div>
							<div class="orderInfoFullRow">
								<div class="row">
									<div class="small-6 columns orderInfoFullLabel">
										Төлбөрийн үлдэгдэл (₮)
									</div>
									<div class="small-6 columns text-right orderInfoFullInfo">
										<?php echo $order['payment2']; ?> ₮
									</div>
								</div>
							</div>
							<div class="orderInfoFullRow">
								<div class="row">
									<div class="small-6 columns orderInfoFullLabel">
									Гэрээний файл
									</div>
									<div class="small-6 columns text-right orderInfoFullInfo">
									<a href="<?php echo MAIN_FOLDER.'/agreements/'.$order['agreement']; ?>" target="_blank" class="button tiny">Татах</a>
									</div>
								</div>
							</div>
						</div>
					</li>
					<li class="accordion-navigation">
						<a href="#panel3a" class="orderInfoFullTitle">Нэмэлт тайлбар</a>
						<div id="panel3a" class="content">
							<div class="row">
								<div class="small-12 columns">
									<form action="order.php?action=descSubmit" method="post">
										<input type="hidden" name="id" value="<?php echo $order['id']; ?>" />
										<div class="orderInfoFormRow">
											<div class="row">
												<div class="small-12 columns">
													<label>Нэмэлт тайлбар
        												<textarea name="director_desc" placeholder="Нэмэлт тайлбарыг энд бичнэ үү"><?php if($order['director_desc'] != NULL) { echo $order['director_desc']; } ?></textarea>
      												</label>
												</div>
											</div>
										</div>
										<div class="row">
    										<div class="large-12 columns text-center">
    											<button type="submit" name="saveOrder" class="infoFormSubmit">Тайлбар илгээх</button>
    										</div>
    									</div>
									</form>
								</div>
							</div>
						</div>
					</li>
					<li class="accordion-navigation">
						<a href="#panel5a" class="orderInfoFullTitle">Үйлдвэр рүү шилжүүлэх</a>
						<div id="panel5a" class="content">
							<div class="row">
								<div class="small-12 columns">
									<form action="order.php?action=paymentSubmit" method="post" enctype="multipart/form-data">
										<input type="hidden" name="id" value="<?php echo $order['id']; ?>" />
										<div class="orderInfoFormRow">
											<div class="row">
												<div class="small-12 columns">
													<label>Гэрээний нийт дүн (₮)
        												<input type="text" id="TotalPrice" value="<?php echo $order['total_price']; ?>" name="total_price" required="required" disabled="disabled" />
      												</label>
												</div>
											</div>
										</div>
										<div class="orderInfoFormRow">
											<div class="row">
												<div class="small-12 columns">
													<label>Бартер (₮)
        												<input type="text" id="Barter" name="barter" value="<?php echo $order['barter']; ?>" required="required"/>
      												</label>
												</div>
											</div>
										</div>
										<div class="orderInfoFormRow">
											<div class="row">
												<div class="small-12 columns">
													<label>Төлбөр төлсөн (₮)
        												<input type="text" id="Payment1" name="payment1" value="<?php echo $order['payment1']; ?>" required="required"/>
      												</label>
												</div>
											</div>
										</div>
										<div class="orderInfoFormRow">
											<div class="row">
												<div class="small-12 columns">
													<label>Төлбөрийн үлдэгдэл (₮)
        												<input type="text" id="Payment2" name="payment2" value="<?php echo $order['payment2']; ?>" required="required"/>
      												</label>
												</div>
											</div>
										</div>
										<div class="row">
    										<div class="large-12 columns text-center">
    											<button type="submit" name="saveOrder" class="infoFormSubmit">Үйлдвэр рүү шилжүүлэх</button>
    										</div>
    									</div>
									</form>
								</div>
							</div>
						</div>
					</li>
					<li class="accordion-navigation">
						<a href="#panel4a" class="orderInfoFullTitle">Захиалга цуцлах</a>
						<div id="panel4a" class="content">
							<div class="row orderApproveRow">
								<div class="small-6 small-centered columns">
									<a href="order.php?action=cancelOrder&id=<?php echo $order['id']; ?>" class="button tiny alert expand" onclick="return confirm('Захиалгыг татгалзах уу?');">Татгалзах</a>
								</div>
							</div>
						</div>
					</li>
				</ul>
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
		<?php
			break;
			case 3:
		?>
			<div class="orderInfoFullHeading">
				<div><?php echo $order['company_name']; ?></div>
				<div class="orderInfoFullProdType"><?php echo getProductTypeName($order['product_type_id']); ?></div>
			</div>
			<div class="orderInfoFullBody">
				<ul class="accordion" data-accordion>
					<li class="accordion-navigation">
						<a href="#panel1a" class="orderInfoFullTitle">Захиалгын явцын мэдээ</a>
						<div id="panel1a" class="content active">
							<div class="orderInfoFullProcedure">
								<div class="row">
									<div class="small-12 columns">
										<span class="orderInfoFullStatusIcon" style="background: <?php echo getStatusColor($order['status']); ?>;"></span> - Захиалгаас татгалзсан байна.
									</div>
								</div>
							</div>
						</div>
					</li>
					<li class="accordion-navigation">
						<a href="#panel2a" class="orderInfoFullTitle">Гэрээний мэдээлэл</a>
						<div id="panel2a" class="content">
							<div class="orderInfoFullRow">
								<div class="row">
									<div class="small-6 columns orderInfoFullLabel">
									Олгосон гэрээний №
									</div>
									<div class="small-6 columns text-right orderInfoFullInfo">
									<?php echo $order['agreement_id']; ?>
									</div>
								</div>
							</div>
							<div class="orderInfoFullRow">
								<div class="row">
									<div class="small-6 columns orderInfoFullLabel">
										Хэмжээ
									</div>
									<div class="small-6 columns text-right orderInfoFullInfo">
										<?php echo $order['size1'].' - '.$order['size2'].' м'; ?><sup>3</sup>
									</div>
								</div>
							</div>
							<div class="orderInfoFullRow">
								<div class="row">
									<div class="small-6 columns orderInfoFullLabel">
									Бүтээгдэхүүний үнэ
									</div>
									<div class="small-6 columns text-right orderInfoFullInfo">
									<?php echo $order['price']; ?> ₮
									</div>
								</div>
							</div>
							<div class="orderInfoFullRow">
								<div class="row">
									<div class="small-6 columns orderInfoFullLabel">
									Гэрээний нийт дүн (₮)
									</div>
									<div class="small-6 columns text-right orderInfoFullInfo">
									<?php echo $order['total_price']; ?> ₮
									</div>
								</div>
							</div>
							<div class="orderInfoFullRow">
								<div class="row">
									<div class="small-6 columns orderInfoFullLabel">
										Gift
									</div>
									<div class="small-6 columns text-right orderInfoFullInfo">
										<?php echo $order['gift']; ?> ₮
									</div>
								</div>
							</div>
							<div class="orderInfoFullRow">
								<div class="row">
									<div class="small-6 columns orderInfoFullLabel">
										Төлбөр төлсөн (₮)
									</div>
									<div class="small-6 columns text-right orderInfoFullInfo">
										<?php echo $order['payment1']; ?> ₮
									</div>
								</div>
							</div>
							<div class="orderInfoFullRow">
								<div class="row">
									<div class="small-6 columns orderInfoFullLabel">
										Төлбөрийн үлдэгдэл (₮)
									</div>
									<div class="small-6 columns text-right orderInfoFullInfo">
										<?php echo $order['payment2']; ?> ₮
									</div>
								</div>
							</div>
							<div class="orderInfoFullRow">
								<div class="row">
									<div class="small-6 columns orderInfoFullLabel">
									Гэрээний файл
									</div>
									<div class="small-6 columns text-right orderInfoFullInfo">
									<a href="<?php echo MAIN_FOLDER.'/agreements/'.$order['agreement']; ?>" target="_blank" class="button tiny">Татах</a>
									</div>
								</div>
							</div>
						</div>
					</li>
					<li class="accordion-navigation">
						<a href="#panel4a" class="orderInfoFullTitle">Нэмэлт тайлбар</a>
						<div id="panel4a" class="content">
							<div class="row">
								<div class="small-12 columns">
									<form action="order.php?action=descSubmit" method="post">
										<input type="hidden" name="id" value="<?php echo $order['id']; ?>" />
										<div class="orderInfoFormRow">
											<div class="row">
												<div class="small-12 columns">
													<label>Нэмэлт тайлбар
        												<textarea name="director_desc" placeholder="Нэмэлт тайлбарыг энд бичнэ үү"><?php if($order['director_desc'] != NULL) { echo $order['director_desc']; } ?></textarea>
      												</label>
												</div>
											</div>
										</div>
										<div class="row">
    										<div class="large-12 columns text-center">
    											<button type="submit" name="saveOrder" class="infoFormSubmit">Тайлбар илгээх</button>
    										</div>
    									</div>
									</form>
								</div>
							</div>
						</div>
					</li>
				</ul>
			</div>
		<?php
			break;
			case 4:
		?>
			<div class="orderInfoFullHeading">
				<div><?php echo $order['company_name']; ?></div>
				<div class="orderInfoFullProdType"><?php echo getProductTypeName($order['product_type_id']); ?></div>
			</div>
			<div class="orderInfoFullBody">
				<ul class="accordion" data-accordion>
					<li class="accordion-navigation">
						<a href="#panel1a" class="orderInfoFullTitle">Захиалгын явцын мэдээ</a>
						<div id="panel1a" class="content active">
							<div class="orderInfoFullProcedure">
								<div class="row">
									<div class="small-12 columns">
										<span class="orderInfoFullStatusIcon" style="background: <?php echo getStatusColor($order['status']); ?>;"></span> - Компанитай гэрээ байгуулж, төлбөрийг хүлээн аван үйлдвэр рүү шилжүүлсэн байна. Үйлдвэрийн менежер дээр захиалга очсон байна.
									</div>
								</div>
							</div>
						</div>
					</li>
					<li class="accordion-navigation">
						<a href="#panel2a" class="orderInfoFullTitle">Гэрээний мэдээлэл</a>
						<div id="panel2a" class="content">
							<div class="orderInfoFullRow">
								<div class="row">
									<div class="small-6 columns orderInfoFullLabel">
									Олгосон гэрээний №
									</div>
									<div class="small-6 columns text-right orderInfoFullInfo">
									<?php echo $order['agreement_id']; ?>
									</div>
								</div>
							</div>
							<div class="orderInfoFullRow">
								<div class="row">
									<div class="small-6 columns orderInfoFullLabel">
										Хэмжээ
									</div>
									<div class="small-6 columns text-right orderInfoFullInfo">
										<?php echo $order['size1'].' - '.$order['size2'].' м'; ?><sup>3</sup>
									</div>
								</div>
							</div>
							<div class="orderInfoFullRow">
								<div class="row">
									<div class="small-6 columns orderInfoFullLabel">
									Бүтээгдэхүүний үнэ
									</div>
									<div class="small-6 columns text-right orderInfoFullInfo">
									<?php echo $order['price']; ?> ₮
									</div>
								</div>
							</div>
							<div class="orderInfoFullRow">
								<div class="row">
									<div class="small-6 columns orderInfoFullLabel">
									Гэрээний нийт дүн (₮)
									</div>
									<div class="small-6 columns text-right orderInfoFullInfo">
									<?php echo $order['total_price']; ?> ₮
									</div>
								</div>
							</div>
							<div class="orderInfoFullRow">
								<div class="row">
									<div class="small-6 columns orderInfoFullLabel">
										Gift
									</div>
									<div class="small-6 columns text-right orderInfoFullInfo">
										<?php echo $order['gift']; ?> ₮
									</div>
								</div>
							</div>
							<div class="orderInfoFullRow">
								<div class="row">
									<div class="small-6 columns orderInfoFullLabel">
										Төлбөр төлсөн (₮)
									</div>
									<div class="small-6 columns text-right orderInfoFullInfo">
										<?php echo $order['payment1']; ?> ₮
									</div>
								</div>
							</div>
							<div class="orderInfoFullRow">
								<div class="row">
									<div class="small-6 columns orderInfoFullLabel">
										Төлбөрийн үлдэгдэл (₮)
									</div>
									<div class="small-6 columns text-right orderInfoFullInfo">
										<?php echo $order['payment2']; ?> ₮
									</div>
								</div>
							</div>
							<div class="orderInfoFullRow">
								<div class="row">
									<div class="small-6 columns orderInfoFullLabel">
									Гэрээний файл
									</div>
									<div class="small-6 columns text-right orderInfoFullInfo">
									<a href="<?php echo MAIN_FOLDER.'/agreements/'.$order['agreement']; ?>" target="_blank" class="button tiny">Татах</a>
									</div>
								</div>
							</div>
						</div>
					</li>
					<li class="accordion-navigation">
						<a href="#panel3a" class="orderInfoFullTitle">Нэмэлт тайлбар</a>
						<div id="panel3a" class="content">
							<div class="row">
								<div class="small-12 columns">
									<form action="order.php?action=descSubmit" method="post">
										<input type="hidden" name="id" value="<?php echo $order['id']; ?>" />
										<div class="orderInfoFormRow">
											<div class="row">
												<div class="small-12 columns">
													<label>Нэмэлт тайлбар
        												<textarea name="director_desc" placeholder="Нэмэлт тайлбарыг энд бичнэ үү"><?php if($order['director_desc'] != NULL) { echo $order['director_desc']; } ?></textarea>
      												</label>
												</div>
											</div>
										</div>
										<div class="row">
    										<div class="large-12 columns text-center">
    											<button type="submit" name="saveOrder" class="infoFormSubmit">Тайлбар илгээх</button>
    										</div>
    									</div>
									</form>
								</div>
							</div>
						</div>
					</li>
					<li class="accordion-navigation">
						<a href="#panel5a" class="orderInfoFullTitle">Захиалгыг үйлдвэрлэх</a>
						<div id="panel5a" class="content">
							<div class="row">
								<div class="small-12 columns">
									<form action="order.php?action=produce" method="post" enctype="multipart/form-data">
										<input type="hidden" name="id" value="<?php echo $order['id']; ?>" />
										<div class="orderInfoFormRow">
											<div class="row">
												<div class="small-12 columns">
													<label>Бетон цутгалтын төрөл
        												<input type="text" name="concrete_type_id" required="required" />
      												</label>
												</div>
											</div>
										</div>
										<div class="row">
    										<div class="small-10 small-centered columns text-center">
    											<button type="submit" name="saveOrder" class="button small alert expand">Үйлдвэрлэж эхлэх</button>
    										</div>
    									</div>
									</form>
								</div>
							</div>
						</div>
					</li>
					<li class="accordion-navigation">
						<a href="#panel4a" class="orderInfoFullTitle">Захиалга цуцлах</a>
						<div id="panel4a" class="content">
							<div class="row orderApproveRow">
								<div class="small-6 small-centered columns">
									<a href="order.php?action=cancelOrder&id=<?php echo $order['id']; ?>" class="button tiny alert expand" onclick="return confirm('Захиалгыг татгалзах уу?');">Татгалзах</a>
								</div>
							</div>
						</div>
					</li>
				</ul>
			</div>
		<?php
			break;
			case 5:
		?>
			<div class="orderInfoFullHeading">
				<div><?php echo $order['company_name']; ?></div>
				<div class="orderInfoFullProdType"><?php echo getProductTypeName($order['product_type_id']); ?></div>
			</div>
			<div class="orderInfoFullBody">
				<ul class="accordion" data-accordion>
					<li class="accordion-navigation">
						<a href="#panel1a" class="orderInfoFullTitle">Захиалгын явц</a>
						<div id="panel1a" class="content active">
							<div class="orderInfoFullProcedure">
								<div class="row">
									<div class="small-12 columns">
										<span class="orderInfoFullStatusIcon" style="background: <?php echo getStatusColor($order['status']); ?>;"></span> - Захиалгыг үйлдвэрлэж байна.
									</div>
								</div>
							</div>
							<div class="orderInfoFullRow">
								<div class="row">
									<div class="small-12 columns">
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
										<?php echo $order['factory_desc']; ?>
										</div>
										<?php } ?>
									</div>
								</div>
							</div>
						</div>
					</li>
					<li class="accordion-navigation">
						<a href="#panel2a" class="orderInfoFullTitle">Гэрээний мэдээлэл</a>
						<div id="panel2a" class="content">
							<div class="orderInfoFullRow">
								<div class="row">
									<div class="small-6 columns orderInfoFullLabel">
									Олгосон гэрээний №
									</div>
									<div class="small-6 columns text-right orderInfoFullInfo">
									<?php echo $order['agreement_id']; ?>
									</div>
								</div>
							</div>
							<div class="orderInfoFullRow">
								<div class="row">
									<div class="small-6 columns orderInfoFullLabel">
										Хэмжээ
									</div>
									<div class="small-6 columns text-right orderInfoFullInfo">
										<?php echo $order['size1'].' - '.$order['size2'].' м'; ?><sup>3</sup>
									</div>
								</div>
							</div>
							<div class="orderInfoFullRow">
								<div class="row">
									<div class="small-6 columns orderInfoFullLabel">
									Бүтээгдэхүүний үнэ
									</div>
									<div class="small-6 columns text-right orderInfoFullInfo">
									<?php echo $order['price']; ?> ₮
									</div>
								</div>
							</div>
							<div class="orderInfoFullRow">
								<div class="row">
									<div class="small-6 columns orderInfoFullLabel">
									Гэрээний нийт дүн (₮)
									</div>
									<div class="small-6 columns text-right orderInfoFullInfo">
									<?php echo $order['total_price']; ?> ₮
									</div>
								</div>
							</div>
							<div class="orderInfoFullRow">
								<div class="row">
									<div class="small-6 columns orderInfoFullLabel">
										Gift
									</div>
									<div class="small-6 columns text-right orderInfoFullInfo">
										<?php echo $order['gift']; ?> ₮
									</div>
								</div>
							</div>
							<div class="orderInfoFullRow">
								<div class="row">
									<div class="small-6 columns orderInfoFullLabel">
										Төлбөр төлсөн (₮)
									</div>
									<div class="small-6 columns text-right orderInfoFullInfo">
										<?php echo $order['payment1']; ?> ₮
									</div>
								</div>
							</div>
							<div class="orderInfoFullRow">
								<div class="row">
									<div class="small-6 columns orderInfoFullLabel">
										Төлбөрийн үлдэгдэл (₮)
									</div>
									<div class="small-6 columns text-right orderInfoFullInfo">
										<?php echo $order['payment2']; ?> ₮
									</div>
								</div>
							</div>
							<div class="orderInfoFullRow">
								<div class="row">
									<div class="small-6 columns orderInfoFullLabel">
									Гэрээний файл
									</div>
									<div class="small-6 columns text-right orderInfoFullInfo">
									<a href="<?php echo MAIN_FOLDER.'/agreements/'.$order['agreement']; ?>" target="_blank" class="button tiny">Татах</a>
									</div>
								</div>
							</div>
						</div>
					</li>
					<li class="accordion-navigation">
						<a href="#panel3a" class="orderInfoFullTitle">Нэмэлт тайлбар</a>
						<div id="panel3a" class="content">
							<div class="row">
								<div class="small-12 columns">
									<form action="order.php?action=descSubmit" method="post">
										<input type="hidden" name="id" value="<?php echo $order['id']; ?>" />
										<div class="orderInfoFormRow">
											<div class="row">
												<div class="small-12 columns">
													<label>Нэмэлт тайлбар
        												<textarea name="director_desc" placeholder="Нэмэлт тайлбарыг энд бичнэ үү"><?php if($order['director_desc'] != NULL) { echo $order['director_desc']; } ?></textarea>
      												</label>
												</div>
											</div>
										</div>
										<div class="row">
    										<div class="large-12 columns text-center">
    											<button type="submit" name="saveOrder" class="infoFormSubmit">Тайлбар илгээх</button>
    										</div>
    									</div>
									</form>
								</div>
							</div>
						</div>
					</li>
					<li class="accordion-navigation">
						<a href="#panel5a" class="orderInfoFullTitle">Захиалгын явц шинэчлэх</a>
						<div id="panel5a" class="content">
							<div class="row">
								<div class="small-12 columns">
									<form action="order.php?action=progressUpdate" method="post" enctype="multipart/form-data">
										<input type="hidden" name="id" value="<?php echo $order['id']; ?>" />
										<div class="orderInfoFormRow">
											<div class="row">
												<div class="small-12 columns">
													<label>Үйлдвэрлэсэн хэмжээ (м<sup>3</sup>)
        												<input type="text" name="produced" <?php echo 'value="'.$order['produced'].'"'; ?> id="Produced" required="required" />
      												</label>
												</div>
											</div>
										</div>
										<div class="orderInfoFormRow">
											<div class="row">
												<div class="small-12 columns">
													<label>Үйлдвэрлэлийн явцын тайлбар
        												<textarea id="FactoryDesc" name="factory_desc"><?php if($order['factory_desc'] != NULL) { echo $order['factory_desc']; } ?></textarea>
      												</label>
												</div>
											</div>
										</div>
										<div class="row">
    										<div class="small-10 small-centered columns text-center">
    											<button type="submit" name="saveOrder" class="button tiny expand">Явцыг шинэчлэх</button>
    										</div>
    									</div>
									</form>
								</div>
							</div>
						</div>
					</li>
					<li class="accordion-navigation">
						<a href="#panel6a" class="orderInfoFullTitle">Үйлдвэрлэлийг дуусгах</a>
						<div id="panel6a" class="content">
							<div class="row">
								<div class="small-12 columns">
									<form action="order.php?action=progressFinish" method="post" enctype="multipart/form-data">
										<input type="hidden" name="id" value="<?php echo $order['id']; ?>" />
										<?php if($order['quality_cert'] == NULL) { ?>
										<div class="orderInfoFormRow">
											<div class="row">
												<div class="small-12 columns">
													<label>Чанарын гэрчилгээ (файл)
        												<input type="file" required="required" name="quality_cert">
      												</label>
												</div>
											</div>
										</div>
										<?php } else { ?>
										<div class="orderInfoFullRow">
											<div class="row">
												<div class="small-6 columns orderInfoFullLabel">
												Чанарын гэрчилгээ
												</div>
												<div class="small-6 columns text-right orderInfoFullInfo">
													<a href="<?php echo MAIN_FOLDER.'/quality_cert/'.$order['quality_cert']; ?>" target="_blank" class="button tiny">Татах</a>
												</div>
											</div>
										</div>
										<?php } ?>
										<?php if($order['slump_img'] == NULL) { ?>
										<div class="orderInfoFormRow">
											<div class="row">
												<div class="small-12 columns">
													<label>Талбайн слампын зураг (файл)
        											<input type="file" required="required" name="slump_img">
      												</label>
												</div>
											</div>
										</div>
										<?php } else { ?>
										<div class="orderInfoFullRow">
											<div class="row">
												<div class="small-6 columns orderInfoFullLabel">
													Талбайн слампын зураг
												</div>
												<div class="small-6 columns text-right orderInfoFullInfo">
													<a href="<?php echo MAIN_FOLDER.'/slump_img/'.$order['slump_img']; ?>" target="_blank" class="button tiny">Татах</a>
												</div>
											</div>
										</div>
										<?php } ?>
										<?php if($order['research_page'] == NULL) { ?>
										<div class="orderInfoFormRow">
											<div class="row">
												<div class="small-12 columns">
													<label>Судалгааны хуудас (файл)
        												<input type="file" required="required" name="research_page">
      												</label>
												</div>
											</div>
										</div>
										<?php } else { ?>
										<div class="orderInfoFullRow">
											<div class="row">
												<div class="small-6 columns orderInfoFullLabel">
													Судалгааны хуудас
												</div>
												<div class="small-6 columns text-right orderInfoFullInfo">
													<a href="<?php echo MAIN_FOLDER.'/research_page/'.$order['research_page']; ?>" target="_blank" class="button tiny">Татах</a>
												</div>
											</div>
										</div>
										<?php } ?>
										<?php if($order['concrete_reply7'] == NULL) { ?>
										<div class="orderInfoFormRow">
											<div class="row">
												<div class="small-12 columns">
													<label>Бетон шооны хариу /7 хоног - дотоод/ (файл)
        												<input type="file" name="concrete_reply7">
      												</label>
												</div>
											</div>
										</div>
										<?php } else { ?>
										<div class="orderInfoFullRow">
											<div class="row">
												<div class="small-6 columns orderInfoFullLabel">
													Бетон шооны хариу /7 хоног - дотоод/ (файл)
												</div>
												<div class="small-6 columns text-right orderInfoFullInfo">
													<a href="<?php echo MAIN_FOLDER.'/concrete_reply7/'.$order['concrete_reply7']; ?>" target="_blank" class="button tiny">Татах</a>
												</div>
											</div>
										</div>
										<?php } ?>
										<?php if($order['concrete_reply14'] == NULL) { ?>
										<div class="orderInfoFormRow">
											<div class="row">
												<div class="small-12 columns">
													<label>Бетон шооны хариу /14 хоног - дотоод/ (файл)
        												<input type="file" name="concrete_reply14">
      												</label>
												</div>
											</div>
										</div>
										<?php } else { ?>
										<div class="orderInfoFullRow">
											<div class="row">
												<div class="small-6 columns orderInfoFullLabel">
													Бетон шооны хариу /14 хоног - дотоод/ (файл)
												</div>
												<div class="small-6 columns text-right orderInfoFullInfo">
													<a href="<?php echo MAIN_FOLDER.'/concrete_reply14/'.$order['concrete_reply14']; ?>" target="_blank" class="button tiny">Татах</a>
												</div>
											</div>
										</div>
										<?php } ?>
										<?php if($order['concrete_reply28'] == NULL) { ?>
										<div class="orderInfoFormRow">
											<div class="row">
												<div class="small-12 columns">
													<label>Бетон шооны хариу /28 хоног - БАК-ын хариу/ (файл)
        												<input type="file" name="concrete_reply28">
      												</label>
												</div>
											</div>
										</div>
										<?php } else { ?>
										<div class="orderInfoFullRow">
											<div class="row">
												<div class="small-6 columns orderInfoFullLabel">
													Бетон шооны хариу /28 хоног - БАК-ын хариу/ (файл)
												</div>
												<div class="small-6 columns text-right orderInfoFullInfo">
													<a href="<?php echo MAIN_FOLDER.'/concrete_reply28/'.$order['concrete_reply28']; ?>" target="_blank" class="button tiny">Татах</a>
												</div>
											</div>
										</div>
										<?php } ?>
    									<div class="row">
    										<div class="small-10 small-centered columns text-center">
    											<button type="submit" name="saveOrder" class="button tiny expand">Үйлдвэрлэлийг дуусгах</button>
    										</div>
    									</div>
									</form>
								</div>
							</div>
						</div>
					</li>
					<li class="accordion-navigation">
						<a href="#panel4a" class="orderInfoFullTitle">Захиалга цуцлах</a>
						<div id="panel4a" class="content">
							<div class="row orderApproveRow">
								<div class="small-6 small-centered columns">
									<a href="order.php?action=cancelOrder&id=<?php echo $order['id']; ?>" class="button tiny alert expand" onclick="return confirm('Захиалгыг татгалзах уу?');">Татгалзах</a>
								</div>
							</div>
						</div>
					</li>
				</ul>
			</div>
		<?php
			break;
			case 6:
		?>
			<div class="orderInfoFullHeading">
				<div><?php echo $order['company_name']; ?></div>
				<div class="orderInfoFullProdType"><?php echo getProductTypeName($order['product_type_id']); ?></div>
			</div>
			<div class="orderInfoFullBody">
				<ul class="accordion" data-accordion>
					<li class="accordion-navigation">
						<a href="#panel1a" class="orderInfoFullTitle">Захиалгын явц</a>
						<div id="panel1a" class="content active">
							<div class="orderInfoFullProcedure">
								<div class="row">
									<div class="small-12 columns">
										<span class="orderInfoFullStatusIcon" style="background: <?php echo getStatusColor($order['status']); ?>;"></span> - Захиалгыг гүйцэтгэж дууссан байна.
									</div>
								</div>
							</div>
							<div class="orderInfoFullRow">
								<div class="row">
									<div class="small-12 columns">
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
										<?php echo $order['factory_desc']; ?>
										</div>
										<?php } ?>
									</div>
								</div>
							</div>
							<div class="orderInfoFullRow">
								<div class="row">
									<div class="small-6 columns orderInfoFullLabel">
										Захиалгын хэмжээ
									</div>
									<div class="small-6 columns text-right orderInfoFullInfo">
										<?php echo $order['size1'].' - '.$order['size2'].' м'; ?><sup>3</sup>
									</div>
								</div>
							</div>
							<div class="orderInfoFullRow">
								<div class="row">
									<div class="small-6 columns orderInfoFullLabel">
										Үйлдвэрлэсэн хэмжээ
									</div>
									<div class="small-6 columns text-right orderInfoFullInfo">
										<?php echo $order['produced']; ?> м<sup>3</sup>
									</div>
								</div>
							</div>
						</div>
					</li>
					<li class="accordion-navigation">
						<a href="#panel2a" class="orderInfoFullTitle">Гэрээний мэдээлэл</a>
						<div id="panel2a" class="content">
							<div class="orderInfoFullRow">
								<div class="row">
									<div class="small-6 columns orderInfoFullLabel">
									Олгосон гэрээний №
									</div>
									<div class="small-6 columns text-right orderInfoFullInfo">
									<?php echo $order['agreement_id']; ?>
									</div>
								</div>
							</div>
							<div class="orderInfoFullRow">
								<div class="row">
									<div class="small-6 columns orderInfoFullLabel">
										Хэмжээ
									</div>
									<div class="small-6 columns text-right orderInfoFullInfo">
										<?php echo $order['size1'].' - '.$order['size2'].' м'; ?><sup>3</sup>
									</div>
								</div>
							</div>
							<div class="orderInfoFullRow">
								<div class="row">
									<div class="small-6 columns orderInfoFullLabel">
									Бүтээгдэхүүний үнэ
									</div>
									<div class="small-6 columns text-right orderInfoFullInfo">
									<?php echo $order['price']; ?> ₮
									</div>
								</div>
							</div>
							<div class="orderInfoFullRow">
								<div class="row">
									<div class="small-6 columns orderInfoFullLabel">
									Гэрээний нийт дүн (₮)
									</div>
									<div class="small-6 columns text-right orderInfoFullInfo">
									<?php echo $order['total_price']; ?> ₮
									</div>
								</div>
							</div>
							<div class="orderInfoFullRow">
								<div class="row">
									<div class="small-6 columns orderInfoFullLabel">
										Gift
									</div>
									<div class="small-6 columns text-right orderInfoFullInfo">
										<?php echo $order['gift']; ?> ₮
									</div>
								</div>
							</div>
							<div class="orderInfoFullRow">
								<div class="row">
									<div class="small-6 columns orderInfoFullLabel">
										Төлбөр төлсөн (₮)
									</div>
									<div class="small-6 columns text-right orderInfoFullInfo">
										<?php echo $order['payment1']; ?> ₮
									</div>
								</div>
							</div>
							<div class="orderInfoFullRow">
								<div class="row">
									<div class="small-6 columns orderInfoFullLabel">
										Төлбөрийн үлдэгдэл (₮)
									</div>
									<div class="small-6 columns text-right orderInfoFullInfo">
										<?php echo $order['payment2']; ?> ₮
									</div>
								</div>
							</div>
							<div class="orderInfoFullRow">
								<div class="row">
									<div class="small-6 columns orderInfoFullLabel">
									Гэрээний файл
									</div>
									<div class="small-6 columns text-right orderInfoFullInfo">
									<a href="<?php echo MAIN_FOLDER.'/agreements/'.$order['agreement']; ?>" target="_blank" class="button tiny">Татах</a>
									</div>
								</div>
							</div>
						</div>
					</li>
					<li class="accordion-navigation">
						<a href="#panel3a" class="orderInfoFullTitle">Нэмэлт файлууд</a>
						<div id="panel3a" class="content">
							<div class="row">
								<div class="small-12 columns">
									<?php if($order['quality_cert'] != NULL) { ?>
									<div class="orderInfoFullRow">
										<div class="row">
											<div class="small-6 columns orderInfoFullLabel">
											Чанарын гэрчилгээ
											</div>
											<div class="small-6 columns text-right orderInfoFullInfo">
												<a href="<?php echo MAIN_FOLDER.'/quality_cert/'.$order['quality_cert']; ?>" target="_blank" class="button tiny">Татах</a>
											</div>
										</div>
									</div>
									<?php } ?>
									<?php if($order['slump_img'] != NULL) { ?>
									<div class="orderInfoFullRow">
										<div class="row">
											<div class="small-6 columns orderInfoFullLabel">
											Талбайн слампын зураг
											</div>
											<div class="small-6 columns text-right orderInfoFullInfo">
												<a href="<?php echo MAIN_FOLDER.'/slump_img/'.$order['slump_img']; ?>" target="_blank" class="button tiny">Татах</a>
											</div>
										</div>
									</div>
									<?php } ?>
									<?php if($order['research_page'] != NULL) { ?>
									<div class="orderInfoFullRow">
										<div class="row">
											<div class="small-6 columns orderInfoFullLabel">
											Судалгааны хуудас
											</div>
											<div class="small-6 columns text-right orderInfoFullInfo">
												<a href="<?php echo MAIN_FOLDER.'/research_page/'.$order['research_page']; ?>" target="_blank" class="button tiny">Татах</a>
											</div>
										</div>
									</div>
									<?php } ?>
									<?php if($order['concrete_reply7'] != NULL) { ?>
									<div class="orderInfoFullRow">
										<div class="row">
											<div class="small-6 columns orderInfoFullLabel">
											Бетон шооны хариу /7 хоног - дотоод/
											</div>
											<div class="small-6 columns text-right orderInfoFullInfo">
												<a href="<?php echo MAIN_FOLDER.'/concrete_reply7/'.$order['concrete_reply7']; ?>" target="_blank" class="button tiny">Татах</a>
											</div>
										</div>
									</div>
									<?php } ?>
									<?php if($order['concrete_reply14'] != NULL) { ?>
									<div class="orderInfoFullRow">
										<div class="row">
											<div class="small-6 columns orderInfoFullLabel">
											Бетон шооны хариу /14 хоног - дотоод/
											</div>
											<div class="small-6 columns text-right orderInfoFullInfo">
												<a href="<?php echo MAIN_FOLDER.'/concrete_reply14/'.$order['concrete_reply14']; ?>" target="_blank" class="button tiny">Татах</a>
											</div>
										</div>
									</div>
									<?php } ?>
									<?php if($order['concrete_reply28'] != NULL) { ?>
									<div class="orderInfoFullRow">
										<div class="row">
											<div class="small-6 columns orderInfoFullLabel">
											Бетон шооны хариу /28 хоног - БАК-ын хариу/
											</div>
											<div class="small-6 columns text-right orderInfoFullInfo">
												<a href="<?php echo MAIN_FOLDER.'/concrete_reply28/'.$order['concrete_reply28']; ?>" target="_blank" class="button tiny">Татах</a>
											</div>
										</div>
									</div>
									<?php } ?>
								</div>
							</div>
						</div>
					</li>
					<li class="accordion-navigation">
						<a href="#panel4a" class="orderInfoFullTitle">Нэмэлт тайлбар</a>
						<div id="panel4a" class="content">
							<div class="row">
								<div class="small-12 columns">
									<form action="order.php?action=descSubmit" method="post">
										<input type="hidden" name="id" value="<?php echo $order['id']; ?>" />
										<div class="orderInfoFormRow">
											<div class="row">
												<div class="small-12 columns">
													<label>Нэмэлт тайлбар
        												<textarea name="director_desc" placeholder="Нэмэлт тайлбарыг энд бичнэ үү"><?php if($order['director_desc'] != NULL) { echo $order['director_desc']; } ?></textarea>
      												</label>
												</div>
											</div>
										</div>
										<div class="row">
    										<div class="large-12 columns text-center">
    											<button type="submit" name="saveOrder" class="infoFormSubmit">Тайлбар илгээх</button>
    										</div>
    									</div>
									</form>
								</div>
							</div>
						</div>
					</li>
					<li class="accordion-navigation">
						<a href="#panel5a" class="orderInfoFullTitle">Захиалга цуцлах</a>
						<div id="panel5a" class="content">
							<div class="row orderApproveRow">
								<div class="small-6 small-centered columns">
									<a href="order.php?action=cancelOrder&id=<?php echo $order['id']; ?>" class="button tiny alert expand" onclick="return confirm('Захиалгыг татгалзах уу?');">Татгалзах</a>
								</div>
							</div>
						</div>
					</li>
				</ul>
			</div>
		<?php
			break;
			}
		?>
		</section>
	</div>
</div>

<?php include(ADMIN_TEMPLATE. "template/footer.php"); ?>