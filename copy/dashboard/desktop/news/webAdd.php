<?php 
	include(ADMIN_WEB_TEMPLATE. "layout/header.php");
	include(ADMIN_TEMPLATE. "session_check.php");
?>

<div id="mainComponent">
	<div class="mainTitle">
		<?php echo $page_title; ?>
	</div>
	<div class="mainWrapper">
	<div class="contentForm">
	<form action="?action=add" method="post" enctype="multipart/form-data">
		<div class="inputRow">
			<div class="row">
				<div class="medium-8 columns">
					<label>Гарчиг
						<input type="text" name="title" id="Title" required="required" />
					</label>
				</div>
			</div>
		</div>
		<div class="inputRow">
			<div class="row">
				<div class="medium-8 columns">
					<label>Категори
						<select name="category_id" id="categoryId" required="required">
							<option value="">Сонгоно уу</option>
							<?php foreach($categories as $category) : ?>
							<option value="<?php echo $category['id']; ?>"><?php echo $category['title']; ?></option>
							<?php endforeach; ?>
						</select>
					</label>
				</div>
			</div>
		</div>
		<div class="inputRow">
			<div class="row">
				<div class="medium-3 columns">
					<label>Нийтлэх
						<select name="published" id="Published" required="required">
							<option value="1">Тийм</option>
							<option value="0">Үгүй</option>
						</select>
					</label>
				</div>
			</div>
		</div>
		<div class="inputRow">
			<div class="row">
				<div class="medium-8 columns">
					<label>Мэдээний текст
						<textarea id="Content" name="content" required="required"></textarea>
					</label>
				</div>
			</div>
		</div>
		<div class="inputRow">
			<div class="row">
				<div class="medium-8 columns">
					<button type="submit" name="saveNews" class="saveBtn">Хадгалах</button>
				</div>
			</div>
		</div>
	</form>
	</div>
	</div>
</div>
<script>
	CKEDITOR.replace( 'Content' );
</script>
<?php 
	include(ADMIN_WEB_TEMPLATE. "layout/footer.php");
?>