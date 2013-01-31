<?php

class BatiWebAppsLightGate{
	
	
	private static $result;
	
	/**
	 * Objet de gestion de la boutique
	 * @var Store
	 */
	private $siteWebManager;

	
	public function __construct(){
		$this->includeFiles();
		
		if(isset($_SESSION['general']['projet']) && !empty($_SESSION['general']['projet'])){
			$array = unserialize($_SESSION['general']['projet']);
			if(count($array)>0){
				foreach($array as $attribute=>$value){
					$this->$attribute = $value;
				}
			}
		}
		
	}
	
	public function __destruct(){
		$array = array();
		foreach($this as $attribute=>$value){
			$array[$attribute] = $value;
		}
		$_SESSION['general']['projet'] = serialize($array);
	}
	
	
	public function siteWebManagerCommand($cmd, $data=null) {
		if (empty($this->siteWebManager)) $this->siteWebManager = SiteWebManager::create(0); // 0 sera remplac� par DataRevend::getId() qui retournera l'identifiant de la soci�t� actuellement connect�e sur l'appli afin de r�cup�rer son site
		if ($cmd == 'kill') $this->siteWebManager = null;
		else {
			$res = $this->siteWebManager->parseCommand($cmd, $data);
		}
		return $res;
	}
	
	private function includeFiles() {
		
		require_once($_SERVER['DOCUMENT_ROOT'].'/classesBT/core/modules/siteWebManager/class.SiteWebManager.php');
		require_once($_SERVER['DOCUMENT_ROOT'].'/classesBT/core/modules/siteWebManager/class.Dao.php');
		require_once($_SERVER['DOCUMENT_ROOT'].'/classesBT/core/modules/siteWebManager/class.DBFactory.php');
		require_once($_SERVER['DOCUMENT_ROOT'].'/classesBT/core/modules/siteWebManager/class.Menu.php');
		require_once($_SERVER['DOCUMENT_ROOT'].'/classesBT/core/modules/siteWebManager/class.MenuDAO.php');
		require_once($_SERVER['DOCUMENT_ROOT'].'/classesBT/core/modules/siteWebManager/class.Content.php');
		require_once($_SERVER['DOCUMENT_ROOT'].'/classesBT/core/modules/siteWebManager/class.ContentDAO.php');
		require_once($_SERVER['DOCUMENT_ROOT'].'/classesBT/core/modules/siteWebManager/class.Module.php');
		require_once($_SERVER['DOCUMENT_ROOT'].'/classesBT/core/modules/siteWebManager/class.ModuleDAO.php');

	}
}



class Debug {

	const defaultLogUrl='logs/log.txt';

	public function __construct(){}

	/**
	 * Fonction d'�criture dans un fichier d'un string
	 *
	 * @param string $m message � �crire dans le fichier
	 * @param string $file nom du fichier
	 * @param boolean $overwrite indique si on �crase le contenu du fichier
	 */
	public static function F($m,$file=self::defaultLogUrl,$overwrite=false){
		if(is_object($m)){
			$mess = $m->__toString();
		}else if(is_array($m)){
			$mess = print_r($m,true);
		}else if(is_bool($m)){
			$mess = $m?"true":"false";
		}else if($m === null){
			$mess = "null";
		}else{
			$mess = $m;
		}
		$res = self::initFile($file,$overwrite);
		$fileStream = fopen($res[0],$res[1]);
		fwrite($fileStream,$mess.(($mess==="")?"":"\n"));
		fclose($fileStream);
	}

	/**
	 * Fonction d'�criture d'un objet compos� (objet, tableau, etc...)
	 *
	 * @param string $data donn�es � �crire dans le fichier
	 * @param string $file nom du fichier
	 * @param boolean $overwrite indique si on �crase le contenu du fichier
	 */
	public static function Ft($data,$file=self::defaultLogUrl,$overwrite=false){
		if(is_array($data) || is_object($data)){
			$mess = print_r($data,true);
			self::F($mess,$file,$overwrite);
		}
		else{
			self::F($data,$file,$overwrite);
		}
	}

	/**
	 * Efface le fichier pass� en param�tre
	 *
	 * @param string $file fichier � effacer
	 */
	public static function clear($file=self::defaultLogUrl) {
		self::F("", $file, true);
	}

	/**
	 * Affiche la pile d'appel
	 * @param string $mess
	 * @param string $file
	 * @param string $overwrite
	 */
	public static function D($mess="",$file=self::defaultLogUrl,$overwrite=false){
		$d = debug_backtrace();
		$str = $mess;
		for($i=0;$i<count($d);$i++){
			$str .= "#$i ".$d[$i]["function"]."() called at [".$d[$i]["file"].":".$d[$i]["line"]."]\r\n";
		}
		$str .= "\n";
		self::F($str,$file,$overwrite);
	}

	private static function initFile($file,$overwrite){
		$racine = $_SERVER["DOCUMENT_ROOT"];
		$racine .= "/";
		$racine .= $file;
		if($overwrite) $mode = "w";
		else $mode = "a";

		return array($racine,$mode);
	}

	
}
?>