<?php
//error_reporting(0);
require(realpath(dirname(__FILE__))."/config/settings.php");
require_once(realpath(dirname(__FILE__))."/classes/Report.class.php");
require_once(realpath(dirname(__FILE__))."/classes/Link.class.php");
require_once(realpath(dirname(__FILE__))."/classes/Marker.class.php");
require_once(realpath(dirname(__FILE__))."/classes/Region.class.php");
require_once(realpath(dirname(__FILE__))."/classes/Section.class.php");
require_once(realpath(dirname(__FILE__))."/classes/Playground.class.php");
require_once(realpath(dirname(__FILE__))."/classes/Torongarts.class.php");
require_once(realpath(dirname(__FILE__))."/classes/Risks.class.php");
require_once(realpath(dirname(__FILE__))."/classes/Road.class.php");
require_once(realpath(dirname(__FILE__))."/classes/District.class.php");
require_once(realpath(dirname(__FILE__))."/classes/Info.class.php");
require_once(realpath(dirname(__FILE__))."/classes/Year.class.php");
require_once(realpath(dirname(__FILE__))."/classes/Jenks.class.php");
@include_once( '/home2/manaikho/public_html/stat/stats-include.php' );

$action = isset( $_GET['action'] ) ? $_GET['action'] : "";

switch ( $action ) {
	case 'regionReport':
		regionReport();
		break;
	case 'regionInfoReport':
		regionInfo();
		break;
	case 'regionTrashReport':
		regionTrashReport();
		break;
	case 'regionTrashReportPdf':
		regionTrashReportPdf();
		break;
	case 'regionHospitalReport':
		regionHospitalReport();
		break;
	case 'regionHospitalReportPdf':
		regionHospitalReportPdf();
		break;
	case 'regionWellReport':
		regionWellReport();
		break;
	case 'regionWellReportPdf':
		regionWellReportPdf();
		break;
	case 'regionRiskReport':
		regionRiskReport();
		break;
	case 'regionRiskReportPdf':
		regionRiskReportPdf();
		break;
	case 'regionBusReport':
		regionBusReport();
		break;
	case 'regionBusReportPdf':
		regionBusReportPdf();
		break;
	case 'regionKinderReport':
		regionKinderReport();
		break;
	case 'regionKinderReportPdf':
		regionKinderReportPdf();
		break;
	case 'regionSchoolReport':
		regionSchoolReport();
		break;
	case 'regionSchoolReportPdf':
		regionSchoolReportPdf();
		break;
	case 'regionGroundReport':
		regionGroundReport();
		break;
	case 'regionGroundReportPdf':
		regionGroundReportPdf();
		break;
	case 'districtBusReport':
		districtBusReport();
		break;
	case 'districtTrashReport':
		districtTrashReport();
		break;
	case 'districtSchoolReport':
		districtSchoolReport();
		break;
	case 'districtKinderReport':
		districtKinderReport();
		break;
	case 'districtHospitalReport':
		districtHospitalReport();
		break;
	case 'districtTypeReport':
		districtTypeReport();
		break;
	case 'yearRegionReport':
		yearRegionReport();
		break;
	case 'regionProfileReport':
		regionProfileReport();
		break;
	case 'regionProfileReportPdf':
		regionProfileReportPdf();
		break;
	case 'districtProfileReport':
		districtProfileReport();
		break;
	case 'getRegionMarkers':
		getRegionMarkers();
		break;
	case 'reportListBack':
		reportListBack();
		break;
	case 'reportDistrictListBack':
		reportDistrictListBack();
		break;
	case 'getRegionMarks':
		getRegionMarks();
		break;
	default:
		reportView();
}

function yearRegionReport() {
	$district = District::getDistrict($_GET['district']);
	$region = Region::getRegion($_GET['region']);
	$types = Marker::getTypes();
	$years = Year::getYearList();
	foreach($years as $yr) {
		$info[$yr['year']] = Info::RegionInfo($region['id'], $yr['year']);
		foreach($types as $tp) {
			$count_marker[$tp['id']][$yr['year']] = Report::markerRegionCount($tp['id'], $_GET['region'], $yr['year']);
		}
	}
	require(SITE_TEMPLATE . "report/yearRegionReport.php");
}

function districtBusReport() {
	$district = District::getDistrict($_GET['district']);
	$districts = District::getDistrictList();
	foreach($districts as $dist) {
		$district_marker[$dist['id']] = Report::markerDistrictCount(1, $dist['id'], $_GET['year']);	
	}
	$count_marker = Report::markerDistrictCount(1, $_GET['district'], $_GET['year']);
	$regions = Region::getRegionList($district['id']);
	foreach($regions as $reg) {
		$regionInfo[$reg['id']] = Info::RegionInfo($reg['id'], $_GET['year']);
		if($regionInfo[$reg['id']] == NULL) {
			$pop_color[$reg['id']] = '#FFFFFF';
			$school_color[$reg['id']] = '#FFFFFF';
			$kin_color[$reg['id']] = '#FFFFFF';
		} else {
				$population_density[$reg['id']] = ceil($regionInfo[$reg['id']]['population_density']);
				$school_ratio[$reg['id']] = ceil($regionInfo[$reg['id']]['school_ratio']);
				$kin_ratio[$reg['id']] = ceil($regionInfo[$reg['id']]['kin_ratio']);
				$colors = array('#730601', '#a84600', '#e48801', '#ffdc9c');
				if($population_density[$reg['id']] >= 0 && $population_density[$reg['id']] <= 50 ) {
					$pop_color[$reg['id']] = $colors[3];
				} elseif($population_density[$reg['id']] >= 51 && $population_density[$reg['id']] <= 100 ) {
					$pop_color[$reg['id']] = $colors[2];
				} elseif($population_density[$reg['id']] >= 101 && $population_density[$reg['id']] <= 200 ) {
					$pop_color[$reg['id']] = $colors[1];
				} elseif($population_density[$reg['id']] >= 201 ) {
					$pop_color[$reg['id']] = $colors[0];
				}
			
				if($school_ratio[$reg['id']] >= 0 && $school_ratio[$reg['id']] <= 21) {
					$school_color[$reg['id']] = $colors[3];
				} elseif($school_ratio[$reg['id']] >= 22 && $school_ratio[$reg['id']] <= 44) {
					$school_color[$reg['id']] = $colors[2];
				} elseif($school_ratio[$reg['id']] >= 45 && $school_ratio[$reg['id']] <= 64) {
					$school_color[$reg['id']] = $colors[1];
				} elseif($school_ratio[$reg['id']] >= 65) {
					$school_color[$reg['id']] = $colors[0];
				}
			
				if($kin_ratio[$reg['id']] >= 0 && $kin_ratio[$reg['id']] <= 21) {
					$kin_color[$reg['id']] = $colors[3];
				} elseif($kin_ratio[$reg['id']] >= 22 && $kin_ratio[$reg['id']] <= 44) {
					$kin_color[$reg['id']] = $colors[2];
				} elseif($kin_ratio[$reg['id']] >= 45 && $kin_ratio[$reg['id']] <= 64) {
					$kin_color[$reg['id']] = $colors[1];
				} elseif($kin_ratio[$reg['id']] >= 65) {
					$kin_color[$reg['id']] = $colors[0];
				}
		}
	}
	$info = Info::reportDistrictInfo($_GET['district'], $_GET['year']);
	require(SITE_TEMPLATE . "report/districtBusReport.php");
}

function districtTrashReport() {
	$district = District::getDistrict($_GET['district']);
	$districts = District::getDistrictList();
	foreach($districts as $dist) {
		$district_marker[$dist['id']] = Report::markerDistrictCount(10, $dist['id'], $_GET['year']);	
	}
	$count_marker = Report::markerDistrictCount(10, $_GET['district'], $_GET['year']);
	$regions = Region::getRegionList($district['id']);
	foreach($regions as $reg) {
		$regionInfo[$reg['id']] = Info::RegionInfo($reg['id'], $_GET['year']);
		if($regionInfo[$reg['id']] == NULL) {
			$pop_color[$reg['id']] = '#FFFFFF';
			$school_color[$reg['id']] = '#FFFFFF';
			$kin_color[$reg['id']] = '#FFFFFF';
		} else {
				$population_density[$reg['id']] = ceil($regionInfo[$reg['id']]['population_density']);
				$school_ratio[$reg['id']] = ceil($regionInfo[$reg['id']]['school_ratio']);
				$kin_ratio[$reg['id']] = ceil($regionInfo[$reg['id']]['kin_ratio']);
				$colors = array('#730601', '#a84600', '#e48801', '#ffdc9c');
				if($population_density[$reg['id']] >= 0 && $population_density[$reg['id']] <= 50 ) {
					$pop_color[$reg['id']] = $colors[3];
				} elseif($population_density[$reg['id']] >= 51 && $population_density[$reg['id']] <= 100 ) {
					$pop_color[$reg['id']] = $colors[2];
				} elseif($population_density[$reg['id']] >= 101 && $population_density[$reg['id']] <= 200 ) {
					$pop_color[$reg['id']] = $colors[1];
				} elseif($population_density[$reg['id']] >= 201 ) {
					$pop_color[$reg['id']] = $colors[0];
				}
		}
	}
	$info = Info::reportDistrictInfo($_GET['district'], $_GET['year']);
	require(SITE_TEMPLATE . "report/districtTrashReport.php");
}

function districtSchoolReport() {
	$district = District::getDistrict($_GET['district']);
	$districts = District::getDistrictList();
	foreach($districts as $dist) {
		$district_marker[$dist['id']] = Report::markerDistrictCount(4, $dist['id'], $_GET['year']);	
	}
	$count_marker = Report::markerDistrictCount(4, $_GET['district'], $_GET['year']);
	$regions = Region::getRegionList($district['id']);
	foreach($regions as $reg) {
		$regionInfo[$reg['id']] = Info::RegionInfo($reg['id'], $_GET['year']);
		if($regionInfo[$reg['id']] == NULL) {
			$pop_color[$reg['id']] = '#FFFFFF';
			$school_color[$reg['id']] = '#FFFFFF';
			$kin_color[$reg['id']] = '#FFFFFF';
		} else {
				$population_density[$reg['id']] = ceil($regionInfo[$reg['id']]['population_density']);
				$school_ratio[$reg['id']] = ceil($regionInfo[$reg['id']]['school_ratio']);
				$kin_ratio[$reg['id']] = ceil($regionInfo[$reg['id']]['kin_ratio']);
				$colors = array('#730601', '#a84600', '#e48801', '#ffdc9c');
				if($school_ratio[$reg['id']] >= 0 && $school_ratio[$reg['id']] <= 21) {
					$school_color[$reg['id']] = $colors[3];
				} elseif($school_ratio[$reg['id']] >= 22 && $school_ratio[$reg['id']] <= 44) {
					$school_color[$reg['id']] = $colors[2];
				} elseif($school_ratio[$reg['id']] >= 45 && $school_ratio[$reg['id']] <= 64) {
					$school_color[$reg['id']] = $colors[1];
				} elseif($school_ratio[$reg['id']] >= 65) {
					$school_color[$reg['id']] = $colors[0];
				}
		}
	}
	$info = Info::reportDistrictInfo($_GET['district'], $_GET['year']);
	require(SITE_TEMPLATE . "report/districtSchoolReport.php");
}

function districtHospitalReport() {
	$district = District::getDistrict($_GET['district']);
	$districts = District::getDistrictList();
	foreach($districts as $dist) {
		$district_marker[$dist['id']] = Report::markerDistrictCount(9, $dist['id'], $_GET['year']);	
	}
	$count_marker = Report::markerDistrictCount(9, $_GET['district'], $_GET['year']);
	$regions = Region::getRegionList($district['id']);
	foreach($regions as $reg) {
		$regionInfo[$reg['id']] = Info::RegionInfo($reg['id'], $_GET['year']);
		if($regionInfo[$reg['id']] == NULL) {
			$pop_color[$reg['id']] = '#FFFFFF';
			$school_color[$reg['id']] = '#FFFFFF';
			$kin_color[$reg['id']] = '#FFFFFF';
		} else {
				$population_density[$reg['id']] = ceil($regionInfo[$reg['id']]['population_density']);
				$school_ratio[$reg['id']] = ceil($regionInfo[$reg['id']]['school_ratio']);
				$kin_ratio[$reg['id']] = ceil($regionInfo[$reg['id']]['kin_ratio']);
				$colors = array('#730601', '#a84600', '#e48801', '#ffdc9c');
				if($population_density[$reg['id']] >= 0 && $population_density[$reg['id']] <= 50 ) {
					$pop_color[$reg['id']] = $colors[3];
				} elseif($population_density[$reg['id']] >= 51 && $population_density[$reg['id']] <= 100 ) {
					$pop_color[$reg['id']] = $colors[2];
				} elseif($population_density[$reg['id']] >= 101 && $population_density[$reg['id']] <= 200 ) {
					$pop_color[$reg['id']] = $colors[1];
				} elseif($population_density[$reg['id']] >= 201 ) {
					$pop_color[$reg['id']] = $colors[0];
				}
		}
	}
	$info = Info::reportDistrictInfo($_GET['district'], $_GET['year']);
	require(SITE_TEMPLATE . "report/districtHospitalReport.php");
}

