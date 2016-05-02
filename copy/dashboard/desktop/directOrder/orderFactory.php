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
				<form action="order.php?action=searchOrderFactory" method="post">
			<div class="row">
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
				<div class="medium-7 columns">
					
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
				<th class="text-center" width="30%">Үйлдвэрлэсэн</th>
				<th class="text-center" width="15%">Захиалгын огноо</th>
			</tr>
			<?php foreach($orders as $order) : ?>
			<tr>
				<td>
					<a href="directOrder.php?action=orderFactoryInfo&id=<?php echo $order['id']; ?>">
						<div class="orderStatus" style="background: <?php echo getStatusColor($order['status']); ?>"></div>
					</a>
				</td>
				<td>
					<a href="directOrder.php?action=orderFactoryInfo&id=<?php echo $order['id']; ?>"><?php echo $order['company_name']; ?></a>
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
								echo '<div class="manager_badge">Шинэ: Үзсэн</div>';
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
				</td>
				<td class="text-center"><?php echo $order['size1'].' - '.$order['size2']; ?> м<sup>3</sup></td>
				<td class="text-center">
					<div class="progress small-12 factory radius round">
  						<span class="meter" style="width: <?php echo ($order['produced']*100)/$order['size1']; ?>%">
  							<div class="factoryProgress" <?php if($order['factory_progress'] == 0 || $order['factory_progress'] == NULL) { echo 'style="color: #000;"'; } ?>>
  								<?php echo round(($order['produced']*100)/$order['size1']); ?>% (<?php echo $order['produced'].' м<sup>3</sup>'; ?>)
  							</div>
  						</span>
					</div>
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
				<?php if(isset($_GET['company'])) { ?>
					<a class="paginationLink" href="directOrder.php?action=orderFactory&page=<?php echo $i; ?>&company=<?php echo $_GET['company']; ?>&product=<?php echo $_GET['product']; ?>"><?php echo $i; ?></a>
				<?php } else { ?>
					<a class="paginationLink" href="directOrder.php?action=orderFactory&page=<?php echo $i; ?>"><?php echo $i; ?></a>
				<?php } ?>
			<?php } ?>
		</div>
	</div>
</div>

<?php 
	include(ADMIN_WEB_TEMPLATE. "layout/footer.php");
?>