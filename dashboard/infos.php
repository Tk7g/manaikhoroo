<?php
require(realpath(dirname(__FILE__))."/../config/settings.php");
require_once(realpath(dirname(__FILE__))."/../classes/Info.class.php");
require_once(realpath(dirname(__FILE__))."/../classes/User.class.php");
require_once(realpath(dirname(__FILE__))."/../classes/Marker.class.php");
require_once(realpath(dirname(__FILE__))."/../classes/Section.class.php");
require_once(realpath(dirname(__FILE__))."/../classes/Earthground.class.php");
require_once(realpath(dirname(__FILE__))."/../classes/Crosswalk.class.php");
require_once(realpath(dirname(__FILE__))."/../classes/Risks.class.php");
require_once(realpath(dirname(__FILE__))."/../classes/Year.class.php");
require_once(realpath(dirname(__FILE__))."/../classes/Region.class.php");
require_once(realpath(dirname(__FILE__))."/../classes/District.class.php");

session_start();

$action = isset( $_GET['action'] ) ? $_GET['action'] : "";

switch ( $action ) {
	case 'add':
		add();
		break;
	case 'edit':
		edit();
		break;
	case 'delete':
		delete();
		break;
	case 'calculateAll':
		calculateAll();
		break;
	default:
		infoList();
}

