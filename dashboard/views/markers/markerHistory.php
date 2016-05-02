<?php include(MAIN_TEMPLATE. "header.php"); ?>
<?php include(ADMIN_TEMPLATE."session_check.php"); ?>
<ul class="breadcrumb">
	<li>
		<i class="icon-home"></i>
			<a href="/dashboard/">Эхлэл</a> 
		<i class="icon-angle-right"></i>
	</li>
	<li>
		<a href="/dashboard/news.php">Зурган тэмдэглэгээний түүх</a>
	</li>
</ul>

<div class="row-fluid sortable">
	<div class="box span11">
		<div class="box-header" data-original-title>
			<h2><i class="halflings-icon pencil"></i><span class="break"></span>Зурган тэмдэглэгээний түүх</h2>
			<div class="box-icon">
				<a href="#" class="btn-minimize"><i class="halflings-icon chevron-up"></i></a>
			</div>
		</div>
		<div class="box-content">
		<div class="tableSearch">
			<form action="markers.php?action=searchHistory" method="post">
			<div class="searchBlock">
				<label>Дүүрэг</label>
				<select name="district" id="districtSearch" style="width: 180px;">
					<option value="">Сонгоно уу</option>
					<?php foreach($districts as $dist) : ?>
					<option value="<?php echo $dist['id']; ?>" <?php if(isset($_GET['district'])){ if($_GET['district'] == $dist['id']){ echo 'selected'; } } ?>><?php echo $dist['title']; ?></option>
					<?php endforeach; ?>
				</select>
			</div>
			<div class="searchBlock">
				<label>Хороо</label>
				<select name="region" id="regionSearch" style="width: 180px;">
					<option value="">Сонгоно уу</option>
					<?php foreach($regions as $reg) : ?>
					<option value="<?php echo $reg['id']; ?>" <?php if(isset($_GET['region'])){ if($_GET['region'] == $reg['id']){ echo 'selected'; } } ?>><?php echo $reg['title'].'-р хороо'; ?></option>
					<?php endforeach; ?>
				</select>
			</div>
			<div class="searchBlock">
				<label>Зурган тэмдэглэгээний төрөл</label>
				<select name="type" style="width: 280px;">
					<option value="">Сонгоно уу</option>
					<?php foreach($types as $typ) : ?>
					<option value="<?php echo $typ['id']; ?>" <?php if(isset($_GET['type'])){ if($_GET['type'] == $typ['id']){ echo 'selected'; } } ?>><?php echo $typ['title']; ?></option>
					<?php endforeach; ?>
				</select>
			</div>
			<div class="searchBlock">
				<button type="submit" name="searchButton" class="searchBtn">Хайх</button>
			</div>
			</form>
		</div>
			<table width="100%" class="table table-striped table-bordered">
				<thead>
					<tr>
						<th width="5%">№</th>
						<th width="20%">Дүүрэг</th>
						<th width="15%">Хороо</th>
						<th width="30%">Тэмдэглэгээ</th>
						<th width="30%">Үйлдэл</th>
					</tr>
				</thead>
				<tbody>
					<?php
						if(isset($_GET['page'])) {
							$k = ($_GET['page'] - 1)*10;
						} else {
							$k = 0; 	
						}
						foreach($data as $marker) :
						$k = $k + 1; 
					?>
					<tr>
						<td><?php echo $k; ?></td>
						<td><?php echo getDistrictName($marker['district_id']); ?></td>
						<td><?php echo getRegionName($marker['region_id']); ?></td>
						<td><?php echo getMarkerTypeName($marker['type_id']); ?></td>
						<td>
						<?php 
							echo 'Тэмдэглэгээ үүсгэсэн</br>Үүсгэсэн огноо: '.$marker['created'];
						?>
						</td>
					</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
			<div id="paginationBlock">
			<?php
			if(isset($_GET['page'])) {
			if($total_pagination == 1) {
			?>
				<a class="paginationLink" href="markers.php?action=markerHistory&page=1<?php if(isset($_GET['district'])){ echo '&district='.$_GET['district']; } ?><?php if(isset($_GET['region'])){ echo '&region='.$_GET['region']; } ?><?php if(isset($_GET['type'])){ echo '&type='.$_GET['type']; } ?>">1</a>
			<?php
			} else {
				if($_GET['page'] <= 20) {
					for($i=1; $i<=40; $i++) {
			?>
				<a class="paginationLink" href="markers.php?action=markerHistory&page=<?php echo $i; ?><?php if(isset($_GET['district'])){ echo '&district='.$_GET['district']; } ?><?php if(isset($_GET['region'])){ echo '&region='.$_GET['region']; } ?><?php if(isset($_GET['type'])){ echo '&type='.$_GET['type']; } ?>"><?php echo $i; ?></a>
			<?php
					}
			?>
				<a class="paginationLink" href="markers.php?action=markerHistory&page=<?php echo $total_pagination; ?><?php if(isset($_GET['district'])){ echo '&district='.$_GET['district']; } ?><?php if(isset($_GET['region'])){ echo '&region='.$_GET['region']; } ?><?php if(isset($_GET['type'])){ echo '&type='.$_GET['type']; } ?>">Төгсгөл</a>
			<?php
				} elseif($_GET['page'] > $total_pagination-20) {
					$first_page = $total_pagination - 39;
					$last_page = $total_pagination;
			?>
				<a class="paginationLink" href="markers.php?action=markerHistory&page=1<?php if(isset($_GET['district'])){ echo '&district='.$_GET['district']; } ?><?php if(isset($_GET['region'])){ echo '&region='.$_GET['region']; } ?><?php if(isset($_GET['type'])){ echo '&type='.$_GET['type']; } ?>">Эхлэл</a>
			<?php
					for($i=$first_page; $i<=$last_page; $i++) {
			?>
				<a class="paginationLink" href="markers.php?action=markerHistory&page=<?php echo $i; ?><?php if(isset($_GET['district'])){ echo '&district='.$_GET['district']; } ?><?php if(isset($_GET['region'])){ echo '&region='.$_GET['region']; } ?><?php if(isset($_GET['type'])){ echo '&type='.$_GET['type']; } ?>"><?php echo $i; ?></a>
			<?php
					}
				} else {
					$first_page = $_GET['page'] - 19;
					$last_page = $_GET['page'] + 20;
			?>
				<a class="paginationLink" href="markers.php?action=markerHistory&page=1<?php if(isset($_GET['district'])){ echo '&district='.$_GET['district']; } ?><?php if(isset($_GET['region'])){ echo '&region='.$_GET['region']; } ?><?php if(isset($_GET['type'])){ echo '&type='.$_GET['type']; } ?>">Эхлэл</a>
			<?php
					for($i=$first_page; $i<=$last_page; $i++) {
			?>
						<a class="paginationLink" href="markers.php?action=markerHistory&page=<?php echo $i; ?><?php if(isset($_GET['district'])){ echo '&district='.$_GET['district']; } ?><?php if(isset($_GET['region'])){ echo '&region='.$_GET['region']; } ?><?php if(isset($_GET['type'])){ echo '&type='.$_GET['type']; } ?>"><?php echo $i; ?></a>
			<?php
					}
			?>
				<a class="paginationLink" href="markers.php?action=markerHistory&page=<?php echo $total_pagination; ?><?php if(isset($_GET['district'])){ echo '&district='.$_GET['district']; } ?><?php if(isset($_GET['region'])){ echo '&region='.$_GET['region']; } ?><?php if(isset($_GET['type'])){ echo '&type='.$_GET['type']; } ?>">Төгсгөл</a>
			<?php
				}
			}
			} else {
				for($i=1; $i<=40; $i++) {
			?>
					<a class="paginationLink" href="markers.php?action=markerHistory&page=<?php echo $i; ?><?php if(isset($_GET['district'])){ echo '&district='.$_GET['district']; } ?><?php if(isset($_GET['region'])){ echo '&region='.$_GET['region']; } ?><?php if(isset($_GET['type'])){ echo '&type='.$_GET['type']; } ?>"><?php echo $i; ?></a>
			<?php
				}
			}
			?>
			</div>
		</div>
	</div>
</div>
<script>
$(document).ready(function () {
	$("#districtSearch").bind("change", function (event) {$.ajax({async:true, data:$("#districtSearch").serialize(), dataType:"html", success:function (data, textStatus) {$("#regionSearch").html(data);}, type:"post", url:"get_search_region.php"});
	return false;});
});
</script>
<?php include(MAIN_TEMPLATE. "footer.php"); ?>