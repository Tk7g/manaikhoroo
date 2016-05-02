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
					case 4:
				?>
					<div class="orderInfoBlock">
						<div class="orderInfoBlockTitle">
							Захиалгын явц
						</div>
						<div class="orderInfoBlockDetail">
							<div class="orderInfoBlockRow text-justify" style="border-top: none;">
								<span class="orderInfoFullStatusIcon" style="background: <?php echo getStatusColor($order['status']); ?>;"></span> - Захиалгыг үйлдвэрлэж эхлэхийг хүлээж байна.
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
							Захиалгыг үйлдвэрлэх
						</div>
						<div class="orderInfoBlockDetail">
							<form action="order.php?action=produce" method="post" enctype="multipart/form-data">
							<input type="hidden" name="id" value="<?php echo $_GET['id']; ?>" id="ID" />
							<div class="orderInfoBlockRow" style="border-bottom: none; border-top: none;">
								<div class="row">
									<div class="medium-12 columns">
										<label>Бетон цутгалтын төрөл</label>
										<select name="concrete_type_id" id="ConcreteTypeId" required="required">
											<option value="">Сонгоно уу</option>
											<?php foreach($concrete_types as $ctype) : ?>
											<option value="<?php echo $ctype['id']; ?>"><?php echo $ctype['title']; ?></option>
											<?php endforeach; ?>
											<option value="textOption">Бусад</option>
										</select>
        								<input id="ConcreteTypeText" type="text" name="concrete_type_text" style="display: none;" placeholder="Энд бичнэ үү" />
        								<div class="text-center">
        								<button type="submit" name="saveOrder" class="infoFormSubmit">Үйлдвэрлэж эхлэх</button>
        								</div>
									</div>
								</div>
							</div>
							</form>
						</div>
					</div>
<script>
    $(document).ready( function() {
      $('#ConcreteTypeId').bind('change', function (e) { 
        if( $('#ConcreteTypeId').val() == 'textOption') {
          $('#ConcreteTypeText').show();
    	  $("#ConcreteTypeText").attr('required', 'required');
        } else {
          $('#ConcreteTypeText').hide();
    	  $('#ConcreteTypeText').removeAttr('required');
        }         
      }).trigger('change');
    });						