function districtKinderReport() {
	$district = District::getDistrict($_GET['district']);
	$districts = District::getDistrictList();
	foreach($districts as $dist) {
		$district_marker[$dist['id']] = Report::markerDistrictCount(3, $dist['id'], $_GET['year']);	
	}
	$count_marker = Report::markerDistrictCount(3, $_GET['district'], $_GET['year']);
	$regions = Region::getRegionList($district['id']);
	foreach($regions as $reg) {
		$regionInfo[$reg['id']] = Info::RegionInfo($reg['id'], $_GET['year']);
		if($regionInfo[$reg['id']] == NULL) {
			$pop_color[$reg['id']] = '#FFFFFF';
			$school_color[$reg['id']] = '#FFFFFF';
			$kin_color[$reg['id']] = '#FFFFFF';
		} else {
				$population_density[$reg['id']] = ceil($regionInfo[$reg['id']]['population_density']);
				$school_ratio[$reg['id']] = ceil($regionInfo[$reg['id']]['school_ratio']);
				$kin_ratio[$reg['id']] = ceil($regionInfo[$reg['id']]['kin_ratio']);
				$colors = array('#730601', '#a84600', '#e48801', '#ffdc9c');
				if($kin_ratio[$reg['id']] >= 0 && $kin_ratio[$reg['id']] <= 21) {
					$kin_color[$reg['id']] = $colors[3];
				} elseif($kin_ratio[$reg['id']] >= 22 && $kin_ratio[$reg['id']] <= 44) {
					$kin_color[$reg['id']] = $colors[2];
				} elseif($kin_ratio[$reg['id']] >= 45 && $kin_ratio[$reg['id']] <= 64) {
					$kin_color[$reg['id']] = $colors[1];
				} elseif($kin_ratio[$reg['id']] >= 65) {
					$kin_color[$reg['id']] = $colors[0];
				}
		}
	}
	$info = Info::reportDistrictInfo($_GET['district'], $_GET['year']);
	require(SITE_TEMPLATE . "report/districtKinderReport.php");
}

function districtTypeReport() {
	$district = District::getDistrict($_GET['district']);
	$regions = Region::getRegionList($_GET['district']);
	$type = Marker::getType($_GET['type']);
	$info = Info::reportDistrictInfo($_GET['district'], $_GET['year']);
	$count_marker = Report::markerDistrictCount($_GET['type'], $_GET['district'], $_GET['year']);
	$districts = District::getDistrictList();
	foreach($districts as $dist) {
		$district_marker[$dist['id']] = Report::markerDistrictCount($_GET['type'], $dist['id'], $_GET['year']);	
	}
	$colors = array('#8683ab', '#998cb0', '#c6b9ca', '#e7dfdf');
	foreach($regions as $reg) {
		$region_pop[$reg['id']] = Info::RegionInfo($reg['id'], $_GET['year']);
		$population_density[$reg['id']] = ceil($region_pop[$reg['id']]['population_density']);
		if($population_density[$reg['id']] >= 0 && $population_density[$reg['id']] <= 48 ) {
			$pop_color[$reg['id']] = $colors[3];
		} elseif($population_density[$reg['id']] >= 49 && $population_density[$reg['id']] <= 77 ) {
			$pop_color[$reg['id']] = $colors[2];
		} elseif($population_density[$reg['id']] >= 78 && $population_density[$reg['id']] <= 101 ) {
			$pop_color[$reg['id']] = $colors[1];
		} elseif($population_density[$reg['id']] >= 102 ) {
			$pop_color[$reg['id']] = $colors[0];
		}
	}
	require(SITE_TEMPLATE . "report/districtTypeReport.php");
}

function regionWellReportPdf() {
	$district = District::getDistrict($_GET['district']);
	$region = Region::getRegion($_GET['region']);
	$regions = Region::getRegionList($district['id']);
	$info = Info::RegionInfo($region['id'], $_GET['year']);
	if($info == NULL) {
		require(SITE_TEMPLATE . "report/reportNotExist.php");
		exit;
	}
	$sections = Section::getRegionSections($_GET['region']);
	$sectionCheck = NULL;
	$count_sections = 0;
	$sectionDensityRows = Report::getSectionsPopDenstity($_GET['region'], $_GET['year']);
	foreach($sectionDensityRows as $secDenRows) {
		$sectionDensity[] = $secDenRows['population']/$secDenRows['area_length'];
	}
	sort( $sectionDensity );
	$breaks = Jenks::getBreaks( $sectionDensity, 4);
	
$cls = 1;
$from = $sectionDensity[ 0 ];
$prices = array_unique( $sectionDensity );
sort( $sectionDensity );

foreach( $sectionDensity as $i => $price ) {
	if( $price >= $breaks[ $cls ] ) {
		$count = 0;
		foreach( $sectionDensity as $p ) {
			if( $p >= $from && $p <= $price ) {
				$count++;
			}
		}
		if( isset( $sectionDensity[ $i + 1 ] ) ) {
			$from = $sectionDensity[ $i + 1 ];
		}

		$cls++;
	}
}
	
	foreach($sections as $sec) {
		if($sectionCheck == NULL) {
			$sectionCheck = $sec['title'];
			$sectionInfo[$sec['title']] = Info::SectionInfo($_GET['region'], $_GET['district'], $sec['title'], $_GET['year']);
			if($sectionInfo[$sec['title']] == NULL) {
				$pop_color[$sec['title']] = '#FFFFFF';
			} else {
				$population_density[$sec['title']] = $sectionInfo[$sec['title']]['population']/$sectionInfo[$sec['title']]['area_length'];
				$colors = array('#730601', '#a84600', '#e48801', '#ffdc9c');
				if($population_density[$sec['title']] <= $breaks[2] ) {
					$pop_color[$sec['title']] = $colors[3];
				} elseif($population_density[$sec['title']] >= ($breaks[2]+0.0000001) && $population_density[$sec['title']] <= $breaks[3] ) {
					$pop_color[$sec['title']] = $colors[2];
				} elseif($population_density[$sec['title']] >= ($breaks[3]+0.0000001) && $population_density[$sec['title']] <= $from ) {
					$pop_color[$sec['title']] = $colors[1];
				} elseif($population_density[$sec['title']] >= ($from+0.0000001) ) {
					$pop_color[$sec['title']] = $colors[0];
				}
			}
		} else {
			if($sectionCheck != $sec['title']) {
				$sectionCheck = $sec['title'];
				$sectionInfo[$sec['title']] = Info::SectionInfo($_GET['region'], $_GET['district'], $sec['title'], $_GET['year']);
				if($sectionInfo[$sec['title']] == NULL) {
					$pop_color[$sec['title']] = '#FFFFFF';
				} else {
					$population_density[$sec['title']] = $sectionInfo[$sec['title']]['population']/$sectionInfo[$sec['title']]['area_length'];
					$colors = array('#730601', '#a84600', '#e48801', '#ffdc9c');
				if($population_density[$sec['title']] <= $breaks[2] ) {
					$pop_color[$sec['title']] = $colors[3];
				} elseif($population_density[$sec['title']] >= ($breaks[2]+0.0000001) && $population_density[$sec['title']] <= $breaks[3] ) {
					$pop_color[$sec['title']] = $colors[2];
				} elseif($population_density[$sec['title']] >= ($breaks[3]+0.0000001) && $population_density[$sec['title']] <= $from ) {
					$pop_color[$sec['title']] = $colors[1];
				} elseif($population_density[$sec['title']] >= ($from+0.0000001) ) {
					$pop_color[$sec['title']] = $colors[0];
				}
				}
			}
		}
	}
	$count_marker = Report::markerRegionCount(2, $_GET['region'], $_GET['year']);
	foreach($regions as $reg) {
		$region_marker[$reg['id']] = Report::markerRegionCount(2, $reg['id'], $_GET['year']);	
	}
	require(SITE_TEMPLATE . "report/regionWellReportPdf.php");
}

function regionWellReport() {
	$district = District::getDistrict($_GET['district']);
	$region = Region::getRegion($_GET['region']);
	$regions = Region::getRegionList($district['id']);
	$info = Info::RegionInfo($region['id'], $_GET['year']);
	if($info == NULL) {
		require(SITE_TEMPLATE . "report/reportNotExist.php");
		exit;
	}
	$sections = Section::getRegionSections($_GET['region']);
	$sectionCheck = NULL;
	$count_sections = 0;
	$sectionDensityRows = Report::getSectionsPopDenstity($_GET['region'], $_GET['year']);
	if($sectionDensityRows == NULL) {
		require(SITE_TEMPLATE . "report/reportNotExist.php");
		exit;
	}
	foreach($sectionDensityRows as $secDenRows) {
		$sectionDensity[] = $secDenRows['population']/$secDenRows['area_length'];
	}
	sort( $sectionDensity );
	$breaks = Jenks::getBreaks( $sectionDensity, 4);
	
$cls = 1;
$from = $sectionDensity[ 0 ];
$prices = array_unique( $sectionDensity );
sort( $sectionDensity );

foreach( $sectionDensity as $i => $price ) {
	if( $price >= $breaks[ $cls ] ) {
		$count = 0;
		foreach( $sectionDensity as $p ) {
			if( $p >= $from && $p <= $price ) {
				$count++;
			}
		}
		if( isset( $sectionDensity[ $i + 1 ] ) ) {
			$from = $sectionDensity[ $i + 1 ];
		}

		$cls++;
	}
}
	
	foreach($sections as $sec) {
		if($sectionCheck == NULL) {
			$sectionCheck = $sec['title'];
			$sectionInfo[$sec['title']] = Info::SectionInfo($_GET['region'], $_GET['district'], $sec['title'], $_GET['year']);
			if($sectionInfo[$sec['title']] == NULL) {
				$pop_color[$sec['title']] = '#FFFFFF';
			} else {
				$population_density[$sec['title']] = $sectionInfo[$sec['title']]['population']/$sectionInfo[$sec['title']]['area_length'];
				$colors = array('#730601', '#a84600', '#e48801', '#ffdc9c');
				if($population_density[$sec['title']] <= $breaks[2] ) {
					$pop_color[$sec['title']] = $colors[3];
				} elseif($population_density[$sec['title']] >= ($breaks[2]+0.0000001) && $population_density[$sec['title']] <= $breaks[3] ) {
					$pop_color[$sec['title']] = $colors[2];
				} elseif($population_density[$sec['title']] >= ($breaks[3]+0.0000001) && $population_density[$sec['title']] <= $from ) {
					$pop_color[$sec['title']] = $colors[1];
				} elseif($population_density[$sec['title']] >= ($from+0.0000001) ) {
					$pop_color[$sec['title']] = $colors[0];
				}
			}
		} else {
			if($sectionCheck != $sec['title']) {
				$sectionCheck = $sec['title'];
				$sectionInfo[$sec['title']] = Info::SectionInfo($_GET['region'], $_GET['district'], $sec['title'], $_GET['year']);
				if($sectionInfo[$sec['title']] == NULL) {
					$pop_color[$sec['title']] = '#FFFFFF';
				} else {
					$population_density[$sec['title']] = $sectionInfo[$sec['title']]['population']/$sectionInfo[$sec['title']]['area_length'];
					$colors = array('#730601', '#a84600', '#e48801', '#ffdc9c');
				if($population_density[$sec['title']] <= $breaks[2] ) {
					$pop_color[$sec['title']] = $colors[3];
				} elseif($population_density[$sec['title']] >= ($breaks[2]+0.0000001) && $population_density[$sec['title']] <= $breaks[3] ) {
					$pop_color[$sec['title']] = $colors[2];
				} elseif($population_density[$sec['title']] >= ($breaks[3]+0.0000001) && $population_density[$sec['title']] <= $from ) {
					$pop_color[$sec['title']] = $colors[1];
				} elseif($population_density[$sec['title']] >= ($from+0.0000001) ) {
					$pop_color[$sec['title']] = $colors[0];
				}
				}
			}
		}
	}
	$count_marker = Report::markerRegionCount(2, $_GET['region'], $_GET['year']);
	$roads = Road::getRegionRoads($_GET['region']);
	foreach($regions as $reg) {
		$region_marker[$reg['id']] = Report::markerRegionCount(2, $reg['id'], $_GET['year']);	
	}
	require(SITE_TEMPLATE . "report/regionWellReport.php");
}

