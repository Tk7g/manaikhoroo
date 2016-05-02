<?php include(MAIN_TEMPLATE. "header.php"); ?>
<?php include(ADMIN_TEMPLATE. "session_check.php"); ?>
<ul class="breadcrumb">
	<li>
		<i class="icon-home"></i>
			<a href="/dashboard/">Эхлэл</a> 
		<i class="icon-angle-right"></i>
	</li>
	<li>
		<a href="/dashboard/infos.php">Тоон мэдээлэл</a>
		<i class="icon-angle-right"></i>
	</li>
	<li>
		<a href="/dashboard/infos.php?action=add">Тоон мэдээ засварлах /<?php echo $districtHeader['title'].' дүүргийн '.$regionHeader['title'].'-р хороо'; ?>/</a>
	</li>
</ul>

<div class="row-fluid sortable">
	<div class="box span11">
		<div class="box-header" data-original-title>
			<h2><i class="halflings-icon edit"></i><span class="break"></span>Тоон мэдээ засварлах /<?php echo $districtHeader['title'].' дүүргийн '.$regionHeader['title'].'-р хороо'; ?>/</h2>
			<div class="box-icon">
				<a href="#" class="btn-minimize"><i class="halflings-icon chevron-up"></i></a>
			</div>
		</div>
		<div class="box-content">
			<form action="infos.php?action=edit&id=<?php echo $info['id']; ?>" method="post">
			<fieldset>
				<input type="hidden" name="id" value="<?php echo $info['id']; ?>"/>
				<div class="control-group">
					<label class="control-label" for="SectionId">Мэдээллийн он</label>
					<div class="controls">
						<select name="year" id="Year" required="required">
							<?php for($y = 2015; $y <= date('Y'); $y++) { ?>
							<option value="<?php echo $y; ?>" <?php if($y == $info['year']){ echo 'selected'; } ?>><?php echo $y; ?></option>
							<?php } ?>
						</select>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="SectionId">Хэсгийн дугаар</label>
					<div class="controls">
						<select name="section_id" id="SectionId" required="required">
							<option value="0">Сонгоно уу</option>
							<?php
								$checkSectionTitle = NULL;
								foreach($sections as $sec) : 
									if($checkSectionTitle == NULL) {
										$checkSectionTitle = $sec['title'];
							?>
								<option <?php if($info['section_id'] == $sec['title']) { echo 'selected'; } ?> value="<?php echo $sec['title']; ?>"><?php echo $sec['title'].'-р хэсэг'; ?></option>
							<?php
									} else {
										if($sec['title'] != $checkSectionTitle) {
											$checkSectionTitle = $sec['title'];
							?>
								<option <?php if($info['section_id'] == $sec['title']) { echo 'selected'; } ?> value="<?php echo $sec['title']; ?>"><?php echo $sec['title'].'-р хэсэг'; ?></option>
							<?php
										}	
									}
								endforeach;
							?>
							<?php foreach($sections as $sec) : ?>
								
							<?php endforeach; ?>
						</select>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="population">Нийт хүн ам</label>
					<div class="controls">
						<input type="text" name="population" value="<?php echo $info['population']; ?>" required="required" class="input-xlarge"/>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="household">Нийт өрхийн тоо</label>
					<div class="controls">
						<input type="text" name="household" value="<?php echo $info['household']; ?>" required="required" class="input-xlarge"/>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="bus_density">Автобусны буудлаас 5 мин алхах зайд амьдардаг хүн амын %</label>
					<div class="controls">
						<input type="text" name="bus_density" value="<?php echo $info['bus_density']; ?>" required="required" class="input-xlarge"/>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="well_density">Усны худгаас 5 минут алхах зайд амьдардаг хүн амын %</label>
					<div class="controls">
						<input type="text" name="well_density" value="<?php echo $info['well_density']; ?>" required="required" class="input-xlarge"/>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="risk_ratio">Аюултай бүсээс 100 м зайнд амьдардаг хүн амын %</label>
					<div class="controls">
						<input type="text" name="risk_ratio" value="<?php echo $info['risk_ratio']; ?>" required="required" class="input-xlarge"/>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="tot_kinnum">2-5 насны хүүхдийн тоо</label>
					<div class="controls">
						<input type="text" name="tot_kinnum" required="required" value="<?php echo $info['tot_kinnum']; ?>" class="input-xlarge"/>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="kin_num">2-5 насны цэцэрлэгт хамрагддаггүй хүүхдийн тоо</label>
					<div class="controls">
						<input type="text" name="kin_num" required="required" value="<?php echo $info['kin_num']; ?>" class="input-xlarge"/>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="tot_schoolnum">6-16 насны хүүхдийн тоо</label>
					<div class="controls">
						<input type="text" name="tot_schoolnum" required="required" value="<?php echo $info['tot_schoolnum']; ?>" class="input-xlarge"/>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="school_num">6-16 насны сургуульд хамрагддаггүй хүүхдийн тоо</label>
					<div class="controls">
						<input type="text" name="school_num" required="required" value="<?php echo $info['school_num']; ?>" class="input-xlarge"/>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="trash_collect">Хогийн цэгийн хог ачих давтамж /сард ? удаа/</label>
					<div class="controls">
						<input type="text" name="trash_collect" required="required" value="<?php echo $info['trash_collect']; ?>" class="input-xlarge"/>
					</div>
				</div>
			</fieldset>
			<div class="form-actions">
				<button type="submit" name="saveInfo" class="btn btn-primary">Хадгалах</button>
			</div>
			</form>
		</div>
	</div>
</div>

<?php include(MAIN_TEMPLATE. "footer.php"); ?>