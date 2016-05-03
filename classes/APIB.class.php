<?php
require_once(realpath(dirname(__FILE__))."/../config/config.php");
require_once(realpath(dirname(__FILE__))."/../config/Database.class.php");
require_once(realpath(dirname(__FILE__))."/Cache.class.php");

class APIB {
  /**
   * @var Singleton The reference to *APIB* instance of this class
   */
  private static $instance;
  private $_db;
  private $_cache;
  
  /**
   * Returns the *Singleton* instance of this class.
   *
   * @return Singleton The *Singleton* instance.
   */
  public static function app(){
      if (null === static::$instance) {
          static::$instance = new APIB();
      }
      
      return static::$instance;
  }

  /**
   * Protected constructor to prevent creating a new instance of the
   * *Singleton* via the `new` operator from outside of this class.
   */
  protected function __construct(){
  
  }
  
  public function getCache($cacheDir=null){
      if($this->_cache===null){
        $this->_cache=new Cache($cacheDir);
      }
      return $this->_cache;
  }

  public function getDb(){
      if($this->_db===null){
        $this->_db=new Database( DB_SERVER, DB_USER, DB_PASS, DB_DATABASE );
      }
      return $this->_db;
  }

  public static function getPlaygroundBorders($ids) {
    $db = APIB::app()->getDb();
    $db->connect();
    $sql = "SELECT coordinate FROM kh_playgrounds
        WHERE id IN (".$ids.")";
    $rows = $db->fetch_all_array($sql);
    $db->close();
    return $rows;
  }

  public static function getRisksBorders($ids) {
    $db = APIB::app()->getDb();
    $db->connect();
    $sql = "SELECT coordinate FROM kh_risks
        WHERE id IN (".$ids.")";
    $rows = $db->fetch_all_array($sql);
    $db->close();
    return $rows;
  }

  public static function getRoadBorders($ids) {
    $db = APIB::app()->getDb();
    $db->connect();
    $sql = "SELECT coordinate FROM kh_roads
        WHERE id IN (".$ids.")";
    $rows = $db->fetch_all_array($sql);
    $db->close();
    return $rows;
  }

  public static function debug($data){

    if(is_array($data) || is_object($data))
    {
      echo 'PHP:';
      echo("<script>console.log(".json_encode($data).");</script>");
    } else {
      echo("<script>console.log('PHP: ".$data."');</script>");
    }
  }
}
