<?php
require_once(realpath(dirname(__FILE__))."/../config/config.php"); 
require_once(realpath(dirname(__FILE__))."/../config/Database.class.php");
define('TABLE_INFOS', "kh_infos");

class Info {
	
	public static function CityInfo($year) {
		$db = new Database( DB_SERVER, DB_USER, DB_PASS, DB_DATABASE );
		$db->connect();
		$sql = "SELECT * FROM kh_infos WHERE year = ".$year." AND district_id IS NULL AND region_id IS NULL AND section_id = 0";
		$data = $db->query_first($sql);
		$db->close();
		return $data;
	}
	
	public static function DistrictInfoGet($district, $year) {
		$db = new Database( DB_SERVER, DB_USER, DB_PASS, DB_DATABASE );
		$db->connect();
		$sql = "SELECT * FROM kh_infos WHERE year = ".$year." AND district_id = $district AND region_id IS NULL AND section_id = 0";
		$data = $db->query_first($sql);
		$db->close();
		return $data;
	}

	public static function RegionInfo($region, $year) {
		$db = new Database( DB_SERVER, DB_USER, DB_PASS, DB_DATABASE );
		$db->connect();
		$sql = "SELECT * FROM kh_infos WHERE year = ".$year." AND region_id = ".$region." AND section_id = 0";
		$data = $db->query_first($sql);
		$db->close();
		return $data;
	}
	
	public static function SectionInfo($region, $district, $section, $year) {
		$db = new Database( DB_SERVER, DB_USER, DB_PASS, DB_DATABASE );
		$db->connect();
		$sql = "SELECT * FROM kh_infos WHERE year = ".$year." AND region_id = ".$region." AND district_id = ".$district." AND section_id = ".$section."";
		$section_data = $db->query_first($sql);
		$db->close();
		return $section_data;
	}
	
	public static function reportDistrictInfo($district, $year) {
		$db = new Database( DB_SERVER, DB_USER, DB_PASS, DB_DATABASE );
		$db->connect();
		$sql = "SELECT kh_infos.*, kh_districts.title as district_title FROM ".TABLE_INFOS." 
				LEFT JOIN kh_districts ON kh_infos.district_id=kh_districts.id
				WHERE district_id =".$district." AND region_id IS NULL AND year = ".$year."";
		$info_district = $db->query_first($sql);
		$db->close();
		return $info_district;
	}
	
	public static function singleRegionInfo($region) {
		$db = new Database( DB_SERVER, DB_USER, DB_PASS, DB_DATABASE );
		$db->connect();
		$year_sql = "SELECT * FROM kh_years WHERE used = 1";
		$info_year = $db->query_first($year_sql);
		$sql = "SELECT kh_infos.*, kh_districts.title as district_title, kh_regions.title as region_title FROM ".TABLE_INFOS." 
				LEFT JOIN kh_districts ON kh_infos.district_id=kh_districts.id
				LEFT JOIN kh_regions ON kh_infos.region_id=kh_regions.id
				WHERE region_id = ".$region." AND year = ".$info_year['year']." AND section_id = 0";
		$info_region = $db->query_first($sql);
		$db->close();
		return $info_region;
	}

	public static function DistrictInfo($district) {
		$db = new Database( DB_SERVER, DB_USER, DB_PASS, DB_DATABASE );
		$db->connect();
		$year_sql = "SELECT * FROM kh_years WHERE used = 1";
		$info_year = $db->query_first($year_sql);
		$sql = "SELECT kh_infos.*, kh_districts.title as district_title FROM ".TABLE_INFOS." 
				LEFT JOIN kh_districts ON kh_infos.district_id=kh_districts.id
				WHERE district_id =".$district." AND region_id IS NULL AND year = ".$info_year['year']."";
		$info_district = $db->query_first($sql);
		$db->close();
		return $info_district;
	}
	
	public function getCityInfo() {
		$db = new Database( DB_SERVER, DB_USER, DB_PASS, DB_DATABASE );
		$db->connect();
		$year_sql = "SELECT * FROM kh_years WHERE used = 1";
		$info_year = $db->query_first($year_sql);
		$sql = "SELECT * FROM ".TABLE_INFOS." 
					WHERE district_id IS NULL AND region_id IS NULL AND year = ".$info_year['year']."
					ORDER BY region_id ASC";
		$info_district = $db->query_first($sql);
		$db->close();
		$results = array();
		$results['info'] = $info_district;
		$results['year'] = $info_year['year'];
		return $results;
	}
	
	public static function getInfo($id) {
		$db = new Database( DB_SERVER, DB_USER, DB_PASS, DB_DATABASE );
		$db->connect();
		$sql = "SELECT * FROM kh_infos WHERE id = ".$id."";
		$primary_id = $db->query_first($sql);
		$db->close();
		return $primary_id;
	}
	
	function getDistricts($db) {
		$sql = "SELECT * FROM kh_districts ORDER BY title ASC";
		$districts = $db->fetch_all_array($sql);
		return $districts;
	}
	
	function getRegions($db, $district) {
		$sql = "SELECT * FROM kh_regions WHERE district_id = ".$district."";
		$regions = $db->fetch_all_array($sql);
		return $regions;
	}
	
	function getDistrictData($db, $district, $year) {
		$sql = "SELECT * FROM kh_infos WHERE year = ".$year." AND region_id IS NULL AND district_id = ".$district." AND section_id = 0";
		$district_data = $db->query_first($sql);
		return $district_data;
	}
	
	function getRegionData($db, $district, $region, $year) {
		$sql = "SELECT * FROM kh_infos WHERE year = ".$year." AND region_id = ".$region." AND district_id = ".$district." AND section_id = 0";
		$region_data = $db->query_first($sql);
		return $region_data;
	}
	
	function getCityData($db, $year) {
		$sql = "SELECT * FROM kh_infos WHERE year = ".$year." AND region_id IS NULL AND district_id IS NULL AND section_id = 0";
		$city_data = $db->query_first($sql);
		return $city_data;
	}
	
	function markerCount($db, $type, $year, $district, $region) {
		$sql = "SELECT COUNT(*)
				FROM kh_markers
				WHERE type_id = ".$type." AND year = ".$year." AND district_id = ".$district." AND region_id = ".$region."";	
		$results = $db->query_first($sql);
		return $results['COUNT(*)'];
	}
	
	function getSectionData($db, $region, $district, $section, $year) {
		$sql = "SELECT * FROM kh_infos WHERE year = ".$year." AND region_id = ".$region." AND district_id = ".$district." AND section_id = ".$section."";
		$section_data = $db->query_first($sql);
		return $section_data;
	}
	
	function getSections($db, $region) {
		$sql = "SELECT * FROM kh_sections WHERE region_id = ".$region." ORDER BY title ASC";
		$sections = $db->fetch_all_array($sql);
		$checkSectionTitle = NULL;
		foreach($sections as $sec) {
			if($checkSectionTitle == NULL) {
				$checkSectionTitle = $sec['title'];
				$sections_to_return[] = $sec;
			} else {
				if($sec['title'] != $checkSectionTitle) {
					$checkSectionTitle = $sec['title'];
					$sections_to_return[] = $sec;
				}	
			}
		}
		return $sections_to_return;
	}
	