</script>
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
							Үйлдвэрлэлийн явц шинэчлэх
						</div>
						<div class="orderInfoBlockDetail">
							<form action="order.php?action=progressUpdate" method="post" enctype="multipart/form-data">
							<input type="hidden" name="id" value="<?php echo $_GET['id']; ?>" id="ID" />
							<div class="orderInfoBlockRow" style="border-bottom: none; border-top: none;">
								<div class="row">
									<div class="medium-12 columns">
										<label>Үйлдвэрлэсэн хэмжээ (м<sup>3</sup>)</label>
        								<input type="text" name="produced" <?php echo 'value="'.$order['produced'].'"'; ?> id="Produced" required="required" />
        								<label>Үйлдвэрлэлийн явцын тайлбар</label>
        								<textarea id="FactoryDesc" name="factory_desc"><?php if($order['factory_desc'] != NULL) { echo $order['factory_desc']; } ?></textarea>
        								<div class="text-center">
        									<button type="submit" name="saveOrder" class="infoFormSubmit">Явцыг шинэчлэх</button>
        								</div>
									</div>
								</div>
							</div>
							</form>
						</div>
						<div class="orderInfoBlockTitle">
							Үйлдвэрлэлийг дуусгах
						</div>
						<div class="orderInfoBlockDetail">
							<form action="order.php?action=progressFinish" method="post" enctype="multipart/form-data">
							<input type="hidden" name="id" value="<?php echo $_GET['id']; ?>" id="ID" />
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
										<div class="orderInfoBlockRow" style="border-top: none;">
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
										<div class="orderInfoBlockRow" style="border-top: none;">
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
        								<input type="file" name="concrete_reply7">
										<?php } else { ?>
										<div class="orderInfoBlockRow" style="border-top: none;">
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
        								<input type="file" name="concrete_reply14">
										<?php } else { ?>
										<div class="orderInfoBlockRow" style="border-top: none;">
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
        								<input type="file" name="concrete_reply28">
										<?php } else { ?>
										<div class="orderInfoBlockRow" style="border-top: none;">
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
        								<div class="text-center">
        									<button type="submit" name="saveOrder" class="infoFormSubmit">Үйлдвэрлэлийг дуусгах</button>
        								</div>
							</form>
						</div>
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
							Үйлдвэрлэлийг дуусгах
						</div>
						<div class="orderInfoBlockDetail">
							<form action="order.php?action=progressFinish" method="post" enctype="multipart/form-data">
							<input type="hidden" name="id" value="<?php echo $_GET['id']; ?>" id="ID" />
										<?php if($order['quality_cert'] == NULL) { ?>
										<label>Чанарын гэрчилгээ (файл)</label>
        								<input type="file" required="required" name="quality_cert">
										<?php } else { ?>
										<div class="orderInfoBlockRow" style="border-top: none;">
											<div class="row">
												<div class="medium-6 columns">
												Чанарын гэрчилгээ
												</div>
												<div class="medium-3 columns text-right">
													<a href="order.php?action=fileRemoveFactory&id=<?php echo $_GET['id']; ?>&folder=quality_cert" class="fileRemove">Устгах</a>
												</div>
												<div class="medium-3 columns text-right">
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
												<div class="medium-3 columns text-right">
													<a href="order.php?action=fileRemoveFactory&id=<?php echo $_GET['id']; ?>&folder=slump_img" class="fileRemove">Устгах</a>
												</div>
												<div class="medium-3 columns text-right">
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
												<div class="medium-3 columns text-right">
													<a href="order.php?action=fileRemoveFactory&id=<?php echo $_GET['id']; ?>&folder=research_page" class="fileRemove">Устгах</a>
												</div>
												<div class="medium-3 columns text-right">
												<a href="<?php echo MAIN_FOLDER.'/research_page/'.$order['research_page']; ?>" target="_blank" class="fileDownload"">Татах</a>
												</div>
											</div>
										</div>
										<?php } ?>
										<?php if($order['concrete_reply7'] == NULL) { ?>
										<label>Бетон шооны хариу /7 хоног - дотоод/ (файл)</label>
        								<input type="file" name="concrete_reply7">
										<?php } else { ?>
										<div class="orderInfoBlockRow">
											<div class="row">
												<div class="medium-6 columns">
												Бетон шооны хариу /7 хоног - дотоод/ (файл)
												</div>
												<div class="medium-3 columns text-right">
													<a href="order.php?action=fileRemoveFactory&id=<?php echo $_GET['id']; ?>&folder=concrete_reply7" class="fileRemove">Устгах</a>
												</div>
												<div class="medium-3 columns text-right">
												<a href="<?php echo MAIN_FOLDER.'/concrete_reply7/'.$order['concrete_reply7']; ?>" target="_blank" class="fileDownload"">Татах</a>
												</div>
											</div>
										</div>
										<?php } ?>
										<?php if($order['concrete_reply14'] == NULL) { ?>
										<label>Бетон шооны хариу /14 хоног - дотоод/ (файл)</label>
        								<input type="file" name="concrete_reply14">
										<?php } else { ?>
										<div class="orderInfoBlockRow">
											<div class="row">
												<div class="medium-6 columns">
												Бетон шооны хариу /14 хоног - дотоод/ (файл)
												</div>
												<div class="medium-3 columns text-right">
													<a href="order.php?action=fileRemoveFactory&id=<?php echo $_GET['id']; ?>&folder=concrete_reply14" class="fileRemove">Устгах</a>
												</div>
												<div class="medium-3 columns text-right">
												<a href="<?php echo MAIN_FOLDER.'/concrete_reply14/'.$order['concrete_reply14']; ?>" target="_blank" class="fileDownload"">Татах</a>
												</div>
											</div>
										</div>
										<?php } ?>
										<?php if($order['concrete_reply28'] == NULL) { ?>
										<label>Бетон шооны хариу /28 хоног - БАК-ын хариу/ (файл)</label>
        								<input type="file" name="concrete_reply28">
										<?php } else { ?>
										<div class="orderInfoBlockRow" style="border-bottom: none;">
											<div class="row">
												<div class="medium-6 columns">
												Бетон шооны хариу /28 хоног - БАК-ын хариу/ (файл)
												</div>
												<div class="medium-3 columns text-right">
													<a href="order.php?action=fileRemoveFactory&id=<?php echo $_GET['id']; ?>&folder=concrete_reply28" class="fileRemove">Устгах</a>
												</div>
												<div class="medium-3 columns text-right">
												<a href="<?php echo MAIN_FOLDER.'/concrete_reply28/'.$order['concrete_reply28']; ?>" target="_blank" class="fileDownload"">Татах</a>
												</div>
											</div>
										</div>
										<?php } ?>
										<?php if($order['quality_cert'] != NULL && $order['slump_img'] != NULL && $order['research_page'] != NULL && $order['concrete_reply7'] != NULL && $order['concrete_reply14'] != NULL && $order['concrete_reply28'] != NULL) { ?>
										
    									<?php } else { ?>
        								<div class="text-center">
        									<button type="submit" name="saveOrder" class="infoFormSubmit">Хадгалах</button>
        								</div>
        								<?php } ?>
							</form>
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