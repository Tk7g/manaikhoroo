<?php include(ADMIN_TEMPLATE. "template/header.php"); ?>
<?php include(ADMIN_TEMPLATE. "session_check.php"); ?>

<div id="command-block">
	<div class="row">
		<div class="small-6 columns">
			<a href="user.php?action=add" class="button tiny"><i class="fa fa-plus"></i> Шинээр нэмэх</a>
		</div>
	</div>
</div>
<div class="row">
	<div class="small-12 columns">
		<?php if ( isset( $result ) ) { ?>
       		<div class="alert-box"><?php echo $result; ?><a href="#" class="close">&times;</a></div>
		<?php } ?>	
	</div>
</div>
<div id="listTable">
	<table width="100%" class="tablelist">
		<tr class="info-row">
			<th width="10%">№</th>
			<th width="30%">Хэрэглэчийн нэр</th>
			<th width="30%">Бүлэг</th>
			<th width="12%"></th>
			<th width="12%"></th>
		</tr>
		<?php
			$i = 0; 
			foreach($users as $user) : 
			$i = $i + 1;
		?>
		<tr class="info-row">
			<td><?php echo $i; ?></td>
			<td><?php echo $user['username']; ?></td>
			<td><?php echo getUserGroupName($user['group_id']); ?></td>
			<td>
				<a href="user.php?action=edit&id=<?php echo $user['id']; ?>" style="padding: 5px;" class="button success tiny">Засах</a>
			</td>
			<td>
				<a href="user.php?action=delete&id=<?php echo $user['id']; ?>" onclick="return confirm('<?php echo $user['username']; ?> хэрэглэгчийг устгах уу?');" style="padding: 5px;" class="button alert tiny">Устгах</a>
			</td>
		</tr>
		<?php endforeach; ?>
	</table>
</div>
<div id="page-block">
	<div class="row">
		<div class="small-12 columns">
		<?php for($i=1; $i<=$total_pagination; $i++) { ?>
			<a class="pagination-link" href="company.php?page=<?php echo $i; ?>"><?php echo $i; ?></a>
		<?php } ?>
		</div>
	</div>
</div>

<?php include(ADMIN_TEMPLATE. "template/footer.php"); ?>