function delete() {
	User::allowExecute(3);
	$current_info = Info::getInfo($_GET['id']);
	$response = Info::deleteInfo($_GET['id']);
	if($response == 0) {
		header( "Location: infos.php?status=deleteUnsuccess" );
	} else {
		
		$region_data = array('population' => 0, 'household' => 0, 'household_average' => 0, 'population_density' => 0, 'kin_num' => 0, 'tot_kinnum' => 0, 'kin_ratio' => 0, 'school_num' => 0, 'tot_schoolnum' => 0, 'school_ratio' => 0, 'year' => $current_info["year"], 'trash_collect' => 0, 'bus_density' => 0, 'well_num' => 0, 'well_density' => 0, 'well_ratio' => 0, 'trash_num' => 0, 'risk_ratio' => 0, 'hospital_num' => 0, 'hospital_ratio' => 0, 'toron_garts' => 0, 'area_length' => 0, 'pale_ground' => 0, 'risk_area' => 0);
			$sections = Section::getRegionPublishedDistinctSections($_SESSION['login']['region_id']);
			$k = 0;
			foreach($sections as $sect) {
				$section_info = Info::SectionInfo($_SESSION['login']['region_id'], $_SESSION['login']['district_id'], $sect['title'], $current_info['year']);
				if($section_info != NULL) {
					$k = $k + 1;
					$region_data['population'] = $region_data['population'] + $section_info['population'];
					$region_data['household'] = $region_data['household'] + $section_info['household'];
					$region_data['kin_num'] = $region_data['kin_num'] + $section_info['kin_num'];
					$region_data['tot_kinnum'] = $region_data['tot_kinnum'] + $section_info['tot_kinnum'];
					$region_data['school_num'] = $region_data['school_num'] + $section_info['school_num'];
					$region_data['tot_schoolnum'] = $region_data['tot_schoolnum'] + $section_info['tot_schoolnum'];
					$region_data['trash_collect'] = $region_data['trash_collect'] + $section_info['trash_collect'];
					$region_data['bus_density'] = $region_data['bus_density'] + $section_info['bus_density'];
					$region_data['well_density'] = $region_data['well_density'] + $section_info['well_density'];
					$region_data['area_length'] = $region_data['area_length'] + $section_info['area_length'];
				}
			}
			$region_data['household_average'] = $region_data['population']/$region_data['household'];
			$region_data['population_density'] = $region_data['population']/$region_data['area_length'];
			$region_data['kin_ratio'] = $region_data['kin_num']*100/$region_data['tot_kinnum'];
			$region_data['school_ratio'] = $region_data['school_num']*100/$region_data['tot_schoolnum'];
			$region_data['trash_collect'] = $region_data['trash_collect']/$k;
			$region_data['bus_density'] = $region_data['bus_density']/$k;
			$region_well_count = Marker::countRegionMarks($_SESSION['login']['district_id'], $_SESSION['login']['region_id'], 2, $current_info['year']);
			$region_data['well_num'] = $region_well_count['COUNT(*)'];
			$region_data['well_density'] = $region_data['well_density']/$k;
			$region_data['well_ratio'] = ($region_data['well_num']/$region_data['population'])*1000;
			$region_trash_count = Marker::countRegionMarks($_SESSION['login']['district_id'], $_SESSION['login']['region_id'], 31, $current_info['year']);
			$region_data['trash_num'] = $region_trash_count['COUNT(*)'];
			$region_data['risk_ratio'] = 0;
			$region_hospital_count = Marker::countRegionMarks($_SESSION['login']['district_id'], $_SESSION['login']['region_id'], 9, $current_info['year']);
			$region_data['hospital_num'] = $region_hospital_count['COUNT(*)'];
			$region_data['hospital_ratio'] = ($region_data['hospital_num']/$region_data['population'])*1000;
			$region_toron_garts_area_total = 0;
			$region_toron_garts_list = Crosswalk::getRegionCrosswalks($_SESSION['login']['region_id']);
			foreach($region_toron_garts_list as $region_toron_garts) {
				$region_toron_garts_area_total = $region_toron_garts_area_total + $region_toron_garts['area'];
			}
			$region_data['toron_garts'] = $region_toron_garts_area_total;
			$region_pale_ground_area_total = 0;
			$region_pale_ground_list = Earthground::getRegionEarthgrounds($_SESSION['login']['region_id']);
			foreach($region_pale_ground_list as $region_pale_ground) {
				$region_pale_ground_area_total = $region_pale_ground_area_total + $region_pale_ground['area'];
			}
			$region_data['pale_ground'] = $region_pale_ground_area_total;
			$region_risk_area_total = 0;
			$region_risk_area_list = Risks::getRegionRisks($_SESSION['login']['region_id']);
			foreach($region_risk_area_list as $region_risk_area) {
				$region_risk_area_total = $region_risk_area_total + $region_risk_area['area'];
			}
			$region_data['risk_area'] = $region_risk_area_total;
			$region_info_exist = Info::RegionInfo($_SESSION['login']['region_id'], $current_info["year"]);
			if($region_info_exist == NULL) {
				$region_response = Info::regionInfoAdd($_SESSION['login']['district_id'], $_SESSION['login']['region_id'], $current_info['year'], $region_data);
			} else {
				$region_response = Info::regionInfoEdit($_SESSION['login']['district_id'], $_SESSION['login']['region_id'], $current_info['year'], $region_data, $region_info_exist['id']);
			}
			
			$district_data = array('population' => 0, 'household' => 0, 'household_average' => 0, 'population_density' => 0, 'kin_num' => 0, 'tot_kinnum' => 0, 'kin_ratio' => 0, 'school_num' => 0, 'tot_schoolnum' => 0, 'school_ratio' => 0, 'year' => $current_info["year"], 'trash_collect' => 0, 'bus_density' => 0, 'well_num' => 0, 'well_density' => 0, 'well_ratio' => 0, 'trash_num' => 0, 'risk_ratio' => 0, 'hospital_num' => 0, 'hospital_ratio' => 0, 'toron_garts' => 0, 'area_length' => 0, 'pale_ground' => 0, 'risk_area' => 0);
			$regions = Region::RegionList($_SESSION['login']['district_id']);
			$m = 0;
			foreach($regions as $reg) {
				$reg_info = Info::RegionInfo($_SESSION['login']['region_id'], $current_info['year']);
				if($reg_info != NULL) {
					$m = $m + 1;
					$district_data['population'] = $district_data['population'] + $reg_info['population'];
					$district_data['household'] = $district_data['household'] + $reg_info['household'];
					$district_data['kin_num'] = $district_data['kin_num'] + $reg_info['kin_num'];
					$district_data['tot_kinnum'] = $district_data['tot_kinnum'] + $reg_info['tot_kinnum'];
					$district_data['school_num'] = $district_data['school_num'] + $reg_info['school_num'];
					$district_data['tot_schoolnum'] = $district_data['tot_schoolnum'] + $reg_info['tot_schoolnum'];
					$district_data['trash_collect'] = $district_data['trash_collect'] + $reg_info['trash_collect'];
					$district_data['bus_density'] = $district_data['bus_density'] + $reg_info['bus_density'];
					$district_data['well_density'] = $district_data['well_density'] + $reg_info['well_density'];
					$district_data['area_length'] = $district_data['area_length'] + $reg_info['area_length'];
				}
			}
			$district_data['household_average'] = $district_data['population']/$district_data['household'];
			$district_data['population_density'] = $district_data['population']/$district_data['area_length'];
			$district_data['kin_ratio'] = $district_data['kin_num']*100/$district_data['tot_kinnum'];;
			$district_data['school_ratio'] = $district_data['school_num']*100/$district_data['tot_schoolnum'];;
			$district_data['trash_collect'] = $district_data['trash_collect']/$m;
			$district_data['bus_density'] = $district_data['bus_density']/$m;
			$district_well_count = Marker::countDistrictYearMarkers($_SESSION['login']['district_id'], $current_info['year'], 2);
			$district_data['well_num'] = $district_well_count['COUNT(*)'];
			$district_data['well_density'] = $district_data['well_density']/$m;
			$district_data['well_ratio'] = ($district_data['well_num']/$district_data['population'])*1000;
			$district_trash_count = Marker::countDistrictYearMarkers($_SESSION['login']['district_id'], $current_info['year'], 31);
			$district_data['trash_num'] = $district_trash_count['COUNT(*)'];
			$district_data['risk_ratio'] = 0;
			$district_hospital_count = Marker::countDistrictYearMarkers($_SESSION['login']['district_id'], $current_info['year'], 9);
			$district_data['hospital_num'] = $district_hospital_count['COUNT(*)'];
			$district_data['hospital_ratio'] = ($district_data['hospital_num']/$district_data['population'])*1000;
			$district_toron_garts_area_total = 0;
			$district_toron_garts_list = Crosswalk::getDistrictCrosswalks($_SESSION['login']['district_id']);
			foreach($district_toron_garts_list as $district_toron_garts) {
				$district_toron_garts_area_total = $district_toron_garts_area_total + $district_toron_garts['area'];
			}
			$district_data['toron_garts'] = $district_toron_garts_area_total;
			$district_pale_ground_area_total = 0;
			$district_pale_ground_list = Earthground::getDistrictEarthgrounds($_SESSION['login']['district_id']);
			foreach($district_pale_ground_list as $district_pale_ground) {
				$district_pale_ground_area_total = $district_pale_ground_area_total + $district_pale_ground['area'];
			}
			$district_data['pale_ground'] = $district_pale_ground_area_total;
			$district_risk_area_total = 0;
			$district_risk_area_list = Risks::getDistrictRisks($_SESSION['login']['district_id']);
			foreach($district_risk_area_list as $district_risk_area) {
				$district_risk_area_total = $district_risk_area_total + $district_risk_area['area'];
			}
			$district_data['risk_area'] = $district_risk_area_total;
			$district_info_exist = Info::DistrictInfoGet($_SESSION['login']['district_id'], $current_info["year"]);
			if($district_info_exist == NULL) {
				$district_response = Info::districtInfoAdd($_SESSION['login']['district_id'], $current_info['year'], $district_data);
			} else {
				$district_response = Info::districtInfoEdit($_SESSION['login']['district_id'], $current_info['year'], $district_data, $district_info_exist['id']);
			}
			
			$capital_data = array('population' => 0, 'household' => 0, 'household_average' => 0, 'population_density' => 0, 'kin_num' => 0, 'tot_kinnum' => 0, 'kin_ratio' => 0, 'school_num' => 0, 'tot_schoolnum' => 0, 'school_ratio' => 0, 'year' => $current_info["year"], 'trash_collect' => 0, 'bus_density' => 0, 'well_num' => 0, 'well_density' => 0, 'well_ratio' => 0, 'trash_num' => 0, 'risk_ratio' => 0, 'hospital_num' => 0, 'hospital_ratio' => 0, 'toron_garts' => 0, 'area_length' => 0, 'pale_ground' => 0, 'risk_area' => 0);
			$dists = District::getDistrictList();
			$n = 0;
			foreach($dists as $dist) {
				$dist_info = Info::DistrictInfoGet($dist['id'], $current_info['year']);
				if($dist_info != NULL) {
					$n = $n + 1;
					$capital_data['population'] = $capital_data['population'] + $dist_info['population'];
					$capital_data['household'] = $capital_data['household'] + $dist_info['household'];
					$capital_data['kin_num'] = $capital_data['kin_num'] + $dist_info['kin_num'];
					$capital_data['tot_kinnum'] = $capital_data['tot_kinnum'] + $dist_info['tot_kinnum'];
					$capital_data['school_num'] = $capital_data['school_num'] + $dist_info['school_num'];
					$capital_data['tot_schoolnum'] = $capital_data['tot_schoolnum'] + $dist_info['tot_schoolnum'];
					$capital_data['trash_collect'] = $capital_data['trash_collect'] + $dist_info['trash_collect'];
					$capital_data['bus_density'] = $capital_data['bus_density'] + $dist_info['bus_density'];
					$capital_data['well_density'] = $capital_data['well_density'] + $dist_info['well_density'];
					$capital_data['area_length'] = $capital_data['area_length'] + $dist_info['area_length'];
				}
			}
			$capital_data['household_average'] = $capital_data['population']/$capital_data['household'];
			$capital_data['population_density'] = $capital_data['population']/$capital_data['area_length'];
			$capital_data['kin_ratio'] = $capital_data['kin_num']*100/$capital_data['tot_kinnum'];;
			$capital_data['school_ratio'] = $capital_data['school_num']*100/$capital_data['tot_schoolnum'];;
			$capital_data['trash_collect'] = $capital_data['trash_collect']/$m;
			$capital_data['bus_density'] = $capital_data['bus_density']/$m;
			$capital_well_count = Marker::countCityYearMarkers($current_info['year'], 2);
			$capital_data['well_num'] = $capital_well_count['COUNT(*)'];
			$capital_data['well_density'] = $capital_data['well_density']/$m;
			$capital_data['well_ratio'] = ($capital_data['well_num']/$capital_data['population'])*1000;
			$capital_trash_count = Marker::countCityYearMarkers($current_info['year'], 31);
			$capital_data['trash_num'] = $capital_trash_count['COUNT(*)'];
			$capital_data['risk_ratio'] = 0;
			$capital_hospital_count = Marker::countCityYearMarkers($current_info['year'], 9);
			$capital_data['hospital_num'] = $capital_hospital_count['COUNT(*)'];
			$capital_data['hospital_ratio'] = ($capital_data['hospital_num']/$capital_data['population'])*1000;
			$capital_toron_garts_area_total = 0;
			$capital_toron_garts_list = Crosswalk::getCityCrosswalks();
			foreach($capital_toron_garts_list as $capital_toron_garts) {
				$capital_toron_garts_area_total = $capital_toron_garts_area_total + $capital_toron_garts['area'];
			}
			$capital_data['toron_garts'] = $capital_toron_garts_area_total;
			$capital_pale_ground_area_total = 0;
			$capital_pale_ground_list = Earthground::getCityEarthgrounds();
			foreach($capital_pale_ground_list as $capital_pale_ground) {
				$capital_pale_ground_area_total = $capital_pale_ground_area_total + $capital_pale_ground['area'];
			}
			$capital_data['pale_ground'] = $capital_pale_ground_area_total;
			$capital_risk_area_total = 0;
			$capital_risk_area_list = Risks::getCityRisks();
			foreach($capital_risk_area_list as $capital_risk_area) {
				$capital_risk_area_total = $capital_risk_area_total + $capital_risk_area['area'];
			}
			$capital_data['risk_area'] = $capital_risk_area_total;
			$capital_info_exist = Info::CityInfo($current_info["year"]);
			if($capital_info_exist == NULL) {
				$district_response = Info::cityInfoAdd($current_info['year'], $capital_data);
			} else {
				$district_response = Info::cityInfoEdit($current_info['year'], $capital_data, $capital_info_exist['id']);
			}
		
		header( "Location: infos.php?status=deleteSuccess" );	
	}
}

