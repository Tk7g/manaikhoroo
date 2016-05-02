<?php include(ADMIN_TEMPLATE. "template/header.php"); ?>
<?php include(ADMIN_TEMPLATE. "session_check.php"); ?>

<div id="command-block">
	<div class="row">
		<div class="small-6 columns">
			<a href="company.php?action=add" class="button tiny"><i class="fa fa-plus"></i> Шинээр нэмэх</a>
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
<div id="listRow">
	<div class="row">
		<div class="small-12 columns">
			<div id="listHeader">
				<div class="row">
					<div class="small-1 columns">№</div>
					<div class="small-4 columns text-center">Компаний нэр</div>
					<div class="small-3 columns text-center">Гэрээний №</div>
					<div class="small-2 columns"></div>
					<div class="small-2 columns"></div>
				</div>
			</div>
			<div id="listBody">
			<?php 
			$i = 0;
			foreach($companies as $company) : 
			$i = $i + 1;
			?>
			<div class="rowList">
				<div class="row list_row">
					<div class="small-1 columns"><?php echo $i; ?></div>
					<div class="small-4 columns text-center">
						<?php if($_SESSION['login']['group_id'] == 1) { ?>
						<div><a href="order.php?action=companyOrderStat&id=<?php echo $company['id']; ?>&year=<?php echo date('Y'); ?>" class="companyStat"><?php echo $company['name']; ?></a></div>
						<?php } else { ?>
						<div><?php echo $company['name']; ?></div>
						<?php } ?>
					</div>
					<div class="small-3 columns text-center"><?php echo $company['agreement_id']; ?></div>
					<div class="small-2 columns text-right rowBtn"><a href="company.php?action=edit&id=<?php echo $company['id']; ?>" style="padding: 5px;" class="button success tiny">Засах</a></div>
					<div class="small-2 columns text-right rowBtn"><a href="company.php?action=delete&id=<?php echo $company['id']; ?>" onclick="return confirm('<?php echo $company['name']; ?> компаний мэдээллийг устгах уу?');" style="padding: 5px;" class="button alert tiny">Устгах</a></div>
				</div>
			</div>
			<?php endforeach; ?>
			</div>
		</div>
	</div>
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