function regionSchoolReportPdf() {
	$district = District::getDistrict($_GET['district']);
	$region = Region::getRegion($_GET['region']);
	$regions = Region::getRegionList($district['id']);
	$info = Info::RegionInfo($region['id'], $_GET['year']);
	if($info == NULL) {
		require(SITE_TEMPLATE . "report/reportNotExist.php");
		exit;
	}
	$sections = Section::getRegionSections($_GET['region']);
	$sectionCheck = NULL;
	foreach($sections as $sec) {
		if($sectionCheck == NULL) {
			$sectionCheck = $sec['title'];
			$sectionInfo[$sec['title']] = Info::SectionInfo($_GET['region'], $_GET['district'], $sec['title'], $_GET['year']);
			if($sectionInfo[$sec['title']] == NULL) {
				$school_color[$sec['title']] = '#FFFFFF'; 
			} else {
				$school_ratio[$sec['title']] = ceil($sectionInfo[$sec['title']]['school_ratio']);
				$colors = array('#730601', '#a84600', '#e48801', '#ffdc9c');
				if($school_ratio[$sec['title']] >= 0 && $school_ratio[$sec['title']] <= 21) {
					$school_color[$sec['title']] = $colors[3];
				} elseif($school_ratio[$sec['title']] >= 22 && $school_ratio[$sec['title']] <= 44) {
					$school_color[$sec['title']] = $colors[2];
				} elseif($school_ratio[$sec['title']] >= 45 && $school_ratio[$sec['title']] <= 64) {
					$school_color[$sec['title']] = $colors[1];
				} elseif($school_ratio[$sec['title']] >= 65) {
					$school_color[$sec['title']] = $colors[0];
				}
			}
		} else {
			if($sectionCheck != $sec['title']) {
				$sectionCheck = $sec['title'];
				$sectionInfo[$sec['title']] = Info::SectionInfo($_GET['region'], $_GET['district'], $sec['title'], $_GET['year']);
				if($sectionInfo[$sec['title']] == NULL) {
					$school_color[$sec['title']] = '#FFFFFF';
				} else {
					$school_ratio[$sec['title']] = ceil($sectionInfo[$sec['title']]['school_ratio']);
					$colors = array('#730601', '#a84600', '#e48801', '#ffdc9c');
					if($school_ratio[$sec['title']] >= 0 && $school_ratio[$sec['title']] <= 21) {
						$school_color[$sec['title']] = $colors[3];
					} elseif($school_ratio[$sec['title']] >= 22 && $school_ratio[$sec['title']] <= 44) {
						$school_color[$sec['title']] = $colors[2];
					} elseif($school_ratio[$sec['title']] >= 45 && $school_ratio[$sec['title']] <= 64) {
						$school_color[$sec['title']] = $colors[1];
					} elseif($school_ratio[$sec['title']] >= 65) {
						$school_color[$sec['title']] = $colors[0];
					}
				}
			}
		}
	}
	$count_marker = Marker::countRegionYearMarkers($_GET['district'], $_GET['region'], 4);
	$regionInfo = Info::RegionInfo($region['id'], $_GET['year']);
	require(SITE_TEMPLATE . "report/regionSchoolReportPdf.php");
}

function regionSchoolReport() {
	$district = District::getDistrict($_GET['district']);
	$region = Region::getRegion($_GET['region']);
	$regions = Region::getRegionList($district['id']);
	$info = Info::RegionInfo($region['id'], $_GET['year']);
if($info == NULL) {
		require(SITE_TEMPLATE . "report/reportNotExist.php");
		exit;
	}
	$sectionDensityRows = Report::getSectionsPopDenstity($_GET['region'], $_GET['year']);
	if($sectionDensityRows == NULL) {
		require(SITE_TEMPLATE . "report/reportNotExist.php");
		exit;
	}
	$sections = Section::getRegionSections($_GET['region']);
	$sectionCheck = NULL;
	foreach($sections as $sec) {
		if($sectionCheck == NULL) {
			$sectionCheck = $sec['title'];
			$sectionInfo[$sec['title']] = Info::SectionInfo($_GET['region'], $_GET['district'], $sec['title'], $_GET['year']);
			if($sectionInfo[$sec['title']] == NULL) {
				$school_color[$sec['title']] = '#FFFFFF'; 
			} else {
				$school_ratio[$sec['title']] = ceil($sectionInfo[$sec['title']]['school_ratio']);
				$colors = array('#730601', '#a84600', '#e48801', '#ffdc9c');
				if($school_ratio[$sec['title']] >= 0 && $school_ratio[$sec['title']] <= 21) {
					$school_color[$sec['title']] = $colors[3];
				} elseif($school_ratio[$sec['title']] >= 22 && $school_ratio[$sec['title']] <= 44) {
					$school_color[$sec['title']] = $colors[2];
				} elseif($school_ratio[$sec['title']] >= 45 && $school_ratio[$sec['title']] <= 64) {
					$school_color[$sec['title']] = $colors[1];
				} elseif($school_ratio[$sec['title']] >= 65) {
					$school_color[$sec['title']] = $colors[0];
				}
			}
		} else {
			if($sectionCheck != $sec['title']) {
				$sectionCheck = $sec['title'];
				$sectionInfo[$sec['title']] = Info::SectionInfo($_GET['region'], $_GET['district'], $sec['title'], $_GET['year']);
				if($sectionInfo[$sec['title']] == NULL) {
					$school_color[$sec['title']] = '#FFFFFF';
				} else {
					$school_ratio[$sec['title']] = ceil($sectionInfo[$sec['title']]['school_ratio']);
					$colors = array('#730601', '#a84600', '#e48801', '#ffdc9c');
					if($school_ratio[$sec['title']] >= 0 && $school_ratio[$sec['title']] <= 21) {
						$school_color[$sec['title']] = $colors[3];
					} elseif($school_ratio[$sec['title']] >= 22 && $school_ratio[$sec['title']] <= 44) {
						$school_color[$sec['title']] = $colors[2];
					} elseif($school_ratio[$sec['title']] >= 45 && $school_ratio[$sec['title']] <= 64) {
						$school_color[$sec['title']] = $colors[1];
					} elseif($school_ratio[$sec['title']] >= 65) {
						$school_color[$sec['title']] = $colors[0];
					}
				}
			}
		}
	}
	$count_marker = Marker::countRegionYearMarkers($_GET['district'], $_GET['region'], 4);
	$regionInfo = Info::RegionInfo($region['id'], $_GET['year']);
	require(SITE_TEMPLATE . "report/regionSchoolReport.php");
}

function regionKinderReportPdf() {
	$district = District::getDistrict($_GET['district']);
	$region = Region::getRegion($_GET['region']);
	$regions = Region::getRegionList($district['id']);
	$info = Info::RegionInfo($region['id'], $_GET['year']);
	if($info == NULL) {
		require(SITE_TEMPLATE . "report/reportNotExist.php");
		exit;
	}
	$sections = Section::getRegionSections($_GET['region']);
	$sectionCheck = NULL;
	foreach($sections as $sec) {
		if($sectionCheck == NULL) {
			$sectionCheck = $sec['title'];
			$sectionInfo[$sec['title']] = Info::SectionInfo($_GET['region'], $_GET['district'], $sec['title'], $_GET['year']);
			if($sectionInfo[$sec['title']] == NULL) {
				$pop_color[$sec['title']] = '#FFFFFF';
				$school_color[$sec['title']] = '#FFFFFF';
				$kin_color[$sec['title']] = '#FFFFFF';
			} else {
				$kin_ratio[$sec['title']] = ceil($sectionInfo[$sec['title']]['kin_ratio']);
				$colors = array('#730601', '#a84600', '#e48801', '#ffdc9c');
				if($kin_ratio[$sec['title']] >= 0 && $kin_ratio[$sec['title']] <= 21) {
					$kin_color[$sec['title']] = $colors[3];
				} elseif($kin_ratio[$sec['title']] >= 22 && $kin_ratio[$sec['title']] <= 44) {
					$kin_color[$sec['title']] = $colors[2];
				} elseif($kin_ratio[$sec['title']] >= 45 && $kin_ratio[$sec['title']] <= 64) {
					$kin_color[$sec['title']] = $colors[1];
				} elseif($kin_ratio[$sec['title']] >= 65) {
					$kin_color[$sec['title']] = $colors[0];
				}
			}
		} else {
			if($sectionCheck != $sec['title']) {
				$sectionCheck = $sec['title'];
				$sectionInfo[$sec['title']] = Info::SectionInfo($_GET['region'], $_GET['district'], $sec['title'], $_GET['year']);
				if($sectionInfo[$sec['title']] == NULL) {
					$pop_color[$sec['title']] = '#FFFFFF';
					$school_color[$sec['title']] = '#FFFFFF';
					$kin_color[$sec['title']] = '#FFFFFF';
				} else {
					$kin_ratio[$sec['title']] = ceil($sectionInfo[$sec['title']]['kin_ratio']);
					$colors = array('#730601', '#a84600', '#e48801', '#ffdc9c');
			
					if($kin_ratio[$sec['title']] >= 0 && $kin_ratio[$sec['title']] <= 21) {
						$kin_color[$sec['title']] = $colors[3];
					} elseif($kin_ratio[$sec['title']] >= 22 && $kin_ratio[$sec['title']] <= 44) {
						$kin_color[$sec['title']] = $colors[2];
					} elseif($kin_ratio[$sec['title']] >= 45 && $kin_ratio[$sec['title']] <= 64) {
						$kin_color[$sec['title']] = $colors[1];
					} elseif($kin_ratio[$sec['title']] >= 65) {
						$kin_color[$sec['title']] = $colors[0];
					}
				}
			}
		}
	}
	$count_marker = Marker::countRegionYearMarkers($_GET['district'], $_GET['region'], 3);;
	$regionInfo = Info::RegionInfo($region['id'], $_GET['year']);
	require(SITE_TEMPLATE . "report/regionKinderReportPdf.php");
}

function regionKinderReport() {
	$district = District::getDistrict($_GET['district']);
	$region = Region::getRegion($_GET['region']);
	$regions = Region::getRegionList($district['id']);
	$info = Info::RegionInfo($region['id'], $_GET['year']);
if($info == NULL) {
		require(SITE_TEMPLATE . "report/reportNotExist.php");
		exit;
	}
	$sectionDensityRows = Report::getSectionsPopDenstity($_GET['region'], $_GET['year']);
	if($sectionDensityRows == NULL) {
		require(SITE_TEMPLATE . "report/reportNotExist.php");
		exit;
	}
	$sections = Section::getRegionSections($_GET['region']);
	$sectionCheck = NULL;
	foreach($sections as $sec) {
		if($sectionCheck == NULL) {
			$sectionCheck = $sec['title'];
			$sectionInfo[$sec['title']] = Info::SectionInfo($_GET['region'], $_GET['district'], $sec['title'], $_GET['year']);
			if($sectionInfo[$sec['title']] == NULL) {
				$pop_color[$sec['title']] = '#FFFFFF';
				$school_color[$sec['title']] = '#FFFFFF';
				$kin_color[$sec['title']] = '#FFFFFF';
			} else {
				$kin_ratio[$sec['title']] = ceil($sectionInfo[$sec['title']]['kin_ratio']);
				$colors = array('#730601', '#a84600', '#e48801', '#ffdc9c');
				if($kin_ratio[$sec['title']] >= 0 && $kin_ratio[$sec['title']] <= 21) {
					$kin_color[$sec['title']] = $colors[3];
				} elseif($kin_ratio[$sec['title']] >= 22 && $kin_ratio[$sec['title']] <= 44) {
					$kin_color[$sec['title']] = $colors[2];
				} elseif($kin_ratio[$sec['title']] >= 45 && $kin_ratio[$sec['title']] <= 64) {
					$kin_color[$sec['title']] = $colors[1];
				} elseif($kin_ratio[$sec['title']] >= 65) {
					$kin_color[$sec['title']] = $colors[0];
				}
			}
		} else {
			if($sectionCheck != $sec['title']) {
				$sectionCheck = $sec['title'];
				$sectionInfo[$sec['title']] = Info::SectionInfo($_GET['region'], $_GET['district'], $sec['title'], $_GET['year']);
				if($sectionInfo[$sec['title']] == NULL) {
					$pop_color[$sec['title']] = '#FFFFFF';
					$school_color[$sec['title']] = '#FFFFFF';
					$kin_color[$sec['title']] = '#FFFFFF';
				} else {
					$kin_ratio[$sec['title']] = ceil($sectionInfo[$sec['title']]['kin_ratio']);
					$colors = array('#730601', '#a84600', '#e48801', '#ffdc9c');
			
					if($kin_ratio[$sec['title']] >= 0 && $kin_ratio[$sec['title']] <= 21) {
						$kin_color[$sec['title']] = $colors[3];
					} elseif($kin_ratio[$sec['title']] >= 22 && $kin_ratio[$sec['title']] <= 44) {
						$kin_color[$sec['title']] = $colors[2];
					} elseif($kin_ratio[$sec['title']] >= 45 && $kin_ratio[$sec['title']] <= 64) {
						$kin_color[$sec['title']] = $colors[1];
					} elseif($kin_ratio[$sec['title']] >= 65) {
						$kin_color[$sec['title']] = $colors[0];
					}
				}
			}
		}
	}
	$count_marker = Marker::countRegionYearMarkers($_GET['district'], $_GET['region'], 3);
	$regionInfo = Info::RegionInfo($region['id'], $_GET['year']);
	require(SITE_TEMPLATE . "report/regionKinderReport.php");
}

