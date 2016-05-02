<?php include(MAIN_TEMPLATE. "header.php"); ?>
<?php include(ADMIN_TEMPLATE. "session_check.php"); ?>
<script src="<?php echo MAIN_FOLDER.'/js/ckeditor/ckeditor.js'; ?>"></script>
<ul class="breadcrumb">
	<li>
		<i class="icon-home"></i>
			<a href="/dashboard/">Эхлэл</a> 
		<i class="icon-angle-right"></i>
	</li>
	<li>
		<a href="/dashboard/">Мэдээний жагсаалт</a>
		<i class="icon-angle-right"></i>
	</li>
	<li>
		<a href="/dashboard/articles.php?action=add">Мэдээ нэмэх</a>
	</li>
</ul>

<div class="row-fluid sortable">
	<div class="box span11">
		<div class="box-header" data-original-title>
			<h2><i class="halflings-icon edit"></i><span class="break"></span>Мэдээ нэмэх</h2>
			<div class="box-icon">
				<a href="#" class="btn-minimize"><i class="halflings-icon chevron-up"></i></a>
			</div>
		</div>
		<div class="box-content">
			<form action="articles.php?action=add" method="post">
			<fieldset>
				<div class="control-group">
					<label class="control-label" for="title">Гарчиг</label>
					<div class="controls">
						<input type="text" name="title" id="NewsTitle" required="required" class="input-xlarge"/>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="content">Мэдээний текст</label>
					<div class="controls">
						<textarea rows="10" cols="80" name="content" id="NewsContent"></textarea>
					</div>
				</div>
			</fieldset>
			<div class="form-actions">
				<button type="submit" name="saveNews" class="btn btn-primary">Хадгалах</button>
			</div>
			</form>
		</div>
	</div>
</div>
<script>
	// Replace the <textarea id="editor1"> with a CKEditor
	// instance, using default configuration.
	CKEDITOR.replace( 'NewsContent' );
</script>

<?php include(MAIN_TEMPLATE. "footer.php"); ?>