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
				<th width="30%">Албан тушаалын нэгр</th>
				<th width="20%">Үүсгэсэн</th>
				<th width="20%">Засварласан</th>
				<th width="25%">
					
				</th>
			</tr>
			<?php
				$i = 0;
				foreach($data as $pos) :
				$i = $i + 1; 
			?>
			<tr>
				<td><?php echo $i; ?></td>
				<td><?php echo $pos['title']; ?></td>
				<td><?php echo $pos['created']; ?></td>
				<td><?php echo $pos['modified']; ?></td>
				<td>
					<a href="?action=edit&id=<?php echo $pos['id']; ?>" class="listBtn btnYellow"><i class="halflings-icon white edit"></i> Засварлах</a>
					<a href="?action=delete&id=<?php echo $pos['id']; ?>" class="listBtn btnRed" onclick="return confirm('<?php echo $pos['title']; ?> нэртэй албан тушаалыг устгах уу?');"><i class="halflings-icon white trash"></i> Устгах</a>
				</td>
			</tr>
			<?php endforeach; ?>
		</table>
	</div>
</div>

<?php 
	include(ADMIN_WEB_TEMPLATE. "layout/footer.php");
?>