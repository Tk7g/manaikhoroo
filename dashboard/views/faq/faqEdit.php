<?php include(MAIN_TEMPLATE. "header.php"); ?>
<?php include(ADMIN_TEMPLATE. "session_check.php"); ?>
<ul class="breadcrumb">
	<li>
		<i class="icon-home"></i>
			<a href="/dashboard/">Эхлэл</a> 
		<i class="icon-angle-right"></i>
	</li>
	<li>
		<a href="/dashboard/">Хэрэгэлгчийн зааврын жагсаалт</a>
		<i class="icon-angle-right"></i>
	</li>
</ul>

<div class="row-fluid sortable">
	<div class="box span11">
		<div class="box-header" data-original-title>
			<h2><i class="halflings-icon edit"></i><span class="break"></span>Заавар засварлах</h2>
			<div class="box-icon">
				<a href="#" class="btn-minimize"><i class="halflings-icon chevron-up"></i></a>
			</div>
		</div>
		<div class="box-content">
			<form action="faq.php?action=edit" method="post">
			<input type="hidden" name="id" value="<?php echo $current_faq['id']; ?>" id="NewsId">
			<fieldset>
				<div class="control-group">
					<label class="control-label" for="title">Гарчиг</label>
					<div class="controls">
						<input type="text" name="title" id="NewsTitle" required="required" value="<?php echo $current_faq['title']; ?>" class="input-xlarge"/>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="content">Мэдээний текст</label>
					<div class="controls">
						<textarea class="cleditor" name="content" id="NewsContent">
						<?php echo $current_faq['content']; ?>
						</textarea>
					</div>
				</div>
			</fieldset>
			<div class="form-actions">
				<button type="submit" name="saveFaq" class="btn btn-primary">Хадгалах</button>
			</div>
			</form>
		</div>
	</div>
</div>

<?php include(MAIN_TEMPLATE. "footer.php"); ?>