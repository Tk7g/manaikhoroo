<?php include(ADMIN_TEMPLATE. "template/header.php"); ?>
<?php include(ADMIN_TEMPLATE. "session_check.php"); ?>

<div class="row">
	<div class="small-12 columns">
		<?php if ( isset( $result ) ) { ?>
       		<div class="alert-box"><?php echo $result; ?><a href="#" class="close">&times;</a></div>
		<?php } ?>	
	</div>
</div>
<div id="listRow">
	<div class="row">
		<div class="small-12 columns">
			<div id="listHeader">
				<div class="row">
					<div class="small-6 columns">Компаний нэр</div>
					<div class="small-3 columns text-right">Хэмжээ/Төлсөн</div>
					<div class="small-3 columns text-right">Үнийн дүн</div>
				</div>
			</div>
			<div id="listBody">
				<?php foreach($orders as $order) : ?>
				<div class="rowList">
				<a href="directOrder.php?action=orderInfoManager&id=<?php echo $order['id']; ?>">
					<div class="row list_row">
						<div class="small-6 columns text-left">
							<div class="row">
								<div class="orderStatus" style="background: <?php echo getStatusColor($order['status']); ?>"></div>
								<div class="orderInfo">
									<div>
										<?php echo $order['company_name']; ?>
									</div>
									<div class="orderProdType">
										<span><?php echo getProductTypeName($order['product_type_id']); ?></span>
										<span class="orderDate"><?php echo $order['order_date']; ?></span>
									</div>
								</div>
							</div>
						</div>
						<div class="small-3 columns text-right">
						<?php
						if($order['payment1'] == NULL) {
							echo $order['size1'].'м<sup>3</sup>';
						} else {
							echo $order['size1'].'м<sup>3</sup>';
							echo '<div style="margin-top: 4px;">'.$order['payment1'].'</div>';
							if($order['payment1'] < $order['total_price']){
								echo '<div style="margin-top: 4px; color: #f04124;">+'.$order['payment2'].'</div>';
							}
						}
						?>	
						</div>
						<div class="small-3 columns text-right">
						<?php 
							echo $order['total_price']; 
							if($order['checked'] == 0) {
								echo '<span class="new_badge">Шинэ</span>';
							} else {
								if($order['status'] == 1){
									echo '<span class="agreement_badge">Гэрээний № олгогдсон</span>';
								} elseif($order['status'] == 2) {
									echo '<span class="approved_badge">Зөвшөөрсөн</span>';
								} elseif($order['status'] == 3) {
									echo '<span class="cancelled_badge">Татгалзсан</span>';
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
						</div>
					</div>
				</a>
				</div>
				<?php endforeach; ?>
			</div>
		</div>
	</div>
</div>
<div id="page-block">
	<div class="row">
		<div class="small-12 columns">
		<?php for($i=1; $i<=$total_pagination; $i++) { ?>
			<a class="pagination-link" href="directOrder.php?action=orderManager&page=<?php echo $i; ?>"><?php echo $i; ?></a>
		<?php } ?>
		</div>
	</div>
</div>
<?php include(ADMIN_TEMPLATE. "template/footer.php"); ?>