	public static function cityInfoAdd($year, $info) {
		$db = new Database( DB_SERVER, DB_USER, DB_PASS, DB_DATABASE );
		$db->connect();
		$data['section_id'] = 0;
		$data['year'] = $year;
		/* Нийт хүн амын тоо */
		$data['population'] = $info['population'];
		/* Нийт өрхийн тоо */
		$data['household'] = $info['household'];
		/* Өрхийн дундаж хэмжээ */
		$data['household_average'] = $info['population']/$info['household'];
		/* Газар нутгийн хэмжээ */
		$data['area_length'] = $info['area_length']/10000;
		/* Хүн амын нягтаршил */
		$data['population_density'] = $info['population']/($info['area_length']/10000);
		/* Автобусны буудлаас 5 минут алхах зайд амьдардаг хүн амын % */
		$data['bus_density'] = $info['bus_density'];
		/* Усны худгаас 5 минут алхах зайд амьдардаг хүн амын % */
		$data['well_density'] = $info['well_density'];
		/* Аюултай бүсээс 100 м зайнд амьдардаг хүн амын % */
		$data['risk_ratio'] = $info['risk_ratio'];
		/* 2-5 насны цэцэрлэгт хамрагддаггүй хүүхдийн тоо */
		$data['kin_num'] = $info['kin_num'];
		$data['tot_kinnum'] = $info['tot_kinnum'];
		$data['kin_ratio'] = $info['kin_num']*100/$info['tot_kinnum'];
		/* 6-16 насны сургуульд хамрагддаггүй хүүхдийн тоо */
		$data['school_num'] = $info['school_num'];
		$data['tot_schoolnum'] = $info['tot_schoolnum'];
		$data['school_ratio'] = $info['school_num']*100/$info['tot_schoolnum'];
		/* сул шороон хөрстэй талбай */
		$data['pale_ground'] = $info['pale_ground'];
		$data['risk_area'] = $info['risk_area'];
		/* хогийн цэг ачих давтамж */
		$data['trash_collect'] = $info['trash_collect'];
		$data['toron_garts']  = $info['toron_garts'];
		$data['created'] = date('Y-m-d H:i:s');
		$data['modified'] = date('Y-m-d H:i:s');
		$sql = "SELECT * FROM kh_infos WHERE year = ".$year." AND district_id IS NULL AND region_id IS NULL AND section_id = 0";
		$year_data = $db->query_first($sql);
		if ($year_data == NULL) {
			$primary_id = $db->query_insert(TABLE_INFOS, $data);
		} else {
			$primary_id = 0;
		}
		$db->close();
		return $primary_id;
	} 
	
	public static function districtInfoAdd($district, $year, $info) {
		$db = new Database( DB_SERVER, DB_USER, DB_PASS, DB_DATABASE );
		$db->connect();
		$data['district_id'] = $district;
		$data['section_id'] = 0;
		$data['year'] = $year;
		/* Нийт хүн амын тоо */
		$data['population'] = $info['population'];
		/* Нийт өрхийн тоо */
		$data['household'] = $info['household'];
		/* Өрхийн дундаж хэмжээ */
		$data['household_average'] = $info['population']/$info['household'];
		/* Газар нутгийн хэмжээ */
		$data['area_length'] = $info['area_length'];
		/* Хүн амын нягтаршил */
		$data['population_density'] = $info['population']/($info['area_length']);
		/* Автобусны буудлаас 5 минут алхах зайд амьдардаг хүн амын % */
		$data['bus_density'] = $info['bus_density'];
		/* Усны худгаас 5 минут алхах зайд амьдардаг хүн амын % */
		$data['well_density'] = $info['well_density'];
		/* Аюултай бүсээс 100 м зайнд амьдардаг хүн амын % */
		$data['risk_ratio'] = $info['risk_ratio'];
		/* 2-5 насны цэцэрлэгт хамрагддаггүй хүүхдийн тоо */
		$data['kin_num'] = $info['kin_num'];
		$data['tot_kinnum'] = $info['tot_kinnum'];
		$data['kin_ratio'] = $info['kin_num']*100/$info['tot_kinnum'];
		/* 6-16 насны сургуульд хамрагддаггүй хүүхдийн тоо */
		$data['school_num'] = $info['school_num'];
		$data['tot_schoolnum'] = $info['tot_schoolnum'];
		$data['school_ratio'] = $info['school_num']*100/$info['tot_schoolnum'];
		/* сул шороон хөрстэй талбай */
		$data['pale_ground'] = $info['pale_ground'];
		$data['risk_area'] = $info['risk_area'];
		/* хогийн цэг ачих давтамж */
		$data['trash_collect'] = $info['trash_collect'];
		$data['toron_garts']  = $info['toron_garts'];
		$data['created'] = date('Y-m-d H:i:s');
		$data['modified'] = date('Y-m-d H:i:s');
		$sql = "SELECT * FROM kh_infos WHERE year = ".$year." AND district_id = ".$district." AND region_id IS NULL AND section_id = 0";
		$year_data = $db->query_first($sql);
		if ($year_data == NULL) {
			$primary_id = $db->query_insert(TABLE_INFOS, $data);
		} else {
			$primary_id = 0;
		}
		$db->close();
		return $primary_id;
	} 
	
	public static function regionInfoAdd($district, $region, $year, $info) {
		$db = new Database( DB_SERVER, DB_USER, DB_PASS, DB_DATABASE );
		$db->connect();
		$data['region_id'] = $region;
		$data['district_id'] = $district;
		$data['section_id'] = 0;
		$data['year'] = $year;
		/* Нийт хүн амын тоо */
		$data['population'] = $info['population'];
		/* Нийт өрхийн тоо */
		$data['household'] = $info['household'];
		/* Өрхийн дундаж хэмжээ */
		$data['household_average'] = $info['population']/$info['household'];
		/* Газар нутгийн хэмжээ */
		$data['area_length'] = $info['area_length'];
		/* Хүн амын нягтаршил */
		$data['population_density'] = $info['population']/($info['area_length']);
		/* Автобусны буудлаас 5 минут алхах зайд амьдардаг хүн амын % */
		$data['bus_density'] = $info['bus_density'];
		/* Усны худгаас 5 минут алхах зайд амьдардаг хүн амын % */
		$data['well_density'] = $info['well_density'];
		/* Аюултай бүсээс 100 м зайнд амьдардаг хүн амын % */
		$data['risk_ratio'] = $info['risk_ratio'];
		/* 2-5 насны цэцэрлэгт хамрагддаггүй хүүхдийн тоо */
		$data['kin_num'] = $info['kin_num'];
		$data['tot_kinnum'] = $info['tot_kinnum'];
		$data['kin_ratio'] = $info['kin_num']*100/$info['tot_kinnum'];
		/* 6-16 насны сургуульд хамрагддаггүй хүүхдийн тоо */
		$data['school_num'] = $info['school_num'];
		$data['tot_schoolnum'] = $info['tot_schoolnum'];
		$data['school_ratio'] = $info['school_num']*100/$info['tot_schoolnum'];
		/* сул шороон хөрстэй талбай */
		$data['pale_ground'] = $info['pale_ground'];
		$data['risk_area'] = $info['risk_area'];
		/* хогийн цэг ачих давтамж */
		$data['trash_collect'] = $info['trash_collect'];
		$data['toron_garts']  = $info['toron_garts'];
		$data['created'] = date('Y-m-d H:i:s');
		$data['modified'] = date('Y-m-d H:i:s');
		$sql = "SELECT * FROM kh_infos WHERE year = ".$year." AND district_id = ".$district." AND region_id = ".$region." AND section_id = 0";
		$year_data = $db->query_first($sql);
		if ($year_data == NULL) {
			$primary_id = $db->query_insert(TABLE_INFOS, $data);
		} else {
			$primary_id = 0;
		}
		$db->close();
		return $primary_id;
	}
	