function calculateAll() {
	User::allowExecute(3);
	$districts = District::getDistrictList();
	foreach($districts as $district) :
		
		$regions = Region::RegionList($district['id']);
		foreach($regions as $region) :
			$region_data = array('population' => 0, 'household' => 0, 'household_average' => 0, 'population_density' => 0, 'kin_num' => 0, 'tot_kinnum' => 0, 'kin_ratio' => 0, 'school_num' => 0, 'tot_schoolnum' => 0, 'school_ratio' => 0, 'year' => $_GET["year"], 'trash_collect' => 0, 'bus_density' => 0, 'well_num' => 0, 'well_density' => 0, 'well_ratio' => 0, 'trash_num' => 0, 'risk_ratio' => 0, 'hospital_num' => 0, 'hospital_ratio' => 0, 'toron_garts' => 0, 'area_length' => 0, 'pale_ground' => 0, 'risk_area' => 0);
			$sections = Section::getRegionPublishedDistinctSections($region['id']);
			$k = 0;
			foreach($sections as $section) :
				$section_info = Info::SectionInfo($region['id'], $district['id'], $section['title'], $_GET['year']);
				if($section_info != NULL) {
					$section_area = Section::getSectionArea($section['title'], $region['id'], $district['id']);
					$results = Info::sectionInfoEdit($district['id'], $region['id'], $section_info, $section_area['area']);
					$k = $k + 1;
					$region_data['population'] = $region_data['population'] + $section_info['population'];
					$region_data['household'] = $region_data['household'] + $section_info['household'];
					$region_data['kin_num'] = $region_data['kin_num'] + $section_info['kin_num'];
					$region_data['tot_kinnum'] = $region_data['tot_kinnum'] + $section_info['tot_kinnum'];
					$region_data['school_num'] = $region_data['school_num'] + $section_info['school_num'];
					$region_data['tot_schoolnum'] = $region_data['tot_schoolnum'] + $section_info['tot_schoolnum'];
					$region_data['trash_collect'] = $region_data['trash_collect'] + $section_info['trash_collect'];
					$region_data['bus_density'] = $region_data['bus_density'] + $section_info['bus_density'];
					$region_data['well_density'] = $region_data['well_density'] + $section_info['well_density'];
					$region_data['area_length'] = $region_data['area_length'] + $section_info['area_length'];
				}
				
			endforeach;
			$region_info_exist = Info::RegionInfo($region['id'], $_GET["year"]);
			if($region_info_exist != NULL) {
			
			if($region_data['population'] > 0) {
				if($region_data['household'] > 0) {
					$region_data['household_average'] = $region_data['population']/$region_data['household'];
				} else {
					$region_data['household_average'] = 0;
				}
			} else {
				$region_data['household_average'] = 0;
			}
			
			if($region_data['population'] > 0) {
				if($region_data['area_length'] > 0) {
					$region_data['population_density'] = $region_data['population']/$region_data['area_length'];
				} else {
					$region_data['population_density'] = 0;
				}
			} else {
				$region_data['population_density'] = 0;
			}
			
			if($region_data['kin_num'] > 0) {
				if($region_data['tot_kinnum'] > 0) {
					$region_data['kin_ratio'] = $region_data['kin_num']*100/$region_data['tot_kinnum'];
				} else {
					$region_data['kin_ratio'] = 0;
				}
			} else {
				$region_data['kin_ratio'] = 0;
			}
			
			if($region_data['school_num'] > 0) {
				if($region_data['tot_schoolnum'] > 0) {
					$region_data['school_ratio'] = $region_data['school_num']*100/$region_data['tot_schoolnum'];
				} else {
					$region_data['school_ratio'] = 0;
				}
			} else {
				$region_data['school_ratio'] = 0;
			}
			
			if($region_data['trash_collect'] > 0) {
				if($k > 0) {
					$region_data['trash_collect'] = $region_data['trash_collect']/$k;
				} else {
					$region_data['trash_collect'] = 0;
				}
			} else {
				$region_data['trash_collect'] = 0;
			}
			
			if($region_data['bus_density'] > 0) {
				if($k > 0) {
					$region_data['bus_density'] = $region_data['bus_density']/$k;
				} else {
					$region_data['bus_density'] = 0;
				}
			} else {
				$region_data['bus_density'] = 0;
			}
			
			$region_well_count = Marker::countRegionMarks($district['id'], $region['id'], 2, $_GET['year']);
			$region_data['well_num'] = $region_well_count['COUNT(*)'];
			if($region_data['well_density'] > 0) {
				if($k > 0) {
					$region_data['well_density'] = $region_data['well_density']/$k;
				} else {
					$region_data['well_density'] = 0;
				}
			} else {
				$region_data['well_density'] = 0;
			}
			
			if($region_data['well_num'] > 0) {
				if($region_data['population'] > 0) {
					$region_data['well_ratio'] = ($region_data['well_num']/$region_data['population'])*1000;
				} else {
					$region_data['well_ratio'] = 0;
				}
			} else {
				$region_data['well_ratio'] = 0;
			}
			
			$region_trash_count = Marker::countRegionMarks($district['id'], $region['id'], 31, $_GET['year']);
			$region_data['trash_num'] = $region_trash_count['COUNT(*)'];
			$region_data['risk_ratio'] = 0;
			$region_hospital_count = Marker::countRegionMarks($district['id'], $region['id'], 9, $_GET['year']);
			$region_data['hospital_num'] = $region_hospital_count['COUNT(*)'];
			if($region_data['hospital_num'] > 0) {
				if($region_data['population'] > 0) {
					$region_data['hospital_ratio'] = ($region_data['hospital_num']/$region_data['population'])*1000;
				} else {
					$region_data['hospital_ratio'] = 0;
				}
			} else {
				$region_data['hospital_ratio'] = 0;
			}
			
			$region_toron_garts_area_total = 0;
			$region_toron_garts_list = Crosswalk::getRegionCrosswalks($region['id']);
			foreach($region_toron_garts_list as $region_toron_garts) {
				$region_toron_garts_area_total = $region_toron_garts_area_total + $region_toron_garts['area'];
			}
			$region_data['toron_garts'] = $region_toron_garts_area_total;
			$region_pale_ground_area_total = 0;
			$region_pale_ground_list = Earthground::getRegionEarthgrounds($region['id']);
			foreach($region_pale_ground_list as $region_pale_ground) {
				$region_pale_ground_area_total = $region_pale_ground_area_total + $region_pale_ground['area'];
			}
			$region_data['pale_ground'] = $region_pale_ground_area_total;
			$region_risk_area_total = 0;
			$region_risk_area_list = Risks::getRegionRisks($region['id']);
			foreach($region_risk_area_list as $region_risk_area) {
				$region_risk_area_total = $region_risk_area_total + $region_risk_area['area'];
			}
			$region_data['risk_area'] = $region_risk_area_total;
			$region_response = Info::regionInfoEdit($district['id'], $region['id'], $_GET['year'], $region_data, $region_info_exist['id']);	
			
			}
		endforeach;
		
			$district_data = array('population' => 0, 'household' => 0, 'household_average' => 0, 'population_density' => 0, 'kin_num' => 0, 'tot_kinnum' => 0, 'kin_ratio' => 0, 'school_num' => 0, 'tot_schoolnum' => 0, 'school_ratio' => 0, 'year' => $_GET["year"], 'trash_collect' => 0, 'bus_density' => 0, 'well_num' => 0, 'well_density' => 0, 'well_ratio' => 0, 'trash_num' => 0, 'risk_ratio' => 0, 'hospital_num' => 0, 'hospital_ratio' => 0, 'toron_garts' => 0, 'area_length' => 0, 'pale_ground' => 0, 'risk_area' => 0);
			$regions = Region::RegionList($district['id']);
			$m = 0;
			foreach($regions as $reg) {
				$reg_info = Info::RegionInfo($reg['id'], $_GET['year']);
				if($reg_info != NULL) {
					$m = $m + 1;
					$district_data['population'] = $district_data['population'] + $reg_info['population'];
					$district_data['household'] = $district_data['household'] + $reg_info['household'];
					$district_data['kin_num'] = $district_data['kin_num'] + $reg_info['kin_num'];
					$district_data['tot_kinnum'] = $district_data['tot_kinnum'] + $reg_info['tot_kinnum'];
					$district_data['school_num'] = $district_data['school_num'] + $reg_info['school_num'];
					$district_data['tot_schoolnum'] = $district_data['tot_schoolnum'] + $reg_info['tot_schoolnum'];
					$district_data['trash_collect'] = $district_data['trash_collect'] + $reg_info['trash_collect'];
					$district_data['bus_density'] = $district_data['bus_density'] + $reg_info['bus_density'];
					$district_data['well_density'] = $district_data['well_density'] + $reg_info['well_density'];
					$district_data['area_length'] = $district_data['area_length'] + $reg_info['area_length'];
				}
			}
			$district_data['household_average'] = $district_data['population']/$district_data['household'];
			$district_data['population_density'] = $district_data['population']/$district_data['area_length'];
			$district_data['kin_ratio'] = $district_data['kin_num']*100/$district_data['tot_kinnum'];;
			$district_data['school_ratio'] = $district_data['school_num']*100/$district_data['tot_schoolnum'];;
			$district_data['trash_collect'] = $district_data['trash_collect']/$m;
			$district_data['bus_density'] = $district_data['bus_density']/$m;
			$district_well_count = Marker::countDistrictYearMarkers($district['id'], $_GET['year'], 2);
			$district_data['well_num'] = $district_well_count['COUNT(*)'];
			$district_data['well_density'] = $district_data['well_density']/$m;
			$district_data['well_ratio'] = ($district_data['well_num']/$district_data['population'])*1000;
			$district_trash_count = Marker::countDistrictYearMarkers($district['id'], $_GET['year'], 31);
			$district_data['trash_num'] = $district_trash_count['COUNT(*)'];
			$district_data['risk_ratio'] = 0;
			$district_hospital_count = Marker::countDistrictYearMarkers($district['id'], $_GET['year'], 9);
			$district_data['hospital_num'] = $district_hospital_count['COUNT(*)'];
			$district_data['hospital_ratio'] = ($district_data['hospital_num']/$district_data['population'])*1000;
			$district_toron_garts_area_total = 0;
			$district_toron_garts_list = Crosswalk::getDistrictCrosswalks($district['id']);
			foreach($district_toron_garts_list as $district_toron_garts) {
				$district_toron_garts_area_total = $district_toron_garts_area_total + $district_toron_garts['area'];
			}
			$district_data['toron_garts'] = $district_toron_garts_area_total;
			$district_pale_ground_area_total = 0;
			$district_pale_ground_list = Earthground::getDistrictEarthgrounds($district['id']);
			foreach($district_pale_ground_list as $district_pale_ground) {
				$district_pale_ground_area_total = $district_pale_ground_area_total + $district_pale_ground['area'];
			}
			$district_data['pale_ground'] = $district_pale_ground_area_total;
			$district_risk_area_total = 0;
			$district_risk_area_list = Risks::getDistrictRisks($district['id']);
			foreach($district_risk_area_list as $district_risk_area) {
				$district_risk_area_total = $district_risk_area_total + $district_risk_area['area'];
			}
			$district_data['risk_area'] = $district_risk_area_total;
			$district_info_exist = Info::DistrictInfoGet($district['id'], $_GET["year"]);
			$district_response = Info::districtInfoEdit($district['id'], $_GET['year'], $district_data, $district_info_exist['id']);
			
	endforeach;
	
		$capital_data = array('population' => 0, 'household' => 0, 'household_average' => 0, 'population_density' => 0, 'kin_num' => 0, 'tot_kinnum' => 0, 'kin_ratio' => 0, 'school_num' => 0, 'tot_schoolnum' => 0, 'school_ratio' => 0, 'year' => $_GET["year"], 'trash_collect' => 0, 'bus_density' => 0, 'well_num' => 0, 'well_density' => 0, 'well_ratio' => 0, 'trash_num' => 0, 'risk_ratio' => 0, 'hospital_num' => 0, 'hospital_ratio' => 0, 'toron_garts' => 0, 'area_length' => 0, 'pale_ground' => 0, 'risk_area' => 0);
		$dists = District::getDistrictList();
		$n = 0;
		foreach($dists as $dist) {
			$dist_info = Info::DistrictInfoGet($dist['id'], $_GET['year']);
			if($dist_info != NULL) {
				$n = $n + 1;
				$capital_data['population'] = $capital_data['population'] + $dist_info['population'];
				$capital_data['household'] = $capital_data['household'] + $dist_info['household'];
				$capital_data['kin_num'] = $capital_data['kin_num'] + $dist_info['kin_num'];
				$capital_data['tot_kinnum'] = $capital_data['tot_kinnum'] + $dist_info['tot_kinnum'];
				$capital_data['school_num'] = $capital_data['school_num'] + $dist_info['school_num'];
				$capital_data['tot_schoolnum'] = $capital_data['tot_schoolnum'] + $dist_info['tot_schoolnum'];
				$capital_data['trash_collect'] = $capital_data['trash_collect'] + $dist_info['trash_collect'];
				$capital_data['bus_density'] = $capital_data['bus_density'] + $dist_info['bus_density'];
				$capital_data['well_density'] = $capital_data['well_density'] + $dist_info['well_density'];
				$capital_data['area_length'] = $capital_data['area_length'] + $dist_info['area_length'];
			}
		}
		$capital_data['household_average'] = $capital_data['population']/$capital_data['household'];
		$capital_data['population_density'] = $capital_data['population']/$capital_data['area_length'];
		$capital_data['kin_ratio'] = $capital_data['kin_num']*100/$capital_data['tot_kinnum'];;
		$capital_data['school_ratio'] = $capital_data['school_num']*100/$capital_data['tot_schoolnum'];;
		$capital_data['trash_collect'] = $capital_data['trash_collect']/$m;
		$capital_data['bus_density'] = $capital_data['bus_density']/$m;
		$capital_well_count = Marker::countCityYearMarkers($_GET['year'], 2);
		$capital_data['well_num'] = $capital_well_count['COUNT(*)'];
		$capital_data['well_density'] = $capital_data['well_density']/$m;
		$capital_data['well_ratio'] = ($capital_data['well_num']/$capital_data['population'])*1000;
		$capital_trash_count = Marker::countCityYearMarkers($_GET['year'], 31);
		$capital_data['trash_num'] = $capital_trash_count['COUNT(*)'];
		$capital_data['risk_ratio'] = 0;
		$capital_hospital_count = Marker::countCityYearMarkers($_GET['year'], 9);
		$capital_data['hospital_num'] = $capital_hospital_count['COUNT(*)'];
		$capital_data['hospital_ratio'] = ($capital_data['hospital_num']/$capital_data['population'])*1000;
		$capital_toron_garts_area_total = 0;
		$capital_toron_garts_list = Crosswalk::getCityCrosswalks();
		foreach($capital_toron_garts_list as $capital_toron_garts) {
			$capital_toron_garts_area_total = $capital_toron_garts_area_total + $capital_toron_garts['area'];
		}
		$capital_data['toron_garts'] = $capital_toron_garts_area_total;
		$capital_pale_ground_area_total = 0;
		$capital_pale_ground_list = Earthground::getCityEarthgrounds();
		foreach($capital_pale_ground_list as $capital_pale_ground) {
			$capital_pale_ground_area_total = $capital_pale_ground_area_total + $capital_pale_ground['area'];
		}
		$capital_data['pale_ground'] = $capital_pale_ground_area_total;
		$capital_risk_area_total = 0;
		$capital_risk_area_list = Risks::getCityRisks();
		foreach($capital_risk_area_list as $capital_risk_area) {
			$capital_risk_area_total = $capital_risk_area_total + $capital_risk_area['area'];
		}
		$capital_data['risk_area'] = $capital_risk_area_total;
		$capital_info_exist = Info::CityInfo($_GET["year"]);
		$district_response = Info::cityInfoEdit($_GET['year'], $capital_data, $capital_info_exist['id']);
	
}

