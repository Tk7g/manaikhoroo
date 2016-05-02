<?php include(MAIN_TEMPLATE. "header.php"); ?>
<?php include(ADMIN_TEMPLATE. "session_check.php"); ?>
<ul class="breadcrumb">
	<li>
		<i class="icon-home"></i>
			<a href="/dashboard/">Эхлэл</a> 
		<i class="icon-angle-right"></i>
	</li>
	<li>
		<a href="/dashboard/sanal.php">Санал хүсэлтийн жагсаалт</a>
	</li>
</ul>

<div class="row-fluid sortable">
	<div class="box span11">
		<div class="box-header" data-original-title>
			<h2><i class="halflings-icon edit"></i><span class="break"></span>Санал хүсэлтийн хариу</h2>
			<div class="box-icon">
				<a href="#" class="btn-minimize"><i class="halflings-icon chevron-up"></i></a>
			</div>
		</div>
		<div class="box-content">
		<div class="box span5">
			<div class="sanal-full">
				<div class="sanal-inforow">
					<span>Хэнээс: </span><?php echo substr($sanal['lastname'], 0, 2).'.'.$sanal['firstname']; ?>
				</div>
				<div class="sanal-inforow">
					<span>Регистрийн №: </span><?php echo $sanal['identity']; ?>
				</div>
				<div class="sanal-inforow">
					<span>Холбогдох и-мэйл: </span><?php echo $sanal['email']; ?>
				</div>
				<div class="sanal-inforow">
					<span>Холбогдох утас: </span><?php echo $sanal['phone']; ?>
				</div>
				<div class="sanal-inforow">
					<span>Ангилал: </span><?php echo $sanal['type']; ?>
				</div>
				<div class="sanal-inforow">
					<span>Хороо: </span>
					<?php
						$region = Region::getRegion($sanal['region_id']); 
						echo $region['title'];
					?>
				</div>
				<div class="sanal-content">
					<div class="content-title">Агуулга:</div>
					<?php echo $sanal['content']; ?>
				</div>
				<div class="sanal-file">
					<?php if($sanal['file'] != NULL) { ?>
					<div class="file-download">
						<a target="_blank" href="<?php echo '/webroot/attachment/'.$sanal['file']; ?>">Хавсралт файл татах</a>
					</div>
					<?php } ?>
				</div>
			</div>
		</div>
		<div class="box span6">
		<div class="reply-box">
				<div class="control-group">
					<label class="control-label" for="content">Хариу</label>
					<?php echo $reply['content']; ?>
				</div>
		</div>
		</div>
		</div>
	</div>
</div>

<?php include(MAIN_TEMPLATE. "footer.php"); ?>