	public static function cityInfoEdit($year, $info, $id) {
		$db = new Database( DB_SERVER, DB_USER, DB_PASS, DB_DATABASE );
		$db->connect();
		$data['section_id'] = 0;
		$data['year'] = $year;
		/* Нийт хүн амын тоо */
		$data['population'] = $info['population'];
		/* Нийт өрхийн тоо */
		$data['household'] = $info['household'];
		/* Өрхийн дундаж хэмжээ */
		$data['household_average'] = $info['population']/$info['household'];
		/* Газар нутгийн хэмжээ */
		$data['area_length'] = $info['area_length'];
		/* Хүн амын нягтаршил */
		$data['population_density'] = $info['population']/($info['area_length']);
		/* Автобусны буудлаас 5 минут алхах зайд амьдардаг хүн амын % */
		$data['bus_density'] = $info['bus_density'];
		/* Усны худгаас 5 минут алхах зайд амьдардаг хүн амын % */
		$data['well_density'] = $info['well_density'];
		/* Аюултай бүсээс 100 м зайнд амьдардаг хүн амын % */
		$data['risk_ratio'] = $info['risk_ratio'];
		/* 2-5 насны цэцэрлэгт хамрагддаггүй хүүхдийн тоо */
		$data['kin_num'] = $info['kin_num'];
		$data['tot_kinnum'] = $info['tot_kinnum'];
		$data['kin_ratio'] = $info['kin_num']*100/$info['tot_kinnum'];
		/* 6-16 насны сургуульд хамрагддаггүй хүүхдийн тоо */
		$data['school_num'] = $info['school_num'];
		$data['tot_schoolnum'] = $info['tot_schoolnum'];
		$data['school_ratio'] = $info['school_num']*100/$info['tot_schoolnum'];
		/* сул шороон хөрстэй талбай */
		$data['pale_ground'] = $info['pale_ground'];
		$data['risk_area'] = $info['risk_area'];
		/* хогийн цэг ачих давтамж */
		$data['trash_collect'] = $info['trash_collect'];
		$data['toron_garts']  = $info['toron_garts'];
		$data['modified'] = date('Y-m-d H:i:s');
		$primary_id = $db->query_update(TABLE_INFOS, $data, "id='".$id."'");
		$db->close();
		return $primary_id;
	}
	
	public static function districtInfoEdit($district, $year, $info, $id) {
		$db = new Database( DB_SERVER, DB_USER, DB_PASS, DB_DATABASE );
		$db->connect();
		$data['district_id'] = $district;
		$data['section_id'] = 0;
		$data['year'] = $year;
		/* Нийт хүн амын тоо */
		$data['population'] = $info['population'];
		/* Нийт өрхийн тоо */
		$data['household'] = $info['household'];
		/* Өрхийн дундаж хэмжээ */
		$data['household_average'] = $info['population']/$info['household'];
		/* Газар нутгийн хэмжээ */
		$data['area_length'] = $info['area_length'];
		/* Хүн амын нягтаршил */
		$data['population_density'] = $info['population']/($info['area_length']);
		/* Автобусны буудлаас 5 минут алхах зайд амьдардаг хүн амын % */
		$data['bus_density'] = $info['bus_density'];
		/* Усны худгаас 5 минут алхах зайд амьдардаг хүн амын % */
		$data['well_density'] = $info['well_density'];
		/* Аюултай бүсээс 100 м зайнд амьдардаг хүн амын % */
		$data['risk_ratio'] = $info['risk_ratio'];
		/* 2-5 насны цэцэрлэгт хамрагддаггүй хүүхдийн тоо */
		$data['kin_num'] = $info['kin_num'];
		$data['tot_kinnum'] = $info['tot_kinnum'];
		$data['kin_ratio'] = $info['kin_num']*100/$info['tot_kinnum'];
		/* 6-16 насны сургуульд хамрагддаггүй хүүхдийн тоо */
		$data['school_num'] = $info['school_num'];
		$data['tot_schoolnum'] = $info['tot_schoolnum'];
		$data['school_ratio'] = $info['school_num']*100/$info['tot_schoolnum'];
		/* сул шороон хөрстэй талбай */
		$data['pale_ground'] = $info['pale_ground'];
		$data['risk_area'] = $info['risk_area'];
		/* хогийн цэг ачих давтамж */
		$data['trash_collect'] = $info['trash_collect'];
		$data['toron_garts']  = $info['toron_garts'];
		$data['modified'] = date('Y-m-d H:i:s');
		$primary_id = $db->query_update(TABLE_INFOS, $data, "id='".$id."'");
		$db->close();
		return $primary_id;
	}
	
	public static function regionInfoEdit($district, $region, $year, $info, $id) {
		$db = new Database( DB_SERVER, DB_USER, DB_PASS, DB_DATABASE );
		$db->connect();
		$data['region_id'] = $region;
		$data['district_id'] = $district;
		$data['section_id'] = 0;
		$data['year'] = $year;
		/* Нийт хүн амын тоо */
		$data['population'] = $info['population'];
		/* Нийт өрхийн тоо */
		$data['household'] = $info['household'];
		/* Өрхийн дундаж хэмжээ */
		if($info['population'] > 0) {
			if($info['household'] > 0) {
				$data['household_average'] = $info['population']/$info['household'];
			} else {
				$data['household_average'] = 0;
			}
		} else {
			$data['household_average'] = 0;
		}
		
		/* Газар нутгийн хэмжээ */
		if($info['area_length'] > 0) {
			$data['area_length'] = $info['area_length'];
		} else {
			$data['area_length'] = 0;
		}
		/* Хүн амын нягтаршил */
		if($info['population'] > 0) {
			if($info['area_length'] > 0) {
				$data['population_density'] = $info['population']/($info['area_length']);
			} else {
				$data['population_density'] = 0;
			}
		} else {
			$data['population_density'] = 0;
		}
		/* Автобусны буудлаас 5 минут алхах зайд амьдардаг хүн амын % */
		$data['bus_density'] = $info['bus_density'];
		/* Усны худгаас 5 минут алхах зайд амьдардаг хүн амын % */
		$data['well_density'] = $info['well_density'];
		/* Аюултай бүсээс 100 м зайнд амьдардаг хүн амын % */
		$data['risk_ratio'] = $info['risk_ratio'];
		/* 2-5 насны цэцэрлэгт хамрагддаггүй хүүхдийн тоо */
		$data['kin_num'] = $info['kin_num'];
		$data['tot_kinnum'] = $info['tot_kinnum'];
		if($info['kin_num'] > 0) {
			if($info['tot_kinnum'] > 0) {
				$data['kin_ratio'] = $info['kin_num']*100/$info['tot_kinnum'];
			} else {
				$data['kin_ratio'] = 0;
			}
		} else {
			$data['kin_ratio'] = 0;
		}
		/* 6-16 насны сургуульд хамрагддаггүй хүүхдийн тоо */
		$data['school_num'] = $info['school_num'];
		$data['tot_schoolnum'] = $info['tot_schoolnum'];
		if($info['school_num'] > 0) {
			if($info['tot_schoolnum'] > 0) {
				$data['school_ratio'] = $info['school_num']*100/$info['tot_schoolnum'];
			} else {
				$data['school_ratio'] = 0;
			}
		} else {
			$data['school_ratio'] = 0;
		}
		/* сул шороон хөрстэй талбай */
		$data['pale_ground'] = $info['pale_ground'];
		$data['risk_area'] = $info['risk_area'];
		/* хогийн цэг ачих давтамж */
		$data['trash_collect'] = $info['trash_collect'];
		$data['toron_garts']  = $info['toron_garts'];
		$data['modified'] = date('Y-m-d H:i:s');
		$primary_id = $db->query_update(TABLE_INFOS, $data, "id='".$id."'");
		$db->close();
		return $primary_id;
	}
	
