<?php
//error_reporting(0);
require(realpath(dirname(__FILE__))."/config/settings.php");
require_once(realpath(dirname(__FILE__))."/classes/Info.class.php");
require_once(realpath(dirname(__FILE__))."/classes/Marker.class.php");
require_once(realpath(dirname(__FILE__))."/classes/Link.class.php");
require_once(realpath(dirname(__FILE__))."/classes/Section.class.php");
require_once(realpath(dirname(__FILE__))."/classes/Region.class.php");
require_once(realpath(dirname(__FILE__))."/classes/Year.class.php");
require_once(realpath(dirname(__FILE__))."/classes/Risks.class.php");
require_once(realpath(dirname(__FILE__))."/classes/Playground.class.php");
require_once(realpath(dirname(__FILE__))."/classes/Road.class.php");
require_once(realpath(dirname(__FILE__))."/classes/Report.class.php");
@include_once( '/home2/manaikho/public_html/stat/stats-include.php' );
$action = isset( $_GET['action'] ) ? $_GET['action'] : "";

switch ( $action ) {
	case "addBorderDistrict":
		addBorderDistrict();
		break;
	case "addMarkerDistrict":
		addMarkerDistrict();
		break;
	case "regionView":
		regionView();
		break;
	case "regionSingle":
		regionSingle();
		break;
	case "getMarkers":
		getMarkers();
		break;
	case "getInfoMarkers":
		getInfoMarkers();
		break;
	case "regionBorder":
		regionBorder();
		break;
	case "regionBoundary":
		regionBoundary();
		break;
	case "markerInfo":
		markerInfo();
		break;
	case "getRegionMarkers":
		getRegionMarkers();
		break;
	case "risksBorder":
		risksBorder();
		break;
	case "playgroundBorder":
		playgroundBorder();
		break;
	case 'roadBorder':
		roadBorder();
		break;
	default:
		districtView();
}

function regionBorder() {
		$results = Marker::getRegionborder($_GET['region']);
		$data['coordinate'] = array();
		$k = 0;
		foreach($results as $result) {
			$data['coordinate'][$k] = explode(',', $result['coordinate'], 2);
			$k = $k + 1;
		}
		header('Content-type: application/json');
		echo json_encode($data);
}

function getRegionMarkers() {
	$results = Marker::regionMarkers($_GET['type'], $_GET['region']);
	$data = array();
	$k = 0;
	foreach($results as $result) {
		$data['coordinate'][$k][] = $result['latitude'];
		$data['coordinate'][$k][] = $result['longitude'];
		$k = $k + 1;
	}
	header('Content-type: application/json');
	echo json_encode($data);
}

function getInfoMarkers() {
	$current_year = Year::getDefaultYear();
	$results = Marker::getDistrictInfoMarkers($_GET['type'], $_GET['district'], $current_year['year']);
	$data = array();
	$k = 0;
	foreach($results['marker'] as $result) {
		$data['coordinate'][$k][] = $result['latitude'];
		$data['coordinate'][$k][] = $result['longitude'];
		$data['info'][$k][] = $result['title'];
		$data['info'][$k][] = $result['phone'];
		$data['info'][$k][] = $result['email'];
		$data['info'][$k][] = $result['description'];
		$k = $k + 1;
	}
	$data['image'] = $results['type']['image'];
	header('Content-type: application/json');
	echo json_encode($data);
}

function getMarkers() {
	$current_year = Year::getDefaultYear();
	$results = Marker::getDistrictMarkers($_GET['type'], $_GET['district'], $current_year['year']);
	$data = array();
	$k = 0;
	foreach($results['marker'] as $result) {
		$data['coordinate'][$k][] = $result['latitude'];
		$data['coordinate'][$k][] = $result['longitude'];
		$k = $k + 1;
	}
	$data['image'] = $results['type']['image'];
	header('Content-type: application/json');
	echo json_encode($data);
}

function addMarkerDistrict() {
	$results = Marker::allMarkers($_GET['type']);
	$data['marker'] = array();
	$k = 0;
	foreach($results['coordinate'] as $result) {
		$data['marker'][$k][] = $result['latitude'];
		$data['marker'][$k][] = $result['longitude'];
		$k = $k + 1;
	}
	$data['image'] = $results['image'];
	header('Content-type: application/json');
	echo json_encode($data);
}

