<?php 
	include(ADMIN_WEB_TEMPLATE. "layout/header.php");
	include(ADMIN_TEMPLATE. "session_check.php");
?>
<div id="mainComponent">
	<div class="mainTitle">
		<?php echo $page_title; ?>
	</div>
	<div class="mainWrapper">
		<div class="orderIconTitle">
			Гэрээт захиалгууд
		</div>
		<div class="orderIconBody">
		<a href="order.php?action=orderManager&page=1&status=0&company=&product=" class="notification-link">
		<div class="notification-block">
			<div class="note-icon newBadgeBg">
				<i class="fa fa-file-text-o"></i>
			</div>
			<div class="note-text">
				Шинэ захиалга
			</div>
			<div class="note-count">
				<?php echo $new_companyOrders['COUNT(*)']; ?>
			</div>
		</div>
		</a>
		<a href="order.php?action=orderManager&page=1&status=1&company=&product=" class="notification-link">
		<div class="notification-block">
			<div class="note-icon agreementBadgeBg">
				<i class="fa fa-pencil-square-o"></i>
			</div>
			<div class="note-text">
				Гэрээний № олгодсон
			</div>
			<div class="note-count">
				<?php echo $agreement_companyOrders['COUNT(*)']; ?>
			</div>
		</div>
		</a>
		<a href="order.php?action=orderManager&page=1&status=2&company=&product=" class="notification-link">
		<div class="notification-block">
			<div class="note-icon acceptedBadgeBg">
				<i class="fa fa-check-square-o"></i>
			</div>
			<div class="note-text">
				Зөвшөөрсөн
			</div>
			<div class="note-count">
				<?php echo $accepted_companyOrders['COUNT(*)']; ?>
			</div>
		</div>
		</a>
		<a href="order.php?action=orderManager&page=1&status=4&company=&product=" class="notification-link">
		<div class="notification-block">
			<div class="note-icon toFactoryBadgeBg">
				<i class="fa fa-paper-plane-o"></i>
			</div>
			<div class="note-text">
				Үйлдвэрт шилжсэн
			</div>
			<div class="note-count">
				<?php echo $toFactory_companyOrders['COUNT(*)']; ?>
			</div>
		</div>
		</a>
		<a href="order.php?action=orderManager&page=1&status=5&company=&product=" class="notification-link">
		<div class="notification-block">
			<div class="note-icon producingBadgeBg">
				<i class="fa fa-cogs"></i>
			</div>
			<div class="note-text">
				Үйлдвэрлэж байгаа
			</div>
			<div class="note-count">
				<?php echo $producing_companyOrders['COUNT(*)']; ?>
			</div>
		</div>
		</a>
		<a href="order.php?action=orderManager&page=1&status=6&company=&product=" class="notification-link">
		<div class="notification-block">
			<div class="note-icon finishedBadgeBg">
				<i class="fa fa-check"></i>
			</div>
			<div class="note-text">
				Үйлдвэрлэж дууссан
			</div>
			<div class="note-count">
				<?php echo $finished_companyOrders['COUNT(*)']; ?>
			</div>
		</div>
		</a>
		</div>
		<div class="orderIconTitle">
			Гэрээт бус захиалгууд
		</div>
		<div class="orderIconBody">
		<a href="directOrder.php?action=orderManager&page=1&status=0&product=" class="notification-link">
		<div class="notification-block newBadgeBg">
			<div class="note-icon">
				<i class="fa fa-file-text-o"></i>
			</div>
			<div class="note-text">
				Шинэ захиалга
			</div>
			<div class="note-count">
				<?php echo $new_companyOrders2['COUNT(*)']; ?>
			</div>
		</div>
		</a>
		<a href="directOrder.php?action=orderManager&page=1&status=1&product=" class="notification-link">
		<div class="notification-block agreementBadgeBg">
			<div class="note-icon">
				<i class="fa fa-pencil-square-o"></i>
			</div>
			<div class="note-text">
				Гэрээний № олгодсон
			</div>
			<div class="note-count">
				<?php echo $agreement_companyOrders2['COUNT(*)']; ?>
			</div>
		</div>
		</a>
		<a href="directOrder.php?action=orderManager&page=1&status=2&product=" class="notification-link">
		<div class="notification-block acceptedBadgeBg">
			<div class="note-icon">
				<i class="fa fa-check-square-o"></i>
			</div>
			<div class="note-text">
				Зөвшөөрсөн
			</div>
			<div class="note-count">
				<?php echo $accepted_companyOrders2['COUNT(*)']; ?>
			</div>
		</div>
		</a>
		<a href="directOrder.php?action=orderManager&page=1&status=4&product=" class="notification-link">
		<div class="notification-block toFactoryBadgeBg">
			<div class="note-icon">
				<i class="fa fa-paper-plane-o"></i>
			</div>
			<div class="note-text">
				Үйлдвэрт шилжсэн
			</div>
			<div class="note-count">
				<?php echo $toFactory_companyOrders2['COUNT(*)']; ?>
			</div>
		</div>
		</a>
		<a href="directOrder.php?action=orderManager&page=1&status=5&product=" class="notification-link">
		<div class="notification-block producingBadgeBg">
			<div class="note-icon">
				<i class="fa fa-cogs"></i>
			</div>
			<div class="note-text">
				Үйлдвэрлэж байгаа
			</div>
			<div class="note-count">
				<?php echo $producing_companyOrders2['COUNT(*)']; ?>
			</div>
		</div>
		</a>
		<a href="directOrder.php?action=orderManager&page=1&status=6&product=" class="notification-link">
		<div class="notification-block finishedBadgeBg">
			<div class="note-icon">
				<i class="fa fa-check"></i>
			</div>
			<div class="note-text">
				Үйлдвэрлэж дууссан
			</div>
			<div class="note-count">
				<?php echo $finished_companyOrders2['COUNT(*)']; ?>
			</div>
		</div>
		</a>
		</div>
		<div class="orderDetailsBlock">
			<div class="row">
				<div class="medium-4 columns">
					<div class="orderDetailTitle">
						Шинээр орж ирсэн гэрээт захиалгууд
					</div>
					<div class="orderDetailBody">
					<?php foreach($companyOrders as $cOrder) : ?>
						<div class="orderDetailRow">
							<div class="row">
								<div class="medium-8 columns">
									<div class="orderDetailInfo"><label>Компаний нэр:</label> <?php echo $cOrder['company_name']; ?></div>
									<div class="orderDetailInfo"><label>Бүтээгдэхүүний төрөл:</label> <?php echo getProductTypeName($cOrder['concrete_type_id']); ?></div>
									<div class="orderDetailInfo"><label>Захиалгын огноо:</label> <?php echo $cOrder['order_date'].' '.substr($cOrder['order_time'], 0, 10); ?></div>
									<div class="orderDetailInfo"><label>Захиалга өгсөн огноо:</label> <?php echo $cOrder['created']; ?></div>
								</div>
								<div class="medium-4 columns">
									<div class="orderDetailReadmore">
										<a href="order.php?action=orderInfoManager&id=<?php echo $cOrder['id']; ?>">Дэлгэрэнгүй</a>
									</div>
								</div>
							</div>
						</div>
					<?php endforeach; ?>
					</div>
				</div>
				<div class="medium-4 columns">
					<div class="orderDetailTitle">
						Шинээр орж ирсэн гэрээт бус захиалгууд
					</div>
					<div class="orderDetailBody">
					<?php foreach($directOrders as $dOrder) : ?>
						<div class="orderDetailRow">
							<div class="row">
								<div class="medium-8 columns">
									<div class="orderDetailInfo"><label>Компаний нэр:</label> <?php echo $dOrder['company_name']; ?></div>
									<div class="orderDetailInfo"><label>Бүтээгдэхүүний төрөл:</label> <?php echo getProductTypeName($dOrder['concrete_type_id']); ?></div>
									<div class="orderDetailInfo"><label>Захиалгын огноо:</label> <?php echo $dOrder['order_date'].' '.substr($dOrder['order_time'], 0, 10); ?></div>
									<div class="orderDetailInfo"><label>Захиалга өгсөн огноо:</label> <?php echo $dOrder['created']; ?></div>
								</div>
								<div class="medium-4 columns">
									<div class="orderDetailReadmore">
										<a href="directOrder.php?action=orderInfoManager&id=<?php echo $dOrder['id']; ?>">Дэлгэрэнгүй</a>
									</div>
								</div>
							</div>
						</div>
					<?php endforeach; ?>
					</div>
				</div>
				<div class="medium-4 columns">
					test
				</div>
			</div>
		</div>
	</div>
</div>
<?php 
	include(ADMIN_WEB_TEMPLATE. "layout/footer.php");
?>