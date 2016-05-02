<?php
include(SITE_TEMPLATE. "header.php");
?>
<div id="pageReport">
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				<div class="pageReportTitle">
					<?php echo $district['title'].' дүүргийн тоон мэдээллийн тайлан'; ?>
				</div>
				<div class="pageReportTable">
					<table>
						<tr>
							<th rowspan="2">№</th>
							<th rowspan="2">Үзүүлэлт</th>
							<th><?php echo $district['title'].' дүүргийн хороод'; ?></th>
						</tr>
						<tr>
							
						</tr>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
<?php
include(SITE_TEMPLATE. "footer.php");
?>