function addBorderDistrict() {
	$results = Marker::addDistrictBorder($_GET['district']);
	$data['coordinate'] = array();
	$k = 0;
	foreach($results['border'] as $result) {
		$data['coordinate'][$k] = explode(',', $result['coordinate'], 2);
		$k = $k + 1;
	}
	$data['image'] = $results['image']['image'];
	header('Content-type: application/json');
	echo json_encode($data);
}

function districtView() {
	$results = Marker::districtView();
	$pop_color = array("#ffdc9c", "#e48801", "#a84600", "#730601");
	$kin_color = array("#ffdc9c", "#e48801", "#a84600", "#730601");
	$school_color = array("#ffdc9c", "#e48801", "#a84600", "#730601");
	
	foreach($results['districts'] as $district) {
		$regions[$district['id']] = Region::getRegionList($district['id']);
		foreach($regions[$district['id']] as $region) {
	$sectionCheck = NULL;
	$count_sections = 0;
	$sectionDensityRows = Report::getSectionsPopDenstity($region['id'], $results['year']['year']);
if($sectionDensityRows != NULL) {
	foreach($sectionDensityRows as $secDenRows) {
		$sectionDensity[] = $secDenRows['population_density'];
	}
	$max_density = max($sectionDensity);
	$min_density = min($sectionDensity);
	foreach($sectionDensity as $secDen) {
		$count_sections = $count_sections + 1;
		$density_average = $density_average + $secDen;
	}
	$density_average = $density_average/$count_sections;
	$secCount = array();
	$sdam = 0;
	for($m=0; $m<$count_sections; $m++) {
		$subtract_sdam = $sectionDensity[$m]-$density_average;
		$exp_sd = $subtract_sdam*$subtract_sdam;
		$sdam = $sdam + $exp_sd;
	}
	$b = 0;
	for($m=0; $m<$count_sections-1; $m++) {
		if($m == 4) {
			break;
		}
		$b = $b + 1;
		$sdcm1_average[$m] = 0;
		$sdcm2_average[$m] = 0;
		for($n=0; $n < $b; $n++) {
			$sdcm1_average[$m] = $sdcm1_average[$m] + $sectionDensity[$n];
		}
		$sdcm1_average[$m] = $sdcm1_average[$m]/$b;
		$sdcm1[$m] = 0;
		for($n=0; $n < $b; $n++) {
			$subtract_sdcm1 = $sectionDensity[$n] - $sdcm1_average[$m];
			$exp_sdcm1 = $subtract_sdcm1*$subtract_sdcm1;
			$sdcm1[$m] = $sdcm1[$m] + $exp_sdcm1;
		}
		for($x=$m+1; $x < $count_sections; $x++) {
			$sdcm2_average[$m] = $sdcm2_average[$m] + $sectionDensity[$x];
		}
		$sdcm2_average[$m] = $sdcm2_average[$m]/($count_sections-$m-1);
		$sdcm2[$m] = 0;
		for($x=$m+1; $x < $count_sections; $x++) {
			$subtract_sdcm2 = $sectionDensity[$x] - $sdcm2_average[$m];
			$exp_sdcm2 = $subtract_sdcm2*$subtract_sdcm2;
			$sdcm2[$m] = $sdcm2[$m] + $exp_sdcm2;
		}
		$sdcm[$m] = $sdcm1[$m] + $sdcm2[$m];
		$gvf[$m] = ($sdam - $sdcm[$m])/$sdam;
	}
if($max_indicator[0] != NULL || isset($max_indicator[0])) {
	for($i=0;$i<=3;$i++) {
		$max_gvf = 0;
		foreach($gvf as $gf) {
			if($max_gvf == 0) {
				$max_gvf = $gf;
			}
			if($max_gvf < $gf) {
				$max_gvf = $gf;
			}
		}
		$key = array_search($max_gvf, $gvf);
		$max_indicator[$i] = array('gvf' => $max_gvf, 'density' => $sectionDensity[$key]);
		unset($gvf[$key]);
	}
	$mi_index = 0;
	foreach($prev_max_gvf['gvf'] as $pmgvf) {
		foreach($max_indicator as $mi) {
			if($pmgvf < $mi) {
				$max_gvf = $gf;
			} else {
				$max_gvf = 0;
			}
		}
		if($max_gvf != 0) {
			$key = array_search($max_gvf, $max_indicator);
			$max_indicator[$mi_index] = array('gvf' => $max_gvf, 'density' => $sectionDensity[$mi_index]);
			$prev_max_gvf['gvf'][$mi_index] = $max_gvf;
			$prev_max_gvf['density'][$mi_index] = $sectionDensity[$mi_index];
		}
		$mi_index = $mi_index + 1;
	}
} else {
	$prev_index = 4;
	for($i=0;$i<=3;$i++) {
		$max_gvf = 0;
		foreach($gvf as $gf) {
			if($max_gvf == 0) {
				$max_gvf = $gf;
			}
			if($max_gvf < $gf) {
				$max_gvf = $gf;
			}
		}
		$key = array_search($max_gvf, $gvf);
		$max_indicator[$i] = array('gvf' => $max_gvf, 'density' => $sectionDensity[$key]);
		$prev_max_gvf['gvf'][$prev_index] = $max_gvf;
		$prev_max_gvf['density'][$prev_index] = $sectionDensity[$key];
		$prev_index = $prev_index + 1; 
		unset($gvf[$key]);
	}
}
}
			$sections[$region['id']] = Section::getRegionSections($region['id']);
		}
		
		foreach($regions[$district['id']] as $region) {
			foreach($sections[$region['id']] as $sec) {
				$secInfo[$region['id']][$sec['id']] = Info::SectionInfo($region['id'], $district['id'], $sec['title'], $results['year']['year']);
				if($secInfo[$region['id']][$sec['id']] != NULL) {
				
				if($secInfo[$region['id']][$sec['id']]['population_density'] <= $max_indicator[0]['density'] ) {
					$pop_district[$region['id']][$sec['id']] = $pop_color[0];
				} elseif($secInfo[$region['id']][$sec['id']]['population_density'] > $max_indicator[0]['density'] && $secInfo[$region['id']][$sec['id']]['population_density'] <= $max_indicator[1]['density']) {
					$pop_district[$region['id']][$sec['id']] = $pop_color[1];
				} elseif($secInfo[$region['id']][$sec['id']]['population_density'] > $max_indicator[1]['density'] && $secInfo[$region['id']][$sec['id']]['population_density'] <= $max_indicator[2]['density']) {
					$pop_district[$region['id']][$sec['id']] = $pop_color[2];
				} else {
					$pop_district[$region['id']][$sec['id']] = $pop_color[3];
				}
				
				if($secInfo[$region['id']][$sec['id']]['kin_ratio'] <= 25 ) {
					$kin_district[$region['id']][$sec['id']] = $kin_color[0];
				} elseif($secInfo[$region['id']][$sec['id']]['kin_ratio'] > 25 && $secInfo[$region['id']][$sec['id']]['kin_ratio'] <= 50) {
					$kin_district[$region['id']][$sec['id']] = $kin_color[1];
				} elseif($secInfo[$region['id']][$sec['id']]['kin_ratio'] > 50 && $secInfo[$region['id']][$sec['id']]['kin_ratio'] <= 75) {
					$kin_district[$region['id']][$sec['id']] = $kin_color[2];
				} else {
					$kin_district[$region['id']][$sec['id']] = $kin_color[3];
				}
				
				if($secInfo[$region['id']][$sec['id']]['school_ratio'] <= 25 ) {
					$school_district[$region['id']][$sec['id']] = $school_color[0];
				} elseif($secInfo[$region['id']][$sec['id']]['school_ratio'] > 25 && $secInfo[$region['id']][$sec['id']]['school_ratio'] <= 50) {
					$school_district[$region['id']][$sec['id']] = $school_color[1];
				} elseif($secInfo[$region['id']][$sec['id']]['school_ratio'] > 50 && $secInfo[$region['id']][$sec['id']]['school_ratio'] <= 75) {
					$school_district[$region['id']][$sec['id']] = $school_color[2];
				} else {
					$school_district[$region['id']][$sec['id']] = $school_color[3];
				}

				
				}
			}
		}
		
		$floods[$district['id']] = Risks::getDistrictRisks($district['id']);
		$pls[$district['id']] = Playground::getDistrictPlaygrounds($district['id']);
		$roads[$district['id']] = Road::getDistrictRoads($district['id']);
	}
	require(SITE_TEMPLATE."markers/districtView.php");
}

