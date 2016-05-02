<?php
require_once(realpath(dirname(__FILE__))."/classes/Marker.class.php");
require_once(realpath(dirname(__FILE__))."/classes/Year.class.php");
if(isset($_POST['region_id2']) && !empty($_POST['region_id2'])) {
	if(substr($_POST['region_id2'], 0, 1) == 'd') {
		$results = Marker::getDistrictTableInfo(substr($_POST['region_id2'], 1, 1));
		$default_year = Year::getDefaultYear();
		$districtMarkerCount['well'] = Marker::countDistrictYearMarkers(substr($_POST['region_id2'], 1, 1), $default_year['year'], 2); 
		$districtMarkerCount['hospital'] = Marker::countDistrictYearMarkers(substr($_POST['region_id2'], 1, 1), $default_year['year'], 9); 
		$districtMarkerCount['trash'] = Marker::countDistrictYearMarkers(substr($_POST['region_id2'], 1, 1), $default_year['year'], 10); 
			if($results['district_info'] != NULL) {
?>
	<div class="row-header text-center">
		<?php echo $results['district']['title']; ?>
	</div>
	<div class="row-rgtable row-value1">
		<div class="rowdata">
		<?php echo $results['district_info']['population']; ?>
		</div>
	</div>
	<div class="row-rgtable row-value1">
		<div class="rowdata">
		<?php echo $results['district_info']['household']; ?>
		</div>
	</div>
	<div class="row-rgtable row-value1">
		<div class="rowdata">
		<?php echo round($results['district_info']['household_average'], 2); ?>
		</div>
	</div>
	<div class="row-rgtable row-value1">
		<div class="rowdata">
		<?php echo round($results['district_info']['area_length']); ?>
		</div>
	</div>
	<div class="row-rgtable row-value1">
		<div class="rowdata">
		<?php echo round($results['district_info']['population_density'], 2); ?>
		</div>
	</div>
	<div class="row-rgtable row-value1">
		<div class="rowdata">
		<?php echo round($results['district_info']['bus_density'], 2).'%'; ?>
		</div>
	</div>
	<div class="row-rgtable row-value1">
		<div class="rowdata">
		<?php echo $districtMarkerCount['well']['COUNT(*)']; ?>
		</div>
	</div>
	<div class="row-rgtable row-value1">
		<div class="rowdata">
		<?php echo round($results['district_info']['well_density'], 2).'%'; ?>
		</div>
	</div>
	<div class="row-rgtable row-value1">
		<div class="rowdata">
		<?php echo round($results['district_info']['well_ratio'], 2); ?>
		</div>
	</div>
	<div class="row-rgtable row-value1">
		<div class="rowdata">
		<?php echo $districtMarkerCount['trash']['COUNT(*)']; ?>
		</div>
	</div>
	<div class="row-rgtable row-value1">
		<div class="rowdata">
		<?php echo round($results['district_info']['risk_ratio'], 2).'%'; ?>
		</div>
	</div>
	<div class="row-rgtable row-value1">
		<div class="rowdata">
		<?php echo $districtMarkerCount['hospital']['COUNT(*)']; ?>
		</div>
	</div>
	<div class="row-rgtable row-value1">
		<div class="rowdata">
		<?php echo round($results['district_info']['hospital_ratio'], 2); ?>
		</div>
	</div>
	<div class="row-rgtable row-value1">
		<div class="rowdata">
		<?php echo $results['district_info']['kin_num']; ?>
		</div>
	</div>
	<div class="row-rgtable row-value1">
		<div class="rowdata">
		<?php echo round($results['district_info']['kin_ratio'], 2).'%'; ?>
		</div>
	</div>
	<div class="row-rgtable row-value1">
		<div class="rowdata">
		<?php echo $results['district_info']['school_num']; ?>
		</div>
	</div>
	<div class="row-rgtable row-value1">
		<div class="rowdata">
		<?php echo round($results['district_info']['school_ratio'], 2).'%'; ?>
		</div>
	</div>
<?php
			} else { 
?>
		<div class="row-header text-center">
			<?php echo $results['district']['title'].' дүүрэг'; ?>
		</div>
		<div class="row-rgtable row-information">
			Мэдээлэл алга байна.
		</div>
<?php 
			}
		exit;
	}
	$results = Marker::getRegionTableInfo($_POST['region_id2']);
	$default_year = Year::getDefaultYear();
	$regionMarkerCount['well'] = Marker::regionCountYearMarkers($_POST['region_id2'], $default_year['year'], 2); 
	$regionMarkerCount['hospital'] = Marker::regionCountYearMarkers($_POST['region_id2'], $default_year['year'], 9); 
	$regionMarkerCount['trash'] = Marker::regionCountYearMarkers($_POST['region_id2'], $default_year['year'], 10); 
?>
<?php if($results['region_info'] != NULL) { ?>
	<div class="row-header text-center">
		<?php echo $results['region']['districtTitle'].' '.$results['region']['title'].'-р хороо'; ?>
	</div>
	<div class="row-rgtable row-value1">
		<div class="rowdata">
		<?php echo $results['region_info']['population']; ?>
		</div>
	</div>
	<div class="row-rgtable row-value1">
		<div class="rowdata">
		<?php echo $results['region_info']['household']; ?>
		</div>
	</div>
	<div class="row-rgtable row-value1">
		<div class="rowdata">
		<?php echo round($results['region_info']['household_average'], 2); ?>
		</div>
	</div>
	<div class="row-rgtable row-value1">
		<div class="rowdata">
		<?php echo round($results['region_info']['area_length']); ?>
		</div>
	</div>
	<div class="row-rgtable row-value1">
		<div class="rowdata">
		<?php echo round($results['region_info']['population_density'], 2); ?>
		</div>
	</div>
	<div class="row-rgtable row-value1">
		<div class="rowdata">
		<?php echo round($results['region_info']['bus_density'], 2); ?>
		</div>
	</div>
	<div class="row-rgtable row-value1">
		<div class="rowdata">
		<?php echo $regionMarkerCount['well']['COUNT(*)']; ?>
		</div>
	</div>
	<div class="row-rgtable row-value1">
		<div class="rowdata">
		<?php echo round($results['region_info']['well_density'], 2); ?>
		</div>
	</div>
	<div class="row-rgtable row-value1">
		<div class="rowdata">
		<?php echo round($results['region_info']['well_ratio'], 2); ?>
		</div>
	</div>
	<div class="row-rgtable row-value1">
		<div class="rowdata">
		<?php echo $regionMarkerCount['trash']['COUNT(*)']; ?>
		</div>
	</div>
	<div class="row-rgtable row-value1">
		<div class="rowdata">
		<?php echo round($results['region_info']['risk_ratio'], 2); ?>
		</div>
	</div>
	<div class="row-rgtable row-value1">
		<div class="rowdata">
		<?php echo $regionMarkerCount['hospital']['COUNT(*)']; ?>
		</div>
	</div>
	<div class="row-rgtable row-value1">
		<div class="rowdata">
		<?php echo round($results['region_info']['hospital_ratio'], 2); ?>
		</div>
	</div>
	<div class="row-rgtable row-value1">
		<div class="rowdata">
		<?php echo $results['region_info']['kin_num']; ?>
		</div>
	</div>
	<div class="row-rgtable row-value1">
		<div class="rowdata">
		<?php echo round($results['region_info']['kin_ratio'], 2); ?>
		</div>
	</div>
	<div class="row-rgtable row-value1">
		<div class="rowdata">
		<?php echo $results['region_info']['school_num']; ?>
		</div>
	</div>
	<div class="row-rgtable row-value1">
		<div class="rowdata">
		<?php echo round($results['region_info']['school_ratio'], 2); ?>
		</div>
	</div>
<?php } else { ?>
		<div class="row-header text-center">
			<?php echo $results['districtTitle'].' дүүргийн '.$results['region']['title'].'-р хороо'; ?>
		</div>
		<div class="row-rgtable row-information">
			Мэдээлэл алга байна.
		</div>
<?php 
	}
} 
?>