function regionTrashReportPdf() {
	$district = District::getDistrict($_GET['district']);
	$region = Region::getRegion($_GET['region']);
	$regions = Region::getRegionList($district['id']);
	$info = Info::RegionInfo($region['id'], $_GET['year']);
	if($info == NULL) {
		require(SITE_TEMPLATE . "report/reportNotExist.php");
		exit;
	}
	$sections = Section::getRegionSections($_GET['region']);
	$sectionCheck = NULL;
	$count_sections = 0;
	$sectionDensityRows = Report::getSectionsPopDenstity($_GET['region'], $_GET['year']);
	foreach($sectionDensityRows as $secDenRows) {
		$sectionDensity[] = $secDenRows['population']/$secDenRows['area_length'];
	}
	sort( $sectionDensity );
	$breaks = Jenks::getBreaks( $sectionDensity, 4);
	
$cls = 1;
$from = $sectionDensity[ 0 ];
$prices = array_unique( $sectionDensity );
sort( $sectionDensity );

foreach( $sectionDensity as $i => $price ) {
	if( $price >= $breaks[ $cls ] ) {
		$count = 0;
		foreach( $sectionDensity as $p ) {
			if( $p >= $from && $p <= $price ) {
				$count++;
			}
		}
		if( isset( $sectionDensity[ $i + 1 ] ) ) {
			$from = $sectionDensity[ $i + 1 ];
		}

		$cls++;
	}
}
	
	foreach($sections as $sec) {
		if($sectionCheck == NULL) {
			$sectionCheck = $sec['title'];
			$sectionInfo[$sec['title']] = Info::SectionInfo($_GET['region'], $_GET['district'], $sec['title'], $_GET['year']);
			if($sectionInfo[$sec['title']] == NULL) {
				$pop_color[$sec['title']] = '#FFFFFF';
			} else {
				$population_density[$sec['title']] = $sectionInfo[$sec['title']]['population']/$sectionInfo[$sec['title']]['area_length'];
				$colors = array('#730601', '#a84600', '#e48801', '#ffdc9c');
				if($population_density[$sec['title']] <= $breaks[2] ) {
					$pop_color[$sec['title']] = $colors[3];
				} elseif($population_density[$sec['title']] >= ($breaks[2]+0.0000001) && $population_density[$sec['title']] <= $breaks[3] ) {
					$pop_color[$sec['title']] = $colors[2];
				} elseif($population_density[$sec['title']] >= ($breaks[3]+0.0000001) && $population_density[$sec['title']] <= $from ) {
					$pop_color[$sec['title']] = $colors[1];
				} elseif($population_density[$sec['title']] >= ($from+0.0000001) ) {
					$pop_color[$sec['title']] = $colors[0];
				}
			}
		} else {
			if($sectionCheck != $sec['title']) {
				$sectionCheck = $sec['title'];
				$sectionInfo[$sec['title']] = Info::SectionInfo($_GET['region'], $_GET['district'], $sec['title'], $_GET['year']);
				if($sectionInfo[$sec['title']] == NULL) {
					$pop_color[$sec['title']] = '#FFFFFF';
				} else {
					$population_density[$sec['title']] = $sectionInfo[$sec['title']]['population']/$sectionInfo[$sec['title']]['area_length'];
					$colors = array('#730601', '#a84600', '#e48801', '#ffdc9c');
				if($population_density[$sec['title']] <= $breaks[2] ) {
					$pop_color[$sec['title']] = $colors[3];
				} elseif($population_density[$sec['title']] >= ($breaks[2]+0.0000001) && $population_density[$sec['title']] <= $breaks[3] ) {
					$pop_color[$sec['title']] = $colors[2];
				} elseif($population_density[$sec['title']] >= ($breaks[3]+0.0000001) && $population_density[$sec['title']] <= $from ) {
					$pop_color[$sec['title']] = $colors[1];
				} elseif($population_density[$sec['title']] >= ($from+0.0000001) ) {
					$pop_color[$sec['title']] = $colors[0];
				}
				}
			}
		}
	}
	$count_marker = Marker::countRegionYearMarkers($_GET['district'], $_GET['region'], 10);
	foreach($regions as $reg) {
		$region_marker[$reg['id']] = Report::markerRegionCount(10, $reg['id'], $_GET['year']);	
	}
	require(SITE_TEMPLATE . "report/regionTrashReportPdf.php");
}

function regionTrashReport() {
	$district = District::getDistrict($_GET['district']);
	$region = Region::getRegion($_GET['region']);
	$regions = Region::getRegionList($district['id']);
	$info = Info::RegionInfo($region['id'], $_GET['year']);
if($info == NULL) {
		require(SITE_TEMPLATE . "report/reportNotExist.php");
		exit;
	}
	$sections = Section::getRegionSections($_GET['region']);
	$sectionCheck = NULL;
	$count_sections = 0;
	$sectionDensityRows = Report::getSectionsPopDenstity($_GET['region'], $_GET['year']);
	if($sectionDensityRows == NULL) {
		require(SITE_TEMPLATE . "report/reportNotExist.php");
		exit;
	}
	foreach($sectionDensityRows as $secDenRows) {
		$sectionDensity[] = $secDenRows['population']/$secDenRows['area_length'];
	}
	sort( $sectionDensity );
	$breaks = Jenks::getBreaks( $sectionDensity, 4);
	
$cls = 1;
$from = $sectionDensity[ 0 ];
$prices = array_unique( $sectionDensity );
sort( $sectionDensity );

foreach( $sectionDensity as $i => $price ) {
	if( $price >= $breaks[ $cls ] ) {
		$count = 0;
		foreach( $sectionDensity as $p ) {
			if( $p >= $from && $p <= $price ) {
				$count++;
			}
		}
		if( isset( $sectionDensity[ $i + 1 ] ) ) {
			$from = $sectionDensity[ $i + 1 ];
		}

		$cls++;
	}
}
	
	foreach($sections as $sec) {
		if($sectionCheck == NULL) {
			$sectionCheck = $sec['title'];
			$sectionInfo[$sec['title']] = Info::SectionInfo($_GET['region'], $_GET['district'], $sec['title'], $_GET['year']);
			if($sectionInfo[$sec['title']] == NULL) {
				$pop_color[$sec['title']] = '#FFFFFF';
			} else {
				$population_density[$sec['title']] = $sectionInfo[$sec['title']]['population']/$sectionInfo[$sec['title']]['area_length'];
				$colors = array('#730601', '#a84600', '#e48801', '#ffdc9c');
				if($population_density[$sec['title']] <= $breaks[2] ) {
					$pop_color[$sec['title']] = $colors[3];
				} elseif($population_density[$sec['title']] >= ($breaks[2]+0.0000001) && $population_density[$sec['title']] <= $breaks[3] ) {
					$pop_color[$sec['title']] = $colors[2];
				} elseif($population_density[$sec['title']] >= ($breaks[3]+0.0000001) && $population_density[$sec['title']] <= $from ) {
					$pop_color[$sec['title']] = $colors[1];
				} elseif($population_density[$sec['title']] >= ($from+0.0000001) ) {
					$pop_color[$sec['title']] = $colors[0];
				}
			}
		} else {
			if($sectionCheck != $sec['title']) {
				$sectionCheck = $sec['title'];
				$sectionInfo[$sec['title']] = Info::SectionInfo($_GET['region'], $_GET['district'], $sec['title'], $_GET['year']);
				if($sectionInfo[$sec['title']] == NULL) {
					$pop_color[$sec['title']] = '#FFFFFF';
				} else {
					$population_density[$sec['title']] = $sectionInfo[$sec['title']]['population']/$sectionInfo[$sec['title']]['area_length'];
					$colors = array('#730601', '#a84600', '#e48801', '#ffdc9c');
				if($population_density[$sec['title']] <= $breaks[2] ) {
					$pop_color[$sec['title']] = $colors[3];
				} elseif($population_density[$sec['title']] >= ($breaks[2]+0.0000001) && $population_density[$sec['title']] <= $breaks[3] ) {
					$pop_color[$sec['title']] = $colors[2];
				} elseif($population_density[$sec['title']] >= ($breaks[3]+0.0000001) && $population_density[$sec['title']] <= $from ) {
					$pop_color[$sec['title']] = $colors[1];
				} elseif($population_density[$sec['title']] >= ($from+0.0000001) ) {
					$pop_color[$sec['title']] = $colors[0];
				}
				}
			}
		}
	}
	$count_marker = Marker::countRegionYearMarkers($_GET['district'], $_GET['region'], 10);
	foreach($regions as $reg) {
		$region_marker[$reg['id']] = Report::markerRegionCount(10, $reg['id'], $_GET['year']);	
	}
	require(SITE_TEMPLATE . "report/regionTrashReport.php");
}

function regionHospitalReportPdf() {
	$district = District::getDistrict($_GET['district']);
	$region = Region::getRegion($_GET['region']);
	$regions = Region::getRegionList($district['id']);
	$info = Info::RegionInfo($region['id'], $_GET['year']);
	if($info == NULL) {
		require(SITE_TEMPLATE . "report/reportNotExist.php");
		exit;
	}
	$sections = Section::getRegionSections($_GET['region']);
	$sectionCheck = NULL;
	$count_sections = 0;
	$sectionDensityRows = Report::getSectionsPopDenstity($_GET['region'], $_GET['year']);
	foreach($sectionDensityRows as $secDenRows) {
		$sectionDensity[] = $secDenRows['population']/$secDenRows['area_length'];
	}
	sort( $sectionDensity );
	$breaks = Jenks::getBreaks( $sectionDensity, 4);
	
$cls = 1;
$from = $sectionDensity[ 0 ];
$prices = array_unique( $sectionDensity );
sort( $sectionDensity );

foreach( $sectionDensity as $i => $price ) {
	if( $price >= $breaks[ $cls ] ) {
		$count = 0;
		foreach( $sectionDensity as $p ) {
			if( $p >= $from && $p <= $price ) {
				$count++;
			}
		}
		if( isset( $sectionDensity[ $i + 1 ] ) ) {
			$from = $sectionDensity[ $i + 1 ];
		}

		$cls++;
	}
}
	
	foreach($sections as $sec) {
		if($sectionCheck == NULL) {
			$sectionCheck = $sec['title'];
			$sectionInfo[$sec['title']] = Info::SectionInfo($_GET['region'], $_GET['district'], $sec['title'], $_GET['year']);
			if($sectionInfo[$sec['title']] == NULL) {
				$pop_color[$sec['title']] = '#FFFFFF';
			} else {
				$population_density[$sec['title']] = $sectionInfo[$sec['title']]['population']/$sectionInfo[$sec['title']]['area_length'];
				$colors = array('#730601', '#a84600', '#e48801', '#ffdc9c');
				if($population_density[$sec['title']] <= $breaks[2] ) {
					$pop_color[$sec['title']] = $colors[3];
				} elseif($population_density[$sec['title']] >= ($breaks[2]+0.0000001) && $population_density[$sec['title']] <= $breaks[3] ) {
					$pop_color[$sec['title']] = $colors[2];
				} elseif($population_density[$sec['title']] >= ($breaks[3]+0.0000001) && $population_density[$sec['title']] <= $from ) {
					$pop_color[$sec['title']] = $colors[1];
				} elseif($population_density[$sec['title']] >= ($from+0.0000001) ) {
					$pop_color[$sec['title']] = $colors[0];
				}
			}
		} else {
			if($sectionCheck != $sec['title']) {
				$sectionCheck = $sec['title'];
				$sectionInfo[$sec['title']] = Info::SectionInfo($_GET['region'], $_GET['district'], $sec['title'], $_GET['year']);
				if($sectionInfo[$sec['title']] == NULL) {
					$pop_color[$sec['title']] = '#FFFFFF';
				} else {
					$population_density[$sec['title']] = $sectionInfo[$sec['title']]['population']/$sectionInfo[$sec['title']]['area_length'];
					$colors = array('#730601', '#a84600', '#e48801', '#ffdc9c');
				if($population_density[$sec['title']] <= $breaks[2] ) {
					$pop_color[$sec['title']] = $colors[3];
				} elseif($population_density[$sec['title']] >= ($breaks[2]+0.0000001) && $population_density[$sec['title']] <= $breaks[3] ) {
					$pop_color[$sec['title']] = $colors[2];
				} elseif($population_density[$sec['title']] >= ($breaks[3]+0.0000001) && $population_density[$sec['title']] <= $from ) {
					$pop_color[$sec['title']] = $colors[1];
				} elseif($population_density[$sec['title']] >= ($from+0.0000001) ) {
					$pop_color[$sec['title']] = $colors[0];
				}
				}
			}
		}
	}
	$count_marker = Marker::countRegionYearMarkers($_GET['district'], $_GET['region'], 9);
	foreach($regions as $reg) {
		$region_marker[$reg['id']] = Report::markerRegionCount(9, $reg['id'], $_GET['year']);	
	}
	require(SITE_TEMPLATE . "report/regionHospitalReportPdf.php");
}