function regionView() {
	$results = Marker::regionView($_GET['district']);
	$pop_color = array("#ffdc9c", "#e48801", "#a84600", "#730601");
	$kin_color = array("#ffdc9c", "#e48801", "#a84600", "#730601");
	$school_color = array("#ffdc9c", "#e48801", "#a84600", "#730601");
	
foreach($results['regions'] as $region) {
	$sectionCheck = NULL;
	$count_sections = 0;
	$sectionDensityRows = Report::getSectionsPopDenstity($region['id'], $results['year']['year']);
if($sectionDensityRows != NULL) {
	foreach($sectionDensityRows as $secDenRows) {
		$sectionDensity[] = $secDenRows['population_density'];
	}
	$max_density = max($sectionDensity);
	$min_density = min($sectionDensity);
	foreach($sectionDensity as $secDen) {
		$count_sections = $count_sections + 1;
		$density_average = $density_average + $secDen;
	}
	$density_average = $density_average/$count_sections;
	$secCount = array();
	$sdam = 0;
	for($m=0; $m<$count_sections; $m++) {
		$subtract_sdam = $sectionDensity[$m]-$density_average;
		$exp_sd = $subtract_sdam*$subtract_sdam;
		$sdam = $sdam + $exp_sd;
	}
	$b = 0;
	for($m=0; $m<$count_sections-1; $m++) {
		if($m == 4) {
			break;
		}
		$b = $b + 1;
		$sdcm1_average[$m] = 0;
		$sdcm2_average[$m] = 0;
		for($n=0; $n < $b; $n++) {
			$sdcm1_average[$m] = $sdcm1_average[$m] + $sectionDensity[$n];
		}
		$sdcm1_average[$m] = $sdcm1_average[$m]/$b;
		$sdcm1[$m] = 0;
		for($n=0; $n < $b; $n++) {
			$subtract_sdcm1 = $sectionDensity[$n] - $sdcm1_average[$m];
			$exp_sdcm1 = $subtract_sdcm1*$subtract_sdcm1;
			$sdcm1[$m] = $sdcm1[$m] + $exp_sdcm1;
		}
		for($x=$m+1; $x < $count_sections; $x++) {
			$sdcm2_average[$m] = $sdcm2_average[$m] + $sectionDensity[$x];
		}
		$sdcm2_average[$m] = $sdcm2_average[$m]/($count_sections-$m-1);
		$sdcm2[$m] = 0;
		for($x=$m+1; $x < $count_sections; $x++) {
			$subtract_sdcm2 = $sectionDensity[$x] - $sdcm2_average[$m];
			$exp_sdcm2 = $subtract_sdcm2*$subtract_sdcm2;
			$sdcm2[$m] = $sdcm2[$m] + $exp_sdcm2;
		}
		$sdcm[$m] = $sdcm1[$m] + $sdcm2[$m];
		$gvf[$m] = ($sdam - $sdcm[$m])/$sdam;
	}
if($max_indicator[0] != NULL || isset($max_indicator[0])) {
	for($i=0;$i<=3;$i++) {
		$max_gvf = 0;
		foreach($gvf as $gf) {
			if($max_gvf == 0) {
				$max_gvf = $gf;
			}
			if($max_gvf < $gf) {
				$max_gvf = $gf;
			}
		}
		$key = array_search($max_gvf, $gvf);
		$max_indicator[$i] = array('gvf' => $max_gvf, 'density' => $sectionDensity[$key]);
		unset($gvf[$key]);
	}
	$mi_index = 0;
	foreach($prev_max_gvf['gvf'] as $pmgvf) {
		foreach($max_indicator as $mi) {
			if($pmgvf < $mi) {
				$max_gvf = $gf;
			} else {
				$max_gvf = 0;
			}
		}
		if($max_gvf != 0) {
			$key = array_search($max_gvf, $max_indicator);
			$max_indicator[$mi_index] = array('gvf' => $max_gvf, 'density' => $sectionDensity[$mi_index]);
			$prev_max_gvf['gvf'][$mi_index] = $max_gvf;
			$prev_max_gvf['density'][$mi_index] = $sectionDensity[$mi_index];
		}
		$mi_index = $mi_index + 1;
	}
} else {
	$prev_index = 4;
	for($i=0;$i<=3;$i++) {
		$max_gvf = 0;
		foreach($gvf as $gf) {
			if($max_gvf == 0) {
				$max_gvf = $gf;
			}
			if($max_gvf < $gf) {
				$max_gvf = $gf;
			}
		}
		$key = array_search($max_gvf, $gvf);
		$max_indicator[$i] = array('gvf' => $max_gvf, 'density' => $sectionDensity[$key]);
		$prev_max_gvf['gvf'][$prev_index] = $max_gvf;
		$prev_max_gvf['density'][$prev_index] = $sectionDensity[$key];
		$prev_index = $prev_index + 1; 
		unset($gvf[$key]);
	}
}
}
}
	
	foreach($results['regions'] as $region) {
		$sections[$region['id']] = Section::getRegionSections($region['id']);
		if($sections[$region['id']] != NULL) {
			foreach($sections[$region['id']] as $sec) {
				$secInfo[$region['id']][$sec['id']] = Info::SectionInfo($region['id'], $_GET['district'], $sec['title'], $results['year']['year']);
				if($secInfo[$region['id']][$sec['id']] != NULL) {
				
				if($secInfo[$region['id']][$sec['id']]['population_density'] <= $max_indicator[0]['density'] ) {
					$pop_district[$region['id']][$sec['id']] = $pop_color[0];
				} elseif($secInfo[$region['id']][$sec['id']]['population_density'] > $max_indicator[0]['density'] && $secInfo[$region['id']][$sec['id']]['population_density'] <= $max_indicator[1]['density']) {
					$pop_district[$region['id']][$sec['id']] = $pop_color[1];
				} elseif($secInfo[$region['id']][$sec['id']]['population_density'] > $max_indicator[1]['density'] && $secInfo[$region['id']][$sec['id']]['population_density'] <= $max_indicator[2]['density']) {
					$pop_district[$region['id']][$sec['id']] = $pop_color[2];
				} else {
					$pop_district[$region['id']][$sec['id']] = $pop_color[3];
				}
				
				if($secInfo[$region['id']][$sec['id']]['kin_ratio'] <= 25 ) {
					$kin_district[$region['id']][$sec['id']] = $kin_color[0];
				} elseif($secInfo[$region['id']][$sec['id']]['kin_ratio'] > 25 && $secInfo[$region['id']][$sec['id']]['kin_ratio'] <= 50) {
					$kin_district[$region['id']][$sec['id']] = $kin_color[1];
				} elseif($secInfo[$region['id']][$sec['id']]['kin_ratio'] > 50 && $secInfo[$region['id']][$sec['id']]['kin_ratio'] <= 75) {
					$kin_district[$region['id']][$sec['id']] = $kin_color[2];
				} else {
					$kin_district[$region['id']][$sec['id']] = $kin_color[3];
				}
				
				if($secInfo[$region['id']][$sec['id']]['school_ratio'] <= 25 ) {
					$school_district[$region['id']][$sec['id']] = $school_color[0];
				} elseif($secInfo[$region['id']][$sec['id']]['school_ratio'] > 25 && $secInfo[$region['id']][$sec['id']]['school_ratio'] <= 50) {
					$school_district[$region['id']][$sec['id']] = $school_color[1];
				} elseif($secInfo[$region['id']][$sec['id']]['school_ratio'] > 50 && $secInfo[$region['id']][$sec['id']]['school_ratio'] <= 75) {
					$school_district[$region['id']][$sec['id']] = $school_color[2];
				} else {
					$school_district[$region['id']][$sec['id']] = $school_color[3];
				}

				
				}
				
			}
		}
		
		$sections[$region['id']] = Section::getRegionSections($region['id']);
		$floods[$region['id']] = Risks::getRegionRisks($region['id']);
		$pls[$region['id']] = Playground::getRegionPlaygrounds($region['id']);
	}
	$roads = Road::getDistrictRoads($_GET['district']);
	$years = Year::getYearList();
	$default_year = Year::getDefaultYear();
	$districtArea = Marker::getDistrictAreaLength($_GET['district'], $default_year['year']);
	if($districtArea == NULL) {
		$districtArea = Marker::getDistrictAreaLength($_GET['district'], $default_year['year']- 1);
		if($districtArea == NULL) {
			$districtArea = Marker::getDistrictAreaLength($_GET['district'], $default_year['year'] - 2);
		}
	}
	$cityMarkerCount['well'] = Marker::countCityYearMarkers($default_year['year'], 2);
	$cityMarkerCount['hospital'] = Marker::countCityYearMarkers($default_year['year'], 9);
	$cityMarkerCount['trash'] = Marker::countCityYearMarkers($default_year['year'], 10);
	$districtMarkerCount['well'] = Marker::countDistrictYearMarkers($_GET['district'], $default_year['year'], 2);
	$districtMarkerCount['hospital'] = Marker::countDistrictYearMarkers($_GET['district'], $default_year['year'], 9);
	$districtMarkerCount['trash'] = Marker::countDistrictYearMarkers($_GET['district'], $default_year['year'], 10);
	$indicators = array('Хүн амын тоо', 'Нийт өрхийн тоо', 'Өрхийн дундаж хэмжээ', 'Газар нутгийн хэмжээ', 'Хүн амын нягтаршил', 'Автобусны буудлаас 5 минут алхах зайд амьдардаг хүн амын %', 'Усны худгийн тоо', 'Усны худгаас 5 минут алхах зайд амьдардаг хүн амын %', '1000 хүнд ноогдох усны худгийн харьцаа', 'Албан бус хогийн цэгийн тоо', 'Аюултай бүсээс 100м зайнд амьдардаг хүн амын %', 'Өрхийн болон бусад эмнэлэгийн харьцаа', '2-5 насны цэцэрлэгэт хамрагддаггүй хүүхдийн тоо', '2-5 насны цэцэрлэгэт хамрагддаггүй хүүхдийн %', '6-16 насны сургуульд хамрагддаггүй хүүхдийн тоо', '6-16 насны сургуульд хамрагддаггүй хүүхдийн %');
	require(SITE_TEMPLATE."markers/regionView.php");
}