	public function sectionInfoAdd($district, $region, $info, $section_area) {
		$db = new Database( DB_SERVER, DB_USER, DB_PASS, DB_DATABASE );
		$db->connect();
		$data['region_id'] = $region;
		$data['district_id'] = $district;
		$data['section_id'] = $info['section_id'];
		$data['year'] = $info['year'];
		/* Нийт хүн амын тоо */
		$data['population'] = $info['population'];
		/* Нийт өрхийн тоо */
		$data['household'] = $info['household'];
		/* Өрхийн дундаж хэмжээ */
		$data['household_average'] = $info['population']/$info['household'];
		/* Газар нутгийн хэмжээ */
		$data['area_length'] = $section_area/10000;
		/* Хүн амын нягтаршил */
		$data['population_density'] = $info['population']/($section_area/10000);
		/* Автобусны буудлаас 5 минут алхах зайд амьдардаг хүн амын % */
		$data['bus_density'] = $info['bus_density'];
		/* Усны худгаас 5 минут алхах зайд амьдардаг хүн амын % */
		$data['well_density'] = $info['well_density'];
		/* Аюултай бүсээс 100 м зайнд амьдардаг хүн амын % */
		//$data['risk_ratio'] = $info['risk_ratio'];
		/* 2-5 насны цэцэрлэгт хамрагддаггүй хүүхдийн тоо */
		$data['kin_num'] = $info['kin_num'];
		$data['tot_kinnum'] = $info['tot_kinnum'];
		$data['kin_ratio'] = $info['kin_num']*100/$info['tot_kinnum'];
		/* 6-16 насны сургуульд хамрагддаггүй хүүхдийн тоо */
		$data['school_num'] = $info['school_num'];
		$data['tot_schoolnum'] = $info['tot_schoolnum'];
		$data['school_ratio'] = $info['school_num']*100/$info['tot_schoolnum'];
		/* хогийн цэг ачих давтамж */
		$data['trash_collect'] = $info['trash_collect'];
		$data['created'] = date('Y-m-d H:i:s');
		$data['modified'] = date('Y-m-d H:i:s');
		$sql = "SELECT * FROM kh_infos WHERE year = ".$info['year']." AND district_id = ".$district." AND region_id = ".$region." AND section_id = ".$info['section_id']."";
		$year_data = $db->query_first($sql);
		if ($year_data == NULL) {
			$primary_id = $db->query_insert(TABLE_INFOS, $data);
		} else {
			$primary_id = 0;
		}
		$db->close();
		return $primary_id;
	}
	
	public static function sectionInfoEdit($district, $region, $info, $section_area) {
		$db = new Database( DB_SERVER, DB_USER, DB_PASS, DB_DATABASE );
		$db->connect();
		$data['region_id'] = $region;
		$data['district_id'] = $district;
		$data['section_id'] = $info['section_id'];
		$data['year'] = $info['year'];
		/* Нийт хүн амын тоо */
		$data['population'] = $info['population'];
		/* Нийт өрхийн тоо */
		$data['household'] = $info['household'];
		/* Өрхийн дундаж хэмжээ */
		if($info['population'] > 0) {
			if($info['household'] > 0) {
				$data['household_average'] = $info['population']/$info['household'];
			} else {
				$data['household_average'] = 0;
			}
		} else {
			$data['household_average'] = 0;
		}
		/* Газар нутгийн хэмжээ */
		$data['area_length'] = $section_area/10000;
		/* Хүн амын нягтаршил */
		if($info['population'] > 0) {
			if($section_area > 0) {
				$data['population_density'] = $info['population']/($section_area/10000);
			} else {
				$data['population_density'] = 0;
			}
		} else {
			$data['population_density'] = 0;
		}
		/* Автобусны буудлаас 5 минут алхах зайд амьдардаг хүн амын % */
		$data['bus_density'] = $info['bus_density'];
		/* Усны худгаас 5 минут алхах зайд амьдардаг хүн амын % */
		$data['well_density'] = $info['well_density'];
		/* Аюултай бүсээс 100 м зайнд амьдардаг хүн амын % */
		$data['risk_ratio'] = $info['risk_ratio'];
		/* 2-5 насны цэцэрлэгт хамрагддаггүй хүүхдийн тоо */
		$data['kin_num'] = $info['kin_num'];
		$data['tot_kinnum'] = $info['tot_kinnum'];
		if($info['kin_num'] > 0) {
			if($info['tot_kinnum'] > 0) {
				$data['kin_ratio'] = $info['kin_num']*100/$info['tot_kinnum'];
			} else {
				$data['kin_ratio'] = 0;
			}
		} else {
			$data['kin_ratio'] = 0;
		}
		/* 6-16 насны сургуульд хамрагддаггүй хүүхдийн тоо */
		$data['school_num'] = $info['school_num'];
		$data['tot_schoolnum'] = $info['tot_schoolnum'];
		if($info['school_num'] > 0) {
			if($info['tot_schoolnum'] > 0) {
				$data['school_ratio'] = $info['school_num']*100/$info['tot_schoolnum'];
			} else {
				$data['school_ratio'] = 0;
			}
		} else {
			$data['school_ratio'] = 0;
		}
		/* сул шороон хөрстэй талбай */
		$data['pale_ground'] = $info['pale_ground'];
		/* хогийн цэг ачих давтамж */
		$data['trash_collect'] = $info['trash_collect'];
		$data['toron_garts'] = $info['toron_garts'];
		$data['modified'] = date('Y-m-d H:i:s');
		$primary_id = $db->query_update(TABLE_INFOS, $data, "id='".$info['id']."'");
		
		$db->close();
		return $primary_id;
	}
	