function regionHospitalReport() {
	$district = District::getDistrict($_GET['district']);
	$region = Region::getRegion($_GET['region']);
	$regions = Region::getRegionList($district['id']);
	$info = Info::RegionInfo($region['id'], $_GET['year']);
	if($info == NULL) {
		require(SITE_TEMPLATE . "report/reportNotExist.php");
		exit;
	}
	$sections = Section::getRegionSections($_GET['region']);
	$sectionCheck = NULL;
	$count_sections = 0;
	$sectionDensityRows = Report::getSectionsPopDenstity($_GET['region'], $_GET['year']);
	if($sectionDensityRows == NULL) {
		require(SITE_TEMPLATE . "report/reportNotExist.php");
		exit;
	}
	foreach($sectionDensityRows as $secDenRows) {
		$sectionDensity[] = $secDenRows['population']/$secDenRows['area_length'];
	}
	sort( $sectionDensity );
	$breaks = Jenks::getBreaks( $sectionDensity, 4);
	
$cls = 1;
$from = $sectionDensity[ 0 ];
$prices = array_unique( $sectionDensity );
sort( $sectionDensity );

foreach( $sectionDensity as $i => $price ) {
	if( $price >= $breaks[ $cls ] ) {
		$count = 0;
		foreach( $sectionDensity as $p ) {
			if( $p >= $from && $p <= $price ) {
				$count++;
			}
		}
		if( isset( $sectionDensity[ $i + 1 ] ) ) {
			$from = $sectionDensity[ $i + 1 ];
		}

		$cls++;
	}
}
	
	foreach($sections as $sec) {
		if($sectionCheck == NULL) {
			$sectionCheck = $sec['title'];
			$sectionInfo[$sec['title']] = Info::SectionInfo($_GET['region'], $_GET['district'], $sec['title'], $_GET['year']);
			if($sectionInfo[$sec['title']] == NULL) {
				$pop_color[$sec['title']] = '#FFFFFF';
			} else {
				$population_density[$sec['title']] = $sectionInfo[$sec['title']]['population']/$sectionInfo[$sec['title']]['area_length'];
				$colors = array('#730601', '#a84600', '#e48801', '#ffdc9c');
				if($population_density[$sec['title']] <= $breaks[2] ) {
					$pop_color[$sec['title']] = $colors[3];
				} elseif($population_density[$sec['title']] >= ($breaks[2]+0.0000001) && $population_density[$sec['title']] <= $breaks[3] ) {
					$pop_color[$sec['title']] = $colors[2];
				} elseif($population_density[$sec['title']] >= ($breaks[3]+0.0000001) && $population_density[$sec['title']] <= $from ) {
					$pop_color[$sec['title']] = $colors[1];
				} elseif($population_density[$sec['title']] >= ($from+0.0000001) ) {
					$pop_color[$sec['title']] = $colors[0];
				}
			}
		} else {
			if($sectionCheck != $sec['title']) {
				$sectionCheck = $sec['title'];
				$sectionInfo[$sec['title']] = Info::SectionInfo($_GET['region'], $_GET['district'], $sec['title'], $_GET['year']);
				if($sectionInfo[$sec['title']] == NULL) {
					$pop_color[$sec['title']] = '#FFFFFF';
				} else {
					$population_density[$sec['title']] = $sectionInfo[$sec['title']]['population']/$sectionInfo[$sec['title']]['area_length'];
					$colors = array('#730601', '#a84600', '#e48801', '#ffdc9c');
				if($population_density[$sec['title']] <= $breaks[2] ) {
					$pop_color[$sec['title']] = $colors[3];
				} elseif($population_density[$sec['title']] >= ($breaks[2]+0.0000001) && $population_density[$sec['title']] <= $breaks[3] ) {
					$pop_color[$sec['title']] = $colors[2];
				} elseif($population_density[$sec['title']] >= ($breaks[3]+0.0000001) && $population_density[$sec['title']] <= $from ) {
					$pop_color[$sec['title']] = $colors[1];
				} elseif($population_density[$sec['title']] >= ($from+0.0000001) ) {
					$pop_color[$sec['title']] = $colors[0];
				}
				}
			}
		}
	}
	$count_marker = Marker::countRegionYearMarkers($_GET['district'], $_GET['region'], 9);
	$roads = Road::getRegionRoads($_GET['region']);
	foreach($regions as $reg) {
		$region_marker[$reg['id']] = Report::markerRegionCount(9, $reg['id'], $_GET['year']);	
	}
	require(SITE_TEMPLATE . "report/regionHospitalReport.php");
}

function regionGroundReportPdf() {
	$district = District::getDistrict($_GET['district']);
	$region = Region::getRegion($_GET['region']);
	$regions = Region::getRegionList($district['id']);
	$info = Info::RegionInfo($region['id'], $_GET['year']);
	if($info == NULL) {
		require(SITE_TEMPLATE . "report/reportNotExist.php");
		exit;
	}
	$sections = Section::getRegionSections($_GET['region']);
	$gardens = Playground::getRegionPlaygrounds($_GET['region']);
	$sectionCheck = NULL;
	$count_sections = 0;
	$sectionDensityRows = Report::getSectionsPopDenstity($_GET['region'], $_GET['year']);
	foreach($sectionDensityRows as $secDenRows) {
		$sectionDensity[] = $secDenRows['population']/$secDenRows['area_length'];
	}
	sort( $sectionDensity );
	$breaks = Jenks::getBreaks( $sectionDensity, 4);
	
$cls = 1;
$from = $sectionDensity[ 0 ];
$prices = array_unique( $sectionDensity );
sort( $sectionDensity );

foreach( $sectionDensity as $i => $price ) {
	if( $price >= $breaks[ $cls ] ) {
		$count = 0;
		foreach( $sectionDensity as $p ) {
			if( $p >= $from && $p <= $price ) {
				$count++;
			}
		}
		if( isset( $sectionDensity[ $i + 1 ] ) ) {
			$from = $sectionDensity[ $i + 1 ];
		}

		$cls++;
	}
}
	
	foreach($sections as $sec) {
		if($sectionCheck == NULL) {
			$sectionCheck = $sec['title'];
			$sectionInfo[$sec['title']] = Info::SectionInfo($_GET['region'], $_GET['district'], $sec['title'], $_GET['year']);
			if($sectionInfo[$sec['title']] == NULL) {
				$pop_color[$sec['title']] = '#FFFFFF';
			} else {
				$population_density[$sec['title']] = $sectionInfo[$sec['title']]['population']/$sectionInfo[$sec['title']]['area_length'];
				$colors = array('#730601', '#a84600', '#e48801', '#ffdc9c');
				if($population_density[$sec['title']] <= $breaks[2] ) {
					$pop_color[$sec['title']] = $colors[3];
				} elseif($population_density[$sec['title']] >= ($breaks[2]+0.0000001) && $population_density[$sec['title']] <= $breaks[3] ) {
					$pop_color[$sec['title']] = $colors[2];
				} elseif($population_density[$sec['title']] >= ($breaks[3]+0.0000001) && $population_density[$sec['title']] <= $from ) {
					$pop_color[$sec['title']] = $colors[1];
				} elseif($population_density[$sec['title']] >= ($from+0.0000001) ) {
					$pop_color[$sec['title']] = $colors[0];
				}
			}
		} else {
			if($sectionCheck != $sec['title']) {
				$sectionCheck = $sec['title'];
				$sectionInfo[$sec['title']] = Info::SectionInfo($_GET['region'], $_GET['district'], $sec['title'], $_GET['year']);
				if($sectionInfo[$sec['title']] == NULL) {
					$pop_color[$sec['title']] = '#FFFFFF';
				} else {
					$population_density[$sec['title']] = $sectionInfo[$sec['title']]['population']/$sectionInfo[$sec['title']]['area_length'];
					$colors = array('#730601', '#a84600', '#e48801', '#ffdc9c');
				if($population_density[$sec['title']] <= $breaks[2] ) {
					$pop_color[$sec['title']] = $colors[3];
				} elseif($population_density[$sec['title']] >= ($breaks[2]+0.0000001) && $population_density[$sec['title']] <= $breaks[3] ) {
					$pop_color[$sec['title']] = $colors[2];
				} elseif($population_density[$sec['title']] >= ($breaks[3]+0.0000001) && $population_density[$sec['title']] <= $from ) {
					$pop_color[$sec['title']] = $colors[1];
				} elseif($population_density[$sec['title']] >= ($from+0.0000001) ) {
					$pop_color[$sec['title']] = $colors[0];
				}
				}
			}
		}
	}
	$playground = Marker::getType(19);
	$parking = Marker::getType(20);
	$count_marker = Marker::countRegionYearMarkers($_GET['district'], $_GET['region'], 19);
	foreach($regions as $reg) {
		$region_marker[$reg['id']] = Report::markerRegionCount(19, $reg['id'], $_GET['year']);	
	}
	require(SITE_TEMPLATE . "report/regionGroundReportPdf.php");
}

function regionGroundReport() {
	$district = District::getDistrict($_GET['district']);
	$region = Region::getRegion($_GET['region']);
	$regions = Region::getRegionList($district['id']);
	$info = Info::RegionInfo($region['id'], $_GET['year']);
	if($info == NULL) {
		require(SITE_TEMPLATE . "report/reportNotExist.php");
		exit;
	}
	$sections = Section::getRegionSections($_GET['region']);
	$gardens = Playground::getRegionPlaygrounds($_GET['region']);
	$sectionCheck = NULL;
	$count_sections = 0;
	$sectionDensityRows = Report::getSectionsPopDenstity($_GET['region'], $_GET['year']);
	if($sectionDensityRows == NULL) {
		require(SITE_TEMPLATE . "report/reportNotExist.php");
		exit;
	}
	foreach($sectionDensityRows as $secDenRows) {
		$sectionDensity[] = $secDenRows['population']/$secDenRows['area_length'];
	}
	sort( $sectionDensity );
	$breaks = Jenks::getBreaks( $sectionDensity, 4);
	
$cls = 1;
$from = $sectionDensity[ 0 ];
$prices = array_unique( $sectionDensity );
sort( $sectionDensity );

foreach( $sectionDensity as $i => $price ) {
	if( $price >= $breaks[ $cls ] ) {
		$count = 0;
		foreach( $sectionDensity as $p ) {
			if( $p >= $from && $p <= $price ) {
				$count++;
			}
		}
		if( isset( $sectionDensity[ $i + 1 ] ) ) {
			$from = $sectionDensity[ $i + 1 ];
		}

		$cls++;
	}
}
	
	foreach($sections as $sec) {
		if($sectionCheck == NULL) {
			$sectionCheck = $sec['title'];
			$sectionInfo[$sec['title']] = Info::SectionInfo($_GET['region'], $_GET['district'], $sec['title'], $_GET['year']);
			if($sectionInfo[$sec['title']] == NULL) {
				$pop_color[$sec['title']] = '#FFFFFF';
			} else {
				$population_density[$sec['title']] = $sectionInfo[$sec['title']]['population']/$sectionInfo[$sec['title']]['area_length'];
				$colors = array('#730601', '#a84600', '#e48801', '#ffdc9c');
				if($population_density[$sec['title']] <= $breaks[2] ) {
					$pop_color[$sec['title']] = $colors[3];
				} elseif($population_density[$sec['title']] >= ($breaks[2]+0.0000001) && $population_density[$sec['title']] <= $breaks[3] ) {
					$pop_color[$sec['title']] = $colors[2];
				} elseif($population_density[$sec['title']] >= ($breaks[3]+0.0000001) && $population_density[$sec['title']] <= $from ) {
					$pop_color[$sec['title']] = $colors[1];
				} elseif($population_density[$sec['title']] >= ($from+0.0000001) ) {
					$pop_color[$sec['title']] = $colors[0];
				}
			}
		} else {
			if($sectionCheck != $sec['title']) {
				$sectionCheck = $sec['title'];
				$sectionInfo[$sec['title']] = Info::SectionInfo($_GET['region'], $_GET['district'], $sec['title'], $_GET['year']);
				if($sectionInfo[$sec['title']] == NULL) {
					$pop_color[$sec['title']] = '#FFFFFF';
				} else {
					$population_density[$sec['title']] = $sectionInfo[$sec['title']]['population']/$sectionInfo[$sec['title']]['area_length'];
					$colors = array('#730601', '#a84600', '#e48801', '#ffdc9c');
				if($population_density[$sec['title']] <= $breaks[2] ) {
					$pop_color[$sec['title']] = $colors[3];
				} elseif($population_density[$sec['title']] >= ($breaks[2]+0.0000001) && $population_density[$sec['title']] <= $breaks[3] ) {
					$pop_color[$sec['title']] = $colors[2];
				} elseif($population_density[$sec['title']] >= ($breaks[3]+0.0000001) && $population_density[$sec['title']] <= $from ) {
					$pop_color[$sec['title']] = $colors[1];
				} elseif($population_density[$sec['title']] >= ($from+0.0000001) ) {
					$pop_color[$sec['title']] = $colors[0];
				}
				}
			}
		}
	}
	$playground = Marker::getType(19);
	$parking = Marker::getType(20);
	$count_marker = Marker::countRegionYearMarkers($_GET['district'], $_GET['region'], 19);
	$roads = Road::getRegionRoads($_GET['region']);
	foreach($regions as $reg) {
		$region_marker[$reg['id']] = Report::markerRegionCount(19, $reg['id'], $_GET['year']);	
	}
	require(SITE_TEMPLATE . "report/regionGroundReport.php");
}

