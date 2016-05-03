<?php

class Cache{
	public $cacheDir='/var/tmp';
	public $expireTime=86400;
	public $isPageInCache=false;

	private $_pageID;

	public function __construct($cacheDir=null){
		if($cacheDir!==null)
			$this->initCacheDir($cacheDir);
	}

	private function initCacheDir($cacheDir){
		$this->cacheDir=$cacheDir;
		if(!is_dir($this->cacheDir)){
			if(!mkdir($this->cacheDir))
				throw new Exception("Can't init cache directory!", 1);
				
		}
	}

	protected function generateFileName($key){
		return $this->cacheDir.'/'.$key.'.cache';
	}

	public function set($key,$data,$expire=null){
		$expireTime=$expire!==null?time()+$expire:time()+$this->expireTime;
		$dataSerialize= base64_encode(serialize(array('expire' => $expireTime,'data'=>$data)));
		return file_put_contents($this->generateFileName($key),$dataSerialize);
	}

	public function get($key){
		$cacheFile=$this->generateFileName($key);
		if(is_file($cacheFile)){
			$data=file_get_contents($cacheFile);
			if($data!==false){
				$data=unserialize(base64_decode($data));
				if($data['expire']>=time()){
					return $data['data'];
				}
			}
		}
		return false;
	}

	public function flushAllCache(){
		if ($handle = opendir($this->cacheDir)) {

		    /* This is the correct way to loop over the directory. */
		    while (false !== ($entry = readdir($handle))) {
		    	$filepath=$this->cacheDir.'/'.$entry;
		        if(is_file($filepath))
		        	unlink($filepath);
		    }
		    closedir($handle);
		}
	}

	private function generatePageID(){
		if($this->_pageID===null){
			$this->_pageID=sha1($_SERVER['REQUEST_URI']);
		}
		return $this->_pageID;
	}

	public function pageCacheStart(){
		if(isset($_GET['flushcache']) && $_GET['flushcache']===1){
			$this->flushAllCache();
		}

		$cache=$this->get($this->generatePageID());
		if($cache!==false && !isset($_GET['nocache'])){
			$this->isPageInCache=true;
			echo $cache;
			exit();
		}
		else{
			ob_start();
			$this->isPageInCache=false;
		}
		
	}

	public function pageCacheEnd(){
		$content=ob_get_flush();
		if ($_SERVER['REQUEST_METHOD'] === 'GET'){
			$cache=$this->set($this->generatePageID(),$content);
		}
	}
}