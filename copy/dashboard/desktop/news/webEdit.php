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
	<form action="?action=edit&id=<?php echo $current_news['id']; ?>" method="post" enctype="multipart/form-data">
		<input type="hidden" name="id" id="ID" value="<?php echo $current_news['id']; ?>" />
		<div class="inputRow">
			<div class="row">
				<div class="medium-8 columns">
					<label>Гарчиг
						<input type="text" name="title" id="Title" required="required" value="<?php echo $current_news['title']; ?>" />
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
							<option value="<?php echo $category['id']; ?>" <?php if($current_news['category_id'] == $category['id']){ echo 'selected'; } ?>><?php echo $category['title']; ?></option>
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
							<option value="1" <?php if($current_news['published'] == 1){ echo 'selected'; } ?>>Тийм</option>
							<option value="0" <?php if($current_news['published'] == 0){ echo 'selected'; } ?>>Үгүй</option>
						</select>
					</label>
				</div>
			</div>
		</div>
		<div class="inputRow">
			<div class="row">
				<div class="medium-8 columns">
					<label>Мэдээний текст
						<textarea id="Content" name="content" required="required"><?php echo $current_news['content']; ?></textarea>
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