function regionSingle() {
	$results = Marker::regionView($_GET['district']);
	$pop_color = array("#ffdc9c", "#e48801", "#a84600", "#730601");
	$kin_color = array("#ffdc9c", "#e48801", "#a84600", "#730601");
	$school_color = array("#ffdc9c", "#e48801", "#a84600", "#730601");
	
	foreach($results['regions'] as $region) {
	$sectionCheck = NULL;
	$count_sections = 0;
	$sectionDensityRows = Report::getSectionsPopDenstity($region['id'], $results['year']['year']);
if($sectionDensityRows != NULL) {
	foreach($sectionDensityRows as $secDenRows) {
		$sectionDensity[] = $secDenRows['population_density'];
	}
	$max_density = max($sectionDensity);
	$min_density = min($sectionDensity);
	foreach($sectionDensity as $secDen) {
		$count_sections = $count_sections + 1;
		$density_average = $density_average + $secDen;
	}
	$density_average = $density_average/$count_sections;
	$secCount = array();
	$sdam = 0;
	for($m=0; $m<$count_sections; $m++) {
		$subtract_sdam = $sectionDensity[$m]-$density_average;
		$exp_sd = $subtract_sdam*$subtract_sdam;
		$sdam = $sdam + $exp_sd;
	}
	$b = 0;
	for($m=0; $m<$count_sections-1; $m++) {
		if($m == 4) {
			break;
		}
		$b = $b + 1;
		$sdcm1_average[$m] = 0;
		$sdcm2_average[$m] = 0;
		for($n=0; $n < $b; $n++) {
			$sdcm1_average[$m] = $sdcm1_average[$m] + $sectionDensity[$n];
		}
		$sdcm1_average[$m] = $sdcm1_average[$m]/$b;
		$sdcm1[$m] = 0;
		for($n=0; $n < $b; $n++) {
			$subtract_sdcm1 = $sectionDensity[$n] - $sdcm1_average[$m];
			$exp_sdcm1 = $subtract_sdcm1*$subtract_sdcm1;
			$sdcm1[$m] = $sdcm1[$m] + $exp_sdcm1;
		}
		for($x=$m+1; $x < $count_sections; $x++) {
			$sdcm2_average[$m] = $sdcm2_average[$m] + $sectionDensity[$x];
		}
		$sdcm2_average[$m] = $sdcm2_average[$m]/($count_sections-$m-1);
		$sdcm2[$m] = 0;
		for($x=$m+1; $x < $count_sections; $x++) {
			$subtract_sdcm2 = $sectionDensity[$x] - $sdcm2_average[$m];
			$exp_sdcm2 = $subtract_sdcm2*$subtract_sdcm2;
			$sdcm2[$m] = $sdcm2[$m] + $exp_sdcm2;
		}
		$sdcm[$m] = $sdcm1[$m] + $sdcm2[$m];
		$gvf[$m] = ($sdam - $sdcm[$m])/$sdam;
	}
if($max_indicator[0] != NULL || isset($max_indicator[0])) {
	for($i=0;$i<=3;$i++) {
		$max_gvf = 0;
		foreach($gvf as $gf) {
			if($max_gvf == 0) {
				$max_gvf = $gf;
			}
			if($max_gvf < $gf) {
				$max_gvf = $gf;
			}
		}
		$key = array_search($max_gvf, $gvf);
		$max_indicator[$i] = array('gvf' => $max_gvf, 'density' => $sectionDensity[$key]);
		unset($gvf[$key]);
	}
	$mi_index = 0;
	foreach($prev_max_gvf['gvf'] as $pmgvf) {
		foreach($max_indicator as $mi) {
			if($pmgvf < $mi) {
				$max_gvf = $gf;
			} else {
				$max_gvf = 0;
			}
		}
		if($max_gvf != 0) {
			$key = array_search($max_gvf, $max_indicator);
			$max_indicator[$mi_index] = array('gvf' => $max_gvf, 'density' => $sectionDensity[$mi_index]);
			$prev_max_gvf['gvf'][$mi_index] = $max_gvf;
			$prev_max_gvf['density'][$mi_index] = $sectionDensity[$mi_index];
		}
		$mi_index = $mi_index + 1;
	}
} else {
	$prev_index = 4;
	for($i=0;$i<=3;$i++) {
		$max_gvf = 0;
		foreach($gvf as $gf) {
			if($max_gvf == 0) {
				$max_gvf = $gf;
			}
			if($max_gvf < $gf) {
				$max_gvf = $gf;
			}
		}
		$key = array_search($max_gvf, $gvf);
		$max_indicator[$i] = array('gvf' => $max_gvf, 'density' => $sectionDensity[$key]);
		$prev_max_gvf['gvf'][$prev_index] = $max_gvf;
		$prev_max_gvf['density'][$prev_index] = $sectionDensity[$key];
		$prev_index = $prev_index + 1; 
		unset($gvf[$key]);
	}
}
}
}

	foreach($results['regions'] as $region) {
		$sections[$region['id']] = Section::getRegionSections($region['id']);
		if($sections[$region['id']] != NULL) {
			foreach($sections[$region['id']] as $sec) {
				$secInfo[$region['id']][$sec['id']] = Info::SectionInfo($region['id'], $_GET['district'], $sec['title'], $results['year']['year']);
				if($secInfo[$region['id']][$sec['id']] != NULL) {
				
				if($secInfo[$region['id']][$sec['id']]['population_density'] <= $max_indicator[0]['density'] ) {
					$pop_district[$region['id']][$sec['id']] = $pop_color[0];
				} elseif($secInfo[$region['id']][$sec['id']]['population_density'] > $max_indicator[0]['density'] && $secInfo[$region['id']][$sec['id']]['population_density'] <= $max_indicator[1]['density']) {
					$pop_district[$region['id']][$sec['id']] = $pop_color[1];
				} elseif($secInfo[$region['id']][$sec['id']]['population_density'] > $max_indicator[1]['density'] && $secInfo[$region['id']][$sec['id']]['population_density'] <= $max_indicator[2]['density']) {
					$pop_district[$region['id']][$sec['id']] = $pop_color[2];
				} else {
					$pop_district[$region['id']][$sec['id']] = $pop_color[3];
				}
				
				if($secInfo[$region['id']][$sec['id']]['kin_ratio'] <= 25 ) {
					$kin_district[$region['id']][$sec['id']] = $kin_color[0];
				} elseif($secInfo[$region['id']][$sec['id']]['kin_ratio'] > 25 && $secInfo[$region['id']][$sec['id']]['kin_ratio'] <= 50) {
					$kin_district[$region['id']][$sec['id']] = $kin_color[1];
				} elseif($secInfo[$region['id']][$sec['id']]['kin_ratio'] > 50 && $secInfo[$region['id']][$sec['id']]['kin_ratio'] <= 75) {
					$kin_district[$region['id']][$sec['id']] = $kin_color[2];
				} else {
					$kin_district[$region['id']][$sec['id']] = $kin_color[3];
				}
				
				if($secInfo[$region['id']][$sec['id']]['school_ratio'] <= 25 ) {
					$school_district[$region['id']][$sec['id']] = $school_color[0];
				} elseif($secInfo[$region['id']][$sec['id']]['school_ratio'] > 25 && $secInfo[$region['id']][$sec['id']]['school_ratio'] <= 50) {
					$school_district[$region['id']][$sec['id']] = $school_color[1];
				} elseif($secInfo[$region['id']][$sec['id']]['school_ratio'] > 50 && $secInfo[$region['id']][$sec['id']]['school_ratio'] <= 75) {
					$school_district[$region['id']][$sec['id']] = $school_color[2];
				} else {
					$school_district[$region['id']][$sec['id']] = $school_color[3];
				}

				
				}
				
			}
		}
		
		$sections[$region['id']] = Section::getRegionSections($region['id']);
		$floods[$region['id']] = Risks::getRegionRisks($region['id']);
		$pls[$region['id']] = Playground::getRegionPlaygrounds($region['id']);
	}
	$roads = Road::getDistrictRoads($_GET['district']);
	$current_region = Region::getRegion($_GET['region']);
	require(SITE_TEMPLATE."markers/regionSingle.php");
}

