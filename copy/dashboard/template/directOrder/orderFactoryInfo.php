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
				case 4:
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
										<span class="orderInfoFullStatusIcon" style="background: <?php echo getStatusColor($order['status']); ?>;"></span> - Захиалгыг үйлдвэрлэж эхлэхийг хүлээж байна.
									</div>
								</div>
							</div>
							<div class="orderInfoFullRow">
								<div class="row">
									<div class="small-6 columns orderInfoFullLabel">
										Нэмэлт тайлбар
									</div>
									<div class="small-6 columns text-right orderInfoFullInfo">
										<?php echo $order['director_desc']; ?>
									</div>
								</div>
							</div>
						</div>
					</li>
					<li class="accordion-navigation">
						<a href="#panel2a" class="orderInfoFullTitle">Захиалгыг үйлдвэрлэх</a>
						<div id="panel2a" class="content">
							<div class="row">
								<div class="small-12 columns">
									<form action="directOrder.php?action=produce" method="post" enctype="multipart/form-data">
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
									<div class="small-6 columns orderInfoFullLabel">
										Нэмэлт тайлбар
									</div>
									<div class="small-6 columns text-right orderInfoFullInfo">
										<?php echo $order['director_desc']; ?>
									</div>
								</div>
							</div>
						</div>
					</li>
					<li class="accordion-navigation">
						<a href="#panel2a" class="orderInfoFullTitle">Үйлдвэрлэлийн явц</a>
						<div id="panel2a" class="content">
							<div class="row">
								<div class="small-12 columns">
									<div class="progress small-12 factory radius round">
  										<span class="meter" style="width: <?php echo ($order['produced']*100)/$order['size1']; ?>%">
  											<div class="factoryProgress" <?php if($order['factory_progress'] == 0 || $order['factory_progress'] == NULL) { echo 'style="color: #000;"'; } ?>>
  											<?php echo round(($order['produced']*100)/$order['size1']); ?>%
  											</div>
  										</span>
									</div>
									<form action="directOrder.php?action=progressUpdate" method="post" enctype="multipart/form-data">
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
						<a href="#panel3a" class="orderInfoFullTitle">Үйлдвэрлэлийг дуусгах</a>
						<div id="panel3a" class="content">
							<div class="row">
								<div class="small-12 columns">
									<form action="directOrder.php?action=progressFinish" method="post" enctype="multipart/form-data">
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
									<div class="small-6 columns orderInfoFullLabel">
										Нэмэлт тайлбар
									</div>
									<div class="small-6 columns text-right orderInfoFullInfo">
										<?php echo $order['director_desc']; ?>
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
						<a href="#panel2a" class="orderInfoFullTitle">Нэмэлт файлууд</a>
						<div id="panel2a" class="content">
							<div class="row">
								<div class="small-12 columns">
									<form action="directOrder.php?action=progressFinish" method="post" enctype="multipart/form-data">
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
        												<input type="file" required="required" name="concrete_reply7">
      												</label>
												</div>
											</div>
										</div>
										<?php } else { ?>
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
										<?php if($order['concrete_reply14'] == NULL) { ?>
										<div class="orderInfoFormRow">
											<div class="row">
												<div class="small-12 columns">
													<label>Бетон шооны хариу /14 хоног - дотоод/ (файл)
        												<input type="file" required="required" name="concrete_reply14">
      												</label>
												</div>
											</div>
										</div>
										<?php } else { ?>
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
										<?php if($order['concrete_reply28'] == NULL) { ?>
										<div class="orderInfoFormRow">
											<div class="row">
												<div class="small-12 columns">
													<label>Бетон шооны хариу /28 хоног - БАК-ын хариу/ (файл)
        												<input type="file" required="required" name="concrete_reply7">
      												</label>
												</div>
											</div>
										</div>
										<?php } else { ?>
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
										<?php if($order['quality_cert'] != NULL && $order['slump_img'] != NULL && $order['research_page'] != NULL && $order['concrete_reply7'] != NULL && $order['concrete_reply14'] != NULL && $order['concrete_reply28'] != NULL) { ?>
										
    									<?php } else { ?>
    									<div class="row">
    										<div class="small-10 small-centered columns text-center">
    											<button type="submit" name="saveOrder" class="button expand">Файл шинэчлэх</button>
    										</div>
    									</div>
    									<?php } ?>
									</form>
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