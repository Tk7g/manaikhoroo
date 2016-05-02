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
					<div class="small-3 columns text-right">Хэмжээ</div>
					<div class="small-3 columns text-right">Үйлдвэрлэсэн</div>
				</div>
			</div>
			<div id="listBody">
				<?php foreach($orders as $order) : ?>
				<div class="rowList">
				<a href="directOrder.php?action=orderFactoryInfo&id=<?php echo $order['id']; ?>">
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
						<?php echo $order['size1']; ?>  м<sup>3</sup>	
						</div>
						<div class="small-3 columns text-right">
						<?php echo $order['produced']; ?> м<sup>3</sup>
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
			<a class="pagination-link" href="directOrder.php?action=orderFactory&page=<?php echo $i; ?>"><?php echo $i; ?></a>
		<?php } ?>
		</div>
	</div>
</div>
<?php include(ADMIN_TEMPLATE. "template/footer.php"); ?>