function regionRiskReportPdf() {
	$district = District::getDistrict($_GET['district']);
	$region = Region::getRegion($_GET['region']);
	$regions = Region::getRegionList($district['id']);
	$info = Info::RegionInfo($region['id'], $_GET['year']);
	if($info == NULL) {
		require(SITE_TEMPLATE . "report/reportNotExist.php");
		exit;
	}
	$sections = Section::getRegionSections($_GET['region']);
	$torongarts = Torongarts::getRegionTorongarts($_GET['region']);
	$sectionCheck = NULL;
	$count_sections = 0;
	$sectionDensityRows = Report::getSectionsPopDenstity($_GET['region'], $_GET['year']);
	foreach($sectionDensityRows as $secDenRows) {
		$sectionDensity[] = $secDenRows['population']/$secDenRows['area_length'];
	}
	sort( $sectionDensity );
	$breaks = Jenks::getBreaks( $sectionDensity, 4);
	
$cls = 1;
$from = $sectionDensity[ 0 ];
$prices = array_unique( $sectionDensity );
sort( $sectionDensity );

foreach( $sectionDensity as $i => $price ) {
	if( $price >= $breaks[ $cls ] ) {
		$count = 0;
		foreach( $sectionDensity as $p ) {
			if( $p >= $from && $p <= $price ) {
				$count++;
			}
		}
		if( isset( $sectionDensity[ $i + 1 ] ) ) {
			$from = $sectionDensity[ $i + 1 ];
		}

		$cls++;
	}
}
	
	foreach($sections as $sec) {
		if($sectionCheck == NULL) {
			$sectionCheck = $sec['title'];
			$sectionInfo[$sec['title']] = Info::SectionInfo($_GET['region'], $_GET['district'], $sec['title'], $_GET['year']);
			if($sectionInfo[$sec['title']] == NULL) {
				$pop_color[$sec['title']] = '#FFFFFF';
			} else {
				$population_density[$sec['title']] = $sectionInfo[$sec['title']]['population']/$sectionInfo[$sec['title']]['area_length'];
				$colors = array('#730601', '#a84600', '#e48801', '#ffdc9c');
				if($population_density[$sec['title']] <= $breaks[2] ) {
					$pop_color[$sec['title']] = $colors[3];
				} elseif($population_density[$sec['title']] >= ($breaks[2]+0.0000001) && $population_density[$sec['title']] <= $breaks[3] ) {
					$pop_color[$sec['title']] = $colors[2];
				} elseif($population_density[$sec['title']] >= ($breaks[3]+0.0000001) && $population_density[$sec['title']] <= $from ) {
					$pop_color[$sec['title']] = $colors[1];
				} elseif($population_density[$sec['title']] >= ($from+0.0000001) ) {
					$pop_color[$sec['title']] = $colors[0];
				}
			}
		} else {
			if($sectionCheck != $sec['title']) {
				$sectionCheck = $sec['title'];
				$sectionInfo[$sec['title']] = Info::SectionInfo($_GET['region'], $_GET['district'], $sec['title'], $_GET['year']);
				if($sectionInfo[$sec['title']] == NULL) {
					$pop_color[$sec['title']] = '#FFFFFF';
				} else {
					$population_density[$sec['title']] = $sectionInfo[$sec['title']]['population']/$sectionInfo[$sec['title']]['area_length'];
					$colors = array('#730601', '#a84600', '#e48801', '#ffdc9c');
				if($population_density[$sec['title']] <= $breaks[2] ) {
					$pop_color[$sec['title']] = $colors[3];
				} elseif($population_density[$sec['title']] >= ($breaks[2]+0.0000001) && $population_density[$sec['title']] <= $breaks[3] ) {
					$pop_color[$sec['title']] = $colors[2];
				} elseif($population_density[$sec['title']] >= ($breaks[3]+0.0000001) && $population_density[$sec['title']] <= $from ) {
					$pop_color[$sec['title']] = $colors[1];
				} elseif($population_density[$sec['title']] >= ($from+0.0000001) ) {
					$pop_color[$sec['title']] = $colors[0];
				}
				}
			}
		}
	}
	$crime = Marker::getType(6);
	$police = Marker::getType(5);
	$crime_count = Marker::countRegionYearMarkers($_GET['district'], $_GET['region'], 6);
	$police_count = Marker::countRegionYearMarkers($_GET['district'], $_GET['region'], 5);
	foreach($regions as $reg) {
		$region_marker[$reg['id']] = Report::markerRegionCount(6, $reg['id'], $_GET['year']);	
	}
	$risks = Risks::getRegionRisks($_GET['region']);
	require(SITE_TEMPLATE . "report/regionRiskReportPdf.php");
}

function regionRiskReport() {
	$district = District::getDistrict($_GET['district']);
	$region = Region::getRegion($_GET['region']);
	$regions = Region::getRegionList($district['id']);
	$info = Info::RegionInfo($region['id'], $_GET['year']);
	if($info == NULL) {
		require(SITE_TEMPLATE . "report/reportNotExist.php");
		exit;
	}
	$sections = Section::getRegionSections($_GET['region']);
	$torongarts = Torongarts::getRegionTorongarts($_GET['region']);
	$sectionCheck = NULL;
	$count_sections = 0;
	$sectionDensityRows = Report::getSectionsPopDenstity($_GET['region'], $_GET['year']);
	if($sectionDensityRows == NULL) {
		require(SITE_TEMPLATE . "report/reportNotExist.php");
		exit;
	}
	foreach($sectionDensityRows as $secDenRows) {
		$sectionDensity[] = $secDenRows['population']/$secDenRows['area_length'];
	}
	sort( $sectionDensity );
	$breaks = Jenks::getBreaks( $sectionDensity, 4);
	
$cls = 1;
$from = $sectionDensity[ 0 ];
$prices = array_unique( $sectionDensity );
sort( $sectionDensity );

foreach( $sectionDensity as $i => $price ) {
	if( $price >= $breaks[ $cls ] ) {
		$count = 0;
		foreach( $sectionDensity as $p ) {
			if( $p >= $from && $p <= $price ) {
				$count++;
			}
		}
		if( isset( $sectionDensity[ $i + 1 ] ) ) {
			$from = $sectionDensity[ $i + 1 ];
		}

		$cls++;
	}
}
	
	foreach($sections as $sec) {
		if($sectionCheck == NULL) {
			$sectionCheck = $sec['title'];
			$sectionInfo[$sec['title']] = Info::SectionInfo($_GET['region'], $_GET['district'], $sec['title'], $_GET['year']);
			if($sectionInfo[$sec['title']] == NULL) {
				$pop_color[$sec['title']] = '#FFFFFF';
			} else {
				$population_density[$sec['title']] = $sectionInfo[$sec['title']]['population']/$sectionInfo[$sec['title']]['area_length'];
				$colors = array('#730601', '#a84600', '#e48801', '#ffdc9c');
				if($population_density[$sec['title']] <= $breaks[2] ) {
					$pop_color[$sec['title']] = $colors[3];
				} elseif($population_density[$sec['title']] >= ($breaks[2]+0.0000001) && $population_density[$sec['title']] <= $breaks[3] ) {
					$pop_color[$sec['title']] = $colors[2];
				} elseif($population_density[$sec['title']] >= ($breaks[3]+0.0000001) && $population_density[$sec['title']] <= $from ) {
					$pop_color[$sec['title']] = $colors[1];
				} elseif($population_density[$sec['title']] >= ($from+0.0000001) ) {
					$pop_color[$sec['title']] = $colors[0];
				}
			}
		} else {
			if($sectionCheck != $sec['title']) {
				$sectionCheck = $sec['title'];
				$sectionInfo[$sec['title']] = Info::SectionInfo($_GET['region'], $_GET['district'], $sec['title'], $_GET['year']);
				if($sectionInfo[$sec['title']] == NULL) {
					$pop_color[$sec['title']] = '#FFFFFF';
				} else {
					$population_density[$sec['title']] = $sectionInfo[$sec['title']]['population']/$sectionInfo[$sec['title']]['area_length'];
					$colors = array('#730601', '#a84600', '#e48801', '#ffdc9c');
				if($population_density[$sec['title']] <= $breaks[2] ) {
					$pop_color[$sec['title']] = $colors[3];
				} elseif($population_density[$sec['title']] >= ($breaks[2]+0.0000001) && $population_density[$sec['title']] <= $breaks[3] ) {
					$pop_color[$sec['title']] = $colors[2];
				} elseif($population_density[$sec['title']] >= ($breaks[3]+0.0000001) && $population_density[$sec['title']] <= $from ) {
					$pop_color[$sec['title']] = $colors[1];
				} elseif($population_density[$sec['title']] >= ($from+0.0000001) ) {
					$pop_color[$sec['title']] = $colors[0];
				}
				}
			}
		}
	}
	$crime = Marker::getType(6);
	$police = Marker::getType(5);
	$crime_count = Marker::countRegionYearMarkers($_GET['district'], $_GET['region'], 6);
	$police_count = Marker::countRegionYearMarkers($_GET['district'], $_GET['region'], 5);
	foreach($regions as $reg) {
		$region_marker[$reg['id']] = Report::markerRegionCount(6, $reg['id'], $_GET['year']);	
	}
	$roads = Road::getRegionRoads($_GET['region']);
	$risks = Risks::getRegionRisks($_GET['region']);
	require(SITE_TEMPLATE . "report/regionRiskReport.php");
}

function regionBusReportPdf() {
	$district = District::getDistrict($_GET['district']);
	$region = Region::getRegion($_GET['region']);
	$regions = Region::getRegionList($district['id']);
	$info = Info::RegionInfo($region['id'], $_GET['year']);
	if($info == NULL) {
		require(SITE_TEMPLATE . "report/reportNotExist.php");
		exit;
	}
	$sections = Section::getRegionSections($_GET['region']);
	$torongarts = Torongarts::getRegionTorongarts($_GET['region']);
	$sectionCheck = NULL;
	$count_sections = 0;
	$sectionDensityRows = Report::getSectionsPopDenstity($_GET['region'], $_GET['year']);
	foreach($sectionDensityRows as $secDenRows) {
		$sectionDensity[] = $secDenRows['population']/$secDenRows['area_length'];
	}
	sort( $sectionDensity );
	$breaks = Jenks::getBreaks( $sectionDensity, 4);
	
$cls = 1;
$from = $sectionDensity[ 0 ];
$prices = array_unique( $sectionDensity );
sort( $sectionDensity );

foreach( $sectionDensity as $i => $price ) {
	if( $price >= $breaks[ $cls ] ) {
		$count = 0;
		foreach( $sectionDensity as $p ) {
			if( $p >= $from && $p <= $price ) {
				$count++;
			}
		}
		if( isset( $sectionDensity[ $i + 1 ] ) ) {
			$from = $sectionDensity[ $i + 1 ];
		}

		$cls++;
	}
}

	
	foreach($sections as $sec) {
		if($sectionCheck == NULL) {
			$sectionCheck = $sec['title'];
			$sectionInfo[$sec['title']] = Info::SectionInfo($_GET['region'], $_GET['district'], $sec['title'], $_GET['year']);
			if($sectionInfo[$sec['title']] == NULL) {
				$pop_color[$sec['title']] = '#FFFFFF';
			} else {
				$population_density[$sec['title']] = $sectionInfo[$sec['title']]['population']/$sectionInfo[$sec['title']]['area_length'];
				$colors = array('#730601', '#a84600', '#e48801', '#ffdc9c');
				if($population_density[$sec['title']] <= $breaks[2] ) {
					$pop_color[$sec['title']] = $colors[3];
				} elseif($population_density[$sec['title']] >= ($breaks[2]+0.0000001) && $population_density[$sec['title']] <= $breaks[3] ) {
					$pop_color[$sec['title']] = $colors[2];
				} elseif($population_density[$sec['title']] >= ($breaks[3]+0.0000001) && $population_density[$sec['title']] <= $from ) {
					$pop_color[$sec['title']] = $colors[1];
				} elseif($population_density[$sec['title']] >= ($from+0.0000001) ) {
					$pop_color[$sec['title']] = $colors[0];
				}
			}
		} else {
			if($sectionCheck != $sec['title']) {
				$sectionCheck = $sec['title'];
				$sectionInfo[$sec['title']] = Info::SectionInfo($_GET['region'], $_GET['district'], $sec['title'], $_GET['year']);
				if($sectionInfo[$sec['title']] == NULL) {
					$pop_color[$sec['title']] = '#FFFFFF';
				} else {
					$population_density[$sec['title']] = $sectionInfo[$sec['title']]['population']/$sectionInfo[$sec['title']]['area_length'];
					$colors = array('#730601', '#a84600', '#e48801', '#ffdc9c');
				if($population_density[$sec['title']] <= $breaks[2] ) {
					$pop_color[$sec['title']] = $colors[3];
				} elseif($population_density[$sec['title']] >= ($breaks[2]+0.0000001) && $population_density[$sec['title']] <= $breaks[3] ) {
					$pop_color[$sec['title']] = $colors[2];
				} elseif($population_density[$sec['title']] >= ($breaks[3]+0.0000001) && $population_density[$sec['title']] <= $from ) {
					$pop_color[$sec['title']] = $colors[1];
				} elseif($population_density[$sec['title']] >= ($from+0.0000001) ) {
					$pop_color[$sec['title']] = $colors[0];
				}
				}
			}
		}
	}
	$bus = Marker::getType(1);
	$light = Marker::getType(7);
	$count_marker = Marker::countRegionYearMarkers($_GET['district'], $_GET['region'], 1);;
	foreach($regions as $reg) {
		$region_marker[$reg['id']] = Report::markerRegionCount(1, $reg['id'], $_GET['year']);	
	}
	require(SITE_TEMPLATE . "report/regionBusReportPdf.php");
}

