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
				<th width="25%">Хэрэглэгчийн нэр</th>
				<th width="25%">Хэрэглэгчийн бүлэг</th>
				<th width="20%">Үүсгэсэн</th>
				<th width="25%">
					
				</th>
			</tr>
			<?php 
				if(isset($_GET['page'])) {
					$i = ($_GET['page'] - 1)*10;
				} else {
					$i = 0; 	
				}
				foreach($users as $user) : 
				$i = $i + 1;
			?>
			<tr>
				<td><?php echo $i; ?></td>
				<td><?php echo $user['username']; ?></td>
				<td><?php echo getUserGroupName($user['group_id']); ?></td>
				<td><?php echo $user['created']; ?></td>
				<td>
					<a href="?action=edit&id=<?php echo $user['id']; ?>" class="listBtn btnYellow"><i class="halflings-icon white edit"></i> Засварлах</a>
					<a href="?action=delete&id=<?php echo $user['id']; ?>" class="listBtn btnRed" onclick="return confirm('<?php echo $user['username']; ?>-ийн мэдээллийг устгах уу?');"><i class="halflings-icon white trash"></i> Устгах</a>
				</td>
			</tr>
			<?php endforeach; ?>
		</table>
		<div id="paginationBlock">
			<?php for($i=1; $i<=$total_pagination; $i++) { ?>
			<a class="paginationLink" href="user.php?page=<?php echo $i; ?>"><?php echo $i; ?></a>
			<?php } ?>
		</div>
	</div>
</div>

<?php 
	include(ADMIN_WEB_TEMPLATE. "layout/footer.php");
?>