function edit() {
	User::allowExecute(3);
	$info = Info::getInfo($_GET['id']);
	$years = Year::getYearList();
	if (isset($_POST['saveInfo'])) {
		$info = new Info;
		$region_information = Region::getRegion($_SESSION['login']['region_id']);
		$region_area_length = $region_information['area_length'];
		$section_area = Section::getSectionArea($_POST['section_id'], $_SESSION['login']['region_id'], $_SESSION['login']['district_id']);
		$results = $info->sectionInfoEdit($_SESSION['login']['district_id'], $_SESSION['login']['region_id'], $_POST, $section_area['area']);
		if($results == 0) {
			header( "Location: infos.php?status=saveUnsuccess" );
		} else {
			$region_data = array('population' => 0, 'household' => 0, 'household_average' => 0, 'population_density' => 0, 'kin_num' => 0, 'tot_kinnum' => 0, 'kin_ratio' => 0, 'school_num' => 0, 'tot_schoolnum' => 0, 'school_ratio' => 0, 'year' => $_POST["year"], 'trash_collect' => 0, 'bus_density' => 0, 'well_num' => 0, 'well_density' => 0, 'well_ratio' => 0, 'trash_num' => 0, 'risk_ratio' => 0, 'hospital_num' => 0, 'hospital_ratio' => 0, 'toron_garts' => 0, 'area_length' => $region_area_length, 'pale_ground' => 0, 'risk_area' => 0);
			$sections = Section::getRegionPublishedDistinctSections($_SESSION['login']['region_id']);
			$k = 0;
			foreach($sections as $sect) {
				$section_info = Info::SectionInfo($_SESSION['login']['region_id'], $_SESSION['login']['district_id'], $sect['title'], $_POST['year']);
				if($section_info != NULL) {
					$k = $k + 1;
					$region_data['population'] = $region_data['population'] + $section_info['population'];
					$region_data['household'] = $region_data['household'] + $section_info['household'];
					$region_data['kin_num'] = $region_data['kin_num'] + $section_info['kin_num'];
					$region_data['tot_kinnum'] = $region_data['tot_kinnum'] + $section_info['tot_kinnum'];
					$region_data['school_num'] = $region_data['school_num'] + $section_info['school_num'];
					$region_data['tot_schoolnum'] = $region_data['tot_schoolnum'] + $section_info['tot_schoolnum'];
					$region_data['trash_collect'] = $region_data['trash_collect'] + $section_info['trash_collect'];
					$region_data['bus_density'] = $region_data['bus_density'] + $section_info['bus_density'];
					$region_data['well_density'] = $region_data['well_density'] + $section_info['well_density'];
					//$region_data['area_length'] = $region_data['area_length'] + $section_info['area_length'];
				}
			}
			$region_data['household_average'] = $region_data['population']/$region_data['household'];
			$region_data['population_density'] = $region_data['population']/$region_data['area_length'];
			$region_data['kin_ratio'] = $region_data['kin_num']*100/$region_data['tot_kinnum'];
			$region_data['school_ratio'] = $region_data['school_num']*100/$region_data['tot_schoolnum'];
			$region_data['trash_collect'] = $region_data['trash_collect']/$k;
			$region_data['bus_density'] = $region_data['bus_density']/$k;
			$region_well_count = Marker::countRegionMarks($_SESSION['login']['district_id'], $_SESSION['login']['region_id'], 2, $_POST['year']);
			$region_data['well_num'] = $region_well_count['COUNT(*)'];
			$region_data['well_density'] = $region_data['well_density']/$k;
			$region_data['well_ratio'] = ($region_data['well_num']/$region_data['population'])*1000;
			$region_trash_count = Marker::countRegionMarks($_SESSION['login']['district_id'], $_SESSION['login']['region_id'], 31, $_POST['year']);
			$region_data['trash_num'] = $region_trash_count['COUNT(*)'];
			$region_data['risk_ratio'] = 0;
			$region_hospital_count = Marker::countRegionMarks($_SESSION['login']['district_id'], $_SESSION['login']['region_id'], 9, $_POST['year']);
			$region_data['hospital_num'] = $region_hospital_count['COUNT(*)'];
			$region_data['hospital_ratio'] = ($region_data['hospital_num']/$region_data['population'])*1000;
			$region_toron_garts_area_total = 0;
			$region_toron_garts_list = Crosswalk::getRegionCrosswalks($_SESSION['login']['region_id']);
			foreach($region_toron_garts_list as $region_toron_garts) {
				$region_toron_garts_area_total = $region_toron_garts_area_total + $region_toron_garts['area'];
			}
			$region_data['toron_garts'] = $region_toron_garts_area_total;
			$region_pale_ground_area_total = 0;
			$region_pale_ground_list = Earthground::getRegionEarthgrounds($_SESSION['login']['region_id']);
			foreach($region_pale_ground_list as $region_pale_ground) {
				$region_pale_ground_area_total = $region_pale_ground_area_total + $region_pale_ground['area'];
			}
			$region_data['pale_ground'] = $region_pale_ground_area_total;
			$region_risk_area_total = 0;
			$region_risk_area_list = Risks::getRegionRisks($_SESSION['login']['region_id']);
			foreach($region_risk_area_list as $region_risk_area) {
				$region_risk_area_total = $region_risk_area_total + $region_risk_area['area'];
			}
			$region_data['risk_area'] = $region_risk_area_total;
			$region_info_exist = Info::RegionInfo($_SESSION['login']['region_id'], $_POST["year"]);
			if($region_info_exist == NULL) {
				$region_response = Info::regionInfoAdd($_SESSION['login']['district_id'], $_SESSION['login']['region_id'], $_POST['year'], $region_data);
			} else {
				$region_response = Info::regionInfoEdit($_SESSION['login']['district_id'], $_SESSION['login']['region_id'], $_POST['year'], $region_data, $region_info_exist['id']);
			}
			
			$district_data = array('population' => 0, 'household' => 0, 'household_average' => 0, 'population_density' => 0, 'kin_num' => 0, 'tot_kinnum' => 0, 'kin_ratio' => 0, 'school_num' => 0, 'tot_schoolnum' => 0, 'school_ratio' => 0, 'year' => $_POST["year"], 'trash_collect' => 0, 'bus_density' => 0, 'well_num' => 0, 'well_density' => 0, 'well_ratio' => 0, 'trash_num' => 0, 'risk_ratio' => 0, 'hospital_num' => 0, 'hospital_ratio' => 0, 'toron_garts' => 0, 'area_length' => 0, 'pale_ground' => 0, 'risk_area' => 0);
			$regions = Region::RegionList($_SESSION['login']['district_id']);
			$m = 0;
			foreach($regions as $reg) {
				$reg_info = Info::RegionInfo($_SESSION['login']['region_id'], $_POST['year']);
				if($reg_info != NULL) {
					$m = $m + 1;
					$district_data['population'] = $district_data['population'] + $reg_info['population'];
					$district_data['household'] = $district_data['household'] + $reg_info['household'];
					$district_data['kin_num'] = $district_data['kin_num'] + $reg_info['kin_num'];
					$district_data['tot_kinnum'] = $district_data['tot_kinnum'] + $reg_info['tot_kinnum'];
					$district_data['school_num'] = $district_data['school_num'] + $reg_info['school_num'];
					$district_data['tot_schoolnum'] = $district_data['tot_schoolnum'] + $reg_info['tot_schoolnum'];
					$district_data['trash_collect'] = $district_data['trash_collect'] + $reg_info['trash_collect'];
					$district_data['bus_density'] = $district_data['bus_density'] + $reg_info['bus_density'];
					$district_data['well_density'] = $district_data['well_density'] + $reg_info['well_density'];
					$district_data['area_length'] = $district_data['area_length'] + $reg_info['area_length'];
				}
			}
			$district_data['household_average'] = $district_data['population']/$district_data['household'];
			$district_data['population_density'] = $district_data['population']/$district_data['area_length'];
			$district_data['kin_ratio'] = $district_data['kin_num']*100/$district_data['tot_kinnum'];;
			$district_data['school_ratio'] = $district_data['school_num']*100/$district_data['tot_schoolnum'];;
			$district_data['trash_collect'] = $district_data['trash_collect']/$m;
			$district_data['bus_density'] = $district_data['bus_density']/$m;
			$district_well_count = Marker::countDistrictYearMarkers($_SESSION['login']['district_id'], $_POST['year'], 2);
			$district_data['well_num'] = $district_well_count['COUNT(*)'];
			$district_data['well_density'] = $district_data['well_density']/$m;
			$district_data['well_ratio'] = ($district_data['well_num']/$district_data['population'])*1000;
			$district_trash_count = Marker::countDistrictYearMarkers($_SESSION['login']['district_id'], $_POST['year'], 31);
			$district_data['trash_num'] = $district_trash_count['COUNT(*)'];
			$district_data['risk_ratio'] = 0;
			$district_hospital_count = Marker::countDistrictYearMarkers($_SESSION['login']['district_id'], $_POST['year'], 9);
			$district_data['hospital_num'] = $district_hospital_count['COUNT(*)'];
			$district_data['hospital_ratio'] = ($district_data['hospital_num']/$district_data['population'])*1000;
			$district_toron_garts_area_total = 0;
			$district_toron_garts_list = Crosswalk::getDistrictCrosswalks($_SESSION['login']['district_id']);
			foreach($district_toron_garts_list as $district_toron_garts) {
				$district_toron_garts_area_total = $district_toron_garts_area_total + $district_toron_garts['area'];
			}
			$district_data['toron_garts'] = $district_toron_garts_area_total;
			$district_pale_ground_area_total = 0;
			$district_pale_ground_list = Earthground::getDistrictEarthgrounds($_SESSION['login']['district_id']);
			foreach($district_pale_ground_list as $district_pale_ground) {
				$district_pale_ground_area_total = $district_pale_ground_area_total + $district_pale_ground['area'];
			}
			$district_data['pale_ground'] = $district_pale_ground_area_total;
			$district_risk_area_total = 0;
			$district_risk_area_list = Risks::getDistrictRisks($_SESSION['login']['district_id']);
			foreach($district_risk_area_list as $district_risk_area) {
				$district_risk_area_total = $district_risk_area_total + $district_risk_area['area'];
			}
			$district_data['risk_area'] = $district_risk_area_total;
			$district_info_exist = Info::DistrictInfoGet($_SESSION['login']['district_id'], $_POST["year"]);
			if($district_info_exist == NULL) {
				$district_response = Info::districtInfoAdd($_SESSION['login']['district_id'], $_POST['year'], $district_data);
			} else {
				$district_response = Info::districtInfoEdit($_SESSION['login']['district_id'], $_POST['year'], $district_data, $district_info_exist['id']);
			}
			
			$capital_data = array('population' => 0, 'household' => 0, 'household_average' => 0, 'population_density' => 0, 'kin_num' => 0, 'tot_kinnum' => 0, 'kin_ratio' => 0, 'school_num' => 0, 'tot_schoolnum' => 0, 'school_ratio' => 0, 'year' => $_POST["year"], 'trash_collect' => 0, 'bus_density' => 0, 'well_num' => 0, 'well_density' => 0, 'well_ratio' => 0, 'trash_num' => 0, 'risk_ratio' => 0, 'hospital_num' => 0, 'hospital_ratio' => 0, 'toron_garts' => 0, 'area_length' => 0, 'pale_ground' => 0, 'risk_area' => 0);
			$dists = District::getDistrictList();
			$n = 0;
			foreach($dists as $dist) {
				$dist_info = Info::DistrictInfoGet($dist['id'], $_POST['year']);
				if($dist_info != NULL) {
					$n = $n + 1;
					$capital_data['population'] = $capital_data['population'] + $dist_info['population'];
					$capital_data['household'] = $capital_data['household'] + $dist_info['household'];
					$capital_data['kin_num'] = $capital_data['kin_num'] + $dist_info['kin_num'];
					$capital_data['tot_kinnum'] = $capital_data['tot_kinnum'] + $dist_info['tot_kinnum'];
					$capital_data['school_num'] = $capital_data['school_num'] + $dist_info['school_num'];
					$capital_data['tot_schoolnum'] = $capital_data['tot_schoolnum'] + $dist_info['tot_schoolnum'];
					$capital_data['trash_collect'] = $capital_data['trash_collect'] + $dist_info['trash_collect'];
					$capital_data['bus_density'] = $capital_data['bus_density'] + $dist_info['bus_density'];
					$capital_data['well_density'] = $capital_data['well_density'] + $dist_info['well_density'];
					$capital_data['area_length'] = $capital_data['area_length'] + $dist_info['area_length'];
				}
			}
			$capital_data['household_average'] = $capital_data['population']/$capital_data['household'];
			$capital_data['population_density'] = $capital_data['population']/$capital_data['area_length'];
			$capital_data['kin_ratio'] = $capital_data['kin_num']*100/$capital_data['tot_kinnum'];;
			$capital_data['school_ratio'] = $capital_data['school_num']*100/$capital_data['tot_schoolnum'];;
			$capital_data['trash_collect'] = $capital_data['trash_collect']/$m;
			$capital_data['bus_density'] = $capital_data['bus_density']/$m;
			$capital_well_count = Marker::countCityYearMarkers($_POST['year'], 2);
			$capital_data['well_num'] = $capital_well_count['COUNT(*)'];
			$capital_data['well_density'] = $capital_data['well_density']/$m;
			$capital_data['well_ratio'] = ($capital_data['well_num']/$capital_data['population'])*1000;
			$capital_trash_count = Marker::countCityYearMarkers($_POST['year'], 31);
			$capital_data['trash_num'] = $capital_trash_count['COUNT(*)'];
			$capital_data['risk_ratio'] = 0;
			$capital_hospital_count = Marker::countCityYearMarkers($_POST['year'], 9);
			$capital_data['hospital_num'] = $capital_hospital_count['COUNT(*)'];
			$capital_data['hospital_ratio'] = ($capital_data['hospital_num']/$capital_data['population'])*1000;
			$capital_toron_garts_area_total = 0;
			$capital_toron_garts_list = Crosswalk::getCityCrosswalks();
			foreach($capital_toron_garts_list as $capital_toron_garts) {
				$capital_toron_garts_area_total = $capital_toron_garts_area_total + $capital_toron_garts['area'];
			}
			$capital_data['toron_garts'] = $capital_toron_garts_area_total;
			$capital_pale_ground_area_total = 0;
			$capital_pale_ground_list = Earthground::getCityEarthgrounds();
			foreach($capital_pale_ground_list as $capital_pale_ground) {
				$capital_pale_ground_area_total = $capital_pale_ground_area_total + $capital_pale_ground['area'];
			}
			$capital_data['pale_ground'] = $capital_pale_ground_area_total;
			$capital_risk_area_total = 0;
			$capital_risk_area_list = Risks::getCityRisks();
			foreach($capital_risk_area_list as $capital_risk_area) {
				$capital_risk_area_total = $capital_risk_area_total + $capital_risk_area['area'];
			}
			$capital_data['risk_area'] = $capital_risk_area_total;
			$capital_info_exist = Info::CityInfo($_POST["year"]);
			if($capital_info_exist == NULL) {
				$district_response = Info::cityInfoAdd($_POST['year'], $capital_data);
			} else {
				$district_response = Info::cityInfoEdit($_POST['year'], $capital_data, $capital_info_exist['id']);
			}
			
			header( "Location: infos.php?status=infoSaved" );
		}
	}
	$districtHeader = District::getDistrict($_SESSION['login']['district_id']);
	$regionHeader = Region::getRegion($_SESSION['login']['region_id']);
	$sections = Section::getRegionPublishedSections($_SESSION['login']['region_id']);
	require(ADMIN_TEMPLATE . "infos/infoEdit.php");
}