function regionBusReport() {
	$district = District::getDistrict($_GET['district']);
	$region = Region::getRegion($_GET['region']);
	$regions = Region::getRegionList($district['id']);
	$info = Info::RegionInfo($region['id'], $_GET['year']);
	if($info == NULL) {
		require(SITE_TEMPLATE . "report/reportNotExist.php");
		exit;
	}
	$sections = Section::getRegionSections($_GET['region']);
	$torongarts = Torongarts::getRegionTorongarts($_GET['region']);
	$sectionCheck = NULL;
	$count_sections = 0;
	$sectionDensityRows = Report::getSectionsPopDenstity($_GET['region'], $_GET['year']);
	if($sectionDensityRows == NULL) {
		require(SITE_TEMPLATE . "report/reportNotExist.php");
		exit;
	}
	foreach($sectionDensityRows as $secDenRows) {
		$sectionDensity[] = $secDenRows['population']/$secDenRows['area_length'];
	}
	sort( $sectionDensity );
	$breaks = Jenks::getBreaks( $sectionDensity, 4);
	
$cls = 1;
$from = $sectionDensity[ 0 ];
$prices = array_unique( $sectionDensity );
sort( $sectionDensity );

foreach( $sectionDensity as $i => $price ) {
	if( $price >= $breaks[ $cls ] ) {
		$count = 0;
		foreach( $sectionDensity as $p ) {
			if( $p >= $from && $p <= $price ) {
				$count++;
			}
		}
		if( isset( $sectionDensity[ $i + 1 ] ) ) {
			$from = $sectionDensity[ $i + 1 ];
		}

		$cls++;
	}
}
	
	foreach($sections as $sec) {
		if($sectionCheck == NULL) {
			$sectionCheck = $sec['title'];
			$sectionInfo[$sec['title']] = Info::SectionInfo($_GET['region'], $_GET['district'], $sec['title'], $_GET['year']);
			if($sectionInfo[$sec['title']] == NULL) {
				$pop_color[$sec['title']] = '#FFFFFF';
			} else {
				$population_density[$sec['title']] = $sectionInfo[$sec['title']]['population']/$sectionInfo[$sec['title']]['area_length'];
				$colors = array('#730601', '#a84600', '#e48801', '#ffdc9c');
				if($population_density[$sec['title']] <= $breaks[2] ) {
					$pop_color[$sec['title']] = $colors[3];
				} elseif($population_density[$sec['title']] >= ($breaks[2]+0.0000001) && $population_density[$sec['title']] <= $breaks[3] ) {
					$pop_color[$sec['title']] = $colors[2];
				} elseif($population_density[$sec['title']] >= ($breaks[3]+0.0000001) && $population_density[$sec['title']] <= $from ) {
					$pop_color[$sec['title']] = $colors[1];
				} elseif($population_density[$sec['title']] >= ($from+0.0000001) ) {
					$pop_color[$sec['title']] = $colors[0];
				}
			}
		} else {
			if($sectionCheck != $sec['title']) {
				$sectionCheck = $sec['title'];
				$sectionInfo[$sec['title']] = Info::SectionInfo($_GET['region'], $_GET['district'], $sec['title'], $_GET['year']);
				if($sectionInfo[$sec['title']] == NULL) {
					$pop_color[$sec['title']] = '#FFFFFF';
				} else {
					$population_density[$sec['title']] = $sectionInfo[$sec['title']]['population']/$sectionInfo[$sec['title']]['area_length'];
					$colors = array('#730601', '#a84600', '#e48801', '#ffdc9c');
				if($population_density[$sec['title']] <= $breaks[2] ) {
					$pop_color[$sec['title']] = $colors[3];
				} elseif($population_density[$sec['title']] >= ($breaks[2]+0.0000001) && $population_density[$sec['title']] <= $breaks[3] ) {
					$pop_color[$sec['title']] = $colors[2];
				} elseif($population_density[$sec['title']] >= ($breaks[3]+0.0000001) && $population_density[$sec['title']] <= $from ) {
					$pop_color[$sec['title']] = $colors[1];
				} elseif($population_density[$sec['title']] >= ($from+0.0000001) ) {
					$pop_color[$sec['title']] = $colors[0];
				}
				}
			}
		}
	}
	$bus = Marker::getType(1);
	$light = Marker::getType(7);
	$roads = Road::getRegionRoads($_GET['region']);
	$count_marker = Marker::countRegionYearMarkers($_GET['district'], $_GET['region'], 1);;
	foreach($regions as $reg) {
		$region_marker[$reg['id']] = Report::markerRegionCount(1, $reg['id'], $_GET['year']);	
	}
	require(SITE_TEMPLATE . "report/regionBusReport.php");
}

function districtProfileReport() {
	$district = District::getDistrict($_GET['district']);
	$districts = District::getDistrictList();
	$regions = Region::getRegionList($district['id']);
	foreach($regions as $reg) {
		$regionInfo[$reg['id']] = Info::RegionInfo($reg['id'], $_GET['year']);
		if($regionInfo[$reg['id']] == NULL) {
			$pop_color[$reg['id']] = '#FFFFFF';
			$school_color[$reg['id']] = '#FFFFFF';
			$kin_color[$reg['id']] = '#FFFFFF';
		} else {
				$population_density[$reg['id']] = ceil($regionInfo[$reg['id']]['population_density']);
				$school_ratio[$reg['id']] = ceil($regionInfo[$reg['id']]['school_ratio']);
				$kin_ratio[$reg['id']] = ceil($regionInfo[$reg['id']]['kin_ratio']);
				$colors = array('#730601', '#a84600', '#e48801', '#ffdc9c');
				if($population_density[$reg['id']] >= 0 && $population_density[$reg['id']] <= 50 ) {
					$pop_color[$reg['id']] = $colors[3];
				} elseif($population_density[$reg['id']] >= 51 && $population_density[$reg['id']] <= 100 ) {
					$pop_color[$reg['id']] = $colors[2];
				} elseif($population_density[$reg['id']] >= 101 && $population_density[$reg['id']] <= 200 ) {
					$pop_color[$reg['id']] = $colors[1];
				} elseif($population_density[$reg['id']] >= 201 ) {
					$pop_color[$reg['id']] = $colors[0];
				}
			
				if($school_ratio[$reg['id']] >= 0 && $school_ratio[$reg['id']] <= 21) {
					$school_color[$reg['id']] = $colors[3];
				} elseif($school_ratio[$reg['id']] >= 22 && $school_ratio[$reg['id']] <= 44) {
					$school_color[$reg['id']] = $colors[2];
				} elseif($school_ratio[$reg['id']] >= 45 && $school_ratio[$reg['id']] <= 64) {
					$school_color[$reg['id']] = $colors[1];
				} elseif($school_ratio[$reg['id']] >= 65) {
					$school_color[$reg['id']] = $colors[0];
				}
			
				if($kin_ratio[$reg['id']] >= 0 && $kin_ratio[$reg['id']] <= 21) {
					$kin_color[$reg['id']] = $colors[3];
				} elseif($kin_ratio[$reg['id']] >= 22 && $kin_ratio[$reg['id']] <= 44) {
					$kin_color[$reg['id']] = $colors[2];
				} elseif($kin_ratio[$reg['id']] >= 45 && $kin_ratio[$reg['id']] <= 64) {
					$kin_color[$reg['id']] = $colors[1];
				} elseif($kin_ratio[$reg['id']] >= 65) {
					$kin_color[$reg['id']] = $colors[0];
				}
		}
	}
	$bus = Marker::getType(1);
	$light = Marker::getType(7);
	$kindergarden = Marker::getType(3);
	$school =  Marker::getType(4);
	$trash =  Marker::getType(10);
	$crime = Marker::getType(6);
	$hospital = Marker::getType(9);
	$info = Info::reportDistrictInfo($_GET['district'], $_GET['year']);
	$trash_count = Report::markerDistrictCount(10, $_GET['district'], $_GET['year']);
	$hospital_count = Report::markerDistrictCount(9, $_GET['district'], $_GET['year']);
	require(SITE_TEMPLATE . "report/districtProfile.php");
}

function regionProfileReportPdf() {
	$district = District::getDistrict($_GET['district']);
	$region = Region::getRegion($_GET['region']);
	$info = Info::RegionInfo($region['id'], $_GET['year']);
	$regions = Region::getRegionList($district['id']);
	if($info == NULL) {
		require(SITE_TEMPLATE . "report/reportNotExist.php");
		exit;
	}
	$sections = Section::getRegionSections($_GET['region']);
	$playgrounds = Playground::getRegionPlaygrounds($_GET['region']);
	$count_parking = Marker::countRegionYearMarkers($_GET['district'], $_GET['region'], 20);
	$count_playground = Marker::countRegionYearMarkers($_GET['district'], $_GET['region'], 19);
	$count_hospital = Marker::countRegionYearMarkers($_GET['district'], $_GET['region'], 9);
	$sectionCheck = NULL;
	$count_sections = 0;
	$sectionDensityRows = Report::getSectionsPopDenstity($_GET['region'], $_GET['year']);

	foreach($sectionDensityRows as $secDenRows) {
		$sectionDensity[] = $secDenRows['population']/$secDenRows['area_length'];
	}
	sort( $sectionDensity );
	$breaks = Jenks::getBreaks( $sectionDensity, 4);
	
$cls = 1;
$from = $sectionDensity[ 0 ];
$prices = array_unique( $sectionDensity );
sort( $sectionDensity );

foreach( $sectionDensity as $i => $price ) {
	if( $price >= $breaks[ $cls ] ) {
		$count = 0;
		foreach( $sectionDensity as $p ) {
			if( $p >= $from && $p <= $price ) {
				$count++;
			}
		}
		if( isset( $sectionDensity[ $i + 1 ] ) ) {
			$from = $sectionDensity[ $i + 1 ];
		}

		$cls++;
	}
}

	foreach($sections as $sec) {
		if($sectionCheck == NULL) {
			$sectionCheck = $sec['title'];
			$sectionInfo[$sec['title']] = Info::SectionInfo($_GET['region'], $_GET['district'], $sec['title'], $_GET['year']);
			if($sectionInfo[$sec['title']] == NULL) {
				$pop_color[$sec['title']] = '#FFFFFF';
				$school_color[$sec['title']] = '#FFFFFF';
				$kin_color[$sec['title']] = '#FFFFFF';
			} else {
				$population_density[$sec['title']] = $sectionInfo[$sec['title']]['population']/$sectionInfo[$sec['title']]['area_length'];
				$school_ratio[$sec['title']] = ceil($sectionInfo[$sec['title']]['school_ratio']);
				$kin_ratio[$sec['title']] = ceil($sectionInfo[$sec['title']]['kin_ratio']);
				$colors = array('#730601', '#a84600', '#e48801', '#ffdc9c');
				if($population_density[$sec['title']] <= $breaks[2] ) {
					$pop_color[$sec['title']] = $colors[3];
				} elseif($population_density[$sec['title']] >= ($breaks[2]+0.0000001) && $population_density[$sec['title']] <= $breaks[3] ) {
					$pop_color[$sec['title']] = $colors[2];
				} elseif($population_density[$sec['title']] >= ($breaks[3]+0.0000001) && $population_density[$sec['title']] <= $from ) {
					$pop_color[$sec['title']] = $colors[1];
				} elseif($population_density[$sec['title']] >= ($from+0.0000001) ) {
					$pop_color[$sec['title']] = $colors[0];
				}
			
				if($school_ratio[$sec['title']] >= 0 && $school_ratio[$sec['title']] <= 21) {
					$school_color[$sec['title']] = $colors[3];
				} elseif($school_ratio[$sec['title']] >= 22 && $school_ratio[$sec['title']] <= 44) {
					$school_color[$sec['title']] = $colors[2];
				} elseif($school_ratio[$sec['title']] >= 45 && $school_ratio[$sec['title']] <= 64) {
					$school_color[$sec['idtitle']] = $colors[1];
				} elseif($school_ratio[$sec['title']] >= 65) {
					$school_color[$sec['title']] = $colors[0];
				}
			
				if($kin_ratio[$sec['title']] >= 0 && $kin_ratio[$sec['title']] <= 21) {
					$kin_color[$sec['title']] = $colors[3];
				} elseif($kin_ratio[$sec['title']] >= 22 && $kin_ratio[$sec['title']] <= 44) {
					$kin_color[$sec['title']] = $colors[2];
				} elseif($kin_ratio[$sec['title']] >= 45 && $kin_ratio[$sec['title']] <= 64) {
					$kin_color[$sec['title']] = $colors[1];
				} elseif($kin_ratio[$sec['title']] >= 65) {
					$kin_color[$sec['title']] = $colors[0];
				}
			}
		} else {
			if($sectionCheck != $sec['title']) {
				$sectionCheck = $sec['title'];
				$sectionInfo[$sec['title']] = Info::SectionInfo($_GET['region'], $_GET['district'], $sec['title'], $_GET['year']);
				if($sectionInfo[$sec['title']] == NULL) {
					$pop_color[$sec['title']] = '#FFFFFF';
					$school_color[$sec['title']] = '#FFFFFF';
					$kin_color[$sec['title']] = '#FFFFFF';
				} else {
					$population_density[$sec['title']] = $sectionInfo[$sec['title']]['population']/$sectionInfo[$sec['title']]['area_length'];
					$school_ratio[$sec['title']] = ceil($sectionInfo[$sec['title']]['school_ratio']);
					$kin_ratio[$sec['title']] = ceil($sectionInfo[$sec['title']]['kin_ratio']);
					$colors = array('#730601', '#a84600', '#e48801', '#ffdc9c');
				if($population_density[$sec['title']] <= $breaks[2] ) {
					$pop_color[$sec['title']] = $colors[3];
				} elseif($population_density[$sec['title']] >= ($breaks[2]+0.0000001) && $population_density[$sec['title']] <= $breaks[3] ) {
					$pop_color[$sec['title']] = $colors[2];
				} elseif($population_density[$sec['title']] >= ($breaks[3]+0.0000001) && $population_density[$sec['title']] <= $from ) {
					$pop_color[$sec['title']] = $colors[1];
				} elseif($population_density[$sec['title']] >= ($from+0.0000001) ) {
					$pop_color[$sec['title']] = $colors[0];
				}
			
					if($school_ratio[$sec['title']] >= 0 && $school_ratio[$sec['title']] <= 21) {
						$school_color[$sec['title']] = $colors[3];
					} elseif($school_ratio[$sec['title']] >= 22 && $school_ratio[$sec['title']] <= 44) {
						$school_color[$sec['title']] = $colors[2];
					} elseif($school_ratio[$sec['title']] >= 45 && $school_ratio[$sec['title']] <= 64) {
						$school_color[$sec['idtitle']] = $colors[1];
					} elseif($school_ratio[$sec['title']] >= 65) {
						$school_color[$sec['title']] = $colors[0];
					}
			
					if($kin_ratio[$sec['title']] >= 0 && $kin_ratio[$sec['title']] <= 21) {
						$kin_color[$sec['title']] = $colors[3];
					} elseif($kin_ratio[$sec['title']] >= 22 && $kin_ratio[$sec['title']] <= 44) {
						$kin_color[$sec['title']] = $colors[2];
					} elseif($kin_ratio[$sec['title']] >= 45 && $kin_ratio[$sec['title']] <= 64) {
						$kin_color[$sec['title']] = $colors[1];
					} elseif($kin_ratio[$sec['title']] >= 65) {
						$kin_color[$sec['title']] = $colors[0];
					}
				}
			}
		}
	}
	$bus = Marker::getType(1);
	$light = Marker::getType(7);
	$kindergarden = Marker::getType(3);
	$playground =  Marker::getType(19);
	$parking =  Marker::getType(20);
	$trash =  Marker::getType(10);
	$crime = Marker::getType(6);
	$hospital = Marker::getType(9);
	$torongarts = Torongarts::getRegionTorongarts($_GET['region']);
	$risks = Risks::getRegionRisks($_GET['region']);
	$trash_count = Report::markerRegionCount(10, $_GET['region'], $_GET['year']);
	require(SITE_TEMPLATE . "report/regionProfilePdf.php");
}

