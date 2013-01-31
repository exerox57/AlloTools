<?php 

class Module {
	
	private $id,
			$title,
			$position,
			$module,
			$params
	;
	
	public function __construct(array $valeurs) {

		foreach ($valeurs as $key => $value) {
			$setter1 = ucfirst($key);
			$setter2 = explode('_', $setter1);
			$setter = '';
			foreach($setter2 as $s) {
				$setter .= ucfirst($s);
			}
			$setter = 'set'. $setter;
		
			if (method_exists($this, $setter))
				$this->$setter($value);
		}
	}
		
	//ID
	public function getId() {
		return $this->id;
	}
	public function setId($id) {
			$this->id = $id;
	}
	//TITLE
	public function getTitle() {
		return $this->title;
	}
	public function setTitle($Title) {
			$this->title = $Title;
	}
	//POSITION
	public function getPosition() {
		return $this->position;
	}
	public function setPosition($pos) {
			$this->position = $pos;
	}
	//MODULE
	public function getModule() {
		return $this->module;
	}
	public function setModule($mod) {
			$this->module = $mod;
	}
	//PARAMS
	public function getParams() {
		return $this->params;
	}
	public function setParams($par) {
			$this->params = $par;
	}
	

}
?>