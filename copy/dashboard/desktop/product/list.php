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
			<div class="medium-6 columns">
				<div data-alert class="infoAlert alert-box alert round">
  				<?php echo $result; ?>
  				<a href="#" class="close">&times;</a>
  				</div>
			</div>
		</div>
		<?php } ?>
		<div class="addBtn">
			<a href="?action=add">+ Нэмэх</a>
		</div>
		<table width="100%" class="mainTable">
			<tr>
				<th width="5%">№</th>
				<th width="25%">Бүтээгдэхүүний нэр</th>
				<th width="19%">Хамаарал</th>
				<th width="13%">Эрэмбэ</th>
				<th width="13%">Үүсгэсэн</th>
				<th width="25%">
					
				</th>
			</tr>
			<?php 
				$i = 0;
				foreach($dataParent as $dParent) : 
					$dataChilds = ProductType::getChildList($dParent['id']);
					if($dataChilds == NULL) {
						$i = $i + 1;
			?>
			<tr>
				<td><?php echo $i; ?></td>
				<td><?php echo $dParent['title']; ?></td>
				<td><?php echo $dParent['parent']; ?></td>
				<td><?php echo $dParent['queue']; ?></td>
				<td><?php echo $dParent['created']; ?></td>
				<td>
					<a href="?action=edit&id=<?php echo $dParent['id']; ?>" class="listBtn btnYellow"><i class="halflings-icon white edit"></i> Засварлах</a>
					<a href="?action=delete&id=<?php echo $dParent['id']; ?>" class="listBtn btnRed" onclick="return confirm('<?php echo $dParent['title']; ?> нэртэй бүтээгдэхүүнийг устгах уу?');"><i class="halflings-icon white trash"></i> Устгах</a>
				</td>
			</tr>
			<?php
					} else {
						$i = $i + 1;
			?>
			<tr>
				<td><?php echo $i; ?></td>
				<td><?php echo $dParent['title']; ?></td>
				<td><?php echo $dParent['parent']; ?></td>
				<td><?php echo $dParent['queue']; ?></td>
				<td><?php echo $dParent['created']; ?></td>
				<td>
					<a href="?action=edit&id=<?php echo $dParent['id']; ?>" class="listBtn btnYellow"><i class="halflings-icon white edit"></i> Засварлах</a>
					<a href="?action=delete&id=<?php echo $dParent['id']; ?>" class="listBtn btnRed" onclick="return confirm('<?php echo $dParent['title']; ?> нэртэй бүтээгдэхүүнийг устгах уу?');"><i class="halflings-icon white trash"></i> Устгах</a>
				</td>
			</tr>
			<?php
						foreach($dataChilds as $dChild) :
							$i = $i + 1;
			?>
			<tr>
				<td><?php echo $i; ?></td>
				<td><?php echo $dChild['title']; ?></td>
				<td><?php echo getProductName($dChild['parent']); ?></td>
				<td><?php echo $dChild['queue']; ?></td>
				<td><?php echo $dChild['created']; ?></td>
				<td>
					<a href="?action=edit&id=<?php echo $dChild['id']; ?>" class="listBtn btnYellow"><i class="halflings-icon white edit"></i> Засварлах</a>
					<a href="?action=delete&id=<?php echo $dChild['id']; ?>" class="listBtn btnRed" onclick="return confirm('<?php echo $dChild['title']; ?> нэртэй бүтээгдэхүүнийг устгах уу?');"><i class="halflings-icon white trash"></i> Устгах</a>
				</td>
			</tr>
			<?php
						endforeach;
					} 
				endforeach; 
			?>
		</table>
	</div>
</div>

<?php 
	include(ADMIN_WEB_TEMPLATE. "layout/footer.php");
?>