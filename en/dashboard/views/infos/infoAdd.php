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
		<a href="/dashboard/infos.php?action=add">Тоон мэдээ нэмэх</a>
	</li>
</ul>

<div class="row-fluid sortable">
	<div class="box span11">
		<div class="box-header" data-original-title>
			<h2><i class="halflings-icon edit"></i><span class="break"></span>Тоон мэдээ нэмэх</h2>
			<div class="box-icon">
				<a href="#" class="btn-minimize"><i class="halflings-icon chevron-up"></i></a>
			</div>
		</div>
		<div class="box-content">
			<form action="infos.php?action=add" method="post">
			<fieldset>
				<div class="control-group">
					<label class="control-label" for="Year">Он</label>
					<div class="controls">
						<select name="year" id="Year" required="required">
							<option value="">Сонгоно уу</option>
							<option value="2013">2013</option>
							<option value="2014">2014</option>
							<option value="2015">2015</option>
						</select>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="SectionId">Хэсгийн дугаар</label>
					<div class="controls">
						<select name="section_id" id="SectionId">
							<option value="0">Сонгоно уу</option>
							<?php
								$checkSectionTitle = NULL;
								foreach($sections as $sec) : 
									if($checkSectionTitle == NULL) {
										$checkSectionTitle = $sec['title'];
							?>
								<option value="<?php echo $sec['title']; ?>"><?php echo $sec['title'].'-р хэсэг'; ?></option>
							<?php
									} else {
										if($sec['title'] != $checkSectionTitle) {
											$checkSectionTitle = $sec['title'];
							?>
								<option value="<?php echo $sec['title']; ?>"><?php echo $sec['title'].'-р хэсэг'; ?></option>
							<?php
										}	
									}
								endforeach;
							?>
						</select>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="population">Нийт хүн ам</label>
					<div class="controls">
						<input type="text" name="population" required="required" class="input-xlarge"/>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="household">Нийт өрхийн тоо</label>
					<div class="controls">
						<input type="text" name="household" required="required" class="input-xlarge"/>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="area_length">Нийт газар нутгийн хэмжээ</label>
					<div class="controls">
						<input type="text" name="area_length" required="required" class="input-xlarge"/>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="bus_density">Автобусны буудлаас 5 мин алхах зайд амьдардаг хүн амын %</label>
					<div class="controls">
						<input type="text" name="bus_density" required="required" class="input-xlarge"/>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="toron_garts">Авто замын гарц гаргах боломжит газар (м)</label>
					<div class="controls">
						<input type="text" name="toron_garts" required="required" class="input-xlarge"/>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="well_density">Усны худгаас 5 минут алхах зайд амьдардаг хүн амын %</label>
					<div class="controls">
						<input type="text" name="well_density" required="required" class="input-xlarge"/>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="risk_ratio">Аюултай бүсийн талбай (м<sup>2</sup>)</label>
					<div class="controls">
						<input type="text" name="risk_area" required="required" class="input-xlarge"/>
					</div>
				</div>
				<!--<div class="control-group">
					<label class="control-label" for="risk_ratio">Аюултай бүсээс 100 м зайнд амьдардаг хүн амын %</label>
					<div class="controls">
						<input type="text" name="risk_ratio" required="required" class="input-xlarge"/>
					</div>
				</div>-->
				<div class="control-group">
					<label class="control-label" for="tot_kinnum">2-5 насны хүүхдийн тоо</label>
					<div class="controls">
						<input type="text" name="tot_kinnum" required="required" class="input-xlarge"/>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="kin_num">2-5 насны цэцэрлэгт хамрагддаггүй хүүхдийн тоо</label>
					<div class="controls">
						<input type="text" name="kin_num" required="required" class="input-xlarge"/>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="tot_schoolnum">6-16 насны хүүхдийн тоо</label>
					<div class="controls">
						<input type="text" name="tot_schoolnum" required="required" class="input-xlarge"/>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="school_num">6-16 насны сургуульд хамрагддаггүй хүүхдийн тоо</label>
					<div class="controls">
						<input type="text" name="school_num" required="required" class="input-xlarge"/>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="pale_ground">Сул шороон хөрстэй талбай /м<sup>2</sup>/</label>
					<div class="controls">
						<input type="text" name="pale_ground" required="required" class="input-xlarge"/>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="trash_collect">Хогийн цэгийн хог ачих давтамж /сард ? удаа/</label>
					<div class="controls">
						<input type="text" name="trash_collect" required="required" class="input-xlarge"/>
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