	public function infoAdd($district, $region, $info) {
		$db = new Database( DB_SERVER, DB_USER, DB_PASS, DB_DATABASE );
		$db->connect();
		$data['region_id'] = $region;
		$data['district_id'] = $district;
		$data['year'] = $info['year'];
		/* Нийт хүн амын тоо */
		$data['population'] = $info['population'];
		/* Нийт өрхийн тоо */
		$data['household'] = $info['household'];
		/* Өрхийн дундаж хэмжээ */
		$data['household_average'] = $info['population']/$info['household'];
		/* Газар нутгийн хэмжээ */
		$data['area_length'] = $info['area_length'];
		/* Хүн амын нягтаршил */
		$data['population_density'] = $info['population']/$info['area_length'];
		/* Автобусны буудлаас 5 минут алхах зайд амьдардаг хүн амын % */
		$data['bus_density'] = $info['bus_density'];
		/* Усны худгийн тоо */
		$data['well_num'] = $this->markerCount($db, 2, $info['year'], $district, $region);
		/* Усны худгаас 5 минут алхах зайд амьдардаг хүн амын % */
		$data['well_density'] = $info['well_density'];
		/* 1000 хүнд ноогдох усны худгийн харьцаа */
		$data['well_ratio'] = ($data['well_num']/$info['population'])*1000;
		/* Албан бус хогийн цэгийн тоо */
		$data['trash_num'] = $this->markerCount($db, 10, $info['year'], $district, $region);
		/* Аюултай бүсээс 100 м зайнд амьдардаг хүн амын % */
		$data['risk_area'] = $info['risk_area'];
		$data['risk_ratio'] = $info['risk_area']/100/$data['area_length'];
		/* Өрхийн болон бусад эмнэлэгийн тоо */
		$data['hospital_num'] = $this->markerCount($db, 9, $info['year'], $district, $region);
		/* 1000 хүнд ноогдох өрхийн болон бусад эмнэлэгийн харьцаа */
		$data['hospital_ratio'] = ($data['hospital_num']/$info['population'])*1000;
		/* 2-5 насны цэцэрлэгт хамрагддаггүй хүүхдийн тоо */
		$data['kin_num'] = $info['kin_num'];
		$data['tot_kinnum'] = $info['tot_kinnum'];
		/* 2-5 насны цэцэрлэгт хамрагддаггүй хүүхдийн % */
		$data['kin_ratio'] = $info['kin_num']*100/$info['tot_kinnum'];
		/* 6-16 насны сургуульд хамрагддаггүй хүүхдийн тоо */
		$data['school_num'] = $info['school_num'];
		$data['tot_schoolnum'] = $info['tot_schoolnum'];
		/* 6-16 насны сургуульд хамрагддаггүй хүүхдийн % */
		$data['school_ratio'] = $info['school_num']*100/$info['tot_schoolnum'];
		/* сул шороон хөрстэй талбай */
		$data['pale_ground'] = $info['pale_ground'];
		/* хогийн цэг ачих давтамж */
		$data['trash_collect'] = $info['trash_collect'];
		$data['toron_garts'] = $info['toron_garts'];
		$data['created'] = date('Y-m-d H:i:s');
		$data['modified'] = date('Y-m-d H:i:s');
		$sql = "SELECT * FROM kh_infos WHERE year = ".$info['year']." AND district_id = ".$district." AND region_id = ".$region."";
		$year_data = $db->query_first($sql);
		if ($year_data == NULL) {
			$primary_id = $db->query_insert(TABLE_INFOS, $data);
		} else {
			$primary_id = 0;
		}
		$regions = $this->getRegions($db, $district);
		$currentDistrictData = array('population' => 0, 'household' => 0, 'household_average' => 0, 'area_length' => 0, 'population_density' => 0, 'bus_density' => 0, 'well_num' => 0, 'well_density' => 0, 'well_ratio' => 0, 'trash_num' => 0, 'risk_ratio' => 0, 'hospital_num' => 0, 'hospital_ratio' => 0, 'kin_num' => 0, 'tot_kinnum' => 0, 'kin_ratio' => 0, 'school_num' => 0, 'tot_schoolnum' => 0, 'school_ratio' => 0, 'year' => $info['year'], 'district_id' => $district, 'pale_ground' => 0, 'trash_collect' => 0);
		$reg_count = 0;
		foreach($regions as $reg) {
			$region_data = $this->getRegionData($db, $district, $reg['id'], $info['year']);
			if($region_data != NULL) {
				$currentDistrictData['population'] = $currentDistrictData['population'] + $region_data['population'];
				$currentDistrictData['household'] = $currentDistrictData['household'] + $region_data['household'];
				$currentDistrictData['household_average'] = $currentDistrictData['household_average'] + $region_data['household_average'];
				$currentDistrictData['area_length'] = $currentDistrictData['area_length'] + $region_data['area_length'];
				$currentDistrictData['population_density'] = $currentDistrictData['population_density'] + $region_data['population_density'];
				$currentDistrictData['bus_density'] = $currentDistrictData['bus_density'] + $region_data['bus_density'];
				$currentDistrictData['well_num'] = $currentDistrictData['well_num'] + $region_data['well_num'];
				$currentDistrictData['well_density'] = $currentDistrictData['well_density'] + $region_data['well_density'];
				$currentDistrictData['well_ratio'] = $currentDistrictData['well_ratio'] + $region_data['well_ratio'];
				$currentDistrictData['trash_num'] = $currentDistrictData['trash_num'] + $region_data['trash_num'];
				$currentDistrictData['risk_ratio'] = $currentDistrictData['risk_ratio'] + $region_data['risk_ratio'];
				$currentDistrictData['hospital_num'] = $currentDistrictData['hospital_num'] + $region_data['hospital_num'];
				$currentDistrictData['hospital_ratio'] = $currentDistrictData['hospital_ratio'] + $region_data['hospital_ratio'];
				$currentDistrictData['kin_num'] = $currentDistrictData['kin_num'] + $region_data['kin_num'];
				$currentDistrictData['tot_kinnum'] = $currentDistrictData['tot_kinnum'] + $region_data['tot_kinnum'];
				$currentDistrictData['kin_ratio'] = $currentDistrictData['kin_ratio'] + $region_data['kin_ratio'];
				$currentDistrictData['school_num'] = $currentDistrictData['school_num'] + $region_data['school_num'];
				$currentDistrictData['tot_schoolnum'] = $currentDistrictData['tot_schoolnum'] + $region_data['tot_schoolnum'];
				$currentDistrictData['school_ratio'] = $currentDistrictData['school_ratio'] + $region_data['school_ratio'];	
				$currentDistrictData['pale_ground'] = $currentDistrictData['pale_ground'] + $region_data['pale_ground'];	
				$currentDistrictData['trash_collect'] = $currentDistrictData['trash_collect'] + $region_data['trash_collect'];	
				$currentDistrictData['toron_garts'] = $currentDistrictData['toron_garts'] + $region_data['toron_garts'];	
				$reg_count = $reg_count + 1;
			}
		}
		$currentDistrictData['household_average'] = $currentDistrictData['population']/$currentDistrictData['household'];
		$currentDistrictData['population_density'] = $currentDistrictData['population']/$currentDistrictData['area_length'];
		$currentDistrictData['bus_density'] = $currentDistrictData['bus_density']/$reg_count;
		$currentDistrictData['well_density'] = $currentDistrictData['well_density']/$reg_count;
		$currentDistrictData['well_ratio'] = $currentDistrictData['well_ratio']/$reg_count;
		$currentDistrictData['risk_ratio'] = $currentDistrictData['risk_ratio']/$reg_count;
		$currentDistrictData['hospital_ratio'] = $currentDistrictData['hospital_ratio']/$reg_count;
		$currentDistrictData['kin_ratio'] = $currentDistrictData['kin_ratio']/$reg_count;
		$currentDistrictData['school_ratio'] = $currentDistrictData['school_ratio']/$reg_count;
		$currentDistrictData['trash_collect'] = $currentDistrictData['trash_collect']/$reg_count;
		$currentDistrictExist = $this->getDistrictData($db, $district, $info['year']);
		if($currentDistrictExist != NULL) {
			$currentDistrictData['modified'] = date('Y-m-d H:i:s');
			$districtId = $db->query_update(TABLE_INFOS, $currentDistrictData, "id='".$currentDistrictExist['id']."'");
		} else {
			$currentDistrictData['district_id'] = $district;
			$currentDistrictData['year'] = $info['year'];
			$currentDistrictData['created'] = date('Y-m-d H:i:s');
			$currentDistrictData['modified'] = date('Y-m-d H:i:s');
			$districtId = $db->query_insert(TABLE_INFOS, $currentDistrictData);
		}
		$districts = $this->getDistricts($db);
		$dist_count = 0;
		$districtData = array('population' => 0, 'household' => 0, 'household_average' => 0, 'area_length' => 0, 'population_density' => 0, 'bus_density' => 0, 'well_num' => 0, 'well_density' => 0, 'well_ratio' => 0, 'trash_num' => 0, 'risk_ratio' => 0, 'hospital_num' => 0, 'hospital_ratio' => 0, 'kin_num' => 0, 'tot_kinnum' => 0, 'kin_ratio' => 0, 'school_num' => 0, 'tot_schoolnum' => 0, 'school_ratio' => 0, 'pale_ground' => 0, 'trash_collect' => 0);
		foreach($districts as $dist) {
			$district_data = $this->getDistrictData($db, $dist['id'], $info['year']);
			if($district_data != NULL) {
				$districtData['population'] = $districtData['population'] + $district_data['population']; 
				$districtData['household'] = $districtData['household'] + $district_data['household']; 
				$districtData['household_average'] = $districtData['household_average'] + $district_data['household_average']; 
				$districtData['area_length'] = $districtData['area_length'] + $district_data['area_length']; 
				$districtData['population_density'] = $districtData['population_density'] + $district_data['population_density']; 
				$districtData['bus_density'] = $districtData['bus_density'] + $district_data['bus_density']; 
				$districtData['well_num'] = $districtData['well_num'] + $district_data['well_num']; 
				$districtData['well_density'] = $districtData['well_density'] + $district_data['well_density']; 
				$districtData['well_ratio'] = $districtData['well_ratio'] + $district_data['well_ratio']; 
				$districtData['trash_num'] = $districtData['trash_num'] + $district_data['trash_num']; 
				$districtData['risk_ratio'] = $districtData['risk_ratio'] + $district_data['risk_ratio']; 
				$districtData['hospital_num'] = $districtData['hospital_num'] + $district_data['hospital_num']; 
				$districtData['hospital_ratio'] = $districtData['hospital_ratio'] + $district_data['hospital_ratio']; 
				$districtData['kin_num'] = $districtData['kin_num'] + $district_data['kin_num'];
				$districtData['tot_kinnum'] = $districtData['tot_kinnum'] + $district_data['tot_kinnum'];
				$districtData['kin_ratio'] = $districtData['kin_ratio'] + $district_data['kin_ratio'];
				$districtData['school_num'] = $districtData['school_num'] + $district_data['school_num'];
				$districtData['tot_schoolnum'] = $districtData['tot_schoolnum'] + $district_data['tot_schoolnum'];
				$districtData['school_ratio'] = $districtData['school_ratio'] + $district_data['school_ratio'];
				$districtData['pale_ground'] = $districtData['pale_ground'] + $district_data['pale_ground'];
				$districtData['trash_collect'] = $districtData['trash_collect'] + $district_data['trash_collect'];
				$districtData['toron_garts'] = $districtData['toron_garts'] + $district_data['toron_garts'];
				$dist_count = $dist_count + 1;
			}
		}
		$districtData['household_average'] = $districtData['population']/$districtData['household'];
		$districtData['population_density'] = $districtData['population']/$districtData['area_length'];
		$districtData['bus_density'] = $districtData['bus_density']/$dist_count;
		$districtData['well_density'] = $districtData['well_density']/$dist_count;
		$districtData['well_ratio'] = $districtData['well_ratio']/$dist_count;
		$districtData['risk_ratio'] = $districtData['risk_ratio']/$dist_count;
		$districtData['hospital_ratio'] = $districtData['hospital_ratio']/$dist_count;
		$districtData['kin_ratio'] = $districtData['kin_ratio']/$dist_count;
		$districtData['school_ratio'] = $districtData['school_ratio']/$dist_count;
		$districtData['trash_collect'] = $districtData['trash_collect']/$dist_count;
		$cityDataExist = $this->getCityData($db, $info['year']);
		if($cityDataExist != NULL) {
			$districtData['modified'] = date('Y-m-d H:i:s');
			$cityId = $db->query_update(TABLE_INFOS, $districtData, "id='".$cityDataExist['id']."'");
		} else {
			$districtData['year'] = $info['year'];
			$districtData['created'] = date('Y-m-d H:i:s');
			$districtData['modified'] = date('Y-m-d H:i:s');
			$cityId = $db->query_insert(TABLE_INFOS, $districtData);
		}
		$db->close();
		return $primary_id;
	}
	
