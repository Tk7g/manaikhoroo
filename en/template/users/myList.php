<?php 
include(ADMIN_TEMPLATE."session_check.php"); 
include(SITE_TEMPLATE. "header.php");
?>
<div id="userPage">
	<div class="container">
		<div class="col-md-2">
		<?php require(SITE_TEMPLATE . "users/menu-left.php"); ?>
		</div>
		<div class="col-md-10">
			<h2 class="up-title">
				Миний илгээсэн санал хүсэлт
			</h2>
			<div class="sanalList">
				<table width="100%">
					<tr>
						<th width="5%">№</th>
						<th width="15%">Ангилал</th>
						<th width="40%">Агуулга</th>
						<th width="13%">Илгээсэн огноо</th>
						<th width="12%">Хавсралт</th>
						<th width="15%">Хариу</th>
					</tr>
					<?php
						$i = 0; 
						foreach($results as $sanal) : 
						$i = $i + 1;
					?>
					<tr>
						<td class="text-center"><?php echo $i; ?></td>
						<td class="text-center"><?php echo $sanal['type']; ?></td>
						<td><?php echo substr($sanal['content'], 0, 250); ?></td>
						<td><?php echo $sanal['created']; ?></td>
						<td class="text-center">
						<?php if($sanal['file'] != NULL) { ?>
							<a class="file-download" href="<?php echo MAIN_FOLDER.'/attachment/'.$sanal['file']; ?>" target="_blank"><i class="glyphicon glyphicon-download-alt"></i> Файл татах</a>
						<?php } else { ?>
							<i class="glyphicon glyphicon-remove"></i>
						<?php } ?>
						</td>
						<td class="text-center">
						<?php 
							$check_reply = Sanal::mySanalReply($sanal['id']);
							if($check_reply == NULL) {
						?>
							<i class="glyphicon glyphicon-remove"></i>
						<?php } else { ?>
							<a href="user.php?page=viewReply&id=<?php echo $sanal['id']; ?>" class="reply-link">Хариу харах</a>
						<?php } ?>
						</td>
					</tr>
					<?php endforeach; ?>
				</table>
			</div>
		</div>
	</div>
</div>
<?php include(SITE_TEMPLATE. "footer.php"); ?>