function risksBorder() {
	$results = Risks::getRisksBorder($_GET['id']);
	preg_match_all("/\(([^\)]*)\)/", $results['coordinate'], $matches);
	$data['coordinate'] = array();
	$k = 0;
	foreach($matches[1] as $result) {
		$data['coordinate'][$k] = explode(',', $result, 2);
		$k = $k + 1;
	}
	header('Content-type: application/json');
	echo json_encode($data);
}

function roadBorder() {
	$results = Road::getRoadBorder($_GET['id']);
	preg_match_all("/\(([^\)]*)\)/", $results['coordinate'], $matches);
	$data['coordinate'] = array();
	$k = 0;
	foreach($matches[1] as $result) {
		$data['coordinate'][$k] = explode(',', $result, 2);
		$k = $k + 1;
	}
	header('Content-type: application/json');
	echo json_encode($data);
}

function playgroundBorder() {
	$results = Playground::getPlaygroundBorder($_GET['id']);
	preg_match_all("/\(([^\)]*)\)/", $results['coordinate'], $matches);
	$data['coordinate'] = array();
	$k = 0;
	foreach($matches[1] as $result) {
		$data['coordinate'][$k] = explode(',', $result, 2);
		$k = $k + 1;
	}
	header('Content-type: application/json');
	echo json_encode($data);
}

?>
