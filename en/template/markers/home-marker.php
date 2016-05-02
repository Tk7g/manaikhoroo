<div class="marker-box-title">
	Тэмдэглэгээ
</div>
<div class="marker-box-home">
	<div class="marker-row">
		<div class="marker-image">
		<img src="http://manaikhoroo.ub.gov.mn/webroot/img/icons/25/line1.png" />
		</div>
		<div class="marker-checker">
			<div class="marker-checkbox" data="sectionline">
			</div>
			<div class="marker-checked" data="sectionline">
			</div>
		</div>
		<div class="marker-description">
			<div class="marker-title">
				Kheseg boundaries
			</div>
		</div>
	</div>
	<?php foreach($results['types'] as $marker_type) : ?>
	<div class="marker-row">
		<div class="marker-image">
		<img src="<?php echo $marker_type['image']; ?>" />
		</div>
		<div class="marker-checker">
			<div class="marker-checkbox" data="<?php echo $marker_type['id']; ?>">
			</div>
			<div class="marker-checked" data="<?php echo $marker_type['id']; ?>">
			</div>
		</div>
		<div class="marker-description">
			<div class="marker-title">
				<?php echo $marker_type['title']; ?>
			</div>
		</div>
	</div>
	<?php if($marker_type['id'] == 1) { ?>
	<div class="marker-row">
		<div class="marker-image">
		<img src="<?php echo IMG_FOLDER.'icons/25/walk-bus.png'; ?>" />
		</div>
		<div class="marker-checker-walk">
			<div class="marker-checkbox" data="walk-bus">
			</div>
			<div class="marker-checked" data="walk-bus">
			</div>
		</div>
		<div class="marker-description">
			<div class="marker-title">
				Bus stop <5 min walk
			</div>
		</div>
	</div>
	<?php 
		}
		if($marker_type['id'] == 2) {
	?>
	<div class="marker-row">
		<div class="marker-image">
		<img src="<?php echo IMG_FOLDER.'icons/25/walk-water.png'; ?>" />
		</div>
		<div class="marker-checker-walk">
			<div class="marker-checkbox" data="walk-water">
			</div>
			<div class="marker-checked" data="walk-water">
			</div>
		</div>
		<div class="marker-description">
			<div class="marker-title">
				Water kiosk <5 min walk
			</div>
		</div>
	</div>
	<?php		
		}
		endforeach; 
	?>
	<div class="marker-row">
		<div class="marker-image">
		<img src="http://manaikhoroo.ub.gov.mn/webroot/img/icons/25/road.png" />
		</div>
		<div class="marker-checker">
			<div class="marker-checkbox" data="road-pol">
			</div>
			<div class="marker-checked" data="road-pol">
			</div>
		</div>
		<div class="marker-description">
			<div class="marker-title">
				Main road
			</div>
		</div>
	</div>
	<div class="marker-row">
		<div class="marker-image">
		<img src="http://manaikhoroo.ub.gov.mn/webroot/img/icons/25/flood.png" />
		</div>
		<div class="marker-checker">
			<div class="marker-checkbox" data="flood-pol">
			</div>
			<div class="marker-checked" data="flood-pol">
			</div>
		</div>
		<div class="marker-description">
			<div class="marker-title">
				Flood risk
			</div>
		</div>
	</div>
	<div class="marker-row">
		<div class="marker-image">
		<img src="http://manaikhoroo.ub.gov.mn/webroot/img/icons/25/pl.png" />
		</div>
		<div class="marker-checker">
			<div class="marker-checkbox" data="pl-pol">
			</div>
			<div class="marker-checked" data="pl-pol">
			</div>
		</div>
		<div class="marker-description">
			<div class="marker-title">
				Possible green area
			</div>
		</div>
	</div>
</div>