function add() {
	User::allowExecute(3);
	if (isset($_POST['saveInfo'])) {
		$info = new Info;
		$region_information = Region::getRegion($_SESSION['login']['region_id']);
		$region_area_length = $region_information['area_length'];
		$section_area = Section::getSectionArea($_POST['section_id'], $_SESSION['login']['region_id'], $_SESSION['login']['district_id']);
		$results = $info->sectionInfoAdd($_SESSION['login']['district_id'], $_SESSION['login']['region_id'], $_POST, $section_area['area']);
		if($results == 0) {
			header( "Location: infos.php?status=saveUnsuccess" );
		} else {
			$region_data = array('population' => 0, 'household' => 0, 'household_average' => 0, 'population_density' => 0, 'kin_num' => 0, 'tot_kinnum' => 0, 'kin_ratio' => 0, 'school_num' => 0, 'tot_schoolnum' => 0, 'school_ratio' => 0, 'year' => $_POST["year"], 'trash_collect' => 0, 'bus_density' => 0, 'well_num' => 0, 'well_density' => 0, 'well_ratio' => 0, 'trash_num' => 0, 'risk_ratio' => 0, 'hospital_num' => 0, 'hospital_ratio' => 0, 'toron_garts' => 0, 'area_length' => $region_area_length, 'pale_ground' => 0, 'risk_area' => 0);
			$sections = Section::getRegionPublishedDistinctSections($_SESSION['login']['region_id']);
			$k = 0;
			foreach($sections as $sect) {
				$section_info = Info::SectionInfo($_SESSION['login']['region_id'], $_SESSION['login']['district_id'], $sect['title'], $_POST['year']);
				if($section_info != NULL) {
					$k = $k + 1;
					$region_data['population'] = $region_data['population'] + $section_info['population'];
					$region_data['household'] = $region_data['household'] + $section_info['household'];
					$region_data['kin_num'] = $region_data['kin_num'] + $section_info['kin_num'];
					$region_data['tot_kinnum'] = $region_data['tot_kinnum'] + $section_info['tot_kinnum'];
					$region_data['school_num'] = $region_data['school_num'] + $section_info['school_num'];
					$region_data['tot_schoolnum'] = $region_data['tot_schoolnum'] + $section_info['tot_schoolnum'];
					$region_data['trash_collect'] = $region_data['trash_collect'] + $section_info['trash_collect'];
					$region_data['bus_density'] = $region_data['bus_density'] + $section_info['bus_density'];
					$region_data['well_density'] = $region_data['well_density'] + $section_info['well_density'];
					//$region_data['area_length'] = $region_data['area_length'] + $section_info['area_length'];
				}
			}
			$region_data['household_average'] = $region_data['population']/$region_data['household'];
			$region_data['population_density'] = $region_data['population']/$region_data['area_length'];
			$region_data['kin_ratio'] = $region_data['kin_num']*100/$region_data['tot_kinnum'];
			$region_data['school_ratio'] = $region_data['school_num']*100/$region_data['tot_schoolnum'];
			$region_data['trash_collect'] = $region_data['trash_collect']/$k;
			$region_data['bus_density'] = $region_data['bus_density']/$k;
			$region_well_count = Marker::countRegionMarks($_SESSION['login']['district_id'], $_SESSION['login']['region_id'], 2, $_POST['year']);
			$region_data['well_num'] = $region_well_count['COUNT(*)'];
			$region_data['well_density'] = $region_data['well_density']/$k;
			$region_data['well_ratio'] = ($region_data['well_num']/$region_data['population'])*1000;
			$region_trash_count = Marker::countRegionMarks($_SESSION['login']['district_id'], $_SESSION['login']['region_id'], 31, $_POST['year']);
			$region_data['trash_num'] = $region_trash_count['COUNT(*)'];
			$region_data['risk_ratio'] = 0;
			$region_hospital_count = Marker::countRegionMarks($_SESSION['login']['district_id'], $_SESSION['login']['region_id'], 9, $_POST['year']);
			$region_data['hospital_num'] = $region_hospital_count['COUNT(*)'];
			$region_data['hospital_ratio'] = ($region_data['hospital_num']/$region_data['population'])*1000;
			$region_toron_garts_area_total = 0;
			$region_toron_garts_list = Crosswalk::getRegionCrosswalks($_SESSION['login']['region_id']);
			foreach($region_toron_garts_list as $region_toron_garts) {
				$region_toron_garts_area_total = $region_toron_garts_area_total + $region_toron_garts['area'];
			}
			$region_data['toron_garts'] = $region_toron_garts_area_total;
			$region_pale_ground_area_total = 0;
			$region_pale_ground_list = Earthground::getRegionEarthgrounds($_SESSION['login']['region_id']);
			foreach($region_pale_ground_list as $region_pale_ground) {
				$region_pale_ground_area_total = $region_pale_ground_area_total + $region_pale_ground['area'];
			}
			$region_data['pale_ground'] = $region_pale_ground_area_total;
			$region_risk_area_total = 0;
			$region_risk_area_list = Risks::getRegionRisks($_SESSION['login']['region_id']);
			foreach($region_risk_area_list as $region_risk_area) {
				$region_risk_area_total = $region_risk_area_total + $region_risk_area['area'];
			}
			$region_data['risk_area'] = $region_risk_area_total;
			$region_info_exist = Info::RegionInfo($_SESSION['login']['region_id'], $_POST["year"]);
			if($region_info_exist == NULL) {
				$region_response = Info::regionInfoAdd($_SESSION['login']['district_id'], $_SESSION['login']['region_id'], $_POST['year'], $region_data);
			} else {
				$region_response = Info::regionInfoEdit($_SESSION['login']['district_id'], $_SESSION['login']['region_id'], $_POST['year'], $region_data, $region_info_exist['id']);
			}
			
			$district_data = array('population' => 0, 'household' => 0, 'household_average' => 0, 'population_density' => 0, 'kin_num' => 0, 'tot_kinnum' => 0, 'kin_ratio' => 0, 'school_num' => 0, 'tot_schoolnum' => 0, 'school_ratio' => 0, 'year' => $_POST["year"], 'trash_collect' => 0, 'bus_density' => 0, 'well_num' => 0, 'well_density' => 0, 'well_ratio' => 0, 'trash_num' => 0, 'risk_ratio' => 0, 'hospital_num' => 0, 'hospital_ratio' => 0, 'toron_garts' => 0, 'area_length' => 0, 'pale_ground' => 0, 'risk_area' => 0);
			$regions = Region::RegionList($_SESSION['login']['district_id']);
			$m = 0;
			foreach($regions as $reg) {
				$reg_info = Info::RegionInfo($_SESSION['login']['region_id'], $_POST['year']);
				if($reg_info != NULL) {
					$m = $m + 1;
					$district_data['population'] = $district_data['population'] + $reg_info['population'];
					$district_data['household'] = $district_data['household'] + $reg_info['household'];
					$district_data['kin_num'] = $district_data['kin_num'] + $reg_info['kin_num'];
					$district_data['tot_kinnum'] = $district_data['tot_kinnum'] + $reg_info['tot_kinnum'];
					$district_data['school_num'] = $district_data['school_num'] + $reg_info['school_num'];
					$district_data['tot_schoolnum'] = $district_data['tot_schoolnum'] + $reg_info['tot_schoolnum'];
					$district_data['trash_collect'] = $district_data['trash_collect'] + $reg_info['trash_collect'];
					$district_data['bus_density'] = $district_data['bus_density'] + $reg_info['bus_density'];
					$district_data['well_density'] = $district_data['well_density'] + $reg_info['well_density'];
					$district_data['area_length'] = $district_data['area_length'] + $reg_info['area_length'];
				}
			}
			$district_data['household_average'] = $district_data['population']/$district_data['household'];
			$district_data['population_density'] = $district_data['population']/$district_data['area_length'];
			$district_data['kin_ratio'] = $district_data['kin_num']*100/$district_data['tot_kinnum'];;
			$district_data['school_ratio'] = $district_data['school_num']*100/$district_data['tot_schoolnum'];;
			$district_data['trash_collect'] = $district_data['trash_collect']/$m;
			$district_data['bus_density'] = $district_data['bus_density']/$m;
			$district_well_count = Marker::countDistrictYearMarkers($_SESSION['login']['district_id'], $_POST['year'], 2);
			$district_data['well_num'] = $district_well_count['COUNT(*)'];
			$district_data['well_density'] = $district_data['well_density']/$m;
			$district_data['well_ratio'] = ($district_data['well_num']/$district_data['population'])*1000;
			$district_trash_count = Marker::countDistrictYearMarkers($_SESSION['login']['district_id'], $_POST['year'], 31);
			$district_data['trash_num'] = $district_trash_count['COUNT(*)'];
			$district_data['risk_ratio'] = 0;
			$district_hospital_count = Marker::countDistrictYearMarkers($_SESSION['login']['district_id'], $_POST['year'], 9);
			$district_data['hospital_num'] = $district_hospital_count['COUNT(*)'];
			$district_data['hospital_ratio'] = ($district_data['hospital_num']/$district_data['population'])*1000;
			$district_toron_garts_area_total = 0;
			$district_toron_garts_list = Crosswalk::getDistrictCrosswalks($_SESSION['login']['district_id']);
			foreach($district_toron_garts_list as $district_toron_garts) {
				$district_toron_garts_area_total = $district_toron_garts_area_total + $district_toron_garts['area'];
			}
			$district_data['toron_garts'] = $district_toron_garts_area_total;
			$district_pale_ground_area_total = 0;
			$district_pale_ground_list = Earthground::getDistrictEarthgrounds($_SESSION['login']['district_id']);
			foreach($district_pale_ground_list as $district_pale_ground) {
				$district_pale_ground_area_total = $district_pale_ground_area_total + $district_pale_ground['area'];
			}
			$district_data['pale_ground'] = $district_pale_ground_area_total;
			$district_risk_area_total = 0;
			$district_risk_area_list = Risks::getDistrictRisks($_SESSION['login']['district_id']);
			foreach($district_risk_area_list as $district_risk_area) {
				$district_risk_area_total = $district_risk_area_total + $district_risk_area['area'];
			}
			$district_data['risk_area'] = $district_risk_area_total;
			$district_info_exist = Info::DistrictInfoGet($_SESSION['login']['district_id'], $_POST["year"]);
			if($district_info_exist == NULL) {
				$district_response = Info::districtInfoAdd($_SESSION['login']['district_id'], $_POST['year'], $district_data);
			} else {
				$district_response = Info::districtInfoEdit($_SESSION['login']['district_id'], $_POST['year'], $district_data, $district_info_exist['id']);
			}
			
			$capital_data = array('population' => 0, 'household' => 0, 'household_average' => 0, 'population_density' => 0, 'kin_num' => 0, 'tot_kinnum' => 0, 'kin_ratio' => 0, 'school_num' => 0, 'tot_schoolnum' => 0, 'school_ratio' => 0, 'year' => $_POST["year"], 'trash_collect' => 0, 'bus_density' => 0, 'well_num' => 0, 'well_density' => 0, 'well_ratio' => 0, 'trash_num' => 0, 'risk_ratio' => 0, 'hospital_num' => 0, 'hospital_ratio' => 0, 'toron_garts' => 0, 'area_length' => 0, 'pale_ground' => 0, 'risk_area' => 0);
			$dists = District::getDistrictList();
			$n = 0;
			foreach($dists as $dist) {
				$dist_info = Info::DistrictInfoGet($dist['id'], $_POST['year']);
				if($dist_info != NULL) {
					$n = $n + 1;
					$capital_data['population'] = $capital_data['population'] + $dist_info['population'];
					$capital_data['household'] = $capital_data['household'] + $dist_info['household'];
					$capital_data['kin_num'] = $capital_data['kin_num'] + $dist_info['kin_num'];
					$capital_data['tot_kinnum'] = $capital_data['tot_kinnum'] + $dist_info['tot_kinnum'];
					$capital_data['school_num'] = $capital_data['school_num'] + $dist_info['school_num'];
					$capital_data['tot_schoolnum'] = $capital_data['tot_schoolnum'] + $dist_info['tot_schoolnum'];
					$capital_data['trash_collect'] = $capital_data['trash_collect'] + $dist_info['trash_collect'];
					$capital_data['bus_density'] = $capital_data['bus_density'] + $dist_info['bus_density'];
					$capital_data['well_density'] = $capital_data['well_density'] + $dist_info['well_density'];
					$capital_data['area_length'] = $capital_data['area_length'] + $dist_info['area_length'];
				}
			}
			$capital_data['household_average'] = $capital_data['population']/$capital_data['household'];
			$capital_data['population_density'] = $capital_data['population']/$capital_data['area_length'];
			$capital_data['kin_ratio'] = $capital_data['kin_num']*100/$capital_data['tot_kinnum'];;
			$capital_data['school_ratio'] = $capital_data['school_num']*100/$capital_data['tot_schoolnum'];;
			$capital_data['trash_collect'] = $capital_data['trash_collect']/$m;
			$capital_data['bus_density'] = $capital_data['bus_density']/$m;
			$capital_well_count = Marker::countCityYearMarkers($_POST['year'], 2);
			$capital_data['well_num'] = $capital_well_count['COUNT(*)'];
			$capital_data['well_density'] = $capital_data['well_density']/$m;
			$capital_data['well_ratio'] = ($capital_data['well_num']/$capital_data['population'])*1000;
			$capital_trash_count = Marker::countCityYearMarkers($_POST['year'], 31);
			$capital_data['trash_num'] = $capital_trash_count['COUNT(*)'];
			$capital_data['risk_ratio'] = 0;
			$capital_hospital_count = Marker::countCityYearMarkers($_POST['year'], 9);
			$capital_data['hospital_num'] = $capital_hospital_count['COUNT(*)'];
			$capital_data['hospital_ratio'] = ($capital_data['hospital_num']/$capital_data['population'])*1000;
			$capital_toron_garts_area_total = 0;
			$capital_toron_garts_list = Crosswalk::getCityCrosswalks();
			foreach($capital_toron_garts_list as $capital_toron_garts) {
				$capital_toron_garts_area_total = $capital_toron_garts_area_total + $capital_toron_garts['area'];
			}
			$capital_data['toron_garts'] = $capital_toron_garts_area_total;
			$capital_pale_ground_area_total = 0;
			$capital_pale_ground_list = Earthground::getCityEarthgrounds();
			foreach($capital_pale_ground_list as $capital_pale_ground) {
				$capital_pale_ground_area_total = $capital_pale_ground_area_total + $capital_pale_ground['area'];
			}
			$capital_data['pale_ground'] = $capital_pale_ground_area_total;
			$capital_risk_area_total = 0;
			$capital_risk_area_list = Risks::getCityRisks();
			foreach($capital_risk_area_list as $capital_risk_area) {
				$capital_risk_area_total = $capital_risk_area_total + $capital_risk_area['area'];
			}
			$capital_data['risk_area'] = $capital_risk_area_total;
			$capital_info_exist = Info::CityInfo($_POST["year"]);
			if($capital_info_exist == NULL) {
				$district_response = Info::cityInfoAdd($_POST['year'], $capital_data);
			} else {
				$district_response = Info::cityInfoEdit($_POST['year'], $capital_data, $capital_info_exist['id']);
			}
			
			header( "Location: infos.php?status=infoSaved" );	
		}
	}
	$sections = Section::getRegionPublishedSections($_SESSION['login']['region_id']);
	$districtHeader = District::getDistrict($_SESSION['login']['district_id']);
	$regionHeader = Region::getRegion($_SESSION['login']['region_id']);
	require(ADMIN_TEMPLATE . "infos/infoAdd.php");
}

function infoList() {
	User::allowExecute(3);
	$results = Info::infoRegionList($_SESSION['login']['district_id'], $_SESSION['login']['region_id']);
	if ( isset( $_GET['status'] ) ) {
    	if ( $_GET['status'] == "infoSaved" ) $results['statusMessage'] = "Мэдээлэл амжилттай хадгалагдлаа.";
    	if ( $_GET['status'] == "saveUnsuccess" ) $results['statusMessage'] = "Хадгалах явцад алдаа гарлаа.";
    	if ( $_GET['status'] == "deleteSuccess" ) $results['statusMessage'] = "Мэдээлэл амжилттай устгагдлаа.";
    	if ( $_GET['status'] == "deleteUnsuccess" ) $results['statusMessage'] = "Устгах явцад алдаа гарсан тул дахин оролдоно уу.";
  	}
	require(ADMIN_TEMPLATE . "infos/infoRegionList.php");
}

?>