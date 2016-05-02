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
		<div class="searchBlock">
				<form action="order.php?action=searchOrderAll" method="post">
			<div class="row">
				<div class="medium-2 columns">
					<div class="searchBox">
						<label>Захиалгын статус</label>
						<select name="status">
							<option value="">Сонгоно уу</option>
							<option value="0">- Шинээр орж ирсэн</option>
							<option value="1" <?php if(isset($_GET['status']) && $_GET['status'] == 1){ echo 'selected'; } ?>>- Гэрээний № олгогдсон</option>
							<option value="2" <?php if(isset($_GET['status']) && $_GET['status'] == 2){ echo 'selected'; } ?>>- Зөвшөөрсөн</option>
							<option value="3" <?php if(isset($_GET['status']) && $_GET['status'] == 3){ echo 'selected'; } ?>>- Татгалзсан/Цуцлагдсан</option>
							<option value="4" <?php if(isset($_GET['status']) && $_GET['status'] == 4){ echo 'selected'; } ?>>- Үйлдвэрт шилжүүлсэн</option>
							<option value="5" <?php if(isset($_GET['status']) && $_GET['status'] == 5){ echo 'selected'; } ?>>- Үйлдвэрлэж эхэлсэн</option>
							<option value="6" <?php if(isset($_GET['status']) && $_GET['status'] == 6){ echo 'selected'; } ?>>- Үйлдвэрлэж дууссан</option>
						</select>
					</div>	
				</div>
				<div class="medium-3 columns">
					<div class="searchBox">
						<label>Гэрээт компани</label>
						<select name="company_id">
							<option value="">Сонгоно уу</option>
							<?php foreach($companies as $comp) : ?>
							<option value="<?php echo $comp['id']; ?>" <?php if(isset($_GET['company']) && $_GET['company'] == $comp['id']){ echo 'selected'; } ?>><?php echo $comp['agreement_id'].' - '.$comp['name']; ?></option>
							<?php endforeach; ?>
						</select>
					</div>
				</div>
				<div class="medium-3 columns">
					<div class="searchBox">
						<label>Бүтээгдэхүүний төрөл</label>
						<select name="product_type_id">
							<option value="">Сонгоно уу</option>
							<?php 
								foreach($productParents as $pPar) : 
								$childs = ProductType::getChildList($pPar['id']);
								if($childs == NULL) {
							?>
								<option value="<?php echo $pPar['id']; ?>" <?php if(isset($_GET['product']) && $_GET['product'] == $pPar['id']){ echo 'selected'; } ?>><?php echo $pPar['title']; ?></option>
							<?php		
								} else {
							?>
								<optgroup label="<?php echo $pPar['title']; ?>">
									<?php foreach($childs as $pChild) : ?>
									<option value="<?php echo $pChild['id']; ?>" <?php if(isset($_GET['product']) && $_GET['product'] == $pChild['id']){ echo 'selected'; } ?>><?php echo $pChild['title']; ?></option>
									<?php endforeach; ?>
								</optgroup>
							<?php
								}
								endforeach; 
							?>
						</select>
					</div>
				</div>
				<div class="medium-2 columns">
					<button type="submit" name="searchOrder" class="searchBtn">Хайх</button>
				</div>
				<div class="medium-2 columns">
					
				</div>
			</div>
			</form>
		</div>
		<table width="100%" class="orderTable">
			<tr>
				<th width="2%"></th>
				<th width="20%">Компаний нэр</th>
				<th width="18%">Бүтээгдэхүүний төрөл</th>
				<th class="text-center" width="15%">Хэмжээ</th>
				<th class="text-right" width="15%">Үнийн дүн</th>
				<th class="text-right" width="15%">Төлбөрийн мэдээлэл</th>
				<th class="text-center" width="15%">Захиалгын огноо</th>
			</tr>
			<?php foreach($orders as $order) : ?>
			<tr>
				<td>
					<a href="order.php?action=orderInfo&id=<?php echo $order['id']; ?>">
						<div class="orderStatus" style="background: <?php echo getStatusColor($order['status']); ?>"></div>
					</a>
				</td>
				<td>
					<a href="order.php?action=orderInfo&id=<?php echo $order['id']; ?>"><?php echo $order['company_name']; ?></a>
					<div class="companyAdditional">Утас: <?php echo $order['phone']; ?></div>
					<?php
						if($order['checked'] == 0) {
							echo '<div class="new_badge">Шинэ</div>';
						} else {
							if($order['status'] == 1){
								echo '<div class="agreement_badge">Гэрээний № олгогдсон</div>';
							} elseif($order['status'] == 2) {
								echo '<div class="approved_badge">Зөвшөөрсөн</div>';
							} elseif($order['status'] == 3) {
								echo '<div class="cancelled_badge">Татгалзсан</div>';
							} elseif($order['status'] == 4) {
								echo '<div class="tofactory_badge">Үйлдвэрт шилжүүлсэн</div>';	
							} elseif($order['status'] == 5) {
								echo '<div class="producing_badge">Үйлдвэрлэж эхэлсэн</div>';
							} elseif($order['status'] == 6) {
								echo '<div class="finished_badge">Үйлдвэрлэж дууссан</div>';
							} elseif($order['status'] == 0) {
								echo '<div class="manager_badge">Шинэ: менежер үзсэн</div>';
							}
						}
					?>
				</td>
				<td>
					<div><?php echo getProductTypeName($order['product_type_id']); ?></div>
					<?php if($order['slump_type_id'] != 0) { ?>
					<div class="orderAdditional">Сламп: <?php echo getSlumpTypeName($order['slump_type_id']); ?></div>
					<?php } ?>
					<?php if($order['pomp_type_id'] != 0) { ?>
					<div class="orderAdditional">Помп: <?php echo getPompName($order['pomp_type_id']); ?></div>
					<?php } ?>
					<div class="orderAdditional">Захиалга өгсөн: <?php echo $order['created']; ?></div>
				</td>
				<td class="text-center"><?php echo $order['size1'].' - '.$order['size2']; ?> м<sup>3</sup></td>
				<td class="text-right">
					<div><?php if($order['total_price'] != NULL){ echo $order['total_price'].' ₮';} ?></div>
					<div class="orderPaymentStatus"><?php echo 'Төлбөр: '.getPaymentStatusName($order['payment_status']); ?></div>
				</td>
				<td class="text-right">
					<?php if($order['barter'] != 0) { ?>
					<div class="orderListBarter"><span>Бартер: </span><?php echo $order['barter'].' ₮'; ?></div>
					<?php } ?>
					<?php if($order['payment1'] != NULL) { ?>
					<div class="orderListPaid"><span>Төлсөн: </span><?php echo $order['payment1'].' ₮'; ?></div>
					<?php } ?>
					<?php if($order['payment2'] != NULL) { ?>
					<div class="orderListRemainPayment"><span>Үлдэгдэл: </span><?php echo $order['payment2'].' ₮'; ?></div>
					<?php } ?>
				</td>
				<td class="text-center">
					<div><?php echo $order['order_date']; ?></div>
					<div><?php echo 'Цаг: '.substr($order['order_time'], 0, 5); ?></div>
				</td>
			</tr>
			<?php endforeach; ?>
		</table>
		<div id="paginationBlock">
			<?php for($i=1; $i<=$total_pagination; $i++) { ?>
				<?php if(isset($_GET['status'])) { ?>
					<a class="paginationLink" href="order.php?page=<?php echo $i; ?>&status=<?php echo $_GET['status']; ?>&company=<?php echo $_GET['company']; ?>&product=<?php echo $_GET['product']; ?>"><?php echo $i; ?></a>
				<?php } else { ?>
				<a class="paginationLink" href="order.php?page=<?php echo $i; ?>"><?php echo $i; ?></a>
				<?php } ?>
			<?php } ?>
		</div>
	</div>
</div>

<?php 
	include(ADMIN_WEB_TEMPLATE. "layout/footer.php");
?>