function regionProfileReport() {
	$district = District::getDistrict($_GET['district']);
	$region = Region::getRegion($_GET['region']);
	$info = Info::RegionInfo($region['id'], $_GET['year']);
	$regions = Region::getRegionList($district['id']);
	if($info == NULL) {
		require(SITE_TEMPLATE . "report/reportNotExist.php");
		exit;
	}
	$sections = Section::getRegionSections($_GET['region']);
	$playgrounds = Playground::getRegionPlaygrounds($_GET['region']);
	$count_parking = Marker::countRegionYearMarkers($_GET['district'], $_GET['region'],  20);
	$count_playground = Marker::countRegionYearMarkers($_GET['district'], $_GET['region'], 19);
	$count_hospital = Marker::countRegionYearMarkers($_GET['district'], $_GET['region'], 9);
	$sectionCheck = NULL;
	$count_sections = 0;
	$sectionDensityRows = Report::getSectionsPopDenstity($_GET['region'], $_GET['year']);
	if($sectionDensityRows == NULL) {
		require(SITE_TEMPLATE . "report/reportNotExist.php");
		exit;
	}
	foreach($sectionDensityRows as $secDenRows) {
		$sectionDensity[] = $secDenRows['population']/$secDenRows['area_length'];
	}
	sort( $sectionDensity );
	$breaks = Jenks::getBreaks( $sectionDensity, 4);
	
$cls = 1;
$from = $sectionDensity[ 0 ];
$prices = array_unique( $sectionDensity );
sort( $sectionDensity );

foreach( $sectionDensity as $i => $price ) {
	if( $price >= $breaks[ $cls ] ) {
		$count = 0;
		foreach( $sectionDensity as $p ) {
			if( $p >= $from && $p <= $price ) {
				$count++;
			}
		}
		if( isset( $sectionDensity[ $i + 1 ] ) ) {
			$from = $sectionDensity[ $i + 1 ];
		}

		$cls++;
	}
}
	
	foreach($sections as $sec) {
		if($sectionCheck == NULL) {
			$sectionCheck = $sec['title'];
			$sectionInfo[$sec['title']] = Info::SectionInfo($_GET['region'], $_GET['district'], $sec['title'], $_GET['year']);
			if($sectionInfo[$sec['title']] == NULL) {
				$pop_color[$sec['title']] = '#FFFFFF';
				$school_color[$sec['title']] = '#FFFFFF';
				$kin_color[$sec['title']] = '#FFFFFF';
			} else {
				$population_density[$sec['title']] = $sectionInfo[$sec['title']]['population']/$sectionInfo[$sec['title']]['area_length'];
				$school_ratio[$sec['title']] = ceil($sectionInfo[$sec['title']]['school_ratio']);
				$kin_ratio[$sec['title']] = ceil($sectionInfo[$sec['title']]['kin_ratio']);
				$colors = array('#730601', '#a84600', '#e48801', '#ffdc9c');
				if($population_density[$sec['title']] <= $breaks[2] ) {
					$pop_color[$sec['title']] = $colors[3];
				} elseif($population_density[$sec['title']] >= ($breaks[2]+0.0000001) && $population_density[$sec['title']] <= $breaks[3] ) {
					$pop_color[$sec['title']] = $colors[2];
				} elseif($population_density[$sec['title']] >= ($breaks[3]+0.0000001) && $population_density[$sec['title']] <= $from ) {
					$pop_color[$sec['title']] = $colors[1];
				} elseif($population_density[$sec['title']] >= ($from+0.0000001) ) {
					$pop_color[$sec['title']] = $colors[0];
				}
			
				if($school_ratio[$sec['title']] >= 0 && $school_ratio[$sec['title']] <= 21) {
					$school_color[$sec['title']] = $colors[3];
				} elseif($school_ratio[$sec['title']] >= 22 && $school_ratio[$sec['title']] <= 44) {
					$school_color[$sec['title']] = $colors[2];
				} elseif($school_ratio[$sec['title']] >= 45 && $school_ratio[$sec['title']] <= 64) {
					$school_color[$sec['idtitle']] = $colors[1];
				} elseif($school_ratio[$sec['title']] >= 65) {
					$school_color[$sec['title']] = $colors[0];
				}
			
				if($kin_ratio[$sec['title']] >= 0 && $kin_ratio[$sec['title']] <= 21) {
					$kin_color[$sec['title']] = $colors[3];
				} elseif($kin_ratio[$sec['title']] >= 22 && $kin_ratio[$sec['title']] <= 44) {
					$kin_color[$sec['title']] = $colors[2];
				} elseif($kin_ratio[$sec['title']] >= 45 && $kin_ratio[$sec['title']] <= 64) {
					$kin_color[$sec['title']] = $colors[1];
				} elseif($kin_ratio[$sec['title']] >= 65) {
					$kin_color[$sec['title']] = $colors[0];
				}
			}
		} else {
			if($sectionCheck != $sec['title']) {
				$sectionCheck = $sec['title'];
				$sectionInfo[$sec['title']] = Info::SectionInfo($_GET['region'], $_GET['district'], $sec['title'], $_GET['year']);
				if($sectionInfo[$sec['title']] == NULL) {
					$pop_color[$sec['title']] = '#FFFFFF';
					$school_color[$sec['title']] = '#FFFFFF';
					$kin_color[$sec['title']] = '#FFFFFF';
				} else {
					$population_density[$sec['title']] = $sectionInfo[$sec['title']]['population']/$sectionInfo[$sec['title']]['area_length'];
					$school_ratio[$sec['title']] = ceil($sectionInfo[$sec['title']]['school_ratio']);
					$kin_ratio[$sec['title']] = ceil($sectionInfo[$sec['title']]['kin_ratio']);
					$colors = array('#730601', '#a84600', '#e48801', '#ffdc9c');
				if($population_density[$sec['title']] <= $breaks[2] ) {
					$pop_color[$sec['title']] = $colors[3];
				} elseif($population_density[$sec['title']] >= ($breaks[2]+0.0000001) && $population_density[$sec['title']] <= $breaks[3] ) {
					$pop_color[$sec['title']] = $colors[2];
				} elseif($population_density[$sec['title']] >= ($breaks[3]+0.0000001) && $population_density[$sec['title']] <= $from ) {
					$pop_color[$sec['title']] = $colors[1];
				} elseif($population_density[$sec['title']] >= ($from+0.0000001) ) {
					$pop_color[$sec['title']] = $colors[0];
				}
			
					if($school_ratio[$sec['title']] >= 0 && $school_ratio[$sec['title']] <= 21) {
						$school_color[$sec['title']] = $colors[3];
					} elseif($school_ratio[$sec['title']] >= 22 && $school_ratio[$sec['title']] <= 44) {
						$school_color[$sec['title']] = $colors[2];
					} elseif($school_ratio[$sec['title']] >= 45 && $school_ratio[$sec['title']] <= 64) {
						$school_color[$sec['idtitle']] = $colors[1];
					} elseif($school_ratio[$sec['title']] >= 65) {
						$school_color[$sec['title']] = $colors[0];
					}
			
					if($kin_ratio[$sec['title']] >= 0 && $kin_ratio[$sec['title']] <= 21) {
						$kin_color[$sec['title']] = $colors[3];
					} elseif($kin_ratio[$sec['title']] >= 22 && $kin_ratio[$sec['title']] <= 44) {
						$kin_color[$sec['title']] = $colors[2];
					} elseif($kin_ratio[$sec['title']] >= 45 && $kin_ratio[$sec['title']] <= 64) {
						$kin_color[$sec['title']] = $colors[1];
					} elseif($kin_ratio[$sec['title']] >= 65) {
						$kin_color[$sec['title']] = $colors[0];
					}
				}
			}
		}
	}
	$bus = Marker::getType(1);
	$light = Marker::getType(7);
	$kindergarden = Marker::getType(3);
	$playground =  Marker::getType(19);
	$parking =  Marker::getType(20);
	$trash =  Marker::getType(10);
	$crime = Marker::getType(6);
	$hospital = Marker::getType(9);
	$torongarts = Torongarts::getRegionTorongarts($_GET['region']);
	$risks = Risks::getRegionRisks($_GET['region']);
	$roads = Road::getRegionRoads($_GET['region']);
	$trash_count = Marker::countRegionYearMarkers($_GET['district'], $_GET['region'], 10);
	require(SITE_TEMPLATE . "report/regionProfile.php");
}

function regionInfo() {
	$district = District::getDistrict($_GET['district'], $_GET['year']);
	$district_infos = Report::getRegionInfo($_GET['district']);
	require( SITE_TEMPLATE . "report/reportDistrictInfo.php" );
}

function regionReport() {
	$district = District::getDistrict($_GET['district']);
	$region = Region::getRegion($_GET['region']);
	$type = Marker::getType($_GET['type']);
	$info = Info::RegionInfo($region['id'], $_GET['year']);
	$population_density = ceil($info['population_density']);
	$colors = array('#8683ab', '#998cb0', '#c6b9ca', '#e7dfdf');
	if($population_density >= 0 && $population_density <= 48 ) {
		$pop_color = $colors[3];
	} elseif($population_density >= 49 && $population_density <= 77 ) {
		$pop_color = $colors[2];
	} elseif($population_density >= 78 && $population_density <= 101 ) {
		$pop_color = $colors[1];
	} elseif($population_density >= 102 ) {
		$pop_color = $colors[0];
	}
	require( SITE_TEMPLATE . "report/reportRegion.php" );
}

function reportListBack() {
	$years = Year::getYearList();
	$districts = District::getDistrictList();
	$region_list = Region::getRegionList($_GET['district']);
	require( SITE_TEMPLATE . "report/reportListBack.php" );
}

function reportDistrictListBack() {
	$years = Year::getYearList();
	$districts = District::getDistrictList();
	$region_list = Region::getRegionList($_GET['district']);
	require( SITE_TEMPLATE . "report/reportDistrictListBack.php" );
}

function reportView() {
	if (isset($_POST['selectType'])) {
		header( "Location: markers.php?action=districtAdd&type=".$_POST['type_id'] );	
	}
	$years = Year::getYearList();
	$districts = District::getDistrictList();
	require( SITE_TEMPLATE . "report/reportList.php" );
}

function getRegionMarkers() {
	$results = Marker::regionMarkers($_GET['type'], $_GET['region']);
	$data['coordinate'] = array();
	$k = 0;
	foreach($results as $result) {
		$data['coordinate'][$k][] = $result['latitude'];
		$data['coordinate'][$k][] = $result['longitude'];
		$k = $k + 1;
	}
	header('Content-type: application/json');
	echo json_encode($data);
}

function getRegionMarks() {
	$results = Marker::regionYearMarkers($_GET['type'], $_GET['region'], $_GET['year']);
	$data['coordinate'] = array();
	$k = 0;
	foreach($results as $result) {
		$data['coordinate'][$k][] = $result['latitude'];
		$data['coordinate'][$k][] = $result['longitude'];
		$k = $k + 1;
	}
	header('Content-type: application/json');
	echo json_encode($data);
}

?>