	public function infoEdit($district, $region, $info) {
		$db = new Database( DB_SERVER, DB_USER, DB_PASS, DB_DATABASE );
		$db->connect();
		$data['region_id'] = $region;
		$data['district_id'] = $district;
		$data['year'] = $info['year'];
		/* Нийт хүн амын тоо */
		$data['population'] = $info['population'];
		/* Нийт өрхийн тоо */
		$data['household'] = $info['household'];
		/* Өрхийн дундаж хэмжээ */
		$data['household_average'] = $info['population']/$info['household'];
		/* Газар нутгийн хэмжээ */
		$data['area_length'] = $info['area_length'];
		/* Хүн амын нягтаршил */
		$data['population_density'] = $info['population']/$info['area_length'];
		/* Автобусны буудлаас 5 минут алхах зайд амьдардаг хүн амын % */
		$data['bus_density'] = $info['bus_density'];
		/* Усны худгийн тоо */
		$data['well_num'] = $this->markerCount($db, 2, $info['year'], $district, $region);
		/* Усны худгаас 5 минут алхах зайд амьдардаг хүн амын % */
		$data['well_density'] = $info['well_density'];
		/* 1000 хүнд ноогдох усны худгийн харьцаа */
		$data['well_ratio'] = ($data['well_num']/$info['population'])*1000;
		/* Албан бус хогийн цэгийн тоо */
		$data['trash_num'] = $this->markerCount($db, 10, $info['year'], $district, $region);
		/* Аюултай бүсээс 100 м зайнд амьдардаг хүн амын % */
		$data['risk_area'] = $info['risk_area'];
		$data['risk_ratio'] = $info['risk_area']/100/$data['area_length'];
		/* Өрхийн болон бусад эмнэлэгийн тоо */
		$data['hospital_num'] = $this->markerCount($db, 9, $info['year'], $district, $region);
		/* 1000 хүнд ноогдох өрхийн болон бусад эмнэлэгийн харьцаа */
		$data['hospital_ratio'] = ($data['hospital_num']/$info['population'])*1000;
		/* 2-5 насны цэцэрлэгт хамрагддаггүй хүүхдийн тоо */
		$data['kin_num'] = $info['kin_num'];
		$data['tot_kinnum'] = $info['tot_kinnum'];
		/* 2-5 насны цэцэрлэгт хамрагддаггүй хүүхдийн % */
		$data['kin_ratio'] = $info['kin_num']*100/$info['tot_kinnum'];;
		/* 6-16 насны сургуульд хамрагддаггүй хүүхдийн тоо */
		$data['school_num'] = $info['school_num'];
		$data['tot_schoolnum'] = $info['tot_schoolnum'];
		/* 6-16 насны сургуульд хамрагддаггүй хүүхдийн % */
		$data['school_ratio'] = $info['school_num']*100/$info['tot_schoolnum'];
		/* сул шороон хөрстэй талбай */
		$data['pale_ground'] = $info['pale_ground'];
		/* хогийн цэг ачих давтамж */
		$data['trash_collect'] = $info['trash_collect'];
		$data['toron_garts'] = $info['toron_garts'];
		$data['created'] = date('Y-m-d H:i:s');
		$data['modified'] = date('Y-m-d H:i:s');
		$primary_id = $db->query_update(TABLE_INFOS, $data, "id='".$info['id']."'");
	
		$regions = $this->getRegions($db, $district);
		$currentDistrictData = array('population' => 0, 'household' => 0, 'household_average' => 0, 'area_length' => 0, 'population_density' => 0, 'bus_density' => 0, 'well_num' => 0, 'well_density' => 0, 'well_ratio' => 0, 'trash_num' => 0, 'risk_ratio' => 0, 'hospital_num' => 0, 'hospital_ratio' => 0, 'kin_num' => 0, 'tot_kinnum' => 0, 'kin_ratio' => 0, 'school_num' => 0, 'tot_schoolnum' => 0, 'school_ratio' => 0, 'year' => $info['year'], 'district_id' => $district, 'pale_ground' => 0, 'trash_collect' => 0);
		$reg_count = 0;
		foreach($regions as $reg) {
			$region_data = $this->getRegionData($db, $district, $reg['id'], $info['year']);
			if($region_data != NULL) {
				$currentDistrictData['population'] = $currentDistrictData['population'] + $region_data['population'];
				$currentDistrictData['household'] = $currentDistrictData['household'] + $region_data['household'];
				$currentDistrictData['household_average'] = $currentDistrictData['household_average'] + $region_data['household_average'];
				$currentDistrictData['area_length'] = $currentDistrictData['area_length'] + $region_data['area_length'];
				$currentDistrictData['population_density'] = $currentDistrictData['population_density'] + $region_data['population_density'];
				$currentDistrictData['bus_density'] = $currentDistrictData['bus_density'] + $region_data['bus_density'];
				$currentDistrictData['well_num'] = $currentDistrictData['well_num'] + $region_data['well_num'];
				$currentDistrictData['well_density'] = $currentDistrictData['well_density'] + $region_data['well_density'];
				$currentDistrictData['well_ratio'] = $currentDistrictData['well_ratio'] + $region_data['well_ratio'];
				$currentDistrictData['trash_num'] = $currentDistrictData['trash_num'] + $region_data['trash_num'];
				$currentDistrictData['risk_ratio'] = $currentDistrictData['risk_ratio'] + $region_data['risk_ratio'];
				$currentDistrictData['hospital_num'] = $currentDistrictData['hospital_num'] + $region_data['hospital_num'];
				$currentDistrictData['hospital_ratio'] = $currentDistrictData['hospital_ratio'] + $region_data['hospital_ratio'];
				$currentDistrictData['kin_num'] = $currentDistrictData['kin_num'] + $region_data['kin_num'];
				$currentDistrictData['tot_kinnum'] = $currentDistrictData['tot_kinnum'] + $region_data['tot_kinnum'];
				$currentDistrictData['kin_ratio'] = $currentDistrictData['kin_ratio'] + $region_data['kin_ratio'];
				$currentDistrictData['school_num'] = $currentDistrictData['school_num'] + $region_data['school_num'];
				$currentDistrictData['tot_schoolnum'] = $currentDistrictData['tot_schoolnum'] + $region_data['tot_schoolnum'];
				$currentDistrictData['school_ratio'] = $currentDistrictData['school_ratio'] + $region_data['school_ratio'];	
				$currentDistrictData['pale_ground'] = $currentDistrictData['pale_ground'] + $region_data['pale_ground'];	
				$currentDistrictData['trash_collect'] = $currentDistrictData['trash_collect'] + $region_data['trash_collect'];	
				$currentDistrictData['toron_garts'] = $currentDistrictData['toron_garts'] + $region_data['toron_garts'];	
				$reg_count = $reg_count + 1;
			}
		}
		$currentDistrictData['household_average'] = $currentDistrictData['population']/$currentDistrictData['household'];
		$currentDistrictData['population_density'] = $currentDistrictData['population']/$currentDistrictData['area_length'];
		$currentDistrictData['bus_density'] = $currentDistrictData['bus_density']/$reg_count;
		$currentDistrictData['well_density'] = $currentDistrictData['well_density']/$reg_count;
		$currentDistrictData['well_ratio'] = $currentDistrictData['well_ratio']/$reg_count;
		$currentDistrictData['risk_ratio'] = $currentDistrictData['risk_ratio']/$reg_count;
		$currentDistrictData['hospital_ratio'] = $currentDistrictData['hospital_ratio']/$reg_count;
		$currentDistrictData['kin_ratio'] = $currentDistrictData['kin_ratio']/$reg_count;
		$currentDistrictData['school_ratio'] = $currentDistrictData['school_ratio']/$reg_count;
		$currentDistrictData['trash_collect'] = $currentDistrictData['trash_collect']/$reg_count;
		$currentDistrictExist = $this->getDistrictData($db, $district, $info['year']);
		if($currentDistrictExist != NULL) {
			$currentDistrictData['modified'] = date('Y-m-d H:i:s');
			$districtId = $db->query_update(TABLE_INFOS, $currentDistrictData, "id='".$currentDistrictExist['id']."'");
		} else {
			$currentDistrictData['district_id'] = $district;
			$currentDistrictData['year'] = $info['year'];
			$currentDistrictData['created'] = date('Y-m-d H:i:s');
			$currentDistrictData['modified'] = date('Y-m-d H:i:s');
			$districtId = $db->query_insert(TABLE_INFOS, $currentDistrictData);
		}
		$districts = $this->getDistricts($db);
		$dist_count = 0;
		$districtData = array('population' => 0, 'household' => 0, 'household_average' => 0, 'area_length' => 0, 'population_density' => 0, 'bus_density' => 0, 'well_num' => 0, 'well_density' => 0, 'well_ratio' => 0, 'trash_num' => 0, 'risk_ratio' => 0, 'hospital_num' => 0, 'hospital_ratio' => 0, 'kin_num' => 0, 'tot_kinnum' => 0, 'kin_ratio' => 0, 'school_num' => 0, 'tot_schoolnum' => 0, 'school_ratio' => 0, 'pale_ground' => 0, 'trash_collect' => 0);
		foreach($districts as $dist) {
			$district_data = $this->getDistrictData($db, $dist['id'], $info['year']);
			if($district_data != NULL) {
				$districtData['population'] = $districtData['population'] + $district_data['population']; 
				$districtData['household'] = $districtData['household'] + $district_data['household']; 
				$districtData['household_average'] = $districtData['household_average'] + $district_data['household_average']; 
				$districtData['area_length'] = $districtData['area_length'] + $district_data['area_length']; 
				$districtData['population_density'] = $districtData['population_density'] + $district_data['population_density']; 
				$districtData['bus_density'] = $districtData['bus_density'] + $district_data['bus_density']; 
				$districtData['well_num'] = $districtData['well_num'] + $district_data['well_num']; 
				$districtData['well_density'] = $districtData['well_density'] + $district_data['well_density']; 
				$districtData['well_ratio'] = $districtData['well_ratio'] + $district_data['well_ratio']; 
				$districtData['trash_num'] = $districtData['trash_num'] + $district_data['trash_num']; 
				$districtData['risk_ratio'] = $districtData['risk_ratio'] + $district_data['risk_ratio']; 
				$districtData['hospital_num'] = $districtData['hospital_num'] + $district_data['hospital_num']; 
				$districtData['hospital_ratio'] = $districtData['hospital_ratio'] + $district_data['hospital_ratio']; 
				$districtData['kin_num'] = $districtData['kin_num'] + $district_data['kin_num']; 
				$districtData['tot_kinnum'] = $districtData['tot_kinnum'] + $district_data['tot_kinnum']; 
				$districtData['kin_ratio'] = $districtData['kin_ratio'] + $district_data['kin_ratio'];
				$districtData['school_num'] = $districtData['school_num'] + $district_data['school_num'];
				$districtData['tot_schoolnum'] = $districtData['tot_schoolnum'] + $district_data['tot_schoolnum'];
				$districtData['school_ratio'] = $districtData['school_ratio'] + $district_data['school_ratio'];
				$districtData['pale_ground'] = $districtData['pale_ground'] + $district_data['pale_ground'];
				$districtData['trash_collect'] = $districtData['trash_collect'] + $district_data['trash_collect'];
				$districtData['toron_garts'] = $districtData['toron_garts'] + $district_data['toron_garts'];
			}
			$dist_count = $dist_count + 1;
		}
		$districtData['household_average'] = $districtData['population']/$districtData['household'];
		$districtData['population_density'] = $districtData['population']/$districtData['area_length'];
		$districtData['bus_density'] = $districtData['bus_density']/$dist_count;
		$districtData['well_density'] = $districtData['well_density']/$dist_count;
		$districtData['well_ratio'] = $districtData['well_ratio']/$dist_count;
		$districtData['risk_ratio'] = $districtData['risk_ratio']/$dist_count;
		$districtData['hospital_ratio'] = $districtData['hospital_ratio']/$dist_count;
		$districtData['kin_ratio'] = $districtData['kin_ratio']/$dist_count;
		$districtData['school_ratio'] = $districtData['school_ratio']/$dist_count;
		$districtData['trash_collect'] = $districtData['trash_collect']/$dist_count;
		$cityDataExist = $this->getCityData($db, $info['year']);
		if($cityDataExist != NULL) {
			$districtData['modified'] = date('Y-m-d H:i:s');
			$cityId = $db->query_update(TABLE_INFOS, $districtData, "id='".$cityDataExist['id']."'");
		} else {
			$districtData['year'] = $info['year'];
			$districtData['created'] = date('Y-m-d H:i:s');
			$districtData['modified'] = date('Y-m-d H:i:s');
			$cityId = $db->query_insert(TABLE_INFOS, $districtData);
		}
		$db->close();
		return $primary_id;
	}
	
