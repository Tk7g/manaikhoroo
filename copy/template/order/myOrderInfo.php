<?php
	include(SITE_TEMPLATE."header2.php");
	include("session_check.php");
?>

<div class="myOrderTitle">
	<div class="row">
		<div class="small-12 columns">
			Захиалгын № <?php echo $order['id']; ?>
		</div>
	</div>
</div>

<div class="myOrderInfo">
	<ul class="accordion" data-accordion>
		<li class="accordion-navigation">
			<a href="#panel1a" class="orderInfoFullTitle">Захиалгын мэдээлэл</a>
				<div id="panel1a" class="content active">
					<div class="row">
						<div class="small-12 columns">
							<div class="myOrderInfoRow">
								<div class="row">
									<div class="small-6 columns">
										Бүтээгдэхүүний төрөл
									</div>
									<div class="small-6 columns">
										<?php echo getProductTypeName($order['product_type_id']); ?>
									</div>
								</div>
							</div>
							<div class="myOrderInfoRow">
								<div class="row">
									<div class="small-6 columns">
										Хэмжээ
									</div>
									<div class="small-6 columns">
										<?php echo $order['size1'].' - '.$order['size2'].' м<sup>3</sup>'; ?>
									</div>
								</div>
							</div>
							<div class="myOrderInfoRow">
								<div class="row">
									<div class="small-6 columns">
										Бетон цутгалтын төрөл
									</div>
									<div class="small-6 columns">
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
							<div class="myOrderInfoRow">
								<div class="row">
									<div class="small-6 columns">
										Помп
									</div>
									<div class="small-6 columns">
										<?php echo getPompName($order['pomp_type_id']); ?>
									</div>
								</div>
							</div>
							<div class="myOrderInfoRow">
								<div class="row">
									<div class="small-6 columns">
										Сламп
									</div>
									<div class="small-6 columns">
										<?php echo getSlumpTypeName($order['slump_type_id']); ?>
									</div>
								</div>
							</div>
							<div class="myOrderInfoRow">
								<div class="row">
									<div class="small-6 columns">
										Захиалга гүйцэтгэх огноо
									</div>
									<div class="small-6 columns">
										<?php echo $order['order_date'].' / '.substr($order['order_time'],0,5); ?>
									</div>
								</div>
							</div>
							<div class="myOrderInfoRow">
								<div class="row">
									<div class="small-6 columns">
										Захиалга өгсөн огноо
									</div>
									<div class="small-6 columns">
										<?php echo substr($order['created'], 0, 10); ?>
									</div>
								</div>
							</div>
							<div class="myOrderInfoRow">
								<div class="row">
									<div class="small-6 columns">
										Нэмэлт тайлбар
									</div>
									<div class="small-6 columns">
										<?php echo $order['description']; ?>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</<a>
		</li>
	</ul>
	<ul class="accordion" data-accordion>
		<li class="accordion-navigation">
			<a href="#panel2a" class="orderInfoFullTitle">Захиалгын явц</a>
			<div id="panel2a" class="content active">
			<div class="row">
			<div class="small-12 columns">
				<div class="myOrderInfoRow">
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
				<div class="myOrderInfoRow">
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
			</div>
			</div>
		</li>
	</ul>
	<?php if($order['price'] != NULL) { ?>
	<ul class="accordion" data-accordion>
		<li class="accordion-navigation">
			<a href="#panel3a" class="orderInfoFullTitle">Төлбөрийн мэдээлэл</a>
			<div id="panel3a" class="content active">
			<div class="row">
			<div class="small-12 columns">
				<div class="myOrderInfoRow">
					<div class="row">
						<div class="small-6 columns">
							Олгосон гэрээний №
						</div>
						<div class="small-6 columns">
							<?php echo $order['agreement_id']; ?>
						</div>
					</div>
				</div>
				<div class="myOrderInfoRow">
					<div class="row">
						<div class="small-6 columns">
							Хэмжээ
						</div>
						<div class="small-6 columns">
							<?php echo $order['size1']; ?> м<sup>3</sup>
						</div>
					</div>
				</div>
				<div class="myOrderInfoRow">
					<div class="row">
						<div class="small-6 columns">
							Бүтээгдэхүүний үнэ (1м<sup>3</sup>)
						</div>
						<div class="small-6 columns">
							<?php echo $order['price']; ?>₮
						</div>
					</div>
				</div>
				<div class="myOrderInfoRow">
					<div class="row">
						<div class="small-6 columns">
							Нийт дүн
						</div>
						<div class="small-6 columns">
							<?php echo $order['total_price']; ?>₮
						</div>
					</div>
				</div>
				<div class="myOrderInfoRow">
					<div class="row">
						<div class="small-6 columns">
							Бартер
						</div>
						<div class="small-6 columns">
							<?php echo $order['barter']; ?>₮
						</div>
					</div>
				</div>
				<div class="myOrderInfoRow">
					<div class="row">
						<div class="small-6 columns">
							Төлсөн
						</div>
						<div class="small-6 columns">
							<?php echo $order['payment1']; ?>₮
						</div>
					</div>
				</div>
				<div class="myOrderInfoRow">
					<div class="row">
						<div class="small-6 columns">
							Төлбөрийн үлдэгдэл
						</div>
						<div class="small-6 columns">
							<?php echo $order['payment2']; ?>₮
						</div>
					</div>
				</div>
			</div>
			</div>
			</div>
		</li>
	</ul>
	<?php } ?>
	<?php if($order['quality_cert'] != NULL || $order['slump_img'] != NULL || $order['research_page'] != NULL || $order['concrete_reply7'] != NULL || $order['concrete_reply14'] != NULL || $order['concrete_reply28'] != NULL) { ?>
	<ul class="accordion" data-accordion>
		<li class="accordion-navigation">
			<a href="#panel4a" class="orderInfoFullTitle">Нэмэлт</a>
			<div id="panel4a" class="content active">
				<div class="row">
					<div class="small-12 columns">
					<?php if($order['quality_cert'] != NULL) { ?>
						<div class="myOrderInfoRow">
							<div class="row">
								<div class="small-6 columns">
									Чанарын гэрчилгээ
								</div>
								<div class="small-6 columns">
									<a href="<?php echo MAIN_FOLDER.'/quality_cert/'.$order['quality_cert']; ?>" target="_blank" class="downloadFile">Татах</a>
								</div>
							</div>
						</div>
					<?php } ?>
					<?php if($order['slump_img'] != NULL) { ?>
						<div class="myOrderInfoRow">
							<div class="row">
								<div class="small-6 columns">
									Талбайн слампын зураг
								</div>
								<div class="small-6 columns">
									<a href="<?php echo MAIN_FOLDER.'/slump_img/'.$order['slump_img']; ?>" target="_blank" class="downloadFile">Татах</a>
								</div>
							</div>
						</div>
					<?php } ?>
					<?php if($order['research_page'] != NULL) { ?>
						<div class="myOrderInfoRow">
							<div class="row">
								<div class="small-6 columns">
									Судалгааны хуудас
								</div>
								<div class="small-6 columns">
									<a href="<?php echo MAIN_FOLDER.'/research_page/'.$order['research_page']; ?>" target="_blank" class="downloadFile">Татах</a>
								</div>
							</div>
						</div>
					<?php } ?>
					<?php if($order['concrete_reply7'] != NULL) { ?>
						<div class="myOrderInfoRow">
							<div class="row">
								<div class="small-6 columns">
									Бетон шооны хариу /7 хоног - дотоод/
								</div>
								<div class="small-6 columns">
									<a href="<?php echo MAIN_FOLDER.'/concrete_reply7/'.$order['concrete_reply7']; ?>" target="_blank" class="downloadFile">Татах</a>
								</div>
							</div>
						</div>
					<?php } ?>
					<?php if($order['concrete_reply14'] != NULL) { ?>
						<div class="myOrderInfoRow">
							<div class="row">
								<div class="small-6 columns">
									Бетон шооны хариу /14 хоног - дотоод/
								</div>
								<div class="small-6 columns">
									<a href="<?php echo MAIN_FOLDER.'/concrete_reply14/'.$order['concrete_reply14']; ?>" target="_blank" class="downloadFile">Татах</a>
								</div>
							</div>
						</div>
					<?php } ?>
					<?php if($order['concrete_reply28'] != NULL) { ?>
						<div class="myOrderInfoRow">
							<div class="row">
								<div class="small-6 columns">
									Бетон шооны хариу /28 хоног - БАК-ын хариу/
								</div>
								<div class="small-6 columns">
									<a href="<?php echo MAIN_FOLDER.'/concrete_reply28/'.$order['concrete_reply28']; ?>" target="_blank" class="downloadFile">Татах</a>
								</div>
							</div>
						</div>
					<?php } ?>
					</div>
				</div>
			</div>
		</li>
	</ul>
	<?php } ?>
</div>


<?php
include(SITE_TEMPLATE."footer.php");
?>