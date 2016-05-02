<?php include(MAIN_TEMPLATE. "header.php"); ?>
<?php include(ADMIN_TEMPLATE."session_check.php"); ?>
<ul class="breadcrumb">
	<li>
		<i class="icon-home"></i>
			<a href="/dashboard/">Эхлэл</a>
		<i class="icon-angle-right"></i>
	</li>
	<li>
		<a href="/dashboard/markers.php">Зурган тэмдэглэгээ</a>
		<i class="icon-angle-right"></i>
	</li>
	<li>
		<a href="/dashboard/markers.php?action=select">
			Тэмдэглэгээ 
			<?php 
				if($_GET['action'] == 'delselect') { 
					echo 'устгах';
				} else {
					echo 'нэмэх';
				}
			?>
		</a>
	</li>
</ul>

<div class="row-fluid sortable">
	<div class="box span11">
		<div class="box-header" data-original-title>
			<h2>
				<i class="halflings-icon edit"></i><span class="break"></span><?php echo $results['district']['title'].' дүүргийн зурган тэмдэглэгээ '; ?>
				<?php 
				if($_GET['action'] == 'delselect') { 
					echo 'устгах';
				} else {
					echo 'нэмэх';
				}
				?>
			</h2>
			<div class="box-icon">
				<a href="#" class="btn-minimize"><i class="halflings-icon chevron-up"></i></a>
			</div>
		</div>
		<div class="box-content">
			<?php if($_GET['action'] == 'select') { ?>
			<form action="markers.php?action=select" id="" method="post">
			<?php } elseif($_GET['action'] == 'delselect') { ?>
			<form action="markers.php?action=delselect" id="" method="post">
			<?php } ?>
			<fieldset>
				<div class="control-group">
					<label class="control-label" for="MarkerType">Тэмдэглэгээний төрөл</label>
					<div class="controls">
						<select name="type_id" id="TypeId" required="required">
							<option value="">Сонгоно уу</option>
							<?php foreach($results['types'] as $type) : ?>
							<option value="<?php echo $type['id'] ?>"><?php echo $type['title']; ?></option>
							<?php endforeach; ?>
						</select>
					</div>
				</div>
			</fieldset>
			<div class="form-actions">
				<button type="submit" name="selectType" class="btn btn-primary">Үргэлжлүүлэх</button>
			</div>
			</form>
		</div>
	</div>
</div>

<?php include(MAIN_TEMPLATE. "footer.php"); ?>