	public static function infoRegionList($district, $region) {
		$db = new Database( DB_SERVER, DB_USER, DB_PASS, DB_DATABASE );
		$db->connect();
		$sql = "SELECT id, title FROM kh_districts
				WHERE id LIKE ".$district."";
		$results['district'] = $db->query_first($sql);
		$sql = "SELECT id, title, image FROM kh_regions
				WHERE id LIKE ".$region."";
		$results['region'] = $db->query_first($sql);
		$sql = "SELECT ".TABLE_INFOS.".*, kh_regions.title as region_title, kh_districts.title as district_title FROM ".TABLE_INFOS."
				LEFT JOIN kh_regions ON ".TABLE_INFOS.".region_id=kh_regions.id
				LEFT JOIN kh_districts ON ".TABLE_INFOS.".district_id=kh_districts.id
				WHERE region_id LIKE ".$region." AND section_id > 0 AND year > 2014
				ORDER BY year DESC";
		$results['info'] = $db->fetch_all_array($sql);
		$db->close();
		return $results;
	}
	
	public function latestDistrictInfo($limit, $district) {
		$db = new Database( DB_SERVER, DB_USER, DB_PASS, DB_DATABASE );
		$db->connect();
		$sql = "SELECT kh_districts.title as district, kh_regions.title as region, kh_infos.created FROM ".TABLE_INFOS." 
				LEFT JOIN kh_regions ON kh_infos.region_id=kh_regions.id 
				LEFT JOIN kh_districts ON kh_infos.district_id=kh_districts.id 
				WHERE kh_infos.district_id = ".$district." 
				ORDER BY kh_infos.created DESC
				LIMIT ".$limit."";
		$rows = $db->fetch_all_array($sql);
		$db->close();
		return $rows;
	} 
	
