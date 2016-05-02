<?php include(ADMIN_TEMPLATE."session_check.php"); ?>
<?php include(SITE_TEMPLATE. "header.php"); ?>
<div id="userPage">
	<div class="container">
		<div class="col-md-2">
		<?php require(SITE_TEMPLATE . "users/menu-left.php"); ?>
		</div>
		<div class="col-md-10">
			<h2 class="up-title">
				Миний илгээсэн санал хүсэлтийн хариу
			</h2>
			<div class="sanalView">
				<div class="row">
					<div class="col-md-7">
						<div class="sanalFull">
							<div class="sf-row">
								<span>Ангилал: </span><?php echo $sanal['type']; ?>
							</div>
							<div class="sf-row">
								<span>Илгээсэн огноо: </span><?php echo substr($sanal['created'], 0, 10); ?>
							</div>
							<div class="sf-to">
								<?php echo $sanal['district'].' дүүргийн '.$sanal['region'].'-р хороонд илгээсэн.'; ?>
							</div>
							<div class="sf-content">
								<div class="sf-title">Агуулга</div>
								<?php echo $sanal['content']; ?>
							</div>
							<div class="sf-download">
							<?php if($sanal['file'] != NULL) { ?>
								<a href="<?php echo MAIN_FOLDER.'/attachment/'.$sanal['file']; ?>">Хавсралт татах</a>
							<?php } ?>
							</div>
						</div>
					</div>
					<div class="col-md-5">
						<div class="reply-box">
							<div class="rb-from">
								<?php echo $sanal['district'].' дүүргийн '.$sanal['region'].'-р хорооноос ирүүлсэн хариу'; ?>
							</div>
							<div class="rb-content">
								<?php echo $reply['reply']; ?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php include(SITE_TEMPLATE. "footer.php"); ?>