	public function latestInfo($limit) {
		$db = new Database( DB_SERVER, DB_USER, DB_PASS, DB_DATABASE );
		$db->connect();
		$sql = "SELECT kh_districts.title as district, kh_regions.title as region, kh_infos.created FROM ".TABLE_INFOS." 
				LEFT JOIN kh_regions ON kh_infos.region_id=kh_regions.id 
				LEFT JOIN kh_districts ON kh_infos.district_id=kh_districts.id 
				ORDER BY kh_infos.created DESC
				LIMIT ".$limit."";
		$rows = $db->fetch_all_array($sql);
		$db->close();
		return $rows;
	} 
	
	public static function getDistrictInfo($district) {
    	$db = new Database( DB_SERVER, DB_USER, DB_PASS, DB_DATABASE );
		$db->connect();
		$result = array();
		$year_sql = "SELECT year FROM kh_years WHERE used = 1";
		$info_year = $db->query_first($year_sql);
			$sql = "SELECT * FROM ".TABLE_INFOS." 
					LEFT JOIN kh_districts ON kh_infos.district_id=kh_districts.id
					WHERE district_id LIKE ".$district." AND region_id IS NULL AND section_id LIKE 0 AND year = ".$info_year['year']."";
		$row = $db->query_first($sql);
		$results['district_data'] = $row;
		$sql = "SELECT id, title FROM kh_regions
				WHERE district_id LIKE ".$district."
				ORDER BY id ASC";
		$regions = $db->fetch_all_array($sql);
		foreach($regions as $region) {
			$sql = "SELECT * FROM ".TABLE_INFOS."
					LEFT JOIN kh_regions ON kh_infos.region_id=kh_regions.id
					WHERE year LIKE ".$info_year['year']." AND region_id LIKE ".$region['id']." AND section_id LIKE 0";
			$row = $db->query_first($sql);
			$results['region_data'][$region['id']] = $row;
		}
		$results['year'] = $info_year['year'];
		$results['regions'] = $regions;
		$db->close();
		return $results;
  	}
	
	public static function getRegionInfo($district, $region) {
		$db = new Database( DB_SERVER, DB_USER, DB_PASS, DB_DATABASE );
		$db->connect();
		$result = array();
		$year_sql = "SELECT year FROM kh_years WHERE used = 1";
		$info_year = $db->query_first($year_sql);
		$sql = "SELECT ".TABLE_INFOS.".*, kh_regions.title as region_title, kh_districts.title as district_title FROM ".TABLE_INFOS." 
				LEFT JOIN kh_districts ON ".TABLE_INFOS.".district_id=kh_districts.id
				LEFT JOIN kh_regions ON ".TABLE_INFOS.".region_id=kh_regions.id
				WHERE kh_infos.district_id LIKE ".$district." AND kh_infos.region_id LIKE ".$region." AND kh_infos.section_id LIKE 0 AND kh_infos.year = ".$info_year['year']."";
		$row = $db->query_first($sql);
		$results['data'] = $row;
		$sql = "SELECT id, title FROM kh_regions
				WHERE district_id LIKE ".$district."
				ORDER BY id ASC";
		$regions = $db->fetch_all_array($sql);
		foreach($regions as $region) {
			$sql = "SELECT * FROM ".TABLE_INFOS."
					LEFT JOIN kh_regions ON kh_infos.region_id=kh_regions.id
					WHERE year LIKE ".$info_year['year']." AND region_id LIKE ".$region['id']." AND section_id LIKE 0";
			$row = $db->query_first($sql);
			$results['region_data'][$region['id']] = $row;
		}
		$results['year'] = $info_year['year'];
		$results['regions'] = $regions;
		$db->close();
		return $results;
	}
	
	public static function deleteInfo($id) {
		$db = new Database( DB_SERVER, DB_USER, DB_PASS, DB_DATABASE );
		$db->connect();
		$sql = "DELETE FROM kh_infos WHERE id='".$id."'";
		$menu = $db->query($sql);
		$db->close();
		return $menu;
	}
	
} 

?>